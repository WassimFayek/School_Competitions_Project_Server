<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class team extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'school_id',
        'description',
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
         return $this->belongsToMany(games::class,'games','team_one_id','team_two_id');
    }

    public function users()
    {
        return $this->belongsTo(user::class);
    }

}
