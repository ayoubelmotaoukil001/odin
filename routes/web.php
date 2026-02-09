<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login') ;
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class);
});



Route::resource('links', LinkController::class);
Route::resource('tags', TagController::class)->middleware('auth');

Route::get('categories/{category}/links/create', [LinkController::class, 'create'])->name('categories.links.create');
Route::post('categories/{category}/links', [LinkController::class, 'store'])->name('categories.links.store');

Route::post('categories/{category}/links/attach', [CategoryController::class, 'attachLink'])->name('categories.links.attach');



Route::post('links/{link}/tags/attach', [LinkController::class, 'attachTag'])->name('links.tags.attach');


require __DIR__.'/auth.php';
