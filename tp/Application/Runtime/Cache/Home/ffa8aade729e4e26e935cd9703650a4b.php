<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title><?php echo ($title); ?></title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/Home/css/style.css"/>
	<script src="/Public/Common/js/jquery.min.js"></script>
</head>
<body>
<div class="top">
	<div class="top-nav">
	<ul><li>收藏本站</li><li>关注本站</li></ul>
	<ul class="right">
		<?php if(isset($userinfo["id"])): ?><li><?php echo ($userinfo["name"]); ?>，欢迎来到传智商城！[<a href="<?php echo U('User/logout');?>">退出</a>]<li>
		<?php else: ?>
		<li>您好，欢迎来到传智商城！[<a href="<?php echo U('User/login');?>">登录</a>][<a href="<?php echo U('User/register');?>">免费注册</a>]</li><?php endif; ?>
		<li class="line">|</li><li><a href="<?php echo U('Order/index');?>">我的订单</a></li>
		<li class="line">|</li><li><a href="<?php echo U('User/index');?>">会员中心</a></li>
		<li class="line">|</li><li><a href="<?php echo U('Cart/index');?>">我的购物车</a></li>
		<li class="line">|</li><li>联系客服</li>
	</ul>
	</div>
</div>
<div class="box">
	<div class="header">
		<a class="left" href="/"><div class="logo"></div></a>
		<div class="search left">
			<input type="text" class="left" />
			<input class="search-btn" type="button" value="搜索" />
			<p class="search-hot">热门搜索：PHP培训　专业教材　智能手机　平板电脑</p>
		</div>
		<div class="info left">
			<input type="button" value="会员中心" onclick="location.href='<?php echo U('User/index');?>'" />
			<input type="button" value="去购物车结算" onclick="location.href='<?php echo U('Cart/index');?>'" />
		</div>
	</div>
	<div class="nav">
		<ul><li id="Index_find"><a class="category" href="<?php echo U('Index/find');?>">全部商品分类</a></li><li id="Index_index"><a href="/">首页</a></li>
			<li><a href="#">特色购物</a></li><li><a href="#">优惠促销</a></li><li><a href="#">限时秒杀</a></li>
			<li><a href="#">品牌专区</a></li><li><a href="#">服务中心</a></li>
		</ul>
	</div>
<div class="usercenter">
<div class="menu">
	<div class="menu-photo">
		<img src="/Public/Home/img/avatar.png" alt="用户头像" />
	</div>
	<dl><dt>我的交易</dt>
		<dd><a href="<?php echo U('Cart/index');?>">我的购物车</a></dd>
		<dd><a href="<?php echo U('Order/index');?>">我的订单</a></dd>
		<dd>评价管理</dd>
	</dl>
	<dl><dt>我的账户</dt>
		<dd><a href="<?php echo U('User/index');?>">个人信息</a></dd>
		<dd>密码修改</dd>
		<dd><a href="<?php echo U('User/addr');?>">收货地址</a></dd>
	</dl>
</div>
	<div class="content">
		<div class="title">我的订单</div>
		<?php if(empty($order)): ?><div class="showinfo"><p>您目前没有订单。</p></div>
		<?php else: ?>
			<?php if(is_array($order)): foreach($order as $key=>$v): ?><table class="order-top">
					<tr><th>订单号码：<span>ITCAST<?php echo ($v["id"]); ?></span>　下单时间：<span><?php echo ($v["add_time"]); ?></span></td>
					<td width="300" class="act">订单总价：<strong>￥<?php echo ($v["price"]); ?></strong>　<a href="#">立即支付</a>　<a href="#" data-id="<?php echo ($v["id"]); ?>" class="cancel">取消订单</a></td></tr>
				</table>
				<table class="order">
					<?php if(is_array($v["goods"])): foreach($v["goods"] as $key=>$vv): ?><tr><td><a href="/?a=goods&id=<?php echo ($vv["id"]); ?>" target="_blank"><?php echo ($vv["name"]); ?></a></td>
						<td class="center" width="100"><?php echo ($vv["num"]); ?>件</td><td class="center" width="100"><span>￥<?php echo ($vv["price"]); ?></span></td></tr><?php endforeach; endif; ?>
					<tr><td colspan="3">收件地址：<?php echo ($v["address"]["address"]); ?>，收件人：<?php echo ($v["address"]["consignee"]); ?>，联系电话：<?php echo ($v["address"]["phone"]); ?></td></tr>
				</table><?php endforeach; endif; endif; ?>
	</div>
	<form method="post" id="form">
		<input type="hidden" id="target" name="id">
	</form>
</div>
<script>
$(".cancel").click(function(){
	if(confirm('您确定要取消订单？')){
		$("#target").val($(this).attr("data-id"));
		$("#form").attr("action","<?php echo U('Order/cancel');?>").submit();
	}
});
</script>
	<div class="service">
		<ul><li>购物指南</li><li>配送方式</li><li>支付方式</li>
			<li>售后服务</li><li>特色服务</li><li>网络服务</li>
		</ul>
	</div>
</div>
</body>
</html>