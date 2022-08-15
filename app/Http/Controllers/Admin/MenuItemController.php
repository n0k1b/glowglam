<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\MenuItemTranslation;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Traits\ActiveInactiveTrait;

class MenuItemController extends Controller
{
    use ActiveInactiveTrait;

    public function index($menuId)
    {
        return view('admin.pages.menu.menu_item.index',compact('menuId'));
    }

    public function dataFetchByType(Request $request)
    {
        if ($request->ajax()) {

            $locale = Session::get('currentLocal');
            $categories = Category::with(['categoryTranslation'=> function ($query) use ($locale){
                $query->where('local',$locale)
                ->orWhere('local','en')
                ->orderBy('id','DESC');
            }])
            ->where('is_active',1)
            ->get();

            $pages = Page::with(['pageTranslations'=> function ($query) use ($locale){
                $query->where('locale',$locale)
                ->orWhere('locale','en')
                ->orderBy('id','DESC');
            }])
            ->where('is_active',1)
            ->get();

            if ($request->type=='category') {
                return view('admin.includes.dependancy.dependancy_category',compact('categories','locale'));
            }
            elseif ($request->type=='page') {
                return view('admin.includes.dependancy.dependancy_page',compact('pages','locale'));
            }
            elseif ($request->type=='url') {
                return view('admin.includes.dependancy.dependancy_url');
            }
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(),[
                'menu_item_name' => 'required|unique:menu_item_translations,menu_item_name',
                'type' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $locale = Session::get('currentLocal');

            if (auth()->user()->can('menu_item-store'))
            {
                $menu_item = new MenuItem();
                $menu_item->menu_id     = $request->menu_id;
                $menu_item->type        = $request->type; //htmlsplashcaracter
                $menu_item->category_id = $request->category_id;
                $menu_item->page_id     = $request->page_id;
                $menu_item->url         = $request->url;
                $menu_item->icon        = $request->icon;
                $menu_item->target      = $request->target;
                $menu_item->parent_id   = $request->parent_id;
                $menu_item->is_fluid    = $request->is_fluid ?? 0;
                $menu_item->is_active   = $request->is_active ?? 0;
                $menu_item->save();

                $menuItemTranslation  = new MenuItemTranslation();
                $menuItemTranslation->menu_item_id = $menu_item->id;
                $menuItemTranslation->locale  = $locale;
                $menuItemTranslation->menu_item_name = $request->menu_item_name;
                $menuItemTranslation->save();

                return response()->json(['success' => '<p><b>Data Saved Successfully.</b></p>']);
            }
        }
    }


    public function edit(Request $request)
    {
        $locale = Session::get('currentLocal');

        $menu_item = MenuItem::find($request->menu_item_id);

        $menuItemTranslation = MenuItemTranslation::where('menu_item_id',$request->menu_item_id)->where('locale',$locale)->first();
        $menu_item_name = $menuItemTranslation->menu_item_name;
        if (!$menu_item_name) {
            $menuItemTranslation = MenuItemTranslation::where('menu_item_id',$request->menu_item_id)->where('locale','en')->first();
            $menu_item_name = $menuItemTranslation->menu_item_name ?? '';
        }

        return response()->json(['menu_item_name'=>$menu_item_name, 'menu_item' => $menu_item, 'menu_item_translation_id'=>$menuItemTranslation->id]);
    }

    public function update(Request $request)
    {
        if (auth()->user()->can('menu_item-edit'))
        {
            if ($request->ajax()) {

                $validator = Validator::make($request->all(),[
                    'menu_item_name' => 'required|unique:menu_item_translations,menu_item_name,'.$request->menu_item_translation_id,
                ]);

                if ($validator->fails()){
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $locale = Session::get('currentLocal');

                $menu_item = MenuItem::find($request->menu_item_id);
                $menu_item->type        = $request->type;
                $menu_item->icon        = $request->icon;
                $menu_item->target      = $request->target;
                $menu_item->parent_id   = $request->parent_id;
                $menu_item->is_fluid    = $request->is_fluid ?? 0;
                $menu_item->is_active   = $request->is_active ?? 0;

                if ($request->type=='category') {
                    $menu_item->category_id = $request->category_id;
                    $menu_item->page_id = NULL;
                    $menu_item->url = NULL;
                }
                else if ($request->type=='page') {
                    $menu_item->page_id = $request->page_id;
                    $menu_item->category_id = NULL;
                    $menu_item->url = NULL;
                }else{
                    $menu_item->url         = $request->url;
                    $menu_item->category_id = NULL;
                    $menu_item->page_id = NULL;
                }
                $menu_item->save();

                MenuItemTranslation::UpdateOrCreate(
                    ['menu_item_id'=>$menu_item->id, 'locale' => $locale],
                    ['menu_item_name'=>$request->menu_item_name],
                );

                return response()->json(['success' => '<p><b>Data Updated Successfully.</b></p>']);
            }
        }
    }

    public function active(Request $request){
        if ($request->ajax()){
            return $this->activeData(MenuItem::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            return $this->inactiveData(MenuItem::find($request->id));
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {
            return $this->bulkActionData($request->action_type, MenuItem::whereIn('id',$request->idsArray));
        }
    }
}
