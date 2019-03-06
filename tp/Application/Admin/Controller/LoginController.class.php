<?php
namespace Admin\Controller;
use Think\Controller;
// 后台用户登录 
class LoginController extends Controller{
	//登录页
	public function index() {
		if(IS_POST){	
			//检查验证码
			if(false === $this->checkVerify(I('post.verify'))){
				$this->error('验证码错误',U('Login/index'));
			}
			$Admin = D('Admin');	//实例化模型
			if(!$Admin->create()){
				$this->error('登录失败:'.$Admin->getError(), U('Login/index'));
			}
			//检查用户名密码
			$username = $Admin->username;	//获取用户名
			if($Admin->checkLogin()){		
			//登录成功，将用户名保存到session
				session('userinfo',array('name' => $username));
				$this->redirect('Index/index');
			}
			$this->error('登录失败：用户名或密码错误! ',U('Login/index'));
		}
		$this->display();
	}
	//生成验证码
	public function getVerify(){
		$Verify =     new \Think\Verify();

		$Verify->entry();
	}
	// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
	private function checkVerify($code, $id = ''){
		$verify = new \Think\Verify();
    	return $verify->check($code, $id);
	}
	//退出系统 
	public function logout(){
		session(null);	//清空后台所以会话
		$this->redirect('Login/index');
	}
}