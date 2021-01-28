<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomainController;

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
    return view('domain.add_form');
});

Route::post('domain', DomainController::class . '@add')->name('domains.add');
Route::get('domain', DomainController::class . '@list')->name('domains.list');
Route::get('domain/{id}', DomainController::class . '@one')->name('domains.one');
