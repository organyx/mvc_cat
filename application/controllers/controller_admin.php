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
				$current_user = $_SESSION['Username'];
			}
			if(isset($_POST['name']))
			{
				$user_to_find = $_POST['name'];
			}
			if(isset($_POST['id']))
			{
				$item_id = $_POST['id'];
			}
			if (IS_AJAX)
			{	
				$user = $this->model->get_user_data($current_user);
				$users = $this->model->manage_users();
				$data = array($user, $users);
				//$this->view->regenerate('admin_view.php',$data);

				//CHECK WHAT BUTTONS PRESSED
				if(isset($_POST['action']) && !empty($_POST['action'])) 
				{
				    $action = $_POST['action'];
				    switch($action) {
				        case 'approve' : 
					        	$this->approve_web($item_id);
					        	break;
				        case 'delete' : 
				        		$this->delete_web($item_id);
					        	break; 
					    case 'search' :
					    		$this->find_user($current_user, $user_to_find);
					    		break;
				    }
				}

				
			}
			else
			{
				//DEFAULT
				$user = $this->model->get_user_data($current_user);
				//$users = $this->model->manage_users();
				//$data = array($user, $users);
				$data = array($user);
				$this->view->generate('admin_view.php', 'template_view.php',$data);
			}
		}
		else
		{
			session_destroy();
			Route::ErrorPage404();
		}
	}

	function approve_web($item_id)
	{
		$return = $_POST;
		$return['json'] = json_encode($return);
		//echo $return['json'];
		$approved = $this->model->approve_web($return['id']);
		$users = $this->model->manage_users();
		$data = array($approved, $users);
		//$this->view->regenerate('admin_view.php', $data);
	}

	function delete_web($item_id)
	{
		$return = $_POST;
		$return['json'] = json_encode($return);
		//print_r($return);
		$deleted = $this->model->delete_web($return['id']);
		$users = $this->model->manage_users();
		$data = array($deleted, $users);
		//$this->view->regenerate('admin_view.php', $data);
	}

	function find_user($current_user, $user_to_find)
	{
		//echo "<pre>".print_r($_POST)."</pre>";
		$return = $_POST;
		$return['json'] = json_encode($return);
		//echo $return['json'];
		$user = $this->model->get_user_data($current_user);
		$users = $this->model->manage_users();
		$found_user = $this->model->find_user($return['name']);
		$data = array($user, $users, $found_user);
		//echo "<pre>".print_r($data)."</pre>";
		//$this->view->regenerate('admin_view.php', $data);
	}
	
	function action_logout()
	{
		session_start();
		session_destroy();
		header('Location:/');
	}

}
