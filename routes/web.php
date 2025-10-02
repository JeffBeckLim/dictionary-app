<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    WordController,
    SearchController,
    CreateController,
    ImportController
};

//**** HOME ROUTE ****
Route::get('/', [WordController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    // **** CONTRIBUTOR ROUTE ****
    Route::get('/word/create', [CreateController::class, 'index'])->name('contribute');
    Route::post('/word/store', [CreateController::class, 'store'])->name('word.store');
    Route::get('/word/import', [ImportController::class, 'index'])->name('import');
    Route::post('/word/import/store', [ImportController::class, 'import'])->name('word.import.store');
});

// **** WORD SEARCH ROUTE ****
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/word/{id}', [SearchController::class, 'getWord'])->name('word.details');

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
