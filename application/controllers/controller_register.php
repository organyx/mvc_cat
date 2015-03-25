<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
class Controller_Register extends Controller
{
	function __construct()
	{
		$this->model = new Model_Register();
		$this->view = new View();
	}

	function action_index()
	{	
		session_start();
		if(IS_AJAX)
		{
			$data = $this->model->register();
			$this->view->regenerate('register_view.php',$data);
		}
		else
		{
			$this->view->generate('register_view.php', 'template_view.php');
		}
		
	}
}