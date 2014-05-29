<?php

require_once("ParserFactory.php");
require_once("ITemperatureParser.php");
require_once("TemperatureAlert.php");
require_once("Sample_Data_Generator.php");
require_once("Status_Level.php");


/*
	attempts to connect to each device and get its temperature reading
*/
class Get_Temperatures_Task 
{
	public function run($arguments)
	{
		try
		{ 
			$devices = Devices::get_all();
			if (!$devices)
			{
				throw new Exception('No Devices found!');
			}

			foreach( $devices as $device )
			{

				$parser = ParserFactory::build($device->type, $device->ip_address);
				if (!$parser->is_connected())
				{
					Log::write("error", "Could not retrieve file: " . $device->name . "--" . $device->ip_address);
					$status = "C_N_C";
					Devices::update_status($device->id, $status);
					Devices::count_status($device->id, $status);
					continue;
				}

				//get current temperature for each port
				$ports = intval($device->ports);
				$status = Status_Level::as_number("OK"); //status will be that highest reported of all the ports
				for($port_num = 0; $port_num < $ports; ++$port_num)
				{
		 			//get current temperature
					$current_temp = $parser->get_temperature($port_num);
					Temperatures::insert($current_temp, $port_num, $device->id);
					TemperatureDeltas::insert($current_temp, $port_num, $device->id);

					$new_status = Status_Level::as_number("OK");


					if ($current_temp > $device->warning_threshold)
					{
						$new_status = Status_Level::as_number("WARNING");
						Log::write("warning", "Device: " . $device->name . " exceeded the warning threshold! " . 
							"\n". "current: ". $current_temp . " warning: " . $device->warning_threshold );

						if ($current_temp > $device->alert_threshold)
						{
							$new_status = Status_Level::as_number("ALERT");
							Log::write("warning", "Device: " . $device->name . " exceeded the alert threshold!". 
								"\n". "current: ". $current_temp . " alert: " . $device->alert_threshold );

							if ($current_temp > $device->critical_threshold)
							{
								$new_status = Status_Level::as_number("CRITICAL");
								Log::write("warning", "Device: " . $device->name . " exceeded the critical threshold!". 
									"\n". "current: ". $current_temp . " critical: " . $device->critical_threshold );
							}
						}
					}


					if ($new_status > $status)
					{
						$status = $new_status;
					}
				}

				//if the device's status has changed, update it
				// if($status != Status_Level::as_number($device->status))
				// {
			  		Devices::update_status($device->id, Status_Level::as_string($status));
			 // 	}

			 	if($status != 0)
		 		{
			 		Devices::count_status($device->id, Status_Level::as_string($status));
			 	}
			}
		}

		catch (Exception $e)
		{
			Log::write('error', $e->getMessage());
		}

	}

}