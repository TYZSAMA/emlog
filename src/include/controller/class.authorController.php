<?php
/**
 * 查看作者日志
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class AuthorController {

	/**
	 * 前台作者日志列表页面输出
	 */
	function display($params) {
		$emBlog = new emBlog();
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		extract($options_cache);
		$navibar = unserialize($navibar);
		$curpage = CURPAGE_HOME;

		$page = isset($params[4]) && $params[4] == 'page' ? abs(intval($params[5])) : 1;
		$author = isset($params[1]) && $params[1] == 'author' ? intval($params[2]) : '' ;

		$start_limit = ($page - 1) * $index_lognum;
		$pageurl = '';

		$user_cache = $CACHE->readCache('user');
		if (!isset($user_cache[$author])) {
			emMsg('不存在该作者', BLOG_URL);
        }
		$blogtitle = $user_cache[$author]['name'].' - '.$blogname;
		$sqlSegment = "and author=$author order by date desc";
		$sta_cache = $CACHE->readCache('sta');
		$lognum = $sta_cache[$author]['lognum'];
		$pageurl .= Url::author($author, 'page');
        
        $emBlog = new emBlog();
        $logs = $emBlog->getLogsForHome($sqlSegment, $page, $index_lognum);
        $page_url = pagination($lognum, $index_lognum, $page, $pageurl);

		include View::getView('header');
		include View::getView('log_list');
	}
}
