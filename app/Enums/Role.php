<?php

namespace App\Enums;

enum Role: string {
 
case ADMIN = 'Admin';
case ACCOUNT_ADMIN = 'Account Admin';
case ACCOUNT_USER = 'Account User';
case ACCOUNT_API_USER = 'Account Api User';
}