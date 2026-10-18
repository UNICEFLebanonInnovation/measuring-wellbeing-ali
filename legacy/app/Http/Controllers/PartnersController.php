<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Email_sender;
use App\Partner;
use App\Collector;
use App\Application;
use App\User;
use App\Status;
use Auth;
use DB;

class PartnersController extends Controller
{
    public function index(Request $request){
    	return view('admin.partners.list');
    }

    public function loadPartnter(Request $request){
    	if(request()->ajax()){
    		$formData = $request->all();
    		$data = Partner::select('users.id as partner_id','users.*','partners.name')
    			->leftJoin('users','users.id','partners.user_id');
    		if(isset($formData['partner_id']) && !empty($formData['partner_id'])){
    			$data->where('users.id',intval($formData['partner_id']));
    		}
    		if(isset($formData['name']) && !empty($formData['name'])){
    			$data->where('partners.name',$formData['name']);
    		}
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
    		if(isset($formData['zone']) && !empty($formData['zone'])){
    			$data->where('users.zone','LIKE',"%".$formData['zone']."%");
    		}
    		if(isset($formData['address']) && !empty($formData['address'])){
    			$data->where('users.address','LIKE',"%".$formData['address']."%");
    		}
    		/*echo "<pre>";
    		print_r($data->get());
    		exit();*/
    		return datatables()->of($data)
	    		->addColumn('action',function($data){
	                if(Auth::user()->hasrole('admin')){
		                $actions 	= '<span class="dropdown">
		                                <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
		                                  <i class="la la-ellipsis-h"></i>
		                                </a>
	                                	<div class="dropdown-menu dropdown-menu-right">';
		                $edit       = '<a href="'.route('edit-partners',$data->partner_id).'" class="dropdown-item"><i class="la la-edit"></i>Edit</a>';
		                $delete     = '<a href="javascript:;" onclick="deleteCollector('.$data->partner_id.')" class="dropdown-item"><i class="la la-trash"></i> Delete</a>';
		                if($data->is_active == 0){
		                	$status     = '<a href="javascript:;" onclick="activatePartner('.$data->partner_id.')" class="dropdown-item"><i class="la la-trash"></i> Activate</a>';
		                }else{
		                	$status     = '<a href="javascript:;" onclick="deactivatePartner('.$data->partner_id.')" class="dropdown-item"><i class="la la-trash"></i> In-activate</a>';
		                }
		                if(intval($data->is_readonly) == 0){
		                	$readonly     = '<a href="javascript:;" onclick="readonlyPartner('.$data->partner_id.')" class="dropdown-item"><i class="la la-trash"></i> Readonly</a>';
		                }else{
		                	$readonly     = '<a href="javascript:;" onclick="unloackPartner('.$data->partner_id.')" class="dropdown-item"><i class="la la-trash"></i> Unlock</a>';
		                }
	                	$actions .= $edit;
	                	$actions .= '</div></span>';
	                	return $actions;
	                }else{
	                	return "";
	                }
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
	                                    <input type="checkbox" name="status" onclick="activatePartner('.$data->id.','.$data->is_active.')" '.$checked.'>
	                                    <span></span>
	                                </label>
	                            </span>
	                        </div>';
	                return $status;
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
	                                    <input type="checkbox" name="status" onclick="readonlyPartner('.$data->id.','.$data->is_readonly.')" '.$checked.'>
	                                    <span></span>
	                                </label>
	                            </span>
	                        </div>';
	                return $status;
	            })
	            ->addColumn('name',function($data){
	                $name   = '<a href="'.route('view-partners',$data->id).'" >'.ucfirst($data->name).'</a>';
	                return $name;
	            })->rawColumns(['action',"status",'active','name'])->make(true);
    	}
    }

