<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="keywords" content="<?php echo $site_key; ?>" />
	<meta name="generator" content="emlog" />
	<title><?php echo $blogtitle; ?></title>
	<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo $blogurl; ?>rss.php">
	<link href="<?php echo $tpl_dir; ?>devart/style.css" rel="stylesheet" type="text/css" />
	<!--[if IE]>
    	<link rel="stylesheet" type="text/css" href="<?php echo $tpl_dir; ?>/ie.css" media="screen" />
    <![endif]-->
    <script src="./lib/js/common_tpl.js" type="text/javascript"></script>
</head>

<body>

<div id="container">

	<div id="header">
		<h1><a href="./"><?php echo $blogname; ?></a><span><?php echo $bloginfo; ?></span></h1>
		<div id="search">
			<form method="get" id="searchform" action="./index.php">
				<input type="text" value="搜索..." name="keyword" id="s" onfocus="if(this.value=='搜索...')this.value=''" onblur="if(this.value=='')this.value='搜索...'" />
				<input type="submit" id="searchsubmit" value="" />
			</form>
		</div>
	</div>

	<div id="nav">
		<ul>
			<li class="current_page_item"><a href="./">首页</a></li>
			<?php if(ISLOGIN): ?>
			<li><a href="./admin/write_log.php">写日志</a></li>
			<li><a href="./admin/">管理中心</a></li>
			<li><a href="./admin/index.php?action=logout">退出</a></li>
			<?php else: ?>
				<li><a href="./admin/index.php">登录</a></li>
			<?php endif; ?>
		</ul>
		<a href="./rss.php" id="feed"></a>
	</div>
	
	<div id="wrapper">