<?php defined('IN_DESTOON') or exit('Access Denied');?><?php if($user_status == 3) { ?>
<ul>
<?php if($member) { ?>
<li class="f_b t_c" style="padding:3px 0 5px 0;font-size:14px;"><a href="<?php echo $member['linkurl'];?>" target="_blank" title="<?php echo $member['company'];?>&#10;<?php echo $member['mode'];?>"><?php echo $member['company'];?></a></li>
<?php if($member['vip']) { ?>
<li class="f_orange" style="padding:5px 0 0 12px;"><img src="<?php echo DT_SKIN;?>image/vip_<?php echo $member['vip'];?>.gif" alt="<?php echo VIP;?>" title="<?php echo VIP;?>:<?php echo $member['vip'];?>级" align="absmiddle"/> [<?php echo VIP;?>第<?php echo vip_year($member['fromtime']);?>年] 指数:<?php echo $member['vip'];?></li>
<?php } ?>
<?php if($member['validated'] || $member['vcompany'] || $member['vtruename'] || $member['vbank'] || $member['vmobile'] || $member['vemail']) { ?>
<li class="f_green" style="padding-top:6px;padding-bottom:6px;">
<?php if($member['vcompany']) { ?>&nbsp;<img src="<?php echo $MODULE['2']['linkurl'];?>image/v_company.gif" width="16" height="16" align="absmiddle" title="通过工商认证"/><?php } ?>
<?php if($member['vtruename']) { ?>&nbsp;<img src="<?php echo $MODULE['2']['linkurl'];?>image/v_truename.gif" width="16" height="16" align="absmiddle" title="通过实名认证"/><?php } ?>
<?php if($member['vbank']) { ?>&nbsp;<img src="<?php echo $MODULE['2']['linkurl'];?>image/v_bank.gif" width="16" height="16" align="absmiddle" title="通过银行帐号认证"/><?php } ?>
<?php if($member['vmobile']) { ?>&nbsp;<img src="<?php echo $MODULE['2']['linkurl'];?>image/v_mobile.gif" width="16" height="16" align="absmiddle" title="通过手机认证"/><?php } ?>
<?php if($member['vemail']) { ?>&nbsp;<img src="<?php echo $MODULE['2']['linkurl'];?>image/v_email.gif" width="16" height="16" align="absmiddle" title="通过邮件认证"/><?php } ?>
<?php if($member['validated']) { ?>&nbsp;<img src="<?php echo DT_STATIC;?>file/image/check-ok.png" align="absmiddle"/> 通过<?php echo $member['validator'];?>认证<?php } ?>
&nbsp;<a href="<?php echo userurl($member['username'], 'file=credit');?>">[诚信档案]</a>
</li>
<?php } ?>
<?php if($member['deposit']) { ?>
<li class="f_green">已缴纳 <strong><?php echo $member['deposit'];?></strong> <?php echo $DT['money_unit'];?>保证金</li>
<?php } ?>
<li style="padding-top:6px;padding-bottom:6px;">
<span>联系人</span><?php echo $member['truename'];?>(<?php echo gender($member['gender']);?>)&nbsp;<?php echo $member['career'];?>&nbsp;
<?php if($member['username'] && $DT['im_web']) { ?><?php echo im_web($member['username'].'&mid='.$moduleid.'&itemid='.$itemid);?>&nbsp;<?php } ?>
<?php if($member['qq'] && $DT['im_qq']) { ?><?php echo im_qq($member['qq']);?>&nbsp;<?php } ?>
<?php if($member['wx'] && $DT['im_wx']) { ?><?php echo im_wx($member['wx'], $member['username']);?>&nbsp;<?php } ?>
<?php if($member['ali'] && $DT['im_ali']) { ?><?php echo im_ali($member['ali']);?>&nbsp;<?php } ?>
<?php if($member['skype'] && $DT['im_skype']) { ?><?php echo im_skype($member['skype']);?>&nbsp;<?php } ?>
</li>
<li><span>会员</span> [<?php if(online($member['userid'])==1) { ?><font class="f_red">当前在线</font><?php } else { ?><font class="f_gray">当前离线</font><?php } ?>
] <a href="<?php echo $MODULE['2']['linkurl'];?>friend.php?action=add&username=<?php echo $member['username'];?>">[加为商友]</a> <a href="<?php echo $MODULE['2']['linkurl'];?>message.php?action=send&touser=<?php echo $member['username'];?>">[发送信件]</a></li>
<?php if($member['mail']) { ?><li><span>邮件</span><?php echo anti_spam($member['mail']);?></li><?php } ?>
<?php if($member['telephone']) { ?><li><span>电话</span><?php echo anti_spam($member['telephone']);?></li><?php } ?>
<?php if($member['mobile']) { ?><li><span>手机</span><?php echo anti_spam($member['mobile']);?></li><?php } ?>
<li><span>地区</span><?php echo area_pos($member['areaid'], '-');?></li>
<?php if($member['address']) { ?><li title="<?php echo $member['address'];?>"><span>地址</span><a href="<?php echo DT_PATH;?>api/address.php?auth=<?php echo encrypt($member['address'].'|'.$member['company'], DT_KEY.'MAP');?>" target="_blank"><?php echo $member['address'];?></a></li><?php } ?>
<?php } else { ?>
<li class="f_b t_c" style="font-size:14px;"><a href="<?php echo userurl('');?>" target="_blank"><?php echo $item['company'];?></a></li>
<li style="padding-top:3px;">
<span>联系人</span><?php echo $item['truename'];?>&nbsp;
<?php if($item['username'] && $DT['im_web']) { ?><?php echo im_web($item['username'].'&mid='.$moduleid.'&itemid='.$itemid);?>&nbsp;<?php } ?>
<?php if($item['qq'] && $DT['im_qq']) { ?><?php echo im_qq($item['qq']);?>&nbsp;<?php } ?>
<?php if($item['wx'] && $DT['im_wx']) { ?><?php echo im_wx($item['wx'], $item['username']);?>&nbsp;<?php } ?>
<?php if($item['ali'] && $DT['im_ali']) { ?><?php echo im_ali($item['ali']);?>&nbsp;<?php } ?>
<?php if($item['skype'] && $DT['im_skype']) { ?><?php echo im_skype($item['skype']);?>&nbsp;<?php } ?>
&nbsp;&nbsp;<strong class="f_red">未注册</strong>
</li>
<?php if($item['email']) { ?><li><span>邮件</span><?php echo anti_spam($item['email']);?></li><?php } ?>
<?php if($item['telephone']) { ?><li><span>电话</span><?php echo anti_spam($item['telephone']);?></li><?php } ?>
<?php if($item['mobile']) { ?><li><span>手机</span><?php echo anti_spam($item['mobile']);?></li><?php } ?>
<li><span>地区</span><?php echo area_pos($item['areaid'], '&nbsp;');?></li>
<?php if($item['address']) { ?><li title="<?php echo $item['address'];?>"><span>地址</span><a href="<?php echo DT_PATH;?>api/address.php?auth=<?php echo encrypt($item['address'].'|'.$item['company'], DT_KEY.'MAP');?>" target="_blank"><?php echo $item['address'];?></a></li><?php } ?>
</li>
<?php } ?>
</ul>
<?php } else if($user_status == 2) { ?>
<div class="px14 t_c">
<table cellpadding="6" cellspacing="6" width="100%">
<tr>
<td class="f_b"><div style="padding:6px;border:#40B3FF 1px solid;background:#E5F5FF;">查看该信息联系方式需支付<?php echo $name;?> <strong class="f_red"><?php echo $fee;?></strong> <?php echo $unit;?></div></td>
</tr>
<tr>
<td>我的<?php echo $name;?>余额 <strong class="f_blue"><?php if($currency=='money') { ?><?php echo $_money;?><?php } else { ?><?php echo $_credit;?><?php } ?>
</strong> <?php echo $unit;?></td>
</tr>
<?php if($MOD['fee_period']) { ?>
<tr>
<td>支付后可查看<strong class="f_red"><?php echo $MOD['fee_period'];?></strong>分钟，过期重新计费</td>
</tr>
<?php } ?>
<tr>
<td><input type="button" value="立即支付" class="btn-green" onclick="Go('<?php echo $pay_url;?>');"/></td>
</tr>
</table>
</div>
<?php } else if($user_status == 1) { ?>
<div class="px14 t_c">
<table cellpadding="6" cellspacing="6" width="100%">
<tr>
<td class="f_b"><div style="padding:6px;border:#FFC600 1px solid;background:#FFFEBF;">您的会员级别没有查看联系方式的权限</div></td>
</tr>
<tr>
<td>获得更多商业机会，建议<span class="f_red">升级</span>会员级别</td>
</tr>
<?php if($DT['telephone']) { ?>
<tr>
<td>咨询电话：<?php echo $DT['telephone'];?></td>
</tr>
<?php } ?>
<tr>
<td><input type="button" value="立即升级" class="btn-green" onclick="Go('<?php echo $MODULE['2']['linkurl'];?>grade.php');"/></td>
</tr>
</table>
</div>
<?php } else if($user_status == 0) { ?>
<br/>
<div class="px14 t_c">
<table cellpadding="5" cellspacing="5" width="100%">
<tr>
<td class="f_b">
<div style="padding:6px;border:#FFC600 1px solid;background:#FFFEBF;">
您还没有登录，请登录后查看详情
</div>
</td>
</tr>
<tr>
<td><input type="button" value="立即登录" class="btn-blue" onclick="Go('<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_login'];?>');"/></td>
</tr>
<tr>
<td><input type="button" value="免费注册" class="btn-green" onclick="Go('<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_register'];?>');"/></td>
</tr>
</table>
</div>
<br/>
<?php } else { ?>
<br/><br/><br/>
<center><img src="<?php echo DT_SKIN;?>image/load.gif"/></center>
<br/><br/><br/>
<?php } ?>