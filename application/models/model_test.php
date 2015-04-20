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
}