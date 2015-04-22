<?php

class Model_Login extends Model
{

	public function get_user($email)
	{
		Global $WebCatalogue;

		$query=sprintf("SELECT email, password, Userlevel FROM users WHERE email=%s", GetSQLValueString($email, "text")); 
		$result = $WebCatalogue->query($query);
		if($result === false)
		{
			trigger_error('Wrong SQL: ' . $query . ' Error: ' . $WebCatalogue->error, E_USER_ERROR);
		}
		else
		{
			$userdata = $result->fetch_assoc(); 
			return $userdata;
		}
	}
}