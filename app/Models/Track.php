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
        'duration',
        'access_group',
    ];

    protected $hidden = [
        'access_group',
        'url',
    ];

    protected $appends = [
        'src',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_track');
    }

    public function getSrcAttribute() {
        $user = request()->user();

        if ($this->access_group === 'free') {
            return $this->url;
        }

        if ($this->access_group === 'login' && $user) {
            return $this->url;
        }
        
        if ($user && $user->premium && $this->access_group === 'premium') {
            return $this->url;
        }

        return null;
    }
}
