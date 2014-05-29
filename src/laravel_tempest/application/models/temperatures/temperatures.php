<?php

class Temperatures
{


/**
*	gets all data of all temperatures from the temperatures table
*
*	@param: 
*
*	@return: array of objects
*/
	public static function get_all()
	{
		try
		{
			$temperatures = DB::table('temperatures')->get();
			return $temperatures;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	gets all temperatures associated with each device and port
*
*	@param: int, int
*
*	@return: array of objects
*/
	public static function get_by_device_port($device_id, $port)
	{
		try
		{
			$temperatures = DB::table('temperatures')
			->where('device_id', '=', $device_id)
			->where('port', '=', $port)
			->get(array('time', 'temperature'));

			return  $temperatures;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	inserts a record. Time updates itself automatically
*
*	@param: float, int, int
*
*	@return: boolean
*/
	public static function insert($temperature, $port, $device_id)
	{
		try
		{
			$success = DB::table('temperatures')->insert(array(
			'temperature' => $temperature,
			'port' => $port,
			'device_id' => $device_id
			));

			return $success;
		}

		catch (Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}

/**
*	gets the max temperature acheived in a week
*
*	@param: int, int
*
*	@return: array of objects
*/
	public function get_week_max($device_id, $port)
	{
		try
		{
			$max = DB::table('temperatures')
				->where('device_id', '=', $device_id)
				->where('port', '=', $port)
				->where('time', '>=', time() - (7*24*60*60))
				->max('temperature');

			return $max;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	gets the min temperature acheived in a week
*
*	@param: int, int
*
*	@return: array of objects
*/
	public function get_week_min($device_id, $port)
	{
		try
		{
			return DB::table('temperatures')
				->where('device_id', '=', $device_id)
				->where('port', '=', $port)
				->where('time', '>=', time() - (7*24*60*60))
				->min('temperature');
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	gets the average temperature acheived in a week
*
*	@param: int, int
*
*	@return: array of objects
*/
	public function get_week_avg($device_id, $port)
	{
		try
		{
			return DB::table('temperatures')
				->where('device_id', '=', $device_id)
				->where('port', '=', $port)
				->where('time', '>=', time() - (7*24*60*60))
				->avg('temperature');
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}
}