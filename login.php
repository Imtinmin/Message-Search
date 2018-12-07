<?php
//error_reporting(0);
#require_once('header.php');
include 'config.php';

session_start();

$conn = new mysqli($GLOBALS['db_addr'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);

if (isset($_SESSION['user'])){
  $user_id = $_SESSION['user'];
  $row = $conn->query("SELECT username from user where user_id=$user_id")->fetch_array();
  $log_user = $row['username'];
}


@$username = $_POST['username'];
$conn->real_escape_string($username);
  
@$password = $_POST['password'];
$conn->real_escape_string($password);

@$vcode = $_POST['vcode'];

$password = md5($password);
//echo $password;
if (isset($username) && strlen($username) > 0 && isset($password) && strlen($password) > 0 && isset($vcode) && strlen($vcode) > 0){
  if (!isset($_SESSION['vcode']) || strtolower($vcode) !== $_SESSION['vcode']) {
    $_SESSION['message'] = '验证码错误';
    $_SESSION['message_tag'] = 'error';
  }else{
  $sql="SELECT `user_id`,`username`,`password`,`regtime` FROM `user` WHERE `username` = '{$username}'";
  $result = $conn->query($sql);
#避免fetch_array报错
  if ($result->num_rows === 0){   
    $_SESSION['message'] = '用户名或密码错误！';
    $_SESSION['message_tag'] = 'error';
  }else{
    $row = $result->fetch_array();
    if(!$row['password']===$password){
      $_SESSION['message'] = '用户名或密码错误！';
      $_SESSION['message_tag'] = 'error';
    }else{ 
    $_SESSION['message'] = '登录成功！';
    $_SESSION['message_tag'] = 'success!';
    $_SESSION['user'] = $row['user_id'];
    $regtime = date("Y-m-d",$row['regtime']);
    $log_user = $row['username'];
    #header('Location:/');
    }
  }
}
}
/*@$action=$_GET['action'];
if (isset($action)){
  if ($action==='logout'){
    unset($_SESSION['user']);
    header('Location:/');
  }
}*/
$conn->close();
?>

<?php require_once('header.php'); ?>   <!--获取页面头部   -->
<div class="ui  text container segment">
  <h2 class="ui header">登录一下吧</h2>
</div>
<?php
if (isset($_SESSION['message']) && isset($_SESSION['message_tag'])){
  echo '<div class="ui info message"><p>'.$_SESSION['message'].'</p><p>'.'您注册时间是： '.$regtime.'</p>'.'</div>';
}
?>

<form class="ui form" method="post">
  <div class="field">
    <label>用户名</label>
    <input type="text" name="username" placeholder="用户名">
  </div>
  <div class="field">
    <label>密码</label>
    <input type="password" name="password" placeholder="密码">
  </div>
  <div class="field">
    <label>验证码</label>
    <input type="text" name="vcode" maxlength="4" placeholder="验证码" />
    <img id="vcode" src="vcode.php" onclick="this.src='vcode.php?'+Math.random();">
  </div>
<?php unset($_SESSION['message']);unset($_SESSION['message_tag']); ?>
  <button class="ui button" type="submit">登录</button>
</form>
</body>
</html>