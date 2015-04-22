<?php
class Model_Main extends Model
{
	
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
			$sql="SELECT @rownum:=@rownum+1 rn, userID, url, title, preview_thumb FROM `users`,(SELECT @rownum:=0) r WHERE NOT `approval` = '0000-00-00 00:00:00' AND NOT `Userlevel` = '2' ORDER BY registration DESC";
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

			$rows = array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$rows[] = $row;
			}
			array_push($rows, $pages);
			echo json_encode($rows);

			$data = array($result, $pages, json_encode($rows));
			$result->free();
			return $data;
	}
}