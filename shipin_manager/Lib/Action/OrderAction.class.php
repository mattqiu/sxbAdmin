<?php
//  时品网   订单管理 功能
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2013 http://shipinmmm.com All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris Ying
// +----------------------------------------------------------------------
// | @version: $Id: OrdersAction.class.php 1564 2014-10-13 03:52:01Z yihua.ying $
class OrderAction extends CommonAction {

    //订单列表
    public function index() {

        $this->navAndDo(U('index'), '订单管理');
        $model = new OrderModel();
        $orderStatus = 0;
        if(isset($_REQUEST['order_status_sel'])){
            $orderStatus = $_REQUEST['order_status_sel'];
        }

        //当前参数
        $this->assign('request', $_REQUEST);

        $supplyM = M('supply');
        $supplyList = $supplyM->where('status = 1')->select();
        $this->assign("supply_list", $supplyList);


        $distributors = M("distributor");
        $distributorList = $distributors->where('status = 1')->select();
        $this->assign("distributor_list",$distributorList);
        //2015/10/30 - 2015/10/31
        $timetype = 0;
        if(!empty($_REQUEST['order_time_type']))
        {
            $timetype = $_REQUEST['order_time_type'];
        }
        $limitDate = array();
        $limitTime = array();
        $whereArr = array();
        if(!empty($_REQUEST['limit_date_From'])){

            $limitDate[0] =$_REQUEST['limit_date_From'];
            $limitTime[0] = $_REQUEST['limit_time_From'];
        }
        if(!empty($_REQUEST['limit_date_To'])){
            $limitDate[1] = $_REQUEST['limit_date_To'];
            $limitTime[1] = $_REQUEST['limit_time_To'];
        }

        if(count($limitDate) > 0)
        {
            if($timetype == 0)
            {
                $whereArr['time'] = array(array('egt', trim($limitDate[0]) . ' '.$limitTime[0]), array('elt', trim($limitDate[1]) . ' '.$limitTime[1]));
            }
            elseif($timetype == 1)
            {
                $whereArr['last_modify_time'] = array(array('egt', trim($limitDate[0]) . ' '.$limitTime[0]), array('elt', trim($limitDate[1]) . ' '.$limitTime[1]));
            }
        }

        //定单金额
        if(isset($_REQUEST['money']) && !empty($_REQUEST['money'])){
            $whereArr['money'] = array('eq', trim($_REQUEST['money']));
        }

        if(isset($_REQUEST['pay_status']) && $_REQUEST['pay_status'] != 100){
            $whereArr['pay_status'] = array('eq', intval($_REQUEST['pay_status']));
        } else {
            $whereArr['pay_status'] = array('eq', 1);
        }


        $deliveryId = I('delivery_id', '');
        if(!empty($deliveryId)){
            $whereArr[C('DB_PREFIX') . 'order.delivery_id'] = array('like', '%' . $deliveryId . '%');
        }
        $this->assign('delivery_id', $deliveryId);

        $groupbuy_Order_Name = I('groupbuy_order_name', '');
        if(!empty($groupbuy_Order_Name)){
            $whereArr[C('DB_PREFIX') . 'order.groupbuy_order_name'] = array('like', '%' . $groupbuy_Order_Name . '%');
        }
        $this->assign('groupbuy_order_name', $groupbuy_Order_Name);

//        $out_bill_Id = I('out_bill_id', '');
//        if(!empty($out_bill_Id)){
//            $whereArr[C('DB_PREFIX') . 'order_payment.out_bill_id'] = array('like', '%' . $out_bill_Id . '%');
//        }
//        $this->assign('out_bill_id', $out_bill_Id);

        $orderName = I('order_name', '');
        if(!empty($orderName)){
            $whereArr[C('DB_PREFIX') . 'order.order_name'] = array('like', '%' . $orderName . '%');
        }
        $this->assign('order_name', $orderName);

//        $productName = I('product_name', '');
//        if(!empty($productName)){
//            $whereArr[C('DB_PREFIX') . 'order_product.product_name'] = array('like', '%' . $productName . '%');
//            $this->assign('product_name', $productName);
//        }

        $short_name = I('short_name', '');
        if(!empty($short_name)){
            $whereArr[C('DB_PREFIX').'order.distributor_id'] = array('eq',md5("$short_name"));
            $this->assign("short_name",$short_name);
        }

//        $send_channel = I('send_channel', '');
//        if(!empty($send_channel)){
//            $whereArr[C('DB_PREFIX') . 'order_product.send_channel'] = array('eq', $send_channel);
//            $this->assign('send_channel', $send_channel);
//        }  else {
//            //主站后台默认只显示时品和天天果园发货渠道的订单和商品
//            $whereArr[C('DB_PREFIX') . 'order_product.send_channel'] = array('in', C('MAIN_CHANNEL'));
//        }

//        $recName = I('rec_name', '');
//        if(!empty($recName)){
//            $whereArr[C('DB_PREFIX') . 'order_address.name'] = array('like', '%' . $recName . '%');
//        }
//        $this->assign('rec_name', $recName);

//        $recPhone = I('rec_phone', '');
//        if(!empty($recPhone)){
//            $whereArr['_string'] = '(' . C('DB_PREFIX') . 'order_address.mobile LIKE "%' . $recPhone . '%" OR ' . C('DB_PREFIX') . 'order_address.telephone LIKE"%' . $recPhone . '%")';
//        }
//        $this->assign('rec_phone', $recPhone);

//        $tradeNo = I('trade_no', '');
//        if(!empty($tradeNo)){
//            $whereArr[C('DB_PREFIX') . 'order_payment.out_bill_id'] = array('like', '%' . $tradeNo . '%');
//        }
//        $this->assign('trade_no', $tradeNo);


        $result = $model->getNewOrdersList($orderStatus, $whereArr);
        foreach($result['order_list'] as $key=>$value){
            if($result['order_list'][$key]['distributor_id'] != '0'){
                $m = M('distributor');
                $result['order_list'][$key]['short_name'] = implode($m->field('short_name')->where("distributor_id = '{$value['distributor_id']}'")->find());
            }else{
                $result['order_list'][$key]['short_name'] = '';
            }
        }
//         dump($result['order_list']);
        // echo md5(shipin);
        // dump($_POST);
        $manageOrderStatusArr = C('MANAGE_ORDER_STATUS');
        $this->assign('timetype', $timetype);
        $this->assign('limit_date_From', $_REQUEST['limit_date_From']);
        $this->assign('limit_time_From', $_REQUEST['limit_time_From']);
        $this->assign('limit_date_To', $_REQUEST['limit_date_To']);
        $this->assign('limit_time_To', $_REQUEST['limit_time_To']);
        $this->assign('manage_order_status', $manageOrderStatusArr);
        $this->assign('order_status_sel', $orderStatus);
        $this->assign('ordersInfo', $result['order_list']);
        $this->assign('page', $result['page']);
        $this->display();
    }

