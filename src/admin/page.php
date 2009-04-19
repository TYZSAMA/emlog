<?php
/**
 * 页面管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id: comment.php 1048 2009-04-12 03:46:42Z emloog $
 */

require_once('globals.php');
require_once(EMLOG_ROOT.'/model/C_blog.php');

$navibar = unserialize($navibar);

//加载页面管理页面
if($action == '')
{
	$emPage = new emBlog($DB);
	$pages = $emPage->getLog('', '', 1, 0, 'admin', 'page');

	include getViews('header');
	require_once(getViews('admin_page'));
	include getViews('footer');
	cleanPage();
}

//显示新建页面表单
if ($action == 'new')
{
	$localtime = time() - ($timezone - 8) * 3600;
	$postDate = date('Y-m-d H:i:s', $localtime);

	include getViews('header');
	require_once(getViews('add_page'));
	include getViews('footer');
	cleanPage();
}
//显示编辑页面表单
if ($action == 'mod')
{
	$emPage = new emBlog($DB);

	$pageId = isset($_GET['id']) ? intval($_GET['id']) : '';
	$pageData = $emPage->getOneLog($pageId);
	extract($pageData);

	$pageUrl = $navibar[$pageId]['url'];

	if($allow_remark == 'y')
	{
		$ex="checked=\"checked\"";
		$ex2="";
	}else{
		$ex="";
		$ex2="checked=\"checked\"";
	}
	if($navibar[$pageId]['is_blank']=='y'){
		$ex3="checked=\"checked\"";
		$ex4="";
	}else{
		$ex3="";
		$ex4="checked=\"checked\"";
	}

	include getViews('header');
	require_once(getViews('edit_page'));
	include getViews('footer');
	cleanPage();
}
//保存页面
if ($action == 'add' || $action == 'edit' || $action == 'autosave')
{
	$emPage = new emBlog($DB);
	
	$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
	$pageUrl = isset($_POST['url']) ? addslashes(trim($_POST['url'])) : '';
	$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
	$pageId = isset($_POST['as_logid']) ? intval(trim($_POST['as_logid'])) : -1;//如被自动保存为草稿则有blog id号
	$allow_remark = isset($_POST['allow_remark']) ? addslashes($_POST['allow_remark']) : '';
	$is_blank = isset($_POST['is_blank']) ? addslashes($_POST['is_blank']) : '';
	$ishide = isset($_POST['ishide']) && empty($_POST['ishide']) ? 'n' : addslashes($_POST['ishide']);
	
	$postTime = $emPage->postDate($timezone);
	
	$logData = array(
	'title'=>$title,
	'content'=>$content,
	'excerpt'=>'',
	'date'=>$postTime,
	'allow_remark'=>$allow_remark,
	'hide'=>$ishide,
	'type'=>'page'
	);

	if($pageId > 0)//自动保存后,添加变为更新
	{
		$emPage->updateLog($logData, $pageId);
		$navibar[$pageId] = array('title' => $title, 'url' => $pageUrl, 'is_blank' => $is_blank);
		$navibar = serialize($navibar);
		$DB->query("UPDATE ".DB_PREFIX."options SET option_value='$navibar' where option_name='navibar'");
	}else{
		$pageId = $emPage->addlog($logData);
		$navibar[$pageId] = array('title' => $title, 'url' => $pageUrl, 'is_blank' => $is_blank);
		$navibar = serialize($navibar);
		$DB->query("UPDATE ".DB_PREFIX."options SET option_value='$navibar' where option_name='navibar'");
	}

	$CACHE->mc_logatts();
	$CACHE->mc_options();
	
	switch ($action)
	{
		case 'autosave':
			echo "autosave_gid:{$pageId}_df:0_";
			break;
		case 'add':
		case 'edit':
			$tbmsg = '';
			$ok_msg = $action == 'add' ? '页面发布成功！' : '页面保存成功！';
			$ok_url = 'page.php';
			formMsg($ok_msg,$ok_url, 1);
			break;
	}
}
//删除页面
if ($action == 'del')
{
	$emPage = new emBlog($DB);
	$pageId = isset($_GET['gid']) ? intval($_GET['gid']) : '';
	$emPage->deleteLog($pageId);

	unset($navibar[$pageId]);
	$navibar = serialize($navibar);
	$DB->query("UPDATE ".DB_PREFIX."options SET option_value='$navibar' where option_name='navibar'");
	
	$CACHE->mc_logatts();
	$CACHE->mc_options();

	header("Location: ./page.php?active_del=true");
}

?>