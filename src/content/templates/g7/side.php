<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="sidebar_tag">
<?php foreach($tag_cache as $value): ?>
<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;"><a href="<?php echo BLOG_URL; ?>?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
<?php endforeach; ?>
</div>

<div id="sidebar">
<div id="sidebar_1">
<ul>
<?php 
require_once (getViews('function'));
$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
foreach ($widgets as $val)
{
	$widget_title = @unserialize($options_cache['widget_title']);
	$custom_widget = @unserialize($options_cache['custom_widget']);
	if(strpos($val, 'custom_wg_') === 0)
	{
		$callback = 'widget_custom_text';
		if(function_exists($callback))
		{
			call_user_func($callback, htmlspecialchars($custom_widget[$val]['title']), $custom_widget[$val]['content'], $val);
		}
	}else{
		$callback = 'widget_'.$val;
		if(function_exists($callback))
		{
			preg_match("/^.*\s\((.*)\)/", $widget_title[$val], $matchs);
			$wgTitle = isset($matchs[1]) ? $matchs[1] : $widget_title[$val];
			call_user_func($callback, htmlspecialchars($wgTitle));
		}
	}
}
?>
</ul>
</div>

<div id="sidebar_2">
<ul>
<?php 
require_once (getViews('function'));
$widgets = !empty($options_cache['widgets2']) ? unserialize($options_cache['widgets2']) : array();
foreach ($widgets as $val)
{
	$widget_title = @unserialize($options_cache['widget_title']);
	$custom_widget = @unserialize($options_cache['custom_widget']);
	if(strpos($val, 'custom_wg_') === 0)
	{
		$callback = 'widget_custom_text';
		if(function_exists($callback))
		{
			call_user_func($callback, htmlspecialchars($custom_widget[$val]['title']), $custom_widget[$val]['content'], $val);
		}
	}else{
		$callback = 'widget_'.$val;
		if(function_exists($callback))
		{
			preg_match("/^.*\s\((.*)\)/", $widget_title[$val], $matchs);
			$wgTitle = isset($matchs[1]) ? $matchs[1] : $widget_title[$val];
			call_user_func($callback, htmlspecialchars($wgTitle));
		}
	}
}
?>
<?php if(ISLOGIN === false):?> 
<li class="random"><h2><a href="<?php echo BLOG_URL; ?>admin/">登录</a></h2>
<?php else:?>
<li class="random"><h2 onclick="showhidediv('loginfm')" >管理</h2>
<ul id="loginfm">
	<li><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
	<li><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
	<li><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
</ul>
<?php endif; ?>
<p><a href="<?php echo BLOG_URL; ?>rss.php"><img src="<?php echo CERTEMPLATE_URL; ?>/images/rss.png" alt="订阅Rss"/></a></p>
</ul>
</div>

</div> 
</div> 
</ul>
</div>			
