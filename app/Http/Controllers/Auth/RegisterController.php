<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use DB;
use Mail;
use App\Notifications\SuccessfulRegistration;
// use App\ActivationService;
// use App\ActivationRepository;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use ThrottlesLogins;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    //protected $activationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('userLogout', 'logout');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => 'required|string|max:255',
            'lastName' => 'string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //$input = $request->all();
        return User::create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $validator = $this->validator($input);
        if ($validator->passes()) {
            $user = $this->create($input)->toArray();
            $user['link'] = str_random(30);

            DB::table('points')->insert(['member_id' => $user['id'], 'points' => 250]);

            DB::table('user_activations')->insert(['id_user'=>$user['id'],'token'=>$user['link']]);
            Mail::send('emails.activation', $user, function($message) use ($user) {
                $message->to($user['email']);
                $message->subject('Activation Code For 7G');
            });
            return redirect()->to('login')->with('success',"We sent activation code. Please check your mail.");
        }
        return back()->with('errors',$validator->errors());
    }

    // public function authenticated(Request $request, $user)
    // {
    //     if (!$user->activated) {
    //         $this->activationService->sendActivationMail($user);
    //         auth()->logout();
    //         return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
    //     }
    //     return redirect()->intended($this->redirectPath());
    // }

    public function userActivation($token)
    {
        $check = DB::table('user_activations')->where('token',$token)->first();
        if(!is_null($check)){
            $user = User::find($check->id_user);
            if($user->is_activated == 1){
                return redirect()->to('login')->with('success',"Your account is already activated. You can log in with your credentials.");
            }
            $user->update(['is_activated' => 1]);
            DB::table('user_activations')->where('token',$token)->delete();
            $user->notify(new SuccessfulRegistration);

            return redirect()->to('login')->with('success',"Your account is activated successfully.");
        }
        return redirect()->to('login')->with('warning',"Your token is invalid.");
    }
}