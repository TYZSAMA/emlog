<?php
/**
 * 标签管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');
require_once('../model/C_tag.php');

$emTag = new emTag($DB);

if($action == '')
{
	$tags = $emTag->getTag();
	include getViews('header');
	require_once(getViews('tag'));
	include getViews('footer');
	cleanPage();
}

if ($action== "mod_tag")
{
	$tagId = isset($_GET['tid']) ? intval($_GET['tid']) : '';
	$tag = $emTag->getOneTag($tagId);
	extract($tag);
	include getViews('header');
	require_once(getViews('tagedit'));
	include getViews('footer');cleanPage();
}

//标签修改
if($action=='update_tag')
{
	$tagName = isset($_POST['tagname']) ? addslashes($_POST['tagname']) : '';
	$tagId = isset($_POST['tid']) ? intval($_POST['tid']) : '';
	$emTag->updateTagName($tid, $tagName);
	$CACHE->mc_logtags('log_tags');
	$CACHE->mc_tags('tags');
	formMsg('标签修改成功','./tag.php',1);
}

//批量删除标签
if($action== 'dell_all_tag')
{
	$tags = isset($_POST['tag']) ? $_POST['tag'] : '';
	if(!$tags)
	{
		formMsg('请选择要删除的标签','javascript:history.go(-1);',0);
	}
	foreach($tags as $key=>$value)
	{
		$emTag->deleteTag($key);
	}
	$CACHE->mc_logtags('log_tags');
	$CACHE->mc_tags('tags');
	formMsg('标签删除成功','./tag.php',1);
}

?>
