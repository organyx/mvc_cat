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
		if(isset($username))
		{
			if(IS_AJAX)
			{
				if ($this->model->update_user()) 
				{
					$user = $this->model->get_user_data($username);
					$data = array($user);
					$this->view->regenerate('update_view.php', $data);
				}
			}
			else
			{
				$user = $this->model->get_user_data($username);
				$data = array($user);
				$this->view->generate('update_view.php', 'template_view.php', $data);
			}
		}
		else
		{
			Route::ErrorPage404();
		}
	}
}