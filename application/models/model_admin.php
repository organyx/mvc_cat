<?php

Class Model_Admin extends Model
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
					$result = array('result' => "Not a valid email.");
					echo json_encode($result);
				}
				else
				{
					$result = array('result' => "User Not Found.");
					echo json_encode($result);
				}
			}
			else
			{
				$result = array('result' => "User Not specified.");
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

	public function approve_web($approve_user_id)
	{
		Global $WebCatalogue;

		$approve_query = sprintf("UPDATE `users` SET approval=CURRENT_TIMESTAMP() WHERE userID=%s",
                       GetSQLValueString($approve_user_id, "int"));
		$approved = $WebCatalogue->query($approve_query);
		if($approved === false) {
			trigger_error('Wrong SQL: ' . $approve_query . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
		}
		else
		{
			$result = array('function_result' => "User " . $this->get_user_by_id($approve_user_id) . " is Approved");
			echo json_encode($result);
			return true;
		}
		return false;
	}

	public function delete_web($delete_user_id)
	{
		Global $WebCatalogue;
		$delete_id = $this->get_user_by_id($delete_user_id);
		$delete_query = sprintf("DELETE FROM `users` WHERE userID=%s",
                       GetSQLValueString($delete_user_id, "int"));
		$deleted = $WebCatalogue->query($delete_query);
		if($deleted === false) {
			trigger_error('Wrong SQL: ' . $delete_query . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
		}
		else
		{
			//echo "User " . $delete_id . " has been Deleted";
			$result = array('function_result' => "User " . $delete_id . " has been Deleted");
			echo json_encode($result);
			return true;
		}
		return false;
	}

	public function manage_users()
	{
		Global $WebCatalogue;
		//$currentPage = $_SERVER["PHP_SELF"];
		//****Pagination Setup*****
		$currentPage = "/index/";
		$maxRows = 10;
		$pageNum = 0;
		if (isset($_GET['pageNum'])) {
		  $pageNum = $_GET['pageNum'];
		}
		$startRow = $pageNum * $maxRows;

			$sql_count="SELECT userID, url, title, preview_thumb FROM `users` WHERE NOT `approval` = '0000-00-00 00:00:00' AND NOT `Userlevel` = '2' ORDER BY registration DESC";
			$sql_count_result=$WebCatalogue->query($sql_count);
			$total_approved = $sql_count_result->num_rows;

			//***Get values***
			$sql="SELECT * FROM users WHERE NOT `Userlevel` = '2' ORDER BY registration DESC";
			$sql_limit = sprintf("%s LIMIT %d, %d", $sql, GetSQLValueString($startRow, "int"), GetSQLValueString($maxRows, "int"));
 
			$result=$WebCatalogue->query($sql_limit);
			 
			if($result === false) {
			  trigger_error('Wrong SQL: ' . $sql_limit . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
			} else {

				if (isset($_GET['totalRows'])) {
				  $totalRows = $_GET['totalRows'];
				} else {
				  $all_ManageUsers = $WebCatalogue->query($sql);
				  if($all_ManageUsers === false)
				  {
				  	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
				  }
				  else
				  {
				  	$totalRows = $all_ManageUsers->num_rows;
				  }
				}
				$totalPages = ceil($totalRows/$maxRows)-1;
			  //$totalRows = $result->num_rows;

				$queryString = "";
				if (!empty($_SERVER['QUERY_STRING'])) {
				  $params = explode("&", $_SERVER['QUERY_STRING']);
				  $newParams = array();
				  foreach ($params as $param) {
				    if (stristr($param, "pageNum") == false && 
				        stristr($param, "totalRows") == false) {
				      array_push($newParams, $param);
				    }
				  }
				  if (count($newParams) != 0) {
				    $queryString = "&" . htmlentities(implode("&", $newParams));
				  }
				}
				$queryString = sprintf("&totalRows=%d%s", $totalRows, $queryString);
			}
			//echo $result->num_rows;
			//****Saving Values*****
			$pages = array(
				'pageNum' => $pageNum, 
				'maxRows' => $maxRows, 
				'startRow' => $startRow, 
				'totalRows' => $totalRows, 
				'totalPages' => $totalPages, 
				'currentPage' => $currentPage,
				'queryString' => $queryString,
				'totalApproved' => $total_approved,
				'totalAwaiting' => $totalRows - $total_approved
				);

			//******Pagination END*******

			$result->data_seek(0);
			// while($row = $result->fetch_assoc()){
			//     echo $row['email'] . '<br>';
			// }
			$data = array($result, $pages);
			return $data;
	}
}