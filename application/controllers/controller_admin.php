<?php

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
		
		/*
		Для простоты, в нашем случае, проверяется равенство сессионной переменной admin прописанному
		в коде значению — паролю. Такое решение не правильно с точки зрения безопасности.
		Пароль должен храниться в базе данных в захешированном виде, но пока оставим как есть.
		*/
		if ( $_SESSION['admin'] == "12345" )
		{
			$user = $this->model->get_user_data($user = "jeez@jeez.lv");
			$users = $this->model->manage_users();
			$data = array($user, $users);
			$this->view->generate('admin_view.php', 'template_view.php',$data);
		}
		else
		{
			session_destroy();
			Route::ErrorPage404();
		}
	}
	
	// Действие для разлогинивания администратора
	function action_logout()
	{
		session_start();
		session_destroy();
		header('Location:/');
	}

}
