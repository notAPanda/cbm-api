<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TrackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/albums', [AlbumController::class, 'index']);
Route::get('/albums/{album}', [AlbumController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function() {

    Route::post('/subscription/session/create', [SubscriptionController::class, 'sessionCreate']);
    
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::get('/authors/{author}', [AuthorController::class, 'show']);
    
    Route::get('/playlists', [PlaylistController::class, 'index']);
    Route::get('/playlist/{playlist}', [PlaylistController::class, 'show']);
    
    Route::get('/tracks', [TrackController::class, 'index']);
    Route::get('/track/{track}', [TrackController::class, 'show']);
});


Route::post('/stripe/webhook', [SubscriptionController::class, 'webhook']);