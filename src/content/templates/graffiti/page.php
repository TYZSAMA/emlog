<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>
<div class="logcontent2">
	<p id="tit"><b><?php echo $log_title; ?></b></p>
	<div>
		<?php echo $log_content; ?>
		<p><?php blog_att($logid); ?></p>
	</div>
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
</div>
<?php include getViews('footer'); ?>