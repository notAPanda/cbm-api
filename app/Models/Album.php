<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}