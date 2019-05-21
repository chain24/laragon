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

Route::middleware(['auth','master.admin'])->group(function (){
    Route::get('edit/user/{id}','UserController@edit');
    Route::post('edit/user','UserController@update');
    Route::post('upload/file', 'UploadController@upload');
    Route::post('users/import/user-xlsx','UploadController@import');
    Route::get('users/export/students-xlsx', 'UploadController@export');
//   Route::get('pdf/profile/{user_id}',function($user_id){
//     $data = App\User::find($user_id);
//     PDF::setOptions(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true]);
//     $pdf = PDF::loadView('pdf.profile-pdf', ['user' => $data]);
// 		return $pdf->stream('profile.pdf');
//   });
//   Route::get('pdf/result/{user_id}/{exam_id}',function($user_id, $exam_id){
//     $data = App\User::find($user_id);
//     $grades = App\Grade::with('exam')->where('student_id', $user_id)->where('exam_id',$exam_id)->latest()->get();
//     PDF::setOptions(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true]);
//     $pdf = PDF::loadView('pdf.result-pdf', ['grades' => $grades, 'user'=>$data]);
// 		return $pdf->stream('result.pdf');
//   });
});
