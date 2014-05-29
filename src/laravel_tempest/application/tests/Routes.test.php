<?php


class routes extends PHPUnit_Framework_TestCase
{
	
	public function testBasicRouteCanBeRouted()
	{
		Route::get('/', function() {});
		Route::get('home, main, details', function() {});

		$this->assertEquals('/', Router::route('GET', '/')->uri);
		$this->assertEquals('home', Router::route('GET', 'home')->uri);
		$this->assertEquals('main', Router::route('GET', 'main')->uri);
		$this->assertEquals('details', Router::route('GET', 'details')->uri);

		$this->assertEquals('add_room', Router::route('GET', 'add_room')->uri);
		$this->assertEquals('add_user', Router::route('GET', 'add_user')->uri);
		$this->assertEquals('add_assignment', Router::route('GET', 'add_assignment')->uri);
		$this->assertEquals('add_device', Router::route('GET', 'add_device')->uri);
		$this->assertEquals('add_devicetype', Router::route('GET', 'add_devicetype')->uri);
		$this->assertEquals('single_room', Router::route('GET', 'single_room')->uri);
		$this->assertEquals('test_data_ajax', Router::route('GET', 'test_data_ajax')->uri);
		$this->assertEquals('login', Router::route('GET', 'login')->uri);
		$this->assertEquals('logout', Router::route('GET', 'logout')->uri);
	}
}

