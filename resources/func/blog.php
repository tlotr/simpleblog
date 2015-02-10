<?php

function add_post($db, $user_id, $title, $contents){

$file 		= add_attachment();
$title 		= htmlentities(mysqli_real_escape_string($db, $title));
$contents 	= htmlentities(mysqli_real_escape_string($db, $contents));
$upload		= mysqli_real_escape_string($db, preg_replace('/\s+/', '_', $_FILES['upload']['name']));
$user_id	= $_SESSION['user_id'];

if(isset($_FILES['upload'])){
		mysqli_query($db, "INSERT INTO posts (user_id, title, contents, posted_date, filename) VALUES('$user_id', '$title', '$contents', NOW(), '$upload')");
	}
}

function edit_post($db, $post_id, $title, $contents){
	
	$post_id 	= (int)$post_id;
	$title 		= htmlentities(mysqli_real_escape_string($db, $title));
	$contents 	= htmlentities(mysqli_real_escape_string($db, $contents));
	$file		= add_attachment();
	$upload		= mysqli_real_escape_string($db, preg_replace('/\s+/', '_', $_FILES['upload']['name']));

	if(isset($_FILES['upload'])){
		mysqli_query($db, "UPDATE posts SET title = '$title', contents = '$contents', filename = '$upload' WHERE post_id = '$post_id'");
	}
}

function delete($db, $table, $post_id){	
$table = mysqli_real_escape_string($db, $table);
$post_id = (int)$post_id;	
mysqli_query($db, "DELETE FROM posts WHERE post_id = '$post_id'");
}

function register($db, $user, $pass, $fname, $lname, $email, $gender){

$file 		= add_avatar();
$user 		= mysqli_real_escape_string($db, $_POST['username']);
$pass 		= mysqli_real_escape_string($db, md5($_POST['password']));
$fname 		= mysqli_real_escape_string($db, $_POST['fname']);
$lname 		= mysqli_real_escape_string($db, $_POST['lname']);
$email 		= mysqli_real_escape_string($db, $_POST['email']);
$gender 	= mysqli_real_escape_string($db, $_POST['gender']);
$avatar		= mysqli_real_escape_string($db, preg_replace('/\s+/', '_', $_FILES['avatar']['name']));
				
if(isset($_FILES['avatar'])){
	mysqli_query($db, "INSERT INTO users (username, password, fname, lname, email, gender, avatar) VALUES ('$user', '$pass', '$fname', '$lname', '$email', '$gender', '$avatar')");
	}	
}

function add_avatar(){
	
if(isset($_FILES['avatar']))
	{
		$image = preg_replace('/\s+/', '_', $_FILES['avatar']['name']);
		move_uploaded_file($_FILES['avatar']['tmp_name'], "avatar/{$image}");
	}
	
}
?>