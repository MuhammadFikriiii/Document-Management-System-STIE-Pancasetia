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
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Division Management (CRUD)
    Route::get('/divisions', [\App\Http\Controllers\AdminController::class, 'divisions'])->name('admin.divisions');
    Route::post('/divisions', [\App\Http\Controllers\AdminController::class, 'storeDivision'])->name('admin.divisions.store');
    Route::patch('/divisions/{division}', [\App\Http\Controllers\AdminController::class, 'updateDivision'])->name('admin.divisions.update');
    Route::delete('/divisions/{division}', [\App\Http\Controllers\AdminController::class, 'destroyDivision'])->name('admin.divisions.destroy');

    // User Management (CRUD)
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::post('/users', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::patch('/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::patch('/users/{user}/toggle-active', [\App\Http\Controllers\AdminController::class, 'toggleActive'])->name('admin.users.toggleActive');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.users.destroy');

    // Documents (Admin view all divisions)
    Route::get('/documents/{folder_id?}', [\App\Http\Controllers\DocumentController::class, 'index'])->name('admin.documents');
    Route::get('/trash', [\App\Http\Controllers\DocumentController::class, 'trash'])->name('admin.trash');

    // Audit Log
    Route::get('/logs', [\App\Http\Controllers\AdminController::class, 'auditLog'])->name('admin.logs');
});

Route::middleware(['auth', 'role:admin,divisi'])->prefix('divisi')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DocumentController::class, 'divisiDashboard'])->name('divisi.dashboard');


    // Phase 2: Specific GET routes MUST come before the wildcard {folder_id?} route
    Route::get('/documents/download/file/{id}', [\App\Http\Controllers\DocumentController::class, 'downloadFile'])->name('divisi.documents.downloadFile');
    Route::get('/documents/download/folder/{id}', [\App\Http\Controllers\DocumentController::class, 'downloadFolderZip'])->name('divisi.documents.downloadFolderZip');
    Route::get('/documents/preview/file/{id}', [\App\Http\Controllers\DocumentController::class, 'previewFile'])->name('divisi.documents.previewFile');
    Route::get('/trash', [\App\Http\Controllers\DocumentController::class, 'trash'])->name('divisi.trash');

    // Wildcard route (must be LAST among GET /documents routes)
    Route::get('/documents/{folder_id?}', [\App\Http\Controllers\DocumentController::class, 'index'])->name('divisi.documents');

    Route::post('/documents/folder', [\App\Http\Controllers\DocumentController::class, 'storeFolder'])->name('divisi.documents.storeFolder');
    Route::post('/documents/folder-upload', [\App\Http\Controllers\DocumentController::class, 'storeFolderUpload'])->name('divisi.documents.storeFolderUpload');
    Route::post('/documents/file', [\App\Http\Controllers\DocumentController::class, 'storeFile'])->name('divisi.documents.storeFile');
    Route::patch('/documents/folder/{id}', [\App\Http\Controllers\DocumentController::class, 'updateFolder'])->name('divisi.documents.updateFolder');
    Route::patch('/documents/file/{id}', [\App\Http\Controllers\DocumentController::class, 'updateFile'])->name('divisi.documents.updateFile');
    Route::patch('/documents/move/folder/{id}', [\App\Http\Controllers\DocumentController::class, 'moveFolder'])->name('divisi.documents.moveFolder');
    Route::patch('/documents/move/file/{id}', [\App\Http\Controllers\DocumentController::class, 'moveFile'])->name('divisi.documents.moveFile');
    Route::delete('/documents/folder/{id}', [\App\Http\Controllers\DocumentController::class, 'destroyFolder'])->name('divisi.documents.destroyFolder');
    Route::delete('/documents/file/{id}', [\App\Http\Controllers\DocumentController::class, 'destroyFile'])->name('divisi.documents.destroyFile');

    // Trash actions
    Route::post('/trash/restore/folder/{id}', [\App\Http\Controllers\DocumentController::class, 'restoreFolder'])->name('documents.trash.restoreFolder');
    Route::post('/trash/restore/file/{id}', [\App\Http\Controllers\DocumentController::class, 'restoreFile'])->name('documents.trash.restoreFile');
    Route::delete('/trash/force/folder/{id}', [\App\Http\Controllers\DocumentController::class, 'forceDeleteFolder'])->name('documents.trash.forceFolder');
    Route::delete('/trash/force/file/{id}', [\App\Http\Controllers\DocumentController::class, 'forceDeleteFile'])->name('documents.trash.forceFile');
    Route::delete('/trash/empty', [\App\Http\Controllers\DocumentController::class, 'emptyTrash'])->name('documents.trash.empty');
});


