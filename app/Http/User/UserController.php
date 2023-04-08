<?php

namespace App\Http\User;

use App\Http\Controllers\Controller;
use App\Core\User\Commands\CreateUser\ICreateUser;
use App\Core\User\Queries\GetUserPagination\IGetUserPagination;
use Illuminate\Http\RedirectResponse;
//use Inertia\Response;
//use Laravel\Jetstream\Jetstream;

class UserController extends Controller
{
    public function index(GetUserPaginationRequest $request, IGetUserPagination $query): Response
    {
        $pagination = $query->execute($request->data());

        return Jetstream::inertia()->render($request, 'Home', [
            'pagination' => $pagination
        ]);
    }

    public function store(CreateUserRequest $request, ICreateUser $command): RedirectResponse
    {
        $command->execute($request->data());
        return redirect()->route('home');
    }
}
