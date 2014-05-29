<?php

class Devices_Controller extends Base_Controller
{
	public $restful = true;




/**
*	creates a view to add a new device in to the devices table.
*
*	@return: View
*   @error: redirects to 500
*/
	public function get_add()
	{
		try
		{
			$view = View::make('details.add_device');
			$view->devices = Devices::get_all();

			$device_type_data = DeviceTypes::get_column('name');
			foreach ($device_type_data as $key => $value)
			{
				$deviceTypes[$value->name] = $value->name;
			}

			$view->rooms = Rooms::get_columns_as_associative_array('id', 'name');
			$view->deviceTypes = $deviceTypes;
			return $view;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}



	/**
*	creates a view to edit an existing device in to the devices table.
*
*	@param: id -> devices.id
*
*	@return: View
*   @error: redirects to 500
*/
	public function get_edit($id)
	{
		try
		{
			if(!is_numeric($id))
			{
				return Response::error('404');
			}

			$view = View::make('details.edit_device');
			$view->device = Devices::find_by_id($id);
		
			$device_type_data = DeviceTypes::get_column('name'); 

			//put it into a format acceptable for a dropdown box
			foreach ($device_type_data as $key => $value)
			{
				$deviceTypes[$value->name] = $value->name;
			}

			$view->rooms = Rooms::get_columns_as_associative_array('id', 'name'); //drop down box
			$view->deviceTypes = $deviceTypes;
			return $view;
		}
		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}


/**
*	deletes a device record from the devices table
*
*	@param: $id -> assignment.id
*	@return: redirection to details page with message
*/
	public function get_delete($id)
	{
		try
		{
			Devices::delete($id);
			return Redirect::to_route('details')
				->with('message', 'Device removed.');
		}

		catch(Exception $e)
		{
			return Response::error('500');
		}
	}


/**
*	creates a new device record in the table devices
*
*	@return: in all cases, Redirect back to details with message
*   @error: redirects to 500
*/
	public function post_create()
	{
		try
		{	
			$rules = array(
			'name' => 'alpha_dash|max:45',
			'ip_address' => 'required|unique:devices,ip_address|max:255' ,
			'warning_threshold' => 'numeric',
			'alert_threshold' => 'numeric',
			'critical_threshold' => 'numeric',
			'ports' => 'numeric'
			);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails())
			{
				return Redirect::to_route('add_device')
					->with_errors($validation->errors)
					->with_input();
			}


			$input = array();
			$input['name'] = Input::get('name');
			$input['ip_address'] = Input::get('ip_address');
			$input['warning_threshold'] = Input::get('warning_threshold');
			$input['alert_threshold'] = Input::get('alert_threshold');
			$input['critical_threshold'] = Input::get('critical_threshold');
			$input['ports'] = Input::get('ports');
			$input['type'] = Input::get('type');
			$input['room_id'] = Input::get('room_id');
			$success = Devices::create($input);

			return Redirect::to_route('details')
				->with('message', 'Created new device successfully!');
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}



/**
*	edits an existing device record in to the devices table.
*
*	@param: 
*
*	@return: Redirect
*   @error: redirects to 500
*/
	public function post_update()
	{
		try
		{
			$id = Input::get('id');

			// |unique:devices,name,' . $id--> table, column, excluded_id
			$rules = array(
				'name' => 'alpha_dash|unique:devices,name,' . $id . '|max:45',
				'ip_address' => 'required|unique:devices,ip_address,' . $id . 'max:255' ,
				'warning_threshold' => 'numeric',
				'alert_threshold' => 'numeric',
				'critical_threshold' => 'numeric',
				'ports' => 'numeric'
			);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails())
			{
				return Redirect::back()
					->with_errors($validation->errors)
					->with_input();
			}


			$input = array();
			$input['id'] = Input::get('id');
			$input['name'] = Input::get('name');
			$input['ip_address'] = Input::get('ip_address');
			$input['warning_threshold'] = Input::get('warning_threshold');
			$input['alert_threshold'] = Input::get('alert_threshold');
			$input['critical_threshold'] = Input::get('critical_threshold');
			$input['ports'] = Input::get('ports');
			$input['type'] = Input::get('type');
			$input['room_id'] = Input::get('room_id');
			$success = Devices::update($input);

			if($success)
			{
				return Redirect::to_route('details')
					->with('message', 'update successful!');
			} else
			{
				return Redirect::to_route('details')
					->with('message', 'update failed!');
			}
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}


	}
}