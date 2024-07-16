<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGptMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'message' => 'json',
    ];
}
