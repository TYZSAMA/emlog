<?php 
/*
* 碎语部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="tw">
    <?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
    <div class="top"><a href="<?php echo BLOG_URL . 'admin/twitter.php' ?>">发布碎语</a></div>
    <?php endif; ?>
    <ul>
    <?php 
    foreach($tws as $val):
    $author = $user_cache[$val['author']]['name'];
    $avatar = empty($user_cache[$val['author']]['avatar']) ? '../admin/views/' . ADMIN_TPL . '/images/avatar.jpg' : '../' . $user_cache[$val['author']]['avatar'];
    $tid = (int)$val['id'];
    ?> 
    <li class="li">
    <div class="main_img"><img src="<?php echo $avatar; ?>" width="32px" height="32px" /></div>
    <p class="post1"><?php echo $author; ?><br /><?php echo $val['t'];?></p>
    <div class="clear"></div>
    <div class="bttome">
        <p class="post"><a href="javascript:loadr('<?php echo BLOG_URL; ?>t/?action=getr&tid=<?php echo $tid;?>','<?php echo $tid;?>');">回复(<span id="rn_<?php echo $tid;?>"><?php echo $val['replynum'];?></span>)</a></p>
        <p class="time"><?php echo $val['date'];?> </p>
    </div>
	<div class="clear"></div>
   	<ul id="r_<?php echo $tid;?>" class="r"></ul>
    <div class="huifu" id="rp_<?php echo $tid;?>">   
	<textarea id="rtext_<?php echo $tid; ?>"></textarea>
    <div>
        昵称：<input type="text" id="rname_<?php echo $tid; ?>" value="" /> 
        <span style="display:<?php if($reply_code == 'n'){echo 'none';}?>">验证码：<input type="text" id="rcode_<?php echo $tid; ?>" value="" /><?php echo $rcode; ?></span>
        <input class="button_p" type="button" onclick="reply('<?php echo BLOG_URL; ?>t/?action=reply',<?php echo $tid;?>);" value="回复" /> 
        <span id="rmsg_<?php echo $tid; ?>" style="color:#FF0000"></span>
    </div>
    </div>
    </li>
    <?php endforeach;?>
    </ul>
</div>
<?php
 include getViews('side');
 include getViews('footer');
?>