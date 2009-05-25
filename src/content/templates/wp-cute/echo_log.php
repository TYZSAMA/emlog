<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=post id=post-1>
<h2>
<b><?php echo $log_title;?></b>
<span class="sort"><?php blog_sort($sortid, $logid); ?></span>
</h2>
<div class="entry">
<p><?php echo $log_content;?></p>
<p><?php blog_att($logid); ?></p>
<p><?php blog_tag($logid); ?></p>
<p><?php neighbor_log(); ?></p>
</div></div>
<p>post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?></p>

<?php blog_trackback(); ?>
<?php blog_comments(); ?>
<?php if ($allow_remark == 'y'){blog_comments_post();}?>

<?php include getViews('footer'); ?>