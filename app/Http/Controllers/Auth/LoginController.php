<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showAdminLoginForm()
    {
        return view('admin.auth.login');
    }

    public function showCustomerLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ((auth()->user()->role == 0)){
                return redirect()->route('admin.dashboard');
            }
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function customerLogin(Request $request)
    {

        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ((auth()->user()->user_type == 0)){
                return redirect()->route('user_account');
            }
        }else {
            session()->flash('warning_type','danger');
            return redirect()->back()->with('message','Credential do not matched !!');
        }
        $this->incrementLoginAttempts($request);

        return redirect()->back();
    }


    //Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $this->_registerOrLoginUser($user);

        return redirect()->route('cartpro.home');
    }

    //Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $this->_registerOrLoginUser($user);

        return redirect()->route('cartpro.home');
    }


    //Github
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();
        $this->_registerOrLoginUser($user);

        return redirect()->route('cartpro.home');
    }


    protected function _registerOrLoginUser($data){
        $user = User::where('email','=',$data->email)->first();
        if (!$user) {
            $user = new User();
            $user->first_name = $data->name;
            $user->last_name = null;
            $user->username = $data->email;
            $user->email = $data->email;
            $user->image = $data->avatar ?? null;
            $user->user_type = 0;
            $user->is_active = 1;
            $user->porvider_id = $data->id;
            $user->save();
        }

        Auth::login($user);

    }


}
