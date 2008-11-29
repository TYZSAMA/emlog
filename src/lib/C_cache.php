<?php
/**
 * 生成文本缓存类
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id$
 */


class mkcache {

	var $dbhd;
	var $db_prefix;

	function mkcache($dbhandle, $db_prefix)
	{
		$this->dbhd = $dbhandle;
		$this->db_prefix = $db_prefix;
	}
	/**
	 * 站点配置缓存
	 */
	function mc_options()
	{
		$options_cache = array();
		$res = $this->dbhd->query("SELECT * FROM ".$this->db_prefix."options");
		while($row = $this->dbhd->fetch_array($res))
		{
			if(in_array($row['option_name'],array('site_key', 'blogname', 'bloginfo', 'blogurl', 'icp')))
			{
				$row['option_value'] = htmlspecialchars($row['option_value']);
			}
			$options_cache[$row['option_name']] = $row['option_value'];
		}
		$cacheData = serialize($options_cache);
		$this->cacheWrite($cacheData,'options');
	}
	/**
	 * 个人资料缓存
	 */
	function mc_blogger()
	{
		$blogger = $this->dbhd->once_fetch_array("select * from ".$this->db_prefix."user ");
		$icon = '';
		if($blogger['photo'])
		{
			$photosrc = substr($blogger['photo'],3);
			$imgsize = chImageSize($blogger['photo'],ICON_MAX_W,ICON_MAX_H);
			$icon = "<img src=\"".htmlspecialchars($photosrc)."\" width=\"{$imgsize['w']}\" height=\"{$imgsize['h']}\" alt=\"blogger\" />";
		}
		$user_cache = array(
		'photo' => $icon,
		'name' =>htmlspecialchars($blogger['nickname']),
		'mail'	=>htmlspecialchars($blogger['email']),
		'des'=>$blogger['description']
		);
		$cacheData = serialize($user_cache);
		$this->cacheWrite($cacheData,'blogger');
	}
	/**
	 * 博客统计缓存
	 */
	function mc_sta()
	{
		$dh = $this->dbhd->once_fetch_array("select * from ".$this->db_prefix."statistics");
		$lognum = $this->dbhd->num_rows($this->dbhd->query("SELECT gid FROM ".$this->db_prefix."blog WHERE hide='n' "));
		$comnum = $this->dbhd->num_rows($this->dbhd->query("SELECT cid FROM ".$this->db_prefix."comment WHERE hide='n' "));
		$tbnum = $this->dbhd->num_rows($this->dbhd->query("SELECT gid FROM ".$this->db_prefix."trackback "));
		$twnum = $this->dbhd->num_rows($this->dbhd->query("SELECT id FROM ".$this->db_prefix."twitter "));
		$hidecom = $this->dbhd->num_rows($this->dbhd->query("SELECT gid FROM ".$this->db_prefix."comment where hide='y' "));

		$sta_cache = array(
		'day_view_count' => $dh['day_view_count'],
		'view_count' =>$dh['view_count'],
		'lognum'=>$lognum,
		'comnum'=>$comnum,
		'twnum'=>$twnum,
		'hidecom'=>$hidecom,
		'tbnum'=>$tbnum
		);
		$cacheData = serialize($sta_cache);
		$this->cacheWrite($cacheData,'sta');
	}
	/**
	 * 最新评论缓存
	 */
	function mc_comment()
	{
		$show_config=$this->dbhd->fetch_array($this->dbhd->query("SELECT option_value FROM ".$this->db_prefix."options where option_name='index_comnum'"));
		$index_comnum = $show_config['option_value'];
		$show_config=$this->dbhd->fetch_array($this->dbhd->query("SELECT option_value FROM ".$this->db_prefix."options where option_name='comment_subnum'"));
		$comment_subnum = $show_config['option_value'];
		$query=$this->dbhd->query("SELECT cid,gid,comment,date,poster,reply FROM ".$this->db_prefix."comment WHERE hide='n' ORDER BY cid DESC LIMIT 0, $index_comnum ");
		$com_cache = array();
		while($show_com=$this->dbhd->fetch_array($query))
		{
			$com_cache[] = array(
			'url' => "index.php?action=showlog&gid={$show_com['gid']}#{$show_com['cid']}",
			'name' => htmlspecialchars($show_com['poster']),
			'content' => htmlClean2(subString($show_com['comment'],0,$comment_subnum)),
			'reply' => $show_com['reply']
			);
		}
		$cacheData = serialize($com_cache);
		$this->cacheWrite($cacheData,'comments');
	}
	/**
	 * 侧边栏标签缓存
	 */
	function mc_tags()
	{
		$tag_cache = array();
		$query=$this->dbhd->query("SELECT max(usenum),min(usenum),count(*) FROM ".$this->db_prefix."tag");
		$row = $this->dbhd->fetch_row($query);
		$maxuse = $row[0];
		$minuse = $row[1];
		$tagnum = $row[2];
		$spread = ($tagnum>12?12:$tagnum);
		$rank = $maxuse-$minuse;
		$rank = ($rank==0?1:$rank);
		$rank = $spread/$rank;
		$query=$this->dbhd->query("SELECT tagname,usenum FROM ".$this->db_prefix."tag");
		while($show_tag = $this->dbhd->fetch_array($query))
		{
			//maxfont:22pt,minfont:10pt
			$fontsize=10+round(($show_tag['usenum']-$minuse)*$rank);
			$tag_cache[] = array(
			'tagurl' => urlencode($show_tag['tagname']),
			'tagname' => htmlspecialchars($show_tag['tagname']),
			'fontsize' => $fontsize,
			'usenum' => $show_tag['usenum']
			);
		}
		$cacheData = serialize($tag_cache);
		$this->cacheWrite($cacheData,'tags');
	}
	/**
	 * 侧边栏分类缓存
	 */
	function mc_sort()
	{
		$sort_cache = array();
		$query = $this->dbhd->query("SELECT sid,sortname FROM ".$this->db_prefix."sort ORDER BY taxis ASC");
		while($row = $this->dbhd->fetch_array($query))
		{
			$logNum = $this->dbhd->num_rows($this->dbhd->query("SELECT sortid FROM ".$this->db_prefix."blog WHERE sortid=".$row['sid']." AND hide='n' "));
			$sort_cache[] = array(
			'lognum' => $logNum,
			'sortname' => htmlspecialchars($row['sortname']),
			'sid' => intval($row['sid'])
			);
		}
		$cacheData = serialize($sort_cache);
		$this->cacheWrite($cacheData,'sort');
	}
	/**
	 * 友站缓存
	 */
	function mc_link()
	{
		$link_cache = array();
		$query=$this->dbhd->query("SELECT siteurl,sitename,description FROM ".$this->db_prefix."link ORDER BY taxis ASC");
		while($show_link=$this->dbhd->fetch_array($query))
		{
			$link_cache[] = array(
			'link'=>htmlspecialchars($show_link['sitename']),
			'url'=>htmlspecialchars($show_link['siteurl']),
			'des'=>htmlspecialchars($show_link['description'])
			);
		}
		$cacheData = serialize($link_cache);
		$this->cacheWrite($cacheData,'links');
	}
	/**
	 * twitter缓存
	 */
	function mc_twitter()
	{
		$show_config=$this->dbhd->fetch_array($this->dbhd->query("SELECT option_value FROM ".$this->db_prefix."options where option_name='index_twnum'"));
		$index_twnum = $show_config['option_value']+1;
		$query=$this->dbhd->query("SELECT * FROM ".$this->db_prefix."twitter ORDER BY id DESC LIMIT $index_twnum");
		$tw_cache = array();
		while($show_tw=$this->dbhd->fetch_array($query))
		{
			$tw_cache[] = array(
			'content' => htmlspecialchars($show_tw['content']),
			'date' => $show_tw['date'],
			'id' => $show_tw['id']
			);
		}
		$cacheData = serialize($tw_cache);
		$this->cacheWrite($cacheData,'twitter');
	}

