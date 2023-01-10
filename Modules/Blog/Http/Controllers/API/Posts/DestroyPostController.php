<?php

namespace Modules\Blog\Http\Controllers\API\Posts;

use app\Helpers\ApiResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Entities\User;
use Modules\Blog\Http\Resources\Posts\PostResource;

class DestroyPostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function __invoke(int $id)
    {
        $user = User::find(Auth::user()->id);

        $post = $user->posts()->findOrFail($id);

        $post->delete();

        return ApiResponse::sendSuccessResponse(
            __('messages.create_data'),
            PostResource::make($post)
        );
    }
}
