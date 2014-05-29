<?php

class Devices
{

/**
*	gets all devices and all device data from devices table
*
*	@param: 
*
*	@return: array
*/
	public static function get_all()
	{
		try
		{
			$devices = DB::table('devices')->get();
			return $devices;
		}

		catch (Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	gets all devices associated with a given room
*
*	@param: int
*
*	@return: array
*/
	public static function get_by_room($id)
	{
		try
		{
			return DB::table('devices')
				->where('room_id', '=', $id)
				->get(array('id', 'name', 'ports'));
		}
		catch (Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}

	}


/**
*	gets all data of all devices in a given room
*
*	@param: int
*
*	@return: array
*/
	public static function get_all_by_room($id)
	{
		try
		{
			return DB::table('devices')
				->where('room_id', '=', $id)
				->get();
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}




/**
*	gets a single column from the devices table
*
*	@param: string
*
*	@return: array
*/
	public static function get_column($col)
	{
		try
		{
			$devices = DB::table('devices')->get($col);
			return $devices;
		}

		catch (Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;			
		}
	}


/**
*	returns the first found device by id
*
*	@param: int
*
*	@return: object
*/
	public static function find_by_id($id)
	{
		try
		{
			$device = DB::table('devices')
				->where('id', '=', $id)
				->first();

			return $device;
		}

		catch (Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	creates a new device record in the devices table
*
*	@param: array
*
*	@return: boolean
*/
	public static function create($input)
	{
		try
		{
		$success = DB::table('devices')->insert(array(
			'name' => $input['name'],
			'ip_address' => $input['ip_address'],
			'warning_threshold' => $input['warning_threshold'],
			'alert_threshold' => $input['alert_threshold'],
			'critical_threshold' => $input['critical_threshold'],
			'type' => $input['type'],
			'ports' => $input['ports'],
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
*	updates a device record in the devices table
*
*	@param: array
*
*	@return: boolean
*/
	public static function update($input)
	{	
		try
		{
		$success = DB::table('devices')
			->where('id', '=', $input['id'])
			->update(array(
			'name' => $input['name'],
			'ip_address' => $input['ip_address'],
			'warning_threshold' => $input['warning_threshold'],
			'alert_threshold' => $input['alert_threshold'],
			'critical_threshold' => $input['critical_threshold'],
			'type' => $input['type'],
			'ports' => $input['ports'],
			'room_id' => $input['room_id'],
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
*	updates the status column of a device
*
*	@param: int, string
*
*	@return: boolean
*/
	public static function update_status($id, $status)
	{
		try
		{
			$success = DB::table('devices')
				->where('id', '=', $id)
				->update( array(
					'status' => $status,
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
*	updates the count of a status of a device
*
*	@param: int, string
*
*	@return: boolean
*/
	public static function count_status($id, $status)
	{
		try
		{
			$column = strtolower($status . "_count");
			$count = DB::table('devices')
				->where('id', '=', $id)
				->only($column);

			$count += 1;

			$success = DB::table('devices')
				->where('id', '=', $id)
				->update( array(
					$column => $count
				)
			);

			return $success;
		}

		catch( Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	resets the status counts of a device back to 0
*
*	@param: int
*
*	@return: boolean
*/
	public static function reset_counts($id)
	{
		try
		{
			$success = DB::table('devices')
				->where('id', '=', $id)
				->update(array(
					'c_n_c_count' => 0,
					'warning_count' => 0,
					'alert_count' => 0,
					'critical_count' => 0,
					'updated_at' => date("Y-m-d H:i:s")
					));

			return $success;
		}

		catch( Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}

/**
*	if messages have been sent from a device this column will be 1 otherwise 0.
* 	if this is 1, this will prevent other messages from being sent out.
*
*	@param: int, int
*
*	@return: boolean
*/
	public static function update_message_sent($id, $sent)
	{
		try
		{
			$success = DB::table('devices')
				->where('id', '=', $id)
				->update( array(
				'message_sent' => $sent
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
*	will delete a device from the table devices. this will also delete ALL associated
*	temperature data in the temperatures table.
*
*	@param: int
*
*	@return: boolean
*/
	public static function delete($id)
	{
		try
		{
			$success = DB::table('devices')->delete($id);
			return $success;	
		}

		catch(Exception $e)
		{
			Log::write("error", $e->getMessage());
			throw $e;
		}
	}
}