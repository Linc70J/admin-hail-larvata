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

Auth::routes(['register' => false, 'verify' => true]);

Route::group(['middleware' => ["theme:admin,layout"]], function () {

    //Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    //Users Pages
    Route::get('users/query', 'UserController@query')->name('users.query');
    Route::delete('users', 'UserController@delete')->name('users.delete');
    Route::put('users/{user}/change-password', 'UserController@changePassword')->name('users.change-password');
    Route::resource('users', 'UserController')->except(['destroy', 'show']);

    //Roles Pages
    Route::get('roles/query', 'RoleController@query')->name('roles.query');
    Route::delete('roles', 'RoleController@delete')->name('roles.delete');
    Route::resource('roles', 'RoleController')->except(['destroy', 'show']);

    //Categories Pages
    Route::get('topic_categories/query', 'TopicCategoryController@query')->name('topic_categories.query');
    Route::delete('topic_categories', 'TopicCategoryController@delete')->name('topic_categories.delete');
    Route::resource('topic_categories', 'TopicCategoryController');

    //Topics Pages
    Route::get('topics/query', 'TopicController@query')->name('topics.query');
    Route::post('topics/order', 'TopicController@order')->name('topics.order');
    Route::delete('topics', 'TopicController@delete')->name('topics.delete');
    Route::resource('topics', 'TopicController')->except(['destroy', 'show']);

    //Topic Replies Pages
    Route::resource('topic_replies', 'TopicReplyController');

    //Settings Pages
    Route::resource('settings', 'SettingController');
});
