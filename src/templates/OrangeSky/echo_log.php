﻿<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,500,300);
print <<<EOT
-->
		<div class="post">
		<br />
		<br />

			<h2>$log_title</h2>
			<div class="entry">
				$log_content
<a name="att"></a>
<p>$att_img</p>
<p>$attachment</p>	
<p>$tag</p>
<p>Posted on $post_time<br /></p>
</div>
<div class="commentdata">
<h3 id="respond">引用:<a name="tb"></a></h3>
<li>GBk: {$blogurl}trackback.php?id=$logid&amp;charset=gbk</li>  
<li>UTF-8: {$blogurl}trackback.php?id=$logid&amp;charset=utf-8</li>
</div>
</div>
<div class="comments-template">
<h3 id="respond"><a name="comment"></a>评论</h3>

<p></p>

<ol class="commentlist">
<!--
EOT;
foreach($com as $key=>$value){
print <<<EOT
-->
<li class="alt" id="comment-8"><a name="$value[cid]"></a>
			<cite>$value[poster]</cite> Says:<br />
			<span>$value[content]</span><br />
			<p class="commentmetadata">$value[addtime]</p>
		</li>
<!--
EOT;
}print <<<EOT
-->
</ol>

<ol class="commentlist">
<!--
EOT;
foreach($tb as $key=>$value){
print <<<EOT
-->
<li class="alt" id="comment-8">
	<cite>trackback by <strong><a href="$value[url]" target="_blank">$value[blog_name]</a></strong> &#8212; $value[date]</cite><br/>
	<a href="$value[url]" target="_blank">$value[title]</a><br/>
	$value[excerpt]
	</li>
<!--
EOT;
}print <<<EOT
-->
</ol>

<h3 id="respond">发表评论</h3>
<p></p>

<form  method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
	<p>
	  <input type="text" name="comname" id="email" value="$ckname" size="40" tabindex="1" />
	   <label for="author"><small>姓名</small></label>
	<input type="hidden" name="gid" value="$logid" />
	</p>

	<p>
	  <input type="text" name="commail" id="email" value="$ckmail" size="40" tabindex="2" />
	   <label for="email"><small>邮件地址</small></label>
	</p>

	<p>
	  <label for="comment"><small>评论内容</small></label>
	  <br />
	  <textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
	</p>

	<p>
	 <input name="submit" type="submit" tabindex="5" value="发布我的评论" onclick="return checkform()" /> $cheackimg <input type="checkbox" name="remember" value="1" checked="checked" /><small>记住我</small>
	</p>
</form>

</div>
<!--
EOT;
print <<<EOT
-->
</div>
</div>
EOT;
include getViews('side');
include getViews('footer');
?>