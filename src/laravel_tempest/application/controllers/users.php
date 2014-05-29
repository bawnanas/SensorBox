<?php

class Users_Controller extends Base_Controller
{
	public $restful = true;



/**
*	creates a view to add a new user in to the users table.
*
*	@return: View
*   @error: redirects to 500
*/
	public function get_add()
	{
		try
		{
			$view = View::make('details.add_user');
			$view->carriers = Carriers::get_columns_as_associative_array('domain', 'name');
			return $view;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}

/**
*	creates a new user record in the table users
*
*	@return: in all cases, Redirect back to details with message
*   @error: redirects to 500
*/
	public function post_create()
	{

		try
		{
			$rules = array(
				'username' => 'required|alpha_dash|max:30|unique:users,username', 
				'email' => 'required|email|max:255|unique:users,email',
				'phone' => 'unique:users,phone|min:10|max:10|match:/([0-9]{10})/',
				'carrier' => 'required_with:phone',
	        	'new_password' => 'required|alpha_num|min:4|max:8|Confirmed',
	        	'new_password_confirmation' => 'required|alpha_num|min:4|max:8'

			);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails())
			{
				return Redirect::to_route('add_user')
					->with_errors($validation->errors)
					->with_input();
			}


			Users::create(array(
				'username' => Input::get('username'),
				'email' =>Input::get('email'),
				'phone' => Input::get('phone'),
				'carrier' => Input::get('carrier'),
				'password' => Input::get('new_password'),
				'is_admin' => Input::get('is_admin')
			));

			return Redirect::to_route('details')
				->with('message', 'Created new user successfully!');


			// $success = Users::create(array(
			// 	'username' => Input::get('username'),
			// 	'email' =>Input::get('email'),
			// 	'phone' => Input::get('phone'),
			// 	'carrier' => Input::get('carrier'),
			// 	'password' => Input::get('new_password'),
			// 	'is_admin' => Input::get('is_admin')
			// ));


			// if($success)
			// {
			// 	return Redirect::to_route('details')
			// 		->with('message', 'Created new user successfully!');
			// }

			// else
			// {
			// 	 return Redirect::to_route('details')
			// 		->with('error', 'User creation failed.');
			// }

		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}

	public function get_edit($id)
	{
		try
		{
			$view = View::make('details.edit_user');
			$view->user = Users::find_by_id($id);
			$view->carriers = Carriers::get_columns_as_associative_array('domain', 'name');
			return $view;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}

	public function post_update()
	{
		try
		{
			$id = Input::get('id');

			$rules = array(
				'username' => 'alpha_dash|required|max:45',
				'email' => 'required|email|unique:users,email,' . $id,
				'phone' => 'match:/([0-9]{10})/|unique:users,phone,' . $id,
				'carrier' => 'required_with:phone',
				'password' => 'confirmed|min:5', 

				);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails())
			{
				return Redirect::back()
					->with_errors($validation->errors)
					->with_input();
			}

			$user = Users::find_by_id($id);
			$email_verified = $user->email_verified;
			$phone_verified = $user->phone_verified;
			
			if($user->email !== Input::get('email') )
			{
				$email_verified = 0;
			}

			if(Input::get('phone') !== null)
			{
				if($user->phone !== Input::get('phone') )
				{
					$phone_verified = 0;
				}
			}
			$success = Users::update(array(
				'id' => Input::get('id'),
				'username' => Input::get('username'),
				'email' =>Input::get('email'),
				'phone' => Input::get('phone'),
				'carrier' => Input::get('carrier'),
				'is_admin' => Input::get('is_admin'),
				'email_verified' => $email_verified,
				'phone_verified' => $phone_verified

			));

			if($success)
			{
				return Redirect::to_route('details')
					->with('message', 'Update contact successful!');
			}
			else
			{
				return Redirect::to_route('details')
					->with('error', 'Update Failed!');
			}
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}

	public function get_delete($id)
	{
		try
		{
			Users::delete($id);
				return Redirect::to_route('details')
					->with('message', 'User Removed');
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}

	// private function generate_salt($max = 15)
	// {
 //        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
 //        $i = 0;
 //        $salt = "";
 //        while ($i < $max) 
 //        {
 //            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
 //            $i++;
 //        }
 //        return $salt;
	// }
}