<?php
// +----------------------------------------------------------------------
// | 时品
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://m.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id$ 

Vendor('Youzan.KdtApiClient');

class YouzanAction extends CommonAction {

    public $appId = '2790602d9352af9085';
    public $appSecret = 'fdc92d22a20fcd9bc03c997a529532fe';
    public $client;

    public function _initialize() {
        $this->client = new KdtApiClient($this->appId, $this->appSecret);
        header('"Content-type: text/html; charset=utf-8"');
    }


    public function getOrderList() {
        $method = 'kdt.trades.sold.get';
        $params = array();
        $params['status'] = 'WAIT_SELLER_SEND_GOODS';
//        $params['status'] = 'WAIT_BUYER_CONFIRM_GOODS';
        $params['use_has_next'] = true;

//        echo '<pre>';
        $result = $this->client->post($method, $params);
//        var_dump($result);
//        echo '</pre>';

        if(isset($result['response']['trades'])){

            $xlsName  = "export_new_order" . date('_YmdHis');

            $xlsCell  = array(
                array('order_name','关联订单'),
                array('name','姓名'),
                array('mobile','手机'),
                array('telephone','座机'),
                array('address','地址'),
                array('product_info','物品内容'),
                array('qty','包裹数量'),
                array('weight','重量（kg）'),
                array('insured','保价'),
                array('insured_money','保价金额（元）'),
                array('money','订单金额（元）'),
                array('COD','代收货款'),
                array('remark','备注信息'),
                array('delivery_type','配送业务类型'),
            );

            $xlsData = array();

            $resultList = $result['response']['trades'];
            $orderNum = count($resultList);
            if($orderNum > 0){

                $deliveryIdM = D('JdDeliveryId');
                $youzanImportJdM = M('youzan_import_jd_log');
                $deliveryIdM->startTrans();

                $expirtTime = time() - (3600 * 24 * 86);
                $deliveryIdList = $deliveryIdM->where('is_used = 0 AND add_time > ' . $expirtTime)->limit(0, $orderNum)->select();
                while(count($deliveryIdList) < $orderNum){
                    $deliveryIdM->getDeliveryId();
                    $deliveryIdList = $deliveryIdM->where('is_used = 0 AND add_time > ' . $expirtTime)->limit(0, $orderNum)->select();
                }

                $k = 0;
                foreach($resultList as $key => $order){
                    $orderData = array();

                    $orderData['delivery_id'] = $deliveryIdList[$k]['delivery_id'];
                    $orderData['order_name'] = substr($order['tid'], 0, 20);
                    $orderData['name'] = $order['receiver_name'];
                    $orderData['address'] = $order['receiver_state'] . $order['receiver_city'] . $order['receiver_district'] . $order['receiver_address'];
                    $orderData['telephone'] = '';
                    $orderData['mobile'] = $order['receiver_mobile'];


//excel 中的订单
                    $dataItem = array();
                    $dataItem['order_name'] = $orderData['order_name'];
                    $dataItem['name'] = $orderData['name'];
                    $dataItem['mobile'] = $orderData['mobile'];
                    $dataItem['telephone'] = $orderData['telephone'];
                    $dataItem['address'] = $orderData['address'];
                    $dataItem['product_info'] = '';
                    $dataItem['qty'] = 1;
                    $dataItem['weight'] = 1;
                    $dataItem['insured'] = '否';
                    $dataItem['insured_money'] = 0;
                    $dataItem['money'] = 0;
                    $dataItem['COD'] = '否';
                    $dataItem['delivery_type'] = '普通';
                    $xlsData[] = $dataItem;

                    $result = $deliveryIdM->sendWayBill($orderData);
                    if($result['status']){
                        deBugLog(array('jd_delivery_id' => $deliveryIdList[$k]['delivery_id'], 'tid' => $order['tid']), __FILE__);
                        $deliveryIdM->where('id = ' . $deliveryIdList[$key]['id'])->save(array('is_used' => 1));
                        //不要自动发货，否则不知道怎么捡货
//                        $this->yzSendGoods($order['tid'], $deliveryIdList[$key]['id']);
                    }else{
                        deBugLog(array('导入有赞订单到京东出错' => $result), __FILE__);
                    }

                    $k++;
                }

                $deliveryIdM->commit();
                if($result['response']['has_next']){
                    $this->getOrderList();
                }
            }

            deBugLog(array('导入有赞订单到京东' => date('Y-m-d  H:i:s', time())), __FILE__);

//            $this->exportExcel($xlsName,$xlsCell,$xlsData, 'export_order');
        }
    }


    public function yzSendGoods($tid = '', $out_sid=''){
        $tid = I('tid', $tid);
        $out_sid = I('out_sid', $out_sid);
        $params = array();
        $params['tid'] = $tid;
        $params['is_no_express'] = 0;
        $params['out_stype'] = 1; //由于没有京东快递选项，改成1 申请物流， 咨询时要跟客户解释下
        $params['out_sid'] = $out_sid;

        $method = 'kdt.logistics.online.confirm';

        $result = $this->client->post($method, $params);
        var_dump($params);
        var_dump($result);
        echo $result;
        deBugLog(array('result' => $result), __FILE__);
    }


    public function showYzOrders(){
        $method = 'kdt.trades.sold.get';
        $params = array();
        $params['status'] = 'WAIT_SELLER_SEND_GOODS';
        //        $params['status'] = 'WAIT_BUYER_CONFIRM_GOODS';
        $params['use_has_next'] = true;

                echo '<pre>';
        $result = $this->client->post($method, $params);
                var_dump($result);
                echo '</pre>';
    }
}