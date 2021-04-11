<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//User Auth
Route::post('login','Api\AuthController@login');
Route::post('register','Api\AuthController@register');
Route::get('logout','Api\AuthController@logout');
Route::post('save_user_info_reg','Api\AuthController@saveUserInfo')->middleware('jwtAuth');

//Event
Route::post('events/create','Api\EventController@create')->middleware('jwtAuth');
Route::post('events/delete','Api\EventController@delete')->middleware('jwtAuth');
Route::post('events/update','Api\EventController@update')->middleware('jwtAuth');
Route::get('events','Api\EventController@events')->middleware('jwtAuth');

//Comment
Route::post('comments/create','Api\CommentController@create')->middleware('jwtAuth');
Route::post('comments/delete','Api\CommentController@delete')->middleware('jwtAuth');
Route::post('comments/update','Api\CommentController@update')->middleware('jwtAuth');
Route::post('events/comments','Api\CommentController@comments')->middleware('jwtAuth');

//Favorite
Route::post('events/favorite', 'Api\FavoriteController@favorite')->middleware('jwtAuth');