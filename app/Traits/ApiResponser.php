<?php

namespace App\Traits;


trait ApiResponser{

    protected function successResponse($data, $message = '', $code = 200)
    {
        return response()->json([
            'status'=> 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message = '', $code)
    {
        return response()->json([
            'status'=>'Error',
            'message' => $message,
            'data' => []
        ], $code);
    }

}
