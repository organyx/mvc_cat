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
			if (IS_AJAX)
			{	
				//CHECK WHAT BUTTONS PRESSED
				if(isset($_POST['action']) && !empty($_POST['action'])) 
				{
				    $action = $_POST['action'];
				    switch($action) {
				        case 'approve' : 
					        	$this->approve_web();
					        	break;
				        case 'delete' : 
				        		$this->delete_web();
					        	break; 
					    case 'search' :
					    		$this->find_user($username);
					    		break;
				    }
				}
			}
			else
			{
				//DEFAULT
				$user = $this->model->get_user_data($username);
				$users = $this->model->manage_users();
				$data = array($user, $users);
				$this->view->generate('admin_view.php', 'template_view.php',$data);
			}
		}
		else
		{
			session_destroy();
			Route::ErrorPage404();
		}
	}

	function approve_web()
	{
		$id = $_POST['id'];
		//echo $id;
		$approved = $this->model->approve_web($id);
		$users = $this->model->manage_users();
		$data = array($approved, $users);
		$this->view->regenerate('admin_view.php', $data);
	}

	function delete_web()
	{
		$id = $_POST['id'];
		$deleted = $this->model->delete_web($id);
		$users = $this->model->manage_users();
		$data = array($deleted, $users);
		$this->view->regenerate('admin_view.php', $data);
	}

	function find_user($username)
	{
		$user = $this->model->get_user_data($username);
		$users = $this->model->manage_users();
		$found_user = $this->model->find_user($_POST['name']);
		$data = array($user, $users, $found_user);
		$this->view->regenerate('admin_view.php', $data);
	}
	
	function action_logout()
	{
		session_start();
		session_destroy();
		header('Location:/');
	}

}
