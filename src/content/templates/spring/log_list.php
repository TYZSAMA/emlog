﻿<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
<div class="post" id="post-<?php echo $value['logid'];?>">
<h2 class="posttitle">
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php topflg($value['top']); ?><?php echo $value['log_title']; ?></a>
</h2>

<p class="postmeta"> 
post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?> 
<?php blog_sort($value['sortid'], $value['logid']); ?> 
<?php editflg($value['logid'],$value['author']); ?><br />
<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</p>
<div class="postentry">
<?php echo $value['log_description'];?>
<p><?php blog_att($value['logid']); ?></p>
<p><?php blog_tag($value['logid']); ?></p>
</div>
</div>
<?php endforeach; ?>
<div class="browse"><?php echo $page_url;?></div>

</div>
<?php
include getViews('side');
include getViews('footer');
?>