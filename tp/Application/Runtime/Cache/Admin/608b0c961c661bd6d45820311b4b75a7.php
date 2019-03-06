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
		<div class="item"><div class="title">修改商品</div>
<div class="top-button">
	修改商品分类：<select id="category">
		<option value="0">未分类</option>
		<?php if(is_array($category)): foreach($category as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(($v["id"]) == $cid): ?>selected<?php endif; ?>><?php echo str_repeat('— ',$v['level']); echo ($v["name"]); ?></option><?php endforeach; endif; ?>
	</select>
	<a href="<?php echo U('Goods/index',array('cid'=>$cid,'p'=>$p));?>" class="light">返回商品列表</a>
</div>
<?php if(isset($success)): ?><div class="mssage">修改成功。</div><?php endif; ?>
<div class="list auto">
	<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo ($goods["id"]); ?>">
	<table class="t2 t4">
		<tr><th>商品名称：</th><td><input type="text" name="name" value="<?php echo ($goods["name"]); ?>" class="big"></td></tr>
		<tr><th>商品编号：</th><td><input type="text" name="sn" value="<?php echo ($goods["sn"]); ?>" ></td></tr>
		<tr><th>商品价格：</th><td><input type="text" name="price" value="<?php echo ($goods["price"]); ?>" class="small"></td></tr>
		<tr><th>商品库存：</th><td><input type="text" name="stock" value="<?php echo ($goods["stock"]); ?>" class="small"></td></tr>
		<tr><th>是否上架：</th><td><select name="on_sale">
			<option value='1' <?php if(($goods["on_sale"]) == "1"): ?>selected<?php endif; ?>>是</option>
				<option value='2' <?php if(($goods["on_sale"]) == "2"): ?>selected<?php endif; ?>>否</option>
		</select></td></tr>
		<tr><th>首页推荐：</th><td><select name="recommend">
			<option value='1'<?php if(($goods["recommend"]) == "1"): ?>selected<?php endif; ?>>是</option>
			<option value='2'<?php if(($goods["recommend"]) == "2"): ?>selected<?php endif; ?>>否</option>
		</select></td></tr>
		<tr><th>修改图片：</th><td><input type="file" name="thumb" /></td></tr>
		<tr><th>当前图片：</th><td>
			<?php if(empty($goods["thumb"])): ?><img src="/Public/Common/img/preview.jpg">
			<?php else: ?>
				<img src="/Public/Uploads/small/<?php echo ($goods["thumb"]); ?>"><?php endif; ?>
		</td></tr>
	</table>
	<div class="editor">
		<link href="/Public/Admin/js/umeditor/themes/default/css/umeditor.min.css" rel="stylesheet">
<script src="/Public/Admin/js/umeditor/umeditor.config.js"></script>
<script src="/Public/Admin/js/umeditor/umeditor.min.js"></script>
<script>
	$(function(){
		//载入在线编辑器
		UM.getEditor("myEditor",{
		"imageUrl":"<?php echo U('Goods/uploadImage');?>", //图片上传提交地址
		"imagePath":"/Public/Uploads/desc/"  //图片显示地址
		});
	});
</script>
		<script type="text/plain" id="myEditor" name="desc"><?php echo ($goods["desc"]); ?></script>
	</div>
	<div class="btn">
		<input type="submit" value="保存修改">
		<input type="submit" value="修改并返回" name="return">
	</div>
	</form>
</div>
<script>
	//下拉菜单跳转
	$("#category").change(function(){
		var url = "<?php echo U('Goods/edit',array('id'=>$id,'cid'=>'_ID_','p'=>$p));?>";
		location.href = url.replace("_ID_",$(this).val());
	});
</script></div>
	</div>
</div>
<script>
	$("#<?php echo (CONTROLLER_NAME); ?>_<?php echo (ACTION_NAME); ?>").addClass("curr");
</script>
</body>
</html>