<?php
require '/config.php';
if(!isset($config))
	die("Rename your example.config.php to config.php");
$db = mysqli_connect($config['db']['host'],$config['db']['username'],$config['db']['password'],$config['db']['database']);
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
include_once("func/blog.php");
?>