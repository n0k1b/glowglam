<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Tax;
use App\Models\TaxTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Traits\ActiveInactiveTrait;
use Illuminate\Support\Facades\App;

class TaxController extends Controller
{
    use ActiveInactiveTrait;

    public function index()
    {
        $countries = Country::all();
        $locale = Session::get('currentLocal');
        // App::setLocale($locale);

        $taxes = Tax::with('taxTranslation','taxTranslationDefaultEnglish')
                ->where('is_active',1)
                ->orderBy('is_active','DESC')
                ->orderBy('id','ASC')
                ->get();

        if (request()->ajax())
        {
            return datatables()->of($taxes)
            ->setRowId(function ($row){
                return $row->id;
            })
            ->addColumn('tax_name', function ($row)
            {
                return $row->taxTranslation->tax_name ?? $row->taxTranslationDefaultEnglish->tax_name ?? null;
            })
            ->addColumn('action', function ($row)
            {
                $actionBtn = "";
                    $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                    &nbsp; ';

                    if ($row->is_active==1) {
                        $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-danger btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-down"></i></button>';
                    }else {
                        $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-up"></i></button>';
                    }
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.pages.tax.index',compact('countries'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only('tax_name','based_on','country','tax_class'),[
            'tax_class'  => 'required',
            'based_on'  => 'required',
            'country'  => 'required',
            'tax_name'  => 'required|unique:tax_translations,tax_name',
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if ($request->ajax())
        {
            $tax = [];
            $tax['country']  = $request->country;
            $tax['zip']      = $request->zip;
            $tax['rate']     = $request->rate;
            $tax['based_on'] = $request->based_on;
            $tax['is_active']= $request->is_active;

            $data = Tax::create($tax);

            $taxTranslation  = [];
            $taxTranslation['tax_id']   = $data->id;
            $taxTranslation['locale']   = Session::get('currentLocal');
            $taxTranslation['tax_class']= $request->tax_class;
            $taxTranslation['tax_name'] = $request->tax_name;
            $taxTranslation['state']    = $request->state;
            $taxTranslation['city']     = $request->city;

            TaxTranslation::create($taxTranslation);

            return response()->json(['success' => 'Data Saved Successfully']);
        }
    }

    public function edit(Request $request)
    {
        $locale = Session::get('currentLocal');
        $tax = Tax::find($request->tax_id);
        $taxTranslation = TaxTranslation::where('tax_id',$request->tax_id)->where('locale',$locale)->first();

        if (!isset($taxTranslation)) {
            $taxTranslation = TaxTranslation::where('tax_id',$request->tax_id)->where('locale','en')->first();
        }
        return response()->json(['tax' => $tax, 'taxTranslation'=>$taxTranslation]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->only('tax_name','based_on','country','tax_class'),[
            'tax_class'  => 'required',
            'based_on'  => 'required',
            'country'  => 'required',
            'tax_name'  => 'required|unique:tax_translations,tax_name,'.$request->tax_translation_id,
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if ($request->ajax())
        {
            $tax = [];
            $tax['country']  = $request->country;
            $tax['zip']      = $request->zip;
            $tax['rate']     = $request->rate;
            $tax['based_on'] = $request->based_on;
            $tax['is_active']= $request->is_active;

            DB::beginTransaction();
            try {
                Tax::find($request->tax_id)->update($tax);

                TaxTranslation::UpdateOrCreate(
                    [
                        'tax_id' => $request->tax_id,
                        'locale' => Session::get('currentLocal')
                    ],
                    [
                        'tax_class' => $request->tax_class,
                        'tax_name'  => $request->tax_name,
                        'state'     => $request->state,
                        'city'      => $request->city,
                    ],
                );

                DB::commit();
            }
            catch (Exception $e)
            {
                DB::rollback();

                return response()->json(['error' => $e->getMessage()]);
            }

            return response()->json(['success' => 'Data Updated Successfully']);
        }
    }


    public function active(Request $request){
        if ($request->ajax()){
            return $this->activeData(Tax::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            return $this->inactiveData(Tax::find($request->id));
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {
            return $this->bulkActionData($request->action_type, Tax::whereIn('id',$request->idsArray));
        }
    }
}
