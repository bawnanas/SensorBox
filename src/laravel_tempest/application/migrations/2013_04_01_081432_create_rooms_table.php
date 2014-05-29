<?php

class Create_Rooms_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rooms', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name', 45);
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
		Schema::drop('rooms');
	}

}