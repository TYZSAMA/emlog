<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<!--
<script type='text/javascript'>
$(document).ready(function(){
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
</script>
-->
<div class=containertitle><b>评论管理</b></div>
<div class=line></div>
<form action="comment.php?action=admin_all_coms" method="post" name="form" id="form">
  <table width="95%" id="adm_comment_list">
  	<thead>
      <tr class="rowstop">
        <td width="19"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="320"><b>评论内容</b></td>
        <td width="160"><b>评论者</b></td>
        <td width="150"><b>时间</b></td>
        <td width="150" colspan="3"></td>
      </tr>
    </thead>
    <tbody>
	<?php
	foreach($comment as $key=>$value):
	$ishide = $value['hide']=='y'?'<font color="red">[未审核]</font>':'';
	$isrp = $value['reply']?'<font color="green">[已回复]</font>':'';
	?>
     <tr>
        <td><input type="checkbox" value="" name="com[<?php echo $value['cid']; ?>]" /></td>
        <td><a href="comment.php?action=reply_comment&amp;cid=<?php echo $value['cid']; ?>&amp;hide=<?php echo $value['hide']; ?>"><?php echo $value['comment']; ?></a> <?php echo $ishide; ?> <?php echo $isrp; ?></td>
        <td><?php echo $value['poster']; ?></td>
        <td><?php echo $value['date']; ?></td>
        <td>
        <a href="comment.php?action=show_comment&amp;cid=<?php echo $value['cid']; ?>">审核</a>
        <a href="comment.php?action=hide_comment&amp;cid=<?php echo $value['cid']; ?>">屏蔽</a>
        <a href="javascript: isdel(<?php echo $value['cid']; ?>, 1);">删除</a>
		</td>
     </tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
      <tr class="rowstop">
        <td colspan="7">对选中的评论执行操作：
          <input type="radio" value="delcom" name="modall" />
          删除
          <input type="radio" value="hidecom" name="modall" />
          屏蔽
          <input type="radio" value="showcom" name="modall" />
          审核
      </tr>
	  <tr>
      	<td align="right" colspan="7">(共<?php echo $num; ?>条评论/每页最多显示15条) <?php echo $pageurl; ?></td>
      </tr>
	  <tr>
		  <td align="center" colspan="7">
		  <input type="submit" value="确 定" class="submit2" />
	      <input type="reset" value="重 置" class="submit2" />
		  </td>
	  </tr>
	 </tfoot>
  </table>
</form>