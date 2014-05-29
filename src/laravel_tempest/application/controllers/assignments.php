<?php


/**
*
*
*/

class Assignments_Controller extends Base_Controller
{
	public $restful = true;

/**
*	creates a view to add a new assignment in to the Assignments table.
*
*	@return: View
*   @error: redirects to 500
*/
	public function get_add()
	{
		try
		{
			$view = View::make('details.add_assignment');
			$view->rooms = Rooms::get_columns_as_associative_array('id', 'name');
			$view->users = Users::get_columns_as_associative_array('id', 'username');
			return $view;
		}
		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}		
	}

/**
*	creates a new assignment record in the table assignments
*
*	@return: in all cases, Redirect back to details with message
*   @error: redirects to 500
*/
	public function post_create()
	{
		try
		{
			$input = array();

			if(Assignments::check_unique_assignment(Input::get('user_id'), Input::get('room_id') ))
			{
				$input['user_id'] = Input::get('user_id');
				$input['room_id'] = Input::get('room_id');

				$success = Assignments::create($input);

				if( $success )
				{
					return Redirect::to_route('details')
					->with('message', 'Created new assignment successfully!');
				}
				else
				{
					return Redirect::to_route('details')
					->with('error', 'Assignment Failed!');
				}
			}

			else
			{
				return Redirect::to_route('details')
				->with('error', 'Assignment already exists!');
			}

		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}

	}


/**
*	deletes an assignment record from the assignments table
*
*	@param: $id -> assignment.id
*	@return: redirection to details page with message
*/
	public function get_delete($id)
	{
		try
		{
			Assignments::delete($id);
			return Redirect::to_route('details')
				->with('message', 'assignment deleted');
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Redirect::to_route('details')
				->with('error', 'assignment deletion failed!');
		}
	}
}