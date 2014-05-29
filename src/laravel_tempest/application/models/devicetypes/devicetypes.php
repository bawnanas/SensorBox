
<?php

class DeviceTypes
{

/**
*	gets all data of all device types
*
*	@param: 
*
*	@return: array
*/
	public static function get_all()
	{
		try
		{
			$deviceTypes = DB::table('device_types')->get();
			return $deviceTypes;
		}
		catch(Exception $e)
		{
			Log::write("error", $e->getMessage());
			throw $e;
		}
	}


/**
*	inserts a new device type in to the device_types table
*
*	@param: array
*
*	@return: boolean
*/
	public static function create($input)
	{
		try
		{
			$success = DB::table('device_types')->insert(array('name'=> $input));
			return $success;
		}
		catch(Exception $e)
		{
			Log::write("error", $e->getMessage());
			throw $e;
		}
	}


/**
*	returns a single column
*
*	@param: string
*
*	@return: array
*/
	public static function get_column($col)
	{
		try
		{
			return DB::table('device_types')->get(array($col));
		}
		catch(Exception $e)
		{
			Log::write("error", $e->getMessage());
			throw $e;
		}
	}


/**
*	removes by id 
*
*	@param: int
*
*	@return: boolean
*/
	public static function delete($id)
	{
		try
		{
			$success = DB::table('device_types')->delete($id);
			return $success;
		}
		catch(Exception $e)
		{
			Log::write("error", $e->getMessage());
			throw $e;
		}
	}
}