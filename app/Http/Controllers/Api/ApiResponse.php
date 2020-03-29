<?php


namespace App\Http\Controllers\Api;


use Illuminate\Support\Facades\Validator;

trait ApiResponse
{

    public $paginateNumber = 5;

    public function apiResponse($data = null, $message = null, $code = 200)
    {
        $array = [
            'data' => $data,
            'status' => in_array($code, $this->successCode()) ? true : false,
            'message' => $message
        ];

        return response($array, $code);
    }

    public function successCode()
    {
        return [
            200, 201, 202
        ];
    }

    public function notFoundResponse()
    {
        return $this->apiResponse(null, 'Not Found', 422);
    }

    public function returnSuccess($data)
    {
        return $this->apiResponse($data, 'success', 200);
    }

    public function createSuccess($data)
    {
        return $this->apiResponse($data, 'success', 201);
    }

    public function deleteSuccess()
    {
        return $this->apiResponse(true, 'success', 200);
    }

    public function unKnownError()
    {
        return $this->apiResponse(null, 'UnKnown Error', 520);
    }

    public function apiValidation($request, $array)
    {
        $rules = Validator::make($request->all(), $array);
        if ($rules->fails()) {
            return $this->apiResponse(null, $rules->errors(), 422);
        }
    }
}
