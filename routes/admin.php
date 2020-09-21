<?php

Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');

Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class,'showLoginForm'])->name('admin.login');
Route::get('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class,'showRegistrationForm'])->name('admin.register');
Route::post('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class,'create'])->name('admin.register');
