
<?php
session_start();
include'config.php';
		#获取页面头部  
$conn = new mysqli($GLOBALS['db_addr'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);

if (isset($_SESSION['user'])){
	$user_id = $_SESSION['user'];
	$row = $conn->query("SELECT username from user where user_id=$user_id")->fetch_array();
	$log_user = $row['username'];
}

@$search = $_POST['search'];
$search = trim($search);
$search = $conn->real_escape_string($search);

@$type = $_POST['type'];
$type = trim($type);

$sql_1 = "SELECT * FROM message WHERE Stu_No=('$search')";
$sql_2 = "SELECT * FROM message WHERE Stu_Name=('$search')";

if (isset($search) && strlen($search) > 0){
  if (!isset($type) && strlen($type) > 0){
    echo '<script>alert("请选择类型")</script>';
  }else if (!preg_match('/^num|name$/', $type)) {
    echo '<script>alert("类型错误")</script>';
  }else{
     if ($type==='num'){
      $row = $conn->query($sql_1)->fetch_array();
    }else if($type==='name'){
      $row = $conn->query($sql_2)->fetch_array();
    }else{
      echo '<script>alert("类型错误")</script>';
    }
  }
   
}

require('header.php');
?>
<div class="ui center aligned raised very padded text container segment">
  <h2>请输入要查找的东西……</h2>
  <form class="ui search" method="POST">
  <div class="ui search">
    <input class="prompt" name="search" type="text" placeholder="something...">
    <i class="search icon"></i>
   <select name="type" class="ui simple dropdown item">
    <option value="">选择</option>
    <option value="num">学号</option>
    <option value="name">姓名</option>
    </select> 
  </div>
 <!--     图形化列表显示信息 -->
  <p></p>
  <button class="ui blue button" type="submit">查询</button>
  </div>
</form>
<table class="ui celled table">
  <thead>
    <tr>
      <th>学号</th>
      <th>名字</th>
      <th>性别</th>        
      <th>爱好</th>
    </tr>    
  </thead>
  <tbody>
    <?php if (isset($row)){ ?><tr class="positive">
      <td><?php echo $row['Stu_No'] ?></td>
      <td><?php echo $row['Stu_Name']?></td>
      <td><?php echo $row['SEX']?></td>
      <td><?php echo $row['Hobby']?></td>
    </tr>
    <?php }?>
  </tbody>
</table>
</div>
<body>
</html>