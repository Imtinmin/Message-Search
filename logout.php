<?php
	# code...
// Redirect To URL
session_start();
if (!isset($_SESSION['user'])){
	header("refresh:3;url=http://127.0.0.1");
	die('<h1 class="ui header">没有登录哦！还有三秒自动跳转主页</h1>');
}else{
	unset($_SESSION['user']);
	header('Location:/');
}
?>
