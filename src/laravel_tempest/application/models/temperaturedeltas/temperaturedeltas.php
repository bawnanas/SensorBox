<?php

class TemperatureDeltas
{

/**
*	gets all temperature deltas that are from today
*
*	@param:
*
*	@return: array of objects
*/
	public static function get_close_today()
	{
		try
		{
			//raw query
			$q = DB::query( "SELECT close, device_id, port FROM temperature_deltas 
					WHERE DATE(time) = DATE(NOW())  
				");

			return $q;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	gets times of temperature deltas associated with a given device and port
*
*	@param: int, int
*
*	@return: array of objects
*/
	public static function get_time_by_device_port($device_id, $port)
	{
		try
		{
			$deltas = DB::table('temperature_deltas')
			->where('device_id', '=', $device_id)
			->where('port', '=', $port)
			->get(array('time')
			);

			return  $deltas;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	gets all temperature deltas associated with a given device and port
*
*	@param: int, int
*
*	@return: array of objects
*/
	public static function get_temperature_data_by_device_port($device_id, $port)
	{
		try
		{
			$deltas = DB::table('temperature_deltas')
				->where('device_id', '=', $device_id)
				->where('port', '=', $port)
				->get(array('time', 'open', 'close', 'low', 'high')
			);

			return  $deltas;
		}

		catch (Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	gets all temperature deltas associated with a given device and port that are from today
*
*	@param: int, int
*
*	@return: array of objects
*/
	public static function get_today_by_device_port($port, $device_id)
	{
		$q = DB::query( "SELECT time, open, high, low, close, id FROM temperature_deltas 
			WHERE DATE(time) = DATE(NOW()) 
			AND device_id = '$device_id'
			AND port = '$port' 
			");

		return $q;
	}


/**
*	will create a new record if one is not found for today's date, otherwise will update that 
* 	record
*
*	@param: float, int, int
*
*	@return: boolean
*/
	public static function insert($temperature, $port, $device_id)
	{
		try
		{
			$success = false;
			//see if record already exists for today
			$q = TemperatureDeltas::get_today_by_device_port($port, $device_id);

			//if does not exist-- create a new record
			if( sizeof($q) == 0 )
			{

				$success = TemperatureDeltas::insert_new($temperature, $port, $device_id);
			}

			if( sizeof($q) >= 1)
			{
				$success = TemperatureDeltas::update($q, $temperature);
			}

			return $success;

		}

		catch (Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	inserts the new record
*
*	@param: float, int, int
*
*	@return: boolean
*/
	public static function insert_new($temperature, $port, $device_id)
	{
		$success = DB::table('temperature_deltas')->insert( array(
		'open' => $temperature,
		'close' => $temperature,
		'low' => $temperature,
		'high' => $temperature,
		'time' => date("Y-m-d H:i:s"),
		'port' => $port,
		'device_id'=> $device_id
		));

		return $success;
	}


/**
*	updates today's record
*
*	@param: object, float
*
*	@return: boolean
*/
	public static function update($current_delta, $new_temperature)
	{
		$low = intval($current_delta[0]->low);
		$high = intval($current_delta[0]->high);

		if ($new_temperature < $low)
		{
			$low = $new_temperature;
		}

		if ($new_temperature > $high)
		{
			$high = $new_temperature;
		}

		$success = DB::table('temperature_deltas')->where( 'id', '=', $current_delta[0]->id)
			->update( array(
				'close' => $new_temperature,
				'low' => $low,
				'high' => $high
			));

		return $success;
	}
}