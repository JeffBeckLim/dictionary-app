<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    WordController,
    SearchController,
    CreateController,
    ImportController,
    RecordAudioController,
    ManageController,
    Auth\RegisteredUserController
};

//**** HOME ROUTE ****
Route::get('/', [WordController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    // **** CONTRIBUTOR ROUTE ****
    Route::get('/word/create', [CreateController::class, 'index'])->name('contribute');
    Route::post('/word/store', [CreateController::class, 'store'])->name('word.store');
    Route::get('/word/import', [ImportController::class, 'index'])->name('import');
    Route::post('/word/import/store', [ImportController::class, 'import'])->name('word.import.store');

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);



    
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('users', [RegisteredUserController::class, 'users'])->name('users');
    Route::put('/users/{id}/update', [RegisteredUserController::class, 'update'])->name('users.update');
});



// **** WORD SEARCH ROUTE ****
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/word/{id}', [SearchController::class, 'getWord'])->name('word.details');


// **** AUDIO RECORDING ROUTE ****
Route::get('/audio/{id}', [RecordAudioController::class, 'index'])->name('audio');
Route::post('/word/{id}/save-recording', [RecordAudioController::class, 'saveRecording'])->name('word.save.recording');

// **** WORD MANAGEMENT ROUTE ****
Route::middleware(['auth'])->group(function () {
    Route::get('/manage', [ManageController::class, 'index'])->name('manage');
    Route::get('/word/{id}/edit', [ManageController::class, 'edit'])->name('word.edit');
    Route::put('/word/{id}', [ManageController::class, 'update'])->name('word.update');
});

// **** AUTH ****

Route::get('/login', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/manage/suggestions', [ManageController::class, 'suggest'])->name('manage.suggest');
});


require __DIR__.'/auth.php';
