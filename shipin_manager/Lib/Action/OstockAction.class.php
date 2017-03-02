<?php
/**
 * O2O商户库存管理
 */
class OstockAction extends CommonAction{

    /*
     * O2O模板列表
     * */
    public function index(){
        $grouptmlM = M('o2o_merchant');
        $list = $grouptmlM->select();
        $this->assign('list',$list);
        $this->display();
    }

    /*
     * 查询O2O商户库存
     * */
    public function stock(){
        $merchant_id = I('id');
        $stockM = M('o2o_stock');
        $where['merchant_id'] = array('eq', $merchant_id);
        $stockResult = $stockM->where($where)->order('product_id desc')->select();

        $product_id = array();
        $list = array();
        foreach($stockResult as $key => $val){
            $product_id[] = $stockResult[$key]['product_id'];
            $list[md5($stockResult[$key]['product_id'])] = array(
                    'id' => $stockResult[$key]['id'],
                    'merchant_id' => $stockResult[$key]['merchant_id'],
                    'product_id' => $stockResult[$key]['product_id'],
                    'stock' => $stockResult[$key]['stock'],
                    'o2o_goods_price' => $stockResult[$key]['o2o_goods_price'],
                );
        }
        $productM = M('product');
        $where['id'] = array('in',$product_id);
        $productResult = $productM->field('id,product_name')->where($where)->order('id desc')->select();
        foreach($productResult as $key => $val){
            $list[md5($productResult[$key]['id'])]['product_name'] = $productResult[$key]['product_name'];
        }
        $this->assign('list',$list);
        $this->display();
    }


    /*
     * O2O模板信息修改
     * */
    public function saveStock(){
        $id = I('id');
        $product_name = I('name');
        $where['id'] = array('eq',$id);
        $stockM = M('o2o_stock');
        $result = $stockM->where($where)->find();
        $this->assign('name',$product_name);
        $this->assign('result',$result);
        $this->display();
    }

    /*
     *O2O模板修改信息执行
     * */
    public function save(){
        $data['stock'] = I('stock');
        $data['o2o_goods_price'] = I('o2o_goods_price');
        $id = I('id');
        $where['id'] = array('eq',$id);
        $stockM = M('o2o_stock');
        $result = $stockM->where($where)->save($data);
        if($result){
            $this->success('商品信息修改成功',U('Ostock/index'));
        }else{
            $this->error('商品信息修改失败');
        }
    }

}
