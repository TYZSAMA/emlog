<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div class="post">
<br />
<br />
<p>$search_info</p><br />
<div>
<!--
EOT;
foreach($slog as $key=>$value){
echo <<<EOT
-->
<p><a href="?action=showlog&gid=$value[gid]">$value[title]</a> <small>($value[date])</small></p>
<!--
EOT;
}echo <<<EOT
-->	
</div>
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