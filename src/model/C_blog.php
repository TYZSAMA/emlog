<?php
/**
 * 模型：撰写日志
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

class emBlog {

	var $dbhd;

	function emBlog($dbhandle)
	{
		$this->dbhd = $dbhandle;
	}

	/**
	 * 存储日志到数据库
	 *
	 * @param array $logData
	 * @return int logid
	 */
	function addlog($logData)
	{
		$kItem = array();
		$dItem = array();
		foreach ($logData as $key => $data)
		{
			$kItem[] = $key;
			$dItem[] = $data;
		}
		$field = implode(',', $kItem);
		$values = "'".implode("','", $dItem)."'";
		$this->dbhd->query("insert into ".DB_PREFIX."blog ($field) values($values)");
		$logid = $this->dbhd->insert_id();
		return $logid;
	}

	/**
	 * 更新日志内容
	 *
	 * @param array $logData
	 * @param int $blogId
	 */
	function updateLog($logData,$blogId)
	{
		$Item = array();
		foreach ($logData as $key => $data)
		{
			$Item[] = "$key='$data'";
		}
		$upStr = implode(',', $Item);
		$this->dbhd->query("update ".DB_PREFIX."blog set $upStr where gid=$blogId");
	}

	/**
	 * 获取指定条件的日志条数
	 *
	 * @param string $hide
	 * @param string $condition
	 * @param int $uid
	 * @param string $type
	 * @return int
	 */
	function getLogNum($hide = 'n', $condition = '', $uid = 1, $type = 'blog')
	{
		$DraftNum = '';
		$author = $uid == 1 && $hide == 'n' ? '' : 'and author='.$uid;
		$res = $this->dbhd->query("SELECT gid FROM ".DB_PREFIX."blog WHERE type='$type' and hide='$hide' $author $condition");
		$LogNum = $this->dbhd->num_rows($res);
		return $LogNum;
	}

	/**
	 * 后台获取单条日志
	 *
	 * @param int $blogId
	 * @param string $hide
	 * @return array
	 */
	function getOneLogForAdmin($blogId,  $hide = '')
	{
		$hideState = $hide == 'n' ? "and hide='n'" :'';
		$sql = "select * from ".DB_PREFIX."blog where gid=$blogId $hideState";
		$res = $this->dbhd->query($sql);
		$row = $this->dbhd->fetch_array($res);
		if($row)
		{
			$row['title'] = htmlspecialchars($row['title']);
			$row['content'] = htmlspecialchars($row['content']);
			$row['excerpt'] = htmlspecialchars($row['excerpt']);
			$row['password'] = htmlspecialchars($row['password']);
			$logData = $row;
			return $logData;
		}else {
			return false;
		}
	}

	/**
	 * 前台获取单条日志
	 *
	 * @param int $blogId
	 * @return array
	 */
	function getOneLogForHome($blogId)
	{
		$sql = "select * from ".DB_PREFIX."blog where gid=$blogId and hide='n'";
		$res = $this->dbhd->query($sql);
		$row = $this->dbhd->fetch_array($res);
		if($row)
		{
			$logData = array(
			'log_title'	=> htmlspecialchars($row['title']),
			'date' => $row['date'],
			'logid' => intval($row['gid']),
			'sortid' => intval($row['sortid']),
			'type' => $row['type'],
			'author' => $row['author'],
			'tbscode' => substr(md5(date('Ynd')),0,5),
			'log_content' => rmBreak($row['content']),
			'views'=>intval($row['views']),
			'comnum'=>intval($row['comnum']),
			'tbcount'=>intval($row['tbcount']),
			'top'=>$row['top'],
			'attnum'=>intval($row['attnum']),
			'allow_remark' => $row['allow_remark'],
			'allow_tb' => $row['allow_tb'],
			'password' => $row['password']
			);
			return $logData;
		}else {
			return false;
		}
	}

	/**
	 * 后台获取日志列表
	 *
	 * @param string $condition
	 * @param string $hide_state
	 * @param int $page
	 * @param int $uid
	 * @param string $type
	 * @return array
	 */
	function getLogsForAdmin($condition = '', $hide_state = '', $page = 1, $uid = 1, $type = 'blog')
	{
		$start_limit = !empty($page) ? ($page - 1) * 15 : 0;
		$author = $uid == 1 && $hide_state == 'n' ? '' : 'and author='.$uid;
		$hide_state  = $hide_state ? "and hide='$hide_state'" : '';
		$limit = "LIMIT $start_limit, 15";
		$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE type='$type' $author $hide_state $condition $limit";
		$res = $this->dbhd->query($sql);
		$logs = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			$row['date'] = date("Y-m-d H:i",$row['date']);
			$row['title'] = !empty($row['title']) ? htmlspecialchars($row['title']) : 'No Title';
			$row['gid'] = $row['gid'];
			$row['comnum'] = $row['comnum'];
			$row['istop'] = $row['top']=='y' ? "<font color=\"red\">[推荐]</font>" : '';
			$row['attnum'] = $row['attnum'] > 0 ? "<font color=\"green\">[附件:".$row['attnum']."]</font>" : '';
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 前台获取日志列表
	 *
	 * @param int $page
	 * @param int $prePageNum
	 * @param string $condition
	 * @return array
	 */
	function getLogsForHome($condition = '', $page = 1, $prePageNum)
	{
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE type='blog' and hide='n' $condition $limit";
		$res = $this->dbhd->query($sql);
		$logs = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			//$row['date'];
			$row['log_title'] = htmlspecialchars(trim($row['title']));
			$row['logid'] = $row['gid'];
			$cookiePassword = isset($_COOKIE['em_logpwd_'.$row['gid']]) ? addslashes(trim($_COOKIE['em_logpwd_'.$row['gid']])) : '';
			if(!empty($row['password']) && $cookiePassword != $row['password'])
			{
				$row['excerpt'] = '<p>[该日志已设置加密，请点击标题输入密码访问]</p>';
			}else{
				if(!empty($row['excerpt']))
				{
					$row['excerpt'] .= '<p><a href="./?action=showlog&gid='.$row['logid'].'">阅读全文&gt;&gt;</a></p>';
				}
			}
			$row['log_description'] = empty($row['excerpt']) ? breakLog($row['content'],$row['gid']) : $row['excerpt'];
			$row['toplog'] = $row['top'];
			$row['attachment'] = '';
			$row['tag']  = '';
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 删除日志
	 *
	 * @param int $blogId
	 * @param int $uid
	 * @return unknown
	 */
	function deleteLog($blogId, $uid)
	{
		$condition = $uid == 1 ? '' : 'and author='.$uid;
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."blog where gid=$blogId $condition");
		$del_nums = $this->dbhd->affected_rows();
		if ($del_nums < 1)
		{
			return false;
		}
		//评论
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."comment where gid=$blogId");
		//引用
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."trackback where gid=$blogId");
		//标签
		$this->dbhd->query("UPDATE ".DB_PREFIX."tag SET gid= REPLACE(gid,',$blogId,',',') WHERE gid LIKE '%".$blogId."%' ");
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."tag WHERE gid=',' ");
		//附件
		$query = $this->dbhd->query("select filepath from ".DB_PREFIX."attachment where blogid=$blogId ");
		while ($attach=$this->dbhd->fetch_array($query))
		{
			if (file_exists($attach['filepath']))
			{
				$fpath = str_replace('thum-', '', $attach['filepath']);
				if ($fpath != $attach['filepath'])
				{
					@unlink($fpath);
				}
				@unlink($attach['filepath']);
			}
		}
		$this->dbhd->query("DELETE FROM ".DB_PREFIX."attachment where blogid=$blogId");
	}

	/**
	 * 隐藏/显示日志
	 *
	 * @param int $blogId
	 * @param string $hideState
	 */
	function hideSwitch($blogId, $hideState)
	{
		$this->dbhd->query("UPDATE ".DB_PREFIX."blog SET hide='$hideState' WHERE gid=$blogId");
		$this->dbhd->query("UPDATE ".DB_PREFIX."comment SET hide='$hideState' WHERE gid=$blogId");
	}

	/**
	 * 获取日志发布时间
	 *
	 * @param int $timezone
	 * @param string $postDate
	 * @param string $oldDate
	 * @return unknown
	 */
	function postDate($timezone=8, $postDate=null, $oldDate=null)
	{
		$localtime = time() - ($timezone - 8) * 3600;
		$logDate = $oldDate ? $oldDate : $localtime;
		$unixPostDate = '';
		if($postDate)
		{
			$unixPostDate = @strtotime($postDate);
			if($unixPostDate === false)
			{
				$unixPostDate = $logDate;
			}
		}else{
			return $localtime;
		}
		return $unixPostDate;
	}

	/**
	 * 增加阅读次数
	 *
	 * @param int $blogId
	 */
	function updateViewCount($blogId)
	{
		$this->dbhd->query("UPDATE ".DB_PREFIX."blog SET views=views+1 WHERE gid=$blogId");
	}

	/**
	 * 获取相邻日志
	 *
	 * @param int $blogId
	 * @return array
	 */
	function neighborLog($blogId)
	{
		$neighborlog = array();
		$neighborlog['nextLog'] = $this->dbhd->once_fetch_array("SELECT title,gid FROM ".DB_PREFIX."blog WHERE gid < $blogId AND hide = 'n' ORDER BY gid DESC  LIMIT 1");
		$neighborlog['prevLog'] = $this->dbhd->once_fetch_array("SELECT title,gid FROM ".DB_PREFIX."blog WHERE gid > $blogId AND hide = 'n' LIMIT 1");
		if($neighborlog['nextLog'])
		{
			$neighborlog['nextLog']['title'] = htmlspecialchars($neighborlog['nextLog']['title']);
		}
		if($neighborlog['prevLog'])
		{
			$neighborlog['prevLog']['title'] = htmlspecialchars($neighborlog['prevLog']['title']);
		}
		return $neighborlog;
	}

	/**
	 * 获取指定数量最新日志
	 *
	 * @param int $num
	 * @return array
	 */
	function getNewLog($num)
	{
		$sql = "SELECT gid,title FROM ".DB_PREFIX."blog WHERE hide='n' ORDER BY gid DESC LIMIT 0, $num";
		$res = $this->dbhd->query($sql);
		$logs = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			$row['gid'] = intval($row['gid']);
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 随机获取指定数量日志
	 *
	 * @param int $num
	 * @return array
	 */
	function getRandLog($num)
	{
		$sql = "SELECT gid,title FROM ".DB_PREFIX."blog WHERE hide='n' ORDER BY rand() LIMIT 0, $num";
		$res = $this->dbhd->query($sql);
		$logs = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			$row['gid'] = intval($row['gid']);
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		return $logs;
	}

	/**
	 * 加密日志访问验证
	 *
	 * @param string $pwd
	 * @param string $pwd2
	 */
	function authPassword($postPwd, $cookiePwd, $logPwd, $logid)
	{
		$pwd = $cookiePwd ? $cookiePwd : $postPwd;
		if($pwd !== addslashes($logPwd))
		{
			echo <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog message</title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	margin-top:20px;
	font-size: 12px;
	color: #666666;
	width:580px;
	margin:10px 200px;
	padding:10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
-->
</style>
</head>
<body>
<div class="main">
<form action="" method="post">
请输入该日志的访问密码<br>
<input type="password" name="logpwd" /><input type="submit" value="进入.." />
<br /><br /><a href="./index.php">&laquo;返回首页</a>
</form>
</div>
</body>
</html>
EOT;
			if($cookiePwd)
			{
				setcookie('em_logpwd_'.$logid, ' ', time() - 31536000);
			}
			exit;
}else {
	setcookie('em_logpwd_'.$logid, $logPwd);
}
	}
}

?>