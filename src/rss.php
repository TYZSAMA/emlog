<?php
/**
 * RSS输出主程序
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

error_reporting(E_ALL);

require_once('./config.php');
require_once(EMLOG_ROOT.'/lib/F_base.php');
require_once(EMLOG_ROOT.'/lib/C_mysql.php');
require_once(EMLOG_ROOT.'/lib/C_cache.php');

//初始化数据库类
$DB = new MySql(DB_HOST, DB_USER, DB_PASSWD,DB_NAME);
//cache
$config_cache = mkcache::readCache('options');
$user_cache = mkcache::readCache('blogger');

/**
 * 获取url地址
 *
 * @return unknown
 */
function GetURL()
{
	$path = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	$path = str_replace("/rss.php","",$path);
	Return $path;
}

/**
 * 获取日志信息
 *
 * @return array
 */
function GetBlog()
{
	global $DB;
	$sql = "SELECT * FROM ".DB_PREFIX."blog  WHERE hide='n' ORDER BY gid DESC limit 0,20";
	$result = $DB->query($sql);
	$blog = array();
	while ($re = $DB->fetch_array($result))
	{
		$re['id'] 		= $re['gid'];
		$re['title']    = htmlspecialchars($re['title']);
		$re['date']		= $re['date'];
		$re['content']	= $re['content'];

		$blog[] = $re;
	}
	return $blog;
}

/**
 * 获取日志数目
 *
 * @return unknown
 */
function GetBlogNum()
{
	$blog_t =  GetBlog();
	return count($blog_t);
}

$URL = GetURL();
$site =  $config_cache;
$blog = GetBlog();
$blognum = GetBlogNum();
$author = $user_cache['name'];

header("Content-type:application/xml");

print <<< END
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
<title><![CDATA[{$site['blogname']}]]></title> 
<description><![CDATA[{$site['bloginfo']}]]></description>
<link>http://$URL</link>
<language>zh-cn</language>
<generator>www.emlog.net</generator>

END;
foreach($blog as $value)
{
	$link = "http://".$URL."/?action=showlog&amp;gid=".$value['id'];
	$abstract = str_replace('[break]','',$value['content']);
	$pubdate =  date('r',$value['date']);
print <<< END

<item>
	<title>{$value['title']}</title>
	<link>$link</link>
	<description><![CDATA[{$abstract}]]></description>
	<pubDate>$pubdate</pubDate>
	<author>$author</author>
	<guid>$link</guid>
</item>
END;
}
print <<< END
</channel>
</rss>
END;

?>