<?php 
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location: http://localhost/simpleblog/sign-in');
	exit();
}
include_once('resources/conx.php');
function get_posts($db, $post_id = null, $user_id = null){
	
	$posts = array();
	$query = "SELECT `posts`.`post_id` AS `p_id`, 
					`users`.`user_id` AS `u_id`, 
					`title`, `contents`, `posted_date`, `filename`, 
					`users`.`fname`, `users`.`lname`
					FROM `posts`
					INNER JOIN `users` ON `users`.`user_id` = `posts`.`user_id`";
	if( isset($post_id)){
		$post_id	= (int)$post_id;
		$query .= "WHERE `posts`.`post_id` = {$post_id}";
	}	
	if( isset($user_id)){
		$user_id = (int)$user_id;
		$query .= " WHERE `users`.`user_id` = {$user_id}";
	}	
	$query .= " AND `posts`.`user_id` = {$_SESSION['user_id']}";	
	$query .= " ORDER BY `post_id` DESC";	
	$query = mysqli_query($db, $query);	
	while($row = mysqli_fetch_assoc($query)){
		$posts[] = $row;
	}
	return $posts;
}
$posts = get_posts($db, $_GET['id']);
if(isset ($_POST['title'], $_POST['content'])){
	
	$errors = array();
	
	$title 		= trim($_POST['title']);
	$contents 	= trim($_POST['content']);	
		
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
	edit_post($db, $_GET['id'], $title, $contents);
	$file = add_attachment();
	header("Location: http:/\/localhost/simpleblog/title/{$posts[0]['p_id']}");
	}
}

?>
<?php include_once('nav.php'); ?>
<div class="wrapper">
<div class="body">
<h2 class="heading">EDIT POST</h2>
<form method="post" action="" enctype="multipart/form-data">
<table id="add_post">
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
<td class="le_ft"><label for="title">TITLE:</label></td>
</tr>
<tr>
<td><input type="text" name="title" id="title" placeholder="Title Goes Here" autocomplete="off" onfocus="emptyElement()" value="<?php echo $posts[0]['title']; ?>" required /></td>
</tr>
<tr>
<td class="le_ft"><label for="content">CONTENTS:</label></td>
</tr>
<tr>
<td><textarea name="content" id="content" placeholder="Message Goes Here" onfocus="emptyElement()" required><?php echo $posts[0]['contents']; ?></textarea></td>
</tr>
<tr>
<td class="le_ft"><label for="upload">ATTACHMENTS:</label></td>
</tr>
<tr>
<td><input type="file" name="upload" id="upload" title="Attach a file to your post" onclick="emptyElement()" /></td>
</tr>
<tr>
<td align="center"><input type="submit" id="submit" value="UPDATE POST" name="submit" /></td>
</tr>
</table>
</form>
</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>