<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
?>
<div id="content">
<div class="entry single">
<p><b>标签</b></p>
<p>所有标签：（标签字体越大其包含的日志越多）</p>
<p>
<?php foreach($tags as $key=>$value): ?>
<span style="font-size:<?php echo $value['fontsize'];?>px; height:30px;"><a href="./?action=taglog&tag=<?php echo $value['tagurl'];?>"><?php echo $value['tag'];?></a></span>&nbsp;
<?php endforeach; ?>
<?php echo $tagmsg;?>
</div>
<?php
?>
</div>
<?php
include getViews('side');
include getViews('footer');
?>