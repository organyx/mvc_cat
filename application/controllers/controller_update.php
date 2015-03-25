<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
class Controller_Update extends Controller
{

	function __construct()
	{
		$this->model = new Model_Update();
		$this->view = new View();
	}


	function action_index()
	{	
		session_start();
		if(isset($_SESSION['Username']))
		{
			$username = $_SESSION['Username'];
		}
		if(IS_AJAX)
		{
			$user = $this->model->get_user_data($username);
			$update = $this->model->update_user();
			$data = array($user, $update);
			$this->view->regenerate('update_view.php', $data);
		}
		else
		{
			$user = $this->model->get_user_data($username);
			$update = $this->model->update_user();
			$data = array($user, $update);
			$this->view->generate('update_view.php', 'template_view.php', $data);
		}
	}
}