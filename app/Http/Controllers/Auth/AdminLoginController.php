<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class AdminLoginController extends Controller
{
    use AuthenticatesUsers;
    //

    public function __construct()
    {
        $this->middleware('guest:web', ['except' => ['logout']]);
    }
    public function showLoginForm() {
        return view('auth.admin-login');
    }

    public function login(Request $request) {
        //Validate the form data
        $this->validate($request, [
            'username' => 'required|text',
            'password' => 'required|min:6'
        ]);
        //Attempt to log the user in
        if (Auth::guard('web')->attempt(['username' => $request->email, 'password' => $request->password], $request->remember)) {
            //if successful, redirect to the
//            if(Auth::guard('web')->user()->is_activated == '0'){
//                $this->logout($request);
//                return back()->with('warning',"Please activate your account first.");
//            }
            return redirect()->intended(route('client.dashboard'));
        }
        
        return redirect()->back()->withInput($request->only('username', 'remember'));
    }

    public function logout()
    {
        Auth::guard('client')->logout();
        return redirect('/');
    }

    public function credentials (Request $request) {
        $request['is_activated'] = 1;
        return $request->only('email', 'password', 'is_activated');
    }
}
