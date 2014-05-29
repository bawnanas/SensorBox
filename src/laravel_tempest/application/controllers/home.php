<?php

class Home_Controller extends Base_Controller {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/

	public $restful = true;

	public function get_index()
	{
		try
		{
			$view = View::make('home.index');
    		$view->rooms = Rooms::get_all();
    		$view->devices = Devices::get_all();
    		$view->temperatures = Temperatures::get_all();
    		$view->deltas = TemperatureDeltas::get_close_today();
    		return $view;
    	}

    	catch(Exception $e)
    	{
    		Log::write('error','Caught exception: ' . $e->getMessage());
    		return Response::error('500');
    	}
	}

}