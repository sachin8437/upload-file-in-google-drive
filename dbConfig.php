<?php
// Include config
require_once 'config.php';

// Create database
$db = new mysqli(
    DB_HOST, DB_USERNAME , DB_PASSWORD , DB_NAME);  
 
// Check Connection
if($db->connect_error){
	die("Connection Failed: " . $db->connect_error);
}else{
	echo "COnnected";
}