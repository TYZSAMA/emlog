<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
echo <<<EOT
-->
<div class="post">
<div class="content">
<h2><b>标签</b></h2>
<p><small>所有标签：（标签字体越大其包含的日志越多）</small></p>
<p>
<!--
EOT;
foreach($tags as $key=>$value){
echo <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="?action=taglog&tag=$value[tagurl]">$value[tag]</a></span>&nbsp;
<!--
EOT;
}echo <<<EOT
-->
$tagmsg
</p>
</div>
<!--
EOT;
echo <<<EOT
-->
</div>
</div>
</div>
EOT;
include getViews('footer');
?>