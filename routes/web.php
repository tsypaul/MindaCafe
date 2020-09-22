<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}'], 'middleware' => 'setlocale'], function () {
    Route::get('/', function () {
        return view('home');
    })->name('/');

    Auth::routes();
});

Route::get('/', function () {
    return redirect(app()->getLocale());
});


Route::get('/admin', 'App\Http\Controllers\AdminController@index')->name('admin');

// Route::get('/checkout', [CheckoutController::class, 'index']);
