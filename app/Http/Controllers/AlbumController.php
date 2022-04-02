<?php

namespace App\Http\Controllers;



use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $albums = Album::with(['author', 'tracks'])->get();

        return [
            "albums" => $albums,
            "user" => auth()->user(),
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
        $album->load(['tracks', 'author']);

        return [
            "album" => $album,
        ];
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
