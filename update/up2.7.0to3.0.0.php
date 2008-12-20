<?php
/**
 * 数据库升级程序2.7.0 to 3.0.0
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 */

define('EMLOG_VERSION', '3.0.0');
define('EMLOG_ROOT', dirname(__FILE__));

class MySql {
	var $user,$pass,$host,$db;
	var $id,$data,$fields,$row,$row_num,$insertid,$version,$query_num=0;
	function MySql($host,$user,$pass,$db) {
		$this->host = $host;
		$this->pass = $pass;
		$this->user = $user;
		$this->db = $db;
		$this->dbconnect($this->host, $this->user, $this->pass);
		$this->selectdb($this->db);
		if($this->version() >'4.1')
		mysql_query("SET NAMES 'utf8'");
	}
	function dbconnect($host,$user,$pass){
		$this->id = @ mysql_connect($host,$user,$pass) OR die("连接数据库失败，可能是用户名或密码错误");
	}
	function selectdb($db){
		mysql_select_db($db,$this->id) or die("未找到指定数据库!");
	}

	function query($sql) {
		$ret = @ mysql_query($sql,$this->id);
		return $ret;
	}
	function fetch_array($query){
		$this->data = @mysql_fetch_array($query);
		return $this->data;
	}
	function num_rows($query) {
		$this->row_num = @mysql_num_rows($query);
		return $this->row_num;
	}
	function version() {
		$this->version = mysql_get_server_info();
		return $this->version;
	}
	function geterror()
	{
		return mysql_error();
	}
}

function getRandStr($length = 12, $special_chars = true)
{
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ( $special_chars )
	{
		$chars .= '!@#$%^&*()';
	}
	$randStr = '';
	for ( $i = 0; $i < $length; $i++ )
	{
		$randStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $randStr;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog 数据库升级程序</title>
<style type="text/css">
<!--
body {
	background-color: #D4E9EA;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	margin-top:20px;
	font-size: 12px;
	color: #666666;
	width:650px;
	margin:10px 280px;
	padding:10px;
	list-style:none;
}
.input {
	border: 1px solid #CCCCCC;
	font-family: Arial;
	font-size: 18px;
	height:28px;
	background-color:#F7F7F7;
	color: #666666;
	margin:5px 25px;
}
.submit{
	background-color:#FFFFFF;
	border: 3px double #999;
	border-left-color: #ccc;
	border-top-color: #ccc;
	color: #333;
	padding: 0.25em;
	cursor:hand;
}
.title{
	font-size:20px;
	font-weight:bold;
}
.care{
	color:#0066CC;
	padding:0px 10px;
}
.title2{
	font-size:14px;
	color:#000000;
	border-bottom: #CCCCCC 1px solid;
}
.foot{
	text-align:center;
}
li{
	border-bottom:#CCCCCC 1px dotted;
	margin:20px 20px;
}
-->
</style>
<?php
if(!isset($_GET['action'])){
?>
<form name="form1" method="post" action="up2.7.0to3.0.0.php?action=install">
<div class="main">
<div>
<p><span class="title">emlog 2.7.0 to 3.0.0</span><span> 数据库升级程序</span></p>
</div>
<div class="b">
<p class="title2">请填写当前需要升级的emlog相关信息。<br>
  如下各个参数请参考当前emlog根目录下的 config.php 文件 认真填写。</p>
<li><strong> 服务器地址</strong>：<span class="care">(通常为localhost不必修改)</span> <br />
    <input name="hostname" type="text" class="input" value="localhost">
</li>
<li><strong>Mysql
    数据库用户名：</strong><span class="care"></span><br />
    <input name="dbuser" type="text" class="input" value="">
</li>
<li>
    <strong>数据库用户密码：</strong><span class="care"></span><br />
  <input name="password" type="password" class="input">
</li>
<li>
    <strong>emlog的数据库名</strong>：<span class="care"></span><br />
      <input name="dbname" type="text" class="input" value="">
</li>
<li>
    <strong>emlog的数据库前缀</strong>：<span class="care"></span><br />
  <input name="dbprefix" type="text" class="input" value="">
</li>
</div>
<div>
<p class="foot">
<input name="Submit" type="submit" class="submit" value="确 定">
<input name="Submit2" type="reset" class="submit" value="重 置">
</p>
</div>
<p class="foot">
&copy;2007 emlog
</p>
</div>
</div>
</form>
<?php
}

if(isset($_GET['action'])&&$_GET['action'] == "install")
{
	// 获取表单信息，修改配置文件
	$db_host = trim($_POST['hostname']);//服务器地址
	$db_user = trim($_POST['dbuser']);	 //mysql 数据库用户名
	$db_pw   = trim($_POST['password']);//mysql 数据库密码
	$db_name = trim($_POST['dbname']);//数据库名
	$db_prefix = trim($_POST['dbprefix']);//数据库前缀

	@$fp = fopen("config.php", 'w') OR die("<table width=\"600\" align=\"center\" bgcolor=\"#f6f6f6\"><tr><td>打开配置文件(config.php)失败!检查文件权限</td></tr></table>");

	$config = "<?php\n"
	."//mysql database address\n"
	."define('DB_HOST','$db_host');"
	."\n//mysql database user\n"
	."define('DB_USER','$db_user');"
	."\n//database password\n"
	."define('DB_PASSWD','$db_pw');"
	."\n//database name\n"
	."define('DB_NAME','$db_name');"
	."\n//database prefix\n"
	."define('DB_PREFIX','$db_prefix');"
	."\n//auth key\n"
	."define('AUTH_KEY','".getRandStr(32).md5($_SERVER['HTTP_USER_AGENT'])."');"
	."\n//cookie name\n"
	."define('AUTH_COOKIE_NAME','EM_AUTHCOOKIE_".getRandStr(32,false)."');"
	."\n//blog root\n"
	."define('EMLOG_ROOT','".EMLOG_ROOT."');"
	."\n//blog version\n"
	."define('EMLOG_VERSION','".EMLOG_VERSION."');"
	."\n?>";

	@$fw = fwrite($fp, $config) ;
	if (!$fw)
	{
		sysMsg('抱歉！配置文件(config.php)修改失败!请检查该文件是否可写');
	}else{
		$result.="配置文件修改成功<br />";
	}
	fclose($fp);

	//初始化数据库类
	$DB = new Mysql($db_host, $db_user, $db_pw,$db_name);
	unset($db_host, $db_user, $db_pw,$db_name);

	$dbcharset = 'utf8';
	$type = 'MYISAM';
	$extra = "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";";
	$extra2 = "TYPE=".$type;
	$DB->version() > '4.1' ? $add = $extra:$add = $extra2.";";


	$widgets = array(
	'blogger'=>'EMER',
	'calendar'=>'日历',
	'tag'=>'标签',
	'sort'=>'分类',
	'archive'=>'存档',
	'newcomm'=>'最新评论',
	'twitter'=>'Twitter',
	'newlog'=>'最新日志',
	'random_log'=>'随机日志',
	'music'=>'音乐',
	'link'=>'链接',
	'search'=>'搜索',
	'bloginfo'=>'博客信息',
	'custom_text'=>'自定义栏目'
	);
	$wg = array();
	foreach ($widgets as $key=>$val)
	{
		$wg[] = $key;
	}
	$widget_title = serialize($widgets);
	$widgets = serialize($wg);
	
	$res = $DB->query("select * from {$db_prefix}config");
	$row = $DB->fetch_array($res);
	extract($row);
	
$insert = "
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogname','$blogname');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('bloginfo','$bloginfo');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_key','$site_key');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogurl','$blogurl');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('icp','$icp');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_lognum','$index_lognum');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_comnum','$index_comnum');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_twnum','$index_twnum');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newlognum','8');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_randlognum','8');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_subnum','$comment_subnum');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('nonce_templet','$nonce_templet');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('tpl_sidenum','1');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_code','$comment_code');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('login_code','$login_code');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkcomment','$ischkcomment');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isurlrewrite','$isurlrewrite');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isgzipenable','$isgzipenable');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istrackback','$istrackback');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('timezone','$timezone');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('music','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widget_title','$widget_title');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets1','$widgets');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_title1','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_content1','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets2','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_title2','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_content2','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets3','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_title3','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_content3','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets4','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_title4','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_content4','');
";
	
