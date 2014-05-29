<?php

class Create_Assignments_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assignments', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('room_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('cascade');
			$table->foreign('room_id')->references('id')->on('rooms')->on_update('cascade')->on_delete('cascade');
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
		Schema::drop('assignments');
	}

}