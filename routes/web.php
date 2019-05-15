<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('create-school', 'SchoolController@index')->middleware('master.admin');

Route::middleware(['auth','master'])->group(function (){
    Route::get('register/admin/{id}/{code}', function($id, $code){
        session([
            'register_role' => 'admin',
            'register_school_id' => $id,
            'register_school_code' => $code,
        ]);
        return redirect()->route('register');
    });
    Route::post('register/admin', 'UserController@storeAdmin');
    Route::get('master/activate-admin/{id}','UserController@activateAdmin');
    Route::get('master/deactivate-admin/{id}','UserController@deactivateAdmin');
    Route::post('create-school', 'SchoolController@store');
    Route::get('school/admin-list/{school_id}','SchoolController@show');
});
