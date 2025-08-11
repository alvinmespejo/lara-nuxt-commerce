<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\UserResource;
use App\Http\Response\ApiResponse;
use App\Http\Response\ApiResponseError;
use App\Services\UserService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }

    public function me(Request $request): Responsable
    {
        return new ApiResponse(UserResource::make($request->user()), code: Response::HTTP_OK);
    }

    public function signout(Request $request): Responsable
    {
        auth('api')->logout(true);
        return new ApiResponse(null, code: Response::HTTP_NO_CONTENT);
    }

    public function refresh(Request $request): Responsable
    {
        try {
            return new ApiResponse(
                $this->service->respondWithToken(auth('api')->refresh()),
                code:Response::HTTP_OK
            );
        } catch (Throwable $e) {
            return new ApiResponseError($e);
        }
    }

}
