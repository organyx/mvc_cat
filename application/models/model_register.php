<?php

	$GLOBALS['flag'] = false;
	$GLOBALS['secure_password'] = "";
	$GLOBALS['file'] = "";

class Model_Register extends Model
{

	public function min_max_pass($password)
	{
		$min = 8;
		$max = 32;
		 if (strlen($password) > $max)
		 {
		   return 1;
		 } 
		 elseif (strlen($password) < $min)
		 {
		   return -1;
		 }
		 else
		 {
		   return 0;
		 }
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

	  	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email'])) {    
	 	}
	  	else {
		    echo "Please enter a valid email.";
		    return false;
	  	}

	  	$login_check_query = sprintf("SELECT email FROM `users` WHERE email=%s", GetSQLValueString($_POST['email'], "text"));
	  	$login_check = $WebCatalogue->query($login_check_query);
	  	if($login_check === false)
	  	{
	  		trigger_error('Wrong SQL: ' . $login_check_query . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
	  	}
	  	else
	  	{
	  		//echo $login_check = $login_check->fetch_assoc();
	  		$login_check->data_seek(0);
	  		$login_found_user = $login_check->num_rows;
	  	}

	  //if there is a row in the database, the username was found - can not add the requested username
	  	if($login_found_user){
		    echo "Username Already Exists.";
		    return false;
	  	}

	  	if(empty($_POST['password'])) 
	  	{
		    echo "Password field cannot be empty.";
		    return false;
	  	}

	  	switch ($this->min_max_pass($_POST['password'])) {
		    	case '-1':
		    		echo "Password is too short.";
		    		return false;
		    		break;
		    	case '1':
		    		echo "Password is too long.";
		    		return false;
		    		break;
		    }

	  	if(empty($_POST['passwordwc']))
	  	{
		    echo "Please confirm your password.";
		    return false;
	  	}

	  	if(empty($_POST['url']))
	  	{
		    echo "Please enter website address.";
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
	  	else
	  	{
		    $GLOBALS['secure_password'] = password_hash($passwordToConfirm, PASSWORD_BCRYPT);
		    return true;
	  	}

	  	return true;
	}

	public function upload_file()
	{
		  $default_picture = "assets/img/default.png/";
		  $user_folder_path = "assets/img/" . basename($_POST['email']) . "/";
		  $user_folder_path_check = "assets/img/" . basename($_POST['email']) . "/";

		  if (!file_exists($user_folder_path_check) && !is_dir($user_folder_path_check) && !is_writable($user_folder_path_check)) 
		  {
		     $dir = mkdir("assets/img/" . basename($_POST['email']), 0777, true);
		  }

		  if(isset($_FILES['file']) && $_FILES['file']['size'] != 0) {
		    $target_dir = "assets/img/" . basename($_POST['email']) . "/";
		    $target_file = $target_dir . basename($_FILES['file']["name"]);
		    $uploadOk = 1;
		    
		    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		    // Check if image file is a actual image or fake image
		    if(isset($_POST["submit"]) && $GLOBALS['flag'] != false) {
		        $check = getimagesize($_FILES['file']["tmp_name"]);
		        if($check !== false) {
		            echo "File is an image - " . $check["mime"] . ".";
		            $uploadOk = 1;
		        } else {
		            echo "File is not an image.";
		            $uploadOk = 0;
		        }
		    }
		    // Check file size
		    if ($_FILES['file']["size"] > 2000000) {
		        echo "Sorry, your file is too large.";
		        $uploadOk = 0;
		    }
		    // Check if file already exists
		    if (file_exists($target_file)) {
		        echo "Sorry, file already exists.";
		        $uploadOk = 0;
		    } 
		    // Allow certain file formats
		    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {

		      echo "Sorry, only JPG, JPEG & PNG files are allowed.";
		      $uploadOk = 0;
		    } 
		    // Check if $uploadOk is set to 0 by an error
		    if ($uploadOk == 0) {
		        echo "Sorry, your file was not uploaded.";
		    // if everything is ok, try to upload file
		    } else {
		      //Change absolute to relative when moving
		        if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . "/" . $target_file)) {
		            echo "The file ". basename($_FILES['file']["name"]). " has been uploaded.<br/>";
		            $GLOBALS['flag'] = true;
		        } else {
		             echo "Sorry, your file was not uploaded. Failed to move. <br/>" . "<br/> Move to: ". "assets/img/" . basename($_POST['email']) . "/" . basename($_FILES["file"]["name"]) ."<br/>";
		             $GLOBALS['flag'] = false;
		        }
		    }
		  }
		  else
		  {
		     copy("assets/img/default.png", "assets/img/" . basename($_POST['email']) . "/default.png");
		     $GLOBALS['flag'] = true;
		  }

		  if(!isset($_FILES["file"]) || ($_FILES['file']["size"] == 0))
		  {
		    return $GLOBALS['file'] = $user_folder_path . "default.png";
		  }
		  else
		  {
		    return $GLOBALS['file'] = $user_folder_path . basename($_FILES['file']['name']);
		  }
	}


	public function register()
	{	
		Global $WebCatalogue;

		if($this->check_user_input())
		{
			if($this->upload_file() && $GLOBALS['flag'] == true)
			{
				$sql=sprintf("INSERT INTO users (email, password, first_name, last_name, `language`, url, title, `description`, preview, preview_thumb) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($GLOBALS['secure_password'], "text"),
                       GetSQLValueString($_POST['first_name'], "text"),
                       GetSQLValueString($_POST['last_name'], "text"),
                       GetSQLValueString($_POST['lang'], "text"),
                       GetSQLValueString($_POST['url'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['descr'], "text"),
                       GetSQLValueString($GLOBALS['file'], "text"),
                       GetSQLValueString($GLOBALS['file'], "text"));
 
				$result=$WebCatalogue->query($sql);
				echo "Registration Succesful.";	
				return "Registration Succesful.";	
			}
		} 
		else
		{
			echo "Registration Failed.";
			return "Registration Failed.";
		}
	}

}