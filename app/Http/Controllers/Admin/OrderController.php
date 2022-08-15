<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrencyRate;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id','DESC')->get();

        if (request()->ajax())
        {
            return datatables()->of($orders)
            ->setRowId(function ($row){
                return $row->id;
            })
            ->addColumn('order_id', function ($row)
            {
                return '<a href="'.route('admin.order.details', $row->id).'">'.$row->id.'</i></a>';
            })
            ->addColumn('order_status', function ($row)
            {
                $btn_color = '';
                if ($row->order_status=='order_placed') {
                    $btn_color = 'primary';
                }else if($row->order_status=='pending'){
                    $btn_color = 'danger';
                }else if($row->order_status=='order_confirmed'){
                    $btn_color = 'secondary';
                }else if($row->order_status=='delivery_scheduled'){
                    $btn_color = 'warning';
                }else if($row->order_status=='delivery_successful'){
                    $btn_color = 'info';
                }else if($row->order_status=='payment_successful'){
                    $btn_color = 'light';
                }else if($row->order_status=='order_completed'){
                    $btn_color = 'success';
                }
                return '<div class="btn-group dropright">
                        <button type="button" class="btn btn-'.$btn_color.'">'.ucwords(str_replace('_', ' ',$row->order_status)  ).'</button>
                        <button type="button" class="btn btn-'.$btn_color.' dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="'.route('admin.order.status_change',['order_id'=>$row->id,'status'=>'order_placed']).'">Order Placed</a>
                            <a class="dropdown-item" href="'.route('admin.order.status_change',['order_id'=>$row->id,'status'=>'order_confirmed']).'">Order Confirmed</a>
                            <a class="dropdown-item" href="'.route('admin.order.status_change',['order_id'=>$row->id,'status'=>'delivery_scheduled']).'">Delivery Scheduled</a>
                            <a class="dropdown-item" href="'.route('admin.order.status_change',['order_id'=>$row->id,'status'=>'delivery_resheduled']).'">Delivery Resheduled</a>
                            <a class="dropdown-item" href="'.route('admin.order.status_change',['order_id'=>$row->id,'status'=>'delivery_successful']).'">Delivery Successful</a>
                            <a class="dropdown-item" href="'.route('admin.order.status_change',['order_id'=>$row->id,'status'=>'payment_successful']).'">Payment Successful</a>
                            <a class="dropdown-item" href="'.route('admin.order.status_change',['order_id'=>$row->id,'status'=>'order_completed']).'">Order Completed</a>
                        </div>
                    </div>';
            })
            ->addColumn('delivery_date', function ($row)
            {
                if ($row->delivery_date) {
                    $delivery_date = date('d-M-Y',strtotime($row->delivery_date));
                }else {
                    $delivery_date = null;
                }
                return '<input data-provide="datepicker" class="form-control date_field" data-id="'.$row->id.'" type="text" placeholder="None" value="'.$delivery_date.'"/>
                        <button hidden class="mt-1 update_btn btn-success" type="button" data-id="'.$row->id.'" title="Update"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                        <span class="text-success"><i class="fa fa-check-circle-o check_icon d-none" aria-hidden="true"></i></span>';
            })
            ->addColumn('delivery_time', function ($row)
            {
                $delivery_time = $row->delivery_time ?? null;
                return '<input class="form-control time_field" data-id="'.$row->id.'" type="text" placeholder="None" value="'.$delivery_time.'"/>
                        <button hidden class="mt-1 update_time_btn btn-success" type="button" data-id="'.$row->id.'" title="Update"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                        <span class="text-success"><i class="fa fa-check-circle-o check_icon d-none" aria-hidden="true"></i></span>';
            })
            ->addColumn('customer_name', function ($row)
            {
                if ($row->billing_first_name==NULL && $row->billing_last_name==NULL) {
                    return Auth::user()->first_name.' '.Auth::user()->last_name;
                }else {
                    return $row->billing_first_name.' '.$row->billing_last_name;
                }
            })
            ->addColumn('customer_email', function ($row)
            {
                if ($row->billing_first_name==NULL && $row->billing_last_name==NULL) {
                    return Auth::user()->email;
                }else {
                    return $row->billing_email;
                }

            })
            ->addColumn('created_at', function ($row)
            {
                return date('Y-m-d',strtotime($row->created_at));
            })
            ->rawColumns(['order_id','action','order_status','delivery_date','delivery_time'])
            ->make(true);
        }
        return view('admin.pages.order.index');
    }

    public function transactionIndex()
    {
        $orders = Order::orderBy('id','DESC')->where('order_status','completed')->get();

        if (request()->ajax())
        {
            return datatables()->of($orders)
            ->setRowId(function ($row){
                return $row->id;
            })
            ->addColumn('order_status', function ($row)
            {
                return ucfirst($row->order_status);
            })
            ->addColumn('created_at', function ($row)
            {
                return date('Y-m-d',strtotime($row->created_at));
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.pages.order.transaction');
    }
    
    public function orderStatusChange($order_id, $status)
    {
        Order::where('id',$order_id)->update(['order_status'=>$status]);

        if ($status=='order_completed') {
            $order_details = OrderDetail::where('order_id',$order_id)->get();

            foreach ($order_details as $row) {
                DB::table('products')
                    ->where('id',$row->product_id)
                    ->update(['qty' => DB::raw('qty -'.$row->qty)]);
            }
        }

        return redirect()->back();
    }

    public function orderDate(Request $request){
        if ($request->date) {
            Order::where('id',$request->id)->update(['delivery_date'=>$request->date]);
            return response()->json(['success'=>'Delivery date updated successfully']);
        }
    }

    public function orderDeliveryTime(Request $request){
        if ($request->time) {
            Order::where('id',$request->id)->update(['delivery_time'=>$request->time]);
            return response()->json(['success'=>'Delivery time updated successfully']);
        }
    }


    public function orderDetails($id)
    {
        $order = Order::with('orderDetails.product.productTranslation','shippingDetails')->find($id);

        $currency_rate = 0.00;
        $default_currency_code = env('DEFAULT_CURRENCY_CODE');
        if ($default_currency_code) {
            $currency_rate = CurrencyRate::where('currency_code',$default_currency_code)->first()->currency_rate;
        }
        return view('admin.pages.order.order_details',compact('order','currency_rate'));
    }

    public function orderStatus(Request $request)
    {
        Order::where('id',$request->order_id)->update(['order_status'=>$request->order_status]);

        if ($request->order_status=='completed') {
            $order_details = OrderDetail::where('order_id',$request->order_id)->get();

            foreach ($order_details as $row) {
                DB::table('products')
                    ->where('id',$row->product_id)
                    ->update(['qty' => DB::raw('qty -'.$row->qty)]);
            }
        }

        return response()->json(['type'=>'success']);
    }
}
