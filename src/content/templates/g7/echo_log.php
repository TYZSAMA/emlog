<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="content">
		<div class="post">
		<h2>
		<?php topflg($top); ?><?php echo $log_title;?>
		<span class="sort"><?php blog_sort($sortid, $logid); ?></a></span>
		</h2>
		</div>
		<p class="postdate">Post by <?php blog_author($author); ?> on <?php echo date('Y-n-j G:i l', $date); ?><br /></p>
		<div class="mypost">
		<?php echo $log_content;?>
		<p><?php blog_att($logid); ?></p>
		<p><?php blog_tag($logid); ?></p>
		<?php doAction('log_related'); ?>
		<p><?php neighbor_log(); ?></p>
		</div>
		<?php blog_trackback(); ?>	
</div>
<div id="comments"><div class="content_c">
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>

</div></div>
</div>
<?php
include getViews('side');
include getViews('footer');
?>