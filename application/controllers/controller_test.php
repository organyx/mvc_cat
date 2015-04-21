<?php

class Controller_Test extends Controller
{
	function __construct()
	{
		$this->model = new Model_Test();
		$this->view = new View();
	}

	function action_index()
	{	
		session_start();

		if($_SESSION['lvl'] == 2)
		{
			if(isset($_SESSION['Username']))
			{
				$current_user = $_SESSION['Username'];
			}

			if(IS_AJAX)
			{
				if(isset($_POST['action']))
				{
					switch($_POST['action'])
					{
						case 'search':
							$this->model->find_user($_POST['name']);
							break;
						case 'approve':
							$this->model->approve_web($_POST['id']);
							break;
						case 'delete':
							$this->model->delete_web($_POST['id']);
							break;
						case 'auto':
							$this->model->auto();
							break;
					}
				}
				else
					$this->model->get_web_list();
			}
			else
			{
				$user = $this->model->get_user_data($current_user);
				$data = array($user);
				$this->view->generate('test_view.php', 'template_view.php', $data);
			}
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