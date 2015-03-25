<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
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
			//echo "<pre>".print_r($_POST)."</pre>";
			$data = $this->model->forgot_pass();
			$this->view->regenerate('forgot_pass_view.php',$data);
		}
		else
		{
			//$data = $this->model->forgot_pass();
			$this->view->generate('forgot_pass_view.php', 'template_view.php');
		}
	}
}