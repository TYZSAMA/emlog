<?php
/**
 * 插件管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.0
 * $Id$
 */

require_once('globals.php');
require_once(EMLOG_ROOT.'/model/C_plugin.php');

if($action == '')
{
	$emPlugin = new emPlugin($DB);

	$plugins = $emPlugin->getPlugins();
	
	include getViews('header');
	require_once(getViews('plugin'));
	include getViews('footer');
	cleanPage();
}
//激活
if ($action== 'active')
{
	$plugin = isset($_POST['plugin']) ? $_POST['plugin'] : '';
	$id = isset($_POST['id']) ? $_POST['id'] : '';

	$emPlugin = new emPlugin($DB, $plugin);
	$emPlugin->active_plugin($active_plugins);
	$CACHE->mc_options();

	echo "<img src=\"./views/".ADMIN_TPL."/images/plugin_{$action}.gif\" onclick=\"do_plugin('$plugin', 'inactive', '$id');\" title=\"已激活\" align=\"absmiddle\">";
}
//禁用
if($action== 'inactive')
{
	$plugin = isset($_POST['plugin']) ? $_POST['plugin'] : '';
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	
	$emPlugin = new emPlugin($DB, $plugin);
	$emPlugin->inactive_plugin($active_plugins);
	$CACHE->mc_options();
	
	echo "<img src=\"./views/".ADMIN_TPL."/images/plugin_{$action}.gif\" onclick=\"do_plugin('$plugin', 'active', '$id');\" title=\"未激活\" align=\"absmiddle\">";
}

?>
