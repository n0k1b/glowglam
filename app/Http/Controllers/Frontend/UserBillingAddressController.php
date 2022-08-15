<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\UserBillingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserBillingAddressController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        $userBillingAddress = UserBillingAddress::where('user_id',Auth::user()->id)->get();

        return view('frontend.pages.user_account.billing_address.index',compact('countries','userBillingAddress'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only('country'),[
            'country' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $billing_address = UserBillingAddress::where('user_id',Auth::user()->id);
        if($billing_address->exists()){
            $billing_address->update(['is_default'=>0]);
        }

        $userBillingAddress            = new UserBillingAddress;
        $userBillingAddress->user_id   = Auth::user()->id;
        $userBillingAddress->country   = $request->country;
        $userBillingAddress->address_1 = $request->address_1;
        $userBillingAddress->address_2 = $request->address_2;
        $userBillingAddress->city      = $request->city;
        $userBillingAddress->state     = $request->state;
        $userBillingAddress->zip_code  = $request->zip_code;
        $userBillingAddress->is_default= 1;
        $userBillingAddress->save();

        session()->flash('success_message','Data Added Successfully');
        return redirect()->back();

    }

    public function update(Request $request, $id)
    {
        if ($request->has('is_default')) {
            UserBillingAddress::where('user_id',Auth::user()->id)->update(['is_default'=>0]);
        }

        $userBillingAddress            = UserBillingAddress::find($id);
        $userBillingAddress->user_id   = Auth::user()->id;
        $userBillingAddress->country   = $request->country;
        $userBillingAddress->address_1 = $request->address_1;
        $userBillingAddress->address_2 = $request->address_2;
        $userBillingAddress->city      = $request->city;
        $userBillingAddress->state     = $request->state;
        $userBillingAddress->zip_code  = $request->zip_code;
        $userBillingAddress->is_default= $request->has('is_default');
        $userBillingAddress->update();

        session()->flash('success_message','Data Updated Successfully');
        return redirect()->back();
    }

    public function destroy($id)
    {
        UserBillingAddress::find($id)->delete();

        session()->flash('success_message','Data Deleted Successfully');
        return redirect()->back();
    }
}
