﻿<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->

	<div class="maincolumn">

		<div class="banner">&#160;</div>

		<div class="clear"></div>
<!--
EOT;
foreach($logs as $value){
//$value[att_img] = getAttachment($value[att_img],200,120);
print <<<EOT
-->

		<div class="post" id="post-$value[logid]">
		<div class="wrapper">

			<div class="postmeta">
				<ul>
					<li>Posted on: $value[post_time]</li>
					<li> 
					<a href="?action=showlog&gid=$value[com_url]">评论($value[comnum])</a></li>
					<li><a href="?action=showlog&gid=$value[tb_url]">引用($value[tbcount])</a> 
					 <a href="?action=showlog&gid=$value[logid]">浏览($value[views])</a></li>
				</ul>
			</div>

			<h2>$value[toplog]<a href="?action=showlog&gid=$value[logid]">$value[log_title]</a></h2>

			<div class="entry">
				$value[log_description]
<p>$value[att_img]</p>
<p>$value[attachment]</p>
<p>$value[tag]</p>
			</div>

		</div>
		</div>
<!--
EOT;
}print <<<EOT
-->
<p>$page_url</p>
</div>
EOT;
include getViews('side');
include getViews('footer');
?>

