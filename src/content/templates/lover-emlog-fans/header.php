<?php
/*
Template Name:love-emlog-fans
Description:献给emlog的忠实fans，希望大家也常来f75h做客。
Author:f75h
Author Url:
Sidebar Amount:1
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once (getViews('module'));
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
<?php doAction('index_head'); ?>
</head>
<body>
<div id="header_box">
	<div id="header_left">
    	<div id="logo">
        <a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a>
        </div>
        <div id="header_dh">
        	<div id="header_dh_left">
            </div>
            <div id="header_dh_cen">
                <span class="header_dh_cen_text"><a href="<?php echo BLOG_URL; ?>">首页</a></span>
				<?php if(ISLOGIN): ?>
				<span class="header_dh_cen_text"><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></span>
				<span class="header_dh_cen_text"><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></span>
				<span class="header_dh_cen_text"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></span>
				<?php else: ?>
				<span class="header_dh_cen_text"><a href="<?php echo BLOG_URL; ?>admin/">登录</a></span>
				<?php endif; ?>          
            </div>
            <div id="header_dh_right">
            </div>
        </div>      
    </div>
	<div id="header_right">
    </div>
</div>
<div class="clear"></div>
