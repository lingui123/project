<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	//表单字段过滤
	protected $insertFields = 'username,password';
	protected $updateFields = 'phone,email,consignee,address';
	protected $_validate = array(
		//注册时验证(1表示self::MODEL_INSERT)
		array('username','2,20','用户名位数不合法（2~20位）',self::MUST_VALIDATE,'length',1),
		array('username','/^[\w\x{4e00}-\x{9fa5}]+$/u','用户名只能是汉字、字母、数字、下划线。',self::MUST_VALIDATE,'regex',1),
		array('password','6,20','密码位数不合法（6~20位）',self::MUST_VALIDATE,'length',1),
		array('password','/^\w+$/','密码只能是字母、数字、下划线。',self::MUST_VALIDATE,'regex',1),
		//更新时验证
		array('email', 'email', '邮箱格式不正确', self::MUST_VALIDATE, 'regex', self::MODEL_UPDATE),
		array('phone', 11, '手机号码格式不正确', self::MUST_VALIDATE, 'length', self::MODEL_UPDATE),
		array('consignee','require','收件人不能为空',self::MUST_VALIDATE,'regex',self::MODEL_UPDATE),
		array('phone','require','手机号不能为空',self::MUST_VALIDATE,'regex',self::MODEL_UPDATE),
		array('address','require','收件地址不能为空',self::MUST_VALIDATE,'regex',self::MODEL_UPDATE),
		//……
	);

	//获取收件地址
	public function getAddr($id){
		//取出数据（收件人，收件地址，邮箱，手机号码）
		$data = $this->field('consignee,address,email,phone')->where("id=$id")->find();
		//dump($data);exit;
		//分割“收件地址”字符串
		$data['area'] = explode(',',$data['address'],4); //最多分割4次 
		if(count($data['area'] != 4)){
			$data['area'] = array('','请选择','请选择');
		}
		return $data;
	}

	//判断前台用户的用户名和密码
	public function checkLogin(){
		$username = $this->data['username']; //表单提交的用户名
		$password = $this->data['password']; //表单提交的密码 
		//根据用户名查询密码等信息
		$data = $this->field('id,password,salt')->where(array('username' => $username))->find();
		//判断密码
		if($data && $data['password'] == $this->password($password,$data['salt'])){
			return array('id' => $data['id'],'name' => $username);
		}
		return false;								
	}
	
	//密码加密函数
	private function password($pwd,$salt){
		return md5(md5($pwd).$salt);
	}
	//插入数据前的回调方法
	protected function _before_insert(&$data,$option){
		$data['salt'] = substr(uniqid(), -6);
		$data['password'] = $this->password($data['password'],$data['salt']);
	}
}