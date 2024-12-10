<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TentangController;
use App\Http\Controllers\API\BeritaController;

Route::get('api/documentation', function () {
    return view('swagger.index'); 
});


Route::prefix('tentang')->group(function () {
    Route::post('/getDataTentang', [TentangController::class, 'getDataTentang'])
        ->name('tentang.getDataTentang');
    Route::post('/getDataTentangById', [TentangController::class, 'getDataTentangById'])
        ->name('tentang.getDataTentangById');
    Route::post('/editTentang', [TentangController::class, 'editTentang'])
        ->name('tentang.editTentang');
    Route::post('/uploadFile', [TentangController::class, 'uploadFile'])
        ->name('tentang.uploadFile');
});


Route::prefix('berita')->group(function () {
    
    Route::post('/getDataBerita', [BeritaController::class, 'getDataBerita'])
        ->name('berita.getDataBerita');
    Route::post('/getDataBeritaById', [BeritaController::class, 'getDataBeritaById'])
        ->name('berita.getDataBeritaById');
    Route::post('/createBerita', [BeritaController::class, 'createBerita'])
        ->name('berita.createBerita'); 
    Route::post('/editBerita', [BeritaController::class, 'editBerita'])
        ->name('berita.editBerita');
    Route::post('/deleteBerita', [BeritaController::class, 'deleteBerita'])
        ->name('berita.deleteBerita'); 
    Route::post('/uploadFile', [BeritaController::class, 'uploadFile'])
        ->name('berita.uploadFile');
});
