<?php

class Model_Account extends Model
{
	public function get_user_data($email)
	{	
			Global $WebCatalogue;

			$colname_User = "-1";
			if (isset($_SESSION['Username'])) 
			{
			  $colname_User = $_SESSION['Username'];
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
			//     echo $row['email'] . '<br>';
			// }
			return $result;
	}
}