<?php
/**
 * 评论管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');

//加载评论管理页面
if($action == '')
{
	$blogid = isset($_GET['gid']) ? $_GET['gid'] : null;

	if($blogid)
	{
		$andQuery = "where gid=$blogid";//查询指定日志评论
		$addUrl = "gid={$blogid}&";
	}else{
		$andQuery = '';
		$addUrl = '';
	}

	$page = intval(isset($_GET['page']) ? $_GET['page'] : 1);
	if (!empty($page))
	{
		$start_limit = ($page - 1) *15;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	$query1=$DB->query("SELECT cid FROM {$db_prefix}comment $andQuery");
	$num=$DB->num_rows($query1);

	$sql="SELECT * FROM {$db_prefix}comment $andQuery ORDER BY cid DESC LIMIT $start_limit, 15";
	$ret=$DB->query($sql);
	$comment = array();
	while($dh=$DB->fetch_array($ret))
	{
		$dh['comment'] = subString(htmlClean2($dh['comment']),0,30);
		$dh['date'] = date("Y-m-d H:i",$dh['date']);
		$dh['reply'] = trim($dh['reply']);
		$comment[] = $dh;
	}

	$pageurl =  pagination($num,15,$page,"comment.php?{$addUrl}page");

	include getViews('header');
	require_once(getViews('comment'));
	include getViews('footer');
	cleanPage();
}

###################批量操作评论###############
if($action== 'admin_all_coms')
{
	$dowhat = isset($_POST['modall']) ? $_POST['modall'] : '';
	if($dowhat == '')
	{
		formMsg('请选择一个要执行的操作','./comment.php',0);
	}
	$coms=isset($_POST['com']) ? $_POST['com'] : '';
	if($coms == '')
	{
		formMsg('请选择要执行操作的评论','./comment.php',0);
	}
	//删除
	if($dowhat == 'delcom')
	{
		foreach($coms as $key=>$value)
		{
			$dh = $DB->fetch_one_array("SELECT gid FROM {$db_prefix}comment WHERE cid='$key' ");
			$DB->query("DELETE FROM {$db_prefix}comment where cid='$key' ");
			$DB->query("UPDATE {$db_prefix}blog SET comnum=comnum-1 WHERE gid='".$dh['gid']."'");
		}
		$MC->mc_sta('../cache/sta');
		$MC->mc_comment('../cache/comments');
		formMsg('评论删除成功','./comment.php',1);
	}
	//屏蔽
	if($dowhat == 'killcom')
	{
		foreach($coms as $key=>$value)
		{
			if($value=='n')
			{
				$dh = $DB->fetch_one_array("SELECT gid FROM {$db_prefix}comment WHERE cid='$key' ");
				$DB->query("UPDATE {$db_prefix}blog SET comnum=comnum-1 WHERE gid='".$dh['gid']."' ");
			}
			$DB->query("UPDATE {$db_prefix}comment SET hide='y' WHERE cid='$key' ");
		}
		$MC->mc_sta('../cache/sta');
		$MC->mc_comment('../cache/comments');
		formMsg('屏蔽评论成功','./comment.php',1);
	}
	//审核
	if($dowhat == 'showcom')
	{
		foreach($coms as $key=>$value)
		{
			if($value=='y')
			{
				$dh = $DB->fetch_one_array("SELECT gid FROM {$db_prefix}comment WHERE cid='$key' ");
				$DB->query("UPDATE {$db_prefix}blog SET comnum=comnum+1 WHERE gid='".$dh['gid']."'");
			}
			$DB->query("UPDATE {$db_prefix}comment SET hide='n' WHERE cid='$key' ");
		}
		$MC->mc_sta('../cache/sta');
		$MC->mc_comment('../cache/comments');
		formMsg('审核评论成功','./comment.php',1);
	}
}
//删除评论
if ($action== 'del_comment')
{
	$commentid = isset($_GET['commentid']) ? intval($_GET['commentid']) : '';
	$dh = $DB->fetch_one_array("SELECT gid FROM {$db_prefix}comment WHERE cid=$commentid");
	$DB->query("DELETE FROM {$db_prefix}comment where cid=$commentid");
	$DB->query("UPDATE {$db_prefix}blog SET comnum=comnum-1 WHERE gid=".$dh['gid']);
	$MC->mc_sta('../cache/sta');
	$MC->mc_comment('../cache/comments');
	formMsg('评论删除成功','./comment.php',1);
}
//屏蔽评论
if($action=='kill_comment')
{
	$hide = isset($_GET['hide']) ? addslashes($_GET['hide']) : '';
	if($hide == 'n')
	{
		$dh = $DB->fetch_one_array("SELECT gid FROM {$db_prefix}comment WHERE cid='".$_GET['cid']."' ");
		$DB->query("UPDATE {$db_prefix}blog SET comnum=comnum-1 WHERE gid='".$dh['gid']."'");
	}
	$DB->query(" UPDATE {$db_prefix}comment SET hide='y' where cid='".$_GET['cid']."' ");
	$MC->mc_sta('../cache/sta');
	$MC->mc_comment('../cache/comments');
	formMsg('评论屏蔽成功','./comment.php',1);
}
//审核评论
if($action=='show_comment')
{
	$hide = isset($_GET['hide']) ? addslashes($_GET['hide']) : '';
	if($hide == 'y')
	{
		$dh = $DB->fetch_one_array("SELECT gid FROM {$db_prefix}comment WHERE cid='".$_GET['cid']."' ");
		$DB->query("UPDATE {$db_prefix}blog SET comnum=comnum+1 WHERE gid='".$dh['gid']."'");
	}
	$DB->query(" UPDATE {$db_prefix}comment SET hide='n' where cid='".$_GET['cid']."' ");
	$MC->mc_sta('../cache/sta');
	$MC->mc_comment('../cache/comments');
	formMsg('评论审核成功','./comment.php',1);
}
//回复评论
if ($action== 'reply_comment')
{
	include getViews('header');

	$cid = isset($_GET['cid']) ? intval($_GET['cid']) : '';

	$sql = "select * from {$db_prefix}comment where cid=$cid ";
	$result = $DB->query($sql);
	$comarr = $DB->fetch_array($result);
	$comment = htmlspecialchars(trim($comarr['comment']));
	$reply = htmlspecialchars(trim($comarr['reply']));
	$name = trim($comarr['poster']);
	$date = date("Y-m-d H:i",$comarr['date']);

	require_once(getViews('comment_reply'));
	include getViews('footer');cleanPage();
}
if($action=='doreply')
{
	$flg = isset($_GET['flg']) ? intval($_GET['flg']) : 0;
	$reply = isset($_POST['reply']) ? addslashes($_POST['reply']) : '';
	$cid = isset($_REQUEST['cid']) ? intval($_REQUEST['cid']) : '';

	if(!$flg)
	{
		$sql="UPDATE {$db_prefix}comment SET reply='$reply' where cid=$cid ";
		$DB->query($sql);
		$MC->mc_comment('../cache/comments');
		formMsg("评论回复成功","./comment.php",1);
	}else{
		$reply = isset($_POST["reply$cid"]) ? addslashes($_POST["reply$cid"]) : '';
		$sql="UPDATE {$db_prefix}comment SET reply='$reply' where cid=$cid ";
		$DB->query($sql);
		$MC->mc_comment('../cache/comments');
		echo "<span><b>博主回复</b>：$reply</span>";
	}
}

?>