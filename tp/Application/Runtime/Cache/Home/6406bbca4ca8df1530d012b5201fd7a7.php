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
<div class="find">
<div class="find-left left"><div class="title">相关商品推荐</div>
	<?php if(is_array($goods["recommend"])): foreach($goods["recommend"] as $key=>$v): ?><ul class="item left">
		<li><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php if(empty($v["thumb"])): ?><img src="/Public/Common/img/preview.jpg"><?php else: ?><img src="/Public/Uploads/small/<?php echo ($v["thumb"]); ?>"><?php endif; ?></a></li>
		<li class="goods"><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php echo ($v["name"]); ?></a></li>
		<li class="price">￥<?php echo ($v["price"]); ?></li>
	</ul><?php endforeach; endif; ?>
</div>
<div class="find-right left">
	<ul class="filter">
		<li class="filter-title">商品列表</li>
		<?php if(!empty($category["parent"])): if(is_array($category["parent"])): $i = 0; $__LIST__ = $category["parent"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><p>分类<?php echo ($i); ?>：</p>
				<?php if(is_array($v)): foreach($v as $key=>$vv): ?><a href="<?php echo mkFilterURL('cid',$vv['id']);?>" class="cid-<?php echo ($vv["id"]); ?>" ><?php echo ($vv["name"]); ?></a><?php endforeach; endif; ?></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
		<li><p>价格：</p><a href="<?php echo mkFilterURL('price');?>" class="price-0">全部</a>
			<?php if(is_array($goods["price"])): foreach($goods["price"] as $key=>$v): ?><a href="<?php echo mkFilterURL('price',$v);?>" class="price-<?php echo ($v); ?>"><?php echo ($v); ?></a><?php endforeach; endif; ?>
		</li>
		<li><p>排序：</p><a
			href="<?php echo mkFilterURL('order');?>" class="order-0">最新上架</a><a 
			href="<?php echo mkFilterURL('order','price-asc');?>" class="order-price-asc">价格升序</a><a
			href="<?php echo mkFilterURL('order','price-desc');?>" class="order-price-desc">价格降序</a>
		</li>
	</ul>
	<div class="find-item">
		<?php if(empty($goods["data"])): ?><div class="empty-tip">没有找到您需要的商品。</div>
		<?php else: ?>
		<?php if(is_array($goods["data"])): foreach($goods["data"] as $key=>$v): ?><ul class="item left">
			<li><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php if(empty($v["thumb"])): ?><img src="/Public/Common/img/preview.jpg"><?php else: ?><img src="/Public/Uploads/small/<?php echo ($v["thumb"]); ?>"><?php endif; ?></a></li>
			<li class="goods"><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php echo ($v["name"]); ?></a></li>
			<li class="price">￥<?php echo ($v["price"]); ?></li>
		</ul><?php endforeach; endif; ?>
		<div class="clear"></div>
		<div class="pagelist"><?php echo ($goods["pagelist"]); ?></div><?php endif; ?>
	</div>
</div>
</div>
<script>
//导航条选中效果
$("#Index_find").addClass("category-curr");
//筛选列表，分类的当前选中效果
<?php if(is_array($category["pids"])): foreach($category["pids"] as $key=>$v): ?>$(".cid-<?php echo ($v); ?>").addClass("curr");<?php endforeach; endif; ?>
//商品价格的选中效果
<?php if(isset($_GET['price'])): ?>$(".price-<?php echo ($_GET['price']); ?>").addClass("curr");
<?php else: ?>
	$(".price-0").addClass("curr");<?php endif; ?>
//商品排序的选中效果
<?php if(isset($_GET['order'])): ?>$(".order-<?php echo ($_GET['order']); ?>").addClass("curr");
<?php else: ?>
	$(".order-0").addClass("curr");<?php endif; ?>
</script>
	<div class="service">
		<ul><li>购物指南</li><li>配送方式</li><li>支付方式</li>
			<li>售后服务</li><li>特色服务</li><li>网络服务</li>
		</ul>
	</div>
</div>
</body>
</html>