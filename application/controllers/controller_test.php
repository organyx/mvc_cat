<?php

class Controller_Test extends Controller
{
	function __construct()
	{
		//$this->model = new Model_Main();
		$this->view = new View();
	}

	function action_index()
	{	
		if(IS_AJAX)
		{

		}
		else
		{
			$this->view->generate('test_view.php', 'template_view.php');
		}
	}
}