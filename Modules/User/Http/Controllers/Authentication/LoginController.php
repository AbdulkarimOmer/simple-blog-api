<?php

namespace Modules\User\Http\Controllers\Authentication;

use ApiResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Actions\Authentication\CreateUserAuthenticationTokenAction;
use Modules\User\Actions\Authentication\SendUserEmailVerificationAction;
use Modules\User\Http\Requests\Authentication\LoginRequest;
use Modules\User\Http\Resources\Authentication\AuthenticationResource;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {

                (new SendUserEmailVerificationAction)($user);

                return ApiResponse::sendFailedResponse(
                    __('auth.verify_email'),
                    null,
                    403
                );
            }

            $user = (new CreateUserAuthenticationTokenAction())($user);


            return ApiResponse::sendSuccessResponse(
                __('auth.success_login'),
                AuthenticationResource::make($user)
            );
        }

        return ApiResponse::sendFailedResponse(
            __('auth.failed'),
            null,
            401
        );
    }
}
