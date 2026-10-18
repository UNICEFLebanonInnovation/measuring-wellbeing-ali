<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Partner;
use App\Collector;
use Hash;

class ProfileController extends Controller
{
    public function index($key,Request $request){
    	$users=User::select('*')->where('remember_token','=',$key)->first();
        if(!empty($users)){
            $id 	= isset($users->id) ? $users->id : 0;
            if($request->isMethod('post')){
            	$formData = $request->all();
            	$request->validate([
            		'name' => 'required|string',
            		'email' => 'required|email',
            		'password' => 'required|min:6:confirmed',
            		'password_confirmation' => 'required',
                    'agree' => "required"
            	]);
            	$users->password 		= Hash::make($formData['password']);
            	$users->remember_token 	= "";
                $users->is_active       = 1;
            	$users->save();
            	if($users->hasrole('partner')){
            		$partnerObj = Partner::where('user_id',$users->id)
            		->update([
            			'name' => $formData['name']
            		]);
            	}
            	$request->session()->flash('success',"Setup Completed. Please login");
            	return redirect('login');
            }
            $name = $users->firstname;
            if($users->hasrole('partner')){
                $partnerObj = Partner::where('user_id',$users->id)->first();
                $name = $partnerObj->name;
            }
            if($users->hasrole('collector')){
                $name = $users->firstname." ".$users->lastname;
            }
            return view('admin.setup_profile',compact('id','key','users','name'));
        }else{
            session()->flash('error','Token has been Expired');
        	return redirect('login');
        }
    }
}
