<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,600,500);
?>
<div id="content">
<div class="entry single">

<h1><?php echo $log_title;?></h1>

<p class="info">
<em class="date">Posted on <?php echo $post_time;?></em>
</p>
				<?php echo $log_content;?>
<a name="att"></a>
<p><?php echo $att_img;?></p>
<p><?php echo $attachment;?></p>	
<p><?php echo $tag;?></p>
<p><?php echo $neighborLog;?></P>
</div>

<?php
if($allow_tb == 'y'){
?>	
<div class="comments-template">
<h2 id="comments">引用:<a name="tb"></a></h2>
<input type="text" style="width:350px" class="input" value="<?php echo $blogurl;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>"><a name="tb"></a></p>
</div>
<?php
}?>

<div class="comments-template">
<h2 id="comments"><a name="comment"></a>评论</h2>

<p></p>

<ol id="commentlist">
<?php
foreach($com as $key=>$value){
$value['reply'] = $value['reply']?"<span style=\"color:#6C8C37;\"><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	<li id="comment-<?php echo $value['cid'];?>"><a name="<?php echo $value['cid'];?>"></a>
	<cite>Comment by <strong><?php echo $value['poster'];?></strong> &#8212; <?php echo $value['addtime'];?></cite>
	<br /><?php echo $value['content'];?><br /><?php echo $value['reply'];?></li>
<?php
}?>
</ol>

<ol id="commentlist">
<?php
foreach($tb as $key=>$value){
?>
	<li id="comment-<?php echo $value['cid'];?>">
	<cite>Trackback by <strong><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></strong> &#8212; <?php echo $value['date'];?></cite><br/>
	<a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a><br/>
	<?php echo $value['excerpt'];?>
	</li>
<?php
}?>
</ol>
<?php
if($allow_remark == 'y'){
?>
<h2>发表评论</h2>
<p></p>

<form method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
<fieldset>

<input type="hidden" name="gid" value="<?php echo $logid;?>" />
<p>
  <label for="author">姓名</label> <input type="text" name="comname" id="author" value="<?php echo $ckname;?>" tabindex="1" />
</p>

<p><label for="email">电子邮件</label> <input type="text" name="commail" id="email" value="<?php echo $ckmail;?>" tabindex="2" />
  <em>(选填)</em>
</p>

<p><label for="email">个人主页</label> <input type="text" name="comurl" id="email" value="<?php echo $ckurl;?>" tabindex="2" />
  <em>(选填)</em>
</p>

<p>
  <label for="comment">内容</label> <textarea name="comment" id="comment" cols="45" rows="10" tabindex="4"></textarea></p>
<p><input type="hidden" name="comment_post_ID" value="7" />
<input type="submit" name="submit" value="发布我的评论" class="button" tabindex="5" onclick="return checkform()"/>
<?php echo $cheackimg;?> 
<input type="checkbox" name="remember" value="1" checked="checked" class="inp" /><small>记住我</small></p>

</fieldset>
</form>
<?php
}?>
</div>
<?php
?>
</div>
<?php
include getViews('side');
include getViews('footer');
?>