<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2"><a class="navi3" href="./configure.php">基本设置</a><a class="navi4" href="./permalink.php">固定链接</a><a class="navi4" href="./blogger.php">个人资料</a>
<?php if(isset($_GET['activated'])):?><span class="actived">设置保存成功</span><?php endif;?>
</div>
<form action="configure.php?action=mod_config" method="post" name="input" id="input">
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
    <tbody>
      <tr nowrap="nowrap">
        <td width="18%" align="right">博客名称：</td>
        <td width="82%"><input maxlength="200" size="35" value="<?php echo $blogname; ?>" name="blogname" /></td>
      </tr>
      <tr nowrap="nowrap">
        <td align="right" valign="top">博客描述：</td>
        <td><textarea name="bloginfo" cols="" rows="3" style="width:300px;"><?php echo $bloginfo; ?></textarea></td>
      </tr>
      <tr nowrap="nowrap">
        <td align="right">博客地址：</td>
        <td class="care"><input maxlength="200" size="35" value="<?php echo $blogurl; ?>" name="blogurl" /></td>
      </tr>
      <tr nowrap="nowrap">
        <td align="right">博客关键字：</td>
        <td><input maxlength="200" size="35" value="<?php echo $site_key; ?>" name="site_key" />
        (关键字之间用半角逗号","隔开)</td>
      </tr>
      <tr nowrap="nowrap">
        <td align="right">ICP备案号：</td>
        <td><input maxlength="200" size="35" value="<?php echo $icp; ?>" name="icp" /></td>
      </tr>
      <tr nowrap="nowrap">
        <td align="right">每页日志数：</td>
        <td><input maxlength="5" size="10" value="<?php echo $index_lognum; ?>" name="index_lognum" /></td>
      </tr>
	  <tr>
        <td valign="top" align="right">你所在时区：<br /></td>
        <td>
		<select name="timezone">
<?php
		$tzlist = array('-12'=>'(标准时-12) 日界线西',
							'-11'=>'(标准时-11) 中途岛、萨摩亚群岛',
							'-10'=>'(标准时-10) 夏威夷',
							'-9'=>'(标准时-9) 阿拉斯加',
							'-8'=>'(标准时-8) 太平洋时间(美国和加拿大)',
							'-7'=>'(标准时-7) 山地时间(美国和加拿大)',
							'-6'=>'(标准时-6) 中部时间(美国和加拿大)、墨西哥城',
							'-5'=>'(标准时-5) 东部时间(美国和加拿大)、波哥大',
							'-4'=>'(标准时-4) 大西洋时间(加拿大)、加拉加斯',
							'-3.5'=>'(标准时-3:30) 纽芬兰',
							'-3'=>'(标准时-3) 巴西、布宜诺斯艾利斯、乔治敦',
							'-2'=>'(标准时-2) 中大西洋',
							'-1'=>'(标准时-1) 亚速尔群岛、佛得角群岛',
							'0'=>'(标准时) 西欧时间、伦敦、卡萨布兰卡',
							'1'=>'(标准时+1) 中欧时间、安哥拉、利比亚',
							'2'=>'(标准时+2) 东欧时间、开罗，雅典',
							'3'=>'(标准时+3) 巴格达、科威特、莫斯科',
							'3.5'=>'(标准时+3:30) 德黑兰',
							'4'=>'(标准时+4) 阿布扎比、马斯喀特、巴库',
							'4.5'=>'(标准时+4:30) 喀布尔',
							'5'=>'(标准时+5) 叶卡捷琳堡、伊斯兰堡、卡拉奇',
							'5.5'=>'(标准时+5:30) 孟买、加尔各答、新德里',
							'6'=>'(标准时+6) 阿拉木图、 达卡、新亚伯利亚',
							'7'=>'(标准时+7) 曼谷、河内、雅加达',
							'8'=>'(标准时+8) 北京、重庆、香港、新加坡',
							'9'=>'(标准时+9) 东京、汉城、大阪、雅库茨克',
							'9.5'=>'(标准时+9:30) 阿德莱德、达尔文',
							'10'=>'(标准时+10) 悉尼、关岛',
							'11'=>'(标准时+11) 马加丹、索罗门群岛',
							'12'=>'(标准时+12) 奥克兰、惠灵顿、堪察加半岛',
		);
foreach($tzlist as $key=>$value):
$ex = $key==$timezone?"selected=\"selected\"":'';
?>
		<option value="<?php echo $key; ?>" <?php echo $ex; ?>><?php echo $value; ?></option>
<?php endforeach;?>
        </select>
        (本地时间：<?php echo gmdate('Y-d-n H:i:s', $utctimestamp + $timezone * 3600); ?>)
        </td>
      </tr>
      <tr>
        <td align="right">开启评论审核：<br /></td>
        <td>
		<select name="ischkcomment">
          <option value="y" <?php echo $ex5; ?>>是</option>
          <option value="n" <?php echo $ex6; ?>>否</option>
        </select>
		</td>
      </tr>
	  <tr>
        <td align="right">开启引用通告：<br /></td>
        <td>
		<select name="istrackback">
          <option value="y" <?php echo $ex7; ?>>是</option>
          <option value="n" <?php echo $ex8; ?>>否</option>
        </select>
		</td>
      </tr>
      <tr>
        <td align="right">开启登录验证码：<br /></td>
        <td class="care">
        <select name="login_code">
          <option value="y" <?php echo $ex1; ?>>是</option>
          <option value="n" <?php echo $ex2; ?>>否</option>
        </select>
        </td>
      </tr>
      <tr>
        <td align="right">开启评论验证码：<br /></td>
        <td>
        <select name="comment_code">
          <option value="y" <?php echo $ex3; ?>>是</option>
          <option value="n" <?php echo $ex4; ?>>否</option>
        </select>
        </td>
      </tr>
      <tr>
        <td align="right">开启页面Gzip压缩：<br /></td>
        <td class="care">
		<select name="isgzipenable">
          <option value="y" <?php echo $ex11; ?>>是</option>
          <option value="n" <?php echo $ex12; ?>>否</option>
        </select>
		</td>
      </tr>
	  <tr>
        <td align="right">开启离线写作支持：<br /></td>
        <td class="care">
		<select name="isxmlrpcenable">
          <option value="y" <?php echo $ex13; ?>>是</option>
          <option value="n" <?php echo $ex14; ?>>否</option>
        </select>
		</td>
      </tr>
      <tr>
        <td align="center" colspan="2"><input type="submit" value="保存设置" class="button" /></td>
      </tr>
    </tbody>
  </table>
</form>