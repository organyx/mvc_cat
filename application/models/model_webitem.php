<?php
class Model_Webitem extends Model
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

	public function item($id)
	{	
			Global $WebCatalogue;

			$colname_id = $id;

			$sql=sprintf("SELECT * FROM users WHERE userID = %s ORDER BY userID DESC", GetSQLValueString($colname_id, "int"));
 
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