<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $sitekey; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="订阅我的博客"  href="./rss.php">
<link href="<?php echo $em_tpldir; ?>/main.css" rel="stylesheet" type="text/css" />
<script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="header">
	<div id="menu"><div class="rimg"><div class="limg">
        <div class="search">
    	<center>
    	<form name="keyform" class="search_form" method="get" action="index.php"><p>
		<input name="keyword"  type="text" value="" style="width:130px;"/>
		<input type="image" src="<?php echo $em_tpldir; ?>/images/bttn_search.gif" onclick="return keyw()" />
		</center>
		</form>
    	</div>
		<ul>
			<li><a href="./">home</a></li>
			<li><a href="http://www.emlog.net" target="_blank">emlog</a></li>
		</ul>
	</div></div></div>
<div class="clear"></div>
	<h1><a href="./" target="_self"><?php echo $blogname; ?></a></h1>
	<h4><?php echo $bloginfo; ?></h4>	
</div>
