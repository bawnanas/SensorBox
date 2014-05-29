<?php

class Add_Carriers {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('carriers')->insert(array(
			'name'=>'Please select one', 
			'domain' => ''
			));

		DB::table('carriers')->insert(array(
			'name'=>'Altel',
			'domain'=>'message.alltel.com',
			));


		DB::table('carriers')->insert(array(
			'name'=>'at&t',
			'domain'=>'txt.att.net',
			));

		DB::table('carriers')->insert(array(
			'name'=>'Bellsouth',
			'domain'=>'bellsouth.cl',
			));

		DB::table('carriers')->insert(array(
			'name' => 'Boost', 
			'domain' => 'sms.myboostmobile.com',
			));

		DB::table('carriers')->insert(array(
			'name' => 'CellularOne', 
			'domain' => 'mobile.celloneusa.com',
			));

		DB::table('carriers')->insert(array(
			'name' => 'CellularOne mms1', 
			'domain' => 'mms.uscc.net',
			));

		DB::table('carriers')->insert(array(
			'name' => 'Cingular', 
			'domain' => 'mobile.mycingular.com',
			));

		DB::table('carriers')->insert(array(
			'name' => 'Comcast', 
			'domain' => 'comcastpcs.textmsg.com',
			));

		DB::table('carriers')->insert(array(
			'name' => 'Edge Wireless', 
			'domain' => 'sms.edgewireless.com',
			));

		DB::table('carriers')->insert(array(
			'name' => 'MetroPCS', 
			'domain' => 'mymetropcs.com',
			));
	
		DB::table('carriers')->insert(array(
			'name' => 'Sprint', 
			'domain' => 'messaging.sprintpcs.com',
			));

		DB::table('carriers')->insert(array(
			'name' => 'T-Mobile', 
			'domain' => 'tmomail.net ',
			));

		DB::table('carriers')->insert(array(
			'name' => 'US Cellular', 
			'domain' => 'email.uscc.net ',
			));

		DB::table('carriers')->insert(array(
			'name' => 'Verizon', 
			'domain' => 'vtext.com',
			));

		DB::table('carriers')->insert(array(
			'name' => 'Virgin Mobile', 
			'domain' => 'vmobl.com',
			));


	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('carriers')->delete(1);
		DB::table('carriers')->delete(2);
		DB::table('carriers')->delete(3);
		DB::table('carriers')->delete(4);
		DB::table('carriers')->delete(5);
		DB::table('carriers')->delete(6);
		DB::table('carriers')->delete(7);
		DB::table('carriers')->delete(8);
		DB::table('carriers')->delete(9);
		DB::table('carriers')->delete(10);
		DB::table('carriers')->delete(11);
		DB::table('carriers')->delete(12);
		DB::table('carriers')->delete(13);
		DB::table('carriers')->delete(14);
		DB::table('carriers')->delete(15);
		DB::table('carriers')->delete(16);
	}
}