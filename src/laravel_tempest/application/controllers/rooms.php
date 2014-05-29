<?php

class Rooms_Controller extends Base_Controller
{
	public $restful = true;


/**
*	creates a view to add a new room in to the rooms table.
*
*	@return: View
*   @error: redirects to 500
*/
	public function get_add()
	{
		$view = View::make('details.add_room');
		return $view;
	}

	/**
*	creates a view to edit an existing room in to the rooms table.
*
*	@param: id -> rooms.id
*
*	@return: View
*   @error: redirects to 500
*/
	public function get_edit($id)
	{
		$view = View::make('details.edit_room');
		$view->room = Rooms::find_by_id($id);
		return $view;
	}


/**
*	deletes a room record from the rooms table
*
*	@param: $id -> rooms.id
*	@return: redirection to details page with message
*/
	public function get_delete($id)
	{
		Rooms::delete($id);
			return Redirect::to_route('details')
				->with('message', 'Room deleted.');
	}


/**
*	creates a new room record in the table rooms
*
*	@return: in all cases, Redirect back to details with message
*   @error: redirects to 500
*/
	public function post_create()
	{
		$rules = array(
			'name' => 'alpha_dash|required|unique:rooms,name|max:45'
		);


		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
		{
			return Redirect::back()
				->with_errors($validation->errors)
				->with_input();
		}
		

		Rooms::create(array(
			'name' => Input::get('name')
		));

		return Redirect::to_route('details')
			->with('message', 'Created new room successfully!');
	}



/**
*	edits an existing room record in to the rooms table.
*
*	@param: none explicit, but they come from Input
*
*	@return: Redirect
*   @error: redirects to 500
*/
	public function post_update()
	{
		$id = Input::get('id');
		$rules = array(
			'name' => 'alpha_dash|required|max:45|unique:rooms,name,' . $id
		);


		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails())
		{
			return Redirect::back()
				->with_errors($validation->errors)
				->with_input();
		}


		$success = Rooms::update(Input::all());
		return Redirect::to_route('details')
			->with('message', 'Room update successful!');
	}



}