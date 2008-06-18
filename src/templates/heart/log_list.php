<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
foreach($logs as $value):
?>

<div class="logcontent">
<div id="t">
<?php echo $value['toplog']; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
</div>

<p id="date"><?php echo $value['post_time']; ?></p>
<div class="log_desc"><?php echo $value['log_description']; ?></div>
<p class="other"><?php echo $value['att_img']; ?></p>
<p class="other"><?php echo $value['attachment']; ?></p>
<p class="other"><?php echo $value['tag']; ?></p>

<div align="right">
<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
</div>
</div>
<?php endforeach; ?>

<div id="pageurl"><?php echo $page_url;?></div>
<?php include getViews('footer'); ?>