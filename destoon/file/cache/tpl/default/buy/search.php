<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<div class="m">
<div class="nav bd-b"><a href="<?php echo $MODULE['1']['linkurl'];?>">首页</a> <i>&gt;</i> <a href="<?php echo $MOD['linkurl'];?>"><?php echo $MOD['name'];?></a> <i>&gt;</i> <a href="<?php echo $MOD['linkurl'];?>search.php">搜索</a></div>
</div>
<div class="m m2">
<div class="m2l">
<form action="<?php echo $MOD['linkurl'];?>search.php" id="fsearch">
<div class="sort">
<div class="sort-k">关键词</div>
<div class="sort-v">
<input type="text" size="60" name="kw" value="<?php echo $kw;?>"/> &nbsp;
<?php if(is_array($sfields)) { foreach($sfields as $k => $v) { ?>
<input type="radio" name="fields" value="<?php echo $k;?>" id="fd_<?php echo $k;?>"<?php if($fields==$k) { ?> checked<?php } ?>
/><label for="fd_<?php echo $k;?>"> <?php echo $v;?></label> &nbsp;
<?php } } ?>
<?php echo $order_select;?>
</div>
<div class="c_b"></div>
</div>
<div class="sort">
<div class="sort-k">行业</div>
<div class="sort-v">
<?php echo $category_select;?>
<b>类型</b>
<?php echo $type_select;?> &nbsp;
<input type="checkbox" name="thumb" id="thumb" value="1"<?php if($thumb) { ?> checked<?php } ?>
/>图片 &nbsp;
<input type="checkbox" name="vip" id="vip" value="1"<?php if($vip) { ?> checked<?php } ?>
/><?php echo VIP;?> &nbsp;
</div>
<div class="c_b"></div>
</div>
<div class="sort">
<div class="sort-k">地区</div>
<div class="sort-v">
<?php echo $area_select;?>
<b>日期</b>
<?php echo dcalendar('fromdate', $fromdate, '');?> 至 <?php echo dcalendar('todate', $todate, '');?>
</div>
<div class="c_b"></div>
</div>
<?php if($CP) { ?><?php include template('property_search', 'chip');?><?php } ?>

<div class="sort">
<div class="sort-k">&nbsp;</div>
<div class="sort-v">
<input type="submit" value="搜 索" class="btn-blue"/>
<input type="button" value="重 搜" class="btn" onclick="Go('<?php echo $MOD['linkurl'];?>search.php');"/>
</div>
<div class="c_b"></div>
</div>
</form>
<?php if($page==1 && $kw) { ?>
<?php echo ad($moduleid,$catid,$kw,6);?>
<?php echo load('m'.$moduleid.'_k'.urlencode($kw).'.htm');?>
<?php } ?>
<?php if($tags) { ?>
<?php include template('list-'.$module, 'tag');?>
<?php } else { ?>
<?php include template('empty', 'chip');?>
<?php } ?>
</div>
<div class="m2r">
<?php if($kw) { ?>
<div class="b10"></div>
<div class="head-sub"><strong>相关搜索</strong></div>
<div class="list-txt">
<ul>
<?php if(is_array($MODULE)) { foreach($MODULE as $mod) { ?><?php if($mod['moduleid']>3 && $mod['moduleid']!=$moduleid && !$mod['islink']) { ?><li><a href="<?php echo $mod['linkurl'];?><?php echo rewrite('search.php?kw='.urlencode($kw));?>">在 <span class="f_red"><?php echo $mod['name'];?></span> 找 <?php echo $kw;?></a></li><?php } ?>
<?php } } ?>
</ul>
</div>
<?php echo tag("moduleid=$moduleid&table=keyword&condition=moduleid=$moduleid and status=3 and word<>'$kw' and keyword like '%$keyword%'&pagesize=10&order=total_search desc&template=list-search_relate", -2);?>
<?php } ?>
<div class="sponsor"><?php echo ad($moduleid,$catid,$kw,7);?></div>
<div class="head-sub"><strong>今日排行</strong></div>
<div class="list-rank">
<?php echo tag("moduleid=$moduleid&table=keyword&condition=moduleid=$moduleid and status=3 and updatetime>$today_endtime-86400&pagesize=9&order=today_search desc&key=today_search&template=list-search_rank");?>
</div>
<div class="head-sub"><strong>本周排行</strong></div>
<div class="list-rank">
<?php echo tag("moduleid=$moduleid&table=keyword&condition=moduleid=$moduleid and status=3 and updatetime>$today_endtime-86400*7&pagesize=9&order=week_search desc&key=week_search&template=list-search_rank");?>
</div>
<div class="head-sub"><strong>本月排行</strong></div>
<div class="list-rank">
<?php echo tag("moduleid=$moduleid&table=keyword&condition=moduleid=$moduleid and status=3 and updatetime>$today_endtime-86400*30&pagesize=9&order=week_search desc&key=week_search&template=list-search_rank");?>
</div>
</div>
<div class="c_b"></div>
</div>
<?php include template('footer');?>