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

	public function auto()
	{
		Global $WebCatalogue;

		if($_POST['type'] == 'email')
		{
			$sql = "SELECT email FROM users where email LIKE '".strtoupper($_POST['name_startsWith'])."%'";
			$result = $WebCatalogue->query($sql);	
			if($result === false)
			{
				trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
			}
			else
			{	
				$data = array();
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
				{
					array_push($data, $row['email']);	
				}
			}
		}	
		echo json_encode($data);

	}

	public function get_user_by_id($id)
	{
	    Global $WebCatalogue;

	    $query_User = sprintf("SELECT * FROM `users` WHERE userID = %s", GetSQLValueString($id, "text"));
	    $User = $WebCatalogue->query($query_User);
	    if($User === false)
	    {
	    	trigger_error('Wrong SQL: ' . $query_User . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
	    }
	    else
	    {
	    	$row_User = $User->fetch_assoc();
	    	return $row_User['email'];
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
			$result = array('function_result' => "User " . $email . " has been Deleted");
			echo json_encode($result);
			return true;
		}
		return false;
	}

	public function get_web_list()
	{	
		Global $WebCatalogue;
		//****Pagination Setup*****
		$currentPage = "/main/index/";
		if (isset($_POST['per_page']) && intval($_POST['per_page']) <= 50) {
		  $maxRows = intval($_POST['per_page']);
		}
		else
		{
			$maxRows = 10;
		}
		if (isset($_POST['page_num'])) {
		 	$pageNum = intval($_POST['page_num']);
		}
		else
		{
			$pageNum = 0;
		}
		$startRow = $pageNum * $maxRows;		
		//***Get values***
		$sql="SELECT * FROM users WHERE NOT `Userlevel` = '2' ORDER BY registration DESC";
		$sql_limit = sprintf("%s LIMIT %d, %d", $sql, GetSQLValueString($startRow, "int"), GetSQLValueString($maxRows, "int"));

		$result=$WebCatalogue->query($sql_limit);
		 
		if($result === false) {
		  trigger_error('Wrong SQL: ' . $sql_limit . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
		} else {
			if (isset($_POST['totalRows'])) {
			  $totalRows = $_POST['totalRows'];
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
		}
		//****Saving Values*****
		$pages = array(
			'pageNum' => $pageNum, 
			'maxRows' => $maxRows, 
			'startRow' => $startRow, 
			'totalRows' => $totalRows, 
			'totalPages' => $totalPages, 
			'currentPage' => $currentPage,
			);
		//******Pagination END*******
		$result->data_seek(0);

		$res = $WebCatalogue->query($sql_limit);
		$rows = array();
		while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
			$rows[] = $row;
		}
		array_push($rows, $pages);
		echo json_encode($rows);

		$data = array($result, $pages, json_encode($rows));
		return $data;
	}
}