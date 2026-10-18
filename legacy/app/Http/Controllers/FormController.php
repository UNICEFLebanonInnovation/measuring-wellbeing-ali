<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;
use Auth;

class FormController extends Controller
{
    public function index(Request $request){
    	return view('admin.form.list');
    }

    public function loadForm(Request $request){
    	if(request()->ajax()){
    		$formData = $request->all();
    		$data = Form::orderBy('id','desc');
            if(isset($formData['form_name']) && !empty($formData['form_name'])){
                $data->where('name','like',"%".$formData['form_name']."%");
            }
            if(isset($formData['form_id']) && !empty($formData['form_id'])){
                $data->where('id',$formData['form_id']);
            }
    		return datatables()->of($data)
	    		->addColumn('action',function($data){
	                $actions 	= "";
	                $edit       = '<a href="'.route('edit-partners',$data->id).'" class="btn btn-info  m-btn--pill m-btn--custom m-btn--icon m-btn--air"><i class="la la-eye"></i> View</a>';
	                if(Auth::user()->hasrole('admin')){
	                	$actions .= $edit;
	                }
	                return $actions;
	            })
	            ->rawColumns(['action'])->make(true);
    	}
    }
}
