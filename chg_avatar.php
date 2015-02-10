<?php 
include_once('resources/conx.php');
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location: http://localhost/sign-in');
	exit();
}
if(isset($_POST['avatar'])){
		$user = $_SESSION['user_id'];
		$avatar = preg_replace('/\s+/', '_', $_FILES['img']['name']);	
		function chg_avatar() {
			if(isset($_FILES['img'])){			
				$image = preg_replace('/\s+/', '_', $_FILES['img']['name']);
				move_uploaded_file($_FILES['img']['tmp_name'], "avatar/{$image}");
		}
	}
		if($avatar != ''){
		$file_type	=	$_FILES['img']['type']; //returns the mime type
		$allowed	=	array("image/jpeg", "image/jpg", "image/png");
			if(!in_array($file_type, $allowed)){			
				$errors[] = "Only jpg and png files are allowed";
			}
			if(file_exists('avatar/'. $avatar)){			
				$errors[] = "File with that name already exists!";
			}}elseif($avatar == ""){
				$errors[] = "You have not selected any file";
			}
	
		if(empty($errors)){
		mysqli_query($db, "UPDATE users SET avatar = '$avatar' WHERE user_id = '$user'");
		$file = chg_avatar();
		echo "<script>alert('Avatar Changed Successfully!');</script>";
		session_destroy();
		echo "<script>location.href='http://localhost/sign-in';</script>";
		}		
}

?>
<?php include_once('nav.php'); ?>
<div class="wrapper">

<div class="body">
<h2 class="heading">CHANGE AVATAR</h2>
<br />
<table border="0" cellspacing="5" cellpadding="5">
<tr>
<td id="status">
<?php
if(isset($errors) && !empty($errors)){
echo '<ul class="errors"><li class="error">', implode('</li><li class="error">', $errors), '</li></ul>';
}
?>
</td>
</tr>
<tr>
<td>
<form method="POST" action="" enctype="multipart/form-data" name="avatar">
<input type="file" name="img" id="img" title="Chose your avatar image file"  onclick="emptyElement()" />
</td>
</tr>
<tr>
<td align="center">
<input type="submit" name="avatar" value="CHANGE AVATAR" id="register" />
</td>
</tr>
</form>
</table>
</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>