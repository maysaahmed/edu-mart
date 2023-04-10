<?php

namespace App\Traits;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use \Illuminate\Http\JsonResponse;

trait ApiResponser{

    protected function successResponse($data, $message = '', $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status'=> 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message = '', $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'status'=>'Error',
            'message' => $message,
            'data' => []
        ], $code);
    }

    public function failedValidation(Validator $validator)
    {
        $errors = [];
        foreach ($validator->errors()->getMessages() as $key => $value) {
            $errors[$key] = implode(", ", $value);
        }
        throw new HttpResponseException(response()->json([
            'status'=> 'Error',
            'message' => 'Validation Errors',
            'data' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY));


    }

}
