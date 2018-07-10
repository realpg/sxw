<?php defined('IN_DESTOON') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="<?php echo DT_CHARSET;?>"/>
<meta name="robots" content="nofollow"/>
<meta name="generator" content="DESTOON B2B - www.destoon.com"/>
<meta http-equiv="x-ua-compatible" content="IE=8"/>
<title><?php if($head_title) { ?><?php echo $head_title;?><?php echo $DT['seo_delimiter'];?><?php } ?>
商务中心<?php echo $DT['seo_delimiter'];?><?php if($city_sitename) { ?><?php echo $city_sitename;?><?php } else { ?><?php echo $DT['sitename'];?><?php } ?>
<?php echo $DT['seo_delimiter'];?>Powered By DESTOON</title>
<link rel="shortcut icon" href="<?php echo DT_STATIC;?>favicon.ico"/>
<link rel="bookmark" href="<?php echo DT_STATIC;?>favicon.ico"/>
<link rel="stylesheet" type="text/css" href="image/style.css"/>
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="<?php echo DT_SKIN;?>ie6.css"/>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/ie6png.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--[if IE]>
<style type="text/css">
.head_user em {margin:-4px 0 0 -4px;}
#mini_profile {margin:20px 0 0 -140px;}
</style>
<![endif]-->
<?php if(!DT_DEBUG) { ?><script type="text/javascript">window.onerror= function(){return true;}</script><?php } ?>
<script type="text/javascript" src="<?php echo DT_STATIC;?>lang/<?php echo DT_LANG;?>/lang.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/config.js"></script>
<!--[if lte IE 9]><!-->
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery-1.5.2.min.js"></script>
<!--<![endif]-->
<!--[if (gte IE 10)|!(IE)]><!-->
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery-2.1.1.min.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/admin.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/member.js"></script>
<?php if($head_mobile && $EXT['mobile_goto']) { ?><script type="text/javascript">GoMobile('<?php echo $head_mobile;?>');</script><?php } ?>
</head>
<body>
<div id="msgbox" style="display:none;"></div>
<?php echo dmsg();?>
<div class="head" id="head">
<div class="head_m">
<div class="head_logo"><a href="<?php echo $MODULE['2']['linkurl'];?>"><img src="image/logo.png"/></a></div>
<div class="head_main">
<ul>
<?php if($_userid) { ?>
<li class="menu_<?php if($menu_id==0) { ?>1<?php } else { ?>2<?php } ?>
"><a href="<?php echo $MODULE['2']['linkurl'];?>">会员中心</a></li>
<li class="menu_<?php if($menu_id==1) { ?>1<?php } else { ?>2<?php } ?>
"><a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_my'];?>">信息管理</a></li>
<li class="menu_<?php if($menu_id==2) { ?>1<?php } else { ?>2<?php } ?>
"><a href="<?php echo $MODULE['2']['linkurl'];?>biz.php">商户后台</a></li>
<?php } ?>
<li class="menu_2"><a href="<?php echo DT_PATH;?>">网站首页</a></li>
</ul>
</div>
<div class="head_user">
<?php if($_userid) { ?>
<ul>
<li id="my_profile"><a href="avatar.php"><img src="<?php echo useravatar($_username, 'small');?>" width="20" height="20" id="myavatar"/></a>
<div id="mini_profile" style="display:none;">
<div>
<dl>
<dt><span class="f_r"><a href="edit.php"><img src="image/setting.gif" width="10" height="10" align="absmiddle" title="资料设置"/></a></span><span class="f_b px14">欢迎，<?php echo $_truename;?></span> (<?php echo $_username;?>) <a href="account.php?action=line" title="<?php if($_online) { ?>在线，点击隐身<?php } else { ?>隐身，点击上线<?php } ?>
"><img src="<?php echo DT_SKIN;?>image/user_<?php if($_online) { ?>on<?php } else { ?>off<?php } ?>
line.png" width="10" height="10" align="absmiddle"/></a></dt>
<dt><a href="<?php echo userurl($_username);?>" target="_blank" title="<?php echo $_company;?>"><span class="f_black"><?php echo $_company;?></span></a>(<?php echo $MG['groupname'];?>)&nbsp;&nbsp;&nbsp;<a href="account.php"><span class="f_dblue">账户详情&raquo;</span></a></dt>
<dt><a href="record.php"><span class="f_black"><?php echo $DT['money_name'];?>:<?php echo $_money;?></span></a> <span class="f_gray">|</span> 
<a href="credit.php"><span class="f_black"><?php echo $DT['credit_name'];?>:<?php echo $_credit;?></span></a></dt>
</dl>
</div>
</div>
</li>
<li id="destoon_message"><a href="message.php">消息</a><?php if($_message) { ?><em><?php echo $_message;?></em><?php } ?>
</li>
<?php if($DT['im_web']) { ?><li id="destoon_chat"><a href="im.php">交谈</a><?php if($_chat) { ?><em><?php echo $_chat;?></em><?php } ?>
</li><?php } ?>
<li><a href="logout.php?forward=">退出</a></li>
<?php if($admin_user) { ?><li><a href="index.php?action=logout">注销授权</a></li><?php } ?>
</ul>
<?php } else { ?>
<a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_login'];?>">立即登录</a> | 
<a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_register'];?>">注册会员</a>
<?php } ?>

