<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_day',
        'end_day',
     
    ];

    public function schools()
    {
        return $this->belongsTo(school::class);
    }

    public function games()
    {
        return $this->hasMany(game::class);
    }
}
