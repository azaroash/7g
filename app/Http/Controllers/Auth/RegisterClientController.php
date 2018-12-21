<?php

namespace App\Http\Controllers\Auth;

use App\Client;
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

class RegisterClientController extends Controller
{
    //
    use RegistersUsers;
    use ThrottlesLogins;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest:client')->except('logout');
    }

    protected function retrieveLogo(Request $request) {

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'companyName' => 'required|string|max:255',
            'phone' => 'string|max:255',
            'tradeName' => 'string|max:255',
            'location' => 'required|string|max:255',
            'categories' => 'required|string',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|min:6|confirmed',
            'logo' => 'image|nullable|max:1999',
        ]);
    }

    protected function create(array $data)
    {
        //$input = $request->input('categories');

        return Client::create([
            'companyName' => $data['companyName'],
            'phone' => $data['phone'],
            'tradeName' => $data['tradeName'],
            'location' => $data['location'],
            'categories' => $data['categories'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        if ($request->hasFile('logo')){
            //Get filename with extension
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('logo')->getClientOriginalExtension();
            //File name to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('logo')->storeAs('public/logos', $fileNameToStore);
        }
        else {
            $fileNameToStore = 'noimage.jpg';
        }

        $input = $request->all();
        $validator = $this->validator($input);

        if ($validator->passes()) {
            $client = $this->create($input)->toArray();
            $client['link'] = str_random(30);

            $updateLogo = Client::find($client['id']);
            $updateLogo->update(['logo' => $fileNameToStore]);

            DB::table('clients_activations')->insert(['id_client'=>$client['id'],'token'=>$client['link']]);
            Mail::send('emails.clientActivation', $client, function($message) use ($client) {
                $message->to($client['email']);
                $message->subject('7G - Activation Code');
            });
            return redirect()->to('client/login')->with('success',"We sent activation code. Please check your mail.");
        }
        return back()->with('errors',$validator->errors());
    }

    public function clientActivation($token)
    {
        $check = DB::table('clients_activations')->where('token',$token)->first();
        if(!is_null($check)){
            $client = Client::find($check->id_client);
            if($client->is_activated == 1){
                return redirect()->to('client/login')->with('success',"Your account is already activated. You can log in with your credentials.");
            }
            $client->update(['is_activated' => 1]);
            DB::table('clients_activations')->where('token',$token)->delete();
            $client->notify(new SuccessfulRegistration);

            return redirect()->to('client/login')->with('success',"Your account is activated successfully.");
        }
        return redirect()->to('client/login')->with('warning',"your token is invalid.");
    }

    public function showRegistrationForm()
    {
        return view('auth.registerClient');
    }
}
