<?php

namespace Modules\Blog\Http\Controllers\Posts;

use app\Helpers\ApiResponse;
use App\Http\Resources\App\SocialNetwork\Posts\PostResource;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Http\Requests\Post\StorePostRequest;
use Modules\Post\DataTransferObjects\PostData;

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
        $user = Auth::user();

        $postData = PostData::fromRequest($request);

        $attributes = unsetEmptyParams($postData->toArray());

        $post = $user->posts()->create($attributes);

        return ApiResponse::sendSuccessResponse(
            __('messages.create_data'),
            PostResource::make($post)
        );
    }
}
