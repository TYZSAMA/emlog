<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
?>
<div class="content">
	<ul id="t">
		<li>标签： <b><?= $tag ?></b></li>
	</ul>
	<ul class="taglog">
<?php foreach($taglogs as $key=>$value){ ?>
	<li><a href="index.php?action=showlog&gid=<?= $value['gid'] ?>"><?= $value['title'] ?></a> <?= $value['date'] ?></li>
<?php } ?>
	</ul>
</div>
<?php include getViews('footer'); ?>