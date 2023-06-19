<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Status;
use Auth;

class StatusController extends Controller
{
    public function index(Request $request){
    	return view('admin.status.list');
    }

    public function loadStatus(Request $request){
    	if(request()->ajax()){
    		$formData = $request->all();
    		$data = Status::select('status.*');
            if(isset($formData['name']) && !empty($formData['name'])){
                $data->where('name','like',"%".$formData['name']."%");
            }
            if(isset($formData['id']) && !empty($formData['id'])){
                $data->where('id',$formData['id']);
            }
    		return datatables()->of($data)
	    		->addColumn('action',function($data){
	                $actions 	= "";
	                $edit       = '<a href="'.route('edit-status',$data->id).'" class="btn btn-primary  m-btn--pill m-btn--custom m-btn--icon m-btn--air"><i class="la la-edit"></i> Edit</a>';
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
                'name' => 'required|string|unique:status'
            ]);

            $statusObj = new Status();
            $statusObj->name = $formData['name'];
            if($statusObj->save()){
                $request->session()->flash('success',"Status successfully added.");
                return redirect('status-list');
            }else{
                $request->session()->flash('error',"Whoops! Something went wrong please try again later.");
                return redirect('add-status');
            }
        }
        return view('admin.status.add');
    }
    public function edit($id,Request $request){
        $statusObj = Status::find($id);
        if(empty($statusObj)){
            $request->session()->flash('error',"Status not found");
            return redirect('status-list');
        }
        if($request->isMethod('post')){
            $formData = $request->all();
            $request->validate([
                'name' => 'required|string'
            ]);

            $statusObj->name = $formData['name'];
            if($statusObj->save()){
                $request->session()->flash('success',"Status successfully updated.");
                return redirect('status-list');
            }else{
                $request->session()->flash('error',"Whoops! Something went wrong please try again later.");
                return redirect('add-status');
            }
        }
        return view('admin.status.edit', compact('statusObj'));
    }

    public function delete(Request $request){
        $error     = '';
        $message   = '';
        Status::find($request['id'])->delete();
        $response  = [
            'response'  => "Status successfully deleted",
            'error'     => $error
        ];
        $request->session()->flash('success',"Status successfully deleted");
        return response()->json( $response );
    }
}
