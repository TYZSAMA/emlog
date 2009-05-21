<?php
/**
 * emlog相册插件
 * by：emlog
 */
require_once('XMLParser.php');
require_once('../../../common.php');

$cerTemplatePath = TEMPLATE_PATH.$nonce_templet.'/';
$calendar_url = BLOG_URL.'calendar.php?' ;

$album = isset($_GET['album']) ? $_GET['album'] : '';

$account = '';
$cachefile = './cache/account';
if(@$fp = fopen($cachefile, 'r'))
{
	$account = @fread($fp,filesize($cachefile));
	fclose($fp);
}
//显示相册列表
if (!$album)
{
	$XMLP = new SofeeXmlParser();
	$feed = "http://picasaweb.google.com/data/feed/base/user/{$account}?kind=album&access=public&hl=zh_CN";
	$XMLP->parseFile($feed);

	$albumData = $XMLP->getTree();
	$albumData = $albumData['feed'];

	$blogtitle =  $albumData['author']['name']['value'] . '的相册 - ' . $blogname;
	$log_title =  $albumData['author']['name']['value'] . '的相册';
	$log_content = '';

	foreach ($albumData['entry'] as $val)
	{
		$title = $val['media:group']['media:title']['value'];
		$description = $val['media:group']['media:description']['value'];
		preg_match('/albumid\/(\d+)/', $val['id']['value'], $match);
		$albumId = $match[1];
		$thumb = $val['media:group']['media:thumbnail'];

		$thumb_url = $thumb['url'];
		$thumb_width = $thumb['width'];
		$thumb_height = $thumb['height'];
		$log_content .=	'
		<div>
		<div>
		<a href="album.php?album='.$albumId.'">
		<img src="'.$thumb_url.'" width="'.$thumb_width.'" height="'.$thumb_height.'"></a>
		</div>
		<p><a href="album.php?album='.$albumId.'">'.$title.'</a></p>
		<p>'.$description.'</p>
		</div>';
	}

	$allow_remark = 'n';
	$logid = '';

	addAction('index_head', 'album_list_css');
	
	include getViews('header');
	include getViews('page');
}
//显示单个相册里的照片
if ($album)
{
	$XMLP = new SofeeXmlParser();
	$feed = "http://picasaweb.google.com/data/feed/base/user/{$account}/albumid/".$album."?hl=zh_CN";
	$XMLP->parseFile($feed);

	$albumData = $XMLP->getTree();
	$albumData = $albumData['feed'];

	$blogtitle =  $albumData['title']['value'] . ' - ' . $blogname;
	$log_title =  $albumData['title']['value'];
	$log_content = '
	<div id="gallery">
	<ul>';
	foreach ($albumData['entry'] as $val)
	{
		$thumb = $val['media:group']['media:thumbnail'][1];
		$thumb_url = $thumb['url'];
		$thumb_width = $thumb['width'];
		$thumb_height = $thumb['height'];
		$photo_src = preg_replace('/^(.+\/)(s\d+)(.+)$/', '$1s512$3', $thumb_url);

		$log_content .=	'
        <li>
		<a href="'.$photo_src.'">
		<img src="'.$thumb_url.'" width="'.$thumb_width.'" height="'.$thumb_height.'"></a>
		</li>';
	}
	$log_content .= '
	</ul>
    </div>';

	$allow_remark = 'n';
	$logid = '';

	addAction('index_head', 'album_photo_css');

	include getViews('header');
	include getViews('page');
}

//单个相册里的照片 css样式
function album_photo_css()
{
echo <<<EOT
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript">
$(function() {
$('#gallery a').lightBox();
});
</script>
<style type="text/css">
	#gallery {
		padding: 10px;
	}
	#gallery ul { list-style: none; }
	#gallery ul li { display: inline; }
	#gallery ul img {
		border: 5px solid #3e3e3e;
		border-width: 5px 5px 20px;
	}
	#gallery ul a:hover img {
		border: 5px solid #fff;
		border-width: 5px 5px 20px;
		color: #fff;
	}
	#gallery ul a:hover { color: #fff; }
</style>
EOT;
}
//相册列表 css样式
function album_list_css()
{
echo <<<EOT
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript">
$(function() {
$('#gallery a').lightBox();
});
</script>
<style type="text/css">

</style>
EOT;
}

cleanPage(true);

?>