$sql = "
ALTER TABLE {$db_prefix}user CHANGE password password VARCHAR( 64 ) NOT NULL;
ALTER TABLE {$db_prefix}blog DROP attcache;
ALTER TABLE {$db_prefix}blog CHANGE date date BIGINT( 20 ) NOT NULL;
ALTER TABLE {$db_prefix}attachment CHANGE addtime addtime BIGINT( 20 ) NOT NULL;
ALTER TABLE {$db_prefix}comment CHANGE date date BIGINT( 20 ) NOT NULL;
ALTER TABLE {$db_prefix}trackback CHANGE date date BIGINT( 20 ) NOT NULL;
ALTER TABLE {$db_prefix}twitter CHANGE date date BIGINT( 20 ) NOT NULL;
ALTER TABLE {$db_prefix}blog ADD sortid TINYINT( 3 ) NOT NULL DEFAULT '-1' AFTER content;
ALTER TABLE {$db_prefix}blog ADD attnum MEDIUMINT( 8 ) UNSIGNED NOT NULL DEFAULT '0' AFTER tbcount;
CREATE TABLE {$db_prefix}sort (
  sid tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  sortname varchar(255) NOT NULL DEFAULT '',
  taxis tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (sid)
)".$add."
CREATE TABLE {$db_prefix}options (
  option_id int(11) unsigned NOT NULL AUTO_INCREMENT,
  option_name varchar(255) NOT NULL,
  option_value longtext NOT NULL,
  PRIMARY KEY (option_id)
)".$add."
$insert
DROP TABLE {$db_prefix}config;
UPdate {$db_prefix}user set password='\$P\$Bm/Mae5JrYYWaFcgb.hcSacUgvY4cK.';";

	$mysql_query = explode(";\n",$sql);
	while (list(,$query) = each($mysql_query))
	{
		$query = trim($query);
		if ($query)
		{
			$ret = $DB->query($query);
			if(!$ret)
			{
				exit("升级失败，可能是你填写的参数错误，请确认后重新提交！<br />$query<br /> MYSQL ERROR:".$DB->geterror());
			}
		}
	}
	echo "恭喜你Emlog数据库升级成功！请删除该升级文件 <br />后台密码重置为：123456 请登录后马上修改 <br /><a href=\"./index.php\">进入Emlog </a>";
}
echo "</body>";
echo "</html>";
?>