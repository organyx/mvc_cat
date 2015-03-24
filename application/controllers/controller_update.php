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
		$user = $this->model->get_user_data($user = "jeez@jeez.lv");
		$update = $this->model->update_user();
		$data = array($user, $update);
		$this->view->generate('update_view.php', 'template_view.php', $data);
	}
}