<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<div class="m">
<div class="nav bd-b"><a href="<?php echo $MODULE['1']['linkurl'];?>">首页</a> <i>&gt;</i> <a href="<?php echo $MOD['linkurl'];?>"><?php echo $MOD['name'];?></a> <i>&gt;</i> <?php echo cat_pos($CAT, ' <i>&gt;</i> ');?></div>
</div>
<div class="m m2">
<div class="m2l">
<div class="sort">
<div class="sort-k">行业</div>
<div class="sort-v">
<ul>
<?php if(is_array($maincat)) { foreach($maincat as $k => $v) { ?>
<li<?php if($v['catid']==$catid) { ?> class="on"<?php } ?>
><a href="<?php echo $MOD['linkurl'];?><?php echo $v['linkurl'];?>"><?php echo set_style($v['catname'],$v['style']);?></a><?php if(!$cityid) { ?> <i>(<?php echo $v['item'];?>)</i><?php } ?>
<li>
<?php } } ?>
</ul>
</div>
<div class="c_b"></div>
</div>
<div class="sort">
<div class="sort-k">地区</div>
<div class="sort-v">
<ul>
<?php $mainarea = get_mainarea(0)?>
<?php if(is_array($mainarea)) { foreach($mainarea as $k => $v) { ?>
<li><a href="<?php echo $MOD['linkurl'];?><?php echo rewrite('search.php?catid='.$catid.'&areaid='.$v['areaid']);?>"><?php echo $v['areaname'];?></a></li>
<?php } } ?>
</ul>
</div>
<div class="c_b"></div>
</div>
<?php if($TYPE) { ?>
<div class="sort">
<div class="sort-k">类别</div>
<div class="sort-v">
<ul>
<?php if(is_array($TYPE)) { foreach($TYPE as $k => $v) { ?>
<li><a href="<?php echo $MOD['linkurl'];?><?php echo rewrite('search.php?catid='.$catid.'&typeid='.$k);?>"><?php echo $v;?></a></li>
<?php } } ?>
</ul>
</div>
<div class="c_b"></div>
</div>
<?php } ?>
<?php if($CP) { ?><?php include template('property_list', 'chip');?><?php } ?>
<div class="img_tip" id="img_tip" style="display:none;">&nbsp;</div>
<?php if($page == 1) { ?><?php echo ad($moduleid,$catid,$kw,6);?><?php } ?>
<?php if($tags) { ?><?php include template('list-'.$module, 'tag');?><?php } ?>
</div>
<div class="m2r">
<div class="sponsor"><?php echo ad($moduleid,$catid,$kw,7);?></div>
<div class="head-sub"><strong>搜索排行</strong></div>
<div class="list-rank">
<?php echo tag("moduleid=$moduleid&table=keyword&condition=moduleid=$moduleid and status=3 and updatetime>$today_endtime-86400*30&pagesize=9&order=week_search desc&key=week_search&template=list-search_rank");?>
</div>
</div>
<div class="c_b"></div>
</div>
<?php include template('footer');?>