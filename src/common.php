<?php
/**
 * 前端全局项加载
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.5.0
 * $Id$
 */

require_once 'init.php';

//读取缓存
$log_cache_tags = $CACHE->readCache('logtags');
$log_cache_sort = $CACHE->readCache('logsort');
$log_cache_atts = $CACHE->readCache('logatts');
$newLogs_cache = $CACHE->readCache('newlog');
$tag_cache = $CACHE->readCache('tags');
$sort_cache = $CACHE->readCache('sort');
$com_cache = $CACHE->readCache('comment');
$link_cache = $CACHE->readCache('link');
$user_cache = $CACHE->readCache('user');
$dang_cache = $CACHE->readCache('record');
$sta_cache = $CACHE->readCache('sta');

$navibar = unserialize($navibar);
