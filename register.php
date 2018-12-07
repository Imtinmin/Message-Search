<?php
//error_reporting(0);
include 'config.php';
session_start();
$conn = new mysqli($GLOBALS['db_addr'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);

if (isset($_SESSION['user'])){
  $user_id = $_SESSION['user'];
  $row = $conn->query("SELECT username from user where user_id=$user_id")->fetch_array();
  $log_user = $row['username'];
}

@$username = $_POST['username'];
$username = trim($username);
$username = $conn->real_escape_string($username); # mysqli_real_escape_string() 防止sql注入，转义单引号双引号



@$password = $_POST['password'];
$password = trim($password); # trim 防止输入字符传前后有空格
$password = $conn->real_escape_string($password);

@$vcode = $_POST['vcode'];

@$regtime = time();
$password = md5($password);   //MD5验证

$sql_1 = "SELECT COUNT(*) from user where username = '{$username}'";
$sql_2 = "INSERT INTO user(username,password,regtime) VALUES ('$username','$password','$regtime')";
if (isset($username) && strlen($username) > 0 && isset($password) && strlen($password) > 0 && isset($vcode) && strlen($vcode) > 0){
  if (!isset($_SESSION['vcode']) || strtolower($vcode) !== $_SESSION['vcode']) { 
      $_SESSION['message'] = '验证码错误！';
      $_SESSION['message_tag'] = 'error';
  }else if (!preg_match('/^[-_A-Za-z0-9]{1,16}$/', $username)) {
      $_SESSION['message'] = '用户名不符合格式';
      $_SESSION['message_tag'] = 'error';
  }else if (!preg_match('/^[\x20-\x7E]{6,}$/', $password)){
      $_SESSION['message'] = '密码不符合格式';
      $_SESSION['message_tag'] = 'error';
  }else{
      $result_1 = $conn->query($sql_1);
      $row = $result_1->fetch_array();
      if ($row['COUNT(*)'] > 0){
        $_SESSION['message'] = '该用户名已被注册';
        $_SESSION['message_tag'] = 'error';
      }else{
        $result_2 = $conn->query($sql_2);
        if (!$result_2 === TRUE){
          $_SESSION['message'] = '注册失败';
          $_SESSION['message_tag'] = 'error';
        }else{
          $_SESSION['message'] = '注册成功';
          $_SESSION['message_tag'] = 'success';

        }
      }

  }

}

?>
<?php require_once('header.php'); ?>
<div class="ui segment">
  <h1>注册界面</h1>
</div>
<?php
if (isset($_SESSION['message']) && isset($_SESSION['message_tag'])){
  echo '<div class="ui info message"><p>'.$_SESSION['message'].'</p></div>';
}
?>
<div class="ui info message">
  <div class="header">
    注意！
  </div>

  <p>用户名只允许 A-Z / a-z / 0-9 / _ / - .</p>
  <p>不要使用常用密码注册！</p>
</div>
<?php unset($_SESSION['message']); unset($_SESSION['message_tag']);  ?>
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
  <button class="ui button" type="submit">登录</button>
</form>
<?php $conn->close();?>
</body>
</html>
