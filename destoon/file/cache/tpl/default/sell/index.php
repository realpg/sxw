<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<?php if($MOD['page_irec']) { ?>
<div class="m o_h">
<div class="head-txt"><span><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>?mid=<?php echo $moduleid;?>&action=add" target="_blank">发布<i>&gt;</i></a></span><strong>推荐<?php echo $MOD['name'];?></strong></div>
<div class="list-img list0"><?php echo tag("moduleid=$moduleid&condition=status=3 and thumb<>'' and level>0&areaid=$cityid&order=addtime desc&width=180&height=135&lazy=$lazy&pagesize=".$MOD['page_irec']."&template=list-thumb");?></div>
</div>
<?php } ?>
<div class="m m3">
<div class="m3l o_h">
<div class="head-txt"><strong>按地区浏览</strong></div>
<div class="list-area">
<?php $mainarea = get_mainarea(0)?>
<ul>
<?php if(is_array($mainarea)) { foreach($mainarea as $k => $v) { ?>
<li><a href="<?php echo $MOD['linkurl'];?><?php echo rewrite('search.php?areaid='.$v['areaid']);?>"><?php echo $v['areaname'];?></a></li>
<?php } } ?>
</ul>
<div class="c_b"></div>
</div>
<div class="head-txt"><strong>按行业浏览</strong></div>
<div class="list-cate">
<?php $mid = $moduleid;?>
<?php include template('catalog', 'chip');?>
</div>
</div>
<div class="m3r">
<?php if($MOD['page_inew']) { ?>
<div class="head-sub"><strong>最新发布</strong></div>
<div class="list-txt">
<?php echo tag("moduleid=$moduleid&condition=status=3&areaid=$cityid&datetype=2&pagesize=".$MOD['page_inew']."&order=addtime desc");?>
</div>
<?php } ?>
<?php if($MOD['page_iedit']) { ?>
<div class="head-sub"><strong>最新更新</strong></div>
<div class="list-txt">
<?php echo tag("moduleid=$moduleid&condition=status=3&areaid=$cityid&datetype=2&pagesize=".$MOD['page_iedit']."&order=edittime desc");?>
</div>
<?php } ?>
<?php if($MOD['page_ihits']) { ?>
<div class="head-sub"><strong>点击排行</strong></div>
<div class="list-rank"><?php echo tag("moduleid=$moduleid&condition=status=3 and addtime>$today_endtime-1800*86400&areaid=$cityid&order=hits desc&key=hits&pagesize=".$MOD['page_ihits']."&template=list-rank");?></div>
<?php } ?>
</div>
<div class="c_b"></div>
</div>
<?php include template('footer');?>