<?php

function has_table($table)
{
	try
	{
		$pdo = DB::connection('mysql')->pdo;
		$stmt = $pdo->query('describe ' . $table);
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
