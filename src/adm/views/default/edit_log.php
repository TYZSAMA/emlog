<!--
<?php
if(!defined('ADM_ROOT')) {exit('error!');}
$maxsize = changeFileSize($uploadmax);
$att_type_str = '';
foreach ($att_type as $val){
	$att_type_str .= " $val";
}
print <<<EOT
-->
<script>
setTimeout("autosave('add_log.php?action=autosave','asmsg')",30000);
</script>
<div class=containertitle><b>编辑日志</b></div>
<div class=line></div>
  <form action="admin_log.php?action=edit" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b><br />
          <input maxlength="200" style="width:460px;" name="title" id="title" value="$title"/></td>
        </tr>
<!--
if($attach)
$anyatt = '<b>附件:</b><br />';
}print <<<EOT
-->
        <tr>
          <td>
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tr>
                    <td><p>
					<b>内容：</b> <span id="asmsg"><input type="hidden" name="as_logid" id="as_logid" value="$as_logid"></span><span id="auto_msg"></span><br />
                    <input type="hidden" id="content" name="content" value="{$content}" style="display:none" />
                    <iframe id="content___Frame" src="./editor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" style="width:680px;" height="450" frameborder="no" scrolling="no"></iframe>              
                      </p>
                    </td>
                  </tr>
        </table>        </tr>
        <tr nowrap="nowrap">
          <td><b>标签:</b>(Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签)<br />
            <input id="tags" maxlength="200" style="width:675px;" name="tag" value="$tag" /><br /><div style="width:675px;">选择已有标签：$oldtags</div></td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>引用通告：</b>(Trackback，通知你所引用的日志)<br />
          <textarea name="pingurl" cols="" rows="3" style="width:675px;" onclick="if (this.value=='每行输入一个引用地址') this.value='';">每行输入一个引用地址</textarea>
          </td>
        </tr>
        <tr>
          <td><b>更改发布时间</b>
            <input id="switch" onclick="doshow('changedate');" type="checkbox" value="1" name="edittime" />
              <br />
              <div style="clear:both; display: none;" id="changedate">
			  <input name="newyear" type="text" value="$year" maxlength="" size="2"> 年 
			  <input name="newmonth" type="text" value="$month" maxlength="2" size="1"> 月 
			  <input name="newday" type="text" value="$day" maxlength="2" size="1"> 日 
			  <input name="newhour" type="text" value="$hour" maxlength="2" 	size="1"> 时
			  <input name="newmin" type="text" value="$minute" maxlength="2" size="1"> 分 
			  <input name="newsec" type="text" value="$second" maxlength="2" size="1"> 秒
			  <input name="date" type="hidden" value="$adddate" >
		  <br />请正确填写各参数,如果参数错误将仍使用当前服务器时间! 范例:2006年01月08日08时06分01秒 (24小时制)</div></td>
        </tr>
    </table>
	<table cellspacing="1" cellpadding="4" width="95%" align="center" border="0" class="attlist">
<!--
EOT;
if($attach)
foreach($attach as $key=>$value){
$extension  = strtolower(substr(strrchr($value[filepath], "."),1));
$atturl = $blogurl.substr(str_replace('thum-','',$value[filepath]),3);
if($extension == 'zip' || $extension == 'rar'){
	$imgpath = "./views/$nonce_tpl/images/tar.gif";
	$embedlink = '压缩包';
}elseif ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
	$imgpath = $value['filepath'];
	$ed_imgpath = $blogurl.substr($imgpath,3);
	$embedlink = "<a href=\"javascript: addattach('$atturl','$ed_imgpath','$value[attdes]',$value[aid]);\">嵌入到日志 </a>";
}else {
	$imgpath = "./views/$nonce_tpl/images/fnone.gif";
	$embedlink = '';
}
print <<<EOT
-->
<tr>
	<td width="8%" rowspan="2" >
		<a href="$atturl" target="_blank"><img src="$imgpath" width="60" height="60" border="0"/></a>
	</td>
</tr>
<tr>
	<td width="92%" >$value[filename] ($value[attsize])<br />描述： 
		<input type="text" name="attachdes[{$value[aid]}]" value="$value[attdes]" />
		<br />操作：<a href="javascript: isdel($value[aid], 6);">删除</a> $embedlink 
	</td>
</tr>
<!--
EOT;
}print <<<EOT
-->
	  </table>
	  <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
        <tr>
          <td><b>上传附件</b><a id="attach" title="增加附件" onclick="add()" href="javascript:;" name="attach">[+]</a> (最大允许{$maxsize}，支持类型:{$att_type_str})<br />
            <div id="tab_attach">
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                </tbody>
              </table>
            </div>
          <span id="idfilespan"></span></td></tr>
        <tr>
          <td>接受评论？是
              <input type="radio" checked="checked" value="y" name="allow_remark" $ex/>
            否
          <input type="radio" value="n" name="allow_remark" $ex2 /></td>
        </tr>
        <tr>
          <td>接受引用？是
              <input type="radio" checked="checked" value="y" name="allow_tb" $add />
            否
          <input type="radio" value="n" name="allow_tb" $add2 /></td>
        </tr>
        <tr>
          <td align="center" colspan="2">
		  <input type="hidden" name="gid" value=$logid>
		  	 <input type="submit" value="保存日志" onclick="return chekform();" class="submit2" />
		  </td>
        </tr>
      </tbody>
    </table>
  </form>
  <div class=line></div>
<!--
EOT;
?>-->
