<?php

namespace Modules\Blog\Http\Controllers\API\Posts;

use app\Helpers\ApiResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Blog\Entities\Post;
use Modules\Blog\Http\Resources\Posts\PostResource;

class ShowPostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id)
    {
        $post = Post::findOrFail($id);

        return ApiResponse::sendSuccessResponse(
            __('messages.get_data'),
            PostResource::make($post)
        );
    }
}
