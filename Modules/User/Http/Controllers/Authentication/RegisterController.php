<?php

namespace Modules\User\Http\Controllers\Authentication;

use app\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\User\Actions\Authentication\CreateUserAuthenticationTokenAction;
use Modules\User\Actions\Authentication\SendUserEmailVerificationAction;
use Modules\User\DataTransferObjects\UserData;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\Authentication\RegisterRequest;
use Modules\User\Http\Resources\Authentication\AuthenticationResource;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $userData = UserData::fromRequest($request);

        try {
            DB::beginTransaction();

            $user = User::query()->create($userData->toArray())->fresh();

            // (new SendUserEmailVerificationAction)($user);

            $user = (new CreateUserAuthenticationTokenAction())($user);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        return ApiResponse::sendSuccessResponse(
            __('auth.thanks_signup'),
            AuthenticationResource::make($user)
        );
    }
}
