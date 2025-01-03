<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;


class BaseController extends Controller
{
    private function basicAuth(){
        if (env('APP_ENV') == 'production'){
            $return['user'] = env('AUTH_API_USER', 'MyCommunity2025');
            $return['password'] = env('AUTH_API_PASSWORD', 'LTiYRz6YOgLD6OayDf4jlM');
        } else {
            $return['user'] = env('AUTH_API_USER', 'MyCommunityDev');
            $return['password'] = env('AUTH_API_PASSWORD', 'myKeyApiDev');
        }
        return $return;
    }

    public function authMobile($request){
        $user           = $request->getUser();
        $password       = $request->getPassword();
        if($user != self::basicAuth()['user'] || $password != self::basicAuth()['password']){
            throw new \Exception('Authentication failed', 401);
        }
        return true;
    }

    public function mobileSuccess($message=null, $result = null)
    {   
        // if(is_array($result)){ ksort($result); }
        $code = 200;
        $response = [
            'status'    => self::statusByCode($code),
            'message'   => $message,
            'data'      => $result,
        ];
        return response()->json($response, $code);
    }

    public function mobileErrorCustom($e)
    {   
        $code = $e->getCode() == 0 ? 422 : (strlen($e->getCode()) > 3 ? 500 : $e->getCode());
        $logId = 'ErrorLogID: '.uniqid();
        $response = [
            'status'    => self::statusByCode($code),
            'message'   => $e->getMessage(),
            'data'      => null,
        ];
        return response()->json($response, $code);
    }

    public function mobileErrorValidation($e)
    {   
        $code = 422;
        $logId = 'ErrorLogID: '.uniqid();
        $response = [
            'status'    => self::statusByCode($code),
            'message'   => $e->getMessage(),
            'data'      => $e->validator->errors()->all(),
        ];
        return response()->json($response, $code);
    }

    public function mobileErrorDuplicate($e)
    {   
        $code = 422;
        $logId = 'ErrorLogID: '.uniqid();
        $response = [
            'status'    => 'duplicate',
            'message'   => $e->getMessage(),
            'data'      => $e->errors(),
        ];
        return response()->json($response, $code);
    }

    public function mobileErrorQuery($e)
    {   
        $code = 500;
        $logId = 'ErrorLogID: '.uniqid();
        $response = [
            'status'    => self::statusByCode($code),
            'message'   => $e->getMessage(),
            'data'      => null,
        ];
        return response()->json($response, $code);
    }

    public function mobileError($e)
    {   
        $code = $e->getCode() == 0 ? 500 : (strlen($e->getCode()) > 3 ? 500 : $e->getCode());
        $logId = 'ErrorLogID: '.uniqid();
        $response = [
            'status'    => self::statusByCode($code),
            'message'   => $e->getMessage(),
            'data'      => null,
        ];
        return response()->json($response, $code);
    }

    public static function statusByCode($number)
    {   
        $code = [
            200 => 'success',
            401 => 'failed',
            403 => 'forbidden',
            404 => 'not_found',
            422 => 'failed',
            500 => 'failed',
        ];
        return $code[$number];
    }
}
