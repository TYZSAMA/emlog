<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
$att_img = getAttachment($att_img,350,300);
$datetime = explode("-",$post_time);
$year = $datetime['0'] . "/" .$datetime['1'];
$day = substr($datetime['2'],0,2);
?>
<div class="post">
	<div class="postdate">
	  <p class="date"><?php echo $day;?>th</p>
	  <p class="year"><?php echo $year;?></p>
	</div>
	<div class="posttitle">
	<h2><?php echo $log_title;?></h2>
    <p class="postmeta"></p>
    </div>

	<div class="content">
		<p><?php echo $log_content;?></p>
		<a name="att"></a>
		<p><?php echo $att_img;?></p>
		<p><?php echo $att_img;?></p>	
		<p class="tags"><?php echo $tag;?></p>
		<p><?php echo $neighborLog;?></P>			
	</div>				
<?php if($allow_tb == 'y'): ?>	
	<div id="comments">
	<h3 id="respond">引用地址：<input type="text" style="width:350px" value="<?php echo $blogurl;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>" /><a name="tb"></a></h3>
	</div>
<?php endif; ?>	
<div id="comments">
<h3 id="respond"><a name="comment"></a>评论</h3>
<p></p>

<ol class="commentlist">
<?php
foreach($com as $key=>$value):
$value['reply'] = $value['reply']?"<span style=\"color:green;\"><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	<li class="alt" id="comment-<?php echo $value['cid'];?>"><a name="<?php echo $value['cid'];?>"></a>
			<?php echo $value['poster'];?> Says:<br />
			<small class="commentmetadata"><?php echo $value['addtime'];?> </small>
			<p><?php echo $value['content'];?></p>
			<p><?php echo $value['reply'];?></p>
	</li>	
	
<?php endforeach; ?>
</ol>

<ol class="commentlist">
<?php foreach($tb as $key=>$value): ?>
	<li id="comment-<?php echo $value['cid'];?>">
	<cite>引用来自：<strong><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></strong> &#8212; <?php echo $value['date'];?></cite>		<br/>
	<cite>标题：<a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a></cite><br />
	<cite>摘要：<?php echo $value['excerpt'];?></cite>
	</li>
<?php endforeach; ?>
</ol>
<?php if($allow_remark == 'y'): ?>
<h3 id="respond">发表评论</h3>
<p></p>
<form  method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
	<p>
	  <input type="text" name="comname" id="email" value="<?php echo $ckname;?>" size="40" tabindex="1" />
	   <label for="author"><small>姓名</small></label>
	<input type="hidden" name="gid" value="<?php echo $logid;?>" />
	</p>

	<p>
	  <input type="text" name="commail" id="email" value="<?php echo $ckmail;?>" size="40" tabindex="2" />
	   <label for="email"><small>邮件地址(选填)</small></label>
	</p>
	<p>
	  <input type="text" name="comurl" id="email" value="<?php echo $ckurl;?>" size="40" tabindex="2" />
	   <label for="email"><small>个人主页(选填)</small></label>
	</p>
	<p>
	  <textarea name="comment" id="comment" cols="55" rows="15" tabindex="4"></textarea>
	</p>

	<p>
	 <input name="submit" id="submit" type="submit" tabindex="5" value="发布我的评论" onclick="return checkform()" /><?php echo $cheackimg;?> <input type="checkbox" name="remember" value="1" checked="checked" /><small>记住我</small></td>
	</p>
</form>
</div>
<?php endif; ?>
</div>
</div>
</div>
</div>
<?php
include getViews('footer');
?>