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
		<div class="item"><div class="title">分类修改</div>
<div class="top-button">
	相关操作：<a href="<?php echo U('Category/index');?>" class="light">分类列表</a>
</div>
<div class="list auto">
	<form method="post">
	<input type="hidden" name="id" value="<?php echo ($id); ?>">
	<table class="t2 t3">
		<tr><th>上级分类：</th><td>
			<select name="pid">
				<option value="0">顶级分类</option>
				<?php if(is_array($category)): foreach($category as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(($v["id"]) == $pid): ?>selected<?php endif; ?> ><?php echo str_repeat('— ',$v['level']); echo ($v["name"]); ?></option><?php endforeach; endif; ?>
			</select>
		</td></tr>
		<tr><th>分类名称：</th><td><input type="text" name="name" value="<?php echo ($name); ?>"></td></tr>
	</table>
	<div class="btn">
		<input type="submit" value="修改分类">
		<input type="reset" value="重新填写">
	</div>
	</form>
</div></div>
	</div>
</div>
<script>
	$("#<?php echo (CONTROLLER_NAME); ?>_<?php echo (ACTION_NAME); ?>").addClass("curr");
</script>
</body>
</html>