<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogImagesController;
use App\Http\Controllers\CKeditorImageUpload;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/blogs', [BlogController::class, 'index'])
        ->name('blogs');
    Route::resource('blogs', BlogController::class)->except(['index']);

    Route::post('/imageUpload', [CKeditorImageUpload::class, 'storeImage'])->name('imageUpload');
    Route::post('/upload-file', [BlogImagesController::class, 'storeImage']);

});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});