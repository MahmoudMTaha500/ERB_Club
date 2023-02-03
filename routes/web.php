<?php

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

Route::get('/', "App\Http\Controllers\LoginController@index");



Route::resource('login',"App\Http\Controllers\LoginController");


Route::group(['prefix' => 'admin', 'middleware' => ['adminMiddleware']], function() {

    Route::get('/', function () {
        return view('Dashboard.dashboard');
    })->name('admin');
/*
 *  Ajax Route
 * */

    route::get('get-sports', "\App\Http\Controllers\LevelsController@getSports")->name('get-sports');
    route::get('get-price-list', "\App\Http\Controllers\PackagesController@getPriceList")->name('get-price-list');
    route::get('get-price', "\App\Http\Controllers\PackagesController@getPrice")->name('get-price');


    #################################################.
    route::get('/file/delete/{id}',"\App\Http\Controllers\PlayersController@deleteFiles");
    ################################################


    Route::resource('branch', "\App\Http\Controllers\BranchesController");
    Route::resource('sport', "\App\Http\Controllers\SportsController");
    Route::resource('level', "\App\Http\Controllers\LevelsController");
    Route::resource('price-list', "\App\Http\Controllers\PriceListController");
    Route::resource('package', "\App\Http\Controllers\PackagesController");
    Route::resource('receipt', "\App\Http\Controllers\ReceiptsController");
    Route::resource('employee', "\App\Http\Controllers\EmployeesController");
    Route::resource('player', "\App\Http\Controllers\PlayersController");

Route::get('logout',"App\Http\Controllers\LoginController@logout")->name('logout');
});

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
