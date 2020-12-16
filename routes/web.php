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


Route::get('/iclock/cdata', [iClockController::class,'CDataGET']);
Route::post('/iclock/cdata', [iClockController::class,'CDataPOST']);

/*
 Route::get('/iclock/getrequest', [iClockController::class,'GetRequest']);
 Route::post('/iclock/getrequest', [iClockController::class,'GetRequest']);

 Route::get('/iclock/push', [iClockController::class,'Push']);
 Route::post('/iclock/push', [iClockController::class,'Push']);

 Route::get('/iclock/devicecmd', [iClockController::class,'DeviceCmd']);
 Route::post('/iclock/devicecmd', [iClockController::class,'DeviceCmd']);
*/
