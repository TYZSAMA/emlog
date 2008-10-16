<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
//$att_img = getAttachment($att_img,600,500);
?>
<div id="content">
<div class="post">
<?php
$value['att_img'] = getAttachment($att_img,200,120);
$datetime = explode("-",$post_time);
$year = $datetime['0'];
$day = $datetime['1']."/".substr($datetime['2'],0,2);
?> 
				<div class="dtm">
					<div class="dtmtmc">
						<div class="titlemeta">
							<?php echo $log_title; ?><br/>
							<span class="byline"><?php echo $tag ?></span>
						</div>
					</div>
					<div class="dtmdate">
						<div class="date"><?php echo $year; ?><br /><span><?php echo $day ?></span></div>
					</div>
				</div>
				<div class="postcontent">
				<?php echo $log_content; ?>
				<p><?php echo $att_img; ?></p>
				<p><?php echo $attachment; ?></p>	
				</div>
				<div class="neighbor">
				<?php if($previousLog):?>
				&laquo; <a href="./?action=showlog&gid=<?php echo $previousLog['gid']; ?>"><?php echo $previousLog['title'];?></a>
				<?php endif;?>
				<?php if($nextLog && $previousLog):?>
				|			
				<?php endif;?>
				<?php if($nextLog):?>
	 			<a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
				<?php endif;?>
				</div>
				<?php if($allow_tb == 'y'):?>	
				<div id="tb_list">
				<p><b>Trackback：</b><br /><input type="text" style="width:300px" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
				<?php endif; ?>
				<?php foreach($tb as $key=>$value):?>
				<li>来自: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></li>
    			<li>标题: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
    			<li>摘要:<?php echo $value['excerpt'];?></li>
				<li>引用时间:<?php echo $value['date'];?></li>
				<?php endforeach; ?>
				</div>
				<div id="comm">
				<?php if($com): ?>
				<p><b>评论:</b><a name="comment"></a></p>
				<?php endif; ?>
				<?php
				foreach($com as $key=>$value):
				$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
				?>
				<li>
					<a name="<?php echo $value['cid']; ?>"></a>
					<strong><?php echo $value['poster']; ?> </strong>
					<?php if($value['mail']):?>
					<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
					<?php endif;?>
					<?php if($value['url']):?>
					<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">Home</a>
					<?php endif;?>
					<?php echo $value['addtime']; ?>
					<br /><?php echo $value['content']; ?>
					<br />
					<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
					<?php if(ISLOGIN === true): ?>	
					<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
					<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
					<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
					<br />
					<a href="javascript:void(0);" onclick="postinfo('./admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
					<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
					</div>
					<?php endif; ?>
				</li>
				<?php endforeach; ?>
				
				<?php if($allow_remark == 'y'): ?>
				<p><b>发表评论:</b><a name="comment"></a></p>
				<form  method="post"  name="commentform" action="index.php?action=addcom">
				<table width="420" border="0" cellspacing="5" cellpadding="0">
				<tr>
				<td>姓　　名：</td>
				<td>
				<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
				<input type="text" name="comname" style="width:200px" maxlength="49" class="commin" value="<?php echo $ckname; ?>"></td>
				</tr>
				<tr>
				<td>电子邮件:</td>
				<td><input type="text" name="commail" style="width:200px" maxlength="128"  class="commin" value="<?php echo $ckmail; ?>">(选填)</td>
				</tr>
				<tr>
				<td>个人主页:</td>
				<td><input type="text" name="comurl" style="width:200px" maxlength="128" class="commin"  value="<?php echo $ckurl; ?>">(选填)</td>
				</tr>
				<tr>
				<td valign="top">内　　容：</td>
				<td><textarea name="comment"class="commin"  style="width:300px;height:155px"></textarea>
				</td>
				</tr>
				<tr>
				<td valign="top">&nbsp;</td>
				<td valign="top"><?php echo $cheackimg; ?><input class="sub" name="Submit" type="submit" value="发表评论" onclick="return checkform()" />
				<input type="checkbox" name="remember" value="1" checked="checked" />记住我</td>
				</tr>
				</table>
				</form>
				<?php endif; ?>
				</div>
<br/>
</div>
</div>
<?php include getViews('footer'); ?>