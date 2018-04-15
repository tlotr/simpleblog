<?php 
session_start();
if(!isset($_GET['id'])){
	header("Location: http://localhost/simpleblog/");
	exit();
}
function get_posts($post_id = null, $user_id = null){
include_once('resources/conx.php');
$sql = "SELECT COUNT(post_id) FROM posts WHERE `posts`.`user_id` = {$_GET['id']}";
$query = mysqli_query($db, $sql) or die(mysqli_error($db));
$row = mysqli_fetch_row($query);
global $rows;
$rows = $row[0];
$page_rows = 4;
$last = ceil($rows/$page_rows);
if($last  < 1){ 
	$last = 1; 
}
$pagenum = 1;
if(isset($_GET['page'])){
	$pagenum = preg_replace('#[^0-9]#', '', $_GET['page']);
}
if ($pagenum < 1){
	$pagenum = 1;
} else if ($pagenum > $last) {
	$pagenum = $last;
}
$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
$sql = "SELECT `posts`.`post_id` AS `p_id`, `users`.`user_id` AS `u_id`, `title`, `contents`, `posted_date`, `filename`, `users`.`fname`, `users`.`lname`, `users`.`avatar` AS `avatar` FROM `posts` INNER JOIN `users` ON `users`.`user_id` = `posts`.`user_id`"; 
if( isset($post_id)){ 
	$post_id = (int)$post_id;
	$sql .= "WHERE `posts`.`post_id` = {$post_id}";
}
if( isset($user_id)){
	$user_id = (int)$user_id;
	$sql .= " WHERE `users`.`user_id` = {$user_id}";
}
$sql .= " ORDER BY p_id DESC $limit";
$query = mysqli_query($db, $sql);
global $paginationCtrls;
global $file;
global $path;
$path = $_SERVER['PHP_SELF'];
$file = basename($path, ".php");
$paginationCtrls = '<ul>';
if($last != 1){
	if ($pagenum > 1){
		$previous = $pagenum - 1;
		$paginationCtrls .= '<a href="http://localhost/simpleblog/user/'.$user_id.'/'.$previous.'"><li class="pagi_left">Previous</li></a>';
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
				$paginationCtrls .= '<a href="http://localhost/simpleblog/user/'.$user_id.'/'.$i.'"><li>'.$i.'</li></a>';
			}
		}
	}
	$paginationCtrls .= '<li>'.$pagenum.'</li>';
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<a href="http://localhost/simpleblog/user/'.$user_id.'/'.$i.'"><li>'.$i.'</li></a>';
		if($i >= $pagenum+4){
			break;
		}
	}
	if ($pagenum != $last) {
		$next = $pagenum + 1;
		$paginationCtrls .= '<a href="http://localhost/simpleblog/user/'.$user_id.'/'.$next.'"><li class="pagi_right">Next</li></a>';
	}
	$paginationCtrls .= '</ul>';
}
$posts = array();
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
	$posts[] = $row;
}
	return $posts;
}
$posts = ( isset ($_GET['id']) ) ? get_posts(null, $_GET['id']) : get_posts();
?>
<?php include_once('nav.php'); ?>
<div class="wrapper">
<div class="body">
<?php if(isset($_SESSION['user_id']) && $_GET['id']==$_SESSION['user_id']){?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td class="u_left">
<img src="http://localhost/simpleblog/avatar/<?=@$_SESSION['avatar'] ? $_SESSION['avatar'] : 'avatar.png'; ?>" height="100" width="100" />
</td>
<td class="u_right">
<h2 class="heading">WELCOME <?php echo strtoupper($_SESSION['fname']. " " .$_SESSION['lname']); ?></h2>
<br />
<font color="#BBBBBB">Number Of Posts:</font> <?php echo $rows; ?>
</td>
</tr>
</table>
<br />
<div id="pagination_ctrl"><?php echo $paginationCtrls; ?></div><br><br>
<h2 class="heading">YOUR POSTS</h2>
<?php foreach ($posts as $post){ ?>
<br>
<p class="title"> <a href="http://localhost/simpleblog/title/<?php echo $post['p_id']; ?>"><?php echo "<font color='green'>". $post['title']. "</font>"; ?></a> </p> 
<i class="icon-stopwatch"></i> <span class="date_time"><?php echo date('d-M-Y h:i A', strtotime($post['posted_date'])); ?></span><br />
<br />
<a href="http://localhost/simpleblog/edit/<?php echo $post['p_id']; ?>"><span class="underline">Edit Post</span></a> &nbsp; &nbsp;
<a href="http://localhost/simpleblog/delete/<?php echo $post['p_id']; ?>" onclick="return confirm('Are you sure you want to delete the post?');"><span class="underline">Delete Post</span></a> <br /><br />
<hr><br>
<?php } ?>
<?php }else{ ?>
<br />
<div id="pagination_ctrl"><?php echo $paginationCtrls; ?></div>
<br>
<table border="0" class="posts" cellspacing="0">
<?php foreach ($posts as $post){ ?>
<tr>
<td class='left'>
<p class="user"><?php echo "<span class='underline'>". $post['fname'] ." ". $post['lname'] ."</span>"; ?></p><br />
<img src="http://localhost/simpleblog/avatar/<?=@$post['avatar'] ? $post['avatar'] : 'avatar.png'; ?>" height="100" width="100" /> <br /><br />
<div class="timer-icon">
<i class="icon-stopwatch"></i> <span class="date_time"><?php echo date('d-M-Y h:i A', strtotime($post['posted_date'])); ?></span><br />
</div>
<p class="attach">
<?php if(isset($_SESSION['user_id']) && ($_SESSION['user_id']) == $post['u_id']){?>
<a href="http://localhost/simpleblog/edit/<?php echo $post['p_id']; ?>"><button class="icons"><i class="icon-pencil"></i></button></a> <a href="http://localhost/simpleblog/delete/<?php echo $post['p_id']; ?>" onclick="return confirm('Are you sure you want to delete the post?');"><button class="icons"><i class="icon-bin"></i></button></a>
<?php } ?>
</p>
<p class="attach">
<?php if($post['filename']): ?> 
<a href="http://localhost/simpleblog/upload/<?=$post['filename'];?>" target="blank"><button class="icons"><i class="icon-attachment"></i></button></a>
<?php endif; ?>
</p>
<br />
</td>
<td class="right">
<p class="title"> <a href="http://localhost/simpleblog/title/<?php echo $post['p_id']; ?>"><?php echo "<font color='green'>". $post['title']. "</font>"; ?></a> </p>
<div class="msg">
<article class="message"> <?php echo nl2br($post['contents']); ?> </article>
</div>
</td>
</tr>
<?php } ?>
</table>
<?php } ?>
<div id="pagination_ctrl"><?php echo $paginationCtrls; ?></div>
</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>