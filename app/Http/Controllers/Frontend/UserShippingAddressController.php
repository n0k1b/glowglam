<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\UserShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserShippingAddressController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        $userShippingAddress = UserShippingAddress::where('user_id',Auth::user()->id)->get();

        return view('frontend.pages.user_account.shipping_address.index',compact('countries','userShippingAddress'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only('country'),[
            'country' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $shipping_address = UserShippingAddress::where('user_id',Auth::user()->id);
        if($shipping_address->exists()){
            $shipping_address->update(['is_default'=>0]);
        }

        $userShippingAddress            = new UserShippingAddress;
        $userShippingAddress->user_id   = Auth::user()->id;
        $userShippingAddress->country   = $request->country;
        $userShippingAddress->address_1 = $request->address_1;
        $userShippingAddress->address_2 = $request->address_2;
        $userShippingAddress->city      = $request->city;
        $userShippingAddress->state     = $request->state;
        $userShippingAddress->zip_code  = $request->zip_code;
        $userShippingAddress->is_default= 1;
        $userShippingAddress->save();

        session()->flash('success_message','Data Added Successfully');
        return redirect()->back();

    }

    public function update(Request $request, $id)
    {
        if ($request->has('is_default')) {
            UserShippingAddress::where('user_id',Auth::user()->id)->update(['is_default'=>0]);
        }

        $userShippingAddress            = UserShippingAddress::find($id);
        $userShippingAddress->user_id   = Auth::user()->id;
        $userShippingAddress->country   = $request->country;
        $userShippingAddress->address_1 = $request->address_1;
        $userShippingAddress->address_2 = $request->address_2;
        $userShippingAddress->city      = $request->city;
        $userShippingAddress->state     = $request->state;
        $userShippingAddress->zip_code  = $request->zip_code;
        $userShippingAddress->is_default= $request->has('is_default');
        $userShippingAddress->update();

        session()->flash('success_message','Data Updated Successfully');
        return redirect()->back();
    }

    public function destroy($id)
    {
        UserShippingAddress::find($id)->delete();

        session()->flash('success_message','Data Deleted Successfully');
        return redirect()->back();
    }
}
