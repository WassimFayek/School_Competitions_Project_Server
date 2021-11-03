<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class player extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'class',
        'age',
        'file',
        'school_id',
        'team_id',
    ];

    public function schools()
    {
        return $this->belongsTo(school::class);
    }

    public function teams()
    {
        return $this->belongsTo(team::class);
    }

}


