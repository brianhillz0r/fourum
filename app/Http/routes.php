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

use Illuminate\Support\Facades\Route;

Route::filter('beforeFilter', 'Fourum\Filter\BeforeFilter');
Route::filter('afterFilter', 'Fourum\Filter\AfterFilter');

/**
 * Front Routes
 */
Route::group(array('before' => 'beforeFilter', 'after' => 'afterFilter'), function()
{
    Route::get('/', 'Front\HomeController@index');
//    Route::get('/install', 'Front\InstallController@index');

    // auth routes
    Route::controller('auth', 'Front\AuthController');

    // forum routes
    Route::get('/forum/{id}/{title?}', 'Front\ForumController@view');

    // notification routes
    Route::get('/notifications', 'Front\NotificationController@index');
    Route::get('/notifications/mark-read', 'Front\NotificationController@markRead');

    // post routes
    Route::get('/post/create/{threadId}', 'Front\PostController@getCreate');
    Route::get('/post/{id}', array(
        'as' => 'post.view',
        'uses' => 'Front\PostController@view'
    ));
    Route::post('/post/create/{threadId}', 'Front\PostController@postCreate');
    Route::post('/post/edit', 'Front\PostController@postEdit');

    // report routes
    Route::get('/report/{type}/{id}', 'Front\ReportController@report');
    Route::post('/report', 'Front\ReportController@save');

    // signup routes
    Route::get('/register', 'Front\SignupController@getRegister');
    Route::post('/register', 'Front\SignupController@postRegister');

    // user routes
    Route::get('/user/{username}', array(
        'as' => 'user.profile',
        'uses' => 'Front\UserController@profile'
    ));

    // thread routes
    Route::get('/thread/create/{forumId}', 'Front\ThreadController@getCreate');
    Route::get('/thread/{id}/{title?}', array(
        'as' => 'thread.view',
        'uses' => 'Front\ThreadController@view'
    ));
    Route::post('/thread/create/{forumId}', 'Front\ThreadController@postCreate');
});


/**
 * Admin Routes
 */
Route::group(array('prefix' => 'admin', 'before' => 'beforeFilter', 'after' => 'afterFilter'), function()
{
    Route::get('/', 'Admin\IndexController@index');

    /**
     * Settings Routes
     */
    Route::get('/settings', 'Admin\SettingsController@index');
    Route::get('/settings/banning', 'Admin\SettingsController@banning');
    Route::get('/settings/themes', 'Admin\SettingsController@themes');
    Route::post('/settings', 'Admin\SettingsController@save');

    /**
     * Forums Routes
     */
    Route::get('/forums', 'Admin\ForumsController@index');
    Route::get('/forums/add', 'Admin\ForumsController@add');
    Route::post('/forums/add', 'Admin\ForumsController@save');

    /**
     * Users Routes
     */
    Route::get('/users', 'Admin\UsersController@index');
    Route::get('/users/manage/{id}', 'Admin\UsersController@manage');
    Route::post('/users/save', 'Admin\UsersController@save');
    Route::post('/users/permissions/save', 'Admin\UsersController@permissionsSave');

    /**
     * Groups Routes
     */
    Route::get('/groups', 'Admin\GroupsController@index');
    Route::get('/groups/add', 'Admin\GroupsController@add');
    Route::get('/groups/view/{id}', 'Admin\GroupsController@view');
    Route::get('/groups/edit/{id}', 'Admin\GroupsController@edit');
    Route::get('/groups/remove/{groupId}/{userId}', 'Admin\GroupsController@remove');
    Route::post('/groups/add', 'Admin\GroupsController@postAdd');
    Route::post('/groups/add-user', 'Admin\GroupsController@addUser');
    Route::post('/groups/edit', 'Admin\GroupsController@save');
    Route::post('/groups/permissions/save', 'Admin\GroupsController@permissionsSave');

    /**
     * Themes Routes
     */
    Route::get('/themes', 'Admin\ThemesController@index');

    /**
     * Rules Routes
     */
    Route::get('/rules', 'Admin\RulesController@index');
    Route::post('/rules/add', 'Admin\RulesController@save');

    /**
     * Reports Routes
     */
    Route::get('/reports', 'Admin\ReportsController@index');
    Route::get('/reports/mark-read/{id}', 'Admin\ReportsController@markRead');

    /**
     * Packages Routes
     */
    Route::get('/packages', 'Admin\PackagesController@index');
    Route::get('/packages/enable/{package}', 'Admin\PackagesController@enable');
    Route::get('/packages/disable/{package}', 'Admin\PackagesController@disable');
});
