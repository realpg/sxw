<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<div class="m m3">
<div class="m3l">
<div class="top-l">
<?php if($MOD['page_islide']) { ?>
<?php echo tag("moduleid=$moduleid&condition=status=3 and level=2 and thumb!=''&areaid=$cityid&order=".$MOD['order']."&pagesize=".$MOD['page_islide']."&width=420&height=315&target=_blank&template=slide");?>
<?php } ?>
</div>
<div class="top-r">
<div class="headline">
<?php echo tag("moduleid=$moduleid&condition=status=3 and level=5&areaid=$cityid&order=".$MOD['order']."&pagesize=1&target=_blank&template=list-hl");?>
</div>
<div class="subline">
<?php echo tag("moduleid=$moduleid&condition=status=3 and level=1&areaid=$cityid&order=".$MOD['order']."&pagesize=8&datetype=2&target=_blank");?>
</div>
</div>
<div class="b16 c_b"></div>
<?php if($MOD['page_icat']) { ?>
<table cellpadding="0" cellspacing="0" width="100%">
<?php if(is_array($maincat)) { foreach($maincat as $i => $c) { ?>
<?php if($i%2==0) { ?><tr><?php } ?>
<td valign="top" width="420">
<div class="head-txt"><span><a href="<?php echo $MOD['linkurl'];?><?php echo $c['linkurl'];?>">更多<i>&gt;</i></a></span><strong><?php echo $c['catname'];?></strong></div>
<div class="list-txt"><?php echo tag("moduleid=$moduleid&catid=".$c['catid']."&condition=status=3&areaid=$cityid&order=".$MOD['order']."&pagesize=".$MOD['page_icat']."&datetype=2&target=_blank");?></div>
</td>
<?php if($i%2==0) { ?><td>&nbsp;</td><?php } ?>
<?php if($i%2==1) { ?></tr><?php } ?>
<?php } } ?>
</table>
<?php } ?>
</div>
<div class="m3r">
<div class="head-sub"><strong>点击排行</strong></div>
<div class="list-rank"><?php echo tag("moduleid=$moduleid&condition=status=3 and addtime>$today_endtime-1800*86400&areaid=$cityid&order=hits desc&key=hits&pagesize=9&template=list-rank");?></div>
<div class="head-sub"><strong>评论排行</strong></div>
<div class="list-rank"><?php echo tag("moduleid=$moduleid&condition=status=3 and addtime>$today_endtime-1800*86400&areaid=$cityid&order=comments desc&key=comments&pagesize=9&template=list-rank");?></div>
</div>
<div class="c_b"></div>
</div>
<?php include template('footer');?>