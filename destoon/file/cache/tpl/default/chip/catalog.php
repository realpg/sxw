<?php defined('IN_DESTOON') or exit('Access Denied');?><?php $child = get_maincat(0, $mid, 1);?>
<table width="100%" cellpadding="0" cellspacing="0">
<?php if(is_array($child)) { foreach($child as $i => $c) { ?>
<?php if($i%2==0) { ?><tr><?php } ?>
<td valign="top">
<p>
<a href="<?php echo $MODULE[$mid]['linkurl'];?><?php echo $c['linkurl'];?>" class="px16"><strong><?php echo set_style($c['catname'], $c['style']);?></strong></a>
<?php if($c['child']) { ?>
<?php $sub = get_maincat($c['catid'], $mid, 2);?>
<?php if(is_array($sub)) { foreach($sub as $j => $s) { ?><?php if($j < 5) { ?><em>|</em><a href="<?php echo $MODULE[$mid]['linkurl'];?><?php echo $s['linkurl'];?>"><strong><?php echo set_style($s['catname'], $s['style']);?></strong></a><?php } ?>
<?php } } ?>
<?php } ?>
</p>
<?php if($c['child']) { ?>
<?php $sub = get_maincat($c['catid'], $mid, 1);?>
<?php $n = count($sub) - 1;?>
<ul>
<?php if(is_array($sub)) { foreach($sub as $j => $s) { ?>
<li><a href="<?php echo $MODULE[$mid]['linkurl'];?><?php echo $s['linkurl'];?>"><?php echo set_style($s['catname'], $s['style']);?></a><?php if($j < $n) { ?><i>|</i><?php } ?>
</li>
<?php } } ?>
</ul>
<?php } ?>
</td>
<?php if($i%2==1) { ?></tr><?php } ?>
<?php } } ?>
</table>