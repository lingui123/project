<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>传智商城 - 注册</title>
	<link href="/Public/Home/css/user.css" rel="stylesheet" />
	<script src="/Public/Common/js/jquery.min.js"></script>
</head>
<body>
<div class="box">
	<h1>传智商城 - 欢迎注册</h1>
	<div class="main">
		<div class="register-ad left"><!--广告位--></div>
		<form method="post">
		<table class="register right">
			<tr><th>用户名：</th><td><input type="text" name="username" required /></td></tr>
			<tr><th>密码：</th><td><input type="password" name="password" id="pwd" required /></td></tr>
			<tr><th>确认密码：</th><td><input type="password" id="pwd2" required /></td></tr>
			<tr><th>验证码：</th><td><input type="text" name="verify" required /></td></tr>
			<tr><td> </td><td><img src="<?php echo U('User/getVerify');?>" id="verify_img" title="点击刷新验证码" /></td></tr>
			<tr><td> </td><td><input class="button" type="submit" value="注　册" /></td></tr>
			<tr><td colspan="2" class="center"><a href="<?php echo U('User/login');?>">返回登录</a><a href="/">返回首页</a></td></tr>
		</table>
		</form>
		<div class="clear"></div>
	</div>
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
//失去焦点时验证表单
$("#pwd2").blur(function(){
	if($(this).val() !== $("#pwd").val()){
		$(this).addClass('error');
	}else{
		$(this).removeClass('error');
	}
});
//表单提交时验证表单
$("form").submit(function(){
	if($("#pwd2").val() !== $("#pwd").val()){
		alert('两次输入密码不一致！');
		return false;
	}
});
</script>
</body>
</html>