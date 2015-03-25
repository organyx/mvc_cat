<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
class Controller_Admin extends Controller
{
	function __construct()
	{
		$this->model = new Model_Admin();
		$this->view = new View();
	}
	
	function action_index()
	{
		session_start();
		
		if ( $_SESSION['lvl'] == 2 )
		{
			if(isset($_SESSION['Username']))
			{
				$username = $_SESSION['Username'];
			}
			$user = $this->model->get_user_data($username);
			$users = $this->model->manage_users();
			$data = array($user, $users);
			$this->view->generate('admin_view.php', 'template_view.php',$data);
		}
		else
		{
			session_destroy();
			Route::ErrorPage404();
		}
	}
	
	function action_logout()
	{
		session_start();
		session_destroy();
		header('Location:/');
	}

}
