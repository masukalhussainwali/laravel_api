<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{
    public static function rollback($e, $message = "Something went wrong! Process not completed.")
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $message = "Something went wrong! Process not completed.")
    {
        Log::error($e->getMessage(), ['exception' => $e]); // Log detailed error for debugging
        $response = response()->json([
            'success' => false,
            'message' => $message,
            'error' => $e->getMessage(),
        ], 500);

        throw new HttpResponseException($response);
    }

    public static function sendResponse($result, $message, $code=200, $headers = [])
    {
        $response = [
            'success' => true,
            'data' => $result,
        ];
        if(!empty($message)){
            $response['message'] = $message;
        }

        $responseInstance = response()->json($response, $code);

        foreach ($headers as $key => $value) {
            $responseInstance->header($key, $value);
        }

        return $responseInstance;
    }
}
