<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class votes extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'answer_id',
        'vote',
    ];
}
