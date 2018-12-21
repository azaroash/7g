<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Notifications\AppNotification;
use App\Notifications\SmsNotification;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('userLogout','logout');
    }
    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
    protected function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->attempt(array('email' => $request->input('email'), 'password' => $request->input('password'))))
        {
           // $userPoint = DB::table('points')->where('member_id', '=', (auth()->user->id))->value('points');
            if(auth()->user()->is_activated == '0'){
                $this->logout($request);
                return back()->with('warning',"Please activate your account first.");
            }
 
            return redirect()->to('home');
            
        }else{
            return back()->with('error','your username and password are wrong.');
        }
    }

    public function credentials (Request $request) {
        $request['is_activated'] = 1;
        return $request->only('email', 'password', 'is_activated');
    }
}
