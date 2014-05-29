<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

// trouble with your routing? --make sure mod_rewrite.so is enable in apache

Route::get('/', function(){
	return Redirect::to('home');
});

//----known working.... ----
Route::get('home', array(
	'as' => 'home',
	'uses' =>'home@index'));

Route::get('details', array(
	'before'=> 'guest',
	'as' 	=> 'details',
	'uses' => 'details@index'));


Route::get('add_room', array(
	'before' => 'auth', 
	'as'=>'add_room', 
	'uses'=>'rooms@add'));

Route::get('add_user', array(
	'before' => 'auth', 
	'as'=>'add_user', 
	'uses'=>'users@add'));

Route::get('add_assignment', 
	array('before' => 'auth', 
		'as'=>'add_assignment', 
		'uses'=>'assignments@add'));

Route::get('add_device', array(
	'before' => 'auth', 
	'as'=>'add_device', 
	'uses'=>'devices@add'));

Route::get('add_devicetype', array(
	'before' => 'auth', 
		'as'=>'add_devicetype', 
		'uses'=>'devicetypes@add'));


Route::post('create_room', array(
	'before' => 'auth|csrf', 
	'uses'=>'rooms@create'));

Route::post('create_device', array(
		'before' => 'auth|csrf', 
		'uses' => 'devices@create'));

Route::post('create_user', array(
	'before' => 'auth|csrf',
	'uses' => 'users@create'));

Route::post('create_assignment', array(
		'before' => 'auth|csrf', 
		'uses' => 'assignments@create'));

Route::post('create_devicetype', array(
	'before' => 'auth|csrf', 
	'uses' => 'devicetypes@create'));


Route::get('delete_room/(:num)', 
	array('before' => 'auth', 
		'as' => 'delete_room', 
		'uses' => 'rooms@delete'));

Route::get('delete_device/(:num)', array(
	'before' => 'auth', 
	'as' => 'delete_device', 
	'uses' => 'devices@delete'));

Route::get('delete_user/(:num)', array(
	'before' => 'auth', 
	'as'=>'delete_user', 
	'uses' => 'users@delete'));

Route::get('delete_assignment/(:num)', array(
	'before' => 'auth', 
	'as'=>'delete_assignment', 
	'uses' => 'assignments@delete'));

Route::get('delete_devicetype/(:num)', array(
	'before' => 'auth', 
	'as' =>'delete_devicetype', 
	'uses' => 'devicetypes@delete'));


Route::get('edit_room/(:num)', array(
	'before' => 'auth', 
	'as'=> 'edit_room', 
	'uses' => 'rooms@edit'));

Route::get('edit_device/(:num)', array(
	'before' => 'auth', 
	'as'=> 'edit_device', 
	'uses' => 'devices@edit'));

Route::get('edit_user/(:num)', array(
	'before' => 'auth', 
	'as'=> 'edit_user', 
	'uses' => 'users@edit'));

Route::get('edit_assignment/(:num)', array(
	'before' => 'auth', 
	'as'=> 'edit_assignment', 
	'uses' => 'assignments@edit'));


Route::post('update_room', array(
	'before' => 'auth|csrf', 
	'as' => 'update_room', 
	'uses' => 'rooms@update'));

Route::post('update_device', array(
	'before' => 'auth|csrf', 
	'as' => 'update_device', 
	'uses' => 'devices@update'));

Route::post('update_user', array(
	'before' => 'auth|csrf', 
	'as' => 'update_user', 
	'uses' => 'users@update'));

Route::post('update_assignment', array(
	'before' => 'auth|csrf', 
	'as' => 'update_assignment', 
	'uses' => 'assignments@update'));


Route::get('single_room', array(
	'as' => 'single_room', 
	'uses' => 'temperatures@single_room'));

Route::get('single_port', array(
	'as' => 'single_port',
	'uses' => 'temperatures@single_port'));

Route::get('all_temperature_data', array(
	'as' => 'all_temperature_data', 
	'uses' => 'temperatures@all_temperature_data'));


Route::get('login', array(
	'as' => 'login', 
	'uses' => 'login@index'));

Route::post('login', array(
	'as' => 'login', 
	'uses' => 'login@index'));

Route::get('logout', array(
	'as' => 'logout', 
	'uses' => 'login@logout'));


Route::get('verify/(:num)', array(
	'before' => 'auth', 
	'as' => 'verify_user', 
	'uses' => 'verify@index'));


Route::get('send_code/(:num)(:any)', array(
	'before'=> 'auth', 
	'as' => 'send_code', 
	'uses' => 'verify@send_code'));

// Route::get('send_phone_code/(:num)', array(
// 	'before' => 'auth', 
// 	'as' => 'send_phone_code', 
// 	'uses' => 'verify@send_phone_code'));

Route::post('verify_user', array(
	'as' => 'verify_user', 
	'uses' => 'verify@verify_user'
	));

Route::post('verify_user_phone', array(
	'as' => 'verify_user_phone', 
	'uses' => 'verify@verify_user_phone'
	));

Route::post('test_verify', array(
	'as' => 'test_verify', 
	'uses' => 'verify@test'
	));


Route::post('test_route', array(
	'as' => 'test_route', 
	'uses' => 'test@index'
	));

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application. The exception object
| that is captured during execution is then passed to the 500 listener.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});


Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest())
	{ 
		return Redirect::to('login')
			->with('error', 'You must be logged in to view this page.');
	}
	if(!Auth::user()->is_admin)
	{
		return Redirect::to('login')
			->with('error', 'You must be logged in to view this page.');
	}
});

Route::filter('guest', function()
{
	//if(Auth::check()) return Redirect::to('/');
 	if (Auth::guest()) return Redirect::to('login');
});