</div>
<div class="c_b"></div>
</div>
</div>
<div class="head_s" id="destoon_space">&nbsp;</div>
<div class="main_tb">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" class="side" id="side">
<?php if($menu_id == 2) { ?>
<?php if($_userid) { ?>
<div class="side_head"><div><img src="image/side-biz.png" align="absmiddle"/>商户服务</div></div>
<div class="side_body">
<ul>
<?php if($MG['trade_order']) { ?>
<li class="side_a" id="trade"><span class="f_r"><a href="trade.php?action=express" class="m">快递</a></span><a href="trade.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">订单管理</a></li>
<?php } ?>
<?php if($MG['group_order']) { ?>
<?php if(is_array($MODULE)) { foreach($MODULE as $m) { ?>
<?php if($m['module'] == 'group') { ?>
<li class="side_a" id="group-<?php echo $m['moduleid'];?>"><span class="f_r"><a href="group.php?mid=<?php echo $m['moduleid'];?>&action=express" class="m">快递</a></span><a href="group.php?mid=<?php echo $m['moduleid'];?>" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $m['name'];?>订单</a></li>
<?php } ?>
<?php } } ?>
<?php } ?>
<?php if($MG['promo_limit']>-1) { ?>
<li class="side_a" id="promo"><span class="f_r"><a href="promo.php?action=add" class="m">新增</a></span><a href="promo.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">优惠促销</a></li>
<?php } ?>
<li class="side_a" id="deposit"><span class="f_r"><a href="deposit.php?action=add" class="m">增资</a></span><a href="deposit.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">保 证 金</a></li>
<?php if($MG['alert_limit']>-1) { ?>
<li class="side_a" id="alert"><span class="f_r"><a href="alert.php?action=list" class="m">添加</a></span><a href="alert.php" class="<?php if($MG['alert_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">贸易提醒</a></li>
<?php } ?>
<?php if($MG['sms']) { ?>
<?php if($DT['sms']) { ?><li class="side_a" id="sms"><span class="f_r"><a href="sms.php?action=buy" class="m">购买</a></span><a href="sms.php" class="<?php if($MG['sms']) { ?>n<?php } else { ?>f<?php } ?>
">手机短信</a></li><?php } ?>
<?php } ?>
<?php if($MG['mail']) { ?>
<li class="side_a" id="mail"><span class="f_r"><a href="mail.php?action=list" class="m">列表</a></span><a href="mail.php" class="<?php if($MG['mail']) { ?>n<?php } else { ?>f<?php } ?>
">邮件订阅</a></li>
<?php } ?>
<?php if($MG['spread']) { ?>
<li class="side_a" id="spread"><span class="f_r"><a href="spread.php?action=list" class="m">购买</a></span><a href="spread.php" class="<?php if($MG['spread']) { ?>n<?php } else { ?>f<?php } ?>
">排名推广</a></li>
<?php } ?>
<?php if($MG['ad']) { ?>
<li class="side_a" id="ad"><span class="f_r"><a href="ad.php?action=list" class="m">购买</a></span><a href="ad.php" class="<?php if($MG['ad']) { ?>n<?php } else { ?>f<?php } ?>
">广告预定</a></li>
<?php } ?>
</ul>
</div>
<?php } ?>
<?php if($MG['homepage']) { ?>
<div class="side_head"><div><img src="image/side-home.png" align="absmiddle"/>商铺管理</div></div>
<div class="side_body">
<ul>
<?php if($MG['homepage']) { ?>
<li class="side_a" id="homepage"><span class="f_r"><a href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $_username;?>&update=1" class="m" target="_blank">预览</a></span><a href="home.php" class="<?php if($MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">商铺设置</a></li>
<?php } ?>
<?php if($MG['homepage']) { ?>
<li class="side_a" id="style"><span class="f_r"><a href="style.php?action=view" class="m">查看</a></span><a href="style.php" class="<?php if($MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">模板设置</a></li>
<?php } ?>
<?php if(($MG['news_limit']>-1 && $MG['homepage'])) { ?>
<li class="side_a" id="news"><span class="f_r"><a href="news.php?action=add" class="m">发布</a></span><a href="news.php" class="<?php if($MG['news_limit']>-1 && $MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">公司新闻</a></li>
<?php } ?>
<?php if(($MG['page_limit']>-1 && $MG['homepage'])) { ?>
<li class="side_a" id="page"><span class="f_r"><a href="page.php?action=add" class="m">添加</a></span><a href="page.php" class="<?php if($MG['page_limit']>-1 && $MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">公司单页</a></li>
<?php } ?>
<?php if(($MG['honor_limit']>-1 && $MG['homepage'])) { ?>
<li class="side_a" id="honor"><span class="f_r"><a href="honor.php?action=add" class="m">添加</a></span><a href="honor.php" class="<?php if($MG['honor_limit']>-1 && $MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">荣誉资质</a></li>
<?php } ?>
<?php if(($MG['link_limit']>-1 && $MG['homepage'])) { ?>
<li class="side_a" id="link"><span class="f_r"><a href="link.php?action=add" class="m">添加</a></span><a href="link.php" class="<?php if($MG['link_limit']>-1 && $MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">友情链接</a></li>
<?php } ?>
</ul>
</div>
<?php } ?>
<?php } else if($menu_id == 1) { ?>
<?php if($MYMODS) { ?>
<div class="side_head"><div><img src="image/side-post.png" align="absmiddle"/>信息管理</div></div>
<div class="side_body">
<ul>
<?php if(is_array($MENUMODS)) { foreach($MENUMODS as $k => $v) { ?>
<?php if($MODULE[$v]['module'] == 'club') { ?>
<li class="side_a"  id="mid_<?php echo $v;?>"><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $v;?>&job=group&action=add" class="m">创建</a></span><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $v;?>" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $MODULE[$v]['name'];?>管理</a></li>
<?php } else { ?>
<li class="side_a"  id="mid_<?php echo $v;?>"><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $v;?>&action=add" class="m">发布</a></span><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $v;?>" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $MODULE[$v]['name'];?>管理</a></li>
<?php } ?>
<?php } } ?>
<?php if($MG['resume']) { ?>
<?php if(is_array($MODULE)) { foreach($MODULE as $k => $v) { ?>
<?php if($v['module'] == 'job') { ?>
<li class="side_a"  id="resume_<?php echo $k;?>"><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $k;?>&job=resume&action=add" class="m">创建</a></span><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $k;?>&job=resume" class="n"><?php echo $v['name'];?>简历</a></li>
<?php } ?>
<?php } } ?>
<?php } ?>
</ul>
</div>
<?php } ?>
<?php } else { ?>
<?php if($_userid) { ?>
<div class="side_head"><div><img src="image/side-user.png" align="absmiddle"/>会员服务</div></div>
<div class="side_body">
<ul>
<?php if($MG['inbox_limit']>-1) { ?>
<li class="side_a" id="message"><span class="f_r"><a href="message.php?action=send" class="m">发信</a></span><a href="message.php" class="<?php if($MG['inbox_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">站内信件</a><?php if($_message) { ?><em><?php echo $_message;?></em><?php } ?>
</li>
<?php } ?>
<?php if($MG['chat']) { ?>
<?php if($DT['im_web']) { ?>
<li class="side_a" id="im"><span class="f_r"><a href="im.php?action=add" class="m">发起</a></span><a href="im.php" class="<?php if($MG['inbox_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">站内交谈</a><?php if($_chat) { ?><em><?php echo $_chat;?></em><?php } ?>
</li>
<?php } ?>
<?php } ?>

<?php if($MG['friend_limit']>-1) { ?>
<li class="side_a" id="friend"><span class="f_r"><a href="friend.php?action=add" class="m">添加</a></span><a href="friend.php" class="<?php if($MG['friend_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">我的商友</a></li>
<?php } ?>
<?php if($MG['favorite_limit']>-1) { ?>
<li class="side_a" id="favorite"><span class="f_r"><a href="favorite.php?action=add" class="m">添加</a></span><a href="favorite.php" class="<?php if($MG['favorite_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">商机收藏</a></li>
<?php } ?>

<?php if($show_oauth) { ?>
<li class="side_a" id="oauth"><span class="f_r"><a href="oauth.php" class="m">绑定</a></span><a href="oauth.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">一键登录</a></li>
<?php } ?>
<?php if($EXT['weixin']) { ?>
<li class="side_a" id="weixin"><span class="f_r"><a href="weixin.php" class="m">绑定</a></span><a href="weixin.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">微信关注</a></li>
<?php } ?>
<?php if($MG['ask']) { ?>
<li class="side_a" id="ask"><span class="f_r"><a href="ask.php?action=add" class="m">提问</a></span><a href="ask.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">客服中心</a></li>
<?php } ?>
<li class="side_a" id="edit"><span class="f_r"><a href="edit.php?tab=1" class="m">密码</a></span><a href="edit.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">修改资料</a></li>
<li class="side_a" id="account"><span class="f_r"><a href="validate.php" class="m">认证</a></span><a href="account.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">账户详情</a></li>
</ul>
</div>
<?php } ?>
<?php if($_userid) { ?>
<div class="side_head"><div><img src="image/side-deal.png" align="absmiddle"/>交易管理</div></div>
<div class="side_body">
<ul>
<li class="side_a" id="order"><span class="f_r"><a href="order.php?action=express" class="m">快递</a></span><a href="order.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">我的订单</a></li>
<?php if(is_array($MODULE)) { foreach($MODULE as $m) { ?>
<?php if($m['module'] == 'group') { ?>
<li class="side_a" id="deal-<?php echo $m['moduleid'];?>"><span class="f_r"><a href="deal.php?mid=<?php echo $m['moduleid'];?>&action=express" class="m">快递</a></span><a href="deal.php?mid=<?php echo $m['moduleid'];?>" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">团购订单</a></li>
<?php } ?>
<?php } } ?>
<li class="side_a" id="coupon"><span class="f_r"><a href="coupon.php?action=my" class="m">我的</a></span><a href="coupon.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">领券中心</a></li>
<li class="side_a" id="record"><span class="f_r"><a href="record.php?action=pay" class="m">站内</a></span><a href="record.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $DT['money_name'];?>流水</a></li>
<li class="side_a" id="charge"><span class="f_r"><a href="charge.php?action=pay" class="m">支付</a></span><a href="charge.php?action=record" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">支付记录</a></li>
<?php if($MG['cash']) { ?>
<li class="side_a" id="cash"><span class="f_r"><a href="cash.php" class="m">提现</a></span><a href="cash.php?action=record" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $DT['money_name'];?>提现</a></li>
<?php } ?>
<li class="side_a" id="credit"><span class="f_r"><a href="credit.php?action=buy" class="m">购买</a></span><a href="credit.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $DT['credit_name'];?>管理</a></li>
<?php if($MG['address_limit']>-1) { ?>
<li class="side_a" id="addr"><span class="f_r"><a href="address.php?action=add" class="m">添加</a></span><a href="address.php" class="<?php if($MG['address_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">收货地址</a></li>
<?php } ?>
</ul>
</div>
<?php } ?>
<?php } ?>
</td>
<td class="side_h" onclick="oh(this);" title="点击展开/隐藏侧栏" id="side_oh">&nbsp;</td>
<td valign="top" class="main" id="main">