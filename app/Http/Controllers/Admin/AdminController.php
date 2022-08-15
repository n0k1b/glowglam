<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Traits\AutoDataUpdateTrait;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

//Google Analytics
use Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    use AutoDataUpdateTrait;
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        return view('admin.pages.home');
    }
    public function dashboard()
    {
        $orders = Order::orderBy('id','DESC')->get();
        $products = Product::where('is_active',1)->get();
        $total_customers = User::where('user_type',0)->get()->count();

        //We will convert it in ExpiryReminder later
        $this->autoDataUpdate();

        $top_brands = OrderDetail::with('brand.brandTranslation','brand.brandTranslationEnglish')
                            ->select('brand_id', DB::raw('count(*) as total, sum(subtotal) as total_amount'))
                            ->orderBy('total_amount','DESC')
                            ->groupBy('brand_id')
                            ->get()
                            ->take(5);

        $top_categories = OrderDetail::with('category.catTranslation','category.categoryTranslationDefaultEnglish')
                            ->select('category_id', DB::raw('count(*) as total, sum(subtotal) as total_amount'))
                            ->orderBy('total_amount','DESC')
                            ->groupBy('category_id')
                            ->get()
                            ->take(5);

        $top_products = OrderDetail::with('product','orderProductTranslation','orderProductTranslationEnglish','baseImage')
                            ->select('product_id', DB::raw('sum(subtotal) as total_amount'))
                            ->orderBy('total_amount','DESC')
                            ->groupBy('product_id')
                            ->get()
                            ->take(6);

        $category_product =  CategoryProduct::get();
        $category_ids = [];
        foreach ($products as $key => $item) {
            foreach ($category_product as $key => $value) {
                if ($item->id==$value->product_id) {
                    $category_ids[$item->id] = $category_product[$key];
                    break;
                }
            }
        }


        $browsers = Analytics::fetchTopBrowsers(Period::days(7));
        $topVisitedPages = Analytics::fetchMostVisitedPages(Period::days(7))->take(10);
        $topReferrers = Analytics::fetchTopReferrers(Period::days(7))->take(10);
        $topUserTypes = Analytics::fetchUserTypes(Period::days(7))->take(10);
        // $topAnaluticsService = Analytics::getAnalyticsService();
        // dd($topAnaluticsService);


        return view('admin.pages.home',compact('orders','products','total_customers','top_brands','top_categories','top_products','category_ids',
                                                'browsers','topVisitedPages','topReferrers','topUserTypes'));
    }

    protected function readFileEnglish(){

        //******* Temporaray For Language Input */
        // $lang_en = $this->readFileEnglish();
        // $lang_other = $this->readFileothers('bn');
        // $this->writeFile($lang_en, $lang_other);
        // return 'ok';
        // sort($lang_en);
        // foreach ($lang_en as $key => $val) {
        //     echo $val."</br>";
        // }
        //******* Temporaray End*/

        $lang_en = [];
        $myfile = fopen("temporary/lang_en.txt", "r") or die("Unable to open file!");
        while(!feof($myfile)) {
            $stringRemoveCotation = fgets($myfile);
            $stringRemoveNewLine = str_replace("\n", '', $stringRemoveCotation);
            $lang_en[] = str_replace("'", '', $stringRemoveNewLine);
        }
        return $lang_en;
    }

    protected function readFileothers($locale){
        $lang_other = [];
        $myfile = fopen('temporary/lang_'.$locale.'.txt', 'r') or die("Unable to open file!");
        while(!feof($myfile)) {
            $stringRemoveCotation = fgets($myfile);
            $stringRemoveNewLine = str_replace("\n", '', $stringRemoveCotation);
            $lang_other[] = str_replace("'", '', $stringRemoveNewLine);
        }
        return $lang_other;
    }

    protected function writeFile($lang_en, $lang_other){
        $myfile_read = fopen("temporary/output_lang.txt", "w") or die("Unable to open file!");
        foreach ($lang_other as $key => $value) {
            if ($value==null){
                break;
            }else {
                $text = "'$lang_en[$key]'". '=>' ."'$value',\n";
                fwrite($myfile_read, $text);
            }
        }
    }


    public function chart()
    {
        $startDate = Carbon::now()->subYear();
        $endDate = Carbon::now();
        // $result = Analytics::fetchVisitorsAndPageViews(Period::create($startDate, $endDate));


        $result = Analytics::fetchVisitorsAndPageViews(Period::days(7));

        return response()->json($result);
    }

    public function googleAnalytics()
    {
        $analytics = Analytics::fetchVisitorsAndPageViews(Period::days(1));
        dd($analytics);
    }

    public function logout()
    {
        Auth::logout();
            $message=array(
                'messege'=>'Successfully Logout',
                'alert-type'=>'success'
                 );

        Session::flush();

             return Redirect()->route('admin')->with($message);
    }

}
