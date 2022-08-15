<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\TagTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Traits\ActiveInactiveTrait;
use App\Traits\SlugTrait;
use Illuminate\Support\Facades\App;

class TagController extends Controller
{
    use ActiveInactiveTrait, SlugTrait;

    public function index()
    {
        if (auth()->user()->can('tag-view'))
        {
            $local = Session::get('currentLocal');
            App::setLocale($local);

            $tags = Tag::with(['tagTranslation'=> function ($query) use ($local){
                $query->where('local',$local)
                ->orWhere('local','en')
                ->orderBy('id','DESC');
            }])
            ->orderBy('is_active','DESC')
            ->orderBy('id','DESC')
            ->get();

            if (request()->ajax())
            {
                return datatables()->of($tags)
                ->setRowId(function ($row){
                    return $row->id;
                })
                ->addColumn('tag_name', function ($row) use ($local)
                {
                    if ($row->tagTranslation->count()>0){
                        foreach ($row->tagTranslation as $key => $value){
                            if ($key<1){
                                if ($value->local==$local){
                                    return $value->tag_name;
                                }elseif($value->local=='en'){
                                    return $value->tag_name;
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
                    if (auth()->user()->can('tag-edit'))
                    {
                        $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                        &nbsp; ';
                    }
                    if (auth()->user()->can('tag-action'))
                    {
                        if ($row->is_active==1) {
                            $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-danger btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-down"></i></button>';
                        }else {
                            $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="fa fa-thumbs-up"></i></button>';
                        }
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            return view('admin.pages.tag.index');
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->only('tag_name'),[
            'tag_name'  => 'required|unique:tag_translations,tag_name',
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if (auth()->user()->can('tag-store'))
        {
            if ($request->ajax())
            {
                if (env('USER_VERIFIED')!=1) {
                    return response()->json(['errors' => ['Disabled for demo !']]);
                }

                $tag = new Tag();
                $tag->slug  = $this->slug($request->tag_name);
                if ($request->is_active==1) {
                    $tag->is_active = 1;
                }else {
                    $tag->is_active = 0;
                }
                $tag->save();

                $tagTranslation = new TagTranslation();
                $tagTranslation->tag_id   = $tag->id;
                $tagTranslation->local    = Session::get('currentLocal');
                $tagTranslation->tag_name = $request->tag_name;
                $tagTranslation->save();

                return response()->json(['success' => 'Data Saved Successfully']);
            }
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $tag = Tag::find($request->tag_id);
            $tag_translation = TagTranslation::where('tag_id',$request->tag_id)->where('local',session('currentLocal'))->first();
            if (!isset($tag_translation)) {
                $tag_translation = TagTranslation::where('tag_id',$request->tag_id)->where('local','en')->first();
            }
            return response()->json(['tag' => $tag , 'tag_translation' => $tag_translation]);
        }

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->only('tag_name'),[
            'tag_name'  => 'required|unique:tag_translations,tag_name,'.$request->tag_translation_id,
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if (auth()->user()->can('tag-edit'))
        {
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['errors' => ['Disabled for demo !']]);
            }

            $tag = Tag::find($request->tag_id);
            $tag->slug  = $this->slug($request->tag_name);
            if ($request->is_active==1) {
                $tag->is_active = 1;
            }else {
                $tag->is_active = 0;
            }
            $tag->update();

            DB::table('tag_translations')
            ->updateOrInsert(
                [
                    'tag_id'  => $request->tag_id,
                    'local'   => Session::get('currentLocal'),
                ],
                [
                    'tag_name' => $request->tag_name,
                ]
            );

            return response()->json(['success' => 'Data Updated Successfully']);
        }
    }


    public function active(Request $request){
        if ($request->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['errors' => ['Disabled for demo !']]);
            }
            return $this->activeData(Tag::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            if (env('USER_VERIFIED')!=1) {
                return response()->json(['errors' => ['Disabled for demo !']]);
            }
            return $this->inactiveData(Tag::find($request->id));
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {
            return $this->bulkActionData($request->action_type, Tag::whereIn('id',$request->idsArray));
        }
    }
}
