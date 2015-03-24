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
		$data = $this->model->forgot_pass();
		$this->view->generate('forgot_pass_view.php', 'template_view.php',$data);
	}
}