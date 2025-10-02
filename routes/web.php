<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    WordController,
    SearchController,
    CreateController,
    ImportController
};

//**** HOME ROUTE ****
Route::get('/', [WordController::class, 'index'])->name('home');



// **** CONTRIBUTOR ROUTE ****
Route::get('/word/create', [CreateController::class, 'index'])->name('contribute');
Route::post('/word/store', [CreateController::class, 'store'])->name('word.store');
Route::get('/word/import', [ImportController::class, 'index'])->name('import');
Route::post('/word/import/store', [ImportController::class, 'import'])->name('word.import.store');


// **** WORD SEARCH ROUTE ****
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/word/{id}', [SearchController::class, 'getWord'])->name('word.details');
