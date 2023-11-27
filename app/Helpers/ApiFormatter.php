<?php

namespace App\Helpers;

class ApiFormatter{
    protected static $successResponse = [
        'code' => null,
        'message' => null,
        'data' => null
    ];

    public static function success($data, $message = "success"){
        self::$successResponse['code'] = 200;
        self::$successResponse['message'] = $message;
        self::$successResponse['data'] = $data;

        return response()->json(self::$successResponse,200);
    }


    protected static $errorResponse = [
        'code' => null,
        'message' => null
    ];

    public static function error($message, $code){
        self::$errorResponse['code'] = $code;
        self::$errorResponse['message'] = $message;

        return response()->json(self::$errorResponse,$code);
    }
}