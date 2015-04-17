<?php

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
			session_destroy();
			Route::ErrorPage404();
		}
	}
}