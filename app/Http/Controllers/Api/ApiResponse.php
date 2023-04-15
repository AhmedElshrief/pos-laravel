<?php

namespace App\Http\Controllers\Api;

trait ApiResponse
{
    public function apiResponse($data = null, $message = [null], $status = null)
    {
        $response = [
            'data' => $data,
            'status' => $status,
            'message' => $message,
        ];
        return response($response, $status, $message);

    }// end of apiResponse

}// end of trait
