<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TentangController;
use App\Http\Controllers\API\BeritaController;
use App\Http\Controllers\API\BeritaControllers;
use App\Http\Controllers\API\TentangControllers;

Route::get('api/documentation', function () {
    return view('swagger.index'); 
});


Route::prefix('tentang')->group(function () {
    Route::post('/getDataTentang', [TentangControllers::class, 'getDataTentang'])
        ->name('tentang.getDataTentang');
    Route::post('/getDataTentangById', [TentangControllers::class, 'getDataTentangById'])
        ->name('tentang.getDataTentangById');
    Route::post('/editTentang', [TentangControllers::class, 'editTentang'])
        ->name('tentang.editTentang');
    Route::post('/uploadFile', [TentangControllers::class, 'uploadFile'])
        ->name('tentang.uploadFile');
});


Route::prefix('berita')->group(function () {
    
    Route::post('/getDataBerita', [BeritaControllers::class, 'getDataBerita'])
        ->name('berita.getDataBerita');
    Route::post('/getDataBeritaById', [BeritaControllers::class, 'getDataBeritaById'])
        ->name('berita.getDataBeritaById');
    Route::post('/createBerita', [BeritaControllers::class, 'createBerita'])
        ->name('berita.createBerita'); 
    Route::post('/editBerita', [BeritaControllers::class, 'editBerita'])
        ->name('berita.editBerita');
    Route::post('/deleteBerita', [BeritaControllers::class, 'deleteBerita'])
        ->name('berita.deleteBerita'); 
    Route::post('/uploadFile', [BeritaControllers::class, 'uploadFile'])
        ->name('berita.uploadFile');
});
