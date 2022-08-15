<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponTranslation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ActiveInactiveTrait;
use App\Traits\SlugTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\App;

class CouponController extends Controller
{
    use ActiveInactiveTrait, SlugTrait;

    public function index()
    {
        if (auth()->user()->can('coupon-view'))
        {
            $locale = Session::get('currentLocal');
            App::setLocale($locale);

            $coupons = Coupon::with(['couponTranslations'=> function ($query) use ($locale){
                $query->where('locale',$locale)
                ->orWhere('locale','en')
                ->orderBy('id','DESC');
            }])
            ->orderBy('is_active','DESC')
            ->orderBy('id','DESC')
            ->get();

            if (request()->ajax())
            {
                return datatables()->of($coupons)
                ->setRowId(function ($row){
                    return $row->id;
                })
                ->addColumn('coupon_name', function ($row) use ($locale)
                {
                    if ($row->couponTranslations->count()>0){
                        foreach ($row->couponTranslations as $key => $value){
                            if ($key<1){
                                if ($value->locale==$locale){
                                    return $value->coupon_name;
                                }elseif($value->locale=='en'){
                                    return $value->coupon_name;
                                }
                            }
                        }
                    }else {
                        return "NULL";
                    }
                })
                ->addColumn('discount', function ($row)
                {
                    if ($row->discount_type=='fixed') {
                        return '$ '.number_format((float)$row->value, env('FORMAT_NUMBER'), '.', ''); //Currency need to change later

                    }else {
                        return number_format((float)$row->value, env('FORMAT_NUMBER'), '.', '').' %';
                    }
                })
                ->addColumn('action', function ($row)
                {
                    $actionBtn = "";
                    if (auth()->user()->can('coupon-edit'))
                    {
                        $actionBtn .= '<a href="'.route('admin.coupon.edit', $row->id) .'" class="edit btn btn-info btn-sm" title="Edit"><i class="dripicons-pencil"></i></a>
                        &nbsp; ';
                    }
                    if (auth()->user()->can('coupon-action'))
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
            return view('admin.pages.coupon.index');
        }
        return abort('403', __('You are not authorized'));
    }

    public function create()
    {
        $locale = Session::get('currentLocal');
        App::setLocale($locale);

        $products = Product::with(['productTranslation','productTranslationEnglish'])
                            ->where('is_active',1)
                            ->get();


        $categories = Category::with(['categoryTranslation'=> function ($query) use ($locale){
                $query->where('local',$locale)
                ->orWhere('local','en')
                ->orderBy('id','DESC');
            }])
            ->where('is_active',1)
            ->get();


        return view('admin.pages.coupon.create',compact('products','categories','locale'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only('coupon_name','coupon_code','value','discount_type'),[
            'coupon_name' => 'required|unique:coupon_translations,coupon_name',
            'coupon_code' => 'required|unique:coupons,coupon_code',
            'value' => 'required',
            'discount_type' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $locale = Session::get('currentLocal');

        if (auth()->user()->can('coupon-store'))
        {
            $coupon = new Coupon();
            $coupon->slug          = $this->slug($request->coupon_name);
            $coupon->coupon_code   = $request->coupon_code;
            $coupon->value         = number_format((float)$request->value, env('FORMAT_NUMBER'), '.', '');
            $coupon->discount_type = $request->discount_type;
            $coupon->free_shipping = $request->free_shipping ?? 0;
            $coupon->minimum_spend = number_format((float)$request->minimum_spend, env('FORMAT_NUMBER'), '.', '');
            $coupon->maximum_spend = number_format((float)$request->maximum_spend, env('FORMAT_NUMBER'), '.', '');
            // $coupon->usage_limit_per_coupon = $request->usage_limit_per_coupon ?? 0;
            // $coupon->usage_limit_per_customer = $request->usage_limit_per_customer  ?? 0;
            $coupon->used          = $request->used ?? 0;
            $coupon->is_active     = $request->is_active ?? 0;
            $coupon->start_date    = date('Y-m-d',strtotime($request->start_date)) ?? NULL;
            $coupon->end_date      = date('Y-m-d',strtotime($request->end_date)) ?? NULL;
            $coupon_translation  = new CouponTranslation();
            $coupon_translation->locale      = $locale;
            $coupon_translation->coupon_name = $request->coupon_name;

            DB::beginTransaction();
            try {
                $coupon->save();

                $coupon_translation->coupon_id   = $coupon->id;
                $coupon_translation->save();

                //----------------- Coupon-Product --------------
                if (!empty($request->product_id)) {
                    $productArrayIds = $request->product_id;
                    $coupon->products()->sync($productArrayIds);
                }

                //----------------- Coupon-Category --------------
                if (!empty($request->category_id)) {
                    $categoryArrayIds = $request->category_id;
                    $coupon->categories()->sync($categoryArrayIds);
                }

                DB::commit();

            }
            catch (Exception $e)
            {
                DB::rollback();

                return response()->json(['error' => $e->getMessage()]);
            }

            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }

    public function edit($id)
    {
        $locale = Session::get('currentLocal');
        App::setLocale($locale);

        $products = Product::with(['productTranslation','productTranslationEnglish'])
                            ->where('is_active',1)
                            ->get();

        $categories = Category::with(['categoryTranslation'=> function ($query) use ($locale){
                $query->where('local',$locale)
                ->orWhere('local','en')
                ->orderBy('id','DESC');
            }])
            ->where('is_active',1)
            ->get();
        $coupon = Coupon::with('couponTranslation','couponTranslationEnglish')->find($id);

        return view('admin.pages.coupon.edit',compact('products','categories','locale','coupon'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->only('coupon_name','coupon_code','value','discount_type'),[
            'coupon_name' => 'required|unique:coupon_translations,coupon_name,'.$request->coupon_translation_id,
            'coupon_code' => 'required|unique:coupons,coupon_code,'.$request->coupon_id,
            'value' => 'required',
            'discount_type' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $locale = Session::get('currentLocal');

        if (auth()->user()->can('coupon-edit'))
        {
            $coupon = Coupon::find($request->coupon_id);
            $coupon->slug          = $this->slug($request->coupon_name);
            $coupon->coupon_code   = $request->coupon_code;
            $coupon->value         = number_format((float)$request->value, env('FORMAT_NUMBER'), '.', '');

            $coupon->discount_type = $request->discount_type;
            $coupon->free_shipping = $request->free_shipping ?? 0;
            $coupon->minimum_spend = number_format((float)$request->minimum_spend, env('FORMAT_NUMBER'), '.', '');
            $coupon->maximum_spend = number_format((float)$request->maximum_spend, env('FORMAT_NUMBER'), '.', '');

            // $coupon->usage_limit_per_coupon = $request->usage_limit_per_coupon  ?? NULL;
            // $coupon->usage_limit_per_customer = $request->usage_limit_per_customer  ?? NULL;
            $coupon->used          = $request->used ?? 0;
            $coupon->is_active     = $request->is_active ?? 0;
            $coupon->start_date    = date('Y-m-d',strtotime($request->start_date)) ?? NULL;
            $coupon->end_date      = date('Y-m-d',strtotime($request->end_date)) ?? NULL;


            DB::beginTransaction();
            try {
                    $coupon->update();

                    CouponTranslation::UpdateOrCreate(
                        [ 'coupon_id'   => $request->coupon_id,  'locale' => $locale ],
                        [ 'coupon_name' => $request->coupon_name ]);

                    //----------------- Coupon-Product --------------
                    if (!empty($request->product_id)) {
                        $productArrayIds = $request->product_id;
                        $coupon->products()->sync($productArrayIds);
                    }

                    //----------------- Coupon-Category --------------
                    if (!empty($request->category_id)) {
                        $categoryArrayIds = $request->category_id;
                        $coupon->categories()->sync($categoryArrayIds);
                    }

                DB::commit();
            }
            catch (Exception $e)
            {
                DB::rollback();

                return response()->json(['error' => $e->getMessage()]);
            }
            return response()->json(['success'=>'Data Saved Successfully']);
        }
    }


    public function active(Request $request){
        if ($request->ajax()){
            return $this->activeData(Coupon::find($request->id));
        }
    }

    public function inactive(Request $request){
        if ($request->ajax()){
            return $this->inactiveData(Coupon::find($request->id));
        }
    }

    public function bulkAction(Request $request)
    {
        if ($request->ajax()) {
            return $this->bulkActionData($request->action_type, Coupon::whereIn('id',$request->idsArray));
        }
    }
}
