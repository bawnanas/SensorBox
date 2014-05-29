<?php
/*
	creates a report and saves it {project_root}/reports as well as sends it to each admin.
*/

class Generate_Report_Task
{

	public function run($arguments)
	{
		$date = getdate();
		$d = $date['mon'] . '_' . $date['mday'] . '_' . $date['year'];
		$file = getcwd() . '/reports/' . $d . '_tempest_report.txt';
		$fp = fopen($file, 'c' );

		$rooms = Rooms::get_all();
		$users = Users::get_all();

		$this->write_unassigned_rooms($fp, $rooms);

		$this->write_unverified_users($fp, $users);

		$this->write_device_details($fp, $rooms);

		fclose($fp);

		$this->send_report($file, $users);
	}


/**
*	writes basic info such as highs, lows, and averages of each device over a week
*	as well as the number of times it was unreachable, and it certain thresholds.
*
*	@param: int, int
*
*	@return: void
*/
	private function write_device_details($fp, $rooms)
	{
		//for each device, display the min, max temperature (may average temerature), status counts
		foreach($rooms as $room)
		{
			fwrite($fp, "===================================================================\n");
			fwrite($fp, $room->name . "\n");
			fwrite($fp, "===================================================================\n");

			$devices = Devices::get_all_by_room($room->id);
			foreach($devices as $device)
			{
				fwrite($fp, "-------------------------------------------------------------------\n");
				fwrite($fp, "Device Name \tDisconnects \tWarnings \tAlerts \tCriticals\n");
				fwrite($fp, "-------------------------------------------------------------------\n");
				fwrite($fp, $device->name . "\t");
				if(strlen($device->name) < 12 )
				{
					fwrite($fp, "\t");
				}
				fwrite($fp, $device->c_n_c_count . "\t\t\t\t");
				fwrite($fp, $device->warning_count . "\t\t\t");
				fwrite($fp, $device->alert_count . "\t\t");
				fwrite($fp, $device->critical_count . "\t");

				fwrite($fp, "\n...................\n");

				fwrite($fp, "Port# \tMin \t\tMax \t\tAverage\n");
				for($port = 0; $port < $device->ports; $port++)
				{
					$min = number_format(Temperatures::get_week_min($device->id, $port), 1);
					$max = number_format(Temperatures::get_week_max($device->id, $port), 1);
					$avg = number_format(Temperatures::get_week_avg($device->id, $port), 2);
					fwrite($fp, $port . "\t\t");
					fwrite($fp, $min . "\t\t");
					fwrite($fp, $max . "\t\t");
					fwrite($fp, $avg . "\t\t");
					fwrite($fp, "\n");
				}
				fwrite($fp, "...................\n");
				fwrite($fp, "\n");

				//reset the counts back to 0
				Devices::reset_counts($device->id);
			}

			fwrite($fp, "\n\n");
		}
	}


/**
*	writes all rooms that do not have anyone assigned to them
*
*	@param: resource, array
*
*	@return: void
*/
	private function write_unassigned_rooms($fp, $rooms)
	{
		//show rooms with no assignments
		fwrite($fp, "===================================================================\n");
		fwrite($fp, "Rooms with No Users Assigned\n");
		fwrite($fp, "===================================================================\n");
		fwrite($fp, "Room Name\n");
		fwrite($fp, "-------------------------------------------------------------------\n");
		foreach($rooms as $room)
		{
			$assignments = Assignments::get_users_by_room($room->id);
			if(!$assignments)
			{
				fwrite($fp, $room->name . "\n");
			}
		}

		fwrite($fp, "\n\n");
	}



/**
*	writes all users who have yet to verify their contact information
*
*	@param: resource, array
*
*	@return: void
*/
	private function write_unverified_users($fp, $contacts)
	{
				//show contacts who are not verified
		fwrite($fp, "===================================================================\n");
		fwrite($fp, "Contacts Not Verified\n");
		fwrite($fp, "===================================================================\n");
		fwrite($fp, "Name \t\t\tPhone/Email\n");
		fwrite($fp, "-------------------------------------------------------------------\n");
		
		foreach ($contacts as $contact) 
		{

			if($contact->email_verified == 0)
			{
				fwrite($fp, $contact->username . "\t");
				if(strlen($contact->username) < 11)
				{
					fwrite($fp, "\t\t");
				}
				if(strlen($contact->username) < 5)
				{
					fwrite($fp, "\t");
				}
				fwrite($fp, $contact->email ."\t");
				fwrite($fp, "\n");
			}


			if($contact->phone != null && $contact->phone_verified == 0)
			{
				fwrite($fp, $contact->username . "\t");
				if(strlen($contact->username) < 11)
				{
					fwrite($fp, "\t\t");
				}
				if(strlen($contact->username) < 5)
				{
					fwrite($fp, "\t");
				}
				fwrite($fp, $contact->phone . '@' . $contact->carrier ."\t");
				fwrite($fp, "\n");
			}
		}
	}


/**
*	sends the report to all admins
*
*	@param: resource, array
*
*	@return: void
*/
	private function send_report($file, $users)
	{
		$addresses = array();
		foreach ($users as $user) 
		{
			if($user->is_admin)
			{
				array_push($addresses, $user->email);
			}
		}


		Bundle::start('messages');

		Message::bcc( $addresses )
			->from('me@google.com', 'R0-Bob Mailey')
			->subject("Tempest_Report")
			->body("Weekly report attached.")
			->attach($file)
			->send();
	}
}