<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\PersonController;
use App\Http\Controllers\Api\MovieController as ApiMovieController;
use App\Http\Controllers\Api\PersonController as ApiPersonController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PagesController::class, 'index'])->name('front');

Route::get('/movies', [PagesController::class, 'movies'])->name('movies');
Route::get('/movie/{movie}', [PagesController::class, 'movie'])->name('movie.single');

Route::get('/genre/{genre}', [PagesController::class, 'genre'])->name('genre.single');

Route::get('/people', [PagesController::class, 'people'])->name('people');
Route::get('/people/{person}', [PagesController::class, 'person'])->name('person.single');

Route::middleware(['auth', 'is_admin'])->prefix('lara-admin')->group(function() {

    Route::get('/', [HomeController::class, 'index'])->name('admin');

    Route::resource('movie', MovieController::class);
    Route::resource('person', PersonController::class);

    Route::get('/medias', [MediaController::class, 'index'])->name('admin.medias');
    Route::get('/medias/create', [MediaController::class, 'create'])->name('admin.medias.create');
    Route::POST('/medias/store', [MediaController::class, 'store'])->name('admin.medias.store');

    Route::get('/account/change-password', [AccountController::class, 'changePassword'])->name('account.password.change');
    Route::post('/account/update-password', [AccountController::class, 'changePassword'])->name('account.password.update');
});

Route::get('/api/movies', [ApiMovieController::class, 'index'])->name('api.movies');
Route::get('/api/movies/genres', [ApiMovieController::class, 'genres'])->name('api.genres');
Route::get('/api/celebrities', [ApiPersonController::class, 'index'])->name('api.celebrities');
Route::get('/api/search/person', [SearchController::class, 'person'])->name('api.search.person');

Route::middleware(['auth', 'is_admin'])->prefix('admin/api')->group(function() {
    Route::post('upload', [ApiController::class, 'upload'])->name('admin.api.upload');
    Route::get('upload', [ApiController::class, 'loadImage'])->name('admin.api.load-image');
    Route::delete('upload', [ApiController::class, 'deleteImage'])->name('admin.api.delete-image');

    Route::get('gallery', [ApiController::class, 'gallery'])->name('admin.api.gallery');

    Route::get('media-manager', [ApiController::class, 'mediaManager'])->name('admin.api.media_manager');
    Route::get('media/{media}', [ApiController::class, 'media'])->name('admin.api.media');
    Route::patch('media/{media}/update', [ApiController::class, 'updateMedia'])->name('admin.api.media.update');
    Route::delete('media/{media}/delete', [ApiController::class, 'deleteMedia'])->name('admin.api.media.delete');
    Route::patch('media/{media}/resize', [ApiController::class, 'resizeImage'])->name('admin.api.media.resize');

    Route::get('image-sizes', [ApiController::class, 'imageSizes'])->name('admin.api.image_sizes');
});

require __DIR__.'/auth.php';
