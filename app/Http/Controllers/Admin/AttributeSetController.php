<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeSet\AttributeSetStoreRequest;
use App\Http\Requests\AttributeSet\AttributeSetUpdateRequest;
use App\Services\AttributeSetService;
use Illuminate\Http\Request;

class AttributeSetController extends Controller
{

    private $attributeSetService;
    public function __construct(AttributeSetService $attributeSetService){
        $this->attributeSetService = $attributeSetService;
    }

    public function index()
    {
        if (auth()->user()->can('attribute_set-view')){
            return view('admin.pages.attribute_set.index');
        }
        return abort('403', __('You are not authorized'));
    }

    public function datatable()
    {
        return $this->attributeSetService->dataTable();
    }

    public function store(AttributeSetStoreRequest $request)
    {
        if (auth()->user()->can('attribute_set-store')){
            return $this->attributeSetService->storeAttributeSet($request);
        }
    }

    public function edit(Request $request)
    {
        $attributeSet             = $this->attributeSetService->findAttributeSet($request->attribute_set_id);
        $attributeSetTranslation  = $this->attributeSetService->findAttributeSetTranslation($request->attribute_set_id);
        return response()->json(['attributeSet'=>$attributeSet, 'attributeSetTranslation'=>$attributeSetTranslation]);
    }

    public function update(AttributeSetUpdateRequest $request)
    {
        if (auth()->user()->can('attribute_set-edit')){
            return $this->attributeSetService->updateAttributeSet($request);
        }
    }

    public function active(Request $request){
        if ($request->ajax()){
            return $this->attributeSetService->activeById($request->id);
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            return $this->attributeSetService->inactiveById($request->id);
        }
    }

    public function bulkAction(Request $request){
        if ($request->ajax()) {
            return $this->attributeSetService->bulkActionByTypeAndIds($request->action_type, $request->idsArray);
        }
    }

    public function destroy(Request $request){
        if ($request->ajax()){
            return $this->attributeSetService->destroy($request->id);
        }
    }
}

// $count = 0;
// DB::listen(function ($attributeSets) use (&$count) {
//     $count++;
// });
// return $count;
