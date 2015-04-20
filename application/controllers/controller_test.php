<?php

class Controller_Test extends Controller
{
	function __construct()
	{
		$this->model = new Model_Test();
		$this->view = new View();
	}

	function action_index()
	{	
		if(IS_AJAX)
		{
			//echo "<pre>".print_r($_POST)."</pre>";
			$this->model->find_user($_POST['name']);
		}
		else
		{
			$this->view->generate('test_view.php', 'template_view.php');
		}
	}
}