    public function ajaxOrderItem(){
        $orderName = I('order_name', '');
        $model = new OrderModel();
        if(!empty($orderName)){
            $whereArr[C('DB_PREFIX') . 'order.order_name'] = array('eq',  $orderName);
        }
        $this->assign('order_name', $orderName);
        $result = $model->getOrdersList(0, $whereArr);
        if(!empty($result['order_list'])){
            $this->result['status'] = 1;
            $this->assign('order', $result['order_list'][0]);
        }

        $this->result['data'] = $this->fetch('itemContent');
        echo json_encode($this->result);
    }

    /**
     *  修改订单信息，只可以修改收件人信息
     */
    public function editOrderInfo()
    {
        $orderId = I('id', 0);


        $model = new OrderModel();

        $whereArr = array();
        $whereArr[C('DB_PREFIX') . 'order.id'] = array('eq',$orderId);
        $result = $model->getOrdersList(0, $whereArr);

        $this->assign('orderinfo', $result['order_list'][0]);
        $this->display('editorderinfo');
    }
    public function saveEditOrderInfo()
    {
        $orderId = I('id', 0);
        $ordernew_addr = I('new_recv_addr', '');
        $ordernew_phone = I('new_recv_phone', '');
        $ordernew_name = I('new_recv_name', '');
        $groupbuyorder_name = I('groupbuyorder_name', '');

        $tmpJdOrderM = M('tmp_jd_order');
        $where['groupbuyorder_name'] = array('eq',$groupbuyorder_name);
        $orderStatus = $tmpJdOrderM->where($where)->find();
        if($orderStatus['print_num'] != 0 && $orderStatus['is_export_to_warehome'] != 1){
            $this->error('此订单不可修改地址，请查看订单状态是否有误！');
        }

        if($orderId == 0)
        {
            echo '订单号不能为空';
            return;
        }
        if(empty($ordernew_addr))
        {
            echo '地址不能为空';
            return;
        }
        if(empty($ordernew_phone))
        {
            echo '手机不能为空';
            return;
        }
        if(empty($ordernew_name))
        {
            echo '姓名不能为空';
            return;
        }

        $OrderAddrM = M('order_address');
        $OrderAddrM->startTrans();
        if(!empty($orderId) && $orderId != 0)
        {
            $data = array();
            $data['position'] = $ordernew_addr;
            $data['address'] = $ordernew_addr;
            $data['name'] = $ordernew_name;
            $data['telephone'] = $ordernew_phone;
            $data['mobile'] = $ordernew_phone;

            if($orderId> 0){
                $OrderAddrM->where('order_id = ' . $orderId)->save($data);
                $orderM = M('order');
                $orderItem = $orderM->where(array('id' => $orderId))->find();
                $tmpJdData = array();
                $tmpJdData['rec_address'] = $ordernew_addr;
                $tmpJdData['rec_name'] = $ordernew_name;
                $tmpJdData['rec_mobile'] = $ordernew_phone;
                $tmpJdData['rec_tel'] = $ordernew_phone;
                $tmpJdData['jd_can_shipping'] =1;
                $tmpJdData['check_can_jd_result'] = '';
                $tmpJdData['delivery_id'] = '';
                $tmpJdData['status'] = '1';
                $tmpJdData['import_jd_num'] = '0';
                $tmpJdData['last_import_jd_time'] = '0000-00-00 00:00:00';
                $tmpJdOrderM->where(array('order_name' => $orderItem['order_name']))->save($tmpJdData);
            }
        }

        if(!empty($groupbuyorder_name) && $groupbuyorder_name != 0)
        {
            //团单也要改变地址
            $dataGroupOrder = array();
            $dataGroupOrder['recv_address'] = $ordernew_addr;
            $dataGroupOrder['recv_name'] = $ordernew_name;
            $dataGroupOrder['recv_phone'] = $ordernew_phone;

            $groupbuying_orderM = M('groupbuying_order');
            if(!empty($groupbuyorder_name)){
                $groupbuying_orderM->where('groupbuy_order_name = ' . $groupbuyorder_name)->save($dataGroupOrder);
            }
        }

        $OrderAddrM->commit();

        echo '保存成功';

    }

