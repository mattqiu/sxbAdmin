<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/1/7
 * Time: 下午3:05
 */
class TmpJdOrderModel extends CommonModel{

    public function addErrorOrder($order){
        $this->where(array('order_name'=>array('eq', $order['order_name'])))->save(array('status' => 15));
    }

    public function exportWarehouseOrder($orderList, $warehouseName) {
        $fileArr = array('product_total' => '', 'order_list' => '');

        $xlsName = date('y-m-d-His') . "_" . $warehouseName. '_订单列表';
        $xlsResult = $this->getWarehouseTmpJdXlsData($orderList);
        $typeName = 'export_order';
        if(!(isset($xlsResult['xls_data']) && !empty($xlsResult['xls_data']))) {
            return false;
        }
        $fileArr['order_list'] = exportExcel($xlsName, $xlsResult['xls_cell'], $xlsResult['xls_data'], $typeName);

        $xlsName = date('y-m-d-His') . "_" . $warehouseName. '_出库单';
        $xlsResult = $this->getTmpGoodsXlsData($orderList);
        $typeName = 'export_send_channel_order';
        $fileArr['product_total'] = exportExcel($xlsName, $xlsResult['xls_cell'], $xlsResult['xls_data'], $typeName);

        return $fileArr;
    }

    public function getWarehouseTmpJdXlsData($orderData) {
        $result = array('xls_cell' => array(), 'xls_data' => array());
        $result['xls_cell'] = array(array('order_name', '关联订单'), array('name', '姓名'), array('mobile', '手机'), array('telephone', '座机'), array('address', '地址'), array('product_info', '物品内容'), array('qty', '包裹数量'), array('weight', '重量（kg）'), array('insured', '保价'), array('insured_money', '保价金额（元）'), array('money', '订单金额（元）'), array('COD', '代收货款'), array('remark', '备注信息'), array('delivery_type', '配送业务类型'),array('delivery_id', '运单号'));

        if(!empty($orderData)) {
            foreach ($orderData as $item) {
                $dataItem = array();
                $dataItem['order_name'] = $item['order_name'];
                $dataItem['name'] = $item['rec_name'];
                $dataItem['mobile'] = $item['rec_mobile'];
                $dataItem['telephone'] = $item['rec_tel'];
                $dataItem['address'] = $item['rec_address'];
                $dataItem['weight'] = 1;
                $dataItem['insured'] = '否';
                $dataItem['insured_money'] = 0;
                $dataItem['money'] = 0;
                $dataItem['COD'] = '否';
                $dataItem['delivery_type'] = '普通';
                $dataItem['product_info'] = $item['product_name'];
                $dataItem['remark'] = $item['product_name'];
                $dataItem['qty'] = $item['num'];
                $dataItem['delivery_id'] = $item['delivery_id'] . '-' . $item['package_no'] . '-' . $item['package_num'] . '-';
                $result['xls_data'][] = $dataItem;
            }
        }

        return $result;
    }


    /**
     *  京东快递模板的订单列表
     * @param $orderData
     * @return array
     */
    public function getTmpJdXlsData($orderData) {
        $result = array('xls_cell' => array(), 'xls_data' => array());
        $result['xls_cell'] = array(array('order_name', '关联订单'), array('name', '姓名'), array('mobile', '手机'), array('telephone', '座机'), array('address', '地址'), array('product_info', '物品内容'), array('qty', '包裹数量'), array('weight', '重量（kg）'), array('insured', '保价'), array('insured_money', '保价金额（元）'), array('money', '订单金额（元）'), array('COD', '代收货款'), array('remark', '备注信息'), array('delivery_type', '配送业务类型'),);

        if(!empty($orderData)) {
            foreach ($orderData as $item) {
                $dataItem = array();
                $dataItem['order_name'] = $item['order_name'];
                $dataItem['name'] = $item['rec_name'];
                $dataItem['mobile'] = $item['rec_mobile'];
                $dataItem['telephone'] = $item['rec_tel'];
                $dataItem['address'] = $item['rec_address'];
                $dataItem['weight'] = 1;
                $dataItem['insured'] = '否';
                $dataItem['insured_money'] = 0;
                $dataItem['money'] = 0;
                $dataItem['COD'] = '否';
                $dataItem['delivery_type'] = '普通';
                $dataItem['product_info'] = $item['product_name'];
                $dataItem['remark'] = $item['product_name'];
                $dataItem['qty'] = $item['num'];
                $result['xls_data']['all'][] = $dataItem;
                $result['xls_data'][$item['send_warehome_id']][] = $dataItem;
            }
        }

        return $result;
    }

    /**
     *  果园备货的xls文档内容
     * @param $orderData
     * @return array
     */
    public function getTmpGoodsXlsData($orderData) {
        $result = array('xls_cell' => array(), 'xls_data' => array());

        $result['xls_cell'] = array(array('product_name', '商品品名'), array('product_standard', '规格'), array('num', '数量'),);

        $productArr = array();
        if(!empty($orderData)) {
            foreach ($orderData as $item) {
                $key = md5($item['product_name'] . $item['product_standard']);
                if(isset($productArr[$key])) {
                    $productData = $productArr[$key];
                    $productData['num'] = intval($productData['num']) + intval($item['num']);
                } else {
                    $productData = array('num' => $item['num'], 'product_standard' => $item['product_standard'], 'product_name' => $item['product_name']);
                }

                $productArr[$key] = $productData;
            }
        }

        if(!empty($productArr)) {
            foreach ($productArr as $pItem) {
                $result['xls_data'][] = $pItem;
            }
        }

        return $result;
    }

    /**
     *  tmpjdorder表中发货
     * @param $orderName
     */
    public function sendGoods($orderName){
        $where = array();
        $where['order_name'] = $orderName;
        $result = $this->where($where)->save(array('status'=>4));
        return $result;
    }

    public function getUserOrderReport(){
//        $startTime = I('start_time', date('Y-m-d', time()) . ' 00:00:00');
//        $endTime = I('end_time', date('Y-m-d', time()) . ' 23:59:59');
//
//        $tmpJdOrder = M('tmp_jd_order');
//        $orderM = new OrderModel();
//        $where = array();
//        $where['last_send_mail_time'] = array(array('egt', $startTime), array('elt', $endTime));
//
//        $orderList = $tmpJdOrder->field('order_name')->where($where)->group('rec_key')->select();
//        $orderNameArr = array();
//        foreach($orderList as $order){
//            $orderNameArr[] = $order['order_name'];
//        }
//
//        $orderUidWhere = array();
//        $orderUidWhere['order_name'] = array('in', $orderNameArr);
//        $orderUidList = $orderM->field('uid')->where($orderUidWhere)->select();
//
//        $userOrdersInfo = array();
//        //`operation_id` int(2) NOT NULL DEFAULT '0' COMMENT '0=>''待审核'',1=>''已审核'',2=>''已发货'',3=>''已完成'',4=>''未完成'',5=>''已取消'',6=>''等待完成'',7=>''退货中'',8=>''换货中'',9=>''已收货'',10=>''待发货''',
//        $uidArr = array();
//        foreach($orderUidList as $uid){
//            $uidArr[] = $uid['uid'];
//
//            //            $userOrdersInfo[$uid['uid']] = '';
//        }
//
//        $userOrderWhere = array();
//        $userOrderWhere['operation_id'] = array('in', array(2,3,6,9,10));
//        $userOrderWhere['uid'] = array('in', $uidArr);
//
//        $userOrdersList = $orderM->field('count(*) as onum, uid')->where($userOrderWhere)->relation('User')->group('uid')->limit(0, 10000)->select();
    }

}