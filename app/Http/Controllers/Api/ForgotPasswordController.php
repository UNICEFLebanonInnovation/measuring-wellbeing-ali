<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Helpers\Email_sender;
use Illuminate\Support\Str;
use Validator;
use Auth;
use Session;
Use App\User;

class ForgotPasswordController extends BaseController
{
    public function index(Request $request){
    	$formData = $request->all();
    	$validator = Validator::make($formData, [
            'email' 	=> 'required|email'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = User::where(['email'=>$formData['email']])->first();
        if($user){
            if(isset($user->email_verified_at) && $user->email_verified_at == null){
                return $this->sendError('Email address not verified');
            }elseif(isset($user->is_active) && $user->is_active == 0){
                return $this->sendError('Account is not activated');
            }else{
                $remember_token = str_random(50);
                User::where('id',$user->id)->update(['remember_token'=>$remember_token,'api_token'=>null]);
                Email_sender::sendForgotPasswordEmail(['user_name'=>$user->firstname." ".$user->lastname,'receiver_email'=>$formData['email'],'token_key'=>$remember_token]);
                return $this->sendResponse($user->toArray(), "Please check your email to get reset password link");
            }
        }else{
            $request->session()->flash('error',"User does not exist");
            return redirect()->back()->withInput($request->all);
        }
        if(Auth::attempt($formData)){
        	$user = User::find(Auth::user()->id);
        	$user->api_token = str_random(50);
        	$user->save();
        	return $this->sendResponse($user->toArray(), 'Welcome! '.ucfirst($user->firstname));
        }else{
        	return $this->sendError('Invalid credentials');
        }
    }
}
