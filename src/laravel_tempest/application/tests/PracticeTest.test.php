<?php

class PracticeTest extends PHPUnit_Framework_TestCase
{
	public function testHelloWorld()
	{
		$greeting = "hello world";

		$this->assertTrue($greeting === "hello world");
	}

	public function testSimpleSum()
	{
		$sum = 2+2;

		$this->assertTrue($sum == 4);
	}

		/**
	 * Test the basic routing mechanism.
	 *
	 * @group laravel
	 */
}