<?php

namespace Modules\User\Actions\Authentication;

use Modules\User\Entities\User;

class CreateUserAuthenticationTokenAction
{
    public function __invoke(User $user)
    {
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $user['token'] = $token;

        return $user;
    }
}
