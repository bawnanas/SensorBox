<?php
class Generate_Boilerplate_Parser_Task
{
	public function run($name)
	{
		try
		{
			//Log::write('info', 'generating boilerplate ');
		$file = getcwd() . '/application/tasks/' . 'DELETE_ME' . "php";
		$fp = fopen($file, 'c' );

			 fclose($fp);
		}

		catch(Exception $e)
		{
			Log::write('error', $e->getMessage());
			return Response::error('500');
		}
	}
}