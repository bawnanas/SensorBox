<?php

class Test_Controller extends Base_Controller
{
	public $restful = true;
	public function get_index()
	{
		$view = View::make('test.index');
		$view->names = Rooms::get_column('name');

		return $view;
	}

	public function post_index()
	{
		$view = View::make('test.index');
		return $view;
	}

	public function get_ajax()
	{
		$names = Rooms::get_column('name');

		$names = json_encode($names);
		return $names;
	}

	public function post_testpost()
	{
		$names = Rooms::get_column(Input::get());

		$names = json_encode($names);
		return $names;
	}

	public function get_is_ajax()
	{
		$is_ajax = 'call to ajax controller';
		if(Request::ajax())
			$is_ajax = 'recognized as ajax';


		return $is_ajax;
	}
}