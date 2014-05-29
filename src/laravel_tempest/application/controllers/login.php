<?php

class Login_Controller extends Base_Controller
{
	public $restful = true;


	/**
*	creates a view to allow someone to log with with valid username and password
*
*	@return: View
*   @error: redirects to 500
*/
	public function get_index()
	{
		try
		{
			$view = View::make('login.index');
			return $view;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}

	public function post_index()
	{
		try
		{
			$userdata = array(
				'username'      => Input::get('username'),
				'password'      => Input::get('password')
				);

			if ( Auth::attempt($userdata) )
			{
				return Redirect::to('home');
			}


			else
			{
	        	// auth failure! back to login
				return Redirect::to('login')
				->with('login_errors', true);
			}
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}


/**
*	logs the user out
*
*	@return: Redirect
*   @error: redirects to 500
*/
	public function get_logout()
	{
		try
		{
			Auth::logout();
			return Redirect::to('home');
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}
}