<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchUsers extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'user_id_to',
        'user_id_from',
        'status',
        'requested_at',
        'replied_at',
    ];


}
