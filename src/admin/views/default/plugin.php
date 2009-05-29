<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<div class=containertitle><b>插件管理</b><div id="msg"></div>
<?php if(isset($_GET['active'])):?><span class="actived">插件激活成功</span><?php endif;?>
<?php if(isset($_GET['inactive'])):?><span class="actived">插件禁用成功</span><?php endif;?>
</div>
<div class=line></div>
<form action="trackback.php?action=dell_all_tb" method="post">
  <table width="100%" id="adm_plugin_list">
  <thead>
      <tr class="rowstop">
        <td width="100"></td>
        <td width="36" align="center"><b>状态</b></td>
		<td width="30" align="center"><b>版本</b></td>
		<td width="500"><b>描述</b></td>
      </tr>
  </thead>
  <tbody>
	<?php 
	$i = 0;
	foreach($plugins as $key=>$val):
		$plug_state = 'inactive';
		$plug_action = 'active';
		$plug_state_des = '未激活';
		if (in_array($key, $active_plugins))
		{
			$plug_state = 'active';
			$plug_action = 'inactive';
			$plug_state_des = '已激活';
		}
		$i++;
	?>	
      <tr>
        <td align="center"><b><?php echo $val['Name']; ?></b></td>
		<td align="center" id="plugin_<?php echo $i;?>">
		<a href="./plugin.php?action=<?php echo $plug_action;?>&plugin=<?php echo $key;?>"><img src="./views/<?php echo ADMIN_TPL; ?>/images/plugin_<?php echo $plug_state; ?>.gif" title="<?php echo $plug_state_des; ?>" align="absmiddle" border="0"></a>
		</td>
        <td align="center"><?php echo $val['Version']; ?></td>
        <td>
		<?php echo $val['Description']; ?>
		<?php if ($val['Url'] != ''):?><a href="<?php echo $val['Url'];?>" target="_blank">插件主页&raquo;</a><?php endif;?>
		<br />
		<?php if ($val['Author'] != ''):?>
		作者：
			<?php if ($val['Email'] != ''):?>
			<a href="mailto:<?php echo $val['Email'];?>"><?php echo $val['Author'];?></a>
			<?php else:?>
			<?php echo $val['Author'];?>
			<?php endif;?>
		<?php endif;?>
		<?php if ($val['AuthorUrl'] != ''):?>，<a href="<?php echo $val['AuthorUrl'];?>" target="_blank">作者主页&raquo;</a><?php endif;?>
		</td>
      </tr>
	<?php endforeach; ?>
	</tbody>
  </table>
</form>
<div style="margin:30px 0px 10px 3px;"><a href="http://www.emlog.net/extend/plugins" target="_blank">获取更多插件&raquo;</a></div>
<script type='text/javascript'>
$("#adm_plugin_list tbody tr:odd").addClass("tralt_b");
$("#adm_plugin_list tbody tr")
	.mouseover(function(){$(this).addClass("trover")})
	.mouseout(function(){$(this).removeClass("trover")})
setTimeout(hideActived,2600);
$("#menu_plug").addClass('sidebarsubmenu1');
</script>