<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class school extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_name',
        'school_address',
        'school_phone',
       
    ];

public function players()
{
    return $this->hasMany(player::class);
}

public function user()
{
    return $this->hasMany(User::class);
}

public function teams()
{
    return $this->hasMany(team::class);
}

public function competitions()
{
    return $this->hasMany(competition::class);
}
}
