<?php
namespace Admin\Controller;
//回收站控制器
class RecycleController extends CommonController {

	//显示回收站商品列表	
	public function index(){
		//获取参数
		$p = I('get.p/id');		//当前页码
		//实例化模型
		$Goods = D('Goods');
		//查询商品列表
		$data['goods'] = $Goods->getList('recycle',-1,$p);
		//防止空页被访问
		if(empty($data['goods']['data']) && $p > 0){
			$this->redirect('Recycle/index');
		}
		$data['p'] = $p;
		$this->assign($data);
		$this->display();
	}

	//恢复商品
	public function rec(){
		//阻止直接访问
		if(!IS_POST) $this->error('恢复失败：未选择商品！');
		//获取参数
		$p = I('get.p/d',0);		//当前页码
		$id = I('post.id/d',0);		//商品ID
		//生成跳转地址
		$jump = U('Recycle/index',array('p' => $p));
		//实例化模型
		$Goods = M('Goods');
		//检查表单令牌
		if(!$Goods->autoCheckToken($_POST)){
			$this->error('表单已过期，请重新提交',$jump);
		}
		//将商品取消删除
		if(false === $Goods->where(array('id' => $id))->save(array('recycle'=>2))){
			$this->error('恢复商品失败！',$jump);
		}
		//恢复成功，跳转
		redirect($jump);
	}

	//彻底删除商品
	public function del(){
		//阻止直接访问
		if(!IS_POST) $this->error('删除失败：未选择商品！');
		//获取参数
		$p = I('get.p/d',0);		//当前页码
		$id = I('post.id/d',0);		//商品ID
		//生成跳转地址
		$jump = U('Recycle/index',array('p' => $p));
		//实例化模型
		$Goods = D('Goods');
		//检查表单令牌
		if(!$Goods->autoCheckToken($_POST)){
			$this->error('表单已过期，请重新提交',$jump);
		}
		//准备where条件
		$where = array('id' => $id,'recycle' => 1);
		//删除商品图片
		$Goods->delThumbFile($where);
		//删除商品数据
		$Goods->where($where)->delete();
		//删除成功，跳转
		redirect($jump);
	}
	
}