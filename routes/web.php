<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GuestController;

// TOPページ
Route::get('/', [HomeController::class, 'index'])->name('home');

// // 会員用TOPページ
// Route::get('/member', [MemberController::class, 'index'])->name('member');

// // ゲスト用TOPページ
// Route::get('/guest', [GuestController::class, 'index'])->name('guest');
