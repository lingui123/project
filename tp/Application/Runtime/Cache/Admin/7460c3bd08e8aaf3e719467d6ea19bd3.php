<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>传智商城 - 后台管理系统</title>
	<link rel="stylesheet" href="/Public/Admin/css/style.css"/>
	<script src="/Public/Common/js/jquery.min.js"></script>
</head>
<body>
<div class="top">
	<h1 class="left">传智商城 <span>后台管理系统</span></h1>
	<ul class="right">
		<li>欢迎您：<?php echo ($admin_name); ?></li>
		<li><a href="/" target="_blank">前台首页</a></li>
		<li><a href="<?php echo U('Login/logout');?>">退出登录</a></li>
	</ul>
</div>
<div class="main">
	<div class="menu left">
		<div class="box">
			<div class="head"><i></i><div>管理菜单</div></div>
			<ul><li><a href="<?php echo U('Index/index');?>">后台首页</a></li>
				<li><a href="<?php echo U('Goods/add');?>" id="Goods_add">商品添加</a></li>
				<li><a href="<?php echo U('Goods/index');?>" id="Goods_index">商品列表</a></li>
				<li><a href="<?php echo U('Category/add');?>" id="Category_add">分类添加</a></li>
				<li><a href="<?php echo U('Category/index');?>" id="Category_index">分类列表</a></li>
				<li><a href="<?php echo U('Recycle/index');?>" id="Recycle_index">回收站</a></li>
				<li><a href="<?php echo U('User/index');?>" id="User_index">会员管理</a></li>
			</ul>
		</div>
	</div>
	<div class="content">
		<div class="item"><div class="title">商品列表</div>
<div class="top-button">
	选择商品分类：<select id="category">
		<option value="-1" >全部</option>
		<option value="0" <?php if(($cid) == "0"): ?>selected<?php endif; ?>>未分类</option>
		<?php if(is_array($category)): foreach($category as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(($v["id"]) == $cid): ?>selected<?php endif; ?>><?php echo str_repeat('— ',$v['level']); echo ($v["name"]); ?></option><?php endforeach; endif; ?>
	</select>
	<a href="<?php echo U('Goods/add',array('cid'=>$cid));?>" class="light">添加商品</a>
	<a href="<?php echo U('Category/add');?>">添加分类</a>
</div>
<div class="list full">
	<table>
		<tr><th class="t1">商品分类</th><th>商品名称</th><th width="100">库存</th><th width="60">上架</th><th width="60">推荐</th><th width="120">操作</th></tr>
		<?php if(is_array($goods["data"])): foreach($goods["data"] as $key=>$v): ?><tr><td class="t1">
				<?php if(empty($v["category_id"])): ?><a href="<?php echo U('Goods/index','cid=0');?>">未分类</a>
				<?php else: ?>
					<a href="<?php echo U('Goods/index',array('cid'=>$v['category_id']));?>"><?php echo ($v["category_name"]); ?></a><?php endif; ?>
			</td>
			<td><?php echo ($v["name"]); ?></td><td><?php echo ($v["stock"]); ?></td>
			<td><a href="#" class="act-onsale" data-id="<?php echo ($v["id"]); ?>" data-status="<?php echo ($v["on_sale"]); ?>"><?php if(($v["on_sale"]) == "1"): ?>是<?php else: ?>否<?php endif; ?></a></td>
			<td><a href="#" class="act-recommend" data-id="<?php echo ($v["id"]); ?>" data-status="<?php echo ($v["recommend"]); ?>"><?php if(($v["recommend"]) == "1"): ?>是<?php else: ?>否<?php endif; ?></a></td><td>
			<a href="<?php echo U('Goods/edit',array('id'=>$v['id'],'cid'=>$v['category_id'],'p'=>$p));?>">修改</a>　<a href="#" class="act-del" data-id="<?php echo ($v["id"]); ?>">删除</a></td></tr><?php endforeach; endif; ?>
	</table>
</div>
<div class="pagelist"><?php echo ($goods["pagelist"]); ?></div>
<form method="post" id="form">
	<input type="hidden" name="id" id="target_id">
	<input type="hidden" name="field" id="target_field">
	<input type="hidden" name="status" id="target_status">
</form>
<script>
	//下拉菜单跳转
	$("#category").change(function(){
		var url = "<?php echo U('Goods/index',array('cid'=>'_ID_'));?>";
		location.href = url.replace("_ID_",$(this).val());
	});
	//快捷操作
	function change_status(obj,field){
		$("#target_id").val(obj.attr("data-id"));
		$("#target_field").attr("value",field)
		$("#target_status").attr("value",(obj.attr("data-status")==1) ? 2 : 1);
		$("#form").attr("action","<?php echo U('Goods/change',array('p'=>$p,'cid'=>$cid));?>").submit();
	}
	//快捷操作-上架
	$(".act-onsale").click(function(){
		change_status($(this),'on_sale');
	});
	//快捷操作-推荐
	$(".act-recommend").click(function(){
		change_status($(this),'recommend');
	});
	//快捷操作-删除
	$(".act-del").click(function(){
		if(confirm('确定要删除吗？')){
			$("#target_id").val($(this).attr("data-id"));
			$("#form").attr("action","<?php echo U('Goods/del',array('p'=>$p,'cid'=>$cid));?>").submit();
		}
	});
</script></div>
	</div>
</div>
<script>
	$("#<?php echo (CONTROLLER_NAME); ?>_<?php echo (ACTION_NAME); ?>").addClass("curr");
</script>
</body>
</html>