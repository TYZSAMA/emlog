<?php
/**
 * 数据备份
 * @copyright (c) 2008, Emlog All rights reserved.
 * @version emlog-2.5.0
 */

require_once('./globals.php');

if($action == '')
{
	include getViews('header');
	$tables = array('attachment', 'blog', 'comment', 'config', 'link','statistics','tag', 'user','trackback');
	$defname = md5(date('YmdHis'));
	require_once(getViews('bakdata'));
	include getViews('footer');cleanPage();
}
if($action=='bakstart')
{
	$bakfname = isset($_POST['bakfname'])?$_POST['bakfname']:'';
	$table_box = isset($_POST['table_box'])?$_POST['table_box']:'';
	
	if(!preg_match("/^[a-zA-Z0-9_]+$/",$bakfname))
	{
		formMsg('错误的备份文件名','javascript:history.go(-1);',0);
	}
	$filename = './bakup/'.$bakfname.'.sql';

	// 获取数据库结构和数据内容
	$sqldump = '';
	foreach($table_box as $table)
	{
		$sqldump .= dataBak($table); 
	}

	// 如果数据内容不是空就开始保存
	if(trim($sqldump)) 
	{
		$sqldump = 
		"#----------------------------------------\n".
		"#emlog_$edition 数据库备份文件\n#备份日期:".
		date('Y/m/d')."\n".
		"#----------------------------------------\n\n\n".$sqldump;
		//备份到服务器
		@$fp = fopen($filename, "w+");
		if ($fp)
		{
			@flock($fp, 3);
			if(@!fwrite($fp, $sqldump)) 
			{
				@fclose($fp);
				 formMsg( '备份失败,请检查目录的权限是否可写','javascript:history.go(-1);',0);
			}else
			{
				formMsg('数据成功备份至服务器','javascript:history.go(-1);',1);
			}
		}else
		{
			formMsg('无法打开指定的目录'. $filename .'，请确定该目录是否存在,或者是否有相应权限','javascript:history.go(-1);',0);
		}
	}else
	{
		formMsg('数据表没有任何内容','javascript:history.go(-1);',0);
	}

}

//备份文件管理
if($action=='bakfile')
{
	include getViews('header');
	$bakfiles = glob("../adm/bakup/*.sql");
 	require_once(getViews('bakfile'));
	include getViews('footer');cleanPage();
}
//恢复数据
if ($action == 'renewdata')
{
	$sqlfile = isset($_GET['sqlfile'])?$_GET['sqlfile']:'';
	if (!file_exists($sqlfile))
	{
		formMsg('文件不存在', 'javascript:history.go(-1);',0);
	}else
	{
		$extension=strtolower(substr(strrchr($sqlfile,'.'),1));
		if ($extension !== 'sql')
		{
			formMsg('读取数据库文件失败, 只能恢复 *.sql 文件.', 'javascript:history.go(-1);',0);
		}		
		$fp=fopen($sqlfile,'rb');
		$bakinfo=fread($fp,200);
		fclose($fp);
		$detail=explode("\n",$bakinfo);
		$dbfile['system']=substr($detail[1],1,11);
		if ($dbfile['system'] !== "emlog_$edition")
		{
			formMsg("导入失败!该备份文件不是emlog_$edition的备份文件!", 'javascript:history.go(-2);',0);
		}
	}
	$fp = fopen($sqlfile, 'rb');
	$sql = fread($fp, filesize($sqlfile));
	fclose($fp);
	unset($sql);
	bakindata($sqlfile);
	$MC->mc_blogger('../cache/blogger');
	$MC->mc_config('../cache/config');
	$MC->mc_record('../cache/records');
	$MC->mc_comment('../cache/comments');
	$MC->mc_logtags('../cache/log_tags');
	$MC->mc_sta('../cache/sta');
	$MC->mc_link('../cache/links');
	$MC->mc_tags('../cache/tags');
	formMsg('数据恢复成功', './backupdata.php?action=bakfile',1);
}

function bakindata($filename)
{
	global $DB;
	$sql = file($filename);
	$query = '';
	$num = 0;
	foreach($sql as $key => $value)
	{
		$value = trim($value);
		if(!$value || $value[0]=='#') continue;
		if(eregi("\;$",$value))
		{			
			$query .= $value;
			if(eregi("^CREATE",$query))
			{
				$query = preg_replace("/\DEFAULT CHARSET=([a-z0-9]+)/is",'',$query);
			}			
			$DB->query($query);
			$query = '';
		} else
		{
			$query .= $value;
		}
	}
}

//批量删除备份文件
if($action== 'dell_all_bak')
{
	if(!isset($_POST['bak']))
	{
		formMsg('请选择要删除的备份文件','./backupdata.php?action=bakfile',0);
	}else
	{
		foreach($_POST['bak'] as $value)
		{
			unlink($value);
		}
		formMsg('备份文件删除成功!','./backupdata.php?action=bakfile',1);
	}
}
?>