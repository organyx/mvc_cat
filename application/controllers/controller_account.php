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
		$data = $this->model->get_user_data($user = "jeez@jeez.lv");
		$this->view->generate('account_view.php', 'template_view.php', $data);
	}
}