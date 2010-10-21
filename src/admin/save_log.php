<?php
/**
 * 保存日志（增加、修改）
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

$Log_Model = new Log_Model();
$Tag_Model = new Tag_Model();
$Trackback_Model = new Trackback_Model();

$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
$postDate = isset($_POST['postdate']) ? trim($_POST['postdate']) : '';
$date = isset($_POST['date']) ? addslashes($_POST['date']) : '';//修改前的日志时间
$sort = isset($_POST['sort']) ? intval($_POST['sort']) : '';
$tagstring = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
$content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
$excerpt = isset($_POST['excerpt']) ? addslashes(trim($_POST['excerpt'])) : '';
$author = isset($_POST['author']) ? intval(trim($_POST['author'])) : UID;
$blogid = isset($_POST['as_logid']) ? intval(trim($_POST['as_logid'])) : -1;//如被自动保存为草稿则有blog id号
$pingurl  = isset($_POST['pingurl']) ? addslashes($_POST['pingurl']) : '';
$allow_remark = isset($_POST['allow_remark']) ? addslashes($_POST['allow_remark']) : 'y';
$allow_tb = isset($_POST['allow_tb']) ? addslashes($_POST['allow_tb']) : 'y';
$ishide = isset($_POST['ishide']) && !empty($_POST['ishide']) && !isset($_POST['pubdf']) ? addslashes($_POST['ishide']) : 'n';
$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';

$postTime = $Log_Model->postDate(Option::get('timezone'), $postDate, $date);

$logData = array(
	'title'=>$title,
	'content'=>$content,
	'excerpt'=>$excerpt,
	'author'=>$author,
	'sortid'=>$sort,
	'date'=>$postTime,
	'allow_remark'=>$allow_remark,
	'allow_tb'=>$allow_tb,
	'hide'=>$ishide,
	'password'=>$password
);
if($blogid > 0)//自动保存草稿后,添加变为更新
{
	$Log_Model->updateLog($logData, $blogid);
	$Tag_Model->updateTag($tagstring, $blogid);
	$dftnum = '';
}else{
    if (!$blogid = $Log_Model->isRepeatPost($title, $postTime))
    {
        $blogid = $Log_Model->addlog($logData);
    }
	$Tag_Model->addTag($tagstring, $blogid);
	$dftnum = $Log_Model->getLogNum('y', '', 'blog', 1);
}

$CACHE->updateCache();

doAction('save_log', $blogid);

switch ($action) {
	case 'autosave':
		echo "autosave_gid:{$blogid}_df:{$dftnum}_";
		break;
	case 'add':
	case 'edit':
		$tbmsg = '';
		if($ishide == 'y') {
			$ok_msg = '草稿保存成功！';
			$ok_url = 'admin_log.php?pid=draft';
		} else {
			//发送Trackback
			if(!empty($pingurl)) {
				$tbmsg = $Trackback_Model->postTrackback(Option::get('blogurl'), $pingurl, $blogid, $title, Option::get('blogname'), $content);
			}
			$ok_msg = $action == 'add' || isset($_POST['pubdf']) ? '日志发布成功！' : '日志保存成功！';
			$ok_url = 'admin_log.php';
		}
		formMsg("$ok_msg\t$tbmsg",$ok_url,1);
		break;
}
