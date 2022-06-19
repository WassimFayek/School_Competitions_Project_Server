<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
