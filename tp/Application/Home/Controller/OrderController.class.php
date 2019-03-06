<?php
namespace Home\Controller;
class OrderController extends CommonController{
	//构造方法
	public function __construct(){
		parent::__construct();
		if($this->userinfo === false){
			$this->error('请先登录!',U('User/login'));
		}
		$this->assign('title','我的订单-传智商城');
	}

	//查看订单
	public function index(){
		//取出订单列表
		$data = M('Order')->where(array('user_id'=>$this->userinfo['id'],'cancel'=>2))->order('id desc')->select();
		foreach($data as $k=>$v){
			$data[$k]['goods'] = unserialize($data[$k]['goods']);
			$data[$k]['address'] = unserialize($data[$k]['address']);
			//dump($data[$k]['address']);exit;
		}
		$this->assign('order',$data);
		$this->display();
	}

	//购买商品（单件或多件商品）
	public function buy(){
		$buy = $this->input();
		//实例化模型
		$Goods = M('Goods');
		$Order = M('Order');
		//检查表单令牌
		$this->checkToken($Order);    
		//当前用户
		$uid = $this->userinfo['id'];
		//准备待写入数据库的数据
		$data = array(
			'price' => 0,		//订单总价格
			'payment' => 2,		//订单未支付
			'cancel' => 2,		//订单未取消
			'user_id' => $uid,	//购买者的用户ID
		);
		//获取收件人信息（收件人，收件地址，手机）
		$data['address'] = M('User')->field('consignee,address,phone')->where(array('id'=>$uid))->find();
		//如果没有收件人，则不允许购买
		foreach(array('consignee','address','phone') as $v){
			if(empty($data['address'][$v])){
				$this->error('请先完善收货地址。',U('User/addr'));
			}
		}
		$Order->startTrans(); //开启事务
		//处理每件商品
		foreach ($buy as $id => $num) {
			//查询出商品的名称、价格
			$goods = $Goods->field('name,price')->where(array('id'=>$id))->find();
			if(empty($goods)){
				$Order->db()->rollBack();  //回滚
				$this->error("您购买的商品不存在，错误的商品ID：{$id}");
			}
			//组合商品信息
			$data['goods'][] = array(
				'id' => $id,		 //商品ID
				'num' => $num,	 	 //购买数量
				'name' => $goods['name'],	 //商品名
				'price' => $goods['price'],	 //价格
			);
			//准备库存操作的where条件
			$where = array(
				'id' => $id,                  //商品ID
				'stock' => array('EGT',$num), //库存不低于购买数量
				'recycle' => 2,            	  //商品未在回收站中
				'on_sale' => 1,               //商品已经上架
			);
			//更新库存
			if(!$Goods->where($where)->setDec('stock',$num)){
				$Order->rollback();	//回滚
				$this->error('执行失败，商品“'.$goods['name'].'”库存不足!');
			}
			//价格自增
			$data['price'] += $goods['price'] * $num;
		}
		//数组序列化
		$data['address'] = serialize($data['address']);
		$data['goods'] = serialize($data['goods']);
		//保存订单
		if(!$Order->data($data)->add()){
			$Order->rollBack();	//回滚
			$this->error('执行失败，生成订单失败！');
		}
		$Order->commit();    //提交事务
		//生成订单成功，删除购物车中的记录
		M('Shopcart')->where(array('goods_id'=>array('IN',array_keys($buy)),'user_id'=>$uid))->delete();
		$this->success('订单生成成功',U('Order/index'));
	}
	
	//取消订单
	public function cancel(){
		$id = I('post.id/d',0);
		$Goods = M('Goods');
		$Order = M('Order');
		$this->checkToken($Order); //检查表单令牌
		
		//将订单中的商品返库存
		$data_order = $Order->where(array('id'=>$id,'user_id'=>$this->userinfo['id']))->find();
		$data_goods = unserialize($data_order['goods']);
		foreach($data_goods as $v){
			$Goods->where(array('id' => $v['id']))->setInc('stock', $v['num']);
		}
		//取消订单（如果有订单回收站功能，则执行此步骤）
		if(false === $Order->where(array('id'=>$id,'user_id'=>$this->userinfo['id']))->save(array('cancel'=>1))){
			$this->error('取消失败');
		}
		//删除订单（如果没有订单回收站功能，则执行此步骤）
		$Order->where(array('id'=>$id,'user_id'=>$this->userinfo['id']))->delete();

		$this->redirect('Order/index');
	}

	private function checkToken($Model){
		//检查表单令牌
		if(!$Model->autoCheckToken($_POST)){
			$this->error('表单已过期，请重新提交');
		}
	}

	//获取购买信息，并过滤数据
	private function input(){
		$buy = I('post.buy/a'); //获取参数
		$data = array();  //保存关联数组结果 array(id=>num)
		//从参数中取出每件商品的ID和购买数量
		foreach($buy as $v){
			if(isset($v['id']) && isset($v['num'])){				
				$v['id'] = max((int)$v['id'],0);   //商品ID不能为负数
				$v['num'] = max((int)$v['num'],1); //购买数量最少为1
				$data[$v['id']] = $v['num'];
			}else{
				continue;
			}
		}
		return $data;
	}
}