<?php

class Add_User {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$password = Hash::make('secret');
		DB::table('users')->insert(array(
			'username'=>'seeded_admin',
			'email' => 'wmu.ceas.tempest@gmail.com',
			'password' => $password, 
			'is_admin' => 1,
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
		DB::table('users')->where('username', '=', 'seeded_admin')->delete();	}

}