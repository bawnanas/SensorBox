<?php

require_once("Status_Level.php");

Bundle::start('messages');


/*
	iterates through all devices and if the device's status is at alert or higher, aggregate
	all the contacts associated with the room that the device is located in and send out notifications
	to them all that something is happening.
*/

class Send_Notifications_Task
{
	public function run()
	{
		$devices = Devices::get_all();
		foreach($devices as $device)
		{
			if( (Status_Level::as_number($device->status) >= Status_Level::as_number("ALERT")) && $device->message_sent == 0 )
			{
				$user_ids = Assignments::get_users_by_room($device->room_id);
				
				$addresses = array();

				foreach ( $user_ids as $user_id )
				{
					$user = Users::find_by_id(intval($user_id->user_id));
					array_push($addresses, $user->email);

					if($user->phone)
					{
						array_push($addresses, $user->phone . '@' . $user->carrier);
					}
				}

				$room = Rooms::find_by_id($device->room_id);

				Message::bcc( $addresses )
				->from('me@google.com', 'R0-Bob Mailey')
				->subject($device->status)
				->body('Device ' . $device->name . ' in room ' . $room->name . ' exceeds temperature threshold!')
				->send();

				if(Message::was_sent())
				{
					Devices::update_message_sent($device->id, 1);
				}


			}

			// if the device is in the ok state and has recently sent out a message, reset 
			// message sent so that it can send out messages again
			if(($device->status === Status_Level::as_string(0)) && $device->message_sent == 1 ) 
			{
				Devices::update_message_sent($device->id, 0);
			}


		}
	}
}