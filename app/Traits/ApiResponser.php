<?php

namespace App\Traits;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function validateRequest(array $requestData, array $validation_rules){
        $validator = $this->getValidationFactory()->make($requestData, $validation_rules);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }
    }

    protected function importFailures($failures): JsonResponse
    {
        $errors = [];
        foreach ($failures as $failure) {
            $errors[] =[
                'row' => $failure->row() - 1,
                'attribute' => $failure->attribute(),
                'errors' => implode("|", $failure->errors()),
            ];
        }

        throw new HttpResponseException(response()->json([
            'status'=> 'Error',
            'message' => 'Validation Errors',
            'data' => $this->filter_failures($errors, 'row')
        ], Response::HTTP_UNPROCESSABLE_ENTITY));

    }

    private function filter_failures($failures, $key): array
    {
        $groups = $errors = array();

        foreach($failures as $failure) {
            $groups[$failure[$key]][] = $failure;
        }

        foreach($groups as $key => $value)
        {
            $attributes = $msgs = '';
            foreach($value as $item)
            {
                $attributes .= $item['attribute'] . ',';
                $msgs .= $item['errors'] . ',';

            }
            array_push($errors, ['row' => $key, 'attributes' => rtrim($attributes, ", "), 'errors' => rtrim($msgs, ", ")]);
        }
        return $errors;
    }


    protected function paginationResponse($resource, LengthAwarePaginator $pagination, $message = '', $code = Response::HTTP_OK): JsonResponse
    {
        $data = [
            'paginatedData' =>  $resource::collection($pagination),
            'currentPage' => $pagination->currentPage(),
            'lastPage' => $pagination->lastPage(),
            'total' => $pagination->total()
        ];
        return response()->json([
            'status'=> 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

}
