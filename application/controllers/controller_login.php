<?php

class Controller_Login extends Controller
{
	function __construct()
	{
		$this->model = new Model_Login();
		$this->view = new View();
	}

	function action_index()
	{
		  	if(isset($_POST['login']) && isset($_POST['password']))
		  	{
		  		$data["login_status"] = "";
			  	$loginUsername=$_POST['login'];
			  	$password = $_POST['password'];
			  	$userAuthorization = "Userlevel";
			  	$redirectLoginSuccessAdmin = "/admin/";
			  	$redirectLoginSuccess = "/account/";
			  	$redirectLoginFailed = "/";

			  	$userinfo = $this->model->get_user($loginUsername);
			  	
				//echo "<pre>".print_r($userinfo)."</pre>";

			  	if(password_verify($password, $userinfo['password']))
				{
				    $loginFoundUser = true;
				}
				else
				{
				    $loginFoundUser = false;
				    $data["login_status"] = "access_denied";
				}

				if($loginFoundUser) 
				{ 
					session_start();
					$loginStrGroup  = $userinfo['Userlevel'];
					 if(isset($_SESSION['lvl'])){
				         $_SESSION['lvl']=$loginStrGroup;
				    }else{
				         $_SESSION['lvl']=$loginStrGroup;
				    }
			  		//////
			  		if (PHP_VERSION >= 5.1) {
			  			session_regenerate_id(true);
			  		} else {
			  			session_regenerate_id();
			  			}
			  		$data["login_status"] = "access_granted";
			  		$_SESSION['Username'] = $loginUsername;
	    			$_SESSION['UserGroup'] = $loginStrGroup;
	    			if($_SESSION['lvl'] == 2)
	    			{
	    				header('Location:'.$redirectLoginSuccessAdmin);	
	    			}  
	    			else if($_SESSION['lvl'] == 1)
	    			{
	    				header('Location:'.$redirectLoginSuccess);
	    			}
		  		}
		  		
			}
			else
			{
				$data["login_status"] = "";
			}
			$this->view->generate('login_view.php', 'template_view.php',$data);
	}
}
