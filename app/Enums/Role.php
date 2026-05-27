<?php

namespace App\Enums;

enum Role: string
{

    case ADMIN = 'Admin';
    case ACCOUNT_ADMIN = 'Account Admin';
    case ACCOUNT_USER = 'Account User';
    case ACCOUNT_API_USER = 'Account Api User';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::ACCOUNT_ADMIN => 'Account Admin',
            self::ACCOUNT_USER => 'Account User',
            self::ACCOUNT_API_USER => 'Account API User',
        };
    }
}
