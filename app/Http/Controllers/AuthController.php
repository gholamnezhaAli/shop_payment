<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\AuthUserRepo;

class AuthController extends ApiController
{

    private $userRepo;

    public function __construct(AuthUserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    public function register(UserRegisterRequest $request)
    {

        $user = $this->userRepo->registerUser($request);
        $token = $user->createToken("myApp")->accessToken;


        return $this->successResponse(201, [
            "user" => new UserResource($user),
            "token" => $token,
        ], "user created successfully");

    }

    public function login(UserLoginRequest $request)
    {


        if (!auth()->attempt($request->all())) {

            return $this->errorResponse(401, "your data is incorrect");
        }

        $token = auth()->user()->createToken("myApp")->accessToken;

        return $this->successResponse(200, [
            "user" => new UserResource(auth()->user()),
            "token" => $token,
            "expireTime" => 1,
        ], "user login successfully ");


    }


}
