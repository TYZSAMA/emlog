<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div class="post">
<br />
<br />
	<p>包含<b>$tag</b>标签的所有日志：</p><br />
<ul class="taglog">
<!--
EOT;
foreach($taglogs as $key=>$value){
echo <<<EOT
-->
	<p><a href="index.php?action=showlog&gid=$value[gid]">$value[title]</a> <small>$value[date]</small></p>
<!--
EOT;
}echo <<<EOT
-->
	</ul>
</div>
<!--
EOT;
echo <<<EOT
-->
</div>
</div>
EOT;
include getViews('side');
include getViews('footer');
?>
