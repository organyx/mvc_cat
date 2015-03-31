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
				$timestamp = "CURRENT_TIMESTAMP()";
				if($total > 0)
				{
					$result = array('found' => true, 'user' => $user);
					echo json_encode($result);
				    $found->free();
				    return $result = array('found' => true, 'user' => $user);
				}
				elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$result = array('result' => "Not valid email.");
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
	}

	public function manage_users()
	{
		Global $WebCatalogue;
		//$currentPage = $_SERVER["PHP_SELF"];
		//****Pagination Setup*****
		// $currentPage = "/index/";
		// $maxRows = 10;
		// $pageNum = 0;
		// if (isset($_GET['pageNum'])) {
		//   $pageNum = $_GET['pageNum'];
		// }
		// $startRow = $pageNum * $maxRows;
		// 	//***Get values***
		// 	$sql="SELECT * FROM users WHERE NOT `Userlevel` = '2' ORDER BY registration DESC";
		// 	$sql_limit = sprintf("%s LIMIT %d, %d", $sql, $startRow, $maxRows);
 
		// 	$result=$WebCatalogue->query($sql_limit);
			 
		// 	if($result === false) {
		// 	  trigger_error('Wrong SQL: ' . $sql_limit . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
		// 	} else {

		// 		if (isset($_GET['totalRows'])) {
		// 		  $totalRows = $_GET['totalRows'];
		// 		} else {
		// 		  $all_ManageUsers = $WebCatalogue->query($sql);
		// 		  if($all_ManageUsers === false)
		// 		  {
		// 		  	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
		// 		  }
		// 		  else
		// 		  {
		// 		  	$totalRows = $all_ManageUsers->num_rows;
		// 		  }
		// 		}
		// 		$totalPages = ceil($totalRows/$maxRows)-1;
		// 	  //$totalRows = $result->num_rows;

		// 		$queryString = "";
		// 		if (!empty($_SERVER['QUERY_STRING'])) {
		// 		  $params = explode("&", $_SERVER['QUERY_STRING']);
		// 		  $newParams = array();
		// 		  foreach ($params as $param) {
		// 		    if (stristr($param, "pageNum") == false && 
		// 		        stristr($param, "totalRows") == false) {
		// 		      array_push($newParams, $param);
		// 		    }
		// 		  }
		// 		  if (count($newParams) != 0) {
		// 		    $queryString = "&" . htmlentities(implode("&", $newParams));
		// 		  }
		// 		}
		// 		$queryString = sprintf("&totalRows=%d%s", $totalRows, $queryString);
		// 	}
		// 	//echo $result->num_rows;
		// 	//****Saving Values*****
		// 	$pages = array(
		// 		'pageNum' => $pageNum, 
		// 		'maxRows' => $maxRows, 
		// 		'startRow' => $startRow, 
		// 		'totalRows' => $totalRows, 
		// 		'totalPages' => $totalPages, 
		// 		'currentPage' => $currentPage,
		// 		'queryString' => $queryString
		// 		);

		// 	//******Pagination END*******

		// 	$result->data_seek(0);
		// 	// while($row = $result->fetch_assoc()){
		// 	//     echo $row['email'] . '<br>';
		// 	// }
		// 	$data = array($result, $pages);
		// 	return $data;
		if(isset($_POST["page"])){
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
		}else{
			$page_number = 1; //if there's no page number, set it to 1
		}
		$item_per_page = 10;
		//get total number of records from database for pagination
		$results = $WebCatalogue->query("SELECT COUNT(*) FROM users");
		$get_total_rows = $results->fetch_row(); //hold total records in variable
		//break records into pages
		$total_pages = ceil($get_total_rows[0]/$item_per_page);
		
		//get starting position to fetch the records
		$page_position = (($page_number-1) * $item_per_page);
		
		//SQL query that will fetch group of records depending on starting position and item per page. See SQL LIMIT clause
		$results = $WebCatalogue->query("SELECT * FROM users WHERE NOT `Userlevel` = '2' ORDER BY registration DESC LIMIT $page_position, $item_per_page");
		
		//Display records fetched from database.
		
		echo '<ul class="contents">';
		while($row = $results->fetch_assoc()) {
			echo '<li>';
			echo  $row["userID"]. '. <strong>' .$row["email"].'</strong> &mdash; '.$row["title"];
			echo '</li>';
		}  
		echo '</ul>';
		
		
		echo '<div align="center">';
		/* We call the pagination function here to generate Pagination link for us. 
		As you can see I have passed several parameters to the function. */
		echo $this->paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
		echo '</div>';
	}


	function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
	{
	    $pagination = '';
	    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
	        $pagination .= '<ul class="pagination">';
	        
	        $right_links    = $current_page + 3; 
	        $previous       = $current_page - 1; //previous link 
	        $next           = $current_page + 1; //next link
	        $first_link     = true; //boolean var to decide our first link
	        
	        if($current_page > 1){
				$previous_link = ($previous==0)?1:$previous;
	            $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
	            $pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
	                for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
	                    if($i > 0){
	                        $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
	                    }
	                }   
	            $first_link = false; //set first link to false
	        }
	        
	        if($first_link){ //if current active page is first link
	            $pagination .= '<li class="first active">'.$current_page.'</li>';
	        }elseif($current_page == $total_pages){ //if it's the last active link
	            $pagination .= '<li class="last active">'.$current_page.'</li>';
	        }else{ //regular current link
	            $pagination .= '<li class="active">'.$current_page.'</li>';
	        }
	                
	        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
	            if($i<=$total_pages){
	                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
	            }
	        }
	        if($current_page < $total_pages){ 
					$next_link = ($i > $total_pages)? $total_pages : $i;
					$next_link = $next_link - 2;
	                $pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
	                $pagination .= '<li class="last"><a href="#" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
	        }
	        
	        $pagination .= '</ul>'; 
	    }
	    return $pagination; //return pagination links
	}
}