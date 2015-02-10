<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html" charset=utf-8"/>
<!--[if lt IE 9]> <script src="js/html5shiv.js"></script> <![endif]-->
<link rel="shortcut icon" href="http://localhost/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="http://localhost/css/global.css">
<script type="text/javascript" src="http://localhost/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="http://localhost/js/sticky.js"></script>
<script type="text/javascript" src="http://localhost/js/empty.js"></script>
<title><?php if(isset($_SESSION['user_id'])){?><?php echo $_SESSION['fname']. " " .$_SESSION['lname']. " | "; ?><?php } ?>tlotr's Simple Blog</title>
</head>
<body>
<div class="logo">
<table>
<tr>
<td>
<a href="http://localhost/"><img src="http://localhost/images/logo.png" border="0"></a>
</td>
<?php if(isset($_SESSION['user_id'])){ ?>
<td align="right">
<a href="http://localhost/user/<?php echo $_SESSION['user_id']; ?>"><img src="http://localhost/avatar/<?=@$_SESSION['avatar'] ? $_SESSION['avatar'] : 'avatar.png'; ?>" height="50" width="55" border="0" /></a>
</td>
<?php } ?>
</tr>
</table>
</div>
<div class="nav">
<div class="subNav">
<ul>
<a href="http://localhost/"><li>HOME</li></a>
<?php if(isset($_SESSION['user_id'])){ ?>
<a href="http://localhost/add-post"><li>ADD POST</li></a>
<a href="http://localhost/change-password"><li>CHANGE PASSWORD</li></a>
<a href="http://localhost/change-avatar"><li>CHANGE AVATAR</li></a>
<a href="http://localhost/sign-out"><li>LOGOUT</li></a>
<?php } ?>
<?php if(!isset($_SESSION['user_id'])) {?>
<a href="http://localhost/sign-in"><li>LOGIN</li></a>
<a href="http://localhost/sign-up"><li>REGISTER</li></a>
<?php } ?>
</ul>
</div>
</div>