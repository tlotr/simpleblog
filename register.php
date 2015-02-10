<?php 
	session_start();
	include_once('resources/conx.php');
	if(isset($_SESSION['user_id'])){
		header("Location: http:/\/localhost/user/{$_SESSION['user_id']}");
	}

	if(isset($_POST['register'])){

	$errors = array();
	
	$user = mysqli_real_escape_string($db, $_POST['username']);
	$pass = mysqli_real_escape_string($db, md5($_POST['password']));
	$fname = mysqli_real_escape_string($db, $_POST['fname']);
	$lname = mysqli_real_escape_string($db, $_POST['lname']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$gender = mysqli_real_escape_string($db, $_POST['gender']);
	
	if($user == "" || $pass == "" || $fname == "" || $lname = "" || $email == "" || $gender == ""){
		$errors[] = "All fields except Avatar Image needs to be filled";
	}
	$u = mysqli_query($db, "SELECT * FROM users WHERE username = '$user'");
	$u_total = mysqli_num_rows($u);
	if($u_total > 0){
		$errors[] = 'That username already exists';
		}
	$e = mysqli_query($db, "SELECT * FROM users WHERE email = '$email'");
	$e_total = mysqli_num_rows($e);
	if($e_total > 0){
		$errors[] = 'That email address already exists';
		}
	
	if($_FILES['avatar']['name'] != ''){
	$file_type	=	$_FILES['avatar']['type']; //returns the mime type
	$allowed	=	array("image/jpeg", "image/gif", "image/png");
		if(!in_array($file_type, $allowed)){
			$errors[] = "Only jpg, gif and png files are allowed";
		}
	}
	
	if(empty($errors)){
	
	register($db, $user, $pass, $fname, $lname, $email, $gender);
	$file = add_avatar();
	echo "<script>alert('Registration Successfully!');</script>";
	echo "<script>location.href='http://localhost/sign-in';</script>";	
	}	
}
?>
<?php include_once('nav.php'); ?>
<div class="wrapper">
<div class="body">
<h2 class="heading">REGISTER</h2>
<form method="POST" action="" name="register" enctype="multipart/form-data">
<table id="reg">
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
	<td style="padding-left: 15px; padding-right: 0; padding-top: 0; padding-bottom: 2px; color: #BBB; "><label for="username">USERNAME:</label></td>
</tr>
<tr>
	<td><input type="text" name="username" id="username" placeholder="Your Username Here" onfocus="emptyElement()" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" autocomplete="off" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" required /></td>
</tr>
<tr>
	<td style="padding-left: 15px; padding-right: 0; padding-top: 0; padding-bottom: 2px; color: #BBB; "><label for="password">PASSWORD:</label></td>
</tr>
<tr>
	<td><input type="password" name="password" id="password" placeholder="Password Here" onfocus="emptyElement()" autocomplete="off" onchange="form.password2.pattern = this.value;" required /></td>
</tr>
<tr>
	<td style="padding-left: 15px; padding-right: 0; padding-top: 0; padding-bottom: 2px; color: #BBB; "><label for="password2">CONFIRM PASSWORD:</label></td>
</tr>
<tr>
	<td><input type="password" name="password2" id="password2" onfocus="emptyElement()" placeholder="Confirm Password" autocomplete="off" required /></td>
</tr>
<tr>
	<td style="padding-left: 15px; padding-right: 0; padding-top: 0; padding-bottom: 2px; color: #BBB; "><label for="fname">FIRST NAME:</label></td>
</tr>
<tr>
	<td><input type="text" name="fname" id="fname" placeholder="Your First Name" onfocus="emptyElement()" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>" autocomplete="off" pattern="[A-Za-z]+" required /></td>
</tr>
<tr>
	<td style="padding-left: 15px; padding-right: 0; padding-top: 0; padding-bottom: 2px; color: #BBB; "><label for="lname">LAST NAME:</label></td>
</tr>
<tr>
	<td><input type="text" name="lname" id="lname" placeholder="Your Last Name" onfocus="emptyElement()" value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; ?>" autocomplete="off" pattern="[A-Za-z]+" required /></td>
</tr>
<tr>
	<td style="padding-left: 15px; padding-right: 0; padding-top: 0; padding-bottom: 2px; color: #BBB; "><label for="email">E-MAIL:</label></td>
</tr>
<tr>
	<td><input type="email" name="email" id="email" onfocus="emptyElement()" placeholder="E-Mail" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" autocomplete="off" required /></td>
</tr>
<tr>
	<td style="padding-left: 15px; padding-right: 0; padding-top: 0; padding-bottom: 2px; color: #BBB; "><label for="gender">GENDER:</label></td>
</tr>
<tr>
	<td><select id="gender" name="gender" required><option value="" selected></option> <option value="Male">Male</option> <option value="Female">Female</option></select></td>
</tr>
<tr>
	<td style="padding-left: 15px; padding-right: 0; padding-top: 0; padding-bottom: 2px; color: #BBB; "><label for="avatar">AVATAR:</label></td>
</tr>
<tr>
	<td><input type="file" id="avatar" name="avatar" title="Chose Your Avatar" /></td>
</tr>
<tr>
	<td align="center"><input type="submit" name="register" id="register" value="REGISTER" /></td>
</tr>
</table>
</form>
</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>