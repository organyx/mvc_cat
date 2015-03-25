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

			$new_password = randomPassword();
			$new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

			$query_EmailPassword = sprintf(
			  "UPDATE users SET password=%s WHERE email=%s",
			                       GetSQLValueString($new_hashed_password, "text"),
			                       GetSQLValueString($email, "text")
			  );
			$email_found = $WebCatalogue->query($query_EmailPassword);

			$query_EmailPassword2 = sprintf("SELECT * FROM `users` WHERE email = %s", GetSQLValueString($colname_EmailPassword, "text"));
			$email_number = $WebCatalogue->query($query_EmailPassword2);
			$row_EmailPassword2 = $email_number->fetch_assoc();
			$totalRows_EmailPassword2 = $email_number->num_rows;

			if($totalRows_EmailPassword2 > 0)
			{
				$from = "noreply@domain.com";
				$email = $email;
				$subject = "Domain - Email Password";
				$message = "Your password is: " .$new_password;
				
				mail($email, $subject,$message, "From: ".$from);

			  echo "Check your email. " . $new_password;
			  $email_number->free();
			  return true;
			}
			else
			{
				$email_number->free();
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