<?php

use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/api/films', [FilmController::class, 'index']);
Route::get('/api/films/show/{id}', [FilmController::class, 'show']);
Route::post('/api/films/createNewFilm', [FilmController::class, 'store']);
Route::put('/api/films/update/{id}', [FilmController::class, 'update']);
Route::delete('/api/films/delete/{id}', [FilmController::class, 'destroy']);
Route::get('/api/films/search', [FilmController::class, 'search']);

Route::get('/api/vetitesek', [\App\Http\Controllers\VetitesekController::class, 'index']);
Route::get('/api/vetitesek/show/{id}', [\App\Http\Controllers\VetitesekController::class, 'show']);
Route::post('/api/vetitesek/create', [\App\Http\Controllers\VetitesekController::class, 'store']);
Route::put('/api/vetitesek/update/{id}', [\App\Http\Controllers\VetitesekController::class, 'update']);
Route::delete('/api/vetitesek/delete/{id}', [\App\Http\Controllers\VetitesekController::class, 'destroy']);
Route::get('/api/vetitesek/search', [\App\Http\Controllers\VetitesekController::class, 'search']);
