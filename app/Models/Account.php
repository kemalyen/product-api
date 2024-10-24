<?php

namespace App\Models;

use App\Enums\AccountStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'account_number', 'status'];

    protected $casts = [
        'role' => AccountStatus::class,
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
