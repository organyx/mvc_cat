<?php

class Controller_Forgot_pass extends Controller
{
	function __construct()
	{
		$this->model = new Model_Forgot_Pass();
		$this->view = new View();
	}

	function action_index()
	{	
		session_start();
		if(IS_AJAX)
		{
			$data = $this->model->forgot_pass();
		}
		else
		{
			$this->view->generate('forgot_pass_view.php', 'template_view.php');
		}
	}
}