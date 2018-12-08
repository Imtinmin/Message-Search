<?php
session_start();
require_once('config.php');
error_reporting(0);
@$myidea = addslashes($_POST['myidea']);
$myidea = trim($myidea);
$myidea = htmlspecialchars($myidea);  #防XSS
@$author = addslashes($_POST['author']);
$author = trim($author);
$author = htmlspecialchars($author);
$time = date("Y-m-d");
$time = (string)$time;
$time = trim($time);
$conn = new mysqli($GLOBALS['db_addr'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
$sql = "INSERT INTO comment(author,comment,subtime) values ('{$author}','{$myidea}','{$time}')";
if (isset($myidea) && strlen($myidea) > 0 && isset($author) && strlen($author) > 0){
  //$conn = new mysqli($GLOBALS['db_addr'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
  $result = $conn->query($sql);
  if (!$result === TRUE){
      echo "Error comment".'<br>'.$conn->error;
  }
}
?>
<?php require_once('header.php');?>
<form class="ui reply form"  method="POST">
    <div class="field">
      <label>Author</label>
      <input type="text" name="author" placeholder="Your name">
    </div>
    <div class="field">
      <label>Content</label>
      <textarea name="myidea" placeholder="输入您的留言..."></textarea>
    </div>
      <button class="ui button" type="submit">留言</button>
  </form>
</div>
<div class="ui comments">
  <h3 class="ui dividing header">留言板</h3>
</div>

    

<?php
$conn = new mysqli($GLOBALS['db_addr'],$GLOBALS['db_user'],$GLOBALS['db_pass'],$GLOBALS['db_name']);
$sql_1 = "SELECT `author`,`comment`,`subtime` FROM comment";
$query = $conn->query($sql_1);
echo '<div class="ui comments">';
if ($query->num_rows > 0){
  while($row = $query->fetch_array()){

    echo '<div class="comment"><a class="avatar"><img src="/emmmm/images/comment.jpg"></a><div class="content">';
    echo '<a class="author">'.$row['author'].'</a>';
    echo '<div class="metadata"><span class="date">'.$row['subtime'].'</span></div>';
    echo '</div></div><div class="text">'.$row['comment'].'</div>';

}
}

$conn->close();
?>
</div>
</body>
</html>
