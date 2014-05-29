<?php

class Devicetypes_Controller extends Base_Controller
{
	public $restful = true;
/**
*	creates a view to add a new device type in to the devicetypes table.
*
*	@return: View
*   @error: redirects to 500
*/
	public function get_add()
	{
		try
		{
			$view = View::make('details.add_devicetype');
			return $view;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}


/**
*	deletes a device type record from the devicetypes table
*
*	@param: $id -> devicetypes.id
*	@return: redirection to details page with message
*/
	public function get_delete($id)
	{
		try
		{
			DeviceTypes::delete($id);
				return Redirect::back()
					->with('message', 'Device type removed.');
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}



/**
*	creates a new device type record in the table devicetypes
*
*	@return: in all cases, Redirect back to details with message
*   @error: redirects to 500
*/
	public function post_create()
	{
		try
		{
			$rules = array(
				'name' => 'alpha_dash|required|unique:device_types|max:45'
			);


			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails())
			{
				return Redirect::back()
					->with_errors($validation->errors)
					->with_input();
			}
			
			//$this->dosomething()

			//Command::run(array('get_temperatures'));
			//Command::run(array('generate_boilerplate_parser', Input::get('name')));

			DeviceTypes::create(array(
				'name' => Input::get('name')
			));

			return Redirect::to_route('details')
				->with('message', 'Created new type successfully!');
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}

	}
}