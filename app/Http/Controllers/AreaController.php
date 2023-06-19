<?php

namespace App\Http\Controllers;
use Auth;
use App\Area;
use App\Caza;
use App\Gouvernate;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request){
        $caza = Caza::all();
   		$gouvernate = Gouvernate::all();
    	return view('admin.area.list',compact('caza','gouvernate'));
    }

    public function loadArea(Request $request){
    	if(request()->ajax()){
    		$formData = $request->all();

    		$data = Area::select('caza.name as caza_name','gouvernate.name as gouvernate_name','area.*')
            ->leftJoin('caza','caza.id','area.caza_id')
    		->leftJoin('gouvernate','gouvernate.id','caza.gouvernate_id');
            if(isset($formData['name']) && !empty($formData['name'])){
                $data->where('area.name','like',"%".$formData['name']."%");
            }
            if(isset($formData['caza']) && !empty($formData['caza'])){
                $data->where('area.caza_id',$formData['caza']);
            }
            if(isset($formData['gouvernate']) && !empty($formData['gouvernate'])){
                $data->where('caza.gouvernate_id',$formData['gouvernate']);
            }
            if(isset($formData['id']) && !empty($formData['id'])){
                $data->where('area.id',$formData['id']);
            }
    		return datatables()->of($data)
	    		->addColumn('action',function($data){
	                $actions 	= "";
	                $edit       = '<a href="'.route('edit-area',$data->id).'" class="btn btn-primary  m-btn--pill m-btn--custom m-btn--icon m-btn--air"><i class="la la-edit"></i> Edit</a>';
                    $delete       = '<a href="javascript:;" onclick="deleteArea('.$data->id.')" class="btn btn-danger  m-btn--pill m-btn--custom m-btn--icon m-btn--air"><i class="la la-trash"></i> Delete</a>';
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
                'name' => 'required|string|unique:area'
            ]);

            $areaObj = new Area();
            $areaObj->caza_id 	         = $formData['caza'];
            $areaObj->gouvernate_id      = $formData['gouvernate'];
            $areaObj->name               = $formData['name'];
            $areaObj->arabic 	         = $formData['arabic'];
            if($areaObj->save()){
                $request->session()->flash('success',"Area successfully added.");
                return redirect('area-list');
            }else{
                $request->session()->flash('error',"Whoops! Something went wrong please try again later.");
                return redirect('add-area');
            }
        }
        $caza = Caza::all();
        $gouvernate = Gouvernate::all();
        return view('admin.area.add',compact('caza','gouvernate'));
    }
    public function edit($id,Request $request){
        $areaObj = Area::find($id);
        if(empty($areaObj)){
            $request->session()->flash('error',"Area not found");
            return redirect('area-list');
        }
        if($request->isMethod('post')){
            $formData = $request->all();
            $request->validate([
                'name' => 'required|string'
            ]);

            $areaObj->caza_id           = $formData['caza'];
            $areaObj->gouvernate_id 	= $formData['gouvernate'];
            $areaObj->name 		        = $formData['name'];
            $areaObj->arabic            = $formData['arabic'];
            if($areaObj->save()){
                $request->session()->flash('success',"Area successfully updated.");
                return redirect('area-list');
            }else{
                $request->session()->flash('error',"Whoops! Something went wrong please try again later.");
                return redirect('add-area');
            }
        }
        $caza = Caza::all();
        $gouvernate = Gouvernate::all();
        return view('admin.area.edit', compact('areaObj','caza','gouvernate'));
    }

    public function delete(Request $request){
        $error     = '';
        $message   = '';
        Area::find($request['id'])->delete();
        $response  = [
            'response'  => "Area successfully deleted",
            'error'     => $error
        ];
        $request->session()->flash('success',"Area successfully deleted");
        return response()->json( $response );
    }

    public function getAjazArea(Request $request){
        $gov_id = $request['caza_id'];
        $caza   = Area::where('caza_id',$gov_id)->get();
        $cityArray = [];
        if(count($caza) > 0){
            foreach ($caza as $value) {
                $slected = "";
                if($value->id == $request['selected_area']){
                    $slected = "selected";
                }
                $subArray = [];
                $subArray['id'] = $value->id;
                $subArray['name'] = ucfirst($value->name);
                $subArray['arabic'] = !empty($value->arabic) ? ucfirst($value->arabic): "";
                array_push($cityArray,$subArray);
            }
        }

        $response  = [
            'response'  => $cityArray
        ];
        return response()->json( $response );
    }
}
