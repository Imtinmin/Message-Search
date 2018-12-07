<?php
//uncenter
include('config.php');
session_start();
$conn = new mysqli($GLOBALS['db_addr'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);

if (isset($_SESSION['user'])){
	$user_id = $_SESSION['user'];
	$row = $conn->query("SELECT username,password from user where user_id=$user_id")->fetch_array();
	$log_user = $row['username'];
}else{
	header("refresh:3;url=http://127.0.0.1");
	die('<h1 class="ui header">没有登录哦！还有三秒自动跳转主页</h1>');
}
require('header.php');   #获取页面头部   -->

@$past_password = $_POST['past_password'];
$past_password = trim($past_password);
$past_password = $conn->real_escape_string($past_password);

@$new_password = $_POST['new_password'];
$new_password = trim($new_password);
$new_password = $conn->real_escape_string($new_password);


@$repassword = $_POST['repassword'];
$repassword = trim($repassword);
$repassword = $conn->real_escape_string($repassword);

@$vcode = $_POST['vcode'];
$vcode = trim($vcode);


if (isset($past_password) && strlen($past_password) > 0 && isset($new_password) && strlen($new_password) > 0 && isset($repassword) && strlen($repassword) > 0){
	if (!isset($_SESSION['vcode']) || strtolower($vcode) !== $_SESSION['vcode']){
		$_SESSION['message'] = '验证码错误';
		$_SESSION['message_tag'] = 'error';
	}else if (!md5($past_password) === $row['password'] && !preg_match('/^[\x20-\x7E]{6,}$/', $past_password)){
		$_SESSION['message'] = '旧密码错误';
		$_SESSION['message_tag'] = 'error';
	}else if (!$past_password === $new_password){
		$_SESSION['message'] = '旧密码与新密码相同';
		$_SESSION['message_tag'] = 'error';
	}else if (!$new_password === $repassword){
		$_SESSION['message'] = '两次密码输入不一致';
		$_SESSION['message_tag'] = 'error';
	}else if(!preg_match('/^[\x20-\x7E]{6,}$/', $new_password)){
		$_SESSION['message'] = '新密码不符合格式';
		$_SESSION['message_tag'] = 'error';
	}else{
		$new_password = md5($new_password);
		$update = "UPDATE user SET password='$new_password' WHERE username='$log_user'";
		$res = $conn->query($update);
		if (!$res){
			$_SESSION['message'] = '修改错误';
			$_SESSION['message_tag'] = 'error';
		}else{
			$_SESSION['message'] = '修改成功';
			$_SESSION['message_tag'] = 'success';
		}

	}
}



$conn->close();
?>
<div class="ui  text container segment">
  <h2 class="ui header">修改密码</h2>
</div>
<?php
if (isset($_SESSION['message']) && isset($_SESSION['message_tag'])){
  echo '<div class="ui info message"><p>'.$_SESSION['message'].'</p></div>';
}
?>
<form class="ui form" method="post">
  <div class="field">
    <label>旧密码</label>
    <input type="password" name="past_password" placeholder="旧密码">
  </div>
  <div class="field">
    <label>新密码</label>
    <input type="password" name="new_password" placeholder="新密码">
  </div>
    <div class="field">
    <label>确认密码</label>
    <input type="password" name="repassword" placeholder="确认密码">
  </div>
  <div class="field">
    <label>验证码</label>
    <input type="text" name="vcode" maxlength="4" placeholder="验证码" />
    <img id="vcode" src="vcode.php" onclick="this.src='vcode.php?'+Math.random();">
  </div>
<?php unset($_SESSION['message']);unset($_SESSION['message_tag']); ?>
  <button class="ui button" type="submit">确认</button>
</form>
</body>
</html>