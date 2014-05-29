<?php

class Add_Devices {

	/**
	 * Make changes to the database.
	 *
	 *   if you don't want these after the 'migrate'
	 *     just remove and migrate again
	 *
	 * @return void
	 */


	public function up()
	{	
		DB::table('devices')->insert(array(
			'name'=>'sample_device',
			'ip_address'=>'http://www.pulaskicircuitcourt.com/xmlfeed.rb',
			'warning_threshold'=>75,
			'alert_threshold'=>85,
			'critical_threshold'=>90,
			'status'=>"C_N_C",
			'type'=>'Sample_Data_Generator',
			'message_sent'=>0,
			'ports'=>4,
			'room_id'=>1,
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
			));

		DB::table('devices')->insert(array(
			'name'=>"PC Solutions",
			'ip_address'=>'http://temp.pcsolutions.cc:82/xmlfeed.rb',
			'warning_threshold'=>75,
			'alert_threshold'=>85,
			'critical_threshold'=>90,
			'status'=>'C_N_C',
			'type'=>'TemperatureAlert',
			'message_sent'=>0,
			'ports'=>1,
			'room_id'=>3,
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
			));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('devices')->where('name', '=', 'dv_1')->delete();
		DB::table('devices')->where('name', '=', 'dv_2')->delete();
	}

}