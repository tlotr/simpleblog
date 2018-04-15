<?php 
session_start();
include_once('resources/conx.php');
if(isset($_SESSION['user_id'])){
	header("Location: http:/\/localhost/simpleblog/user/{$_SESSION['user_id']}");
	}
if(isset($_POST['login'])){
	$errors = array();
	$user = mysqli_real_escape_string($db, $_POST['user']);
	$pass = md5(mysqli_real_escape_string($db, $_POST['pass']));
	$query = mysqli_query($db, "SELECT * FROM users WHERE username = '$user' AND password = '$pass'");
	$total = mysqli_num_rows($query);
	if($total > 0){
	session_start();
	$row = mysqli_fetch_assoc($query);
    $_SESSION['user_id'] = $row['user_id'];
	$_SESSION['fname'] = $row['fname'];
	$_SESSION['lname'] = $row['lname'];
	$_SESSION['username'] = $row ['username'];
	$_SESSION['avatar'] = $row ['avatar'];
    header("Location: http:/\/localhost/simpleblog/user/{$_SESSION['user_id']}");
	}
else {
		$errors[] = 'Invalid username or password';
	}	
}
?>
<?php include_once('nav.php'); ?>
<div class="wrapper">
<div class="body">
<h2 class="heading">LOGIN</h2>
<form method="POST" name="lo_gin" id="lo_gin" action="">
<table id="log_in">
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
<td style="padding-left: 15px; padding-right: 0; padding-top: 0; padding-bottom: 2px; color: #BBB; "><label for="user">USERNAME:</label></td>
</tr>
<tr>
<td><input type="text" name="user" id="user" onfocus="emptyElement()" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" placeholder="Username Here" autocomplete="off" required /></td>
</tr>
</tr>
<tr>
<td style="padding-left: 15px; padding-right: 0; padding-top: 0; padding-bottom: 2px; color: #BBB; "><label for="pass">PASSWORD:</label></td>
</tr>
<tr>
<td><input type="password" name="pass" id="pass" onfocus="emptyElement()" placeholder="Password Here" autocomplete="off" required /></td>
</tr>
<tr>
<td align="center"><input type="submit" id="login" value="LOGIN" name="login" /></td>
</tr>
</table>
</form>
</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>