<?php
/*
Plugin Name: tips
Version: 1.0
Plugin URL:
Description: 这是世界上第一个emlog插件，它会在你的管理页面送上一句温馨的小提示。
Author: dawei
Author Email: emloog@gmail.com
Author URL: http://www.emlog.net/blog/
*/

$array_tips = array(
'你可以点击编辑器上的 插入日志分割符按钮 将内容部分显示在首页。',
'你可以在日志中上传多个附件',
'emlog支持灵活的标签(tag)分类功能',
'在撰写日志的时候你可以使用Tab键方便的缩进内容',
'如果你的服务器不在国内，请正确选择服务器所在时区。',
'你可以使用widgets功能对博客侧边栏组件排序并自定义侧边栏的组件',
'你可以修改日志的发布时间',
'你可以为你的日志写一段漂亮的摘要',
'为防日志丢失，emlog会在你书写日志的时候为你自动保存它们',
'你可以在日志中插入flash格式的多媒体文件',
'emlog支持引用通告（Trackback），可以让你通知你所要评论的日志',
'如果你的服务器支持，你可以开启URL伪静态设置，这样更有利于搜索引擎收录你的博客',
'emlog采用UTF-8编码，可以支持世界上几乎所有语种的文字。',
'emlog会唱歌,尝试在widgets里添加音乐组件吧',
'你可以把你未写完的日志保存到草稿箱里，等下次有时间的时候再写',
'emlog会把太大的图片附件自动生产缩略图，从而加快页面加载速度',
'emlog是 every memory log 的缩写，意即：点滴记忆',
'你可以把图片附件嵌入到内容中，让你的日志图文并茂',
'你可以在写日志的时候为日志设置访问密码，只让你授予密码的人访问',
'今天你备份数据了吗？',
'节约能源，保护环境',
'如果你拥有爱，请在失去之前好好珍惜',
'我是我命运的船长 我是我灵魂的舵手',
'生命在于运动，别总对着电脑，出去走走吧'
);

function tips()
{
	global $array_tips;
	$i = mt_rand(0,count($array_tips)-1);
	$tip = $array_tips[$i];	
	echo "<div id=\"tip\">:) $tip</div>";
}

addAction('adm_main_top', 'tips');

function tips_css()
{
	echo "
	<style type='text/css'>
	#tip{
		background:url(../content/plugins/tips/icon_tips.gif) no-repeat left 3px;
		padding:3px 18px;
		margin:5px 0px;
		font-size:12px;
		color:#999999;
	}
	</style>";
}

addAction('adm_head', 'tips_css');

?>