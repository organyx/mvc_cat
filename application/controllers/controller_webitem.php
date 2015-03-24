<?php

class Controller_Webitem extends Controller
{	
	function __construct()
	{
		$this->model = new Model_Webitem();
		$this->view = new View();
	}

	function action_item()
	{	
		$id = $_GET['site'];
		$email = "flirts@flirts.lv";
		//echo "<pre>".print_r($_GET)."</pre>";
		$user_data = $this->model->get_user_data($email);
		$selected_web_data = $this->model->item($id);
		$data = array($user_data, $selected_web_data);
		$this->view->generate('webitem_view.php', 'template_view.php',$data);
	}
}