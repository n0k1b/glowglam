<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqType;
use App\Models\Faq;
use App\Models\FaqTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Traits\ActiveInactiveTrait;

class FAQController extends Controller
{
    use ActiveInactiveTrait;

    public function index()
    {
        $faq_types = FaqType::with('faqTypeTranslation','faqTypeTranslationEnglish')
                    ->orderBy('is_active','DESC')
                    ->orderBy('id','DESC')
                    ->get();

        $faq =  Faq::with('faqTranslation','faqTranslationEnglish','faqType:id,type_name')
                    ->orderBy('is_active','DESC')
                    ->orderBy('id','DESC')
                    ->get();

        if (request()->ajax())
        {
            return datatables()->of($faq)
            ->setRowId(function ($row){
                return $row->id;
            })
            ->addColumn('type', function ($row)
            {
                return $row->faqType->type_name ?? $row->faqType->type_name ?? null;
            })
            ->addColumn('title', function ($row)
            {
                return $row->faqTranslation->title ?? $row->faqTranslationEnglish->title ?? null;
            })
            ->addColumn('description', function ($row)
            {
                $string    = $row->faqTranslation->description ?? $row->faqTranslationEnglish->description ?? null;
                $wordCount = strlen($string);
                if($wordCount>25){
                    $data = substr($string, 0, 25).'...';
                }else {
                    $data = $string;
                }
                return $data;
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

        return view('admin.pages.faq.index',compact('faq_types'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->only('faq_type_id','title','description'),[
                'title'  => 'required|unique:faq_translations,title',
                'description'  => 'required',
                'faq_type_id'  => 'required',
            ]);
            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $data = [];
            $data['faq_type_id'] = $request->faq_type_id;
            $data['is_active']   = $request->input('is_active', 0);
            $faq  = Faq::create($data);

            $data['faq_id'] = $faq->id;
            $data['locale'] = Session::get('currentLocal');
            $data['title']  = $request->title;
            $data['description'] = $request->description;
            FaqTranslation::create($data);

            return response()->json(['success' => 'Data Added Succcessfully']);
        }
    }

    public function edit(Request $request)
    {
        $faq = Faq::find($request->faq_id);
        $faqTranslation = FaqTranslation::where('faq_id',$request->faq_id)->where('locale',Session::get('currentLocal'))->first();
        if (!isset($faqTranslation)) {
            $faqTranslation = FaqTranslation::where('faq_id',$request->faq_id)->where('locale','en')->first();
        }
        return response()->json(['faq' => $faq,'faqTranslation'=>$faqTranslation]);
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'title'  => 'required|unique:faq_translations,title,'.$request->faq_translation_id,
                'description'  => 'required',
                'faq_type_id'  => 'required',
            ]);
            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }

            $data = [];
            $data['faq_type_id'] = $request->faq_type_id;
            $data['is_active']   = $request->input('is_active', 0);
            Faq::whereId($request->faq_id)->update($data);

            FaqTranslation::updateOrCreate(
                [
                    'faq_id'  => $request->faq_id,
                    'locale' => Session::get('currentLocal'),
                ],
                [
                    'title'=> $request->title,
                    'description'=> $request->description,
                ]
            );

            return response()->json(['success' => 'Data Updated Succcessfully']);
        }
    }

    public function active(Request $request){
        if ($request->ajax()){
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            return $this->activeData(Faq::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            return $this->inactiveData(Faq::find($request->id));
        }
    }

    public function delete(Request $request){
        if ($request->ajax()){
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            Faq::find($request->id)->delete();
            FaqTranslation::where('faq_id',$request->id)->delete();
            return response()->json(['success' => 'Data Deleted Succcessfully']);
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {
            if (!env('USER_VERIFIED')) {
                return response()->json(['errors'=>['This is disabled for demo']]);
            }
            return $this->bulkActionData($request->action_type, Faq::whereIn('id',$request->idsArray));
        }
    }
}
