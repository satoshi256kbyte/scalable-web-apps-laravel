<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GuestController;

// TOPページ
Route::get('/top', [HomeController::class, 'top'])->name('top');

// 会員用TOPページ
Route::get('/member/top', [MemberController::class, 'top'])->name('member.top');

// ゲスト用TOPページ
Route::get('/guest/top', [GuestController::class, 'top'])->name('guest.top');
