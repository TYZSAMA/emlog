// JavaScript Document
var attaIdx = 0;
var IsIE;
function add() {
	addfile("idfilespan",attaIdx);
	attaIdx++;
	return false;
}
function addfile(spanId,index)
{
       var strIndex = "" + index;
	   var fileId = "attachfile"+ strIndex;
	   var brId = "idAttachBr" + strIndex;
	   addInputFile(spanId,fileId);
	   addbr(spanId,brId);
	   return;
}
function addInputFile(spanId,fileId){
	  var span = document.getElementById(spanId);
	  if ( span !=null ) {

					var fileObj = document.createElement("input");
						if ( fileObj != null ) {
							fileObj.type="file";
							fileObj.name = "attach[]";
							fileObj.size="20";  
							fileObj.id="input";  
							span.appendChild(fileObj);
					}
					span.appendChild(document.createTextNode(" 描述："));
					var fileObj = document.createElement("input");
						if ( fileObj != null ) {
							fileObj.type="text";
							fileObj.name = "attdes[]";
							fileObj.size="25";
							fileObj.id="input";  
							span.appendChild(fileObj);
					}
	  }
}
function addbr(spanId,brId){
	  var span = document.getElementById(spanId);
	  if ( span !=null ) {
			var brObj = document.createElement("br");
				span.appendChild(brObj);
     }
	 return;
}
function chekform(){
	if (document.addlog.title.value==""){
	alert("日志标题不能为空");
	document.addlog.title.focus();
	return false;
	}else 
	return true;	
}
function inserttag (tag, taginputname) {
	var currenttag=tag;
	var targetinput=document.getElementById(taginputname);
	 if(targetinput.value=='')  {
		 var newvalue= currenttag;
			targetinput.value+=newvalue;
	 }else{
		var newvalue=','+currenttag;
		targetinput.value+=newvalue;
	}
}
function doshow(elementid) {
	if (document.getElementById('switch').checked) 
		document.getElementById(elementid).style.display='block';
	else 
		document.getElementById(elementid).style.display='none';
}
//删除确定
function isdel (id, property) {
	if (property==1) 	{
		var urlreturn="comment.php?action=del_comment&commentid="+id;
		var msg = "你确定要删除该评论吗？";
	} else if (property==2)  {
		var urlreturn="link.php?action=dellink&linkid="+id;
		var msg = "你确定要删除该友情站点吗？";
	} else if (property==3)  {
		var urlreturn="admin_log.php?action=delLog&gid="+id;
		var msg = "你确定要删除该篇日志吗？";
	} else if (property==4)  {
		var urlreturn="trackback.php?action=del_tb&tbid="+id;
		var msg = "你确定要删除该引用吗？";
	}else if (property==5)  {
		var urlreturn="backupdata.php?action=renewdata&sqlfile="+id;
		var msg = "你确定要导入该备份文件吗？";
	}else if (property==6)  {
		var urlreturn="attachment.php?action=del_attach&aid="+id;
		var msg = "你确定要删除该附件吗？";
	}else if (property==7)  {
		var urlreturn="blogger.php?action=delicon";
		var msg = "你确定要删除头像吗？";
	}else {
		var urlreturn="admin.php?go=entry_deletedraft_"+blogid+'';
	}
	if(confirm(msg)){
		window.location=urlreturn;
	}
	else {
		return;
	}
}
function addhtml(content){
	var oEditor = FCKeditorAPI.GetInstance('content');
	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG ) {
		oEditor.InsertHtml(content) ;
	} else {
		alert('请先转换到所见即所得模式') ;
	}
}
function addattach(imgurl,imgsrc,des,aid){
	addhtml('<a target=\"_blank\" href=\"'+imgurl+'\"><img src=\"'+imgsrc+'\" alt=\"附件[ematt:'+aid+'] '+des+'\" border=\"0\"></a>');
}

var xmlhttp = false;
var node = '';
function createxmlhttp() {//初始化、指定处理函数、发送请求的函数
	xmlhttp = false;
	//开始初始化XMLHttpRequest对象
	if(window.XMLHttpRequest) { //Mozilla 浏览器
		xmlhttp = new XMLHttpRequest();
		if (xmlhttp.overrideMimeType) {//设置MiME类别
			xmlhttp.overrideMimeType('text/xml');
		}
	}
	else if (window.ActiveXObject) { // IE浏览器
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!xmlhttp) { // 异常，创建对象实例失败
		window.alert("不能创建XMLHttpRequest对象实例.");
		return false;
	}
}
function sendinfo(url,nodeid){
	node = nodeid;
	document.getElementById(node).innerHTML = "<div><span style=\"background-color:#FF8000; color:#FFFFFF;\">处理中...请稍候!</span></div>";
	createxmlhttp();
	var querystring = url+ "&timetmp=" + new Date().getTime();;
	xmlhttp.open("GET", querystring, true);
	xmlhttp.send(null);
	xmlhttp.onreadystatechange = processRequest;
}
function postinfo(url,nodeid){
	node = nodeid;
	document.getElementById(node).innerHTML = "<div><span style=\"background-color:#FF8000; color:#FFFFFF;\">处理中...请稍候!</span></div>";
	createxmlhttp();
	var url2 = url + "&timetmp=" + new Date().getTime();
	xmlhttp.open("POST", url2, true);
	xmlhttp.onreadystatechange = processRequest;
	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
	var tw = document.getElementById("tw").value;
	var querystring = "tw=" + tw;
	xmlhttp.send(querystring);
}
function autosave(url,nodeid)
{
	node = nodeid;
	createxmlhttp();
	var url2 = url + "&timetmp=" + new Date().getTime();
	xmlhttp.open("POST", url2, true);
	xmlhttp.onreadystatechange = processRequest;
	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
	var title = document.getElementById("title").value;
	var logid = document.getElementById("as_logid").value;
	var oEditor = FCKeditorAPI.GetInstance('content');
	var content = oEditor.GetXHTML();
	var querystring = "content="+content+"&title="+title+"&as_logid="+logid;
	if(logid!=-2 && title!="" && content!="")
	{
		document.getElementById("auto_msg").innerHTML = "<span style=\"background-color:#FF8000; color:#FFFFFF;\">正在自动保存日志……!</span>";
		xmlhttp.send(querystring);
	}
	setTimeout("autosave('add_log.php?action=autosave','asmsg')",5000);
}
function processRequest() {
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
			var ret = xmlhttp.responseText;
			if(ret.substring(0,9) == "autosave_")
			{
				var logid = ret.substring(9);
				var iddiv = "<input type=hidden  name=as_logid id=as_logid value="+logid+">";
			}
			document.getElementById(node).innerHTML = iddiv;
			var digital = new Date();
			var hours = digital.getHours();
			var mins = digital.getMinutes();
			var secs = digital.getSeconds();
			document.getElementById("auto_msg").innerHTML = "<span style=\"background-color:#FF8000; color:#FFFFFF;\">草稿自动保存于 "+hours+":"+mins+":"+secs+" </span>";
		}
	}
}