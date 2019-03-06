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
		<div class="title">我的购物车</div>
		<form method="post" action="<?php echo U('Order/buy');?>">
			<table class="shopcart">
				<tr><th width="60"><a href="#" class="checkAll">全选</a></th>
				<th>商品</th><th width="150">单价(元)</th><th width="95">数量</th><th width="120">操作</th></tr>
				<?php if(is_array($cart)): foreach($cart as $k=>$v): ?><tr class="item">
					<td class="center"><input type="checkbox" name="buy[<?php echo ($k); ?>][id]" class="check" value="<?php echo ($v["goods_id"]); ?>" /></td>
					<td><a href="/?a=goods&id=<?php echo ($v["goods_id"]); ?>" target="_blank" class="bold"><?php echo ($v["name"]); ?></a></td>
					<td class="center"><span class="item-price"><?php echo ($v["price"]); ?></span></td>
					<td class="center">
						<button class="setNum">-</button>
						<input name="buy[<?php echo ($k); ?>][num]" class="item-num" type="text" value="<?php echo ($v["num"]); ?>" />
						<button class="setNum">+</button>
					</td>
					<td class="center"><a href="<?php echo U('Cart/del',array('id'=>$v['id']));?>" />删除</a></td>
					</tr><?php endforeach; endif; ?>
				<tr class="act"><td class="center"><a href="#" class="checkAll">全选</a></td>
				<td colspan="4">
					共<span id="num"></span>件商品 总计：<span class="price">￥<span id="monery"></span></span>
					<input type="submit" value="提交订单" class="order-btn" />
				</td></tr>
			</table>
		</form>
	</div>
</div>
<script>
(function(){
	var $check = $(".check");  //获取复选框对象
	var isCheckAll = false;    //当前是否全选
	$check.click(total);	   //单击复选框时更新总价格
	checkAll();				   //默认设为全选
	//全选、全不选
	$(".checkAll").click(checkAll);
	function checkAll(){
		isCheckAll = isCheckAll ? false : true;
		$check.prop("checked", isCheckAll);
		$check.attr("checked", isCheckAll);
		total();  //更新价格
	}
	//单击修改数量
	$(".setNum").click(function(){
		var $item = $(this).parent().find(".item-num");
		var act = $(this).text();
		var num = parseInt($item.val());
		var stock = 100;
		if (act === '-') {
			if (num === 1) return false;
			$item.val(num-1);
		}else if (act === '+') {
			if (num === stock) return false;
			$item.val(num+1);
		}
		total();
		return false;
	});
	//键盘修改数量
	$(".item-num").keyup(function(){
		var num = parseInt($(this).val());
		var stock = 100;
		if(num < 1){
			$(this).val(1);
		}else if(num > stock){
			$(this).val(stock);
		}
		total();
	});
	//计算总价
	function total() {
		var count = 0; //总数量
		var total = 0; //总价格
		//遍历勾选的商品
		$(".check:checked").each(function(){
			var $item = $(this).parents(".item");
			var price = parseFloat($item.find(".item-price").text());
			var num = parseInt($item.find(".item-num").val());
			count += num;
			total += price * num;
		});
		$("#monery").text(total.toFixed(2));
		$("#num").text(count);
	}
})();
</script>
	<div class="service">
		<ul><li>购物指南</li><li>配送方式</li><li>支付方式</li>
			<li>售后服务</li><li>特色服务</li><li>网络服务</li>
		</ul>
	</div>
</div>
</body>
</html>