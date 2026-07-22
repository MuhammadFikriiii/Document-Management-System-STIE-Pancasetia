<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'Admin Dashboard (Dalam Pengembangan)';
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:divisi'])->prefix('divisi')->group(function () {
    Route::get('/dashboard', function () {
        return 'Divisi Dashboard (Dalam Pengembangan)';
    })->name('divisi.dashboard');
    
    Route::get('/documents/{folder_id?}', [\App\Http\Controllers\DocumentController::class, 'index'])->name('divisi.documents');
    Route::post('/documents/folder', [\App\Http\Controllers\DocumentController::class, 'storeFolder'])->name('divisi.documents.storeFolder');
    Route::post('/documents/folder-upload', [\App\Http\Controllers\DocumentController::class, 'storeFolderUpload'])->name('divisi.documents.storeFolderUpload');
    Route::post('/documents/file', [\App\Http\Controllers\DocumentController::class, 'storeFile'])->name('divisi.documents.storeFile');
    Route::patch('/documents/folder/{id}', [\App\Http\Controllers\DocumentController::class, 'updateFolder'])->name('divisi.documents.updateFolder');
    Route::patch('/documents/file/{id}', [\App\Http\Controllers\DocumentController::class, 'updateFile'])->name('divisi.documents.updateFile');
    Route::delete('/documents/folder/{id}', [\App\Http\Controllers\DocumentController::class, 'destroyFolder'])->name('divisi.documents.destroyFolder');
    Route::delete('/documents/file/{id}', [\App\Http\Controllers\DocumentController::class, 'destroyFile'])->name('divisi.documents.destroyFile');
});
