<?php

namespace App\Http\Controllers;
use Auth;
use App\Gouvernate;
use Illuminate\Http\Request;

class GouvernateController extends Controller
{
    public function index(Request $request){
    	return view('admin.gouvernate.list');
    }

    public function loadGouvernate(Request $request){
    	if(request()->ajax()){
    		$formData = $request->all();
    		$data = Gouvernate::select('gouvernate.*');
            if(isset($formData['name']) && !empty($formData['name'])){
                $data->where('name','like',"%".$formData['name']."%");
            }
            if(isset($formData['id']) && !empty($formData['id'])){
                $data->where('id',$formData['id']);
            }
            /*if(isset($formData['order'][0])){
                if(isset($formData['order'][0]['column']) == 0){
                    $data->orderBy('id',$formData['order'][0]['dir']);
                }elseif(isset($formData['order'][0]['column']) == 1){
                    $data->orderBy('name',$formData['order'][0]['dir']);
                }else{
                    $data->orderBy('name','desc');
                }
            }*/
    		return datatables()->of($data)
	    		->addColumn('action',function($data){
	                $actions 	= "";
	                $edit       = '<a href="'.route('edit-gouvernate',$data->id).'" class="btn btn-primary  m-btn--pill m-btn--custom m-btn--icon m-btn--air"><i class="la la-edit"></i> Edit</a>';
                    $delete       = '<a href="javascript:;" onclick="deleteGov('.$data->id.')" class="btn btn-danger  m-btn--pill m-btn--custom m-btn--icon m-btn--air"><i class="la la-trash"></i> Delete</a>';
	                if(Auth::user()->hasrole('admin')){
	                	$actions .= $edit." ".$delete;
	                }
	                return $actions;
	            })
	            ->rawColumns(['action'])->make(true);
    	}
    }

    public function add(Request $request){
        if($request->isMethod('post')){
            $formData = $request->all();
            $request->validate([
                'name' => 'required|string|unique:gouvernate'
            ]);

            $govObj                 = new Gouvernate();
            $govObj->name           = $formData['name'];
            $govObj->arabic        = $formData['arabic'];
            if($govObj->save()){
                $request->session()->flash('success',"Gouvernate successfully added.");
                return redirect('gouvernate-list');
            }else{
                $request->session()->flash('error',"Whoops! Something went wrong please try again later.");
                return redirect('add-gouvernate');
            }
        }
        return view('admin.gouvernate.add');
    }
    public function edit($id,Request $request){
        $govObj = Gouvernate::find($id);
        if(empty($govObj)){
            $request->session()->flash('error',"Gouvernate not found");
            return redirect('gouvernate-list');
        }
        if($request->isMethod('post')){
            $formData = $request->all();
            $request->validate([
                'name' => 'required|string'
            ]);

            $govObj->name       = $formData['name'];
            $govObj->arabic    = $formData['arabic'];
            if($govObj->save()){
                $request->session()->flash('success',"Gouvernate successfully updated.");
                return redirect('gouvernate-list');
            }else{
                $request->session()->flash('error',"Whoops! Something went wrong please try again later.");
                return redirect('add-gouvernate');
            }
        }
        return view('admin.gouvernate.edit', compact('govObj'));
    }

    public function delete(Request $request){
        $error     = '';
        $message   = '';
        Gouvernate::find($request['id'])->delete();
        $response  = [
            'response'  => "Gouvernate successfully deleted",
            'error'     => $error
        ];
        $request->session()->flash('success',"Gouvernate successfully deleted");
        return response()->json( $response );
    }

    public function getLocation(Request $request){
        $ip = $request->ip();
        /*if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }*/
        $geoIP  = json_decode(file_get_contents("http://freegeoip.net/json/$ip"), true);

        return response()->json( ['location' => $geoIP] );
    }
}
