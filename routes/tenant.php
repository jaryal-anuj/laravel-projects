<?php

use App\Tenant\Manager;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/test',function(){
   dd(app(Manager::class)->getTenant());
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
