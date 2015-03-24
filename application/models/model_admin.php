<?php

Class Model_Admin extends Model
{
	public function get_user_data($user)
	{
		Global $WebCatalogue;

			$colname_User = "-1";
			if (isset($_SESSION['MM_Username'])) 
			{
			  $colname_User = $_SESSION['MM_Username'];
			}
			else
			{
				$colname_User = $user;
			}

			$sql=sprintf("SELECT * FROM users WHERE email = %s", GetSQLValueString($colname_User, "text"));
 
			$result=$WebCatalogue->query($sql);
			 
			if($result === false) 
			{
			  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
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

		return "User " . get_user_by_id($approve_user_id) . " is Approved";
	}

	public function delete_web($delete_user_id)
	{
		Global $WebCatalogue;

		$delete_query = sprintf("DELETE FROM `users` WHERE userID=%s",
                       GetSQLValueString($delete_user_id, "int"));
		$deleted = $WebCatalogue->query($delete_query);

		return "User " . get_user_by_id($delete_user_id) . " has been Deleted";
	}

	public function manage_users()
	{
		Global $WebCatalogue;
		//$currentPage = $_SERVER["PHP_SELF"];
		$currentPage = "/index/";
		$maxRows_ManageUsers = 10;
		$pageNum_ManageUsers = 0;
		if (isset($_GET['pageNum_ManageUsers'])) {
		  $pageNum_ManageUsers = $_GET['pageNum_ManageUsers'];
		}
		$startRow_ManageUsers = $pageNum_ManageUsers * $maxRows_ManageUsers;

			$sql="SELECT * FROM users WHERE NOT `Userlevel` = '2' ORDER BY registration DESC";
			$sql_limit = sprintf("%s LIMIT %d, %d", $sql, $startRow_ManageUsers, $maxRows_ManageUsers);
 
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
				$totalPages_ManageUsers = ceil($totalRows/$maxRows_ManageUsers)-1;
			  //$totalRows = $result->num_rows;

				$queryString_ManageUsers = "";
				if (!empty($_SERVER['QUERY_STRING'])) {
				  $params = explode("&", $_SERVER['QUERY_STRING']);
				  $newParams = array();
				  foreach ($params as $param) {
				    if (stristr($param, "pageNum_ManageUsers") == false && 
				        stristr($param, "totalRows") == false) {
				      array_push($newParams, $param);
				    }
				  }
				  if (count($newParams) != 0) {
				    $queryString_ManageUsers = "&" . htmlentities(implode("&", $newParams));
				  }
				}
				$queryString_ManageUsers = sprintf("&totalRows=%d%s", $totalRows, $queryString_ManageUsers);
			}
			//echo $result->num_rows;
			$pages = array(
				'pageNum' => $pageNum_ManageUsers, 
				'maxRows' => $maxRows_ManageUsers, 
				'startRow' => $startRow_ManageUsers, 
				'totalRows' => $totalRows, 
				'totalPages' => $totalPages_ManageUsers, 
				'currentPage' => $currentPage,
				'queryString' => $queryString_ManageUsers
				);
			$result->data_seek(0);
			// while($row = $result->fetch_assoc()){
			//     echo $row['email'] . '<br>';
			// }
			$data = array($result, $pages);
			return $data;
	}
}