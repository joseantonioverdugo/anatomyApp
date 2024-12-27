<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'isAdmin'])->name('dashboard');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/about', fn () => Inertia::render('About'))->name('about');

    Route::resource('users', UserController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('flashcards', FlashcardController::class)->except(['update']);
    Route::match(['put', 'patch', 'post'], 'flashcards/{flashcard}', [FlashcardController::class, 'update'])->name('flashcards.update');
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('subcategories', SubcategoryController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/game', [UserController::class, 'game'])->name('game')->middleware(['auth','isUser']);
Route::patch('/best-score/{id}', [UserController::class, 'updateBestScore'])->name('best-score')->middleware(['auth','isUser']);
require __DIR__.'/auth.php';
