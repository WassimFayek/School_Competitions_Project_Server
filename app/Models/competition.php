<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'end_day',
        'start_day',
        'description',
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
