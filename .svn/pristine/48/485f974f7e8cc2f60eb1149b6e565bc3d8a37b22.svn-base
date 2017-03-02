<?php

/**
 * 出库
 * User: chrisying
 * Date: 15/8/14
 * Time: 下午12:04
 */
class OutStorageAction extends CommonAction
{

    /**
     *  出库单列表
     */
    public function outStorageBill(){

        $this->navAndDo(U('outStorageBill'), '出库管理');

        $this->display();

    }

    /**
     *  生成出库单号
     */
    public function createOutStorageBill(){
        $orderType = I('create_out_storage_order', 1);
        $orderM = M('order');
        $orderProductM = M('order_product');
        $orderOutStorageM = M('order_out_storage');
        $orderProductList = array();
        $outNo = '';
        switch($orderType){
            case 1:
                //未生成过的, 已审核状态，且已经支付或货到付款的订单, 为防止一次生成太多死机，一次限制200个订单
                $where = 'has_create_out_storage = 0 && (operation_id = 10 OR operation_id = 2) && (pay_status = 1 OR pay_parent_id = 4) AND time > "2015-10-13 21:00:00"';
                $orderList = $orderM->field('id,order_name')->where($where)->limit(0, 200)->select();
//                echo $orderM->getLastSql();
//                var_dump($orderList);
//                echo '===================<br/>';
                $orderIdArr = array();
                if(!empty($orderList)){
                    foreach($orderList as $item){
                        $orderIdArr[] = $item['id'];
                    }

                    $outNo = 'CK' . date('ymdHim', time()) . rand(10000, 99999);
                    $orderM->where('id IN(' . implode(',', $orderIdArr) . ')')->save(array('has_create_out_storage' => 1));
                    $outStorageData = array('out_no' => $outNo, 'act_uid' => $_SESSION['admin_id']
                    , 'create_orders' => serialize($orderIdArr)
                    , 'add_time'=> time());
                    $orderOutStorageM->add($outStorageData);

                    $orderProductList = $orderProductM->field('sum(qty) as pnum, ' . $orderProductM->getTableName() . '.*')
                        ->where('order_id IN(' . implode(',', $orderIdArr) . ')')
                        ->group('product_id')
                        ->select();
//                    echo '<br/>===========' . $orderProductM->getLastSql() . '=========<br/>';
                }

                break;
        }

//        var_dump($orderProductList);
        $this->assign('out_storage_no', $outNo);
        $this->assign('create_time', date('Y-m-d H:m:i', time()));
        $this->assign('list', $orderProductList);
        $this->display();
    }


    /**
     *  捡货单
     */
    public function pickUpGoodsBill(){

        $this->navAndDo(U('pickUpGoodsBill'), '出库管理');
        $this->display();
    }


    /**
     *  生成捡货单
     *  一个订单一个捡货单
     */
    public function createPickUpGoodsBill(){
        $orderType = I('create_pick_up_goods_order', 1);
        $orderM = D('Order');
        $orderProductM = M('order_product');
        $orderPickUpGoodsM = M('order_pick_up_goods');
        $orderPickUpGoodsProductM = M('order_pick_up_goods_product');
        $list = array();

        switch($orderType){
            case 1:
                //未生成过的, 已审核状态，且已经支付或货到付款的订单, 为防止一次生成太多死机，一次限制200个订单
                $where = 'has_create_pick_up_goods = 0 && (operation_id = 10 OR operation_id = 2) && (pay_status = 1 OR pay_parent_id = 4) AND time > "2015-10-13 21:00:00"';
                $orderList = $orderM->relation(true)->where($where)->limit(0, 200)->select();
                $orderIdArr = array();
                if(!empty($orderList)){
                    $pickUpGoodsData = array();
                    $pickUpGoodsProductData = array();
                    $pickUpGoodsNoArr = array();
                    foreach($orderList as $key => $item){
                        $orderIdArr[] = $item['id'];
                        $pickUpGoodsNo = 'JH' . date('ymdHim', time()) . rand(10000, 99999);
                        while(in_array($pickUpGoodsNo, $pickUpGoodsNoArr)){
                            $pickUpGoodsNo = 'JH' . date('ymdHim') . rand(10000, 99999);
                        }

                        $orderList[$key]['pick_up_goods_no'] = $pickUpGoodsNo;
                        $orderList[$key]['shipping_no'] = $pickUpGoodsNo;
                        $pickUpGoodsData[] = array('pick_up_goods_no' => $pickUpGoodsNo, 'act_uid' => $_SESSION['admin_id']
                        , 'order_name' => $item['order_name'], 'order_id' => $item['id']
                        , 'shipping_no' => '00000' , 'add_time'=> time());

                        foreach($item['order_product'] as $product){
                            $pickUpGoodsProductData[] = array('pick_up_goods_no' => $pickUpGoodsNo
                                , 'order_name' => $item['order_name'], 'shipping_no' => '0000'
                                , 'product_name' => $product['product_name'], 'product_id' => $product['product_id']
                                , 'product_no' => $product['product_no'], 'qty' => $product['qty'], 'add_time' => time());
                        }
                    }

                    $orderM->where('id IN(' . implode(',', $orderIdArr) . ')')->save(array('has_create_pick_up_goods' => 1));
                    $orderPickUpGoodsM->addAll($pickUpGoodsData);
                    $orderPickUpGoodsProductM->addAll($pickUpGoodsProductData);

                }

                break;
        }

        $this->assign('list', $orderList);
        $this->display();
    }
}