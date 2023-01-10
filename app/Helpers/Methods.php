<?php

use Illuminate\Support\Facades\Hash;


function defaultHashedPassword(): string
{
    return Hash::make('123456');
}

function unsetEmptyParams(array $data): array
{
    foreach ($data as $key => $value) {
        if (isset($key) && is_null($value)) {
            unset($data[$key]);
        }
    }

    return $data;
}
