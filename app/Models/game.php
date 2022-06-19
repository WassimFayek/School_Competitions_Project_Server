<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class game extends Model
{
    use HasFactory;

    public function competitions()
    {
        return $this->belongsTo(competition::class);
    }

    public function results()
    {
        return $this->hasOne(result::class);
    }

    public function teams()
    {
        return $this->hasMany(team::class,'id','id');
    }
   
}
