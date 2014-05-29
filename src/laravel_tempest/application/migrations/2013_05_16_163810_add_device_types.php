<?php

class Add_Device_Types {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('device_types')->insert(array(
			'name'=>'TemperatureAlert'
			));

		DB::table('device_types')->insert(array(
			'name'=>'Sample_Data_Generator'
			));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('device_types')->delete(1);
		DB::table('device_types')->delete(2);
	}

}