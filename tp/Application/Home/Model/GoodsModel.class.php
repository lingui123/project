<?php
namespace Home\Model;
use Think\Model;
class GoodsModel extends Model{

	/**
	 * 商品列表
	 * @param array|int $cids 分类ID数组
	 * @param int $p 当前页码
	 * @return array 查询结果
	 */
	//获取商品列表
	public function getList($cid=0,$p=0){
		//准备查询条件
		$field = 'category_id,id,name,price,thumb';
		$where = array('recycle' => 2,'on_sale' => 1);
		//查找分类ID数组
		if($cids > 0){
			$where['category_id'] = array('in',$cids);
		}
		$price_max = $this->where($where)->max('price');  //获取最大价格
		$recommend = $this->getRecommend($where);         //获取推荐商品
		//--------处理排序条件
		$order = 'id desc';
		$allow_order = array(
			'price-desc' => 'price desc',
			'price-asc' => 'price asc',
		);
		$input_order = I('get.order');
		if(isset($allow_order[$input_order])){
			$order = $allow_order[$input_order];
		}
		//--------处理价格条件
		$price = explode('-',I('get.price'));
		if(count($price)==2){
			$where['price'] = array(
				array('EGT',(int)$price[0]), //大于等于
				array('ELT',(int)$price[1]), //小于等于
			);
		}
		//准备分页查询
		$pagesize = C('USER_CONFIG.pagesize');        //每页显示商品数
		$count = $this->where($where)->count();       //获取符合条件的商品总数
		$Page = new \Think\Page($count,$pagesize);    //实例化分页类
		$this->_customPage($Page);                    //定制分页类样式
		//查询商品数据
		$data = $this->field($field)->where($where)->order($order)->page($p,$pagesize)->select();
		//返回结果
		return array(
			'data' => $data,              //商品列表数组
			'price' => $this->getPriceDist($price_max), //计算商品价格
			'recommend' => $recommend,    //被推荐的商品
			'pagelist' => $Page->show(),  //分页链接HTML
		);
	}

	//定制分页类样式
	private function _customPage($Page){
		$Page->lastSuffix = false;
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$Page->setConfig('first','首页');
		$Page->setConfig('last','尾页');
	}

	//根据$where条件查询商品数据
	public function getGoods($where){
		//定义需要的字段
		$field = 'id,category_id,sn,name,price,thumb,stock,desc';
		return $this->field($field)->where($where)->find();
	}

	//取出推荐商品
	public function getRecommend($where){
		//查询被推荐的商品
		$where['recommend'] = 1;
		$field = 'id,name,price,thumb';
		return $this->field($field)->where($where)->limit(6)->select();
	}
	
	//动态计算价格（max最大价格，sum分配个数）
	private function getPriceDist($max,$sum = 5){
		if($max < 0) return false;
		$end = $size = ceil($max / $sum);
		$start = 0;
		$rst = array();
		for($i = 0;$i < $sum;$i++){
			$rst[] = "$start-$end";
			$start = $end + 1;
			$end += $size;
		}
		return $rst;
	}
}