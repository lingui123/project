<?php
namespace Home\Model;
use Think\Model;
class ShopcartModel extends Model{
	//添加到购物车
	public function addCart($gid,$uid,$num){
		//判断购物车中是否已经有该类商品
		$rst = $this->where(array('goods_id' => $gid,'user_id' => $uid))->field('id,goods_id,num')->find();
		//存在商品时，增加购买数量
		if($rst){
			$num += $rst['num'];
			return $this->where(array('id' => $rst['id']))->save(array('num' => $num));
		}
		//不存在时添加到购物车
		return $this->add(array('user_id'=>$uid,'goods_id'=>$gid,'num'=>$num));
	}
	//从购物车获得商品信息
	public function getList($uid){
		return $this->alias('c')
				->join('__GOODS__ AS g ON g.id=c.goods_id','LEFT')
				->field('g.name,g.price,c.id,c.add_time,c.goods_id,c.num')
				->where(array('user_id'=>$uid))->select();
	}
}