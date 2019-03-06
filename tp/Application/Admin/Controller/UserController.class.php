<?php
namespace Admin\Controller;
//前台会员控制器
class UserController extends CommonController{
	public function index(){
		//取出会员信息
		$data = D('User')->getList();
		$this->assign($data);
		$this->display();
	}
}