<?php

class Users extends PHPUnit_Framework_TestCase
{

	public function testTableExists()
	{
		try
		{
			$pdo = DB::connection('mysql')->pdo;
			$stmt = $pdo->query('describe users');
			$stmt->execute();
		
			if($stmt->fetch())
			{
				$this->assertTrue(true);
			}
		}

		catch(Exception $e)
		{
			$this->fail("Table not found. Did you run migrations?");
		}
	}

	// public function test_Insert_Verification_Code()
	// {
	// 	$id = 1;
	// 	$type = 'email';
	// 	$code = 'VKKBL';
	// 	Users::insert_verification_code($id, $type, $code );
	// }

}