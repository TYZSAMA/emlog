<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./configure.php">基本设置</a>
<a class="navi2" href="./style.php">后台风格</a>
<a class="navi4" href="./permalink.php">固定链接</a>
<a class="navi4" href="./blogger.php">个人资料</a>
<?php if(isset($_GET['activated'])):?><span class="actived">设置保存成功</span><?php endif;?>
</div>
<form action="configure.php?action=mod_config" method="post" name="input" id="input">
<div id="admin_style">
	<div><img src="http://localhost/blogs/wordpress/wp-content/themes/twentyten/images/headers/cherryblossoms-thumbnail.jpg" alt="樱花" title="樱花" /></div>
    <div><img src="http://localhost/blogs/wordpress/wp-content/themes/twentyten/images/headers/cherryblossoms-thumbnail.jpg" alt="樱花" title="樱花" /></div>
    <div><img src="http://localhost/blogs/wordpress/wp-content/themes/twentyten/images/headers/cherryblossoms-thumbnail.jpg" alt="樱花" title="樱花" /></div>
    <div><img src="http://localhost/blogs/wordpress/wp-content/themes/twentyten/images/headers/cherryblossoms-thumbnail.jpg" alt="樱花" title="樱花" /></div>
    <div><img src="http://localhost/blogs/wordpress/wp-content/themes/twentyten/images/headers/cherryblossoms-thumbnail.jpg" alt="樱花" title="樱花" /></div>
</div>
</form>