    public function add(Request $request){
    	if ($request->isMethod('post')) {
		    $formData = $request->all();
		    /*echo "<pre>";
		    print_r($formData);
		    exit();*/
		    $request->validate([
		    	"prefix" 		=> "required|string",
		    	'partner_name' 	=> 'required|min:3|string',
		    	'firstname' 	=> 'required|string',
		    	'lastname' 		=> 'required|string',
		    	'email' 		=> 'required|email|unique:users',
		    	'address' 		=> 'required|string',
		    	'phone' 		=> 'required',
		    	'max_code' 		=> 'required|digits_between:1,1000',
		    ]);
		    $remember_token = str_random(50);
		    $userObj = new User();
		    $userObj->firstname 		= $formData['firstname'];
		    $userObj->lastname 			= $formData['lastname'];
		    $userObj->email 			= $formData['email'];
		    $userObj->address 			= $formData['address'];
		    $userObj->phone 			= $formData['phone'];
		    /*$userObj->fax 				= $formData['fax'];
		    $userObj->zone 				= $formData['zone'];*/
		    $userObj->remember_token 	= $remember_token;
		    $userObj->api_token 		= $remember_token;
		    $userObj->is_active 		= 1;
		    $userObj->save();
		    DB::table('model_has_roles')->insert([
		    	'role_id' => 2,
		    	'model_type' => "App\User",
		    	'model_id' => $userObj->id
		    ]);

		    $partnerObj = new Partner();
		    $partnerObj->name 				= $formData['partner_name'];
		    $partnerObj->prefix				= strtoupper($formData['prefix']);
		    $partnerObj->max_app_per_year 	= $formData['max_code'];
		    $partnerObj->user_id 			= $userObj->id;
		    if ($file = $request->hasFile('partner_logo')){
                if (isset($partnerObj->logo) && $partnerObj->logo!='' && file_exists(public_path().'/assets/images/providerlogo/'.$partnerObj->logo)) {
                    unlink(public_path().'/images/partner_logo/'.$partnerObj->logo);
                }
                $file 					= $request->file('partner_logo');
                $customimagename 		= time(). '.' . $file->getClientOriginalExtension();
                $destinationPath 		= public_path().'/images/partner_logo/';
                $upload 				= $file->move($destinationPath, $customimagename);
                $partnerObj->logo    	= $customimagename;
            }
		    $partnerObj->save();
            Email_sender::sendSetupProfileEmail(['user_name'=>ucfirst($formData['partner_name']),'receiver_email'=>$formData['email'],'token_key'=>$remember_token]);

		    if($userObj->id > 0 && $partnerObj->id > 0){
		    	$request->session()->flash('success',"Partner successfully added");
		    	return redirect('partners-list');
		    }else{
		    	$request->session()->flash('error',"Whoops! Something went wrong. Please try again");
		    	return view('admin.partners.add');
		    }
		}
    	return view('admin.partners.add');
    }

    public function edit($id,Request $request){
    	$partnerObj = Partner::select('users.id as partner_id','users.*','partners.name','partners.prefix','partners.logo','partners.max_app_per_year')
    			->leftJoin('users','users.id','partners.user_id')
    			->where('users.id',$id)->first();
    	if(empty($partnerObj)){
    		$request->session()->flash('error',"Partner does not exists");
    		return redirect('partners-list');
    	}
    	if ($request->isMethod('post')) {
		    $formData = $request->all();
		    $request->validate([
		    	"prefix" 		=> "required|string",
		    	'partner_name' 	=> 'required|min:3|string',
		    	'firstname' 	=> 'required|string',
		    	'lastname' 		=> 'required|string',
		    	'email' 		=> 'required|email',
		    	'address' 		=> 'required|string',
		    	'phone' 		=> 'required',
		    	'max_code' 		=> 'required|digits_between:1,1000',
		    ]);
		    $userObj = User::find($id);
		    $userObj->firstname 	= $formData['firstname'];
		    $userObj->lastname 		= $formData['lastname'];
		    $userObj->email 		= $formData['email'];
		    $userObj->address 		= $formData['address'];
		    $userObj->phone 		= $formData['phone'];
		    /*$userObj->fax 			= $formData['fax'];
		    $userObj->zone 			= $formData['zone'];*/
		    $userObj->is_active 		= 1;
		    $userObj->save();
		    $roles = DB::table('model_has_roles')->where('model_id',$id)->first();
		    if(!empty($roles)){
			    DB::table('model_has_roles')->where('model_id',$id)->update([
			    	'role_id' => 2,
			    	'model_type' => "App\User",
			    ]);
		    }else{
		    	DB::table('model_has_roles')->insert([
			    	'role_id' => 2,
			    	'model_type' => "App\User",
			    	'model_id' => $id
			    ]);
		    }

		    $partnerObj = Partner::where('user_id',$id)->first();
		    $partnerObj->name 				= $formData['partner_name'];
		    $partnerObj->prefix 			= strtoupper($formData['prefix']);
		    $partnerObj->max_app_per_year 	= $formData['max_code'];
		    $partnerObj->user_id 			= $userObj->id;
		    if ($file = $request->hasFile('partner_logo')){
                if (isset($partnerObj->logo) && $partnerObj->logo!='' && file_exists(public_path().'/assets/images/providerlogo/'.$partnerObj->logo)) {
                    unlink(public_path().'/images/partner_logo/'.$partnerObj->logo);
                }
                $file 					= $request->file('partner_logo');
                $customimagename 		= time(). '.' . $file->getClientOriginalExtension();
                $destinationPath 		= public_path().'/images/partner_logo/';
                $upload 				= $file->move($destinationPath, $customimagename);
                $partnerObj->logo    	= $customimagename;
            }
		    $partnerObj->save();

		    if($userObj->id > 0 && $partnerObj->id > 0){
		    	$request->session()->flash('success',"Partner successfully updated");
		    	return redirect('partners-list');
		    }else{
		    	$request->session()->flash('error',"Whoops! Something went wrong. Please try again");
		    	return view('admin.partners.edit');
		    }
		}
    	return view('admin.partners.edit',compact('partnerObj'));
    }

