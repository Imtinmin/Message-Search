<!DOCTYPE html>
<html>
<head>
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<script src="semantic/dist/semantic.min.js"></script>
<script src="semantic/dist/form.js"></script>
<script src="semantic/dist/search.js"></script>
<link rel="stylesheet" type="text/css" href="semantic/dist/components/menu.css">
<link rel="stylesheet" type="text/css" href="semantic/dist/components/form.css">
<link rel="stylesheet" type="text/css" href="semantic/dist/components/button.css">
<link rel="stylesheet" type="text/css" href="semantic/dist/components/segment.css">
<link rel="stylesheet" type="text/css" href="semantic/dist/components/header.css">
<link rel="stylesheet" type="text/css" href="semantic/dist/components/search.css">
<link rel="stylesheet" type="text/css" href="semantic/dist/components/message.css">
<link rel="stylesheet" type="text/css" href="semantic/dist/components/comment.css">
<link rel="stylesheet" type="text/css" href="semantic/dist/components/dropdown.css">
<link rel="stylesheet" type="text/css" href="semantic/dist/components/table.css">
  <title>XXXX信息查询系统</title>
  <?php require_once('config.php'); ?>
</head>
<body>
<div class="ui secondary menu">
  <a href="index.php" class="active item">
    <?php echo $GLOBALS['index']; ?>
  </a>
  <a href="link.php" class="item">
    友情链接
  </a>
  <a href="wooyun.php" class="item">
    乌云镜像
  </a>
  <a href="comment.php" class="ui item">
      留言板
  </a>
  <div class="right menu">
  <?php if (isset($_SESSION['user'])) { ?>
      <a href="logout.php" class="ui item">注销 <?php echo $log_user; ?></a>
      <a href="ucenter.php" class="ui item">用户中心</a>
  <?php }else{ ?>
      <a href="register.php" class="ui item">注册</a>
      <a href="login.php" class="ui item">登录</a>
  <?php } ?>
  </div>
</div>
