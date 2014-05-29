<?php

/**
* Will create a parser depending on the type device
* 
*	only one parser currently, with one dummy class, to show extensibility and shhhtuff
*
*
*/
class ParserFactory
{
	public static function build($type, $ip_address)
	{
		if ($type === "TemperatureAlert")
		{
			return new TemperatureAlert($ip_address);
		}
		elseif( $type === "Sample_Data_Generator")
		{
			return new Sample_Data_Generator('dummy argument');
		}

		else
		{
			Log::write('error', $type . " not supported.");
		}
	}
}