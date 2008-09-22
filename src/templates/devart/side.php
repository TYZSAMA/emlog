<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="sidebar">

	
	<div class="block">
		<h3>作者</h3>
		<?php echo $photo; ?><br />
        <?php echo $name; ?><br />
		<span id="bloggerdes"><?php echo $blogger_des; ?></span>
        <?php if(ISLOGIN === true): ?>
        <a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
            <img src="<?php echo $tpl_dir; ?>devart/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
            <span id='modbdes' style="display:none;">
                <textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:190px;height:60px;"><?php echo $blogger_des; ?></textarea>
                <br />
                <a href="javascript:void(0);" onclick="postinfo('./adm/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
                <a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
            </span>
        <?php endif; ?>
	</div>
	<div class="block">
		<h3>日历</h3>
		<ul>
			<div id="calendar">
			</div>
			<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
		</ul>
	</div>
	
	<div class="block">
		<h3>标签</h3>
		<ul>
			
				<?php foreach($tag_cache as $value): ?>
				<span style="font-size:<?php echo $value['fontsize']; ?>pt; height:30px;">
					<a href="index.php?tag=<?php echo $value['tagurl']; ?>" title="<?php echo $value['usenum']; ?> 篇日志"><?php echo $value['tagname']; ?></a></span>
				<?php endforeach; ?>
            
		</ul>
	</div>
	
    
    <?php if($index_twnum > 0 ): ?>
       	<div class="block">
		<h3>Twitter</h3>
        <ul id="twitter">
        <?php
        if(isset($tw_cache) && is_array($tw_cache)):
            $morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
            foreach (array_slice($tw_cache,0,$index_twnum) as $value):
                $delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
                $value['date'] = smartyDate($localdate,$value['date']);
                ?>
                <li> <?php echo $value['content']; ?> <?php echo $delbt; ?><br><span><?php echo $value['date']; ?></span></li>
            <?php endforeach;?>
            <?php echo $morebt;?>
        <?php endif;?>
        </ul>
        <?php if(ISLOGIN === true): ?>
            <ul>
            <li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
            <li id='addtw' style="display: none;">
            <textarea name="tw" id="tw" style="overflow-y: hidden;width:210px;height:70px;" class="input"></textarea>
            <a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
            <a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
            </li>
            </ul>
        <?php endif;?>
		</div>
    <?php endif;?>

	
    <?php if($ismusic): ?>
        <div class="block">
		<h3>音乐</h3>	
        <ul id="blogmusic">
        	<p>
			<?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" /></object>
        	</p>
        </ul>
		</div>
    <?php endif; ?>
    
    
    <div class="block">
		<h3>最新评论</h3>
		<ul>
        	<?php if (is_array($com_cache) && !empty($com_cache) ): ?>
				<?php foreach($com_cache as $value): ?>
                <li id="comment"><?php echo $value['name']; ?> 
               	<a href="<?php echo $value['url']; ?>"><?php echo $value['content']; ?></a></li>
                <?php endforeach; ?>
            <?php endif;?>
		</ul>
	</div>	
    
    <div class="block">
		<h3>日志归档</h3>
		<ul>
        	<?php if (is_array($dang_cache) && !empty($dang_cache) ): ?>
				<?php foreach($dang_cache as $value): ?>
					<li><a href="<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
				<?php endforeach; ?>
            <?php endif;?>
		</ul>
	</div>	
    
    
	<div class="block">
		<h3>友情链接</h3>
		<ul>
        	<?php if (is_array($link_cache) && !empty($link_cache) ): ?>
				<?php foreach($link_cache as $value): ?>     	
                	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
            	<?php endforeach; ?>
            <?php endif;?>
		</ul>
	</div>		
	
	<div class="block">
		<h3>Meta</h3>
		<ul>
			<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
			<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
			<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
			<li>今日访问：<?php echo $sta_cache['day_view_count']; ?></li>
			<li>总访问量：<?php echo $sta_cache['view_count']; ?></li>
            <?php if(ISLOGIN === true): ?>
				<li><a href="./adm/add_log.php">写日志</a></li>
				<li><a href="./adm/">管理中心</a></li>
				<li><a href="./index.php?action=logout" title="退出">退出</a></li>
            <?php else: ?>
            	<li><a href="./adm/" title="登陆">管理</a></li>
            <?php endif;?>
		</ul>
	</div>
		

</div>