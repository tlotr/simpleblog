<?php 
include_once('resources/conx.php');
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location: http://localhost/simpleblog/sign-in');
	}
if (!isset($_GET['id'])){
	header('Location: http://localhost/simpleblog/');	
	}
delete($db, 'posts', $_GET['id']);
echo "<script>alert('Post Deleted!');</script>";
echo "<script>location.href='http://localhost/simpleblog/';</script>";
?>