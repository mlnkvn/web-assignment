<?php

$serverName = "localhost";
$dbUserName = "root";
$dbPassword = "root";
$dbName = "my_site_db";

$con = mysqli_connect($serverName, $dbUserName, $dbPassword, $dbName);

if (!$con) {
	die("Connection failed: " . mysqli_connect_error());
}
?>