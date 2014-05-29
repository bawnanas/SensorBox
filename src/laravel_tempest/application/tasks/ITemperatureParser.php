<?php
/**
* Interface for Temperature Parsers
*/


interface ITemperatureParser
{
	function is_connected();
	function get_temperature($port_num);
}