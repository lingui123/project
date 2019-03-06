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
		<div class="item"><div class="title">商品分类</div>
<div class="top-button">
	相关操作：<a href="<?php echo U('Category/add');?>" class="light">添加分类</a>
</div>
<div class="list full auto">
	<table>
		<tr><th>分类名称</th><th>操作</th></tr>
		<?php if(is_array($category)): foreach($category as $key=>$v): ?><tr><td><?php echo str_repeat('— ',$v['level']); echo ($v["name"]); ?></td><td><a href="<?php echo U('Category/edit',array('id'=>$v['id']));?>">修改</a>　<a href="#" class="act-del" data-id="<?php echo ($v["id"]); ?>" >删除</a></td></tr><?php endforeach; endif; ?>
	</table>
</div>
<form method="post" id="form">
	<input type="hidden" name="id" id="target_id">
</form>
<script>
	//删除
	$(".act-del").click(function(){
		if(confirm('确定要删除吗？（该分类下的商品将归于未分类）')){
			$("#target_id").val($(this).attr("data-id"));
			$("#form").attr("action","<?php echo U('Category/del');?>").submit();
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