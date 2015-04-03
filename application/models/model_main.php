<?php

class Model_Main extends Model
{
	
	public function get_web_list()
	{	
			Global $WebCatalogue;
			//****Pagination Setup*****
			$currentPage = "/main/index/";
			$maxRows = 10;
			$pageNum = 0;
			if (isset($_POST['page'])) {
			  $pageNum = $_POST['page'];
			}
			$startRow = $pageNum * $maxRows;		
			//***Get values***
			$sql="SELECT userID, url, title, preview_thumb FROM `users` WHERE NOT `approval` = '0000-00-00 00:00:00' AND NOT `Userlevel` = '2' ORDER BY registration DESC";
			$sql_limit = sprintf("%s LIMIT %d, %d", $sql, GetSQLValueString($startRow, "int"), GetSQLValueString($maxRows, "int"));
 
			$result=$WebCatalogue->query($sql_limit);
			 
			if($result === false) {
			  trigger_error('Wrong SQL: ' . $sql_limit . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
			} else {
			  //$totalRows = $result->num_rows;
				if (isset($_POST['total_rows'])) {
				  $totalRows = $_POST['total_rows'];
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


				// $queryString = "";
				// if (!empty($_SERVER['QUERY_STRING'])) {
				//   $params = explode("&", $_SERVER['QUERY_STRING']);
				//   $newParams = array();
				//   foreach ($params as $param) {
				//     if (stristr($param, "pageNum") == false && 
				//         stristr($param, "totalRows") == false) {
				//       array_push($newParams, $param);
				//     }
				//   }
				//   if (count($newParams) != 0) {
				//     $queryString = "&" . htmlentities(implode("&", $newParams));
				//   }
				// }
				// $queryString = sprintf("&totalRows=%d%s", $totalRows, $queryString);
			}
			//****Saving Values*****
			$pages = array(
				'pageNum' => $pageNum, 
				'maxRows' => $maxRows, 
				'startRow' => $startRow, 
				'totalRows' => $totalRows, 
				'totalPages' => $totalPages, 
				'currentPage' => $currentPage,
				//'queryString' => $queryString
				);
			//******Pagination END*******

			$result->data_seek(0);
			// while($row = $result->fetch_assoc()){
			//     echo $row['email'] . '<br>';
			// }
			// $data = array($result, $pages);

			$res = $WebCatalogue->query($sql_limit);
			$rows = array();
			while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
				$rows[] = $row;
			}
			array_push($rows, $pages);
			echo json_encode($rows);
			// foreach ($rows as $row) {
			// 	echo json_encode($row);
			// }
			//echo json_encode($pages);
			$data = array($result, $pages);
			return $data;
	}

}