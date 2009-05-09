<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!--blogger-->
<?php function widget_blogger($title){ ?>
	<?php global $photo,$name,$blogger_des,$em_tpldir; ?>
	<div class="title"><h1><span onclick="showhidediv('blogger')"><?php echo $title; ?></span></h1></div>
	<ul id="blogger">
		<?php echo $photo; ?>
		<li><b><?php echo $name; ?></b></li>
		<li><span id="bloggerdes"><?php echo $blogger_des; ?></span>
		<?php if(ISLOGIN === true): ?>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
		<img src="<?php echo $em_tpldir; ?>images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
		<li id='modbdes' style="display:none;">
		<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:160px;height:60px;"><?php echo $blogger_des; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./admin/blogger.php?action=update&flg=1','bdes','bloggerdes');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消l</a>
		<?php endif; ?>
		</li>
	</ul>
<?php }?>
<!--日历-->
<?php function widget_calendar($title){ ?>
	<?php global $calendar_url; ?>
	<div class="title"><h1><span onclick="showhidediv('calendar')"><?php echo $title; ?></span></h1></div>
	<ul id="calendar">
		<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
	</ul>
<?php }?>
<!--标签-->
<?php function widget_tag($title){ ?>
	<?php global $tag_cache; ?>
	<div class="title"><h1><span onclick="showhidediv('tags')"><?php echo $title; ?></span></h1></div>
	<ul id="tags">
		<?php foreach($tag_cache as $value): ?>
		<span style="font-size:<?php echo $value['fontsize']; ?>pt; height:30px;">
		<a href="index.php?tag=<?php echo $value['tagurl']; ?>" title="<?php echo $value['usenum']; ?> 篇日志"><?php echo $value['tagname']; ?></a></span> 
		<?php endforeach; ?>
	</ul>
<?php }?>
<!--分类-->
<?php function widget_sort($title){ ?>
	<?php global $sort_cache,$em_tpldir; ?>
	<div class="title"><h1><span onclick="showhidediv('sort')"><?php echo $title; ?></span></h1></div>
	<ul id="sort">
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="./index.php?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="./rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo $em_tpldir; ?>images/icon_rss.gif" alt="订阅该分类"/></a>
	</li>
	<?php endforeach; ?>
	</ul>
<?php }?>
<!--twitter-->
<?php function widget_twitter($title){ ?>
	<?php global $tw_cache,$index_twnum,$localdate,$em_tpldir; ?>
	<?php if($index_twnum>0): ?>
	<div class="title"><h1><span onclick="showhidediv('twitter')"><?php echo $title; ?></span></h1></div>
	<ul id="twitter">
		<?php
			if(isset($tw_cache) && is_array($tw_cache)):
			$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
			foreach (array_slice($tw_cache,0,$index_twnum) as $value):
			$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
			$value['date'] = smartyDate($localdate,$value['date']);
		?>
		<li><?php echo $value['content']; ?> <?php echo $delbt; ?><br><span><?php echo $value['date']; ?></span></li>
		<?php endforeach;?>
		<?php echo $morebt;?>
		<?php endif;?>
	</ul>
	<?php if(ISLOGIN === true): ?>
	<ul>
	<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
		<li id='addtw' style="display: none;">
		<textarea name="tw" id="tw" style="overflow-y: hidden;width:170px;height:70px;" class="input"></textarea>
		<center>
		<a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
		</center>
		</li>
	</ul>
	<?php endif;?>
	<?php endif;?>
<?php } ?>
<!--音乐-->
<?php function widget_music($title){ ?>
	<?php global $musicdes,$em_tpldir,$musicurl,$autoplay; ?>
	<div class="title"><h1><span onclick="showhidediv('blogmusic')"><?php echo $title; ?></span></h1></div>
	<ul id="blogmusic">
	<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="<?php echo $em_tpldir; ?>images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="180" height="20"><param name="movie" value="<?php echo $em_tpldir; ?>images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" /></object></li>
	</ul>
<?php }?>
<!--最新评论-->
<?php function widget_newcomm($title){ ?>
	<?php global $com_cache,$em_tpldir; ?>
	<div class="title"><h1><span onclick="showhidediv('newcomment')"><?php echo $title; ?></span></h1></div>
	<ul id="newcomment">
		<?php foreach($com_cache as $value): ?>
		<li id="comment"><?php echo $value['name']; ?> 
		<?php if($value['reply']): ?>
		<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
		<img src="<?php echo $em_tpldir; ?>images/reply.gif" align="absmiddle"/>
		</a>
		<?php endif;?>
		<br /><a href="<?php echo $value['url']; ?>"><?php echo $value['content']; ?></a></li>
		<?php endforeach; ?>
	</ul>
<?php }?>
<!--最新日志-->
<?php function widget_newlog($title){ ?>
	<?php global $newLogs_cache; ?>
	<div class="title"><h1><span onclick="showhidediv('newlog')"><?php echo $title; ?></span></h1></div>
	<ul id="newlog">
	<?php foreach($newLogs_cache as $value): ?>
	<li><a href="index.php?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
<?php }?>
<!--随机日志-->
<?php function widget_random_log($title){ ?>
	<?php 
	global $index_randlognum, $emBlog;
	$randLogs = $emBlog->getRandLog($index_randlognum);
	?>
	<div class="title"><h1><span onclick="showhidediv('randlog')"><?php echo $title; ?></span></h1></div>
	<ul id="randlog">
	<?php foreach($randLogs as $value): ?>
	<li><a href="index.php?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
<?php }?>
<!--归档-->
<?php function widget_archive($title){ ?>
	<?php global $dang_cache; ?>
	<div class="title"><h1><span onclick="showhidediv('archives')"><?php echo $title; ?></span></h1></div>
	<ul id="archives">
		<?php foreach($dang_cache as $value): ?>
		<li><a href="<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
		<?php endforeach; ?>
	</ul>
<?php } ?>
<!--自定义-->
<?php function widget_custom_text($title, $content, $id){ ?>
	<div class="title"><h1><span onclick="showhidediv('<?php echo $id; ?>')"><?php echo $title; ?></span></h1></div>
	<ul id="<?php echo $id; ?>">
	<li><?php echo $content; ?></li>
	</ul>
<?php } ?>
<!--链接-->
<?php function widget_link($title){ ?>
	<?php global $link_cache; ?>
	<div class="title"><h1><span onclick="showhidediv('frlink')"><?php echo $title; ?></span></h1></div>
	<ul id="frlink">
		<?php foreach($link_cache as $value): ?>     	
		<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
		<?php endforeach; ?>
	</ul>
<?php }?>
<!--信息-->
<?php function widget_bloginfo($title){ ?>
	<?php global $sta_cache; ?>
	<div class="title"><h1><span onclick="showhidediv('bloginfo')"><?php echo $title; ?></span></h1></div>
	<ul id="bloginfo">
		<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
		<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
		<li>今日访问：<?php echo $sta_cache['day_view_count']; ?></li>
		<li>总访问量：<?php echo $sta_cache['view_count']; ?></li>
	</ul>
<?php }?>