<?php
/**
 * 前端全局项加载
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

require_once('./config.php');
require_once(EMLOG_ROOT.'/init.php');

//登录验证
$userData = array();
define('ISLOGIN',	isLogin());

//读取缓存
$log_cache_tags = $CACHE->readCache('log_tags');
$log_cache_sort = $CACHE->readCache('log_sort');
$log_cache_atts = $CACHE->readCache('log_atts');
$newLogs_cache = $CACHE->readCache('newlogs');
$tag_cache = $CACHE->readCache('tags');
$sort_cache = $CACHE->readCache('sort');
$com_cache = $CACHE->readCache('comments');
$link_cache = $CACHE->readCache('links');
$user_cache = $CACHE->readCache('blogger');
$dang_cache = $CACHE->readCache('records');
$sta_cache = $CACHE->readCache('sta');
$tw_cache = $CACHE->readCache('twitter');

$photo = $user_cache['photo'];
$blogger_des = $user_cache['des'];
$name = $user_cache['mail'] != '' ? "<a href=\"mailto:".$user_cache['mail']."\">".$user_cache['name']."</a>" : $user_cache['name'];
//模板目录
define('TEMPLATE_PATCH', './content/templates/');

//背景音乐
$music = @unserialize($options_cache['music']);
if ($music['mlinks'])
{
	$key = $music['randplay'] ? mt_rand(0,count($music['mlinks']) - 1) : 0 ;
	$musicurl = $music['mlinks'][$key];
	$musicdes = !empty($music['mdes'][$key]) ? $music['mdes'][$key] .'<br>' : '';
	$autoplay = $music['auto'] ? "&autoplay=1" : '';
}

?>
