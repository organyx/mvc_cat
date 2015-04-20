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
		if(IS_AJAX)
		{
			//echo "<pre>".print_r($_POST)."</pre>";
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
			}
		}
		else
		{
			$this->view->generate('test_view.php', 'template_view.php');
		}
	}
}