<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="sidebar">
<div id="search">
<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>">
<div>
<input type="text" name="keyword" id="s" />
<input type="submit" id="go" value="" onclick="return keyw()"/>
</div>
</form>
</div>
<ul>
<?php 
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
<a href="<?php echo BLOG_URL; ?>rss.php"><img src="<?php echo CERTEMPLATE_URL; ?>/images/rss.gif" alt="订阅Rss"/></a>
</div>
