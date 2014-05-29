<?php

class Tempest_Controller extends Base_Controller
{

	public $restful = true;

	public function get_index()
	{
		return View::make('home.index')
			->with('rooms', Room::all())
			->with('devices', Device::all())
			->with('temperatures', Temperature::all()); 
	}
}