<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html" charset=utf-8"/>
<!--[if lt IE 9]> <script src="http://localhost/simpleblog/js/html5shiv.js"></script> <![endif]-->
<link rel="shortcut icon" href="http://localhost/simpleblog/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="http://localhost/simpleblog/css/global.css">
<script type="text/javascript" src="http://localhost/simpleblog/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="http://localhost/simpleblog/js/sticky.js"></script>
<script type="text/javascript" src="http://localhost/simpleblog/js/empty.js"></script>
<title><?php if(isset($_SESSION['user_id'])){?><?php echo $_SESSION['fname']. " " .$_SESSION['lname']. " | "; ?><?php } ?>tlotr's Simple Blog</title>
</head>
<body>
<div class="logo">
<table>
<tr>
<td>
<a href="http://localhost/simpleblog/"><img src="http://localhost/simpleblog/images/logo.png" border="0"></a>
</td>
<?php if(isset($_SESSION['user_id'])){ ?>
<td align="right">
<a href="http://localhost/simpleblog/user/<?php echo $_SESSION['user_id']; ?>"><img src="http://localhost/simpleblog/avatar/<?=@$_SESSION['avatar'] ? $_SESSION['avatar'] : 'avatar.png'; ?>" height="50" width="55" border="0" /></a>
</td>
<?php } ?>
</tr>
</table>
</div>
<div class="nav">
<div class="subNav">
<ul>
<a href="http://localhost/simpleblog/"><li>HOME</li></a>
<?php if(isset($_SESSION['user_id'])){ ?>
<a href="http://localhost/simpleblog/add-post"><li>ADD POST</li></a>
<a href="http://localhost/simpleblog/change-password"><li>CHANGE PASSWORD</li></a>
<a href="http://localhost/simpleblog/change-avatar"><li>CHANGE AVATAR</li></a>
<a href="http://localhost/simpleblog/sign-out"><li>LOGOUT</li></a>
<?php } ?>
<?php if(!isset($_SESSION['user_id'])) {?>
<a href="http://localhost/simpleblog/sign-in"><li>LOGIN</li></a>
<a href="http://localhost/simpleblog/sign-up"><li>REGISTER</li></a>
<?php } ?>
</ul>
</div>
</div>