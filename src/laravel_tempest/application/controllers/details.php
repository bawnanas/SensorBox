<?php

/**
*		
*
*/

class Details_Controller extends Base_Controller
{
	public $restful = true;

/**
*			
*
*/
	public function get_index()
	{
		try
		{
			$view = View::make('details.index');
			$view->rooms = Rooms::get_all();
			$view->devices = Devices::get_all();
			$view->users = Users::get_all();
			$view->assignments = Assignments::get_all();
			$view->deviceTypes = DeviceTypes::get_all();
			$view->carriers = Carriers::get_all();
			return $view;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}
}