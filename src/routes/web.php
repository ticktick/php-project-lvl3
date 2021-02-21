<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;

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

require_once __DIR__ . '/../vendor/autoload.php';

Route::get('/', function () {
    return view('urls.add_form');
});

Route::post('urls', UrlController::class . '@add')->name('urls.add');
Route::get('urls', UrlController::class . '@list')->name('urls.list');
Route::get('urls/{id}', UrlController::class . '@one')->name('urls.one');
Route::post('urls/{id}/checks', UrlController::class . '@makeCheck')->name('urls.makeCheck');
