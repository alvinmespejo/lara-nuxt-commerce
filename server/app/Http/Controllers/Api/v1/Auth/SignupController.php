<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Dto\Api\v1\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\SignupRequest;
use App\Http\Response\ApiResponse;
use App\Http\Response\ApiResponseError;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SignupController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }

    public function signup(SignupRequest $request)
    {
        $dto = new UserDto($request->name, $request->email, $request->password);
        try {
            $this->service->store($dto);
            return new ApiResponse(code: Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return new ApiResponseError($e, code: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
