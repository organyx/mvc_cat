<?php

class Model_Forgot_Pass extends Model
{
	
	public function forgot_pass()
	{	
			Global $WebCatalogue;

			$email = "";

			if(isset($_POST['email']))
			  {
			    $email = $_POST['email'];
			  }

			$colname_EmailPassword = "-1";
			if (isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
			  $colname_EmailPassword = $email;
			}

			$query_find_user = sprintf("SELECT * FROM `users` WHERE email = %s", GetSQLValueString($colname_EmailPassword, "text"));
			$user_found = $WebCatalogue->query($query_find_user);
			if($user_found === false)
			{
				trigger_error('Wrong SQL: ' . $query_find_user . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
			}
			$row_EmailPassword2 = $user_found->fetch_assoc();
			$found = $user_found->num_rows;

			if($found > 0)
			{
				$new_password = randomPassword();
				$new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

				$query_update_pass = sprintf(
				  "UPDATE users SET password=%s WHERE email=%s",
				                       GetSQLValueString($new_hashed_password, "text"),
				                       GetSQLValueString($email, "text")
				  );
				$update = $WebCatalogue->query($query_update_pass);
				if($update === false)
				{
					trigger_error('Wrong SQL: ' . $query_update_pass . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
				}
				else
				{
					$from = "noreply@domain.com";
					$email = $email;
					$subject = "Domain - Email Password";
					$message = "Your password is: " .$new_password;
					
					mail($email, $subject,$message, "From: ".$from);

				  	echo "Check your email. " . $new_password;
				  	$user_found->free();
				  	return true;
				}
			}
			else
			{
				$user_found->free();
				if(filter_var($email, FILTER_VALIDATE_EMAIL))
			  	{
				    echo "Email not Found.";
				    return false;
			  	}
			  	elseif (empty($email)) 
			  	{
				    echo "Email field is empty.";
				    return false;
			  	}
			  	else
			  	{
				    echo "Invalid email format.";
				    return false;
			  	}
			}
	}

}