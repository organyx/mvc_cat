<?php
class Controller_Account extends Controller
{
	function __construct()
	{
		$this->model = new Model_Account();
		$this->view = new View();
	}

	function action_index()
	{	
		session_start();
		if(isset($_SESSION['Username']))
		{
			$user = $_SESSION['Username'];
		}
		if(isset($user))
		{
			$data = $this->model->get_user_data($user);
			$this->view->generate('account_view.php', 'template_view.php', $data);
		}
		else
		{
			session_destroy();
			Route::ErrorPage403();
		}
	}

	// function action_update()
	// {
	// 	session_start();
	// 	if(isset($_SESSION['Username']))
	// 	{
	// 		$user = $_SESSION['Username'];
	// 	}
	// 	if(isset($user))
	// 	{
	// 		$data = $this->model->get_user_data($user);
	// 		$this->view->generate('update_view.php', 'template_view.php', $data);
	// 	}
	// 	else
	// 	{
	// 		Route::ErrorPage403();
	// 	}
	// }

	function action_logout()
	{
		session_start();
		session_destroy();
		header('Location:/');
	}
}