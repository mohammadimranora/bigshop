<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class ResponseHelper
{

    /**
     * send response in json
     * @param string $message
     * @param mixed $data
     * @param integer $code
     * @return \Illuminate\Http\Response
     */

    public static function success($message, $data = [], $code = 200)
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
            'timedate' => Carbon::now()
        ];

        return response()->json($response, $code);
    }

    /**
     * send error in json
     * @param string $error
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public static function error($message, $code = 400, $errors = [])
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'timedate' => Carbon::now()
        ];

        return response()->json($response, $code);
    }
}
