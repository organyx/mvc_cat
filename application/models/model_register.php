<?php

class Model_Register extends Model
{
	
	public function register()
	{	
			Global $WebCatalogue;

			$sql="SELECT * FROM `users` WHERE NOT `approval` = '0000-00-00 00:00:00' AND NOT `Userlevel` = '2' ORDER BY registration DESC";
 
			$result=$WebCatalogue->query($sql);
			 
	}

}