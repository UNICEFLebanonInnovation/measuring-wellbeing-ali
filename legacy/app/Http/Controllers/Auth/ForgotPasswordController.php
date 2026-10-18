<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Helpers\Email_sender;
use Session;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(Request $request){
        return view('admin.forgot_password');
    }

    public function sendForgotPasswordLink(Request $request){
        $formData = $request->all();

        $request->validate([
            'email' => 'required|email'
        ]);

        if($request->isMethod('post')){
            /*echo "<pre>";
            print_r($formData);
            exit();*/
            $user = User::where(['email'=>$formData['email']])->first();
            if($user){
                if(isset($user->email_verified_at) && $user->email_verified_at == null){
                    $request->session()->flash('error',"Please Verify Your Email Address");
                    return redirect()->back()->withInput($request->all);
                }elseif(isset($user->status) && $user->status == 0){
                    $request->session()->flash('error',"Please Verify Your Email Address");
                    return redirect()->back()->withInput($request->all);
                }else{
                    $remember_token = str_random(50);
                    User::where('id',$user->id)->update(['remember_token'=>$remember_token]);
                    $token_key = $remember_token;
                    Email_sender::sendForgotPasswordEmail(['user_name'=>$user->firstname." ".$user->lastname,'email'=>$formData['email'],'token_key'=>$token_key]);
                    session()->flash('success',"Please check your email to get reset password link");
                    return redirect()->back();
                }
            }else{
                $request->session()->flash('error',"User does not exist");
                return redirect()->back()->withInput($request->all);
            }
        }
    }

    public function reset($key){
        try{
            $users=User::select('*')->where('remember_token','=',$key)->first();
            if($users!=null){
                $id= isset($users->id)?$users->id:0;
                return view('admin.reset_password',compact('id'));
            }else{
                session()->flash('error','Token has been Expired');
            }
            return redirect('login');
        } catch (Exception $ex) {
            Bugsnag::notifyException($ex);
        }
    }
}
