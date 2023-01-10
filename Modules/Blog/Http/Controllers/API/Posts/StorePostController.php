<?php

namespace Modules\Blog\Http\Controllers\API\Posts;

use app\Helpers\ApiResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\DataTransferObjects\PostData;
use Modules\Blog\Entities\User;
use Modules\Blog\Http\Requests\Posts\StorePostRequest;
use Modules\Blog\Http\Resources\Posts\PostResource;

class StorePostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(StorePostRequest $request)
    {
        $user = User::find(Auth::user()->id);

        $postData = PostData::fromRequest($request);

        $attributes = unsetEmptyParams($postData->toArray());

        $post = $user->posts()->create($attributes);

        return ApiResponse::sendSuccessResponse(
            __('messages.create_data'),
            PostResource::make($post)
        );
    }
}
