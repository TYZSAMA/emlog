<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<html>
<head>
<meta HTTP-EQUIV="REFRESH" CONTENT="3;url=<?php echo $url; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-CN" />
<link href="<?php echo $em_tpldir; ?>/style.css" rel="stylesheet" type="text/css">
<title>系统消息</title>
</head>
<body>
<div id="page">
<div id="content">
<h5><?php echo $msg;?></h5>
<p>3秒后将自动跳转<p>
<p><a href="<?php echo $url;?>">如果你不想等待或浏览器没有自动跳转请点击这里!</a></p>
</div>
</div>
</body>
</html>