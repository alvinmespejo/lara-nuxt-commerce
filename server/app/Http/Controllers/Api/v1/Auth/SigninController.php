<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\SigninRequest;
use App\Http\Resources\Api\v1\UserResourcePrivate;
use App\Http\Response\ApiResponse;
use App\Services\UserService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SigninController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }

    public function signin(SigninRequest $request): Responsable
    {
        $credentials = $request->safe()->only('email', 'password');
        if (!$token = Auth::attempt($credentials)) {
            return new ApiResponse(
                'Invalid credentials',
                code: Response::HTTP_UNAUTHORIZED
            );
        }

        return new ApiResponse(
            $this->service->respondWithToken($token),
            code: Response::HTTP_OK
        );
    }

    public function signinv2(SigninRequest $request): Responsable
    {
        $credentials = $request->safe()->only('email', 'password');
        if (!$token = Auth::attempt($credentials)) {
            return new ApiResponse(
                'Invalid credentials',
                code: Response::HTTP_UNAUTHORIZED
            );
        }

        return (new UserResourcePrivate($request->user()))
            ->additional([
                'meta' => ['token' => $token]
            ]);

        // return new ApiResponse($resource);
    }
}
