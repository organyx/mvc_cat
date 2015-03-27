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
					echo 
					'<table class="width-670 center WidthAuto">
				        <tr>
				          <td align="center">Account: '.$user['email'].'</td>
				        </tr>
				        <tr>
				          <td><table class="width-500 TableStyle center WidthAuto">
				            <tr>
				              <td valign="top">&nbsp;</td>
				              <td align="right" valign="top">Registration date : </td>
				            </tr>
				            <tr>
				              <td>Title: ' . $user['title'] . '</td>
				              <td>'.$user['registration'].'</td>
				            </tr>
				            <tr>
				              <td>URL: <a target="_blank" href="'.$user['url'].'"> '.$user['url'].'</a></td>
				              <td width="150" height="150" rowspan="3" class="TableStyleBorderLeft">
				        <a class="fancybox"  href="../../'.$user['preview_thumb'].'">
				        <img src="../../'.$user['preview_thumb'].'" alt="Preview Thumb" height="140px" width="140px" class="img-thumbnail">
				              </td>
				            </tr>
				            <tr>
				              <td>Languages: '.$user['language'].'</td>
				              </tr>
				            <tr>
				              <td>Description:</td>
				              </tr>
				            <tr>
				              <td colspan="2">'.$user['description'].'</td>
				            </tr>
				          </table></td>
				        </tr>
				        <tr>
		                    <td>
		                      <div class="list">
		                        <table class="center">
		                          <tr>
		                            <td>
			                            <form class="DeleteUserForm" name="DeleteUserForm" method="POST">
			                              <input name="DeleteUserHiddenField" type="hidden"  class="DeleteUserHiddenField" value="'.$user['userID'].'">
			                              <input type="submit" name="DeleteUserButton"  class="DeleteUserButton" value="Delete User">
			                            </form>
		                            </td>
		                            <td>
			                            <form class="ApproveUserForm" name="ApproveUserForm" method="POST">
			                              <input name="ApproveUserHiddenField" type="hidden"  class="ApproveUserHiddenField" value="'.$timestamp.'">
			                              <input name="ApproveIDhiddenField" type="hidden"  class="ApproveIDhiddenField" value="'.$user['userID'].'">
			                              <input type="submit" name="ApproveUserButton"  class="ApproveUserButton" value="Approve User">
			                            </form>
		                            </td>
		                          </tr>
		                        </table>
		                      </div>
		                    </td>
		                  </tr>
				      </table>';
				      $found->free();
				      return $user;
				}
				else
				{
					echo "User Not Found.";
				}
			}
			else
			{
				echo "User not specified.";
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
			echo "User " . $this->get_user_by_id($approve_user_id) . " is Approved";
			return true;
		}
	}

	public function delete_web($delete_user_id)
	{
		Global $WebCatalogue;

		$delete_query = sprintf("DELETE FROM `users` WHERE userID=%s",
                       GetSQLValueString($delete_user_id, "int"));
		$deleted = $WebCatalogue->query($delete_query);
		if($deleted === false) {
			trigger_error('Wrong SQL: ' . $delete_query . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
		}
		else
		{
			echo "User " . $this->get_user_by_id($delete_user_id) . " has been Deleted";
			return true;
		}
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
			//***Get values***
			$sql="SELECT * FROM users WHERE NOT `Userlevel` = '2' ORDER BY registration DESC";
			$sql_limit = sprintf("%s LIMIT %d, %d", $sql, $startRow, $maxRows);
 
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
				'queryString' => $queryString
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