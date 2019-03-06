<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller{
	protected $userinfo = false;  //用户登录信息（未登录为false）
	//构造方法
	public function __construct() {
		parent::__construct();
		//登录检查
		$this->checkUser();
	}

	private function checkUser(){
		if(session('?userinfo')){
			//将用户信息保存到成员变量
			$this->userinfo = session('userinfo');
			//将用户信息分配到模板
			$this->assign('userinfo',$this->userinfo);
		}
	}
}