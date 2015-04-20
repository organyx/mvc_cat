<?php
Class Model_Test extends Model
{
	public function find_user($email)
	{
		Global $WebCatalogue;

		if (isset($email)) 
		{
			if(!empty($email))
			{
				$find_query = sprintf("SELECT * FROM users WHERE email = %s", GetSQLValueString($email, "text"));
				$found = $WebCatalogue->query($find_query);
				$user = $found->fetch_assoc();
				$total = $found->num_rows;
				//$timestamp = "CURRENT_TIMESTAMP()";
				if($total > 0)
				{
					$result = array('found' => true, 'user' => $user);
					echo json_encode($result);
				    $found->free();
				    return $result = array('found' => true, 'user' => $user);
				}
				elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$result = array('found' => false,'result' => "Not a valid email.");
					echo json_encode($result);
				}
				else
				{
					$result = array('found' => false, 'result' => "User Not Found.");
					echo json_encode($result);
				}
			}
			else
			{
				$result = array('found' => false, 'result' => "User Not specified.");
				echo json_encode($result);
			}
		}
		return false;
	}

	public function get_user_by_id($id)
	{
	    Global $WebCatalogue;

	    $query_User = sprintf("SELECT * FROM `users` WHERE userID = %s", GetSQLValueString($id, "text"));
	    $User = $WebCatalogue->query($query_User);
	    $row_User = $User->fetch_assoc();
	    return $row_User['email'];
	}

	public function get_userID_by_email($email)
	{
	    Global $WebCatalogue;

	    $query_User = sprintf("SELECT * FROM `users` WHERE email = %s", GetSQLValueString($email, "text"));
	    $User = $WebCatalogue->query($query_User);
	    if($User === false)
	    {
			trigger_error('Wrong SQL: ' . $query_User . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
	    }
	    else
	    {
		    $row_User = $User->fetch_assoc();
		    return $row_User['userID'];
	    }
	}

	public function approve_web($id)
	{
		Global $WebCatalogue;
		$email = $this->get_user_by_id($id);
		$approve_query = sprintf("UPDATE `users` SET approval=CURRENT_TIMESTAMP() WHERE userID=%s",
                       GetSQLValueString($id, "int"));
		$approved = $WebCatalogue->query($approve_query);
		if($approved === false) {
			trigger_error('Wrong SQL: ' . $approve_query . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
		}
		else
		{
			$result = array('function_result' => "User " . $email . " is Approved");
			echo json_encode($result);
			//return true;
		}
		return false;
	}

	public function delete_web($id)
	{
		Global $WebCatalogue;
		$email = $this->get_user_by_id($id);
		$delete_query = sprintf("DELETE FROM `users` WHERE userID=%s",
                       GetSQLValueString($id, "int"));
		$deleted = $WebCatalogue->query($delete_query);
		if($deleted === false) {
			trigger_error('Wrong SQL: ' . $delete_query . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
		}
		else
		{
			//echo "User " . $delete_id . " has been Deleted";
			$result = array('function_result' => "User " . $email . " has been Deleted");
			echo json_encode($result);
			return true;
		}
		return false;
	}
}