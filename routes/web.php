<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

Route::get('/upload', [PhotoController::class, 'create'])->name('photos.create');
Route::get('/photos', [PhotoController::class, 'index'])->name('photos.index');
Route::post('/upload-single', [PhotoController::class, 'storeSingle'])->name('photos.storeSingle');
Route::post('/upload-multiple', [PhotoController::class, 'storeMultiple'])->name('photos.storeMultiple');
Route::delete('/photos/{id}', [PhotoController::class, 'destroy'])->name('photos.destroy');