<?php

class Controller_Webitem extends Controller
{	
	function __construct()
	{
		$this->model = new Model_Webitem();
		$this->view = new View();
	}

	function action_index()
	{	
		session_start();
		if(isset($_GET['site']))
		{
			$id = $_GET['site'];
			if(isset($_SESSION['Username']))
			{
				$username = $_SESSION['Username'];
				$user_data = $this->model->get_user_data($username);
				$selected_web_data = $this->model->item($id);
				$data = array($user_data, $selected_web_data);
			}
			else
			{
				//$user_data = $this->model->get_user_data($username);
				$selected_web_data = $this->model->item($id);
				$data = array($user_data = "", $selected_web_data);
			}
			//$email = "flirts@flirts.lv";
			//echo "<pre>".print_r($_GET)."</pre>";
			
			$this->view->generate('webitem_view.php', 'template_view.php',$data);
		}
		else
		{
			Route::ErrorPage404();
		}
	}
}