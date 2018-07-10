<?php defined('IN_DESTOON') or exit('Access Denied');?><?php isset($file) or $file='search';?>
<ul>
<?php if(is_array($tags)) { foreach($tags as $i => $t) { ?>
<?php $n=$i+1;?>
<li title="搜索<?php echo $t[$key];?>次 约<?php echo $t['items'];?>条结果"><span class="f_r"><?php echo $t['items'];?>条</span><?php if($n>3) { ?><i><?php echo $n;?></i><?php } else { ?><em><?php echo $n;?></em><?php } ?>
<a href="<?php echo $MODULE[$moduleid]['linkurl'];?><?php echo $file;?>.php?kw=<?php echo urlencode($t['word']);?>"<?php if($target) { ?> target="<?php echo $target;?>"<?php } ?>
><?php echo $t['word'];?></a></li>
<?php } } ?>
</ul>