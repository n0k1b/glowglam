<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ActiveInactiveTrait;
use App\Traits\SlugTrait;
use Harimayco\Menu\Facades\Menu;
use Illuminate\Support\Facades\Session;
use Harimayco\Menu\Models\Menus;
use Illuminate\Support\Facades\App;

class MenuController extends Controller
{
    use ActiveInactiveTrait, SlugTrait;


    public function index(Request $request)
    {
        if (auth()->user()->can('menu-view'))
        {
            App::setLocale(Session::get('currentLocal'));

            $locale = Session::get('currentLocal');

            $menus = Menus::with(['menuTranslations'=> function ($query) use ($locale){
                $query->where('locale',$locale)
                ->orWhere('locale','en')
                ->orderBy('id','DESC');
            }])
            ->orderBy('is_active','DESC')
            ->orderBy('id','DESC')
            ->get();

            $currentUrl = url()->current();

            if ($request->ajax())
            {
                return DataTables::of($menus)
                ->setRowId(function ($row)
                {
                    return $row->id;
                })
                ->addColumn('menu_name', function ($row) use ($locale)
                {
                    if ($row->menuTranslations->isNotEmpty()){
                        foreach ($row->menuTranslations as $key => $value){
                            if ($key<1){
                                if ($value->locale==$locale){
                                    return $value->menu_name;
                                }elseif($value->locale=='en'){
                                    return $value->menu_name;
                                }
                            }
                        }
                    }else {
                        return "NULL";
                    }
                })
                ->addColumn('action', function($row) use ($currentUrl)
                {
                    $actionBtn = '';
                    if (auth()->user()->can('menu_item-view'))
                    {
                        $actionBtn .= '<a href="'.route('admin.menu.menu_item', $row->id).'?menu='.$row->id.'" class="view btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                        &nbsp;';
                    }
                    if (auth()->user()->can('menu-edit'))
                    {
                        $actionBtn .= '<button type="button" title="Edit" class="edit btn btn-info btn-sm" title="Edit" data-id="'.$row->id.'"><i class="dripicons-pencil"></i></button>
                        &nbsp;';
                    }
                    if (auth()->user()->can('menu-action'))
                    {
                        if ($row->is_active==1) {
                            $actionBtn .= '<button type="button" title="Inactive" class="inactive btn btn-danger btn-sm" data-id="'.$row->id.'"><i class="dripicons-thumbs-down"></i></button>';
                        }else {
                            $actionBtn .= '<button type="button" title="Active" class="active btn btn-success btn-sm" data-id="'.$row->id.'"><i class="dripicons-thumbs-up"></i></button>';
                        }
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }

            return view('admin.pages.menu.index',compact('menus'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('menu-store'))
        {
            if ($request->ajax()) {


                $validator = Validator::make($request->only('menu_name'),[
                    'menu_name' => 'required|unique:menu_translations,menu_name',
                ]);

                if ($validator->fails()){
                    return response()->json(['errors' => $validator->errors()->all()]);
                }


                $locale = Session::get('currentLocal');


                $menu = new Menus();
                $menu->slug =  $this->slug($request->menu_name);
                $menu->is_active =  $request->is_active ?? 0;
                $menu->save();

                $menuTranslation = new MenuTranslation();
                $menuTranslation->menu_id = $menu->id;
                $menuTranslation->locale  = $locale;
                $menuTranslation->menu_name  = $request->menu_name;
                $menuTranslation->save();

                return response()->json(['success' => '<p><b>Data Saved Successfully.</b></p>']);
            }
        }
    }

    public function edit(Request $request)
    {

        $locale = Session::get('currentLocal');
        if ($request->ajax()) {

            $menu = Menus::find($request->menu_id);
            $menuTranslation = MenuTranslation::where('menu_id',$request->menu_id)->where('locale',$locale)->first();

            if (!$menuTranslation) {
                $menuTranslation =  MenuTranslation::where('menu_id',$request->menu_id)->where('locale','en')->first();
            }
            return response()->json(['menu' => $menu, 'menuTranslation'=>$menuTranslation]);
        }
    }

    public function update(Request $request)
    {
        if (auth()->user()->can('menu-edit'))
        {
            $locale = Session::get('currentLocal');
            if ($request->ajax()) {
                $validator = Validator::make($request->only('menu_name'),[
                    'menu_name' => 'required|unique:menu_translations,menu_name,'.$request->menu_translation_id,
                ]);

                if ($validator->fails()){
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $menu = Menus::find($request->menu_id);
                $menu->slug =  $this->slug($request->menu_name);
                $menu->is_active = $request->is_active ?? 0;
                $menu->update();

                MenuTranslation::UpdateOrCreate(
                    ['menu_id'=>$request->menu_id, 'locale' => $locale],
                    ['menu_name' => $request->menu_name]
                );

                return response()->json(['success' => 'Data Updated Successfully.']);
            }
        }

    }

    public function active(Request $request){
        if ($request->ajax()){
            return $this->activeData(Menu::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            return $this->inactiveData(Menu::find($request->id));
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {

            return $this->bulkActionData($request->action_type, Menu::whereIn('id',$request->idsArray));
        }
    }
}
