<?php

class Add_Rooms {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('rooms')->insert(array(
			'name'=>'Room_A0',
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")
			));
		DB::table('rooms')->insert(array(
			'name'=>'Room_B1',
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s")));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('rooms')->where('name', '=', 'Room_A0')->delete();
		DB::table('rooms')->where('name', '=', 'Room_B1')->delete();
	}

}