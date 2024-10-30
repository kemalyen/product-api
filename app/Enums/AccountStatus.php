<?php

namespace App\Enums;

enum AccountStatus: string {
    case ACTIVE  = 'active';
    case PENDING = 'pending';
    case DISABLED = 'disabled';
}