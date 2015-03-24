<?php

class Controller_Main extends Controller
{

	function action_index()
	{	
		$this->view->generate('update_account_view.php', 'template_view.php');
	}
}