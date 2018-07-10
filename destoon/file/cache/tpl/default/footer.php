<?php defined('IN_DESTOON') or exit('Access Denied');?><div class="m b20" id="footb"></div>
<div class="m">
<div class="foot_page">
<a href="<?php echo $MODULE['1']['linkurl'];?>">网站首页</a> &nbsp;|&nbsp; 
<?php echo tag("table=webpage&condition=item=1&areaid=$cityid&order=listorder desc,itemid desc&template=list-webpage");?>
<a href="<?php echo $MODULE['1']['linkurl'];?>sitemap/">网站地图</a> &nbsp;|&nbsp; 
<a href="<?php echo $EXT['spread_url'];?>">排名推广</a> &nbsp;|&nbsp; 
<?php if($EXT['ad_enable']) { ?><a href="<?php echo $EXT['ad_url'];?>">广告服务</a> &nbsp;|&nbsp; <?php } ?>
<?php if($EXT['gift_enable']) { ?><a href="<?php echo $EXT['gift_url'];?>">积分换礼</a> &nbsp;|&nbsp; <?php } ?>
<?php if($EXT['guestbook_enable']) { ?><a href="<?php echo $EXT['guestbook_url'];?>">网站留言</a> &nbsp;|&nbsp; <?php } ?>
<?php if($EXT['feed_enable']) { ?><a href="<?php echo $EXT['feed_url'];?>">RSS订阅</a> &nbsp;|&nbsp; <?php } ?>
 <a href="javascript:SendReport();">违规举报</a>
<?php if($DT['icpno']) { ?> &nbsp;|&nbsp; <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $DT['icpno'];?></a><?php } ?>
</div>
</div>
<div class="m">
<div class="foot">
<div id="copyright"><?php echo $DT['copyright'];?></div>
<?php if(DT_DEBUG) { ?><div><?php echo debug();?></div><?php } ?>
<div id="powered"><a href="https://www.destoon.com/" target="_blank"><img src="<?php echo DT_STATIC;?>file/image/powered.gif" width="136" height="10" alt="Powered By DESTOON"/></a></div>
</div>
</div>
<div class="back2top"><a href="javascript:void(0);" title="返回顶部">&nbsp;</a></div>
<script type="text/javascript">
<?php if($destoon_task) { ?>
show_task('<?php echo $destoon_task;?>');
<?php } else { ?>
<?php include DT_ROOT.'/api/task.inc.php';?>
<?php } ?>
<?php if($lazy) { ?>$(function(){$("img").lazyload();});<?php } ?>
</script>
</body>
</html>