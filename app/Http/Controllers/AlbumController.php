<?php

namespace App\Http\Controllers;



use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        return Album::with(['author', 'tracks'])->get();
    }

    public function free_index()
    {
        return Album::with(['author', 'tracks'])->limit(5)->get();
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
