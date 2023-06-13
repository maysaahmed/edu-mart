<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Transformers\UserResource;
use Modules\Users\Core\User\Queries\GetUserPagination;

class UsersController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param GetUserPagination\IGetUserPagination $query
     * @return JsonResponse
     */
    public function index(Request $request,GetUserPagination\IGetUserPagination $query): JsonResponse
    {
        try {
            $organization_id = request()->user()->organization_id;
            $queryModel = GetUserPagination\GetUserPaginationModel::from($request->all()+['org_id' => $organization_id]);
            $pagination = $query->execute($queryModel);

            return $this->paginationResponse(UserResource::class,$pagination);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('users::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('users::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
