<?php /** @noinspection PhpUndefinedClassInspection */

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

Route::get('/', 'AuthController@showFormLogin')->name('login');
Route::get('login', 'AuthController@showFormLogin')->name('login');
Route::post('login', 'AuthController@login');
Route::get('register', 'AuthController@showFormRegister')->name('register');
Route::post('register', 'AuthController@register');
Route::get('forgot-password', 'AuthController@forgotPassword')->name('forgot-password');

Route::group(['middleware' => 'auth'], function () {

    Route::get('inbox', 'HomeController@index')->name('inbox');
    Route::get('inbox/search', 'HomeController@search')->name('search');
    Route::get('sent', 'HomeController@sent')->name('letter-sent');
    Route::get('sent/search', 'HomeController@sent_search')->name('sent-search');
    Route::get('compose', 'HomeController@compose')->name('compose');
    Route::get('files', 'HomeController@files')->name('letter-files');
    Route::get('detail/{id}', 'HomeController@detail')->name('detail');
    Route::get('detail/file/{id}/{filename}', 'FileController@download')->name('download');
    Route::get('logout', 'AuthController@logout')->name('logout');
    Route::post('send-letter', 'LetterController@send')->name('send-letter');
    Route::post('manage-letter', 'LetterController@manage')->name('manage-letter');
    Route::post('discuss-letter', 'LetterController@discuss')->name('discuss-letter');
    Route::get('notification/{id}', 'NotificationController@getnotif')->name('get-notif');
    Route::get('user-management', 'AdminController@users')->name('user-management');
    Route::get('user-management/detail/{id}', 'AdminController@user_detail')->name('user-detail');
    Route::post('user-update', 'AdminController@user_update')->name('user-update');
    Route::get('user-management/new', 'AdminController@new_user')->name('user-new');
    Route::post('user-create', 'AdminController@user_create')->name('user-create');
    Route::get('profil', 'HomeController@profil')->name('profil');
    Route::post('profil-update', 'HomeController@profil_update')->name('profil-update');
});
