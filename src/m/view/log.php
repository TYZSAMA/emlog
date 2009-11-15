<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./" id="active">日志</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="./?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<form method="post" action="./?action=t" >
<input name="t" value="" /> <br /><input type="submit" value="发碎语" /> <a href="./?action=write">撰写日志</a>
</form>
<?php endif;?>
<?php foreach($logs as $value): ?>
<div class="title"><a href="./?post=<?php echo $value['logid'];?>"><?php echo $value['log_title']; ?></a></div>
<div class="info"><?php echo date('Y-n-j G:i', $value['date']); ?></div>
<div class="info2">
评论:<?php echo $value['comnum']; ?> 阅读:<?php echo $value['views']; ?> 
<?php if(ROLE == 'admin' || $value['author'] == UID): ?>
<a href="./?action=write&id=<?php echo $value['logid'];?>">编辑</a>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $page_url;?></div>
</div>