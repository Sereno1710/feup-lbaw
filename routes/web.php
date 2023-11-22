<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/users/search', [UserController::class, 'search']);

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::match(['post', 'put'], '/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/users', [AdminController::class, 'getUsers'])->name('admin.users');
Route::post('/admin/users/demote', [AdminController::class, 'demote'])->name('admin.demote');
Route::post('/admin/users/promote', [AdminController::class, 'promote'])->name('admin.promote');
Route::post('/admin/users/disable', [AdminController::class, 'disable'])->name('admin.disable');
Route::get('/admin/transfers', [AdminController::class, 'getTransfers'])->name('admin.transfers');
Route::post('/admin/transfers/approve', [AdminController::class, 'approve'])->name('admin.approve');
Route::post('/admin/transfers/reject', [AdminController::class, 'reject'])->name('admin.reject');
Route::get('/admin/auctions', [AdminController::class, 'getAuctions'])->name('admin.auctions');


// API
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
});


// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});
