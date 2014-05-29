<?php

class Carriers
{


/**
*	gets all carriers from table carriers
*
*	@param: 
*
*	@return: boolean
*/	
	public static function get_all()
	{
		try
		{
			$carriers = DB::table('carriers')->get();
			return $carriers;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}


/**
*	gets all carriers from carrier table and returns it as an associative array.
*	this is used mainly to create drop down boxes in a form.
*
*	@param: string, string
*
*	@return: array
*/
	public static function get_columns_as_associative_array($col1, $col2)
	{
		try
		{
			$carriers_data = DB::table('carriers')->get(array($col1, $col2));
			foreach ($carriers_data as $key => $value)
			{
				$carriers[$value->domain] = $value->name;
			}
			return $carriers;
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			throw $e;
		}
	}
}