<?php

class Temperatures_Controller extends Base_Controller
{

	public $restful = true;

	public function get_data()
	{
		//$port = Input::get('port');
		//$device_id = Input::get('device_id');
		//$temps = Temperatures::get_by_device_port($device_id, $port);

		$temps = Temperatures::get_all();
		if( Request::ajax())
			$temps = json_encode($temps, JSON_NUMERIC_CHECK);

		return $temps;
	}

/**
*	gets all temperature data stored and organizes it by device and port into a multi dimentional array
* 	to be graphed.
*
*/
	public function get_all_temperature_data()
	{
		$series = array();

		$devices = Devices::get_all();

		foreach($devices as $device)
		{
			for($port=0; $port < $device->ports; $port++)
			{
				$tat = Temperatures::get_by_device_port($device->id, $port);
				
				$time_and_temperatures = array();
				foreach($tat as $t)
				{
					//convert to an array to appease the graphing lib
					array_push($time_and_temperatures, array(strtotime($t->time) * 1000, $t->temperature));
				}

				$name ='device: ' . $device->name . ' port: ' . $port;
				$data_set = array($name, $time_and_temperatures);

				array_push($series, $data_set);
			}
		}
		$series = json_encode($series, JSON_NUMERIC_CHECK);
		return $series;
	}


/**
*	gets all device temperature data associated with a single room, and organizes it by device
* 	 and port for graphing
*
*/
	public function get_single_room()
	{
		$series = array(); // all of the data that is going to be sent back

		$room_name = (Input::get('room_name'));
		$room = Rooms::find_by_name($room_name);

		$devices = Devices::get_by_room($room->id);

		foreach($devices as $device)
		{
			for($port=0; $port < $device->ports; $port++)
			{
				$tat = Temperatures::get_by_device_port($device->id, $port);
				
				$time_and_temperatures = array();
				foreach($tat as $t)
				{
					//convert to an array and format the time to appease the graphing lib
					array_push($time_and_temperatures, array(strtotime($t->time) * 1000, $t->temperature));
				}

				//$all_data = $time_and_temperatures;
				$name ='device: ' . $device->name . ' port: ' . $port;
				$data_set = array($name, $time_and_temperatures);

				array_push($series, $data_set);
			}
		}
		$series = json_encode($series, JSON_NUMERIC_CHECK);
		return $series;
	}


/**
*	gets all temperature deltas from a single device port and preps it to be graphed
*
*/
	public function get_single_port()
	{
		$series = array(); // all of the data that is going to be sent back

		$port_name = (Input::get('port_name'));

		list($device_id, $port_number) = explode(" ", $port_name);

		$deltas = TemperatureDeltas::get_temperature_data_by_device_port($device_id, $port_number);

		for($i = 0; $i < sizeof($deltas); $i++ )
		{
			array_push($series, array( strtotime($deltas[$i]->time) * 1000, 
				floatval($deltas[$i]->open), floatval($deltas[$i]->high), 
				floatval($deltas[$i]->low), floatval($deltas[$i]->close)));
		}

		$deltas = json_encode($deltas, JSON_NUMERIC_CHECK);
		$series = json_encode($series, JSON_NUMERIC_CHECK);
		return $series;
	}
}