    public function view($id,Request $request){
    	$partnerObj = Partner::select('users.id as partner_id','users.*','partners.name','partners.logo','partners.max_app_per_year')
    			->leftJoin('users','users.id','partners.user_id')
    			->where('users.id',$id)->first();
		$myCollectors = Collector::select('users.id as collector_id','collectors.name')
			->leftJoin('users','users.id','collectors.user_id')
			->orderBy('collector_id','desc')
			->where('collectors.partner_id',intval($id))
			->get();

		$collectorCount = count($myCollectors);

    	if(empty($partnerObj)){
    		$request->session()->flash('error',"Partner does not exists");
    		return redirect('partners-list');
    	}
    	$status 	= Status::all();
    	return view('admin.partners.view',compact('partnerObj','collectorCount','myCollectors','status'));
    }

    public function loadCollector(Request $request){
    	if(request()->ajax()){
	        $formData 	= $request->all();
    		$data = Application::select('application.*','part.name as partner_name','col.firstname as collector_name','status.name as status_name')
	            ->leftJoin('users as col','col.id','application.collector_id')
                ->join('collectors','collectors.user_id','application.collector_id')
	            ->leftJoin('partners as part','part.user_id','collectors.partner_id')
	            ->leftJoin('status','status.id','application.status');
	        if(isset($formData['code']) && !empty($formData['code'])){
	            $data->where('application.code','like',"%".$formData['code']."%");
	        }
	        if(isset($formData['pre_test_date']) && !empty($formData['pre_test_date'])){
	            $data->where('application.pre_test_date','like',"%".$formData['pre_test_date']."%");
	        }
	        if(isset($formData['post_test_date']) && !empty($formData['post_test_date'])){
	            $data->where('application.post_test_date','like',"%".$formData['post_test_date']."%");
	        }

	        if(isset($formData['partner']) && !empty($formData['partner'])){
	            $data->where('application.partner_id',$formData['partner']);
	            $collectors = Collector::select('user_id')->where('partner_id',$formData['partner'])->get()->toArray();
	        	$data->orWhereIn('application.collector_id',$collectors);
	        }
	        if(isset($formData['status']) && !empty($formData['status'])){
	            $data->where('application.status',$formData['status']);
	        }
	        /*if(isset($formData['order'][0])){
                if(isset($formData['order'][0]['column']) == 0){
                    $data->orderBy('code',$formData['order'][0]['dir']);
                }elseif(isset($formData['order'][0]['column']) == 1){
                    $data->orderBy('pre_test_date',$formData['order'][0]['dir']);
                }elseif(isset($formData['order'][0]['column']) == 2){
                    $data->orderBy('post_test_date',$formData['order'][0]['dir']);
                }elseif(isset($formData['order'][0]['column']) == 4){
                    $data->orderBy('status',$formData['order'][0]['dir']);
                }else{
                    $data->orderBy('code','desc');
                }
            }*/
    		return datatables()->of($data)
	            ->addColumn('score',function($data){
	            	return "6/10";
	            })
	            ->addColumn('partner',function($data){
	            	return ucfirst($data->partner_name);
	            })
	            ->make(true);
    	}
    }

    public function activate(Request $request){
        $error     = '';
        $message   = '';
        User::where('id',$request['id'])->update(['is_active'=>$request['value']]);
        if(intval($request['value'])){
        	$message = "Partner successfully activated";
        }else{
        	$message = "Partner successfully deactivated";
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
        	$message = "Partner moved to readonly";
        }else{
        	$message = "Partner moved to functional mode";
        }
        $response  = [
            'response'  => $message,
            'status'    => "Status",
            'error'     => $error
        ];
        return response()->json( $response );
    }

    public function delete(Request $request){
        $error     = '';
        $message   = '';
        User::where('id',$request['id'])->delete();
        Partner::where('user_id',$request['id'])->delete();
        $collectors = Collector::where('partner_id',$request['id'])->get();
        Collector::where('partner_id',$request['id'])->delete();
        foreach ($collectors as  $value) {
        	Application::where('collector_id',$value->user_id)->delete();
        }
        Application::where('partner_id',$request['id'])->delete();
        $response  = [
            'response'  => "Partner successfully deleted",
            'error'     => $error
        ];
        $request->session()->flash('success',"Partner successfully deleted");
        return response()->json( $response );
    }
}
