<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use App\User;
use App\Setting;
use Mail;
use Validator;

class LoginController extends Controller
{

    use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(2);
	}

    public function login(Request $request)
    {

    	$this->validate($request, [
    		'email' => 'required',
    		'password' => 'required'
    	]);
        
        $authUser = User::where('email', $request->email)->first();
        if(isset($authUser) && $authUser->status == 0){
            return response()->json('Blocked User', 401); 
        }
        else{
            return $this->issueToken($request, 'password');
        }

    }

    public function fblogin(Request $request)
    {


        $this->validate($request, [
            'email' => 'required',
            'password' => '',
            'name' => 'required',
            'code' => 'required'
        ]);



        $authUser = User::where('email', $request->email)->first();

        if($authUser){
            $authUser->facebook_id = $request->code;
            $authUser->fname = $request->name;
            $authUser->save();
            if(isset($authUser) &&  $authUser->status == 0){
                return response()->json('Blocked User', 401); 
            }
            else{

                return $this->issueToken($request, 'password');
            }
        }
        else{
            $user = User::create([
                'fname' =>  request('name'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                'facebook_id' => request('code'),
            ]);

            return $this->issueToken($request, 'password');
        }
    }

    public function refresh(Request $request){
    	$this->validate($request, [
    		'refresh_token' => 'required'
    	]);

    	return $this->issueToken($request, 'refresh_token');
    }
    
    public function forgotApi(Request $request)
    { 
        $user = User::whereEmail($request->email)->first();
        if($user){

            $uni_col = array(User::pluck('code'));
            do {
              $code = str_random(5);
            } while (in_array($code, $uni_col));            
            try{
                $config = Setting::findOrFail(1);
                $logo = $config->logo;
                $email = $config->wel_email;
                $company = $config->project_title;
                Mail::send('forgotemail', ['code' => $code, 'logo' => $logo, 'company'=>$company], function($message) use ($user, $email) {
                    $message->from($email)->to($user->email)->subject('Reset Password Code');
                });
                $user->code = $code;
                $user->save();
                return response()->json('ok', 200);
            }
            catch(\Swift_TransportException $e){
                return response()->json('Mail Sending Error', 400);
            }
        }
        else{          
            return response()->json('user not found', 401);  
        }
    }

    public function verifyApi(Request $request)
    { 
        if( ! $request->code || ! $request->email)
        {
            return response()->json('email and code required', 449);
        }

        $user = User::whereEmail($request->email)->whereCode($request->code)->first();

        if( ! $user)
        {            
            return response()->json('not found', 401);
        }
        else{
            $user->code = null;
            $user->save();
            return response()->json('ok', 200);
        }
    }

    public function resetApi(Request $request)
    { 

        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::whereEmail($request->email)->first();

        if($user){

            $user->update(['password' => bcrypt($request->password)]);

            $user->save(); 
            
            return response()->json('ok', 200);
        }
        else{          
            return response()->json('not found', 401);
        }
    }

    public function logoutApi()
    {

        $token = Auth::user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);

    }
    
}
