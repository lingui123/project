<?php
namespace Home\Controller;
class UserController extends CommonController{
	//通过构造方法限制用户必须登录
	public function __construct() {
		parent::__construct();
		//指定不需要检查登录的方法列表
		$allow = array('login','getverify','getVerify','register');
		if($this->userinfo === false && !in_array(ACTION_NAME, $allow)){
			$this->error('请先登录！',U('User/login'));
		}
		$this->assign('title','会员中心 - 传智商城');
	}

	//会员中心首页
	public function index(){
		$this->display();
	}

	//查看用户ID
	public function addr(){
		$data['addr'] = D('User')->getAddr($this->userinfo['id']);
		$this->assign($data);
		$this->display();
	}

	//用户注册
	public function register(){
		if(IS_POST){
			//检查验证码
			if(false===$this->checkVerify(I('post.verify'))){
				$this->error('验证码错误',U('User/register')); //指定跳转地址，防止验证码不刷新
			}
			//实例化模型
			$User = D('User');		
			//判断用户名是否已经存在
			if($User->where(array('username'=>I('post.username')))->getField('id')){
				$this->error('注册失败：用户名已经存在。');
			}
			if(!$User->create()){
				$this->error('注册失败：'.$User->getError(),U('User/register'));
			}
			//取出用户名
			$username = $User->username;
			//添加数据并提取新用户ID
			if(!$id = $User->add()){
				$this->error('注册失败：保存到数据库失败',U('User/register'));
			}
			//注册成功后自动登录
			session('userinfo',array('id' => $id,'name' => $username));
			$this->redirect('Index/index');
		}
		$this->display();
	}

	//用户登录
	public function login(){
		if(IS_POST){
			if(false === $this->checkVerify(I('post.verify'))){
				$this->error('验证码错误'.U('User/login'));
			}
			//实例化模型
			$User = D('User');
			//创建数据对象
			if(!$User->create()){
				$this->error('登录失败：'.$User->getError(),U('User/login'));
			}
			if($userinfo = $User->checkLogin()){	//检查用户名密码
				session('userinfo',$userinfo);		//登录成功，将登录信息保存到session
				$this->redirect('Index/index');
			}
			$this->error('登录失败：用户名或密码错误！',U('User/login'));
		}
		$this->display();
	}

	//修改收件地址
	public function addrEdit(){
		if(IS_POST){
			$User = D('User');
			if(!$User->create(null,2)){
				$this->error('修改失败：'.$User->getError(),U('User/addrEdit'));
			}
			if(false===$User->where(array('id'=>$this->userinfo['id']))->save()){
				$this->error('修改失败',U('User/addrEdit'));
			}
			$this->redirect('User/addr');
		}
		$this->addr();
	}
	
	//生成验证码
    public function getVerify() {
        $Verify = new \Think\Verify();
		$Verify->entry();
    }
	//检查验证码
    private function checkVerify($code, $id = '') {
        $Verify = new \Think\Verify();
        return $Verify->check($code, $id);
    }
    //退出系统
	public function logout(){
		session(null); //清空前台所有会话
		$this->redirect('Index/index');
	}
}


		