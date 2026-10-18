<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Helpers\Email_sender;
use App\User;
use Auth;
use DB;

class UserController extends Controller
{
    public function index(Request $request){
    	return view('admin.user.list');
    }

    public function loadAdmin(Request $request){
    	$formData = $request->all();
		$data = User::select('users.*')
				->join('model_has_roles','model_has_roles.model_id','users.id')
				->where('model_has_roles.role_id',1);
		if(isset($formData['firstname']) && !empty($formData['firstname'])){
			$data->where('users.firstname','LIKE',"%".$formData['firstname']."%");
		}
		if(isset($formData['lastname']) && !empty($formData['lastname'])){
			$data->where('users.lastname','LIKE',"%".$formData['lastname']."%");
		}
		if(isset($formData['email']) && !empty($formData['email'])){
			$data->where('users.email','LIKE',"%".$formData['email']."%");
		}
		if(isset($formData['phone']) && !empty($formData['phone'])){
			$data->where('users.phone','LIKE',"%".$formData['phone']."%");
		}
		return datatables()->of($data)
    		->addColumn('action',function($data){
                if(Auth::user()->hasrole('admin')){
	                $actions 	= '<span class="dropdown">
	                                <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
	                                  <i class="la la-ellipsis-h"></i>
	                                </a>
                                	<div class="dropdown-menu dropdown-menu-right">';
	                $edit       = '<a href="'.route('edit-admin',$data->id).'" class="dropdown-item"><i class="la la-edit"></i>Edit</a>';
	                $delete     = '<a href="javascript:;" onclick="deleteAdmin('.$data->id.')" class="dropdown-item"><i class="la la-trash"></i> Delete</a>';
	                if($data->is_active == 0){
	                	$status     = '<a href="javascript:;" onclick="activateAdmin('.$data->id.')" class="dropdown-item"><i class="la la-trash"></i> Activate</a>';
	                }else{
	                	$status     = '<a href="javascript:;" onclick="deactivateAdmin('.$data->id.')" class="dropdown-item"><i class="la la-trash"></i> In-activate</a>';
	                }
	                $actions .= $edit;
	                if($data->id != 1){
	                	/*$actions .= $delete;*/
	                }
                	$actions .= $status;
                	$actions .= '</div></span>';
                	return $actions;
                }else{
                	return "";
                }
            })
            ->addColumn('status',function($data){
                if($data->is_active){
                	$status = '<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Active</span>';
                }else{
                	$status = '<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">In-active</span>';
                }
                return $status;
            })->rawColumns(['action','status','name'])->make(true);
    }

    public function add(Request $request){
    	if ($request->isMethod('post')) {
		    $formData = $request->all();

		    $request->validate([
		    	'firstname' 	=> 'required|string',
		    	'lastname' 		=> 'required|string',
		    	'email' 		=> 'required|email|unique:users',
		    	'address' 		=> 'required|string',
		    	'phone' 		=> 'required',
		    ]);
		    $remember_token = str_random(50);
		    $userObj = new User();
		    $userObj->firstname 		= $formData['firstname'];
		    $userObj->lastname 			= $formData['lastname'];
		    $userObj->email 			= $formData['email'];
		    $userObj->address 			= $formData['address'];
		    $userObj->phone 			= $formData['phone'];
		    $userObj->fax 				= $formData['fax'];
		    $userObj->remember_token 	= $remember_token;
		    $userObj->api_token 		= $remember_token;
		    $userObj->is_active 		= 1;
		    $userObj->save();
		    DB::table('model_has_roles')->insert([
		    	'role_id' => 1,
		    	'model_type' => "App\User",
		    	'model_id' => $userObj->id
		    ]);

            Email_sender::sendSetupProfileEmail(['user_name'=>ucfirst($formData['firstname']." ".$formData['lastname']),'receiver_email'=>$formData['email'],'token_key'=>$remember_token]);

		    if($userObj->id > 0){
		    	$request->session()->flash('success',"Admin successfully added");
		    	return redirect('admin-list');
		    }else{
		    	$request->session()->flash('error',"Whoops! Something went wrong. Please try again");
		    	return view('admin.user.add');
		    }
		}
    	return view('admin.user.add');
    }

    public function edit($id,Request $request){
    	$userObj = User::select('users.*')
    			->where('users.id',$id)->first();
    	if(empty($userObj)){
    		$request->session()->flash('error',"User does not exists");
    		return redirect('admin-list');
    	}
    	if ($request->isMethod('post')) {
		    $formData = $request->all();
		    $request->validate([
		    	'firstname' 	=> 'required|string',
		    	'lastname' 		=> 'required|string',
		    	'email' 		=> 'required|email',
		    	'address' 		=> 'required|string',
		    	'phone' 		=> 'required',
		    ]);
		    $userObj = User::find($id);
		    $userObj->firstname 	= $formData['firstname'];
		    $userObj->lastname 		= $formData['lastname'];
		    $userObj->email 		= $formData['email'];
		    $userObj->address 		= $formData['address'];
		    $userObj->phone 		= $formData['phone'];
		    $userObj->is_active 	= 1;
		    $userObj->save();
		    $roles = DB::table('model_has_roles')->where('model_id',$id)->first();
		    if(!empty($roles)){
			    DB::table('model_has_roles')->where('model_id',$id)->update([
			    	'role_id' => 1,
			    	'model_type' => "App\User",
			    ]);
		    }else{
		    	DB::table('model_has_roles')->insert([
			    	'role_id' => 1,
			    	'model_type' => "App\User",
			    	'model_id' => $id
			    ]);
		    }

		    if($userObj->id > 0){
		    	$request->session()->flash('success',"Admin successfully updated");
		    	return redirect('admin-list');
		    }else{
		    	$request->session()->flash('error',"Whoops! Something went wrong. Please try again");
		    	return view('admin.user.edit');
		    }
		}
    	return view('admin.user.edit',compact('userObj'));
    }

    public function activate(Request $request){
        $error     = '';
        $message   = '';
        User::where('id',$request['id'])->update(['is_active'=>$request['is_active']]);
        if(intval($request['is_active'])){
        	$message = "Admin successfully activated";
        }else{
        	$message = "Admin successfully deactivated";
        }
        $response  = [
            'response'  => $message,
            'error'     => $error
        ];
        return response()->json( $response );
    }
}
