<?php

namespace Modules\User\Actions\Authentication;

use Modules\User\Notifications\VerifyEmailNotification;
use Illuminate\Support\Str;
use Modules\User\Entities\User;

class SendUserEmailVerificationAction
{
    public function __invoke(User $user)
    {
        $user->forceFill([
            'remember_token' => Str::random(length: 50),
        ])->save();

        $user->notify(new VerifyEmailNotification($user->remember_token));
    }
}
