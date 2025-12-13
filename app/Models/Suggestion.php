<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = [
        'name', 'email', 'message', 'ip_address', 'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];
}