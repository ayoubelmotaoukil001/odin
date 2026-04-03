<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkShareController;
use App\Http\Controllers\Admin\ActivityLogController;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Soft Deletes & Trash Management
    Route::get('links/trash', [LinkController::class, 'trash'])->name('links.trash');
    Route::post('links/{id}/restore', [LinkController::class, 'restore'])->name('links.restore');
    Route::delete('links/{id}/force', [LinkController::class, 'forceDelete'])->name('links.forceDelete');

    // Favorite System (US-12)
    Route::post('/links/{link}/favorite', [LinkController::class, 'toggleFavorite'])->name('links.favorite');
    Route::get('/favorites', [LinkController::class, 'favorites'])->name('links.favorites');

    // Main Resources
    Route::resource('links', LinkController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);

    // Categories & Links Relationships
    Route::get('categories/{category}/links/create', [LinkController::class, 'create'])->name('categories.links.create');
    Route::post('categories/{category}/links', [LinkController::class, 'store'])->name('categories.links.store');
    Route::post('categories/{category}/links/attach', [CategoryController::class, 'attachLink'])->name('categories.links.attach');
    
    // Tags Relationships
    Route::post('links/{link}/tags/attach', [LinkController::class, 'attachTag'])->name('links.tags.attach');
    
    // Sharing System
    Route::post('/links/{link}/share', [LinkShareController::class, 'share'])->name('links.share');
    Route::get('/shared-links', [LinkShareController::class, 'sharedWithMe'])->name('links.shared');

    // Admin Access Logs
    Route::get('/admin/logs', [ActivityLogController::class, 'index'])->name('admin.logs');
});

require __DIR__.'/auth.php';