<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php
//widget：blogger
function widget_blogger($title){
	global $user_cache; 
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<div id="categories" class="dbx-box">
	<h3 class="dbx-handle" onclick="showhidediv('blogger')"><?php echo $title; ?></h3>
	<div class="dbx-content" id="blogger">
	<ul>
	<p align="center"><?php echo $user_cache[1]['photo']; ?></p>
		<li><span id="bloggerdes"><?php echo $user_cache[1]['des']; ?></span>
		<?php if(ROLE == 'admin'): ?>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
		<li id='modbdes' style="display:none;">
		<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:150px;height:50px;"><?php echo $user_cache[1]['des']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/blogger.php?action=update&flg=1','bdes','bloggerdes');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
		<?php endif; ?>
		</li>
	 </ul>
	</div>
	</div>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){
	global $calendar_url; ?>
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('calendar')"><?php echo $title; ?></h3>
        <div class="dbx-content">
          <ul>
            <div id="calendar"></div>
          </ul>
        </div>
      </div>
	  <script>sendinfo('<?php echo $calendar_url;?>','calendar');</script>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $tag_cache; ?>
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('tags')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="tags">
          <ul>
			<?php foreach($tag_cache as $value): ?>
			<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;"><a href="<?php echo BLOG_URL; ?>?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $sort_cache; ?>
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('sort')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="sort">
          <ul>
			<?php foreach($sort_cache as $value): ?>
			<li>
			<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
			<a href="<?php echo BLOG_URL; ?>rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo CERTEMPLATE_URL; ?>/images/icon_rss.gif" alt="订阅该分类"/></a>
			</li>
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php }?>
<?php
//widget：twitter
function widget_twitter($title){
	global $tw_cache,$index_twnum,$localdate; ?>
	<?php if($index_twnum>0): ?>
	<div id="meta" class="dbx-box">
	<h3 onclick="showhidediv('twitter')" class="dbx-handle"><?php echo $title; ?></h3>
	<div class="dbx-content">
	<ul id="twitter">
	<?php  if(isset($tw_cache) && is_array($tw_cache)):
	$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('".BLOG_URL."twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
	foreach (array_slice($tw_cache,0,$index_twnum) as $value):
		$delbt = ROLE == 'admin'?"<a href=\"javascript:void(0);\" onclick=\"isdel('".BLOG_URL."','{$value['id']}','twitter')\">删除</a>":'';
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
	<textarea name="tw" id="tw" style="overflow-y: hidden;width:160px;height:70px;" class="input"></textarea>
	<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>twitter.php?action=add','tw','twitter');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
	</li>
	</ul>
	<?php endif; ?>
	</div>
	</div>
	<?php endif; ?>
<?php } ?>
<?php 
//widget：音乐
function widget_music($title){
	global $musicdes,$musicurl,$autoplay; ?>
		  <div id="meta" class="dbx-box">
			<h3 class="dbx-handle" onclick="showhidediv('music')"><?php echo $title; ?></h3>
			<div class="dbx-content" id="music">
			  <ul>
	 <?php echo $musicdes;?><object type="application/x-shockwave-flash" data="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" width="180" height="20"><param name="movie" value="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" /></object>
	</p>
			  </ul>
			</div>
		  </div>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $com_cache; ?>
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('comm')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="comm">
          <ul>	
		  	<?php 
			foreach($com_cache as $value): 
			$value['url'] = BLOG_URL.$value['url'];
			?>
			<li><?php echo $value['name'];?>
			<?php if($value['reply']): ?>
				<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
				<img src="<?php echo CERTEMPLATE_URL; ?>/images/comments.gif" align="absmiddle"/>
				</a>
			<?php endif;?>
			<br /><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php }?>
<?php
//widget：最新日志
function widget_newlog($title){
	global $newLogs_cache; ?>
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('newlog')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="newlog">
          <ul>
			<?php foreach($newLogs_cache as $value): ?>
			<li><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
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
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('randlog')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="randlog">
          <ul>
			<?php foreach($randLogs as $value): ?>
			<li><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php }?>
<?php
//widget：归档
function widget_archive($title){
	global $dang_cache; ?>
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('dang')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="dang">
          <ul>
			<?php foreach($dang_cache as $value): ?>
					<li><a href="<?php echo BLOG_URL; ?><?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
			<?php endforeach; ?>	
          </ul>
        </div>
      </div>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content, $id){ ?>
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('<?php echo $id; ?>')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="<?php echo $id; ?>">
          <ul>
			<p><?php echo $content; ?></p>
          </ul>
        </div>
      </div>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $link_cache; ?>
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('blogroll')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="blogroll">
          <ul>
			<?php foreach($link_cache as $value): ?>     	
					<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php }?>
<?php
//widget：博客信息
function widget_bloginfo($title){
	global $sta_cache,$viewcount_day,$viewcount_all; ?>
      <div id="meta" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('qita')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="qita">
          <ul>
			<li>日志数量：<?php echo $sta_cache['lognum'];?></li>
			<li>评论数量：<?php echo $sta_cache['comnum'];?></li>
			<li>引用数量：<?php echo $sta_cache['tbnum'];?></li>
			<li>今日访问：<?php echo $viewcount_day;?></li>
			<li>总访问量：<?php echo $viewcount_all;?></li>
          </ul>
        </div>
      </div>
<?php }?>