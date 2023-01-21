<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChallengeController;
use App\Models\Challenge;

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
    return view('challenge');
}); 
Route::post('/send', [ChallengeController::class, 'activity'])->name('send');