	/**
	 * 最新日志
	 */
	function mc_newlog()
	{
		$row = $this->dbhd->fetch_array($this->dbhd->query("SELECT option_value FROM ".$this->db_prefix."options where option_name='index_newlognum'"));
		$index_newlognum = $row['option_value'];
		$sql = "SELECT gid,title FROM ".$this->db_prefix."blog WHERE hide='n' ORDER BY gid DESC LIMIT 0, $index_newlognum";
		$res = $this->dbhd->query($sql);
		$logs = array();
		while($row = $this->dbhd->fetch_array($res))
		{
			$row['gid'] = intval($row['gid']);
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		$cacheData = serialize($logs);
		$this->cacheWrite($cacheData,'newlogs');
	}

	/**
	 * 日志归档缓存
	 */
	function mc_record()
	{
		global $isurlrewrite;
		$query=$this->dbhd->query("select date from ".$this->db_prefix."blog WHERE hide='n' ORDER BY date DESC");
		$record='xxxx_x';
		$p = 0;
		$lognum = 1;
		$dang_cache = array();
		while($show_record=$this->dbhd->fetch_array($query))
		{
			$f_record=date('Y_n',$show_record['date']);
			if ($record!=$f_record){
				$h = $p-1;
				if($h!=-1)
				{
					$dang_cache[$h]['lognum'] = $lognum;
				}
				if($isurlrewrite == 'y')
				{
					$dang_cache[$p] = array(
					'record'=>date("Y年n月",$show_record['date']),
					'url'=>"record-".date("Ym",$show_record['date']).".html"
					);
				}else{
					$dang_cache[$p] = array(
					'record'=>date("Y年n月",$show_record['date']),
					'url'=>"index.php?record=".date("Ym",$show_record['date'])
					);
				}
				$p++;
				$lognum = 1;
			}else{
				$lognum++;
				continue;
			}
			$record=$f_record;
		}
		$j = $p-1;
		if($j>=0)
		{
			$dang_cache[$j]['lognum'] = $lognum;
		}

		$cacheData = serialize($dang_cache);
		$this->cacheWrite($cacheData,'records');
	}
	/**
	 * 日志标签缓存
	 */
	function mc_logtags()
	{
		$sql="SELECT gid FROM ".$this->db_prefix."blog ORDER BY top DESC ,date DESC";
		$query1=$this->dbhd->query($sql);
		$log_cache_tags = array();
		while($show_log=$this->dbhd->fetch_array($query1))
		{
			$tag = '';
			$gid = $show_log['gid'];
			//tag
			$tquery = "SELECT tagname FROM ".$this->db_prefix."tag WHERE gid LIKE '%,$gid,%' " ;
			$result = $this->dbhd->query($tquery);
			$tagnum = $this->dbhd->num_rows($result);
			if($tagnum>0)
			{
				while($show_tag=$this->dbhd->fetch_array($result))
				{
					$tag .= "	<a href=\"./?tag=".urlencode($show_tag['tagname'])."\">".htmlspecialchars($show_tag['tagname']).'</a>';
				}
			}else{
				$tag = '';
			}
			$log_cache_tags[$show_log['gid']] = $tag;
			unset($tag);
		}
		$cacheData = serialize($log_cache_tags);
		$this->cacheWrite($cacheData,'log_tags');
	}
	/**
	 * 日志分类缓存
	 */
	function mc_logsort()
	{
		$sql = "SELECT gid,sortid FROM ".$this->db_prefix."blog ORDER BY top DESC ,date DESC";
		$query = $this->dbhd->query($sql);
		$log_cache_sort = array();
		while($row = $this->dbhd->fetch_array($query))
		{
			if($row['sortid'] > 0)
			{
				$res = $this->dbhd->query("SELECT sortname FROM ".$this->db_prefix."sort where sid=".$row['sortid']);
				$srow = $this->dbhd->fetch_array($res);
				$sortName = $srow['sortname'];
			}else {
				$sortName = '';
			}
			$log_cache_sort[$row['gid']] = $sortName;
			unset($tag);
		}
		$cacheData = serialize($log_cache_sort);
		$this->cacheWrite($cacheData,'log_sort');
	}
	/**
	 * 日志附件缓存
	 */
	function mc_logatts()
	{
		$sql = "SELECT gid FROM ".$this->db_prefix."blog ORDER BY top DESC ,date DESC";
		$query = $this->dbhd->query($sql);
		$log_cache_atts = array();
		while($row = $this->dbhd->fetch_array($query))
		{
			$gid = $row['gid'];
			$attachment = '';
			//attachment
			$attQuery = $this->dbhd->query("SELECT * FROM ".$this->db_prefix."attachment WHERE blogid=$gid ");
			while($show_attach = $this->dbhd->fetch_array($attQuery))
			{
				$att_path = $show_attach['filepath'];//eg: ../uploadfile/200710/b.jpg
				$atturl = substr($att_path,3);//eg: uploadfile/200710/b.jpg
				$postfix = strtolower(substr(strrchr($show_attach['filename'], "."),1));
				if(!in_array($postfix, array('jpg', 'jpeg', 'gif', 'png')))
				{
					$file_atturl = $atturl;
					$attachment .= "<br /><a href=\"$file_atturl\" target=\"_blank\">{$show_attach['filename']}</a>\t".changeFileSize($show_attach['filesize']);
				}
			}
			$log_cache_atts[$gid] = $attachment;
			unset($attachment);
		}
		$cacheData = serialize($log_cache_atts);
		$this->cacheWrite($cacheData,'log_atts');
	}

	/**
	 * 写入缓存
	 */
	function cacheWrite ($cacheDate,$cachefile)
	{
		$cachefile = EMLOG_ROOT.'/content/cache/'.$cachefile;
		@ $fp = fopen($cachefile, 'wb') OR sysMsg('打开缓存文件失败，请查看文件权限');
		@ $fw =	fwrite($fp,$cacheDate) OR sysMsg('写入缓存失败，请查看文件权限');
		fclose($fp);
	}

	/**
	 * 读取缓存文件
	 */
	function readCache($cachefile)
	{
		$cachefile = EMLOG_ROOT.'/content/cache/'.$cachefile;
		if(@$fp = fopen($cachefile, 'r'))
		{
			@$data = fread($fp,filesize($cachefile));
			fclose($fp);
		}
		return unserialize($data);
	}
}
?>