<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class player extends Model
{
    use HasFactory;

    protected $fillable = [
        'age',
        'file',
        'class',
        'gender',
        'team_id',
        'last_name',
        'school_id',
        'first_name',
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


