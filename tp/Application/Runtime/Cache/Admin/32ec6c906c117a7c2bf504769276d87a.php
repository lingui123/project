<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>后台登录 - 传智商城</title>
	<link rel="stylesheet" href="/Public/Admin/css/style.css" />
	<script src="/Public/Common/js/jquery.min.js"></script>
</head>
<body class="login">
<div class="top">
	<h1 class="left">传智商城 <span>后台管理系统</span></h1>
</div>
<div class="box">
	<h1>欢迎访问后台</h1>
	<form method="post">
		<table>
			<tr><th width="80">用户名：</th><td><input class="input" type="text" name="username" required /></td></tr>
			<tr><th>密　码：</th><td><input class="input" type="password" name="password" required /></td></tr>
			<tr><th>验证码：</th><td><input class="input" type="text" name="verify" required /></td></tr>
			<tr><td> </td><td><img src="<?php echo U('Login/getVerify');?>" id="verify_img" title="点击刷新验证码"/></td></tr>
			<tr><td> </td><td><input class="login_btn" type="submit" value="登录" /></td></tr>
		</table>
	</form>
</div>
<script>
	//验证码点击刷新
	$(function(){
		var img = $("#verify_img");
		var src = img.attr("src")+"?";
		img.click(function(){
			img.attr("src",src+Math.random());
		});
	});
</script>
</body>
</html>