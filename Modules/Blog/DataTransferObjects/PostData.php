<?php

namespace Modules\Blog\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class PostData extends Data
{
    public function __construct(
        public string $title,
        public string $content,
    ) {}

    public static function fromRequest(Request $request): PostData
    {
        return new self(
            $request->post('title'),
            $request->post('content'),
        );
    }
}
