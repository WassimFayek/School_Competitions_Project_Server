<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enroll_competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'competition_id',
       
    ];
}