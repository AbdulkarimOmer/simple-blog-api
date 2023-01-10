<?php

namespace Modules\User\Http\Controllers\Authentication;

use app\Helpers\ApiResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class LogoutController extends Controller
{
    /**
     * Handle the Login request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var PersonalAccessToken $accessToken */
        $accessToken = Auth::user()->currentAccessToken();
        $accessToken->delete();

        return ApiResponse::sendSuccessResponse(
            __('auth.logout'),
            null,
            204
        );
    }
}
