<?php

class Create_Temperature_Deltas_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('temperature_deltas', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->float('open');
			$table->float('close');
			$table->float('low');
			$table->float('high');
			$table->date('time');
			$table->integer('port')->unsigned();

			$table->integer('device_id')->unsigned();
			$table->foreign('device_id')->references('id')->on('devices')->on_update('cascade')->on_delete('cascade');
		});	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('temperature_deltas');
	}

}