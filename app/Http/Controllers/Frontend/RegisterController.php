<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\imageHandleTrait;

class RegisterController extends Controller
{
    use imageHandleTrait;

    public function customerRegister(Request $request)
    {
        $data = [];

        if ($request->billing_create_account_check) {
            $validator1 = Validator::make($request->all(),[
                'billing_first_name' => 'required|string',
                'billing_last_name'  => 'required|string',
                'username'   => 'required|string|unique:users',
                'billing_phone'      => 'required',
                'password'   => 'required|string|confirmed',
                'password_confirmation' => 'required',
            ]);

            if($validator1->fails()){
                return response()->json(['errors' => $validator1->errors()->all()]);
            }

            $data['first_name'] = $request->billing_first_name;
            $data['last_name']  = $request->billing_last_name;
            $data['username']   = $request->username;
            $data['email']      = $request->billing_email;
            $data['phone']      = $request->billing_phone;
            $data['user_type']  = 0;
            $data['password']   = Hash::make($request->password);
        }
        else {
            $validator2 = Validator::make($request->all(),[
                'first_name' => 'nullable|string',
                'last_name'  => 'nullable|string',
                'username'   => 'required|string|unique:users',
                'email'      => 'required|string|email|unique:users',
                'phone'      => 'nullable',
                'password'   => 'required|string|confirmed',
                'password_confirmation' => 'required',
                'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            ]);

            if($validator2->fails()){
                session()->flash('message','');
                return redirect()->back()->withErrors($validator2)->withInput();
            }

            $data['username']   = $request->username;
            $data['email']      = $request->email;
            $data['user_type']  = 0;
            $data['is_active']  = 1;
            $data['password']   = Hash::make($request->password);
        }
        $user = User::create($data);
        $data['user_id'] = $user->id;
        Customer::create($data);

        if ($request->billing_create_account_check) {
            return response()->json(['success' => 'Data Saved Successfully']);
        }

        session()->flash('warning_type','success');
        session()->flash('message','Registration Successfully Done !!!');
        return redirect()->back();
    }
}
