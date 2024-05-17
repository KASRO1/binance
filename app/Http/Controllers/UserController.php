<?php

namespace App\Http\Controllers;

use App\Http\Actions\User\Create;
use App\Http\Actions\User\Exist;
use App\Http\Actions\User\Login;
use App\Http\Actions\User\Logout;
use App\Http\Requests\ExistRequest;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function register(UserRequest $request)
    {
        return (new Create)->run($request);
    }

    public function login(UserRequest $request)
    {
        return (new Login)->run($request);
    }
    public function exist(ExistRequest $request)
    {
        return (new Exist)->run($request);
    }

    public function Logout()
    {
        return (new Logout)->run();
    }

}
