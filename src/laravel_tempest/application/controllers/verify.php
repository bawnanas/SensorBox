<?php

class Verify_Controller extends Base_Controller
{
	public $restful = true;


	public function get_index($id)
	{
		try
		{
			$view = View::make('verify.index');
			$view->user = Users::find_by_id($id);
			return $view;
		}

		catch (Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}



	public function get_send_code($id, $type)
	{
		try
		{
			$code = strtoupper($this->generate_code());
			$user = Users::find_by_id($id);
			Users::insert_verification_code($id, $type, $code);

			$address = "";
			$message = "";

			if($type === 'email')
			{
				$address = $user->email;
			}

			if($type === 'phone')
			{
				if($user->phone === "")
				{
					return Redirect::back()
						->with('message', 'there is no phone for this user!');
				}
				$address = $user->phone . '@' . $user->carrier;
			}


			Message::to( $address )
			->from('me@google.com', 'R0-Bob Mailey')
			->subject('verification code')
			->body($code)
			->send();

			return Redirect::to_route('verify_user', array($id))
			->with('message', 'Code has been sent! Please check your ' . $type . '.');
		}

		catch (Exception $e) 
		{
			Log::write('error', $e->getMessage());
			return Redirect::to_route('details')
			->with('message', 'some kind of error occured! Please try again later.');
		}
	}

	public function post_verify_user()
	{
		$id = Input::get('id');
		$type = Input::get('type');
		$code_correct = false;

		try
		{
			$rules = array(
				'email_code' => 'alpha_num|min:5|max:5',
				'phone_code' => 'alpha_num|min:5|max:5'
				);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails())
			{
				return Redirect::back()
				->with_errors($validation->errors)
				->with_input();
			}

			$user = Users::find_by_id($id);


			if($type === 'email' )
			{
				if($user->email_verification_code === strtoupper(Input::get('email_code')) )
				{
					$code_correct = true;
				}
			}

			elseif( $type === 'phone' )
			{
				if($user->phone_verification_code === strtoupper(Input::get('phone_code')) )
				{
					$code_correct = true;
				}
			}

			if($code_correct)
			{
				$success = Users::update_verified( $id, $type, 1 );

				if($success)
				{
					return Redirect::to_route('details')
					->with('message', $user->username . "'s " . $type . " has been verified!");
				}
				else
				{
					return Redirect::to_route('details')
					->with('message', 'Update Failed!');
				}
			}

			else
			{
				return Redirect::back()
				->with('message', 'code not correct! reenter or click the link again to send a new code.');
			}
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}


		/**
		* generates a random 5 character long code 
		* @return string
		*/
		private function generate_code()
		{
			$code = "";
			for ($i = 0; $i < 5; ++$i) 
			{
				if (mt_rand() % 2 == 0) 
				{
					$code .= mt_rand(0,9);
				} else 
				{
					$code .= chr(mt_rand(65, 90));
				}

			}

			return $code; 

		}
	}