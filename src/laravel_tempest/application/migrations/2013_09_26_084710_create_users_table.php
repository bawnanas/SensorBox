<?php

class Create_Users_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('username', 30)->index();
			$table->string('password', 60)->index();
			$table->string('email', 255)->index();
			$table->boolean('email_verified')->default(0);
			$table->string('phone', 20)->nullable();
			$table->string('carrier', 45)->nullable();
			$table->boolean('phone_verified')->default(0);
			$table->string('email_verification_code', 5)->nullable();
			$table->string('phone_verification_code', 5)->nullable();
			$table->boolean('is_admin')->nullable()->default(0);
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
		Schema::drop('users');
	}

}