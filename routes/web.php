<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\requestfromterminal;
use App\Http\Livewire\Terminals;
use App\Http\Controllers\iClockController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('terminal', Terminals::class)->middleware('auth');





Route::middleware([requestfromterminal::class])->group(function(){


  // very first request from terminal when connected to network
   Route::get('/iclock/cdata', [iClockController::class,'terminalconnect']);



});
