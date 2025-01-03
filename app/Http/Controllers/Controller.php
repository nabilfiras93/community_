<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendSuccess($message='', $result = null)
    {   
        $code = 200;
        $response = [
            'status'    => true,
            'data'      => $result,
            'message'   => $message,
        ];
        return response()->json($response, $code);
    }

    public function sendError($httpCode=0, $message=null, $result = null)
    {   
        $code = $httpCode == 0 ? 401 : (strlen($httpCode) > 3 ? 500 : $httpCode);
        $response = [
            'status'    => false,
            'data'      => $result,
            'message'   => $message,
        ];
        if($code != 422){
            if(is_array($message)){
                Log::error(collect($message)->implode(', '));
            } else {
                Log::error($message);
            }
        }
        return response()->json($response);
    }
}
