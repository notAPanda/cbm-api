<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_photo',
        'author_id',
    ];

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
