<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\User;

class BaseController extends Controller
{
    public $userObj;
    public function __construct(Request $request)
    {
        if(isset($request['token']) && !empty($request['token'])){
            $this->userObj = User::where('api_token',$request['token'])->where('api_token','!=',"")->first();
            if(empty($this->userObj)){
                return response()->json([
                    'error' => "Invalid Token"
                ], 401);
            }
        }else{
            return response()->json([
                'error' => "Authorization failed"
            ], 401);
            return $this->sendError("Authorization failed",401);
        }
    }
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function getUser($token){
        $userObj = User::where('api_token',$token)->first();
        return $userObj;
    }
}
