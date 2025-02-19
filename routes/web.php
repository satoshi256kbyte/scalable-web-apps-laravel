<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GuestController;

// TOPページ
Route::get('/', [HomeController::class, 'top'])->name('top');

// 会員用TOPページ
Route::get('/member', [MemberController::class, 'member_top'])->name('member.top');

// ゲスト用TOPページ
Route::get('/guest', [GuestController::class, 'guest_top'])->name('guest.top');
