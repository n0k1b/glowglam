<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ActiveInactiveTrait;
use App\Traits\SlugTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class PageController extends Controller
{
    use ActiveInactiveTrait, SlugTrait;

    public function index()
    {
        if (auth()->user()->can('page-view'))
        {
            $locale = Session::get('currentLocal');
            App::setLocale(Session::get('currentLocal'));

            $pages = Page::with(['pageTranslations'=> function ($query) use ($locale){
                $query->where('locale',$locale)
                ->orWhere('locale','en')
                ->orderBy('id','DESC');
            }])
            ->orderBy('is_active','DESC')
            ->orderBy('id','DESC')
            ->get();

            if (request()->ajax())
            {
                return datatables()->of($pages)
                    ->setRowId(function ($row){
                        return $row->id;
                    })
                    ->addColumn('page_name', function ($row) use ($locale)
                    {
                        if ($row->pageTranslations->isNotEmpty()){
                            foreach ($row->pageTranslations as $key => $value){
                                if ($key<1){
                                    if ($value->locale==$locale){
                                        return $value->page_name;
                                    }elseif($value->locale=='en'){
                                        return $value->page_name;
                                    }
                                }
                            }
                        }else {
                            return "NULL";
                        }
                    })
                    ->addColumn('action', function ($row)
                    {
                        $actionBtn = "";
                        $url = url('/');
                        $actionBtn .= '<a target="_blank" title="View" class="btn btn-success btn-sm" href="'.$url.'/page/'.$row->slug.'"><i class="dripicons-preview"></i></a>&nbsp; ';
                        if (auth()->user()->can('page-edit'))
                        {
                            $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                            &nbsp; ';
                        }
                        if (auth()->user()->can('page-action'))
                        {
                            if ($row->is_active==1) {
                                $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-danger btn-sm" data-id="'.$row->id.'"><i class="dripicons-thumbs-down"></i></button>';
                            }else {
                                $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="dripicons-thumbs-up"></i></button>';
                            }
                        }
                        return $actionBtn;
                    })
                    ->addColumn('copy_url', function ($row)
                    {
                        return $row->slug;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.pages.page.index');
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('page-store'))
        {
            if($request->ajax()){

                $validator = Validator::make($request->only('page_name','body'),[
                    'page_name' => 'required|unique:page_translations,page_name',
                    'body' => 'required'
                ]);

                if ($validator->fails()){
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $locale = Session::get('currentLocal');

                $page = new Page();
                $page->slug      = $this->slug(htmlspecialchars_decode($request->page_name));
                $page->is_active = $request->is_active ?? 0;
                $page->save();

                $page_translation = new PageTranslation();
                $page_translation->page_id   = $page->id;
                $page_translation->locale    = $locale;
                $page_translation->page_name = htmlspecialchars_decode($request->page_name);
                $page_translation->body      = $request->body;
                $page_translation->save();

                return response()->json(['success'=>'Data Saved Successfully']);
            }
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $locale = Session::get('currentLocal');

            $page = Page::find($request->page_id);
            $page_translation = PageTranslation::where('page_id',$request->page_id)->where('locale',$locale)->first();
            if (!isset($page_translation)) {
                $page_translation = PageTranslation::where('page_id',$request->page_id)->where('locale','en')->first();
            }
            $page_translation_body = htmlspecialchars_decode($page_translation->body);
        }
        return response()->json(['page'=> $page, 'page_translation' => $page_translation, 'page_translation_body'=> $page_translation_body]);
    }

    public function update(Request $request)
    {

        if (auth()->user()->can('page-edit'))
        {
            $locale = Session::get('currentLocal');
            if($request->ajax()){

                $validator = Validator::make($request->only('page_name','body'),[
                    'page_name' => 'required|unique:page_translations,page_name,'.$request->page_translation_id,
                    'body'=> 'required'
                ]);

                if ($validator->fails())
                {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $page = Page::find($request->page_id);
                if ($locale=='en') {
                    $page->slug      = $this->slug(htmlspecialchars_decode($request->page_name));
                }
                $page->is_active = $request->is_active ?? 0;
                $page->update();

                PageTranslation::UpdateOrCreate(
                    [ 'page_id'   => $request->page_id,  'locale' => $locale ],
                    [ 'page_name' => htmlspecialchars_decode($request->page_name), 'body' => $request->body]);

                return response()->json(['success'=>'Data updated Successfully']);
            }
        }
    }

    public function active(Request $request){
        if ($request->ajax()){
            return $this->activeData(Page::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            return $this->inactiveData(Page::find($request->id));
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {
            return $this->bulkActionData($request->action_type, Page::whereIn('id',$request->idsArray));
        }
    }
}
