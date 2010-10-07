<?php
/**
 * 标签管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

$emTag = new emTag();

if($action == '')
{
	$tags = $emTag->getTag();
	include View::getView('header');
	require_once View::getView('tag');
	include View::getView('footer');
	View::output();
}

if ($action== "mod_tag")
{
	$tagId = isset($_GET['tid']) ? intval($_GET['tid']) : '';
	$tag = $emTag->getOneTag($tagId);
	extract($tag);
	include View::getView('header');
	require_once View::getView('tagedit');
	include View::getView('footer');View::output();
}

//标签修改
if($action=='update_tag')
{
	$tagName = isset($_POST['tagname']) ? addslashes($_POST['tagname']) : '';
	$tagId = isset($_POST['tid']) ? intval($_POST['tid']) : '';
	$emTag->updateTagName($tagId, $tagName);
	$CACHE->updateCache(array('tags', 'logtags'));
	header("Location: ./tag.php?active_edit=true");
}

//批量删除标签
if($action== 'dell_all_tag')
{
	$tags = isset($_POST['tag']) ? $_POST['tag'] : '';
	if(!$tags)
	{
		header("Location: ./tag.php?error_a=true");
		exit;
	}
	foreach($tags as $key=>$value)
	{
		$emTag->deleteTag($key);
	}
	$CACHE->updateCache(array('tags', 'logtags'));
	header("Location: ./tag.php?active_del=true");
}
