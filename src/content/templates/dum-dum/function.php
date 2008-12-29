<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!--blogger-->
<?php function widget_blogger($title){ ?>
	<?php global $photo,$name,$blogger_des,$em_tpldir; ?>
	<div class="box1">
		<div class="box1text">
		<ul>
		<li><h2><?php echo $title; ?></h2>
		<li style="text-align:center;"><?php echo $photo; ?></li>
		<li style="text-align:center;"><b><?php echo $name; ?></b></li>
			<li style="text-align:center;"><span id="bloggerdes"><?php echo $blogger_des; ?></span>
			<?php if(ISLOGIN === true): ?>
			<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
			<img src="<?php echo $em_tpldir; ?>images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
			<li id='modbdes' style="display:none;">
			<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:190px;height:60px;"><?php echo $blogger_des; ?></textarea>
			<br />
			<a href="javascript:void(0);" onclick="postinfo('./admin/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
			<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
			<?php endif; ?>
			</li>
		</ul>
		</div>
	</div>
<?php }?>
<!--日历-->
<?php function widget_calendar($title){ ?>
	<?php global $calendar_url; ?>
	<div class="box2">
		<div class="box2text">
		<ul>
			<li><h2><?php echo $title; ?></h2>
				<div id="calendar">
				</div>
			</li>
		</ul>
		</div> <!-- BOX2 TEXT -->
	</div> 
	<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
<?php }?>
<!--标签-->
<?php function widget_tag($title){ ?>
	<?php global $tag_cache; ?>
	<div class="box3">
		<div class="box3text">
		<ul>
		<li><h2><?php echo $title; ?></h2>
		<?php foreach($tag_cache as $value): ?>
			<a style="font-size:<?php echo $value['fontsize']; ?>pt; height:30px;" href="index.php?tag=<?php echo $value['tagurl']; ?>" title="<?php echo $value['usenum']; ?> 篇日志"><?php echo $value['tagname']; ?></a>
		<?php endforeach; ?>			
		</ul>
		</div> <!-- BOX3 TEXT -->
	</div> <!-- BOX3 -->
<?php }?>
<!--分类-->
<?php function widget_sort($title){ ?>
	<?php global $sort_cache,$em_tpldir; ?>
	<div class="box3">
		<div class="box3text">
		<ul>
		<li><h2><?php echo $title; ?></h2>
		<?php foreach($sort_cache as $value): ?>
		<li>
		<a href="./index.php?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
		<a href="./rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo $em_tpldir; ?>images/icon_rss.gif" alt="订阅该分类"/></a>
		</li>
		<?php endforeach; ?>			
		</ul>
		</div> <!-- BOX3 TEXT -->
	</div> <!-- BOX3 -->
<?php }?>
<!--twitter-->
<?php function widget_twitter($title){ ?>
	<?php global $tw_cache,$index_twnum,$localdate,$em_tpldir; ?>
	<div class="box2">
		<div class="box2text">
		<ul>
			<li><h2><?php echo $title; ?></h2>
			<ul id="twitter">
			<?php
			if(isset($tw_cache) && is_array($tw_cache)):
				$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
				foreach (array_slice($tw_cache,0,$index_twnum) as $value):
					$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
					$value['date'] = smartyDate($localdate,$value['date']);
					$value['content'] = str_replace("[wap]", " <img align=\"absmiddle\" src=\"{$em_tpldir}images/wap.gif\" alt=\"手机wap发布\"/>", $value['content']);
					?>
					<li> <?php echo $value['content']; ?> <?php echo $delbt; ?><br><span><?php echo $value['date']; ?></span></li>
				<?php endforeach;?>
				<?php echo $morebt;?>
			<?php endif;?>
			</ul>
			<?php if(ISLOGIN === true): ?>
				<ul>
				<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
				<li id='addtw' style="display: none;">
				<textarea name="tw" id="tw" style="overflow-y: hidden;width:180px;height:70px;" class="input"></textarea>
				<a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
				<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
				</li>
				</ul>
			<?php endif;?>
			</li>
		</ul>
		</div> <!-- BOX2 TEXT -->
	</div> 
<?php } ?>
<!--音乐-->
<?php function widget_music($title){ ?>
	<?php global $musicdes,$em_tpldir,$musicurl,$autoplay; ?>
	<div class="box1">
		<div class="box1text">
		<ul>
		<li><h2><?php echo $title; ?></h2>
		<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="<?php echo $em_tpldir; ?>images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="180" height="20"><param name="movie" value="<?php echo $em_tpldir; ?>images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" /></object>
		</ul>
		</div> <!-- BOX1 TEXT -->
	</div> <!-- BOX1 -->
<?php }?>
<!--最新评论-->
<?php function widget_newcomm($title){ ?>
	<?php global $com_cache,$em_tpldir; ?>
	<div class="box3">
		<div class="box3text">
		<ul>
		<li><h2><?php echo $title; ?></h2>
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
		</div> <!-- BOX3 TEXT -->
	</div> <!-- BOX3 -->
<?php }?>
<!--最新日志-->
<?php function widget_newlog($title){ ?>
	<?php global $newLogs_cache; ?>
	<div class="box3">
		<div class="box3text">
		<ul>
		<li><h2><?php echo $title; ?></h2>
		<?php foreach($newLogs_cache as $value): ?>
		<li><a href="index.php?action=showlog&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
		<?php endforeach; ?>			
		</ul>
		</div> <!-- BOX3 TEXT -->
	</div> <!-- BOX3 -->
<?php }?>
<!--随机日志-->
<?php function widget_random_log($title){ ?>
	<?php 
	global $index_randlognum, $emBlog;
	$randLogs = $emBlog->getRandLog($index_randlognum);
	?>
	<div class="box3">
		<div class="box3text">
		<ul>
		<li><h2><?php echo $title; ?></h2>
		<?php foreach($randLogs as $value): ?>
		<li><a href="index.php?action=showlog&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
		<?php endforeach; ?>		
		</ul>
		</div> <!-- BOX3 TEXT -->
	</div> <!-- BOX3 -->
<?php }?>
<!--归档-->
<?php function widget_archive($title){ ?>
	<?php global $dang_cache; ?>
	<div class="box2">
		<div class="box2text">
		<ul>
			<li><h2><?php echo $title; ?></h2>
			<?php foreach($dang_cache as $value): ?>
			<li><a href="<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
			<?php endforeach; ?>
		</ul>
		</div> <!-- BOX2 TEXT -->
	</div>
<?php } ?>
<!--自定义-->
<?php function widget_custom_text($title, $content, $id){ ?>
	<div class="box2">
		<div class="box2text">
		<ul>
		<li><h2><?php echo $title; ?></h2>
		<li><?php echo $content; ?></li>	
		</ul>
		</div>
	</div>
<?php } ?>
<!--搜索-->
<?php 
function widget_search($title){ 
global $em_tpldir;
?>
	<form name="keyform" method="get" action="index.php" id="searchform">
	<div>
   	<input name="keyword"  type="text" value="" id="s" /><input type="image" src="<?php echo $em_tpldir; ?>images/search-button.jpg" id="searchsubmit" value="Search" />
	</div>
	</form>
<?php } ?>
<!--链接-->
<?php function widget_link($title){ ?>
	<?php global $link_cache; ?>
	<div class="box1">
		<div class="box1text">
		<ul>
			<li><h2><?php echo $title; ?></h2>
			<?php foreach($link_cache as $value): ?>     	
			<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
			<?php endforeach; ?>
		</ul>
		</div> <!-- BOX1 TEXT -->
	</div> <!-- BOX1 -->
<?php }?>
<!--信息-->
<?php function widget_bloginfo($title){ ?>
	<?php global $sta_cache,$em_tpldir; ?>
	<div class="box3">
		<div class="box3text">
		<ul>
			<li><h2><?php echo $title; ?></h2>
			<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
			<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
			<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
			<li>今日访问：<?php echo $sta_cache['day_view_count']; ?></li>
			<li>总访问量：<?php echo $sta_cache['view_count']; ?></li>
		</ul>
		</div> <!-- BOX3 TEXT -->
	</div> <!-- BOX3 -->
<?php }?>