<?php

class Rooms
{

/**
*	returns all data of all rooms in the rooms table
*
*	@param: 
*
*	@return: array
*/
	public static function get_all()
	{
		try
		{
			return DB::table('rooms')->get();
		}
		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	finds and returns the first room by id
*
*	@param: int
*
*	@return: object
*/
	public static function find_by_id($id)
	{
		try
		{
			return DB::table('rooms')->where('id', '=', $id)->first();
		}
		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	finds and returns the first room by name
*
*	@param: string
*
*	@return: object
*/
	public static function find_by_name($name)
	{
		try
		{
			return DB::table('rooms')->where('name', '=', $name)->first();
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	returns all data related to a specific column
*
*	@param: string
*
*	@return: array
*/
	public static function get_column($col_name)
	{
		try
		{
			return DB::table('rooms')->get($col_name);
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	gets column and returns as associative array
*
*	@param: string, string
*
*	@return: array of objects
*/
	public static function get_columns_as_associative_array($col1, $col2)
	{
		try
		{
			$rooms_data = DB::table('rooms')->get(array($col1, $col2));

			foreach ($rooms_data as $key => $value)
			{
    			$rooms[$value->id] = $value->name;
			}
			return $rooms;
		}
		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}



/**
*	inserts a new room record
*
*	@param: array
*
*	@return: boolean
*/
	public static function create($input)
	{
		try
		{
			$success = DB::table('rooms')->insert(array(
				'name'=> $input['name'],
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
*	updates an existing room record by id
*
*	@param: array
*
*	@return: boolean
*/
	public static function update($input)
	{
		try
		{
			$success = DB::table('rooms')
				->where('id', '=', $input['id'])
				->update(array('name' => $input['name'],
				'updated_at' => date("Y-m-d H:i:s")));

			return $success;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}



/**
*	removes room record by id
*
*	@param: array
*
*	@return: boolean
*/
	public static function delete($id)
	{
		try
		{
			$success = DB::table('rooms')->delete($id);
			return $success;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}

}