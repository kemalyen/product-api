<?php

namespace App\Enums;

enum ProductStatus: string
{
    case ACTIVE  = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case DISABLED = 'disabled';
}
