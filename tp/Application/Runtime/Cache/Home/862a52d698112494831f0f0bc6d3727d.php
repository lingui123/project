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
<div class="goodsinfo">
	<div class="now_cat">当前位置：<?php if(is_array($path)): foreach($path as $key=>$v): ?>&nbsp;<a 
		href="<?php echo U('Index/find',array('cid'=>$v['id']));?>"><?php echo ($v["name"]); ?></a>&nbsp;&gt;<?php endforeach; endif; ?>&nbsp;<?php echo ($goods["name"]); ?></div>
	<div class="pic left"><?php if(empty($goods["thumb"])): ?><img src="/Public/Common/img/preview2.jpg" /><?php else: ?>
		<img src="/Public/Uploads/big/<?php echo ($goods["thumb"]); ?>" /><?php endif; ?></div>
	<div class="info left"><h1><?php echo ($goods["name"]); ?></h1><table>
		<tr><th>售 价：</th><td><span class="price">￥<?php echo ($goods["price"]); ?></span></td></tr>
		<tr><th>商品编号：</th><td><?php echo ($goods["sn"]); ?></td></tr>
		<tr><th>累计销量：</th><td>1000</td></tr>
		<tr><th>评 价：</th><td>1000</td></tr>
		<tr><th>配送至：</th><td>北京（免运费）</td></tr>
		<tr><th>购买数量：</th><td>
			<input type="button" value="-" class="cnt-btn" />
			<input type="text" value="1" id="num" class="num-btn" />
			<input type="button" value="+" class="cnt-btn" />（库存：<?php echo ($goods["stock"]); ?>）</td></tr>
		<tr><td colspan="2" class="button"><a href="#" id="buy">立即购买</a><a href="#" id="addCart">加入购物车</a></td></tr>
		</table></div>
		<form method="post" action="<?php echo U('Order/buy');?>" id="form_buy">
			<input type="hidden" name="buy[0][id]" value="<?php echo ($goods["id"]); ?>">
			<input type="hidden" name="buy[0][num]" value="" id="form_num">
		</form>
		<!--二维码-->
		<!-- <div class="qr">
			<img src="/Public/Uploads/qr/<?php echo genIdPath($goods['id']);?>.png">
			<span>扫一扫，手机购物</span>
		</div> -->
		<div class="clear"></div>
	<div class="goods-slide left"><div class="title">相关商品推荐</div>
		<?php if(is_array($recommend)): foreach($recommend as $key=>$v): ?><ul class="item left">
			<li><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php if(empty($v["thumb"])): ?><img src="/Public/Common/img/preview.jpg"><?php else: ?><img src="/Public/Uploads/small/<?php echo ($v["thumb"]); ?>"><?php endif; ?></a></li>
			<li class="goods"><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php echo ($v["name"]); ?></a></li>
			<li class="price">￥<?php echo ($v["price"]); ?></li>
		</ul><?php endforeach; endif; ?>
	</div>
	<div class="desc left"><div class="title">商品详情</div><div class="content"><?php echo ($goods["desc"]); ?></div></div>
	<div class="clear"></div>
</div>
<script>
//导航条选中效果
$("#Index_find").addClass("category-curr");
//购买数量加减
$(".cnt-btn").click(function(){
	var num = parseInt($("#num").val());
	if ($(this).val() === '-') {
		if ( num=== 1) return;
		$("#num").val(num-1);
	}else if ($(this).val() === '+') {
		if (num === <?php echo ($goods["stock"]); ?>) return;
		$("#num").val(num+1);
	}
});
//自动纠正购买数量
$("#num").keyup(function(){
	var num = parseInt($(this).val());
	if(num<1){ 
		$(this).val(1);
	}else if(num > <?php echo ($goods["stock"]); ?>){
		$(this).val(<?php echo ($goods["stock"]); ?>);
	}
});
//添加购物车
$("#addCart").click(function(){
	var url = "<?php echo U('Cart/add',array('id'=>$goods['id'],'num'=>'_NUM_'));?>";
	window.location.href = url.replace("_NUM_",$("#num").val());
});
//点击购买按钮时，构造表单并提交
$("#buy").click(function(){
	$("#form_num").val($("#num").val());
	$("#form_buy").submit();
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