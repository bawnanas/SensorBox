<?php

class Create_Device_Types {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('device_types', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name', 45);
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('device_types');
	}

}