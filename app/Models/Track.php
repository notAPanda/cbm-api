<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'album_id',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_track');
    }
}
