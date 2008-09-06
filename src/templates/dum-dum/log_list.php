<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="content">
<img src="<?php echo $em_tpldir; ?>/images/img_08.jpg" alt="" />
	<div class="contenttext">
<?php 
foreach($logs as $value):
$datetime = explode("-",$value['post_time']);
$year = $datetime['0'];
$day = substr($datetime['2'],0,2)."/".$datetime['1'];
?>

		<div class="post" id="post-<?php echo $value['logid']; ?>">
			<div class="postheader">
				<div class="postdate">
					<div class="postday"><?php echo $day; ?></div> <!-- POST DAY -->
					<div class="postmonth"><?php echo $year; ?></div> <!-- POST MONTH -->
				</div> <!-- POST DATE -->
				
				<div class="posttitle">
					<h3><?php echo $value['toplog']; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h3>
				</div> <!-- POST TITLE -->

				<div class="postmeta">
					<div class="postauthor">by <?php echo $name; ?></div> <!-- POST AUTHOR -->
					<div class="postcategory"><?php echo $value['tag']; ?></div> <!-- POST CATEGORY -->
				</div> <!-- POST META -->
			</div> <!-- POST HEADER -->
			<div style=" clear:both;"></div>
			<div class="posttext">
				<?php echo $value['log_description']; ?>
			</div> <!-- POST TEXT -->
			<div style="clear:both;"></div>
			<div class="postfooter" style="">
				<div class="postcomments"><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论：(<?php echo $value['comnum']; ?>)</a></div> <!-- POST COMMENTS -->
				<div class="posttags"><div class="posttags2"><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> </div> <!-- POST TAGS 2 --></div> <!-- POST TAGS -->
				<div class="postnr"><div class="postnrtext"><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>" title="浏览：<?php echo $value['views']; ?> 次"><?php echo $value['views']; ?></a></div> <!-- POST NR TEXT --></div> <!-- POST NR -->
			</div> <!-- POST FOOTER -->
		</div> <!-- POST -->
		<?php endforeach; ?>
	<div class="postcategory"><?php echo $page_url;?></div>
	</div> <!-- CONTENT TEXT -->
<img src="<?php echo $em_tpldir; ?>/images/img_09.jpg" style="vertical-align: bottom;" alt="" />
</div> <!-- CONTENT -->

<?php
include getViews('side'); 
include getViews('footer');
?>