<?php 
session_start();
include'config.php';

$conn = new mysqli($GLOBALS['db_addr'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
if (!$conn){
	die('mysql connect error!');
}
if (isset($_SESSION['user'])){
	$user_id = $_SESSION['user'];
	$row = $conn->query("SELECT username from user where user_id=$user_id")->fetch_array();
	$log_user = $row['username'];
}
require('header.php');
?>
<div class="ui center aligned raised very padded text container segment">
  <h2 class="ui header">友情链接</h2>
  <p>百度：https://www.baidu.com/</p>
  <p>谷歌：https://www.google.com.hk/</p>
</div>
</body>
</html>