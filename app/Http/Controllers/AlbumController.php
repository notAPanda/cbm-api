<?php

namespace App\Http\Controllers;



use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $albums = Album::with(['author', 'tracks'])
            ->when(!$user, function ($q) {
                $q->limit(5);
            })
            ->get();

        return [
            "albums" => $albums,
            "user" => auth()->user(),
        ];
    }

    public function free_index()
    {
        $albums = Album::with(['author', 'tracks'])->limit(5)->get();

        return [
            "albums" => $albums,
            "user" => auth()->check()
        ];
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Album $album)
    {
        return $album;
    }

    public function edit(Album $album)
    {
        //
    }

    public function update(Request $request, Album $album)
    {
        //
    }

    public function destroy(Album $album)
    {
        //
    }
}
