<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model{
	protected $insertFields = 'name,pid';
	protected $updateFields = 'name,pid';

	//查询分类数据
	private function getData(){		
		static $data =  null;		//缓存查询结果 
		if(!$data) $data = $this->field('id,name,pid')->select();
		return $data;
	}
	//获得分类列表
	public function getList(){
		category_list($this->getData(),$data);
		// dump($data);die;
		return $data;
	}
	//自动验证
	protected $_validate = array(
		array('pid','require','父级分类不能为空',self::MUST_VALIDATE),
		array('name','require','分类名不能为空',self::MUST_VALIDATE),
	);
	//自动完成
	protected $_auto = array(
		array('pid','max',self::MODEL_BOTH,'function',0),
	);
	//查找所有子孙类
	public function getSubIds($id){
		$data = array('$id');	//将ID自身放入数组头部
		category_child($this->getData(),$data,$id);
		return $data;
	}
}
