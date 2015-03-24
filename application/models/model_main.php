<?php

class Model_Main extends Model
{
	
	public function get_web_list()
	{	
			Global $WebCatalogue;

			$maxRows_ManageUsers = 10;

			$sql="SELECT * FROM `users` WHERE NOT `approval` = '0000-00-00 00:00:00' AND NOT `Userlevel` = '2' ORDER BY registration DESC";
 
			$result=$WebCatalogue->query($sql);
			 
			if($result === false) {
			  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
			} else {
			  $totalRows = $result->num_rows;
			}

			$result->data_seek(0);
			// while($row = $result->fetch_assoc()){
			//     echo $row['email'] . '<br>';
			// }
			return $result;
	}

}