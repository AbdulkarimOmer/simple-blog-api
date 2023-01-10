<?php

namespace Modules\User\DataTransferObjects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    public static function fromRequest(Request $request): UserData
    {
        return new self(
            $request->post('name'),
            $request->post('email'),
            Hash::make($request->post('password')),
        );
    }
}
