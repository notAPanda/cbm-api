<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'author_photo',
    ];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function tracks()
    {
        return $this->hasManyThrough(Track::class, Album::class);
    }
}