    /**
     *  单独对某订单进行退款
     */
    public function orderRefund(){
        $orderNames = I('order_names', '');
        $refundResult = array();
        if(!empty($orderNames)){
            $taskM = new TaskModel();
            $groupbuyingM = M('groupbuying_order');
            $where = 'order_name IN(' . $orderNames . ') AND state NOT IN (0,3,4)';
            $groupbuyingList = $groupbuyingM->where($where)->select();
            if(!empty($groupbuyingList)){
                foreach($groupbuyingList as $groupbuyOrder){
                  $refundResult[] = $taskM->doGroupOrderRefund($groupbuyOrder, 1);
                }
            }
        }

        echo json_encode($refundResult);
    }

    /**
     *  根据下单时间，订单状态和发货渠道导出订单功能
     *  chrisying 2015-11-11
     */
    public function exportOrder(){
        $whereArr = array();
        $model = new OrderModel();
        $orderStatus = 0;
        //导出类型，默认是1快递格式，2是 捡货格式
        $type = I('export_type', 2);

        if(isset($_REQUEST['order_status_sel'])){
            $orderStatus = I('order_status_sel', 0);
        }

        if(isset($_REQUEST['send_channel'])){
            $send_channel = I('send_channel', '');
            if(!empty($send_channel)){
                $whereArr[C('DB_PREFIX') . 'order_product.send_channel'] = array('eq', $send_channel);
            }
        }

        $timetype = 0;
        if(!empty($_REQUEST['order_export_time_type']))
        {
            $timetype = $_REQUEST['order_export_time_type'];
        }


        $limitDate = array();
        $limitTime = array();
        if(!empty($_REQUEST['limit_date_export_From'])){

            $limitDate[0] =$_REQUEST['limit_date_export_From'];
            $limitTime[0] = $_REQUEST['limit_time_export_From'];
        }
        if(!empty($_REQUEST['limit_date_export_To'])){
            $limitDate[1] = $_REQUEST['limit_date_export_To'];
            $limitTime[1] = $_REQUEST['limit_time_export_To'];
        }

        if(count($limitDate) > 0)
        {
            //
            if($timetype == 0)
            {
                $whereArr['time'] = array(array('egt', trim($limitDate[0]) . ' '.$limitTime[0]), array('elt', trim($limitDate[1]) . ' '.$limitTime[1]));
            }
            elseif($timetype == 1)
            {
                $whereArr['last_modify_time'] = array(array('egt', trim($limitDate[0]) . ' '.$limitTime[0]), array('elt', trim($limitDate[1]) . ' '.$limitTime[1]));

            }
            //
        }

        $result = $model->getExportOrdersList($orderStatus, $whereArr);



        if($type == 1){
            $xlsName  = date('y-m-d-His') . "_export_order_shipping";
            $xlsResult = $this->getJdXlsData($result);
            $this->exportExcel($xlsName,$xlsResult['xls_cell'],$xlsResult['xls_data'], 'export_order');
        } else {
            $xlsName  = date('y-m-d-His') . "_export_order_product";
            $xlsResult = $this->getGoodsXlsData($result);
            $this->exportExcel($xlsName,$xlsResult['xls_cell'],$xlsResult['xls_data'], 'export_send_channel_order');
        }


    }

    /**
     *  快递打印的xls文档内容
     * @param $orderData
     * @return array
     */
    private function getShippingXlsData($orderData){
        $result = array('xls_cell' => array(), 'xls_data' => array());

        $orderAddressM = M('order_address');
        $areaM = M('area');
        $productM = M('product');

        $result['xls_cell']  = array(
            array('order_name','时品订单号'),
            array('name','收件人'),
            array('mobile','手机'),
            array('address','地址'),
            array('recv_city','目的城市'),
            array('product_name','商品明细'),
            array('pay_status','付款状态'),
            array('remark','备注'),
        );

        if(!empty($orderData['order_list'])){
            foreach($orderData['order_list'] as $item){
                $dataItem = array();
                $dataItem['order_name'] = $item['order_name'];
                $dataItem['name'] = $item['name'];
                $dataItem['mobile'] = $item['mobile'];
                $dataItem['telephone'] = $item['telephone'];
                $dataItem['address'] = $item['address'];

                $cityName = '';
                $orderAddressItem = $orderAddressM->where(array('order_id'=>array('eq', $item['id'])))->find();
                if(!empty($orderAddressItem)){
                    $areaItem = $areaM->where(array('id' => array('eq', $orderAddressItem['city'])))->find();
                    if(!empty($areaItem)){
                        $cityName = $areaItem['name'];
                    }
                }
                $dataItem['recv_city'] = $cityName;

                $productName = '';
                if(!empty($item['order_product'])){
                    foreach($item['order_product'] as $product){
                        $productItem = $productM->where(array('id' => array('eq', $product['product_id'])))->find();
                        $productName .= $productItem['product_name'] . ' ';
                    }
                }

                $dataItem['product_name'] = $productName;
                $dataItem['pay_status'] = $item['pay_status'] == 1 ? '已付款' : '未付款';
                $dataItem['remark'] = ''; //备注
                $result['xls_data'][] = $dataItem;
            }
        }

        return $result;
    }

