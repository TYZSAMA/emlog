<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
$loadcal = " onload=\"sendinfo('$calendar_url');\"";
echo <<<EOT
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

	<title>$blogtitle</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="zh-CN" />
	<meta name="description" content="$sitekey" />
	<meta name="keywords" content="emlog,blog,$sitekey" />
	<meta name="copyright" content="emlog" />
	<meta name="author" content="emlog" />

	<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
	<link href="{$tpl_dir}OrangeSky/style.css" rel="stylesheet" type="text/css" />
	<script src="{$tpl_dir}fruitlicious/main.js" type="text/javascript"></script>
</head>
<body onload="sendinfo('$calendar_url');">

<div id="page">
<div id="main">
<ul id="menu">
	<li class="page_item"><a href="./">首页</a></li>
    <li class="page_item"><a href="./?action=tag">标签</a></li>
    <li class="page_item"><a href="./adm">登录</a></li>
</ul>

<div id="header">
	<div id="headerimg">
		<h1><a href="./">$blogname</a></h1><br />
		<p class="description">$blog_info</p>
	</div>
</div>
<div id="content">
<!--
EOT;
?>-->
