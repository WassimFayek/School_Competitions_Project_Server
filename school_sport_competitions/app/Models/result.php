<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class result extends Model
{
    use HasFactory;

    public function teams()
    {
        return $this->belongsTo(team::class);
    }

    public function games()
    {
        return $this->hasOne(game::class);
    }
}
