<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="content">
<div class="mypost">
	<p><b><?php echo $tag;?></b></p>
	<p><small>包含该标签的所有日志：</small></p>
<ul class="taglog">
<?php
foreach($taglogs as $key=>$value){
?>
	<li><a href="index.php?action=showlog&gid=<?php echo $value['gid'];?>"><?php echo $value['title'];?></a> <?php echo $value['date'];?></li>
<?php
}?>
	</ul>
</div>
<?php
?>
</div>
</div>
<?php
include getViews('side');
include getViews('footer');
?>