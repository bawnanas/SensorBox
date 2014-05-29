<?php

class Create_Devices_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devices', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name', 45)->unique();
			$table->string('ip_address', 100)->unique();
			$table->float('warning_threshold')->default(80)->nullable();
			$table->float('alert_threshold')->default(85)->nullable();
			$table->float('critical_threshold')->default(90)->nullable();
			$table->string('status', 45)->default('C_N_C'); // C_N_C == could not connect
			$table->string('type', 45)->default('TemperatureAlert');
			$table->integer('message_sent')->unsigned()->default(0)->nullable();
			$table->integer('ports')->unsigned()->default(1)->nullable();
			$table->integer('room_id')->unsigned();
			$table->foreign('room_id')->references('id')->on('rooms')->on_update('cascade')->on_delete('cascade');
			
			$table->integer('c_n_c_count');
			$table->integer('warning_count');
			$table->integer('alert_count');
			$table->integer('critical_count');
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('devices');
	}

}