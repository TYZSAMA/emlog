<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php
//widget：blogger
function widget_blogger($title){
	global $user_cache; 
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<h4><em onclick="showhidediv('blogger')"><?php echo $title; ?></em></h4>
	<ul id="blogger">
		<li>
		<?php if (!empty($user_cache[1]['photo']['src'])): ?>
		<img src="<?php echo $user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
		<?php endif;?>
		</li>
		<li><span id="bloggerdes"><?php echo $user_cache[1]['des']; ?></span>
		<?php if(ROLE == 'admin'): ?>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
		<li id='modbdes' style="display:none;">
		<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:160px;height:50px;"><?php echo $user_cache[1]['des']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./admin/blogger.php?action=update&flg=1','bdes','bloggerdes');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
		<?php endif; ?>
		</li>
	</ul>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){
	global $calendar_url; ?>
	<h4><em onclick="showhidediv('calendar')"><?php echo $title; ?></em></h4>
	<ul>
	<div id="calendar"></div>
	</ul>
	<script>sendinfo('<?php echo $calendar_url;?>','calendar');</script>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $tag_cache; ?>
	<h4><em onclick="showhidediv('tag')"><?php echo $title; ?></em></h4>
	<ul id="tag">
	<?php foreach($tag_cache as $value): ?>
	<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;">
	<a href="./?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a>
	</span>&nbsp;
	<?php endforeach; ?>	
	</ul>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $sort_cache; ?>
	<h4><em onclick="showhidediv('sort')"><?php echo $title; ?></em></h4>
	<ul id="sort">
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="./?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="./rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo CERTEMPLATE_URL; ?>/images/icon_rss.gif" alt="订阅该分类"/></a>
	</li>
	<?php endforeach; ?>	
	</ul>
<?php }?>
<?php
//widget：twitter
function widget_twitter($title){
	global $tw_cache,$index_twnum,$localdate; ?>
	<?php if($index_twnum>0): ?>
	<h4 onclick="showhidediv('twitter')"><em><?php echo $title; ?></em></h4>
	<ul id="twitter" class="posts">
	<?php if(isset($tw_cache) && is_array($tw_cache)):
	$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('./twitter.php?p=2','twitter')\">更早的&raquo;</a></li>":'';
	foreach (array_slice($tw_cache,0,$index_twnum) as $value):
		$delbt = ROLE == 'admin'?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
		$value['date'] = smartyDate($localdate,$value['date']);
	?>
	<li> <?php echo $value['content'];?> <?php echo $delbt;?><br><span><?php echo $value['date'];?></span></li>
	<?php  endforeach; ?>
	<?php echo $morebt; ?>
	<?php endif; ?>
	</ul>
	<?php if(ROLE == 'admin'): ?>
	<ul>
	<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
	<li id='addtw' style="display: none;">
	<textarea name="tw" id="tw" style="overflow-y: hidden;width:180px;height:70px;" class="input"></textarea>
	<a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
	</li>
	</ul>
	<?php endif; ?>
	<?php endif; ?>
<?php } ?>
<?php 
//widget：音乐
function widget_music($title){
	global $musicdes,$musicurl,$autoplay; ?>
	<h4><em onclick="showhidediv('music')"><?php echo $title; ?></em></h4>
	<ul id="music">
	<?php echo $musicdes;?><object type="application/x-shockwave-flash" data="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?>
	<?php echo $autoplay;?>&autoreplay=1" width="180" height="20"><param name="movie" value="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?>
	<?php echo $autoplay;?>&autoreplay=1" /></object>
	</p>
	</ul>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $com_cache; ?>
	<h4><em onclick="showhidediv('newcomm')"><?php echo $title; ?></em></h4>
	<ul id="newcomm" class="posts">
	<?php 
	foreach($com_cache as $value): 
	$value['url'] = $value['url'];
	?>
			<li><?php echo $value['name']; ?> 
	<?php if($value['reply']): ?>
		<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/reply.gif" align="absmiddle"/>
		</a>
	<?php endif;?>
	<br /><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
	<?php endforeach; ?>	
	</ul>
<?php }?>
<?php
//widget：最新日志
function widget_newlog($title){
	global $newLogs_cache; ?>
	<h4><em onclick="showhidediv('newlog')"><?php echo $title; ?></em></h4>
	<ul id="newlog" class="posts">
	<?php foreach($newLogs_cache as $value): ?>
	<li><a href="./?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>	
	</ul>
<?php }?>
<?php
//widget：随机日志
function widget_random_log($title){
	global $index_randlognum, $emBlog;
	if (!isset($emBlog))
	{
		global $DB;
		require_once(EMLOG_ROOT.'/model/C_blog.php');
		$emBlog = new emBlog($DB);
	}
	$randLogs = $emBlog->getRandLog($index_randlognum);?>
	<h4><em onclick="showhidediv('randlog')"><?php echo $title; ?></em></h4>
	<ul id="randlog" class="posts">
	<?php foreach($randLogs as $value): ?>
	<li><a href="./?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>	
	</ul>
<?php }?>
<?php
//widget：归档
function widget_archive($title){
	global $dang_cache; ?>
	<h4><em onclick="showhidediv('record')"><?php echo $title; ?></em></h4>
	<ul class="record" id="record">
	<?php foreach($dang_cache as $value): ?>
	<li><a href="./<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
	<?php endforeach; ?>	
	</ul>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content, $id){ ?>
	<h4><em onclick="showhidediv('<?php echo $id; ?>')"><?php echo $title; ?></em></h4>
	<ul id="<?php echo $id; ?>">
	<p><?php echo $content; ?></p>	
	</ul>	
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $link_cache; ?>
	<h4><em onclick="showhidediv('blogroll')"><?php echo $title; ?></em></h4>
	<ul class="links" id="blogroll">
	<?php foreach($link_cache as $value): ?>     	
			<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
	<?php endforeach; ?>
	</ul>
<?php }?>
<?php
//widget：博客信息
function widget_bloginfo($title){
	global $sta_cache,$viewcount_day,$viewcount_all; ?>
	<h4><em onclick="showhidediv('sta')"><?php echo $title; ?></em></h4>
	<ul class="months" id="sta">
			<li>日志数量：<?php echo $sta_cache['lognum'];?></li>
			<li>评论数量：<?php echo $sta_cache['comnum'];?></li>
			<li>引用数量：<?php echo $sta_cache['tbnum'];?></li>
			<li>今日访问：<?php echo $viewcount_day;?></li>
			<li>总访问量：<?php echo $viewcount_all;?></li>
			<li><a href="<?php echo BLOG_URL; ?>rss.php"><img src="<?php echo CERTEMPLATE_URL; ?>/images/rss.gif" alt="订阅Rss"/></a></li>
	</ul>
<?php }?>
<?php
//blog：置顶
function topflg($istop){
	global $log_cache_sort; 
	$topflg = $istop == 'y' ? "<img src=\"".CERTEMPLATE_URL."/images/import.gif\" align=\"absmiddle\"  title=\"置顶日志\" /> " : '';
	echo $topflg;
}
?>
<?php
//blog：编辑
function editflg($logid,$author){
	$editflg = ROLE == 'admin' || $author == UID ? '<a href="'.'./admin/write_log.php?action=edit&gid='.$logid.'">编辑</a>' : '';
	echo $editflg;
}
?>
<?php 
//blog：分类
function blog_sort($sort, $blogid){
	global $log_cache_sort; ?>
	<?php if($log_cache_sort[$blogid]): ?>
	[<a href="./?sort=<?php echo $sort; ?>"><?php echo $log_cache_sort[$blogid]; ?></a>]
	<?php endif;?>
<?php }?>
<?php
//blog：文件附件
function blog_att($blogid){
	global $log_cache_atts; 
	$attachment = !empty($log_cache_atts[$blogid]) ? '文件附件：'.$log_cache_atts[$blogid] : '';
	echo $attachment;
}
?>
<?php
//blog：日志标签
function blog_tag($blogid){
	global $log_cache_tags; 
	if (!empty($log_cache_tags[$blogid]))
	{
		$tag = '标签:';
		foreach ($log_cache_tags[$blogid] as $value)
		{
			$tag .= "	<a href=\"./?tag=".$value['tagurl']."\">".$value['tagname'].'</a>';
		}
		echo $tag;
	}
}
?>
<?php
//blog：日志作者
function blog_author($uid){
	global $user_cache,$DB;
	$author = $user_cache[$uid]['name'];
	$mail = $user_cache[$uid]['mail'];
	$des = $user_cache[$uid]['des'];
	$title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
	echo "<a href=\"./?author=$uid\" $title>$author</a>";
}
?>
<?php
//blog：相邻日志
function neighbor_log(){
	global $prevLog,$nextLog; ?>
	<?php if($prevLog):?>
	&laquo; <a href="./?post=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
	<?php endif;?>
	<?php if($nextLog && $prevLog):?>
		|
	<?php endif;?>
	<?php if($nextLog):?>
		 <a href="./?post=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
	<?php endif;?>
<?php }?>
<?php
//blog：引用通告
function blog_trackback(){
	global $allow_tb,$tbscode,$logid,$tb; ?>
	<?php if($allow_tb == 'y'): ?>	
	<div class="comments-template">
	<h2 id="comments">引用:<a name="tb"></a></h2>
	<input type="text" style="width:350px" class="input" value="<?php echo BLOG_URL;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>"><a name="tb"></a></p>
	</div>
	<?php endif; ?>
	<ol id="commentlist">
	<?php foreach($tb as $key=>$value): ?>
		<li id="comment-<?php echo $value['cid'];?>">
		<cite>Trackback by <strong><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></strong> &#8212; <?php echo $value['date'];?></cite><br/>
		<a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a><br/>
		<?php echo $value['excerpt'];?>
		</li>
	<?php endforeach; ?>
	</ol>	
<?php }?>
<?php
//blog：博客评论列表
function blog_comments(){
	global $comments; ?>
	<h2 id="comments"><a name="comment"></a>评论</h2>
	
	<p></p>
	
	<ol id="commentlist">
	<?php
	foreach($comments as $key=>$value):
	$reply = $value['reply']?"<span style=\"color:#6C8C37;\"><b>博主回复</b>：{$value['reply']}</span>":'';
	?>
		<li id="comment-<?php echo $value['cid'];?>"><a name="<?php echo $value['cid'];?>"></a>
		<cite>Comment by <strong><?php echo $value['poster'];?></strong> 
		<?php if($value['mail']):?>
			<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
		<?php endif;?>
		<?php if($value['url']):?>
			<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
		<?php endif;?>
		&#8212; <?php echo $value['date'];?></cite>
		<br /><?php echo $value['content'];?><br /><div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply;?></div>
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
	</ol>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post(){
	global $logid,$ckname,$ckmail,$ckurl,$cheackimg,$allow_remark; ?>
	<?php if($allow_remark == 'y'): ?>
	<h2>发表评论</h2>
	<p></p>
	
	<form method="post"  name="commentform" action="./?action=addcom" id="commentform">
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
	</p>
	</fieldset>
	</form>
	<?php endif; ?>
<?php }?>