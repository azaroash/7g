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

Route::get('/SelectRegistration', function () {
    return view('registerSelect');
})->name('SelectRegistration');
Route::get('/SelectLogin', function (){
    return view('loginSelect');
})->name('SelectLogin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('user/activation/{token}', 'Auth\RegisterController@userActivation')->name('user.activate');
Route::get('client/activation/{token}', 'Auth\RegisterClientController@clientActivation')->name('client.activate');

Route::get('users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('client')->group(function() {
    Route::get('/login', 'Auth\ClientLoginController@showLoginForm')->name('client.login');
    Route::post('/login', 'Auth\ClientLoginController@login')->name('client.login.submit');
    Route::get('/', 'ClientController@index')->name('client.dashboard');
    Route::post('/', 'ClientController@store')->name('client.register.purchase');
    Route::get('/logout', 'Auth\ClientLoginController@logout')->name('client.logout');
    Route::get('/register', 'Auth\RegisterClientController@showRegistrationForm')->name('client.register');
    Route::post('/register', 'Auth\RegisterClientController@register')->name('client.register.submit');
    Route::get('/getUserData', 'ClientController@getUserData')->name('getUserData');

});
Route::get('registerPurchase', 'RegisterPurchaseController@index')->name('registerPurchase');

Route::get('userMarkRead', 'HomeController@markAllAsRead')->name('userAllMark');
Route::get('clientMarkRead', 'ClientController@markAllAsRead')->name('clientAllMark');
Route::get('/notifications/{id}', 'HomeController@markThisAsRead')->name('userMark');
Route::get('clientMarkAsRead', 'ClientController@markThisAsRead')->name('clientMark');
Route::get('doneViewingAd', 'HomeController@viewAdDone')->name('viewAdDone');

Route::get('/ViewAd/{id}', 'HomeController@viewAdFull')->name('ViewAd');
Route::post('/rate', 'HomeController@rateClient')->name('rate.client');
Route::get('/rate', 'HomeController@viewRating')->name('rate');
Route::get('/downloadPDF','ClientController@downloadPDF')->name('downloadPDF');
Route::get('/viewPDF','ClientController@viewPDF')->name('viewPDF');

Route::get('/admin', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');

