<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Email_sender;
use App\Application;
use App\Collector;
use App\Partner;
use App\User;
use Auth;
use DB;

class CollectorsController extends Controller
{
    public function index(Request $request){
    	return view('admin.collector.list');
    }

    public function loadCollector(Request $request){
		$formData = $request->all();
		$data = Collector::select('users.id as collector_id','users.*','collectors.city','collectors.is_subpartner','collectors.name','partners.name as partner_name')
			->leftJoin('users','users.id','collectors.user_id')
			->leftJoin('partners','partners.user_id','collectors.partner_id');
		if(isset($formData['collector_id']) && !empty($formData['collector_id'])){
			$data->where('users.id',intval($formData['collector_id']));
		}
		if(isset($formData['partner_id']) && !empty($formData['partner_id'])){
			$data->where('collectors.partner_id',intval($formData['partner_id']));
		}
		if(isset($formData['collector_name']) && !empty($formData['collector_name'])){
			$data->where('users.firstname','Like',"%".$formData['collector_name']."%")
			->orWhere('users.lastname','Like',"%".$formData['collector_name']."%");
		}
		if(Auth::user()->hasrole('partner')){
			$data->where('collectors.partner_id',intval(Auth::user()->id));
		}
		return datatables()->of($data)
    		->addColumn('action',function($data){

                if(Auth::user()->hasrole('admin') || Auth::user()->hasrole('partner')){
	                $actions 	= '<span class="dropdown">
	                                <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
	                                  <i class="la la-ellipsis-h"></i>
	                                </a>
                                	<div class="dropdown-menu dropdown-menu-right">';
	                $edit       = '<a href="'.route('edit-collector',$data->collector_id).'" class="dropdown-item"><i class="la la-edit"></i>Edit</a>';
	                $delete     = '<a href="javascript:;" onclick="deleteCollector('.$data->collector_id.')" class="dropdown-item"><i class="la la-trash"></i> Delete</a>';
	                if($data->is_active == 0){
	                	$status     = '<a href="javascript:;" onclick="activateCollector('.$data->collector_id.')" class="dropdown-item"><i class="la la-trash"></i> Activate</a>';
	                }else{
	                	$status     = '<a href="javascript:;" onclick="deactivateCollector('.$data->collector_id.')" class="dropdown-item"><i class="la la-trash"></i> In-activate</a>';
	                }
	                if(intval($data->is_readonly) == 0){
	                	$readonly     = '<a href="javascript:;" onclick="readonlyCollector('.$data->collector_id.')" class="dropdown-item"><i class="la la-trash"></i> Readonly</a>';
	                }else{
	                	$readonly     = '<a href="javascript:;" onclick="unloackCollector('.$data->collector_id.')" class="dropdown-item"><i class="la la-trash"></i> Unlock</a>';
	                }
	                if(Auth::user()->hasrole('partner')){
	                	$actions .= $edit;
	                }
                	$actions .= $status;
                	$actions .= '</div></span>';
                	if(!intval(Auth::user()->is_readonly)){
                		return $actions;
                	}else{
                		return "";
                	}
                }else{
                	return "";
                }
            })
            ->addColumn('active',function($data){

                if(intval($data->is_readonly) == 1){
                    $checked ='checked';
                }else{
                    $checked = '';
                }
                $status = '<div class="col-3">
                            <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                                <label>
                                    <input type="checkbox" name="status" onclick="readonlyCollector('.$data->id.','.$data->is_readonly.')" '.$checked.'>
                                    <span></span>
                                </label>
                            </span>
                        </div>';
                return $status;
            })
            ->addColumn('status',function($data){

                if(intval($data->is_active) == 1){
                    $checked ='checked';
                }else{
                    $checked = '';
                }
                $status = '<div class="col-3">
                            <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                                <label>
                                    <input type="checkbox" name="status" onclick="activateCollector('.$data->id.','.$data->is_active.')" '.$checked.'>
                                    <span></span>
                                </label>
                            </span>
                        </div>';
                return $status;
            })
            ->addColumn('collector_name',function($data){
            	return $collector_name = ucfirst($data->firstname." ".$data->lastname);
            })
            ->addColumn('pre_test',function($data){
            	$applicationCount = Application::where('collector_id',$data->collector_id)->whereIn('status',[2,3,4])->count();
	            return $applicationCount;
            })
            ->addColumn('post_test',function($data){
            	$applicationCount = Application::where('collector_id',$data->collector_id)->whereIn('status',[5,6,7,8])->count();
	            return $applicationCount;
            })
            /*->addColumn('is_subpartner',function($data){

            	if($data->is_subpartner){
                	$status = '<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Yes</span>';
                }else{
                	$status = '<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">No</span>';
                }
                return $status;
            })*/
            ->rawColumns(['action','active','is_subpartner','collector_name','status'])->make(true);
/*    	if(request()->ajax()){
    	}*/
    }

