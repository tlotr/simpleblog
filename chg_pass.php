<?php 
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location: http://localhost/sign-in');
}
include_once('resources/conx.php');
$user = $_SESSION['user_id'];
if(isset($_POST['chg_pass'])){
	$errors = 	array();
	$old_pass = md5(mysqli_real_escape_string($db, $_POST['old_pass']));
	$new_pass = md5(mysqli_real_escape_string($db, $_POST['pwd1']));
	$query = mysqli_query($db, "SELECT password FROM users WHERE user_id = '$user'");
	$row = mysqli_fetch_assoc($query);

if($old_pass == $new_pass){
	$errors[] = 'The new password cannot be same as the old password';
}elseif ($old_pass != $row['password']){
	$errors[] = 'The old password entered is incorrect';
}else{
	mysqli_query($db, "UPDATE users SET password = '$new_pass' WHERE user_id = '$user'");
	echo "<script>alert('Password Change Successfully!');</script>";
	session_destroy();
	echo "<script>location.href='http://localhost/sign-in';</script>";
}
}
?>
<?php include_once('nav.php'); ?>
<div class="wrapper">
<div class="body">
<h2 class="heading">CHANGE PASSWORD</h2>
<form method="POST" name="chg_pass" action="">
<table id="cg_pass">
<tr>
<td id="status">
<?php
	if(isset($errors) && !empty($errors))
{
	echo '<ul class="errors"><li class="error">', implode('</li><li class="error">', $errors), '</li></ul>';
}
?>
</td>
</tr>
<tr>
<td class="le_ft"><label for="old_pass">OLD PASSWORD</label></td>
</tr>
<tr>
<td><input type="password" name="old_pass" id="old_pass" onfocus="emptyElement()" placeholder="Old Pass Here" autocomplete="off" required  /></td>
</tr>
<tr>
<td class="le_ft"><label for="new_pass">NEW PASSWORD</label></td>
</tr>
<tr>
<td><input type="password" id="new_pass" autocomplete="off" onfocus="emptyElement()" placeholder="New Pass Here" required name="pwd1" onchange="form.pwd2.pattern = this.value;" /></td>
</tr>
<tr>
<td class="le_ft"><label for="new_pass_2">CONFIRM NEW PASSWORD</label></td>
</tr>
<tr>
<td><input type="password" id="new_pass_2" autocomplete="off" onfocus="emptyElement()" placeholder="Confirm New Pass" required name="pwd2" /></td>
</tr>
<tr>
<td align="center"><input type="submit" value="CHANGE PASSWORD" id="submit_pass" name="chg_pass" /></td>
</tr>
</table>
</form>
</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>