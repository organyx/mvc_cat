<?php

class Model_Register extends Model
{
	
	public function register()
	{	
		Global $WebCatalogue;

		$sql="SELECT * FROM `users` WHERE NOT `approval` = '0000-00-00 00:00:00' AND NOT `Userlevel` = '2' ORDER BY registration DESC";
 
		$result=$WebCatalogue->query($sql);
			 
	}


	public function check_user_input()
	{
		Global $WebCatalogue;

		if(empty($_POST['first_name']))
	  	{
		    echo "Please enter your name.";
		    return false;
	  	}

	  	if(empty($_POST['last_name']))
	  	{
		    echo "Please enter your last name.";
		    return false;
	  	}

	  	if(ctype_alpha($_POST['first_name']) || ctype_alpha($_POST['last_name'])) {
	  	}
	  	else {
		    echo "Personal fields contain invalid data.";
		    return false;
	  	}

	  	if(filter_var($loginUsername, FILTER_VALIDATE_EMAIL) && !empty($loginUsername)) {    
	 	}
	  	else {
		    echo "Please enter a valid email.";
		    return false;
	  	}

	  	$login_check_query = sprintf("SELECT email FROM `users` WHERE email=%s", GetSQLValueString($loginUsername, "text"));
	  	$login_check = $WebCatalogue->query($login_check_query);
	  	$login_found_user = $login_check->num_rows;

	  //if there is a row in the database, the username was found - can not add the requested username
	  	if($loginFoundUser){
		    echo "Username Already Exists.";
		    return false;
	  	}

	  	if(empty($_POST['password'])) 
	  	{
		    echo "Password field cannot be empty.";
		    return false;
	  	}

	  	if(empty($_POST['passwordwc']))
	  	{
		    echo "Please confirm your password.";
		    return false;
	  	}

	  	if(filter_var($_POST['url'], FILTER_VALIDATE_URL)) {    
	  	}
	  	else {
		    echo "Url is broken.";
		    return false;
	  	}

	  	if(empty($_POST['title']))
	  	{
		    echo "Please enter website title.";
		    return false;
	  	}

	  	$passwordToConfirm = $_POST['password'];
	  	$passwordConfirm = $_POST['passwordwc'];
	  	if($passwordToConfirm != $passwordConfirm)
	  	{
		    echo "Passwords don't match.";
		    return false;
	  	}
	  	// else
	  	// {
		  //   $secure_password = password_hash($passwordToConfirm, PASSWORD_BCRYPT);
		  //   return array(true, $secure_password);
	  	// }

	  	return true;
	}

}