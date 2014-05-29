<?php

/**
* an assignment maintains a relationship between a user and a room. Users assigned to a room
* will be notified if a device in room exceeds the alert threshold.
*
*/

class Assignments
{

/**
*	gets all assignments and returns them in order of room_id
*	
*	@return: array of objects
*/
	public static function get_all()
	{
		try
		{
			$assignments = DB::table('assignments')->order_by('room_id')->get(array( 
				'id', 'user_id', 'room_id'));

			return $assignments;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}



/**
*	gets all users associated with a given room
*
*	@param: int -> room id
*
*	@return: array of objects
*/
	public function get_users_by_room($room_id)
	{
		try
		{
			$users = DB::table('assignments')
				->where('room_id', '=', $room_id)
				->get(array('user_id'));

			return $users;
		}

		catch( Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}



/**
*	gets all users associated with a given room
*
*	@param: array
*
*	@return: boolean
*/
	public static function create($input)
	{
		try
		{
			$success = DB::table('assignments')->insert(array(
				'user_id' => $input['user_id'],
				'room_id' => $input['room_id'],
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			));

		return $success;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	checks to see if an assignment already exists
*
*	@param: int, int
*
*	@return: boolean
*/
	public static function check_unique_assignment($user_id, $room_id)
	{
		try
		{
			$query = DB::table('assignments')
				->where('user_id', '=', $user_id)
				->where('room_id', '=', $room_id);

			return $query->count() == 0;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}
	


/**
*	removes an assignment row based on id from the assignments table
*
*	@param: int
*
*	@return: boolean
*/
	public static function delete($id)
	{
		try
		{
			$success = DB::table('assignments')->delete($id);

			return $success;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}
}