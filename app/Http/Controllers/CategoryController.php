<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Http\Controllers\jsonResponse;
use App\Http\Resources\CategoryCollectionResource;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends ApiController
{

    private $validation_rules = [
        'name' => 'required|string'
    ];

    public function index() {
        try {
            $items = Category::paginate(10);
            return $this->successResponse(CategoryCollectionResource::collection($items));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * store category data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validation_rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            try {
                $category = Category::create([
                    "name" => $request->name
                ]);
                return $this->successResponse(new CategoryResource($category),'Data saved successfully!' , Response::HTTP_CREATED);

            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * update one category
     * @param $id
     * @param Request $request
     * @return \App\Http\Controllers\jsonResponse
     */
    public function update($id, Request $request)
    {

        $validator = $this->getValidationFactory()->make(['id' => $id, 'name' => $request->name], ['id' => 'required|numeric|exists:categories', 'name' => 'required|string']);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            try {
                $item = Category::findOrFail($id);

                if ($item->update($request->all())) {
                    $this->response['message'] = 'Data updated successfully!';
                    return $this->successResponse(new CategoryResource($item),'Data updated successfully!' , Response::HTTP_ACCEPTED);

                } else {
                    return $this->errorResponse('Data failed to update!', Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

    }


    /**
     * delete one category
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $validator = $this->getValidationFactory()->make(['id' => $id], ['id' => 'required|numeric|exists:categories']);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            try {
                $item = Category::find($id);
                if ($item->delete()) {
                    return $this->successResponse([],'Data removed successfully!' , Response::HTTP_OK);
                } else {
                    return $this->errorResponse('Data failed to remove!', Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } catch (\Throwable $th) {
                return $this->errorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

    }
}
