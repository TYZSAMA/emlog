<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<html>
<head>
<meta HTTP-EQUIV="REFRESH" CONTENT="3;URL=$url">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-CN" />
<link href="<?php echo $tpl_dir;?>g7/main.css" rel="stylesheet" type="text/css">
<title>系统消息</title>
</head>
<body>
<div class="content">
<h5><?php echo $msg;?></h5>
<p>3秒后将自动跳转<p>
<p><a href="<?php echo $url;?>">如果你不想等待或浏览器没有自动跳转请点击这里!</a></p>
</div>
</body>
</html>
<?php
?>
