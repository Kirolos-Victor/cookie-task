<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth')->get('buy/{cookies}', function ($cookies) {
    $user = Auth::user();
    if($user->wallet < $cookies)
    {
        return "Sorry you don't have enough balance in your wallet";
    }
    elseif ($cookies ==0)
    {
        return "Please enter a number above 0 :)";
    }
    $new_amount = $user->wallet - $cookies;
    $user->update(['wallet' => $new_amount]);
    Log::info('User ' . $user->email . ' have bought ' . $cookies . ' cookies'); // we need to log who ordered and how much
    return 'Success, you have bought ' . $cookies . ' cookies!';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
