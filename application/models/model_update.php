<?php

	$GLOBALS['flag'] = false;
	$GLOBALS['passCheck'] = false;
	$GLOBALS['secure_password'] = "";
	$GLOBALS['file'] = "";

class Model_Update extends model
{
	public function get_user_data($email)
	{
		//header("content-type:application/json");
		Global $WebCatalogue;

			$colname_User = "-1";
			if (isset($_SESSION['MM_Username'])) 
			{
			  $colname_User = $_SESSION['MM_Username'];
			}
			else
			{
				$colname_User = $email;
			}

			$sql=sprintf("SELECT * FROM users WHERE email = %s", GetSQLValueString($colname_User, "text"));
 
			$result=$WebCatalogue->query($sql);
			 
			if($result === false) 
			{
			  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
			} 
			else 
			{
			  $totalRows = $result->num_rows;
			}

			$result->data_seek(0);
			// while($row = $result->fetch_assoc()){
			//     echo $row['preview'] . '<br>';
			// }
			return $result;
	}

	public function check_user_input()
	{
		if(isset($_POST['password']) && isset($_POST['passwordwc']))
		{
			$passwordToConfirm = $_POST['password'];
			$passwordConfirm = $_POST['passwordwc'];
		}
		if(isset($passwordToConfirm) &&(isset($passwordConfirm)))
		{
			if($passwordToConfirm !== $passwordConfirm) 
		  {
		    echo "Passwords don't match. ";
		    $GLOBALS['passCheck'] = false;
		    return false;
		  }
		  else
		  {
		    $passwordConfirm = $_POST['password'];
		    $cleansedstring = preg_replace('#\W#', '', $passwordConfirm);
		    $GLOBALS['secure_password'] = password_hash($passwordConfirm, PASSWORD_BCRYPT);
		    $GLOBALS['passCheck'] = true;
		    return true;
		  }
		}
	}

	public function upload_file()
	{
		$user_folder_path = "assets/img/" . basename($_SESSION['Username']) . "/";

		if(isset($_FILES['file']) && $_FILES['file']['size'] != 0) {
		    $target_dir = "assets/img/" . basename($_SESSION['Username']) . "/";
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
		    // if (file_exists($target_file)) {
		    //     echo "Sorry, file already exists.";
		    //     $uploadOk = 0;
		    // } 
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
		      //Change absolute to relative when moving to the Server
		        if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . "/" . $target_file)) {
		        	echo "The file ". basename($_FILES['file']["name"]). " has been uploaded.<br/>";
		            $GLOBALS['flag'] = true;
		        } else {
		        	echo "Sorry, your file was not uploaded. Failed to move. <br/>" . "<br/> Move to: ". "assets/img/" . basename($_POST['email']) . "/" . basename($_FILES["file"]["name"]) ."<br/>";
		            $GLOBALS['flag'] = false;
		        }
		    }
		  }

		$GLOBALS['file'] = $user_folder_path . basename($_FILES['file']['name']);
		return true;
	}

	public function update_user()
	{
		Global $WebCatalogue;
		$good = "Record Updated";

		if($this->check_user_input())
		{
			if($this->upload_file())
			{
				if (($GLOBALS['passCheck'] == true) && ($GLOBALS['flag'] == false) && (($_POST['password'] != "") && ($_POST['passwordwc'] != ""))  ) {
				  $updateSQL = sprintf("UPDATE users SET password=%s, language=%s, url=%s, title=%s, `description`=%s WHERE userID=%s",
				                       GetSQLValueString($GLOBALS['secure_password'], "text"),
									   GetSQLValueString($_POST['lang'], "text"),
				                       GetSQLValueString($_POST['url'], "text"),
				                       GetSQLValueString($_POST['title'], "text"),
				                       GetSQLValueString($_POST['descr'], "text"),
				                       GetSQLValueString($_POST['UserIDhiddenField'], "int"));

				  $result = $WebCatalogue->query($updateSQL);
				  echo $good;
				  return true;
				}
				elseif (($GLOBALS['passCheck'] == true) && ($GLOBALS['flag'] == true) && (($_POST['password'] != "") && ($_POST['passwordwc'] != ""))  ) {
				  $updateSQL = sprintf("UPDATE users SET password=%s, language=%s, url=%s, title=%s, `description`=%s, `preview`=%s, `preview_thumb`=%s  WHERE userID=%s",
				                       GetSQLValueString($GLOBALS['secure_password'], "text"),
				                       GetSQLValueString($_POST['lang'], "text"),
				                       GetSQLValueString($_POST['url'], "text"),
				                       GetSQLValueString($_POST['title'], "text"),
				                       GetSQLValueString($_POST['descr'], "text"),
				                       GetSQLValueString($GLOBALS['file'], "text"),
				                       GetSQLValueString($GLOBALS['file'], "text"),
				                       GetSQLValueString($_POST['UserIDhiddenField'], "int"));

				  $result = $WebCatalogue->query($updateSQL);
				  echo $good;
				  return true;
				}
				elseif (($GLOBALS['passCheck'] == true) && ($GLOBALS['flag'] == false) && (($_POST['password'] == "") && ($_POST['passwordwc'] == "")) ) {
				  $updateSQL = sprintf("UPDATE users SET language=%s, url=%s, title=%s, `description`=%s  WHERE userID=%s",
				                       GetSQLValueString($_POST['lang'], "text"),
				                       GetSQLValueString($_POST['url'], "text"),
				                       GetSQLValueString($_POST['title'], "text"),
				                       GetSQLValueString($_POST['descr'], "text"),
				                       GetSQLValueString($_POST['UserIDhiddenField'], "int"));

				  $result = $WebCatalogue->query($updateSQL);
				  json_encode($good);
				  echo $good;
				  return true;
				}
				elseif (($GLOBALS['passCheck'] == true) && ($GLOBALS['flag'] == true) && (($_POST['password'] == "") && ($_POST['passwordwc'] == ""))  ) {
				  $updateSQL = sprintf("UPDATE users SET language=%s, url=%s, title=%s, `description`=%s, `preview`=%s, `preview_thumb`=%s  WHERE userID=%s",
				                       GetSQLValueString($_POST['lang'], "text"),
				                       GetSQLValueString($_POST['url'], "text"),
				                       GetSQLValueString($_POST['title'], "text"),
				                       GetSQLValueString($_POST['descr'], "text"),
				                       GetSQLValueString($GLOBALS['file'], "text"),
				                       GetSQLValueString($GLOBALS['file'], "text"),
				                       GetSQLValueString($_POST['UserIDhiddenField'], "int"));

				  $result = $WebCatalogue->query($updateSQL);
				  echo $good;
				  return true;
				}
				else {
				  echo "Update Failed";
				  return false;
				}
			}
		}
	}
}