<?php
namespace Admin\Model;
use Think\Model;
// 后台用户登录  
class adminModel extends Model{
	//自动验证
	protected $_validate = array(
		array('username','/^\w{4,10}$/','用户名不合法（4~10位，英文、数字、下划线）',self::MUST_VALIDATE), //self::MUST_VALIDATE的值为1
		array('password','/^\w{6,12}$/','密码不合法（6~12位，英文、数字、下划线）',self::MUST_VALIDATE),
	);

	//判断管理员用户名和密码
	public function checkLogin(){
		//当执行create()方法后，$this->data就保存了从表单提交过来的数据
		$username = $this->data['username'];	//表单提交的用户名
		$password = $this->data['password'];	//表单提交的密码 
		$data = $this->field('password,salt')->where(array('username' => $username))->find();	//根据用户名查询密码
		//判断密码
		if($data){	
			return $data['password'] == $this->password($password,$data['salt']);
		} 
		return false;
	}
	//密码加密函数
	private function password($password,$salt){
		return md5(md5($password).$salt);
	}
} 
