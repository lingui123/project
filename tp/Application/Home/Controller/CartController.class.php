<?php
namespace Home\Controller;
class CartController extends CommonController{
	//通过构造方法限制用户必须登录
	public function __construct() {
		parent::__construct();
		//指定不需要检查登录的方法列表
		if($this->userinfo === false)
		$this->error('请先登录！',U('User/login'));
	}
	//添加到购物车
	public function add(){
		$id = I('get.id/d',0);
		$num = I('get.num/d',0);
		$rst = D('Shopcart')->addCart($id,$this->userinfo['id'],$num);
		if($rst === false){
			$this->error('添加购物车失败！');
		}
		$this->success('添加购物车成功！');
	}
	//购物车列表
	public function index(){
		$data['cart'] = D('Shopcart')->getList($this->userinfo['id']);
		$this->assign($data);
		$this->display();
	}
	//从购物车删除
	public function del(){
		$id=I('get.id/d',0);
		$where = array('id'=>$id,'user_id'=>$this->userinfo['id']);
		if(false===M('Shopcart')->where($where)->delete()){
			$this->error('删除失败');	
		}
		$this->redirect('Cart/index');
	}
}