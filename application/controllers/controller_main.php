<?php

class Controller_Main extends Controller
{
	function __construct()
	{
		$this->model = new Model_Main();
		$this->view = new View();
	}

	function action_index()
	{	
		session_start();
		if(IS_AJAX)
		{
			$data = $this->model->get_web_list();
		}
		else
		{
			$this->view->generate('main_view.php', 'template_view.php');
		}
	}
}