<?php

namespace Modules\Blog\Http\Controllers\API\Posts;

use app\Helpers\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Blog\Entities\Post;
use Modules\Blog\Http\Resources\Posts\PostsResource;

class IndexPostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request,)
    {
        $sort = $request->input('sort') ?? 'desc';

        $orderBy = $request->input('orderBy') ?? 'created_at';

        $perPage = $request->input('perPage') ?? 10;

        $query = Post::query()->when(
            $request->input('search_text'),
            fn (Builder $builder) => $builder
                ->where('title', 'ilike', "%{$request->input('search_text')}%")
                ->orWhere('content', 'ilike', "%{$request->input('search_text')}%")
        );

        $posts = PostsResource::collection(
            $query->orderBy($orderBy, $sort)->paginate($perPage)
        )->appends($request->query())->toArray();


        return ApiResponse::sendSuccessResponse(
            __('messages.get_data'),
            $posts
        );
    }
}
