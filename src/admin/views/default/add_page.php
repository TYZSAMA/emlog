<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<div class=containertitle><b>新建页面</b><span id="msg_2"></span></div><div id="msg"></div>
<div class=line></div>
  <form action="page.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b><br />
          <input maxlength="200" style="width:380px;" name="title" id="title"/>
	      <input name="date" id="date" type="hidden" value="" >
        </td>
        </tr>
        <tr>
          <td>
          <b>内容：</b> <a href="javascript: displayToggle('FrameUpload', 0);autosave(4);" class="thickbox">附件管理</a><span id="asmsg">
          <input type="hidden" name="as_logid" id="as_logid" value="-1"></span><br />
          <div id="FrameUpload" style="display: none;"><iframe width="720" height="160" frameborder="0" src="attachment.php?action=selectFile"></iframe></div>
          <input type="hidden" id="content" name="content" value="" style="display:none" />
          <input type="hidden" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
          <iframe src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>转向地址：</b>(如果填写，页面标题将指向该地址)<br />
          <input name="url" id="url" maxlength="200" style="width:715px;" /><br />
          </td>
        </tr>
        <tr>
          <td>页面是否接受评论？是
          <input type="radio" value="y" name="allow_remark" id="allow_remark" />否
          <input type="radio" checked="checked" value="n" name="allow_remark" id="allow_remark" />
          </td>
        </tr>
        <tr>
          <td>在新窗口打开页面？是
          <input type="radio" value="_blank" name="is_blank" id="is_blank" />否
          <input type="radio" checked="checked" value="_parent" name="is_blank" id="is_blank" />
          </td>
        </tr>
		<tr>
          <td align="center"><br>
          <input type="hidden" name="ishide" id="ishide" value="">
          <input type="submit" value="发布页面" onclick="return chekform();" class="button" />
          <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(3);" class="button" />
		  </td>
        </tr>
	</tbody>
	</table>
  </form>
<div class=line></div>