﻿<!--<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta name="description" content="$sitekey" />
<meta name="keywords" content="emlog,blog,$sitekey" />
<meta name="copyright" content="emlog" />
<meta name="author" content="emlog" />
<title>$blogtitle</title>
<link href="{$tpl_dir}wp/main.css" rel="stylesheet" type="text/css" />
<script src="{$tpl_dir}wp/main.js" type="text/javascript"></script>
</head>
<body onload="sendinfo('$calendar_url','calendar');">
<DIV id=page>
<DIV id=header>
<DIV id=headerimg>
<H1><a href="./">$blogname</a></H1><p>
<DIV class=description>$blog_info</DIV></DIV></DIV>
<HR>
<DIV class=narrowcolumn id=content>
<!--
EOT;
?>-->