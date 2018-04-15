<?php 
include_once('resources/conx.php');
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location: http://localhost/simpleblog/sign-in');
	exit();
}
if(isset ($_SESSION['user_id'], $_POST['title'], $_POST['content'])){
	$errors 	= array();
	$title 		= trim($_POST['title']);
	$contents 	= trim($_POST['content']);
	$user_id 	= $_SESSION['user_id'];

	if ( empty($title) ){
		$errors[] = 'You need to supply a title.';
	}else if(strlen($title) > 255){
		$errors[] = 'The title cannot be longer than 255 characters';
	}
	if ( empty($contents) ){
		$errors[] = 'You need to supply the contents';
	}
	
	if($_FILES['upload']['name'] != ''){
		$files = preg_replace('/\s+/', '_', $_FILES['upload']['name']);
			if(file_exists('upload/'. $files)){
				$errors[] = "File with that name already exists!";
			}
		
	$file_type	=	$_FILES['upload']['type']; //returns the mime type
	$allowed	=	array("image/jpeg", "image/gif", "image/png", "application/pdf");
		if(!in_array($file_type, $allowed)){
			$errors[] = "Only jpg, gif, png and pdf files are allowed";
		}
	}	
	
	function add_attachment(){
			if(isset($_FILES['upload'])){
				$files = preg_replace('/\s+/', '_', $_FILES['upload']['name']);
				move_uploaded_file($_FILES['upload']['tmp_name'], "upload/{$files}");
			}
		}
		
		if( empty($errors) ){
		add_post($db, $user_id, $title, $contents);
		$file = add_attachment();
		$id = mysqli_insert_id($db);
		header("Location: http:/\/localhost/simpleblog/title/{$id}");		
	}
}
?>
<?php include_once('nav.php'); ?>
<div class="wrapper">
<div class="body">
<h2 class="heading">ADD POST</h2>
<form method="post" action="" enctype="multipart/form-data">
<table id="add_post">
<tr>
<td colspan="2">
<span id="status">
<?php
if(isset($errors) && !empty($errors)){
echo '<ul class="errors"><li class="error">', implode('</li><li class="error">', $errors), '</li></ul>';
}
?>
</span>
</td>
</tr>
<tr>
<td class="le_ft"><label for="title">TITLE:</label></td>
</tr>
<tr>
<td><input type="text" name="title" id="title" placeholder="Title Goes Here" onFocus="emptyElement()" value="<?php if(isset($_POST['title'])) echo $_POST['title']; ?>" required /></td>
</tr>
<tr>
<td class="le_ft"><label for="content">CONTENTS:</label></td>
</tr>
<tr>
<td><textarea name="content" id="content" placeholder="Message Goes Here" onFocus="emptyElement()" required><?php if(isset($_POST['content'])) echo $_POST['content']; ?></textarea></td>
</tr>
<tr>
<td class="le_ft"><label for="upload">ATTACHMENTS</label></td></tr>
<tr>
<td><input type="file" name="upload" id="upload" title="Attach a file to your post" onClick="emptyElement()" /></td>
</tr>
<tr>
<td align="center"><input type="submit" id="submit" value="ADD POST" name="submit" /></td>
</tr>
</table>
</form>
</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>