<?php 
if(!defined('ADMIN_ROOT')) {exit('error!');}
$allcom = $hidecom + $comnum;
?>
<div id="admindex">
<div id="admindex_main">
你有<span class=care2><b><?php echo $lognum; ?></b></span>篇日志，<span class=care2><b><?php echo $tbnum; ?></b></span>条引用通告，<span class=care2><b><?php echo $allcom; ?></b></span>条评论<?php if($ischkcomment == 'y' || $hidecom != 0): ?>，其中有<b><a href="./comment.php?hide=y"><?php echo $hidecom; ?></a></b>条评论等待审核<?php endif; ?>。
</div>
<div class="clear"></div>
<div id="admindex_servinfo">
<h3>服务器信息</h3>
<ul>
	<li>服务器环境: <?php echo $serverapp; ?></li>
	<li>PHP版本: <?php echo $php_ver; ?></li>
	<li>MySQL版本: <?php echo $mysql_ver; ?></li>
	<li>服务器时间: <?php echo $serverdate; ?></li>
	<li>GD图形处理库: <?php echo $gd_ver; ?></li>
	<li>服务器允许上传最大文件: <?php echo $uploadfile_maxsize; ?></li>
	<li><a href="configure.php?action=phpinfo">更多信息&raquo;</a></li>
</ul>
</div>
<div id="admindex_msg">
<h3>官方消息</h3>
<ul>
	<li><a href="configure.php?action=phpinfo">更多信息师傅是大方说发生</a></li>
	<li><a href="configure.php?action=phpinfo">更多信息范德萨发生时地方撒</a></li>
	<li><a href="configure.php?action=phpinfo">更多信发生飞洒发生</a></li>
	<li><a href="configure.php?action=phpinfo">往往往往往往往往</a></li>
	<li><a href="configure.php?action=phpinfo">发送方师傅师傅是大方萨法</a></li>
</ul>
</div>
<div class="clear"></div>
</div>