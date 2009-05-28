<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
	<div class="post">
			<h2><?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
			<div class="info">
				<span class="date">post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?> 
				<?php blog_sort($value['sortid'], $value['logid']); ?> 
				<?php editflg($value['logid'],$value['author']); ?>
				</span>
			</div>
			<div class="content">
				<p><?php echo $value['log_description']; ?></p>
				<p><?php blog_att($value['logid']); ?></p>
				<p><?php blog_tag($value['logid']); ?></p>
				<p>
				<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
				<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
				<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
				</p>
			</div>
		</div>

<div class="fixed"></div>
<?php endforeach; ?>
<div id="pagenavi">
<?php echo $page_url;?>
</div>
<div style="clear:both">&nbsp;</div>
<?php 
include getViews('side');
include getViews('footer'); 
?>