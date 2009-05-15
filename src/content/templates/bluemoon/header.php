<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php">
<link href="<?php echo CERTEMPLATE_URL; ?>/main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
</head>
<body>
<div id="header">
	<div id="menu"><div class="rimg"><div class="limg">
        <div class="search">
    	<center>
    	<form name="keyform" class="search_form" method="get" action="<?php echo BLOG_URL; ?>index.php"><p>
		<input name="keyword"  type="text" value="" style="width:130px;"/>
		<input type="image" src="<?php echo CERTEMPLATE_URL; ?>/images/bttn_search.gif" onclick="return keyw()" />
		</center>
		</form>
    	</div>
		<ul>
			<li><a href="<?php echo BLOG_URL; ?>">home</a></li>
			<?php if(ISLOGIN): ?>
				<li><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
				<li><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
				<li><a href="<?php echo BLOG_URL; ?>admin/index.php?action=logout">退出</a></li>
			<?php else: ?>
				<li><a href="<?php echo BLOG_URL; ?>admin/index.php">登录</a></li>
			<?php endif; ?>
		</ul>
	</div></div></div>
<div class="clear"></div>
	<h1><a href="<?php echo BLOG_URL; ?>" target="_self"><?php echo $blogname; ?></a></h1>
	<h4><?php echo $bloginfo; ?></h4>	
</div>
