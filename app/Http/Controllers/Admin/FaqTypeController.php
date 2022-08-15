<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\FaqType;
use App\Models\FaqTypeTranslation;
use Illuminate\Support\Facades\Validator;
use App\Traits\ActiveInactiveTrait;

class FaqTypeController extends Controller
{
    use ActiveInactiveTrait;


    public function index()
    {
        $faq_types = FaqType::with('faqTypeTranslation','faqTypeTranslationEnglish')
                        ->orderBy('is_active','DESC')
                        ->orderBy('id','DESC')
                        ->get();

        if (request()->ajax())
        {
            return datatables()->of($faq_types)
            ->setRowId(function ($row){
                return $row->id;
            })
            ->addColumn('type_name', function ($row)
            {
                return $row->faqTypeTranslation->type_name ?? $row->faqTypeTranslationEnglish->type_name ?? null;
            })
            ->addColumn('action', function ($row)
            {
                $actionBtn = "";
                $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                            &nbsp; ';
                if ($row->is_active==1) {
                    $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-warning btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-down"></i></button>';
                }else {
                    $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-up"></i></button>';
                }
                $actionBtn .= '<button type="button" title="Delete" class="delete btn btn-danger btn-sm ml-2" title="Delete" data-id="'.$row->id.'"><i class="dripicons-trash"></i></button>
                    &nbsp; ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.pages.faq.faq_type.index');
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            $validator = Validator::make($request->only('type_name'),[
                'type_name'  => 'required|unique:faq_type_translations,type_name',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $faq_type = FaqType::create([
                'is_active' => $request->input('is_active',0)
            ]);

            FaqTypeTranslation::create([
                'faq_type_id'=> $faq_type->id,
                'locale'=> Session::get('currentLocal'),
                'type_name'=> $request->type_name,
            ]);

            return response()->json(['success' => 'Data added Succcessfully']);
        }
    }

    public function edit(Request $request)
    {
        $faq_type = FaqType::find($request->faq_type_id);
        $faqTypeTranslation = FaqTypeTranslation::where('faq_type_id',$request->faq_type_id)->where('locale',Session::get('currentLocal'))->first();
        if (!isset($faqTypeTranslation)) {
            $faqTypeTranslation = FaqTypeTranslation::where('faq_type_id',$request->faq_type_id)->where('locale','en')->first();
        }
        return response()->json(['faq_type'=>$faq_type,'faqTypeTranslation'=>$faqTypeTranslation]);
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $validator = Validator::make($request->only('type_name'),[
                'type_name'  => 'required|unique:faq_type_translations,type_name,'.$request->faq_type_id,
            ]);
            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $faq_type = FaqType::find($request->faq_type_id);
            if ($request->is_active==1) {
                $faq_type->is_active = 1;
            }else {
                $faq_type->is_active = 0;
            }
            $faq_type->update();

            FaqTypeTranslation::updateOrCreate(
                ['faq_type_id'  => $request->faq_type_id, 'locale' => Session::get('currentLocal'),],
                ['type_name'=> $request->type_name]
            );

            return response()->json(['success' => 'Data Updated Succcessfully']);
        }
    }

    public function active(Request $request){
        if ($request->ajax()){
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            return $this->activeData(FaqType::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            return $this->inactiveData(FaqType::find($request->id));
        }
    }

    public function delete(Request $request){
        if ($request->ajax()){
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            FaqType::find($request->id)->delete();
            FaqTypeTranslation::where('faq_type_id',$request->id)->delete();

            return response()->json(['success' => 'Data Deleted Succcessfully']);
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            return $this->bulkActionData($request->action_type, FaqType::whereIn('id',$request->idsArray));
        }
    }

}
