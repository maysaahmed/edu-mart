<?php

namespace App\Http\Controllers;
use App\Models\Level;
use App\Http\Controllers\jsonResponse;
use App\Http\Resources\LevelResource;
use Symfony\Component\HttpFoundation\Response;

class LevelController extends ApiController
{

    public function index() {
        try {
            $items = Level::paginate(10);
            return $this->successResponse(LevelResource::collection($items));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
