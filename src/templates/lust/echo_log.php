<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,500,300);
print <<<EOT
-->
<div class="maincolumn">

<div class="banner">&#160;</div>

		<div class="clear"></div>

		
		<div class="post" id="post-7"><div class="wrapper">

			<div class="postmeta">
				<ul>
					<li>Posted on: $post_time</li>
				</ul>
			</div>

			<h2>$log_title</h2>

			<div class="entry">
				<p>$log_content</p>
				<a name="att"></a>
				<p>$att_img</p>
				<p>$attachment</p>	
				<p>$tag</p>
			</div>

		</div></div>

		
		<div class="clear"></div>
<div class="comments_template"><div class="wrapper">

<ol class="commentlist">
<!--
EOT;
foreach($com as $key=>$value){
print <<<EOT
-->
	<li id="comment-$value[cid]">
			<div class="commentmeta">
			<ul>
				<li><a name="$value[cid]"></a>评论：<strong>$value[poster]</strong></li>
				<li><a href="#comment-2" title="">$value[addtime]</a></li>
			</ul>
			</div>

			<div class="commenentry">
				
				<p>$value[content]</p>
			</div>

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
	<li id="comment-$value[cid]">
			<div class="commentmeta">
			<ul>
				<li>引用：<strong><a href="$value[url]" target="_blank">$value[blog_name]</a></strong></li>
				<li>$value[date]</li>
			</ul>
			</div>

			<div class="commenentry">
				
				<p>	<a href="$value[url]" target="_blank">$value[title]</a><br/>
	$value[excerpt]</p>
			</div>

		</li>
<!--
EOT;
}print <<<EOT
-->
	
	</ol>
<a name="comment"></a>
<div class="comments_form">

<h3 id="respond">发表你的评论</h3>


<form  method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
	<p>
	  <input type="text" name="comname" id="email" value="$ckname" size="40" tabindex="1" />
	   <label for="author"><small>姓名</small></label>
	<input type="hidden" name="gid" value="$logid" />
	</p>

	<p>
	  <input type="text" name="commail" id="email" value="$ckmail" size="40" tabindex="2" />
	   <label for="email"><small>邮件地址(选填)</small></label>
	</p>

	<p>
	  <label for="comment"><small>评论内容</small></label>
	  <br />
	  <textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
	</p>

	<p>
	 <input name="submit" type="submit" tabindex="5" value="发布我的评论" onclick="return checkform()" /> $cheackimg <input type="checkbox" name="remember" value="1" checked="checked" /><small>记住我</small></td>
	</p>
</form>

</div>


		</div></div>

		<div class="clear"></div>
		
	</div>
EOT;
include getViews('side');
include getViews('footer');
?>