    /**
     *  果园备货的xls文档内容
     * @param $orderData
     * @return array
     */
    private function getGoodsXlsData($orderData){
        $result = array('xls_cell' => array(), 'xls_data' => array());

        $orderAddressM = M('order_address');
        $areaM = M('area');
        $productM = M('product');

        $result['xls_cell']  = array(
            array('product_name','商品品名'),
            array('product_standard','规格'),
            array('product_num','数量'),
        );

        $xls_data = array();

        if(!empty($orderData['order_list'])){
            foreach($orderData['order_list'] as $item){
                $dataItem = array();
                $dataItem['order_name'] = $item['order_name'];
                $dataItem['name'] = $item['name'];
                $dataItem['mobile'] = $item['mobile'];
                $dataItem['telephone'] = $item['telephone'];
                $dataItem['address'] = $item['address'];

                $cityName = '';
                $orderAddressItem = $orderAddressM->where(array('order_id'=>array('eq', $item['id'])))->find();
                if(!empty($orderAddressItem)){
                    $areaItem = $areaM->where(array('id' => array('eq', $orderAddressItem['city'])))->find();
                    if(!empty($areaItem)){
                        $cityName = $areaItem['name'];
                    }
                }
                $dataItem['recv_city'] = $cityName;
                if(!empty($item['order_product'])){
                    foreach($item['order_product'] as $product){
                        $productItem = $productM->where(array('id' => array('eq', $product['product_id'])))->find();

                        $dataItem['product_name'] = $productItem['product_name'];
                        $dataItem['product_standard'] = $product['gg_name'];
                        $dataItem['product_num'] = $product['qty'];

                        $xls_data[] = $dataItem;
                    }
                }
            }
        }

        $productArr = array();
        if(!empty($xls_data)){
            foreach($xls_data as $item){
                $key = md5($item['product_name'] . $item['product_standard']);
                if(isset($productArr[$key])){
                    $productData = $productArr[$key];
                    $productData['product_num'] = intval($productData['product_num']) + intval($item['product_num']);
                } else {
                    $productData = array('product_num'=> $item['product_num']
                        , 'product_standard'=>$item['product_standard'], 'product_name' => $item['product_name']);
                }

                $productArr[$key] = $productData;
            }
        }

        if(!empty($productArr)){
            foreach($productArr as $pItem){
                $result['xls_data'][] = $pItem;
            }
        }

        return $result;
    }

