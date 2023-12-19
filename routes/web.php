<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\MailController;

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
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/home', 'index')->name('home');
    Route::get('/search', 'search')->name('search');
});

// Users
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

// Profile
Route::get('/profile', [UserController::class, 'show'])->name('profile');
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::match(['post', 'put'], '/profile/update', [UserController::class, 'update'])->name('profile.update');
Route::get('/user/{userId}', [UserController::class, 'showProfile'])->name('profile.show');
Route::post('/profile/delete', [UserController::class, 'delete'])->name('profile.delete');

// Balance
Route::get('/balance', [BalanceController::class, 'index'])->name('balance');
Route::post('/balance/withdraw', [BalanceController::class, 'withdraw'])->name('balance.withdraw');
Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');
Route::post('/balance/deposit', [StripeController::class, 'deposit'])->name('deposit.stripe');
Route::get('/success/{depositAmount}', [StripeController::class, 'success'])->name('success');

// Footer
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('aboutUs');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/contacts', [HomeController::class, 'contacts'])->name('contacts');
Route::get('/terms-of-use', [HomeController::class, 'termsOfUse'])->name('termsOfUse');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacyPolicy');

// Auction
Route::controller(AuctionController::class)->group(function () {
    Route::get('/auctions', 'showActiveAuctions');
    Route::get('/auction/submit', 'showAuctionForm');
    Route::get('/auction/search','search')->name('auction.search');
    Route::post('/auction/create', 'createAuction')->name('auction.create');
    Route::post('/auction/follow', 'followAuction')->name('auction.follow');
    Route::post('/auction/unfollow', 'unfollowAuction')->name('auction.unfollow');
    Route::get('/auction/{id}', 'showAuction');
    Route::post('/auction/{id}/bid', 'bidOnAuction');
    Route::post('/auction/{id}/start', 'startAuction');
    Route::post('/auction/{id}/rate', 'rateAuction');
    Route::post('/auction/{id}/report', 'reportAuction')->name('auction.report');
    Route::post('/auction/{id}/comment/create', 'commentOnAuction')->name('auction.comment.create');
    Route::post('/auction/{auction}/comment/{comment}/delete', 'deleteCommentOnAuction')->name('auction.comment.delete');
});

// Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/users', [AdminController::class, 'getUsers'])->name('admin.users');
Route::post('/admin/users/demote', [AdminController::class, 'demote'])->name('admin.demote');
Route::post('/admin/users/promote', [AdminController::class, 'promote'])->name('admin.promote');
Route::post('/admin/users/disable', [AdminController::class, 'disable'])->name('admin.disable');
Route::post('/admin/users/ban', [AdminController::class, 'ban'])->name('admin.ban');
Route::post('/admin/users/unban', [AdminController::class, 'unban'])->name('admin.unban');

Route::get('/admin/transfers/withdrawals', [AdminController::class, 'getTransfers'])->name('admin.transfers.withdrawals');
Route::get('/admin/transfers/completed', [AdminController::class, 'getTransfers'])->name('admin.transfers.completed');
Route::post('/admin/transfers/approve', [AdminController::class, 'approve'])->name('admin.approve');
Route::post('/admin/transfers/reject', [AdminController::class, 'reject'])->name('admin.reject');

Route::get('/admin/auctions/pending', [AdminController::class, 'getAuctions'])->name('admin.auctions.pending');
Route::get('/admin/auctions/active', [AdminController::class, 'getAuctions'])->name('admin.auctions.active');
Route::get('/admin/auctions/others', [AdminController::class, 'getAuctions'])->name('admin.auctions.others');
Route::post('/admin/auctions/approve', [AdminController::class, 'approveAuction'])->name('admin.approveAuction');
Route::post('/admin/auctions/reject', [AdminController::class, 'rejectAuction'])->name('admin.rejectAuction');
Route::post('/admin/auctions/pause', [AdminController::class, 'pauseAuction'])->name('admin.pauseAuction');
Route::post('/admin/auctions/resume', [AdminController::class, 'resumeAuction'])->name('admin.resumeAuction');
Route::post('/admin/auctions/disable', [AdminController::class, 'disableAuction'])->name('admin.disableAuction');

Route::get('admin/reports/listed', [AdminController::class, 'getReports'])->name('admin.getlisted');
Route::get('admin/reports/reviewed', [AdminController::class, 'getReports'])->name('admin.getreviewed');
Route::post('admin/reports/update', [AdminController::class, 'reviewReport'])->name('admin.reviewReport');

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/recoverpassword', 'indexRecoverPassword')->name('password.recover');
    Route::get('/login/google', 'redirectToGoogle')->name('login.google');
    Route::get('/login/google/callback', 'handleGoogleCallback');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/dateofbirth', 'showDateOfBirth')->name('show.dateofbirth')->middleware('can:accessDateOfBirth,App\Models\User');;
    Route::post('/dateofbirth', 'updateDateOfBirth')->name('update.dateofbirth');
});

// Email
Route::post('/recoverpassword/send', [MailController::class, 'send'])->name('password.sendmail');
