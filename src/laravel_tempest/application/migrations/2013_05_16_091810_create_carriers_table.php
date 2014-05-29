<?php

class Create_Carriers_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carriers', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name', 45);
			$table->string('domain', 45);
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('carriers');
	}

}