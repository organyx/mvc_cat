<?php

$config = parse_ini_file('config.ini');
$host = $config['user_host'];
$database = $config['user_dbname'];
$username = $config['user_username'];
$password = $config['user_password'];

$WebCatalogue = new mysqli($host, $username, $password, $database);

if($WebCatalogue->connect_error)
{
	trigger_error('Database connection failed: '  . $WebCatalogue->connect_error, E_USER_ERROR);
}