    public function add(Request $request){
    	if ($request->isMethod('post')) {
		    $formData = $request->all();

		    $request->validate([
		    	/*'name'				=> "required|string",*/
		    	'firstname' 		=> 'required|string',
		    	'lastname' 			=> 'required|string',
		    	'email' 			=> 'required|email|unique:users',
		    	'address' 			=> 'required|string',
		    	'phone' 			=> 'required',
		    	'city' 				=> 'required',
		    ]);

		    if(isset($formData['is_sub']) && $formData['is_sub'] == 1){
		    	$request->validate([
		    		'sub_partner' => 'required'
		    	]);
		    }
		    $remember_token 			= str_random(50);
		    $userObj 					= new User();
		    $userObj->firstname 		= $formData['firstname'];
		    $userObj->lastname 			= $formData['lastname'];
		    $userObj->email 			= $formData['email'];
		    $userObj->address 			= $formData['address'];
		    $userObj->phone 			= $formData['phone'];
		    /*$userObj->zone 				= $formData['zone'];*/
		    $userObj->remember_token 	= $remember_token;
		    $userObj->api_token 		= $remember_token;
		    $userObj->is_active 		= 1;
		    $userObj->save();
		    DB::table('model_has_roles')->insert([
		    	'role_id' 		=> 3,
		    	'model_type' 	=> "App\User",
		    	'model_id' 		=> $userObj->id
		    ]);

		    $collectorObj 					= new Collector();
		    $collectorObj->city 			= $formData['city'];
		    /*$collectorObj->name 			= $formData['name'];*/
		    $collectorObj->partner_id 		= Auth::user()->id;
		    $collectorObj->prefix			= strtoupper($formData['prefix']);
		    $collectorObj->user_id 			= $userObj->id;
		    if(isset($formData['is_sub']) && $formData['is_sub'] == 1){
		    	$collectorObj->is_subpartner 	= $formData['is_sub'];
		    	$collectorObj->sub_partner 		= $formData['sub_partner'];
		    }else{
		    	$collectorObj->is_subpartner = 0;
		    	$collectorObj->sub_partner = null;
		    }
		    $collectorObj->save();
            Email_sender::sendSetupProfileEmail(['user_name'=>ucfirst($formData['firstname']." ".$formData['lastname']),'receiver_email'=>$formData['email'],'token_key'=>$remember_token]);

		    if($userObj->id > 0 && $collectorObj->id > 0){
		    	$request->session()->flash('success',"Collector successfully added");
		    	return redirect('collector-list');
		    }else{
		    	$request->session()->flash('error',"Whoops! Something went wrong. Please try again");
		    	return view('admin.collector.add');
		    }
		}
    	$partners = Partner::get();
    	return view('admin.collector.add',compact('partners'));
    }

