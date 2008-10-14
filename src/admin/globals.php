<?php
/**
 * 后台全局项加载主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

error_reporting(E_ALL);
ob_start();

require_once('../config.php');
require_once('../lib/C_mysql.php');
require_once('../lib/F_base.php');
require_once('../lib/F_login.php');
require_once('../lib/F_adm.php');
require_once('./tips.php');
require_once('../lib/C_cache.php');

//去除多余的转义字符
doStripslashes();
//获取GET变量
$action = isset($_GET['action']) ? $_GET['action'] : '';
//数据库操作对象
$DB = new MySql($host, $user, $pass,$db);
//实例化一个缓存生成对象
$CACHE = new mkcache('../content/cache/', $DB, $db_prefix);
		
//读取配置参数
$config_cache = $CACHE->readCache('config');
extract($config_cache);
$timezone  = intval($timezone);
$dftnum = $DB->num_rows($DB->query("SELECT gid FROM {$db_prefix}blog WHERE hide='y'"));
$draftnum = $dftnum>0 ? "($dftnum)" : '';//草稿数目
$tips = getTips($tips);//加载小提示
$att_type = array('rar','zip','gif', 'jpg', 'jpeg', 'png','bmp');//允许上传的文件类型
$uploadroot = "../uploadfile/";	//附件保存目录
$uploadmax = 2097152;			//附件大小上限 单位：字节
$tpl_dir = '../content/templates/';		//所有模板目录
$nonce_tpl = 'default';			//后台模板 adm/views/default

define('AUTH_KEY',	'rtyuiopghjkl'.md5($_SERVER['HTTP_USER_AGENT']).'fghjk');
define('AUTH_COOKIE_NAME',	'EM_AUTHCOOKIE_'.md5($_SERVER['SERVER_SOFTWARE']));
define('EM_VERSION',		'2.7.0');//版本号
define('IMG_ATT_MAX_W',		420);//图片附件缩略图最大宽
define('IMG_ATT_MAX_H',		460);//图片附件缩略图最大高
define('ICON_MAX_W',		140);//个性头像缩略图最大宽
define('ICON_MAX_H',		220);//个性头像缩略图最大高

//检测后台模板
define('ADM_ROOT', dirname(__FILE__));
$em_tpldir = ADM_ROOT.'/views/'.$nonce_tpl.'/';
if (!is_dir($em_tpldir))
{
	exit('the adm tmplate net found!');
}
//登陆验证
if ($action == 'login') 
{
	session_start();
	$username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
	$password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
	$img_code = ($login_code == 'y' && isset($_POST['imgcode'])) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';
	if (strlen($username) >16) 
	{
		formMsg('ERROR!!','javascript:history.go(-1);',0);
	}
	if (checkUser($username, $password,$img_code,$login_code) === true) 
	{
		setAuthCookie($username);
		header("Location: index.php"); 
	}else{
		loginPage();
	}
}
//登出
if ($action == 'logout')
{
	session_start();
	session_unset();
	session_destroy();
	setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
	formMsg('退出成功！','../index.php',1);
}

if(($userData = isLogin()) === false)
{
	loginpage();
}

?>