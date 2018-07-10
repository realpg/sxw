<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<script type="text/javascript">var module_id= <?php echo $moduleid;?>,item_id=<?php echo $itemid;?>,content_id='content',img_max_width=<?php echo $MOD['max_width'];?>;</script>
<div class="m">
<div class="nav"><div><img src="<?php echo DT_SKIN;?>image/ico-share.png" class="share" title="分享好友" onclick="Dshare(<?php echo $moduleid;?>, <?php echo $itemid;?>);"/></div><a href="<?php echo $MODULE['1']['linkurl'];?>">首页</a> <i>&gt;</i> <a href="<?php echo $MOD['linkurl'];?>"><?php echo $MOD['name'];?></a> <i>&gt;</i> <?php echo cat_pos($CAT, ' <i>&gt;</i> ');?></div>
<div class="b20 bd-t"></div>
</div>
<div class="m">
<table width="100%">
<tr>
<td valign="top">
<table width="100%">
<tr>
<td colspan="3"><h1 class="title_trade" id="title"><?php echo $title;?></h1></td>
</tr>
<tr>
<td width="330" valign="top">
<div id="mid_pos"></div>
<div id="mid_div" onmouseover="SAlbum();" onmouseout="HAlbum();" onclick="PAlbum(Dd('mid_pic'));">
<img src="<?php echo $albums['0'];?>" width="320" height="240" id="mid_pic"/><span id="zoomer"></span>
</div>
<div class="b10"></div>
<div>
<?php if(is_array($thumbs)) { foreach($thumbs as $k => $v) { ?><img src="<?php echo $v;?>" width="60" height="60" onmouseover="if(this.src.indexOf('nopic60.gif')==-1)Album(<?php echo $k;?>, '<?php echo $albums[$k];?>');" class="<?php if($k) { ?>ab_im<?php } else { ?>ab_on<?php } ?>
" id="t_<?php echo $k;?>"/><?php } } ?>
</div>
<div class="b10"></div>
<div onclick="PAlbum(Dd('mid_pic'));" class="c_b t_c c_p"><img src="<?php echo DT_SKIN;?>image/ico_zoom.gif" width="16" height="16" align="absmiddle"/> 点击图片查看原图</div>
</td>
<td width="16">&nbsp;</td>
<td valign="top">
<div id="big_div" style="display:none;"><img src="" id="big_pic"/></div>
<table width="100%" cellpadding="5" cellspacing="5">
<?php if($n1 && $v1) { ?>
<tr>
<td><?php echo $n1;?>：</td>
<td><?php echo $v1;?></td>
</tr>
<?php } ?>
<?php if($n2 && $v2) { ?>
<tr>
<td><?php echo $n2;?>：</td>
<td><?php echo $v2;?></td>
</tr>
<?php } ?>
<?php if($n3 && $v3) { ?>
<tr>
<td><?php echo $n3;?>：</td>
<td><?php echo $v3;?></td>
</tr>
<?php } ?>
<tr>
<td>需求数量：</td>
<td><?php echo $amount;?></td>
</tr>
<tr>
<td>价格要求：</td>
<td class="f_b f_orange"><?php echo $price;?></td>
</tr>
<tr>
<td>包装要求：</td>
<td><?php echo $pack;?></td>
</tr>
<tr>
<td>所在地：</td>
<td><?php echo area_pos($areaid, '');?></td>
</tr>
<tr>
<td>有效期至：</td>
<td><?php if($todate) { ?><?php echo $todate;?><?php } else { ?>长期有效<?php } ?>
<?php if($expired) { ?> <span class="f_red">[已过期]</span><?php } ?>
</td>
</tr>
<tr>
<td width="80">最后更新：</td>
<td><?php echo $editdate;?></td>
</tr>
<?php if($MOD['hits']) { ?>
<tr>
<td>浏览次数：</td>
<td><span id="hits"><?php echo $hits;?></span></td>
</tr>
<?php } ?>
<?php if($username && !$expired) { ?>
<tr>
<td colspan="2"><img src="<?php echo DT_SKIN;?>image/btn_price.gif" alt="报价" class="c_p" onclick="Go('<?php echo $MOD['linkurl'];?><?php echo rewrite('price.php?itemid='.$itemid);?>');"/></td>
</tr>
<?php } ?>
</table>
</td>
</tr>
</table>
</td>
<td width="16">&nbsp;</td>
<td width="300" valign="top">
<div class="contact_head">公司基本资料信息</div>
<div class="contact_body" id="contact"><?php include template('contact', 'chip');?></div>
<?php if(!$username) { ?>
<br/>
&nbsp;<strong class="f_red">注意</strong>:发布人未在本站注册，建议优先选择<a href="<?php echo $MODULE['2']['linkurl'];?>grade.php"><strong><?php echo VIP;?>会员</strong></a>
<?php } ?>
</td>
</tr>
</table>
</div>
<div class="m">
<div class="head-txt"><strong>详细说明</strong></div>
<?php if($CP) { ?><?php include template('property_show', 'chip');?><?php } ?>
<div class="content c_b" id="content"><?php echo $content;?></div>
<?php if($MOD['fee_award']) { ?>
<div class="award"><div onclick="Go('<?php echo $MODULE['2']['linkurl'];?>award.php?mid=<?php echo $moduleid;?>&itemid=<?php echo $itemid;?>');">打赏</div></div>
<?php } ?>
<div class="head-txt"><span><a href="<?php echo $MOD['linkurl'];?><?php echo $CAT['linkurl'];?>">更多<i>&gt;</i></a></span><strong>同类<?php echo $MOD['name'];?></strong></div>
<div class="list-thumb"><?php echo tag("moduleid=$moduleid&length=20&condition=status=3 and thumb<>''&catid=$catid&areaid=$cityid&pagesize=8&order=edittime desc&width=100&height=100&cols=8&template=thumb-table", -2);?></div>
<?php include template('comment', 'chip');?>
</div>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/album.js"></script>
<?php if($content) { ?><script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/content.js"></script><?php } ?>
<?php include template('footer');?>