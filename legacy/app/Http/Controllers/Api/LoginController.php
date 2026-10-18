<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Auth;
use Session;
Use App\User;
use App\Collector;
use App\Partner;
use App\Application;

class LoginController extends BaseController
{
    public function login(Request $request){
    	$formData = $request->all();
    	$validator = Validator::make($formData, [
            'email' 	=> 'required|email',
            'password' 	=> 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = User::where(['email'=>$formData['email']])->first();

        if($user){
            if(isset($user->email_verified_at) && ($user->email_verified_at == null || $user->email_verified_at == "")){
                return $this->sendError('Please Verify your Email Address');
            }elseif (isset($user->is_active) && intval($user->is_active) == 0) {
                return $this->sendError('Your account is inactive');
            }else{
                if(Auth::attempt($formData)){
                	$user = User::find(Auth::user()->id);
                	$user->api_token = str_random(50);
                	$user->save();
                    $collectorObj       = Collector::where('user_id',$user->id)->first();
                    if(empty($collectorObj)){
                        return $this->sendError("Collector not found or unauthorized user");
                    }
                    $partnerObj = Partner::where('user_id',$collectorObj->partner_id)->first();
                    if(!empty($partnerObj) && !empty($partnerObj->prefix)){
                        $partnerPrefix = $partnerObj->prefix;
						$partnerName = $partnerObj->name;
                        $collectors = Collector::select('user_id')->where('partner_id',$partnerObj->user_id)->get()->toArray();
                        $applicationCount = Application::select('id')->where('collector_id',$user->id)->count();
                    }else{
                        return $this->sendError('Partner Prefix not added');
                    }
                    if(!empty($collectorObj) && !empty($collectorObj->prefix)){
                        $collectorPrefix = $collectorObj->prefix;
                    }else{
                        return $this->sendError('Collector Prefix not added');
                    }
                    $user->collector_prefix = $collectorPrefix;
                    $user->partner_prefix   = $partnerPrefix;
					$user->partner_name   	= $partnerName;
                    $user->last_increment_no = isset($applicationCount) && $applicationCount > 0 ? $applicationCount : 0;
                	return $this->sendResponse($user->toArray(), 'Welcome! '.ucfirst($user->firstname));
                }else{
                	return $this->sendError('Invalid credentials');
                }
            }
        }else{
            return $this->sendError('User does not exists');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        Session::flush();
        if(!Auth::user()){
        	return $this->sendResponse([],"Logout");
        }else{
        	return $this->sendError("Whoops! Please try again later.");
        }
    }
}
