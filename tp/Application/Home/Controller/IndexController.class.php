<?php
namespace Home\Controller;
//前台主页控制器
class IndexController extends CommonController {	
	//首页
    public function index(){
        //获取分类列表
        $data['category'] =	D('Category')->getTree();	
        //准备查询条件（推荐商品、已上架、不在回收站中）
        $where = array('recommend'=>1,'on_sale'=>1,'recycle'=>2);
        //取出商品ID，商品名，商品价格，商品图片
        $data['best'] = M('Goods')->field('id,name,price,thumb')->where($where)->limit(6)->select();
        $this->assign('title','传智商城首页');
        $this->assign($data);
        $this->display();
    }
    //查找商品
    public function find(){
        //获取参数
        $p = I('get.p/d',0);    //当前页面
        $cid = I('get.cid/d',-1);//分类ID 
        //实例化模型
        $Goods = D('Goods');
        $Category = D('Category'); 
        //如果分类ID大于0，则取出所有子分类ID 
        $cids = ($cid > 0) ? $Category->getSubIds($cid) : $cid;
        //获取商品列表
        $data['goods'] = $Goods->getList($cids,$p);
        //防止空页被访问
        if(empty($data['goods']['data']) && $p > 0){
            $this->redirect('Index/find',array('cid' => $cid));
        }
        //查询分类列表
        $data['category'] = $Category->getFamily($cid);
        $data['p'] = $p;
        $data['cid'] = $cid;
        $this->assign($data);
        $this->display();  
    }  
    //商品详情页
    public function goods(){
        //获取展示商品ID
        $id = I('get.id/d',0);
        //实例化商品模型
        $Goods = D('Goods');
        //实例化分类模型
        $Category = D('Category');
        //查找当前商品
        $data['goods'] = $Goods->getGoods(array('recycle'=>2,'on_sale'=>1,'id'=>$id));
        if(empty($data['goods'])){
            $this->error('您访问的商品不存在，已下架或删除！');
        }
        //查找推荐商品
        $cids = $Category->getSubIds($data['goods']['category_id']);
        $where = array('recycle' => 2,'on_sale' => 1);
        $where['category_id'] = array('in',$cids);
        $data['recommend'] = $Goods->getRecommend($where);
        //查找分类导航
        $data['path'] = $Category->getPath($data['goods']['category_id']);
        $this->assign('title',$data['goods']['name'].' -传智商城');
        $this->assign($data);
        $this->display();
    }
}