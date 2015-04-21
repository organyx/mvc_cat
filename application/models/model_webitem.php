<?php
class Model_Webitem extends Model
{
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

			return $result;
	}

}