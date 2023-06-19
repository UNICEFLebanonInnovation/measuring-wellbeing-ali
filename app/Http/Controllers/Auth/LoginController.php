<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use DB;
use App\User;
use Session;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(Request $request){
        return view('admin.login');
    }

    public function doLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $formData = $request->all();
        $user = User::where(['email'=>$formData['email']])->first();
        /*echo "<pre>";
        print_r($user);
        exit();*/

        if($user){
            $userRole = DB::table('model_has_roles')->where('model_id',$user->id)->first();
            /*if(isset($userRole->role_id) && intval($userRole->role_id) == 3){
                $request->session()->flash('error',"Your are not allowed to login");
                return redirect()->back()->withInput($request->all());
            }*/
            if(isset($user->email_verified_at) && ($user->email_verified_at == null || $user->email_verified_at == "")){
                $request->session()->flash('error',"Please Verify Your Email Address");
                return redirect()->back()->withInput($request->all());
            }elseif (isset($user->is_active) && intval($user->is_active) == 0) {
                $request->session()->flash('error',"Your Account is Inactive.");
                return redirect()->back()->withInput($request->all());
            }else{
                $credentials = [
                    'email'     => $formData['email'],
                    'password'  => $formData['password']
                ];
                $remember = 0;
                if(isset($formData['remember'])){
                    $remember = $formData['remember'];
                }
                $authSuccess = Auth::attempt($credentials,$remember);
                if ($authSuccess) {
                    $id = Auth::user()->id;
                    $userObj = Auth::guard('web')->user();
                    $request->session()->flash('success',"Welcome! ".ucfirst($userObj->firstname));
                    if(Auth::user()->hasRole('collector')){
                        return redirect('application-list');
                    }
                    return redirect('/dashboard');

                }else{
                    $request->session()->flash('error',"Invalid credentials");
                    return redirect()->back()->withInput($request->all());
                }
            }
        }else{
            $request->session()->flash('error',"User dose not exist");
            return redirect()->back()->withInput($request->all());
        }
    }

    public function logout(Request $request){
        Auth::logout();
        Session::flush();
        $message = "Successfully logged out";
        $request->session()->flash('success',$message);
        return redirect('/');
    }
}
