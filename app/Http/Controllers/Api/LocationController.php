<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Auth;
use Session;
Use App\Gouvernate;
Use App\Status;
Use App\Caza;
Use App\Area;

class LocationController extends BaseController
{
    public function getGouvernate(Request $request){
    	$gouvernates = Gouvernate::all();
        if(count($gouvernates) > 0){
        	return $this->sendResponse($gouvernates->toArray(), "Success");
        }else{
        	return $this->sendError('No Gouvernate available');
        }
    }

    public function getCaza(Request $request){
        $formData = $request->all();
        $validator = Validator::make($formData, [
            'gouvernate_id'     => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
    	$cazas = Caza::where('gouvernate_id',$formData['gouvernate_id'])->get();
        if(count($cazas) > 0){
        	return $this->sendResponse($cazas->toArray(), "Success");
        }else{
        	return $this->sendError('No Caza available');
        }
    }

    public function getArea(Request $request){
        $formData = $request->all();
        $validator = Validator::make($formData, [
            'caza_id'     => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $area = Area::where('caza_id',$formData['caza_id'])->get();
        if(count($area) > 0){
            return $this->sendResponse($area->toArray(), "Success");
        }else{
            return $this->sendError('No area available');
        }
    }

    public function getStatus(Request $request){
        $statuses = Status::all();
        if(count($statuses) > 0){
            return $this->sendResponse($statuses->toArray(), "Success");
        }else{
            return $this->sendError('No Status available');
        }
    }

    public function getAllLocation(Request $request){
        $gouvernates = Gouvernate::all();
        $caza = Caza::all();
        $area = Area::all();

        $data = [
            'gouvernates'   => count($gouvernates) > 0 ? $gouvernates->toArray() : [],
            'caza'          => count($caza) > 0 ? $caza->toArray() : [],
            'area'          => count($area) > 0 ? $area->toArray() : [],
        ];
        return $this->sendResponse($data, "Success");
    }
}