    public function edit($id,Request $request){
    	$collectorObj = Collector::select('users.id as collector_id','users.*','collectors.name','collectors.prefix','collectors.city','collectors.is_subpartner','collectors.sub_partner')
    			->leftJoin('users','users.id','collectors.user_id')
    			->where('users.id',$id)->first();
    	if(empty($collectorObj)){
    		$request->session()->flash('error',"Collector does not exists");
    		return redirect('collector-list');
    	}
    	if ($request->isMethod('post')) {
		    $formData = $request->all();
		    $request->validate([
		    	/*'name'				=> "required|string",*/
		    	'firstname' 		=> 'required|string',
		    	'lastname' 			=> 'required|string',
		    	'email' 			=> 'required|email',
		    	'address' 			=> 'required|string',
		    	'phone' 			=> 'required',
		    	'city' 				=> 'required',
		    ]);
		    $userObj = User::find($id);
		    $userObj->firstname 	= $formData['firstname'];
		    $userObj->lastname 		= $formData['lastname'];
		    $userObj->email 		= $formData['email'];
		    $userObj->address 		= $formData['address'];
		    $userObj->phone 		= $formData['phone'];
		    /*$userObj->zone 			= $formData['zone'];*/
		    $userObj->is_active 		= 1;
		    $userObj->save();
		    $roles = DB::table('model_has_roles')->where('model_id',$id)->first();
		    if(!empty($roles)){
			    DB::table('model_has_roles')->where('model_id',$id)->update([
			    	'role_id' 		=> 3,
			    	'model_type' 	=> "App\User",
			    ]);
		    }else{
		    	DB::table('model_has_roles')->insert([
			    	'role_id' 		=> 3,
			    	'model_type' 	=> "App\User",
			    	'model_id' 		=> $id
			    ]);
		    }

		    $collectorObj 						= Collector::where('user_id',$id)->first();
		    $collectorObj->city 				= $formData['city'];
		    /*$collectorObj->name 				= $formData['name'];*/
		    $collectorObj->partner_id 			= Auth::user()->id;
		    $collectorObj->prefix				= strtoupper($formData['prefix']);
		    $collectorObj->user_id 				= $userObj->id;
		    if(isset($formData['is_sub']) && $formData['is_sub'] == 1){
		    	$collectorObj->is_subpartner = $formData['is_sub'];
		    	$collectorObj->sub_partner 		= $formData['sub_partner'];
		    }else{
		    	$collectorObj->is_subpartner = 0;
		    	$collectorObj->sub_partner = null;
		    }
		    $collectorObj->save();

		    if($userObj->id > 0 && $collectorObj->id > 0){
		    	$request->session()->flash('success',"Collector successfully updated");
		    	return redirect('collector-list');
		    }else{
		    	$request->session()->flash('error',"Whoops! Something went wrong. Please try again");
		    	return view('admin.collector.edit');
		    }
		}
    	$partners = Partner::get();
    	return view('admin.collector.edit',compact('collectorObj','partners'));
    }

    public function delete(Request $request){
        $error     = '';
        $message   = '';
        User::where('id',$request['id'])->delete();
        Collector::where('user_id',$request['id'])->delete();
        $response  = [
            'response'  => "Collector successfully deleted",
            'error'     => $error
        ];
        $request->session()->flash('success',"Collector successfully deleted");
        return response()->json( $response );
    }

    public function activate(Request $request){
        $error     = '';
        $message   = '';
        User::where('id',$request['id'])->update(['is_active'=>$request['value']]);
        if(intval($request['value'])){
        	$message = "Collector successfully activated";
        }else{
        	$message = "Collector successfully deactivated";
        }
        $response  = [
        	"status" => "Status",
            'response'  => $message,
            'error'     => $error
        ];
        return response()->json( $response );
    }

    public function readonly(Request $request){
        $error     = '';
        $message   = '';
        User::where('id',$request['id'])->update(['is_readonly'=>$request['value']]);
        if(intval($request['value'])){
        	$message = "Collector moved to readonly";
        }else{
        	$message = "Collector moved to functional mode";
        }
        $response  = [
        	"status"  	=> "Status",
            'response'  => $message,
            'error'     => $error
        ];
        return response()->json( $response );
    }
}
