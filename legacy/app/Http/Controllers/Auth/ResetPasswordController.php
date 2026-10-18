<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Helpers\Email_sender;
use Session;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function resetPassword(Request $request)
    {

        $data = $request->all();
        $request->validate([
            'password' => 'required|min:6:confirmed'
        ]);
        $user = User::where(['id'=>$data['user_id']])->first();
        if($user){
            User::where('id',$data['user_id'])->update(['password'=>Hash::make($data['password']),'email_verified_at'=>date('Y-m-d H:i:s'),'remember_token'=>'','is_active'=>1]);
            session()->flash('success',"Your password successfully reset ");
            return redirect('login');
        }else{
            $request->session()->flash('error',"User Not Found");
            return redirect('login');
        }
    }
}
