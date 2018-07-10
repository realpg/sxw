<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<div class="m0">
<div class="m">
<div class="im0">
<div class="im0l">
<?php $mid = $moduleid;?>
<?php $c0 = get_maincat(0, $mid, 1);?>
<ul>
<?php if(is_array($c0)) { foreach($c0 as $k0 => $v0) { ?>
<?php if($k0 < 16 && $v0['child']) { ?>
<?php $_c1 = get_maincat($v0['catid'], $mid, 2);?>
<?php $c1 = get_maincat($v0['catid'], $mid);?>
<li class="cate-<?php echo $k0;?>"><i>&gt;</i>
<a href="<?php echo $MOD['linkurl'];?><?php echo $v0['linkurl'];?>" target="_blank"><strong><?php echo $v0['catname'];?></strong></a> 
<?php if($_c1) { ?>
<a href="<?php echo $MOD['linkurl'];?><?php echo $_c1['0']['linkurl'];?>" target="_blank"><strong><?php echo $_c1['0']['catname'];?></strong></a>
<?php } else { ?>
<a href="<?php echo $MOD['linkurl'];?><?php echo $c1['0']['linkurl'];?>" target="_blank"><strong><?php echo $c1['0']['catname'];?></strong></a>
<?php } ?>
<div>
<?php if(is_array($c1)) { foreach($c1 as $k1 => $v1) { ?>
<dl>
<dt><a href="<?php echo $MOD['linkurl'];?><?php echo $v1['linkurl'];?>" target="_blank"><?php echo set_style($v1['catname'], $v1['style']);?></a></dt>
<?php if($v1['child']) { ?>
<?php $c2 = get_maincat($v1['catid'], $mid);?>
<dd>
<?php if(is_array($c2)) { foreach($c2 as $k2 => $v2) { ?>
<?php if($k2) { ?><em>|</em><?php } ?>
<a href="<?php echo $MOD['linkurl'];?><?php echo $v2['linkurl'];?>" target="_blank"><?php echo set_style($v2['catname'], $v2['style']);?></a>
<?php } } ?>
</dd>
<?php } ?>
</dl>
<?php } } ?>
</div>
</li>
<?php } ?>
<?php } } ?>
</ul>
</div>
<div class="im0m">
<div><?php echo ad(14);?></div>
<div class="im0mall">
<div id="itrade">
<div class="tab-head">
<ul id="trade-h">
<li id="trade-h-1" onmouseover="Tb(this);" class="on"><span>推荐</span></li>
<li id="trade-h-2" onmouseover="Tb(this);"><span>上新</span></li>
<li id="trade-h-3" onmouseover="Tb(this);"><span>人气</span></li>
<li id="trade-h-4" onmouseover="Tb(this);"><span>热销</span></li>
<li id="trade-h-5" onmouseover="Tb(this);"><span>热评</span></li>
</ul>
</div>
<div id="trade-b-1" class="im0t-mall" style="display:;"><?php echo tag("moduleid=$moduleid&condition=status=3 and level>0&areaid=$cityid&pagesize=10&order=".$MOD['order']."&width=100&height=100&template=thumb-mall&target=_blank");?></div>
<div id="trade-b-2" class="im0t-mall" style="display:none;"><?php echo tag("moduleid=$moduleid&condition=status=3&areaid=$cityid&pagesize=10&order=addtime desc&width=100&height=100&template=thumb-mall&target=_blank");?></div>
<div id="trade-b-3" class="im0t-mall" style="display:none;"><?php echo tag("moduleid=$moduleid&condition=status=3&areaid=$cityid&pagesize=10&order=hits desc&width=100&height=100&template=thumb-mall&target=_blank");?></div>
<div id="trade-b-4" class="im0t-mall" style="display:none;"><?php echo tag("moduleid=$moduleid&condition=status=3&areaid=$cityid&pagesize=10&order=orders desc&width=100&height=100&template=thumb-mall&target=_blank");?></div>
<div id="trade-b-5" class="im0t-mall" style="display:none;"><?php echo tag("moduleid=$moduleid&condition=status=3&areaid=$cityid&pagesize=10&order=comments desc&width=100&height=100&template=thumb-mall&target=_blank");?></div>
</div>
</div>
</div>
<div class="im0r">
<div class="im0u">
<div class="user-info" style="background:#FFFFFF;">
<script type="text/javascript">
var destoon_uname = get_cookie('username');
document.write('<a href="<?php echo $MODULE['2']['linkurl'];?>avatar.php"><img src="'+DTPath+'api/avatar/show.php?size=large&reload=<?php echo DT_TIME;?>&username='+destoon_uname+'"/></a>');
document.write('<ul>');
if(get_cookie('auth')) {
document.write('<li><em><a href="<?php echo $MODULE['2']['linkurl'];?>logout.php">退出</a></em><a href="<?php echo $MODULE['2']['linkurl'];?>"><strong>Hi,'+destoon_uname+'</strong></a></li>');
} else {
if(destoon_uname) {
document.write('<li><em><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_login'];?>">登录</a></em><a href="<?php echo $MODULE['2']['linkurl'];?>"><strong>Hi,'+destoon_uname+'</strong></a></li>');
} else {
document.write('<li><em><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_register'];?>">注册</a></em><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_login'];?>"><strong>Hi,请登录</strong></a></li>');
}
}
document.write('<li><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>?mid=<?php echo $moduleid;?>&action=add" class="b">会员中心</a><i>|</i><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>?mid=<?php echo $moduleid;?>" class="b">我的订单</a><i>|</i><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>?mid=<?php echo $moduleid;?>&job=answer" class="b">商户后台</a></li>');
document.write('</ul>');
</script>
</div>
<div>
<div class="ian-h">
<ul id="ian-h">
<li id="ian-h-1" onmouseover="Tb(this);" class="on"><a href="<?php echo $EXT['announce_url'];?>" target="_blank"><span>网站动态</span></a></li>
</ul>
</div>
<div id="ian-b-1" class="ian-b" style="display:;">
<?php echo tag("table=announce&condition=(totime=0 or totime>$today_endtime-86400)&areaid=$cityid&pagesize=3&datetype=2&order=listorder desc,addtime desc&target=_blank");?>
</div>
</div>
<div class="im0g">
<a href="<?php echo $MODULE['2']['linkurl'];?>cart.php" target="_blank"><div><em><script type="text/javascript">document.write(get_cart());</script></em><img src="<?php echo DT_SKIN;?>image/grid-cart.png"/><br/>购物车</div></a>
<a href="<?php echo $MODULE['2']['linkurl'];?>coupon.php" target="_blank"><div><img src="<?php echo DT_SKIN;?>image/grid-coupon.png"/><br/>优惠券</div></a>
<a href="<?php echo $MODULE['2']['linkurl'];?>favorite.php" target="_blank"><div><img src="<?php echo DT_SKIN;?>image/grid-favorite.png"/><br/>商品关注</div></a>
<a href="<?php echo $MOD['linkurl'];?>view.php" target="_blank"><div><img src="<?php echo DT_SKIN;?>image/grid-view.png"/><br/>浏览历史</div></a>
</div>
</div>
<div class="im0t">&nbsp;</div>
</div>
<div class="c_b"></div>
</div>
</div>
</div>
<div class="m">
<div class="b20"></div>
<?php if(is_array($c0)) { foreach($c0 as $k0 => $v0) { ?>
<?php if($v0['child']) { ?>
<div class="im-b im-b-mall">
<div class="im-l">
<a href="<?php echo $MOD['linkurl'];?><?php echo $v0['linkurl'];?>"><p><?php echo $v0['catname'];?></p></a>
<?php $child = get_maincat($v0['catid'], $moduleid, 1);?>
<ul>
<?php if(is_array($child)) { foreach($child as $i => $c) { ?>
<li><a href="<?php echo $MOD['linkurl'];?><?php echo $c['linkurl'];?>" target="_blank"><?php echo set_style($c['catname'], $c['style']);?></a></li>
<?php } } ?>
</ul>
</div>
<div class="im-r im-r-mall">
<?php $tags=tag("moduleid=$mid&condition=status=3 and level>0&catid=".$v0['catid']."&areaid=$cityid&order=addtime desc&lazy=$lazy&pagesize=".$DT['page_mall']."&template=null");?>
<?php if(is_array($tags)) { foreach($tags as $i => $t) { ?>
<div>
<a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" width="134" height="134" alt=""/></a>
<b><?php echo $DT['money_sign'];?><?php echo $t['price'];?></b>
<p><a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>" target="_blank"><?php echo $t['title'];?></a></p>
</div>
<?php } } ?>
</div>
</div>
<?php } ?>
<?php } } ?>
</div>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/index.js"></script>
<?php include template('footer');?>