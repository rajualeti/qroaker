<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);
//Route::post('contact-us', 'HomeController@contactUs');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::filter('no-cache',function($route, $request, $response){

	$response->header("Cache-Control","no-cache,no-store, must-revalidate");
	$response->header("Pragma", "no-cache"); /* HTTP 1.0 */
	$response->header("Expires","0"); /* Date in the past */

});

Route::resource('users', 'UserController');
Route::resource('qroak-users', 'QroakUserController');
Route::resource('roles', 'RoleController');
Route::resource('qroaks', 'QroakController');

Route::post('change-role-status/{id}', 'RoleController@changeStatus');
Route::post('change-qroakuser-status/{qroak_user_id}', 'QroakUserController@changeStatus');
Route::post('block-user/{id}', 'UserController@blockUser');
Route::post('unblock-user/{id}', 'UserController@unblockUser');
Route::post('reset-password/{id}', 'HomeController@resetPassword');
Route::get('change-password', 'HomeController@changePassword');
Route::post('update-password', 'HomeController@updatePassword');
