﻿<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value){
//$value[att_img] = getAttachment($value[att_img],200,120);
echo <<<EOT
-->
		<div class="post" id="post-$value[logid]">
<h2>
{$value['toplog']}<a href="./?action=showlog&gid={$value['logid']}">{$value['log_title']}</a>
</h2>
<div class="entry">
$value[log_description]
<p>$value[att_img]</p>
<p>$value[attachment]</p>
<p>$value[tag]</p>
<p class="postinfo">
	Posted on $value[post_time]<br />
 	<a href="./?action=showlog&gid={$value['logid']}#comment">评论({$value['comnum']})</a>
 	<a href="./?action=showlog&gid={$value['logid']}#tb">引用({$value['tbcount']})</a> 
 	<a href="./?action=showlog&gid={$value['logid']}">浏览({$value['views']})</a>
</p>
</div>
</div>
<!--
EOT;
}echo <<<EOT
-->
<div class="browse">$page_url</div>
<!--
EOT;
echo <<<EOT
-->
</div>
EOT;
include getViews('side');
include getViews('footer');
?>