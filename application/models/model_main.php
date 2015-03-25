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
			if (isset($_GET['pageNum'])) {
			  $pageNum = $_GET['pageNum'];
			}
			$startRow = $pageNum * $maxRows;		
			//***Get values***
			$sql="SELECT * FROM `users` WHERE NOT `approval` = '0000-00-00 00:00:00' AND NOT `Userlevel` = '2' ORDER BY registration DESC";
			$sql_limit = sprintf("%s LIMIT %d, %d", $sql, $startRow, $maxRows);
 
			$result=$WebCatalogue->query($sql_limit);
			 
			if($result === false) {
			  trigger_error('Wrong SQL: ' . $sql_limit . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
			} else {
			  //$totalRows = $result->num_rows;
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