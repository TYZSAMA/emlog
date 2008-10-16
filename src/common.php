<?php
/**
 * 前端全局项加载主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

error_reporting(E_ALL);
ob_start();

//$start_time=array_sum(explode(' ',microtime()));

define('EMLOG_ROOT', dirname(__FILE__));

require_once(EMLOG_ROOT.'/config.php');
require_once(EMLOG_ROOT.'/lib/C_mysql.php');
require_once(EMLOG_ROOT.'/lib/F_base.php');
require_once(EMLOG_ROOT.'/lib/F_login.php');
require_once(EMLOG_ROOT.'/lib/C_cache.php');

//数据库操作对象
$DB = new MySql($host, $user, $pass,$db);
//cache
$CACHE = new mkcache('./content/cache/', $DB,$db_prefix);
//去除多余的转义字符
doStripslashes();
//登录验证
$userData = array();
define('ISLOGIN',	isLogin());
//获取操作
$action = isset($_GET['action'])?addslashes($_GET['action']):'';

//读取缓存
$config_cache = $CACHE->readCache('config');
$log_cache_tags = $CACHE->readCache('log_tags');
$log_cache_atts = $CACHE->readCache('log_atts');
$tag_cache = $CACHE->readCache('tags');
$com_cache = $CACHE->readCache('comments');
$link_cache = $CACHE->readCache('links');
$user_cache = $CACHE->readCache('blogger');
$dang_cache = $CACHE->readCache('records');
$sta_cache = $CACHE->readCache('sta');
$tw_cache = $CACHE->readCache('twitter');
$music = $CACHE->readCache('musics');

//配置项目
extract($config_cache);
$exarea    = stripslashes($exarea);
$timezone  = intval($timezone);
$tpl_dir   = './content/templates/';//所有模板存放目录
$localdate = $timezone != 8 ? time() - ($timezone-8) * 3600 : time();

//站点信息
$icp = $icp;
$photo = $user_cache['photo'];
$blogger_des = $user_cache['des'];
$user_cache['mail']!=''?
$name = "<a href=\"mailto:".$user_cache['mail']."\">".$user_cache['name']."</a>":
$name = $user_cache['name'];

//背景音乐
if ($ismusic = $music['ismusic'])
{
	$key = $music['randplay'] ? mt_rand(0,count($music['mlinks']) - 1) : 0 ;
	$musicurl = $music['mlinks'][$key];
	$musicdes = !empty($music['mdes'][$key]) ? $music['mdes'][$key] .'<br>' : '';
	$autoplay = $music['auto'] ? "&autoplay=1" : '';
}

?>
