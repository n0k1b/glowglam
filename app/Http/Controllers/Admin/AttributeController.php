<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeTranslation;
use App\Models\AttributeSet;
use App\Models\AttributeValue;
use App\Models\AttributeValueTranslation;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Traits\ActiveInactiveTrait;
use App\Traits\SlugTrait;
use Illuminate\Support\Facades\App;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AttributeController extends Controller
{
    use ActiveInactiveTrait, SlugTrait;

    public function index()
    {
        if (auth()->user()->can('attribute-view'))
        {
            $local = Session::get('currentLocal');
            App::setLocale($local);
            $tr    = new GoogleTranslate($local);

            $attributes = Attribute::with('attributeTranslation','attributeTranslationEnglish',
                                    'attributeSetTranslation','attributeSetTranslationEnglish')
                                    ->orderBy('is_active','DESC')
                                    ->orderBy('id','DESC')
                                    ->get();

            if (request()->ajax())
            {
                return datatables()->of($attributes)
                    ->setRowId(function ($row){
                        return $row->id;
                    })
                    ->addColumn('attribute_name', function ($row) use ($local)
                    {
                        return $row->attributeTranslation->attribute_name ?? $row->attributeTranslationEnglish->attribute_name ?? null;
                    })
                    ->addColumn('attribute_set_name', function ($row) use ($local)
                    {
                        return $row->attributeSetTranslation->attribute_set_name ?? $row->attributeSetTranslationEnglish->attribute_set_name ?? null;
                    })
                    ->addColumn('is_filterable', function ($row){
                        if ($row->is_filterable==1) {
                            return "YES";
                        }else {
                            return "NO";
                        }
                    })
                    ->addColumn('action', function ($row)
                    {
                        $actionBtn = "";
                        if (auth()->user()->can('attribute-edit'))
                        {
                            $actionBtn .= '<a href="'.route('admin.attribute.edit', $row->id) .'" class="edit btn btn-primary btn-sm" title="Edit"><i class="dripicons-pencil"></i></a>
                                        &nbsp; ';
                        }
                        if (auth()->user()->can('attribute-action'))
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
            return view('admin.pages.attribute.index',compact('attributes','local','tr'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function create()
    {
        $local = Session::get('currentLocal');
        App::setLocale($local);

        $attributeSets = AttributeSet::with('attributeSetTranslation','attributeSetTranslationEnglish')
                        ->where('is_active',1)
                        ->orderBy('is_active','DESC')
                        ->orderBy('id','DESC')
                        ->get();

        $categories = Category::with(['categoryTranslation'=> function ($query) use ($local){
            $query->where('local',$local)
            ->orWhere('local','en')
            ->orderBy('id','DESC');
        },
        'parentCategory'
        ])
        ->get();

        return view('admin.pages.attribute.create',compact('local','attributeSets','categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only('attribute_set_id','attribute_name'),[
            'attribute_set_id'=> 'required',
            'attribute_name'  => 'required|unique:attribute_translations',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (auth()->user()->can('attribute-store'))
        {
            $attribute = new Attribute();
            $attribute->attribute_set_id = $request->attribute_set_id;
            $attribute->slug             = $this->slug($request->attribute_name);

            if ($request->is_filterable==1) {
                $attribute->is_filterable = 1;
            }else {
                $attribute->is_filterable = 0;
            }

            if ($request->is_active==1) {
                $attribute->is_active = 1;
            }else {
                $attribute->is_active = 0;
            }
            $attribute->save();

            $attributeTranslation = new AttributeTranslation();
            $attributeTranslation->attribute_id = $attribute->id;
            $attributeTranslation->locale        = Session::get('currentLocal');
            $attributeTranslation->attribute_name = $request->attribute_name;
            $attributeTranslation->save();

            //----------------- Attribute-Category Sync --------------
            if (!empty($request->category_id)) {
                $categoryArrayIds = $request->category_id;
                $attribute->categories()->sync($categoryArrayIds);
            }
            //-----------------/ Attribute-Category Sync ----------------------



            //-------- Attribute-Value ----------

            $attributeValueNameArray= $request->value_name;

            if(array_filter($attributeValueNameArray) != []){ //if value_empty it show  [null] when use return, checking that way.

                $attributeValueArray = $request->value_name;
                foreach ($attributeValueArray as $key => $value) {
                    $attributeValue = new AttributeValue();
                    $attributeValue->attribute_id = $attribute->id;
                    $attributeValue->save();

                    $attributeValueTranslation = new AttributeValueTranslation();
                    $attributeValueTranslation->attribute_id = $attribute->id;
                    $attributeValueTranslation->attribute_value_id = $attributeValue->id;
                    $attributeValueTranslation->local        = Session::get('currentLocal');
                    $attributeValueTranslation->value_name   = $attributeValueArray[$key];
                    $attributeValueTranslation->save();
                }
            }
            //--------/ Attribute-Value ----------

            session()->flash('type','success');
            session()->flash('message','Data Saved Successfully.');

            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $local = Session::get('currentLocal');
        App::setLocale($local);

        $attribute                 = Attribute::with('categories')->where('id',$id)->first();
        $attributeTranslation      = AttributeTranslation::where('attribute_id',$id)->where('locale',Session::get('currentLocal'))->first();
        if (!isset($attributeTranslation)) {
            $attributeTranslation = AttributeTranslation::where('attribute_id',$id)->where('locale','en')->first();
        }

        //-------- Value ---------
        $attributeValue = AttributeValue::where('attribute_id',$id)->pluck('id'); //show- attribute_values.id as [2,3,4,5]

        $attributeValueTranslation = AttributeValueTranslation::whereIn('attribute_value_id',$attributeValue)
                                                                ->where('local',$local)
                                                                ->get();

        if (count($attributeValueTranslation)==0) {
            $attributeValueTranslation = AttributeValueTranslation::whereIn('attribute_value_id',$attributeValue)->where('local','en')->get();
        }
        //-------- Value ---------


        $attributeSets = AttributeSet::with('attributeSetTranslation','attributeSetTranslationEnglish')
                                    ->where('is_active',1)
                                    ->orderBy('is_active','DESC')
                                    ->orderBy('id','DESC')
                                    ->get();

        $categories = Category::with(['categoryTranslation'=> function ($query) use ($local){
            $query->where('local',$local)
            ->orWhere('local','en')
            ->orderBy('id','DESC');
        },
        'parentCategory'
        ])
        ->get();

        return view('admin.pages.attribute.edit',compact('attribute','attributeTranslation','attributeValueTranslation','local','attributeSets','categories'));
    }

    public function update(Request $request, $id)
    {
        $local = Session::get('currentLocal');

        $validator = Validator::make($request->only('attribute_name'),[
            'attribute_name'  => 'required|unique:attribute_translations,attribute_name,'.$request->attribute_translation_id,
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (auth()->user()->can('attribute-edit'))
        {
            $attribute = Attribute::find($id);
            $attribute->slug             = $this->slug($request->attribute_name);
            $attribute->attribute_set_id = $request->attribute_set_id;
            if ($request->is_filterable==1) {
                $attribute->is_filterable = 1;
            }else {
                $attribute->is_filterable = 0;
            }

            if ($request->is_active==1) {
                $attribute->is_active = 1;
            }else {
                $attribute->is_active = 0;
            }
            $attribute->update();

            DB::table('attribute_translations')
            ->updateOrInsert(
                [
                    'attribute_id'  => $id,
                    'locale'         => $local,
                ],
                [
                    'attribute_name' => $request->attribute_name,
                ]
            );


            //----------------- Attribute-Category Sync --------------
            if (!empty($request->category_id)) {
                $categoryArrayIds = $request->category_id;
                $attribute->categories()->sync($categoryArrayIds);
            }
            //-----------------/ Attribute-Category Sync ----------------------


            //--------- Value Part--------
            $attributeValueNameArray = $request->value_name;
            $attributeValueIdArray   = $request->attribute_value_id;

            if (empty($attributeValueNameArray)) {
                AttributeValue::where('attribute_id',$id)->delete();
            }

            if (isset($attributeValueNameArray) && isset($attributeValueIdArray)) {

                AttributeValue::where('attribute_id',$id)->whereNotIn('id',$attributeValueIdArray)->delete();

                foreach ($attributeValueNameArray as $key => $value) {
                    DB::table('attribute_value_translations')
                    ->updateOrInsert(
                        [
                            'attribute_id'  => $id,
                            'attribute_value_id'  => $attributeValueIdArray[$key],
                            'local'               => $local,
                        ],
                        [
                            'value_name' => $attributeValueNameArray[$key],
                        ]
                    );
                }
            }

            if(isset($request->add_more_value_name)) {
                $attributeValueNameArray = $request->add_more_value_name;
                foreach ($attributeValueNameArray as $key => $value) {
                    $attributeValue = new AttributeValue();
                    $attributeValue->attribute_id =  $id;
                    $attributeValue->save();

                    $attributeValueTranslation  = new AttributeValueTranslation();
                    $attributeValueTranslation->attribute_id       = $attribute->id;
                    $attributeValueTranslation->attribute_value_id = $attributeValue->id;
                    $attributeValueTranslation->local              = $local;
                    $attributeValueTranslation->value_name         = $attributeValueNameArray[$key];
                    $attributeValueTranslation->save();
                }
            }

            //--------- Value Part--------

            session()->flash('type','success');
            session()->flash('message','Successfully Updated');
            return redirect()->back();
        }
    }

    public function active(Request $request){
        if ($request->ajax()){
            return $this->activeData(Attribute::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            return $this->inactiveData(Attribute::find($request->id));
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {
            return $this->bulkActionData($request->action_type, Attribute::whereIn('id',$request->idsArray));
        }
    }


    public function getAttributeValues(Request $request)
    {
        $attribute = Attribute::find($request->attribute_id);

        if (isset($attribute->attributeValue)) {
            $attributeValueTranslation = AttributeValueTranslation::where('attribute_id',$request->attribute_id)->where('local',Session::get('currentLocal'))->get();
        }else {
            $attributeValueTranslation = NULL;
        }


        $output = '';
		foreach ($attributeValueTranslation as $row)
		{
			$output .= '<option value=' . $row->attribute_value_id . '>' . $row->value_name . '</option>';
		}

        return response()->json($output);
    }
}
