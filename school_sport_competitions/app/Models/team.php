<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'description',
        'school_id',
        
    ];

    public function schools()
    {
        return $this->belongsTo(school::class);
    }

    public function players()
    {
        return $this->hasMany(player::class);
    }

    public function results()
    {
        return $this->hasMany(result::class,'winner_team_id');
    }

    public function games()
    {
    return $this->belongsToMany(team::class,'games','team_one_id','team_two_id');
    }

    public function users()
    {
        return $this->belongsTo(user::class);
    }

  
}
