<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>当前模板</b><?php if(isset($_GET['activated'])):?><span class="actived">模板更换成功</span><?php endif;?></div>
<div class=line></div>
<table cellspacing="10" cellpadding="0" width="80%" border="0">
    <tr>
      <td width="27%">
	  <img src="<?php echo $tpl_dir.$nonce_templet; ?>/preview.jpg" width="200" height="160"  border="1" />	  </td>
	  <td width="73%">
	  <?php echo $tplName; ?><br>
	  <?php echo $tplAuthor; ?><br>
	  <?php echo $tplDes; ?><br>
	  </td>
    </tr>
</table>
<div class=containertitle><b>可用模板</b></div>
<div class=line><span class="care" style="padding:0px 12px;">当前共有<?php echo $tplnums; ?>个可用模板 <a href="http://www.emlog.net" target="_blank">更多模板</a></span></div>
<table cellspacing="0" cellpadding="0" width="90%" border="0" class="adm_tpl_list">
<?php 
$i = 0;
foreach($tpls as $key=>$value):
if($i % 3 == 0){echo "<tr>";}
$i++;
?>
      <td align="center" width="300">
	  <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>">
	  <img alt="点击使用该模板" src="<?php echo $tpl_dir; ?><?php echo $value['tplfile']; ?>/preview.jpg" width="154" height="136" border="0" />
	  </a><br />
      <b><a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>" title="点击使用该模板"><?php echo $value['tplname']; ?></a></b><br />
      </td>
<?php 
if($i > 0 && $i % 3 == 0){echo "</tr>";}
endforeach; 
?>
</table>