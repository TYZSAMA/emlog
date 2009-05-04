<?php
/**
 * 前端页面加载主程序
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

require_once('common.php');

viewCount();

define('CURPAGE','index');

//当前模板目录
$em_tpldir = TEMPLATE_PATCH.$nonce_templet.'/';
if (!is_dir($em_tpldir))
{
	exit('Template Error: no template directory!');
}
$blogtitle = $blogname;
$calendar_url = isset($_GET['record']) ? 'calendar.php?record='.intval($_GET['record']) : 'calendar.php?' ;
$job = array('showlog','search','addcom','taglog','');
if (!in_array($action,$job))
{
	emMsg('error!','./index.php');
}
//日志列表
if (!isset($action) || empty($action))
{
	require_once(EMLOG_ROOT.'/model/C_blog.php');

	$emBlog = new emBlog($DB);

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$record = isset($_GET['record']) ? intval($_GET['record']) : '' ;
	$tag = isset($_GET['tag']) ? addslashes(strval(trim($_GET['tag']))) : '';
	$sortid = isset($_GET['sort']) ? intval($_GET['sort']) : '';
	$keyword = isset($_GET['keyword']) ? addslashes(trim($_GET['keyword'])) : '';

	$start_limit = ($page - 1) * $index_lognum;
	$pageurl= './index.php';

	if ($record)
	{
		$blogtitle = $record.' - '.$blogname;
		$sqlSegment = "and from_unixtime(date, '%Y%m%d') LIKE '%".$record."%' order by top desc ,date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= "?record=$record&page";
	} elseif ($tag) {
		require_once(EMLOG_ROOT.'/model/C_tag.php');
		$emTag = new emTag($DB);
		$blogtitle = stripslashes($tag).' - '.$blogname;
		$blogIdStr = $emTag->getTagByName($tag);
		if($blogIdStr === false)
		{
			emMsg('不存在该标签','./index.php');
		}
		$sqlSegment = "and gid IN ($blogIdStr) order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= '?tag='.urlencode($tag).'&page';
	} elseif($keyword) {
		$keyword = str_replace('%','\%',$keyword);
		$keyword = str_replace('_','\_',$keyword);
		if (strlen($keyword) > 30 || strlen($keyword) < 3)
		{
			emMsg('错误的关键字长度','./index.php');
		}
		$sqlSegment = "and title like '%{$keyword}%' order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= '?keyword='.urlencode($keyword).'&page';
	} elseif($sortid) {
		require_once(EMLOG_ROOT.'/model/C_sort.php');
		$emSort = new emSort($DB);
		$sortName = $sort_cache[$sortid]['sortname'];
		$blogtitle = $sortName.' - '.$blogname;
		$sqlSegment = "and sortid=$sortid order by date desc";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= "?sort=$sortid&page";
	} else {
		$sqlSegment ="ORDER BY top DESC ,date DESC";
		$lognum = $emBlog->getLogNum('n', $sqlSegment);
		$pageurl .= "?page";
	}
	$logs = $emBlog->getLogsForHome($sqlSegment, $page, $index_lognum);
	$page_url = pagination($lognum, $index_lognum, $page, $pageurl);

	include getViews('header');
	include getViews('log_list');
}
//显示日志、页面
if ($action == 'showlog')
{
	require_once(EMLOG_ROOT.'/model/C_blog.php');
	require_once(EMLOG_ROOT.'/model/C_comment.php');
	require_once(EMLOG_ROOT.'/model/C_trackback.php');
	include getViews('header');

	isset($_GET['gid']) ? $logid = intval($_GET['gid']) : emMsg('提交参数错误','./index.php');

	$emBlog = new emBlog($DB);
	$emComment = new emComment($DB);
	$emTrackback = new emTrackback($DB);

	$logData = $emBlog->getOneLogForHome($logid);
	if($logData === false)
	{
		emMsg('不存在该条目','./index.php');
	}
	extract($logData);
	if(!empty($password))
	{
		$postpwd = isset($_POST['logpwd']) ? addslashes(trim($_POST['logpwd'])) : '';
		$cookiepwd = isset($_COOKIE['em_logpwd_'.$logid]) ? addslashes(trim($_COOKIE['em_logpwd_'.$logid])) : '';
		$emBlog->AuthPassword($postpwd, $cookiepwd, $password, $logid);
	}
	$blogtitle = $log_title.' - '.$blogname;
	$log_author = $user_cache[$author]['name'];
	//comments
	$cheackimg = $comment_code == 'y' ? "<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\" /><input name=\"imgcode\"  type=\"text\" class=\"input\" size=\"5\">" : '';
	$ckname = isset($_COOKIE['commentposter']) ? htmlspecialchars(stripslashes($_COOKIE['commentposter'])) : '';
	$ckmail = isset($_COOKIE['postermail']) ? $_COOKIE['postermail'] : '';
	$ckurl = isset($_COOKIE['posterurl']) ? $_COOKIE['posterurl'] : '';
	$comments = $emComment->getComments(0, $logid, 'n');
	if ($type == 'blog')
	{
		//add viewcount
		$emBlog->updateViewCount($logid);
		//neighborlog
		$neighborLog = $emBlog->neighborLog($logid);
		extract($neighborLog);
		//trackback
		$tb = $emTrackback->getTrackbacks(null, $logid, 0);
		require_once getViews('echo_log');
	}elseif ($type == 'page'){
		include getViews('page');
	}
}
//添加评论
if ($action == 'addcom')
{
	require_once(EMLOG_ROOT.'/model/C_comment.php');

	$emComment = new emComment($DB);
	$comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
	$commail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
	$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
	$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
	$imgcode = strtoupper(trim(isset($_POST['imgcode']) ? $_POST['imgcode'] : ''));
	$gid = isset($_POST['gid']) ? intval($_POST['gid']) : -1;

	$ret = $emComment->addComment($comname, $comment, $commail, $comurl, $imgcode, $comment_code, $ischkcomment, $localdate, $gid);
	
	if($ret === 0)
	{
		$CACHE->mc_sta();
		$CACHE->mc_user();
		$CACHE->mc_comment();
		emMsg('评论发表成功!',"?action=showlog&gid=$gid#comment", true);
	}elseif ($ret === 1){
		$CACHE->mc_sta();
		$CACHE->mc_user();
		emMsg('评论发表成功!请等待管理员审核!',"?action=showlog&gid=$gid#comment");
	}
}

cleanPage(true);

?>