    /**
     *  京东快递模板的订单列表
     * @param $orderData
     * @return array
     */
    private function getJdXlsData($orderData){
        $result = array('xls_cell' => array(), 'xls_data' => array());

        $orderAddressM = M('order_address');
        $areaM = M('area');
        $productM = M('product');

        $result['xls_cell']  = array(
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

        if(!empty($orderData['order_list'])){
            foreach($orderData['order_list'] as $item){
                $dataItem = array();
                $dataItem['order_name'] = $item['order_name'];
                $dataItem['name'] = $item['name'];
                $dataItem['mobile'] = $item['mobile'];
                $dataItem['telephone'] = $item['telephone'];
                $dataItem['address'] = $item['address'];
                $dataItem['weight'] = 1;
                $dataItem['insured'] = '否';
                $dataItem['insured_money'] = 0;
//                $dataItem['money'] = $item['money'];
                $dataItem['money'] = 0;
                //如果是货到付款的需要代收货款
                if(4 === intval($item['pay_parent_id'])){
                    $dataItem['COD'] = '是';
                } else {
                    $dataItem['COD'] = '否';
                }
                $dataItem['delivery_type'] = '普通';
                $xlsData[] = $dataItem;

                $orderNameArr[] = $item['order_name'];

                if(!empty($item['order_product'])){
                    foreach($item['order_product'] as $product){
                        $productItem = $productM->where(array('id' => array('eq', $product['product_id'])))->find();

                        $dataItem['product_info'] = $productItem['product_name'];
                        $dataItem['remark'] = $productItem['product_name'];
                        $dataItem['qty'] = $product['qty'];

                        $result['xls_data'][] = $dataItem;
                    }
                }
            }
        }

        return $result;
    }

    //原来的导出订单功能,现已经废弃
    public function exportOrderOld(){

        $exportType = intval(I('export_type', 0));
        switch($exportType){
            case 1:
                //未导出过的新订单
                $orderM = new OrderModel();
                //未导出过的, 待发货的订单
                $where = 'has_export = 0 && (operation_id = 10 OR operation_id = 2) && (pay_status = 1 OR pay_parent_id = 4) AND time > "2015-10-13 21:00:00"';
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

                $orderList  = $orderM->relation(true)->where($where)->select();
                $orderNameArr = array();
                $xlsData = array();
                if(!empty($orderList)){
                    foreach($orderList as $item){
                        $dataItem = array();
                        $dataItem['order_name'] = $item['order_name'];
                        $dataItem['name'] = $item['name'];
                        $dataItem['mobile'] = $item['mobile'];
                        $dataItem['telephone'] = $item['telephone'];
                        $dataItem['address'] = $item['address'];
                        $dataItem['product_info'] = '';
                        $dataItem['qty'] = 1;
                        $dataItem['weight'] = 1;
                        $dataItem['insured'] = '否';
                        $dataItem['insured_money'] = 0;
                        $dataItem['money'] = $item['money'];
                        //如果是货到付款的需要代收货款
                        if(4 === intval($item['pay_parent_id'])){
                            $dataItem['COD'] = '是';
                        } else {
                            $dataItem['COD'] = '否';
                        }
                        $dataItem['delivery_type'] = '普通';
                        $xlsData[] = $dataItem;

                        $orderNameArr[] = $item['order_name'];
                    }

                    $orderM->where('order_name IN(' . implode(',', $orderNameArr) . ')')->save(array('has_export' => 1));
                    $exportOrderLogM = M('order_export_log');
                    $logData = array('export_name' => $xlsName, 'act_uid' => $_SESSION['admin_id']
                    , 'export_orders' => serialize($orderNameArr)
                        , 'add_time'=> time());
                    $exportOrderLogM->add($logData);

                }


                $this->exportExcel($xlsName,$xlsCell,$xlsData, 'export_order');
                break;

            case 2:
                //选中的订单

                break;
        }
    }

    public function importOrder(){
        $file = '/home/wwwroot/sp.com/manage/Public/export_new_order_20150812160748.xls';
        $this->importExecl($file);
    }

    /**
     *  批量导入京东xls表格数据进行发货
     *  此功能已经废弃
     * chrisying 15-12-29
     */
    public function importSendOrder(){
//        set_time_limit(0);
//        $file = '/mnt/wwwtest/testm1/trunk/manage/upload/orderrecord.xls';
////        $file = '/Users/chrisying/Desktop/orderrecord_11_24.xls';
//        $result = $this->importExecl($file);
//        var_dump($result);
//        if(!empty($result['data'])){
//            $orderM = M('order');
//            $data = array();
//            $data['shipping_name'] = '京东快递';
//            $data['shipping_id'] = 'jd_delivery';
//            $data['is_send_jd'] = '1';
//            foreach($result['data'] as $key => $item){
//                if($key > 1){
//                    $where['order_name'] = array('eq', $item['C']);
//                    $data['delivery_id'] = $item['B'];
//                    $orderM->where($where)->save($data);
//                    $this->doSendGoods($item['C']);
////                    $this->sendOrderMsg($item['C'], $item['I'], $item['B']);
//                }
//
//            }
//        }
    }

    //显示订单详情
    public function detail(){
        $orderName = I('order_name');
        if(!empty($orderName)){
            $orderM = new OrderModel();
            $orderInfo = $orderM->getOrdersList('all', array('order_name' => ' = ' . $orderName));

            $this->assign('order_info', $orderInfo['order_list'][0]);

            $this->display();
        } else {
            echo '参数出错';
        }
    }

    /**
     * 不是货到付款且未付款的订单
     */
    public function noPay() {
        $this->getSubOrdersList('noPay');
        $this->display('index');
    }

    /**
     * 已付款或货到付款且待配货审核的订单
     */
    public function storageCheck() {
        $this->getSubOrdersList('storageCheck');
        $this->display('index');
    }

    /**
     * 已付款或货到付款且待发货的订单
     */
    public function shipments() {
        $this->getSubOrdersList('shipments');
        if(isset($_REQUEST['export'])) {
            $this->display('exportOrder');
        } else {
            $this->display('index');
        }
    }

    /**
     * 已付款或货到付款且待客服审核订单
     */
    public function verify() {
        $this->getSubOrdersList('verify');
        $this->display('index');
    }

    /**
     * 已付款或货到付款且已经发货订单
     */
    public function alreadyShipments() {
        $this->getSubOrdersList('alreadyShipments');
        $this->display('index');
    }

    /**
     * 异常订单
     */
    public function exception() {
        $this->getSubOrdersList('exception');
        $this->display('index');
    }

    /**
     * 显示已经删除的订单
     */
    public function deletedOrder() {
        $this->getSubOrdersList('deleted');
        $this->display('index');
    }

    /**
     * 取已付款的子订单
     */
    public function getPayedSubOrderList() {
        $this->getSubOrdersList('payed');
        $this->display('subOrders');
    }

    //订单搜索 可通过订单号，收货人，订单状态进行搜索
    function searchOrder() {
        $model = M('Order');
//        $ordersDetailM = M('orders_detail');
        $orderId = $_POST['orderId'] ? " AND order_name LIKE '%" . $_POST['orderId'] . "%'" : '';

//        $addressName = $_POST['addressName'] ? " AND address_name LIKE '%" . $_POST['addressName'] . "%'" : '';
        $status = $_POST['status'] ? " AND order_status=" . intval($_POST['status']) : '';
//
//        $beginTime = $_POST['begin_time'] ? ' AND add_time >= ' . strtotime($_POST['begin_time']) : '';
//        $endTime = $_POST['end_time'] ? ' AND add_time <= ' . strtotime($_POST['end_time']) : '';

        $beginTime = '';
        $endTime = '';

        $sql = '1' .  rtrim($orderId . $status . $beginTime . $endTime, ' AND');

        $this->getOrdersList('all', $sql);

        import('ORG.Util.Page');
        $count = $model->where($sql)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $orderInfo = $model->where($sql)->limit($page->firstRow . ',' . $page->listRows)->select();
        $orderStatus = array("1" => "待审核", "2" => "待付款", "3" => "待发货", "4" => "代收货", "5" => "已完成", "6" => "已关闭");
        foreach ($orderInfo as $key => $item) {
            $item['status'] = $orderStatus[$item['status']];
            $orderInfo[$key] = $item;
        }
        //print_r($model);
        $this->assign('orderInfo', $orderInfo);
        $this->assign('page', $strPage);
        $this->navAndDo(U('index'), '订单搜索');
        $this->display('index');
    }

    /**
     * 删除订单order_status 变为100
     */
    public function delete() {
        $id = I('id');
    }

    /**
     * 更新订单的状态
     * 审核，完成，关闭, 不需要填写表单直接更新的操作
     * TODO orders_detail 表的订单状态更新
     *
     */
    public function actStatus() {
       //订单号及操作



        //操作完成后更新列表中的订单状态数据
//        import('@.ORG.Orders');
//        $ordersObj = new Orders();
//        $order = $orderM->relation(true)->where('id = ' . $oId)->find();
//        $actionButton = $ordersObj->getActionButton($order);
//        $order['actionButton'] = $actionButton;
//        $this->getDetailColor($order, M('details_size'));

//        $this->assign('order', $order);
//        $result['data'] = $this->fetch('item');

//        echo json_encode($result);
    }

    /**
     * 后台订单操作付款，显示付款信息输入界面
     */
    public function payed() {
        $orderName = intval(I('order_name'));
        if(!empty($orderName)) {
            $orderM = M('order');
            $order = $orderM->where('order_name = ' . $orderName)->find();
            if(!empty($order)) {
                $this->assign('order', $order);
            }

            $this->result['status'] = 1;
        }

        $this->result['data'] = $this->fetch('payed');
        echo json_encode($this->result);
    }

    /**
     * 提交付款表单内容, 一般只会有货到付款的订单需要后台支付
     * 付款后,更新付款时间，更新订单状态为已收货(判断是否货到付款，
     * 如果不是货到付款且订单状态为未付款，则订单状态更新为已付款)
     */
    public function doPayed() {
        $buyer = trim($this->_post('buyer'));
        $oId = intval($this->_post('oId'));
        $payPrice = floatval($this->_post('payPrice'));
        $tradeNo = trim($this->_post('tradeNo'));
        $payments = trim($this->_post('payments'));
        $totalFee = floatval($this->_post('totalFee'));

        if($payPrice > 0 && $oId > 0) {
            $orderM = M('orders');
            $ordersDetailM = M('orders_detail');
            $order = $orderM->where('id = ' . $oId)->find();

            if(!($payPrice < $order['pay_price'])) {
                if(!empty($order)) {
                    //写入支付日志
                    $orderPayLogM = M('order_paylogs');
                    $data = array();
                    $data['u_id'] = $order['u_id'];
                    $data['admin_id'] = $_SESSION['admin_id'];
                    $data['o_id'] = $oId;
                    $data['payments'] = $payments;
                    $data['pay_price'] = $payPrice;
                    $data['orderId'] = $order['orderId'];
                    $data['buyer'] = $buyer;
                    $data['total_fee'] = $totalFee;
                    $data['trade_no'] = $tradeNo;
                    //                '1:交易成功',
                    $data['trade_status'] = 1;
                    //                '资金加减操作，加为1，减为2',
                    $data['act'] = 1;

                    //更新订单状态
                    //货到付款，且已发货的订单
                    $payMethod = intval($order['supportmetho']);
                    $status = intval($order['status']);

                    //        7=>"货到付款-现金",
                    //        8=>"货到付款-POS刷卡",
                    //        9=>"货到付款-手机支付",
                    if(in_array($payMethod, array(7, 8, 9))) {
                        if($status > 3 && $status < 6) {
                            $orderData = array();
                            $orderData['support_time'] = time();
                            // `status` '1=>"待付款",2=>"已付款",3=>"待发货",4=>"待收货",5=>"已收货",6=>"已完成",7=>"退货中" ,8=>"退货完成", 9=>"关闭"',
                            $orderData['status'] = 5;
                            $orderM->where('id = ' . $oId)->save($orderData);

                            $ordersDetailData = array();
                            $ordersDetailData['status'] = 5;
                            $ordersDetailData['sync'] = 1;
                            $ordersDetailM->where('o_id = ' . $oId)->save($ordersDetailData);

                            //写入订单日志, 付款，已收货
                            $ordersModiM = M('orders_modi');
                            $modiData = array();
                            $modiData['orderId'] = $order['orderId'];
                            $modiData['modi'] = '系统';
                            $modiData['info'] = '货到付款,支付';
                            $modiData['admin_id'] = $_SESSION['admin_id'];
                            $modiData['created'] = time();
                            $ordersModiM->add($modiData);

                            $modiData['info'] = '货到付款,已收货';
                            $ordersModiM->add($modiData);
                            //写入支付日志
                            $orderPayLogM->add($data);
                            $this->result['status'] = 1;
                        } else {
                            $this->result['msg'] = '货到付款的订单,需要发货后,才能付款!';
                        }
                    } elseif(in_array($payMethod, array(1, 2, 3, 5, 6))) {
                        //1=>"支付宝", 2=>"财付通", 3=>"微支付",    5=>"储蓄卡",   6=>"信用卡",
                        //在线支付的订单，只有未付款的才可以在后台进行支付操作
                        if(1 === $status) {
                            $orderData = array();
                            $orderData['support_time'] = time();
                            $orderData['status'] = 2;
                            $orderM->where('id = ' . $oId)->save($orderData);

                            $ordersDetailData = array();
                            $ordersDetailData['status'] = 2;
                            $ordersDetailM->where('o_id = ' . $oId)->save($ordersDetailData);

                            //写入订单日志, 付款，已收货
                            $ordersModiM = M('orders_modi');
                            $modiData = array();
                            $modiData['orderId'] = $order['orderId'];
                            $modiData['modi'] = '系统';
                            $modiData['info'] = '订单后台支付操作';
                            $modiData['admin_id'] = $_SESSION['admin_id'];
                            $modiData['created'] = time();
                            $ordersModiM->add($modiData);

                            //写入支付日志
                            $orderPayLogM->add($data);
                            $this->result['status'] = 1;
                        } else {
                            $this->result['msg'] = '在线支付的订单，只有未付款时才允许后台支付!';
                        }
                    }
                }
            } else {
                $this->result['msg'] = '付款金额小于订单需要支付的金额!';
            }

            echo json_encode($this->result);
        }
    }

    /**
     * 改变发货状态, 如果一次多单可用逗号分隔，必须是同一人收货地址，只发送一条通知信息
     */
    public function doSendGoods($orderNames = '') {
        set_time_limit(0);
        $orderNames = I('order_name', $orderNames);
        if(!empty($orderNames)){

            $orderAddrM = M('order_address');
            $orderM = M('order');
            $groupbuyOrderM = M('groupbuying_order');

            $resrow = $orderM->where('order_name IN (' . $orderNames . ') && operation_id = 10')->save(array('operation_id' => 2));
            $groupbuyOrderM->where('order_name IN (' . $orderNames . ')')->save(array('state' => 5));
            $this->result['status'] = 1;

            if($resrow !=0)
            {
                $orderdatalist = $orderM->where('order_name IN (' . $orderNames . ')')->select();
                $orderaddrlist = $orderAddrM->where('order_id = '.$orderdatalist[0]['id'])->select();
                $content = '您的订单：'.$orderNames.' 已发货。由['.$orderdatalist[0]['shipping_name'].']快递进行配送，快递单号为：'.$orderdatalist[0]['delivery_id'].'，回复TD退订';//内容
                $send_res = $this->sendsmsMsg($orderaddrlist[0]['mobile'],$content);
                $this->record_sms_log($orderaddrlist[0]['mobile'],$content,$send_res,1);
//                $this->sendsmsMsg('15355309566',$content);

                $wxToken = getMem('wx_api_access_token');
//                $wxToken = 'b4n_BgeIRADIvJuF_L2N4yLAcUJFkw1l_648OqcL66WzukFX8vucxdqdPPIVED7HSSa3uWHBDJbtvTmfRNNyvgdJb6r-CbBhHiCU4ncz5pYONMcAHAGFE';
                $userWxM = M('user_wx');
                $userWxItem = $userWxM->where('uid = ' . $orderdatalist[0]['uid'])->find();
//                $userWxItem = $userWxM->where('uid = 332885')->find();

                if(!empty($wxToken) && !empty($userWxItem)){
                    $wxUrl = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $wxToken;
                    $wxData = array(
                        'touser' => $userWxItem['openid'],
                        'msgtype' => 'text',
                        'text' => array(
                            'content' => urlencode('您在叔小白 m.shuxiaobai.com 的订单：'.$orderNames.' 已发货。由['.$orderdatalist[0]['shipping_name'].']快递进行配送，快递单号为：'.$orderdatalist[0]['delivery_id'])
                        ),
                    );
                    $wxDataJson = urldecode(json_encode($wxData));
                    $wxResult = getCurlRequest($wxUrl, $wxDataJson);
                    deBugLog('===SendOrder===' . $orderNames , __FILE__);
                    deBugLog('===weixinsendmsg===' . json_encode($wxResult), __FILE__);
                } else {
                    deBugLog('===$wxToken===' . $wxToken , __FILE__);
                    deBugLog('===$userWxItem===' . json_encode($userWxItem), __FILE__);
                }
            }

        }

        echo json_encode($this->result);
    }

    public function sendOrderMsg($orderName, $mobile, $deliveryId){
        $orderName = I('orderName', $orderName);
        $mobile = I('mobile', $mobile);
        $deliveryId = I('deliveryId', $deliveryId);
        $content = '您的订单：'.$orderName.' 已发货。由[京东快递]快递进行配送，快递单号为：'. $deliveryId .'，回复TD退订';//内容
        $this->sendsmsMsg($mobile,$content);
    }

    public function printOrder() {
        $id = I('id');

        $this->display('printOrder');
    }

    /**
     *  订单处理后，返回当前订单状态更新后的数据
     * @param $orderM
     * @param $oId
     * @return mixed
     */
    protected function getActOrder($orderM, $oId) {
        //ajax更新当前处理的这条订单信息
        import('@.ORG.Orders');
        $ordersObj = new Orders();
        $order = $orderM->where('id = ' . $oId)->find();
        $actionButton = $ordersObj->getActionButton($order);
        $order['actionButton'] = $actionButton;
        $this->assign('order', $order);

        return $this->fetch('item');
    }

    /**
     * 写入订单修改日志
     */
    protected function  addModiLog() {


    }

    public function testSendMsg(){
        $phone = I('p', '13625866022');
        //$content = I('c', '您的订单：1512041003396924 已发货。由[京东快递]快递进行配送，快递单号为：VB25347602265，回复TD退订');
        $content = I('c', '您在[叔小白]上的订单：1512041003396924 已发货。由[京东快递]快递进行配送，快递单号为：VB25347602265，回复TD退订');
        $send_res = $this->sendsmsMsg($phone, $content);

    }

    protected function sendsmsMsg($phone,$content)
    {
        $smsUrl = C('SMS_URL');
        //发货成功
        //发送短信通知
        $account = C('SMS_ACCOUNT');
        $password = C('SMS_PASSWD');
        $userid = C('SMS_USERID');
        $contentSend = $content;
        $timestamps = time()*1000;

        $md5Paswd = md5($password.$phone.$timestamps);

        $params = array(
            'account' => $account,
            'password' => $md5Paswd,
            'mobile' => $phone,
            'content' => $contentSend,
            'timestamps' => $timestamps
        );

        $response =  getCurlRequest($smsUrl, http_build_query($params));

        if(!empty($response))
        {
            $json_data = $response;
            if(!empty($json_data))
            {
                if(count($json_data['Rets']) != 0 )
                {
                    foreach($json_data['Rets'] as $key => $value )
                    {
                        if($value['Rspcode'] == 0)
                        {
                            //某条发送成功
                            return true;
                        }
                    }
                }
            }

            return false;
        }
        else{
            return false;
        }
    }

    public function mergeDelivery(){
//        {order_names: checkedOrders.join(','), delivery_company: deliveryCompany, delivery_id: deliveryId};
        $orderNames = I('order_names', '');
        $deliveryCompany = I('delivery_company', '');
        $deliveryId = I('delivery_id', '');

        if(!empty($orderNames) && !empty($deliveryCompany) && !empty($deliveryId) && $deliveryCompany != '0'){
            $orderM = M('order');
            $shippingCompanyConf = C('SHIPPING_COMPANY');
            $changeRowsNum = $orderM->where('order_name IN (' . $orderNames . ') && operation_id = 10')->save(array(
                'shipping_name' => $shippingCompanyConf[$deliveryCompany],
                'shipping_id' => $deliveryCompany,
                'delivery_id' => $deliveryId,
            ));

            if($changeRowsNum > 0){
                $this->doSendGoods($orderNames);
                $this->result['msg'] = '合并发货成功';
                $this->result['status'] = 1;
            }
        } else {
            $this->result['msg'] = '参数出错';
        }


        echo json_encode($this->result);
    }

    //记录短信接口调用结果
    public function record_sms_log($phone,$content,$sendres,$sms_type)
    {
        $strNow = date("Y-m-d H:i:s");

        //插入新数据
        $insertLog_data = array(
            'mobile'=>$phone,
            'content'=>$content,
            'send_result'=>$sendres,
            'add_time'=>$strNow,
            'type'=>$sms_type,
        );

        $mobile_msg_logM = M('mobile_msg_log');
        $mobile_msg_logM->add($insertLog_data);
    }

    public function testWxMsg(){
        $wxToken = getMem('wx_api_access_token');
        echo 'wxtoken===' . $wxToken;
        //                $wxToken = 'b4n_BgeIRADIvJuF_L2N4yLAcUJFkw1l_648OqcL66WzukFX8vucxdqdPPIVED7HSSa3uWHBDJbtvTmfRNNyvgdJb6r-CbBhHiCU4ncz5pYONMcAHAGFE';
        $userWxM = M('user_wx');
        $userWxItem = $userWxM->where('uid = 343559')->find();
        //                $userWxItem = $userWxM->where('uid = 332885')->find();

        if(!empty($wxToken) && !empty($userWxItem)){
            $wxUrl = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $wxToken;
            $wxData = array(
                'touser' => $userWxItem['openid'],
                'msgtype' => 'text',
                'text' => array(
                    'content' => urlencode('您在叔小白 m.shuxiaobai.com 的订单：'.'123456'.' 已发货。由['.'京东快递'.']快递进行配送，快递单号为：'.'jd133948556'
                )),
            );
            $wxDataJson = urldecode(json_encode($wxData));
            $wxResult = getCurlRequest($wxUrl, $wxDataJson);

            var_dump($wxResult);
        }
    }



}