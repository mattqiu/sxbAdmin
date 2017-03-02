<?php

/**
 * Class JOrderAction
 *  京东订单导入导出及发货功能 以及订单查询功能
 */
class JdOrderAction extends CommonAction {
    const PAGE_NUM = 100;

    public function _init() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        header('"text/html; charset=UTF-8"');
    }



    //订单列表
    public function index() {
        $this->getOrderList();

        $supplyM = M('supply');
        $supplyList = $supplyM->select();
        $this->assign('supply_list', $supplyList);

        $sendWarehomeListM = M('send_warehome');
        $warehomeList = $sendWarehomeListM->select();
        $this->assign('warehome_list', $warehomeList);

        $this->display('JdOrder/index');
    }

    /**
     *  小拼拼订单管理
     */
    public function xppOrder(){
        $params['send_warehome_name'] = 9;
        $params['open_order_id'] = 1;
        $this->getOrderList($params);

        $supplyM = M('supply');
        $supplyList = $supplyM->select();
        $this->assign('supply_list', $supplyList);

        $sendWarehomeListM = M('send_warehome');
        $warehomeList = $sendWarehomeListM->select();
        $this->assign('warehome_list', $warehomeList);

        $this->display('JdOrder/xppOrder');
    }

    /**
     *  小拼拼上海仓打印系统
     */
    public function xppTtgyShWarehouse(){
        $params = array();
        if(!isset($_REQUEST['status'])){
            $params['status'] = 2;
        }
        $params['send_warehome_name'] = 9;
        $params['is_export_to_warehome'] = 2;
        $params['open_order_id'] = 1;
        if(!isset($_REQUEST['print_num'])){
            $_REQUEST['print_num'] = 2;
            $_GET['print_num'] = 2;
        }
        $this->getOrderList($params);

        $this->assign('open_order_id', 1);
        $this->assign('act_name', 'xppTtgyShWarehouse');
        $this->assign('send_warehome_name', 9);
        //只显示已经发了邮件的
        $this->assign('is_export_to_warehome', 2);
        $this->display('JdOrder/warehousePrint');
    }

    /**
     *  天天果园上海仓发货
     * 限只能打印已同步到京东且是上海仓的订单
     */
    public function ttgyShWarehouse(){
        $params = array();
        if(!isset($_REQUEST['status'])){
            $params['status'] = 2;
        }
        $params['open_order_id'] = 0;
        $params['send_warehome_name'] = 4;
        $params['is_export_to_warehome'] = 2;
        if(!isset($_REQUEST['print_num'])){
            $_REQUEST['print_num'] = 2;
            $_GET['print_num'] = 2;
        }
        $this->getOrderList($params);

        $this->assign('open_order_id', 0);
        $this->assign('act_name', 'ttgyShWarehouse');
        $this->assign('send_warehome_name', 4);
        //只显示已经发了邮件的
        $this->assign('is_export_to_warehome', 2);
        $this->display('JdOrder/warehousePrint');
    }

    public function ttgyBjWarehouse(){
        $params = array();
        if(!isset($_REQUEST['status'])){
            $params['status'] = 2;
        }

        $params['open_order_id'] = 0;
        $params['send_warehome_name'] = 5;
        $params['is_export_to_warehome'] = 2;
        if(!isset($_REQUEST['print_num'])){
            $_REQUEST['print_num'] = 2;
            $_GET['print_num'] = 2;
        }
        $this->getOrderList($params);

        $this->assign('open_order_id', 0);
        $this->assign('act_name', 'ttgyBjWarehouse');
        $this->assign('send_warehome_name', 5);
        //只显示已经发了邮件的
        $this->assign('is_export_to_warehome', 2);
        $this->display('JdOrder/warehousePrint');
    }

    /**
     *  果园广州仓打印
     */
    public function ttgySzWarehouse(){
        $params = array();
        if(!isset($_REQUEST['status'])){
            $params['status'] = 2;
        }
        $params['open_order_id'] = 0;
        $params['send_warehome_name'] = 7;
        $params['is_export_to_warehome'] = 2;
        if(!isset($_REQUEST['print_num'])){
            $_REQUEST['print_num'] = 2;
            $_GET['print_num'] = 2;
        }
        $this->getOrderList($params);

        $this->assign('open_order_id', 0);
        $this->assign('act_name', 'ttgySzWarehouse');
        $this->assign('send_warehome_name', 7);
        //只显示已经发了邮件的
        $this->assign('is_export_to_warehome', 2);
        $this->display('JdOrder/warehousePrint');
    }

    /**
     *  果园成都仓打印
     */
    public function ttgyCdWarehouse(){
        $params = array();
        if(!isset($_REQUEST['status'])){
            $params['status'] = 2;
        }
        $params['open_order_id'] = 0;
        $params['send_warehome_name'] = 8;
        $params['is_export_to_warehome'] = 2;
        if(!isset($_REQUEST['print_num'])){
            $_REQUEST['print_num'] = 2;
            $_GET['print_num'] = 2;
        }
        $this->getOrderList($params);

        $this->assign('open_order_id', 0);
        $this->assign('act_name', 'ttgyCdWarehouse');
        $this->assign('send_warehome_name', 9);
        //只显示已经发了邮件的
        $this->assign('is_export_to_warehome', 2);
        $this->display('JdOrder/warehousePrint');
    }

    private function getOrderList($params = array()){
        $time = I('time', 11);                             //按时间查询
        $limit_date_From = I('limit_date_From');       //从XXX开始    日期
        $limit_date_To = I('limit_date_To');           //从XXX截至    日期
        $status = I('status', 11);                         //订单状态
        $jd_can_shipping = I('jd_can_shipping', 11);       //是否可发货
        $send_warehome_name = I('send_warehome_name', ''); //按发货仓
        $package_num = I('package_num', 11);               //包裹数量
        $import_jd_num = I('import_jd_num', 11);           //是否导入京东
        $print_num = I('print_num', 11);                     //是否已打印
        $delivery_id = I('delivery_id');               //运单号
        $groupbuy_order_name = I('groupbuy_order_name');//团单号
        $order_name = I('order_name');                 //订单号
        $product_name = I('product_name');             //物品名
        $rec_name = I('rec_name');                     //收件人
        $rec_mobile = I('rec_mobile');                 //收件人电话
        $shipping_status = I('shipping_status');       //物流信息
        $shipping_finish = I('shipping_finish');       //是否签收
        $rec_address = I('rec_address');               //收货地址

        $isExportToWarehouse = I('is_export_to_warehome', ''); //是否已经发邮件给仓库

        $jdOrder = M("tmp_jd_order");
        $where = array();

        //如果定义了params 强制重写
        $status = isset($params['status']) ? trim($params['status']) : $status;
        $send_warehome_name = isset($params['send_warehome_name']) ? trim($params['send_warehome_name']) : $send_warehome_name;
        $print_num = isset($params['print_num']) ? trim($params['print_num']) : $print_num;

        if(isset($params['is_export_to_warehome'])){
            $where['is_export_to_warehome'] = array('eq', $params['is_export_to_warehome']);
        }

        //外部合作订单的标识, 默认为0， 1是宁波周吉的小拼拼
        if(isset($params['open_order_id'])){
            $where['open_order_id'] = $params['open_order_id'];
        }

        if(!empty($isExportToWarehouse)){
            $where['is_export_to_warehome'] = array('eq', $isExportToWarehouse);
        }

        //1.所有下拉选择的选项， 时间，状态，是否可发货，发货仓，包裹数，是否导入京东
        if($time != 11){
            $time_From = $limit_date_From . ' ' . I('limit_time_From');
            $time_To = $limit_date_To . ' ' . I('limit_time_To');
            switch($time){
                case 1:
                    //取出时间查询
                    $where['add_time'] = array(array("egt", "$time_From"), array("elt", "$time_To"));
                    $time_Type = 1;
                    $this->assign("type", $time_Type);
                    break;

                case 2:
                    //导入京东时间
                    $where['last_import_jd_time'] = array(array("egt", "$time_From"), array("elt", "$time_To"));
                    $time_Type = 2;
                    $this->assign("type", $time_Type);
                    break;

                case 3:
                    //打印时间查询
                    $where['last_print_time'] = array(array("egt", "$time_From"), array("elt", "$time_To"));
                    $time_Type = 3;
                    $this->assign("type", $time_Type);
                    break;

                case 4:
                    //打印时间查询
                    $where['last_send_mail_time'] = array(array("egt", "$time_From"), array("elt", "$time_To"));
                    $time_Type = 4;
                    $this->assign("type", $time_Type);
                    break;

            }
        }

        if($status != 11){
            $where['status'] = array("eq", "$status");
        }

        if($jd_can_shipping != 11){
            if($jd_can_shipping === '1'){
                $where['jd_can_shipping'] = array("eq",1);
            }elseif($jd_can_shipping === '2'){
                $where['jd_can_shipping'] = array("eq",2);
            }elseif($jd_can_shipping === '3'){
                $where['jd_can_shipping'] = array("eq",3);
            }elseif($jd_can_shipping === '4'){
                $where['jd_can_shipping'] = array("eq",4);
            }
        }

        if(!empty($send_warehome_name)){
            $where['send_warehome_id'] = array("eq",$send_warehome_name);
        }

        if($package_num != 11){
            if($package_num === '1') {
                $where['package_num'] = array("eq", 1);
            } elseif($package_num === '2') {
                $where['package_num'] = array("gt", 1);
            }
        }

        if($import_jd_num != 11){
            if($import_jd_num === '1') {
                $where['import_jd_num'] = array("egt", 1);
            } elseif($import_jd_num === '2') {
                $where['import_jd_num'] = array("lt", 1);
            }
        }

        //按是否打印查询
        if($print_num !=11){
            if($print_num === '1'){
                $where['print_num'] = array("egt",1);
                $nums = 1;
                $this->assign("nums",$nums);
            }elseif($print_num === '2'){
                $where['print_num'] = array("lt",1);
                $nums = 2;
                $this->assign("nums",$nums);
            }
        }

        //按是否有物流信息查询
        if($shipping_status !=11){
            if($shipping_status === '1'){
                $where['shipping_status'] = array('eq','');
            }elseif($shipping_status === '2'){
                $where['shipping_status'] = array('neq','');
            }
        }

        //按是否已经签收查询
        if($shipping_finish != 11){
            if($shipping_finish === '1'){
                $where['shipping_finish'] = array('eq',1);
            }elseif($shipping_finish === '2'){
                $where['shipping_finish'] = array('eq',2);
            }
        }

        //2.所有输入框  运单号,订单号,团单号，物品名，收件人，收件人电话
        if(!empty($delivery_id)){
            $where['delivery_id'] = array("eq", "$delivery_id");
        }

        if(!empty($order_name)){
            //使用订单号查询
            $where['order_name'] = array("eq", "$order_name");
        }

        if(!empty($groupbuy_order_name)){
            $where['groupbuy_order_name'] = array("eq", "$groupbuy_order_name");
        }

        if(!empty($product_name)){
            $where['product_name'] = array("like", "%{$product_name}%");
        }

        if(!empty($rec_name)){
            $where['rec_name'] = array("eq", "$rec_name");
        }

        if(!empty($rec_mobile)){
            $where['rec_mobile'] = array("like", "%{$rec_mobile}");
        }

        if(!empty($rec_address)){
            $where['rec_address'] = array("like" , "%{$rec_address}%");
        }

        $count = $jdOrder->where($where)->count();
//        echo '===count==' . $jdOrder->getLastSql();
        $this->result['msg'] = '===count==' . $jdOrder->getLastSql();
        $Page = new Page($count, self::PAGE_NUM);
        $show = $Page->show();
        $data = $jdOrder->where($where)->order("id desc")->limit($Page->firstRow, $Page->listRows)->select();
//        echo '===datalist==' . $jdOrder->getLastSql();
        $this->result['msg'] .= '===datalist==' . $jdOrder->getLastSql();
        $this->assign("post", $_REQUEST);

        $jdCanShippingConf = C('JD_CAN_SHIPPING');
        $isSendMailConf = array(0=>'默认', 1=>'未发', 2=>'已发');
        foreach($data as $key => $item){
            $data[$key]['jd_can_shipping_name'] = $jdCanShippingConf[$item['jd_can_shipping']];

            $shippingStatusResult = json_decode($item['shipping_status'], true);
            $data[$key]['shipping_status_name'] = $shippingStatusResult[count($shippingStatusResult)-1]['ope_title'];

            $data[$key]['is_export_to_warehome'] = $isSendMailConf[$item['is_export_to_warehome']];
        }

        if(!empty($data)) {
            $this->assign("list", $data);
        } else {
            $this->assign("empty", "<td colspan='13' style='color:#ff0000;font-size:15px;text-align:center;'>当前条件下无订单信息！</td>");
        }
//        dump($data);
        $this->assign("page",$show);
        $resultData = array();
        $resultData['page'] = $show;
        $resultData['list'] = $data;
        return $resultData;
    }

    public function ajaxOrderItem() {
        $orderName = I('order_name', '');
        $model = new OrderModel();
        if(!empty($orderName)) {
            $whereArr[C('DB_PREFIX') . 'order.order_name'] = array('eq', $orderName);
        }
        $this->assign('order_name', $orderName);
        $result = $model->getOrdersList(0, $whereArr);
        if(!empty($result['order_list'])) {
            $this->result['status'] = 1;
            $this->assign('order', $result['order_list'][0]);
        }

        $this->result['data'] = $this->fetch('itemContent');
        echo json_encode($this->result);
    }


    /**
     *  添加补发的订单
     */
    public function bfFetchOrder() {
        $orderName = I('order_name', '');
        if(empty($orderName)){
            echo '订单号不存在';

            return;
        }

        $tmpJdOrderM = M('tmp_jd_order');
        $tmpOrder = $tmpJdOrderM->where(array('order_name' => $orderName))->find();

        if(!empty($tmpOrder)){
            $tmpData = array();
            $tmpData['order_name'] = 'bf' . $tmpOrder['order_name'];
            $tmpData['rec_name'] = $tmpOrder['rec_name'];
            $tmpData['rec_mobile'] = $tmpOrder['rec_mobile'];
            $tmpData['rec_tel'] = $tmpOrder['rec_tel'];
            $tmpData['rec_address'] = $tmpOrder['rec_address'];
            $tmpData['product_name'] = $tmpOrder['product_name'];
            $tmpData['num'] = 1;
            $tmpData['weight'] = 1;
            $tmpData['remark'] = $tmpOrder['remark'];
            $tmpData['add_time'] = date('Y-m-d H:i:s', time());
            $tmpData['status'] = 1;
            $tmpData['product_standard'] = $tmpOrder['product_standard'];
            $tmpData['product_id'] = $tmpOrder['product_id'];
            $tmpData['send_warehome_id'] = $tmpOrder['send_warehome_id'];
            $tmpData['send_warehome_en_name'] = $tmpOrder['send_warehome_en_name'];
            $tmpData['send_warehome_name'] = $tmpOrder['send_warehome_name'];
            $tmpData['rec_key'] = md5($tmpData['rec_name'] . $tmpData['rec_mobile'] . $tmpData['rec_address']);
            $tmpData['groupbuy_order_name'] = $tmpOrder['groupbuy_order_name'];
            $tmpData['distributor_id'] = $tmpOrder['distributor_id'];
            $result = $tmpJdOrderM->add($tmpData);

            if($result  > 0){
                echo '添加补发信息成功!';
            }
        }

//        $whereArr = array();
//        $model = new OrderModel();
//        $orderStatus = 5; //已发货的订单
//
//        $whereArr['order_name'] = $orderName;
//        //最后更新时间15天之内的订单
//        $whereArr['last_modify_time'] = array(array('egt', date('Y-m-d H:i:s', time()-86400 * 15)), array('elt', date('Y-m-d H:i:s', time())));
//
//        $result = $model->getFetchOrdersList($orderStatus, $whereArr);
//        echo '===总计===' . count($result['order_list']) . '单<br/>';
//        echo '===page===' . $result['page'] . '<br/>';
//        echo '===page===' . 'page-data' . '<br/>';
//        var_dump($result['page_data']);
//
//        if(empty($result['order_list'])) {
//            return;
//        }
//
//
//        $productM = M('product');
//        $sendWareHomeM = new SendWarehomeModel();
//        $dataAll = array();
//
//        foreach ($result['order_list'] as $item) {
//            $where = array();
//            $where['order_name'] = array('eq', 'bf' . $item['order_name']);
//            $isHave = $tmpJdOrderM->where($where)->find();
//            //已经存在的订单不再重复导入
//            if(!empty($isHave)) {
//                continue;
//            }
//            $data = array();
//            $data['order_name'] = $item['order_name'];
//            $data['rec_name'] = trim($item['name']);
//            $data['rec_mobile'] = trim($item['mobile']);
//            $data['rec_tel'] = $item['telephone'];
//            $data['rec_address'] = trim($item['address']);
//            $data['weight'] = 1;
//            $data['add_time'] = date('Y-m-d H:i:s', time());
//            $data['rec_key'] = md5($data['rec_name'] . $data['rec_mobile'] . $data['rec_address']);
//            $data['groupbuy_order_name'] = $item['groupbuy_order_name'];
//
//            if(!empty($item['order_product'])) {
//                foreach ($item['order_product'] as $product) {
//                    $productItem = $productM->where(array('id' => array('eq', $product['product_id'])))->find();
//                    $data['product_name'] = $productItem['product_name'];
//                    $data['remark'] = $productItem['product_name'];
//                    $data['num'] = $product['qty'];
//                    $data['product_standard'] = $product['gg_name'];
//                    $data['product_id'] = $product['product_id'];
//
//                    //发货仓
//                    $prodWareHome = $productItem['send_warehome'];
//                    $provinceCode = $item['province'];//省份代号
//                    $wareHomeData = $sendWareHomeM->getOrderWareHome($provinceCode, $prodWareHome);
//
//                    $data['send_warehome_id'] = $wareHomeData['send_warehome_id'];
//                    $data['send_warehome_name'] = $wareHomeData['send_warehome_name'];
//                    $data['send_warehome_en_name'] = $wareHomeData['send_warehome_en_name'];
//                    $data['source_city'] = $wareHomeData['source_city'];
//
//                    $data['jd_can_shipping'] = $item['jd_can_shipping'];
//                    $data['check_can_jd_result'] = $item['check_can_jd_result'];
//                    $data['groupbuy_order_name'] = $item['groupbuy_order_name'];
//                    $tmpJdId = $tmpJdOrderM->add($data);
//                    if(!($tmpJdId > 0)){
//                        echo '<br/>取出失败的订单<br/>';
//                        echo '<br/>' . $tmpJdOrderM->getLastSql() . ';<br/>';
//                    } else {
//                        //取出成功,将order表中的 has_export 改成1, 为了通过发货时的订单状态检查将订单状态改成待发货
//                        $orderUpResult = $model->where(array('order_name'=>array('eq', $item['order_name'])))->save(array('has_export'=> 1, 'operation_id'=>10));
//                        if($orderUpResult == false){
//                            echo 'order表更新失败===' . $model->getLastSql() . '<br/>';
//                        }
//                    }
//                }
//            }
//        }

    }


    /**
     *  按条件取出订单数据到ttgy_tmp_jd_order 表
     */
    public function fetchOrder() {
        $whereArr = array();
        $model = new OrderModel();
        $orderStatus = 0;

        if(isset($_REQUEST['order_status_sel'])) {
            $orderStatus = I('order_status_sel', 0);
        }

        if(isset($_REQUEST['send_channel'])) {
            $send_channel = I('send_channel', '');
            if(!empty($send_channel)) {
                $whereArr[C('DB_PREFIX') . 'order_product.send_channel'] = array('eq', $send_channel);
            }
        }

        $limitDate = array();
        $limitTime = array();
        if(!empty($_REQUEST['limit_date_fetch_From'])) {
            $limitDate[0] = $_REQUEST['limit_date_fetch_From'];
            $limitTime[0] = $_REQUEST['limit_time_fetch_From'];
        }
        if(!empty($_REQUEST['limit_time_fetch_To'])) {
            $limitDate[1] = $_REQUEST['limit_date_fetch_To'];
            $limitTime[1] = $_REQUEST['limit_time_fetch_To'];
        }

        if(count($limitDate) > 0) {
            //改成最后更新时间 chrisying 2015-11-26
            $whereArr['last_modify_time'] = array(array('egt', trim($limitDate[0]) . ' ' . $limitTime[0]), array('elt', trim($limitDate[1]) . ' ' . $limitTime[1]));
        }

        $result = $model->getFetchOrdersList($orderStatus, $whereArr);
        echo '===总计===' . count($result['order_list']) . '单<br/>';
        echo '===page===' . $result['page'] . '<br/>';
        echo '===page===' . 'page-data' . '<br/>';
        var_dump($result['page_data']);

        if(empty($result['order_list'])) {
            return;
        }

        $tmp_jd_orderM = M('tmp_jd_order');
        $productM = M('product');
        $sendWareHomeM = new SendWarehomeModel();
        $dataAll = array();

        foreach ($result['order_list'] as $item) {
            $where = array();
            $where['order_name'] = array('eq', $item['order_name']);
            $isHave = $tmp_jd_orderM->where($where)->find();
            //已经存在的订单不再重复导入
            if(!empty($isHave)) {
                continue;
            }
            $data = array();
            $data['order_name'] = $item['order_name'];
            $data['rec_name'] = trim($item['name']);
            $data['rec_mobile'] = trim($item['mobile']);
            $data['rec_tel'] = $item['telephone'];
            $data['rec_address'] = trim($item['address']);
            $data['weight'] = 1;
            $data['add_time'] = date('Y-m-d H:i:s', time());
            $data['rec_key'] = md5($data['rec_name'] . $data['rec_mobile'] . $data['rec_address'] . $data['send_warehome_id']);
            $data['groupbuy_order_name'] = $item['groupbuy_order_name'];

            if(!empty($item['order_product'])) {
                foreach ($item['order_product'] as $product) {
                    $productItem = $productM->where(array('id' => array('eq', $product['product_id'])))->find();
                    $data['product_name'] = $productItem['product_name'];
                    $data['remark'] = $productItem['product_name'];
                    $data['num'] = $product['qty'];
                    $data['product_standard'] = $product['gg_name'];
                    $data['product_id'] = $product['product_id'];

                    //发货仓
                    $prodWareHome = $productItem['send_warehome'];
                    $provinceCode = $item['province'];//省份代号
                    $wareHomeData = $sendWareHomeM->getOrderWareHome($provinceCode, $prodWareHome);

                    $data['send_warehome_id'] = $wareHomeData['send_warehome_id'];
                    $data['send_warehome_name'] = $wareHomeData['send_warehome_name'];
                    $data['send_warehome_en_name'] = $wareHomeData['send_warehome_en_name'];
                    $data['source_city'] = $wareHomeData['source_city'];

                    $data['jd_can_shipping'] = $item['jd_can_shipping'];
                    $data['check_can_jd_result'] = $item['check_can_jd_result'];
                    $data['groupbuy_order_name'] = $item['groupbuy_order_name'];
                    $data['uid'] = $item['uid'];
                    $tmpJdId = $tmp_jd_orderM->add($data);
                    if(!($tmpJdId > 0)){
                        echo '<br/>取出失败的订单<br/>';
                        echo '<br/>' . $tmp_jd_orderM->getLastSql() . ';<br/>';
                    } else {
                        //取出成功,将order表中的 has_export 改成1
                        $orderUpResult = $model->where(array('order_name'=>array('eq', $item['order_name'])))->save(array('has_export'=> 1));
                        if($orderUpResult == false){
                            echo 'order表更新失败===' . $model->getLastSql() . '<br/>';
                        }
                    }
                }
            }
        }

        echo '取出成功';
    }

    /**
     *  宁波小拼拼导出订单
     */
    public function xppExportOrder() {
        $model = new TmpJdOrderModel();
        $sendWarehomeM = M('send_warehome');
        $warehouseList = $sendWarehomeM->select();
        $warehouseIdArr = array();
        foreach($warehouseList as $item){
            $warehouseIdArr[$item['id']] = $item['name'];
        }

        $productName = I('product_name', '');
        $sendWarehomeId = I('send_warehome_id', '');
        $limitDateFrom = I('limit_date_from', '');
        $limitTimeFrom = I('limit_time_from', '');
        $limitDateTo = I('limit_date_to', '');
        $limitTimeTo = I('limit_time_to', '');
        $jdCanShipping = I('jd_can_shipping', '');

        $warehouseName = '';

        $where = array();

        if($sendWarehomeId != ''){
            $where['send_warehome_id'] = $sendWarehomeId;
            $warehouseName = $warehouseIdArr[$sendWarehomeId];
        }

        if(!empty($productName)) {
            $where['product_name'] = array('eq', $productName);
        }

        if(!empty($jdCanShipping)){
            $where['jd_can_shipping'] = $jdCanShipping;
        }

        if(!empty($limitDateFrom) && !empty($limitTimeFrom) && !empty($limitDateTo)
            && !empty($limitTimeTo)){
            $where['add_time'] = array(array('egt', trim($limitDateFrom . ' ' . $limitTimeFrom)), array('elt', trim($limitDateTo . ' ' . $limitTimeTo)));
        }

        //只能导出宁波小拼拼的订单
        $where['open_order_id'] = 1;

        $orderList = $model->where($where)->select();

        if(!empty($orderList)){
            foreach($orderList as $key => $order){
                if($order['open_order_id'] == 0){
                    continue;
                }
                $orderList[$key]['order_name'] = substr($order['order_name'], strlen($order['open_order_code']));
            }
        }

        //导出类型，默认是1快递格式，2是 捡货格式

        $type = I('export_type', 2);
        if($type == 1) {
            $xlsName = date('y-m-d-His') . '_' . $warehouseName . "_导入京东订单";

            $xlsResult = $model->getTmpJdXlsData($orderList);
            $typeName = 'export_order';
            if(isset($xlsResult['xls_data']['all']) && !empty($xlsResult['xls_data']['all'])) {
                foreach ($xlsResult['xls_data'] as $key => $xlsList) {
                    $this->exportExcel($xlsName . '_warehome_NO' . $warehouseIdArr[$key], $xlsResult['xls_cell'], $xlsList, $typeName, true);
                }


            }
        } else {
            $xlsName = date('y-m-d-His'). '_' . $warehouseName . "_出库单";
            $xlsResult = $model->getTmpGoodsXlsData($orderList);
            $typeName = 'export_send_channel_order';
            $this->exportExcel($xlsName, $xlsResult['xls_cell'], $xlsResult['xls_data'], $typeName, true);
        }

        $this->success('导出成功', '/JdOrder/xppOrder');
    }

    /**
     *  直接从临时表中导出京东快递表格 V3
     *
     */
    public function exportOrder() {
        $model = new TmpJdOrderModel();
        $sendWarehomeM = M('send_warehome');
        $warehouseList = $sendWarehomeM->select();
        $warehouseIdArr = array();
        foreach($warehouseList as $item){
            $warehouseIdArr[$item['id']] = $item['name'];
        }


        $productName = I('product_name', '');
        $sendWarehomeId = I('send_warehome_id', '');
        $limitDateFrom = I('limit_date_from', '');
        $limitTimeFrom = I('limit_time_from', '');
        $limitDateTo = I('limit_date_to', '');
        $limitTimeTo = I('limit_time_to', '');
        $jdCanShipping = I('jd_can_shipping', '');

        $warehouseName = '';

        $where = array();

        if($sendWarehomeId != ''){
            $where['send_warehome_id'] = $sendWarehomeId;
            $warehouseName = $warehouseIdArr[$sendWarehomeId];
        }

        if(!empty($productName)) {
            $where['product_name'] = array('eq', $productName);
        }

        if(!empty($jdCanShipping)){
            $where['jd_can_shipping'] = $jdCanShipping;
        }

        if(!empty($limitDateFrom) && !empty($limitTimeFrom) && !empty($limitDateTo)
            && !empty($limitTimeTo)){
            $where['add_time'] = array(array('egt', trim($limitDateFrom . ' ' . $limitTimeFrom)), array('elt', trim($limitDateTo . ' ' . $limitTimeTo)));
        }

//        $where['status'] = array('in', array(1,2));
//        if($sendWarehomeId == 4){
//            $where['status'] = array('eq', 2);
//        } else {
//            $where['status'] = array('in', array(1,2));
//        }
//        $where['jd_can_shipping'] = 2;
//        $where['print_num'] = '0';
//        $where['is_export_to_warehome'] = '1';
        $orderList = $model->where($where)->select();

        if(!empty($orderList)){
            foreach($orderList as $key => $order){
                if($order['open_order_id'] == 0){
                    continue;
                }
                $orderList[$key]['order_name'] = substr($order['order_name'], strlen($order['open_order_code']));
            }
        }

        //导出类型，默认是1快递格式，2是 捡货格式

        $type = I('export_type', 2);
        if($type == 1) {
            $xlsName = date('y-m-d-His') . '_' . $warehouseName . "_导入京东订单";

            $xlsResult = $model->getTmpJdXlsData($orderList);
            $typeName = 'export_order';
            if(isset($xlsResult['xls_data']['all']) && !empty($xlsResult['xls_data']['all'])) {
                foreach ($xlsResult['xls_data'] as $key => $xlsList) {
                    $this->exportExcel($xlsName . '_warehome_NO' . $warehouseIdArr[$key], $xlsResult['xls_cell'], $xlsList, $typeName, true);
                }

//                $allNum = count($xlsResult['xls_data']['all']);
//                if($allNum > 500) {
//                    $i = 1;
//                    $itemArr = array();
//                    $divideFileArr = array();
//                    foreach ($xlsResult['xls_data']['all'] as $item) {
//                        $itemArr[] = $item;
//                        if(0 == ($i % 500)) {
//                            $divideFileArr[] = $itemArr;
//                            $itemArr = array();
//                        }
//                        $i++;
//                    }
//
//                    if(!empty($itemArr)) {
//                        $divideFileArr[] = $itemArr;
//                    }
//
//                    foreach ($divideFileArr as $key => $divideFileData) {
//                        $tagNum = $key + 1;
//                        $this->exportExcel($xlsName . '_NO' . $tagNum, $xlsResult['xls_cell'], $divideFileData, $typeName);
//                        unset($divideFileArr[$key]);
//                    }
//                }
            }
        } else {
            $xlsName = date('y-m-d-His'). '_' . $warehouseName . "_出库单";
            $xlsResult = $model->getTmpGoodsXlsData($orderList);
            $typeName = 'export_send_channel_order';
            $this->exportExcel($xlsName, $xlsResult['xls_cell'], $xlsResult['xls_data'], $typeName, true);
        }

        $this->success('导出成功', '/JdOrder/index');
    }


    /**
     *  根据下单时间，订单状态和发货渠道导出订单功能
     *  chrisying 2015-11-11
     */
    public function exportOrderV2() {
        $whereArr = array();
        $model = new OrderModel();
        $orderStatus = 0;
        //导出类型，默认是1快递格式，2是 捡货格式
        $type = I('export_type', 2);

        if(isset($_REQUEST['order_status_sel'])) {
            $orderStatus = I('order_status_sel', 0);
        }

        if(isset($_REQUEST['send_channel'])) {
            $send_channel = I('send_channel', '');
            if(!empty($send_channel)) {
                $whereArr[C('DB_PREFIX') . 'order_product.send_channel'] = array('eq', $send_channel);
            }
        }

        $limitDate = array();
        $limitTime = array();
        if(!empty($_REQUEST['limit_date_export_From'])) {

            $limitDate[0] = $_REQUEST['limit_date_export_From'];
            $limitTime[0] = $_REQUEST['limit_time_export_From'];
        }
        if(!empty($_REQUEST['limit_time_export_To'])) {
            $limitDate[1] = $_REQUEST['limit_date_export_To'];
            $limitTime[1] = $_REQUEST['limit_time_export_To'];
        }

        if(count($limitDate) > 0) {
            //改成最后更新时间 chrisying 2015-11-26
            $whereArr['last_modify_time'] = array(array('egt', trim($limitDate[0]) . ' ' . $limitTime[0]), array('elt', trim($limitDate[1]) . ' ' . $limitTime[1]));
            //            $whereArr['time'] = array(array('egt', trim($limitDate[0]) . ' '.$limitTime[0]), array('elt', trim($limitDate[1]) . ' '.$limitTime[1]));
        }

        $result = $model->getExportOrdersList($orderStatus, $whereArr);

        if($type == 1) {
            $xlsName = date('y-m-d-His') . "_export_order_shipping";
            $xlsResult = $this->getJdXlsData($result);
            $this->exportExcel($xlsName, $xlsResult['xls_cell'], $xlsResult['xls_data'], 'export_order');
        } else {
            $xlsName = date('y-m-d-His') . "_export_order_product";
            $xlsResult = $this->getGoodsXlsData($result);
            $this->exportExcel($xlsName, $xlsResult['xls_cell'], $xlsResult['xls_data'], 'export_send_channel_order');
        }
    }



    /**
     *  果园备货的xls文档内容
     * @param $orderData
     * @return array
     */
    private function getGoodsXlsData($orderData) {
        $result = array('xls_cell' => array(), 'xls_data' => array());

        $orderAddressM = M('order_address');
        $areaM = M('area');
        $productM = M('product');

        $result['xls_cell'] = array(array('product_name', '商品品名'), array('product_standard', '规格'), array('product_num', '数量'),);

        $xls_data = array();

        if(!empty($orderData['order_list'])) {
            foreach ($orderData['order_list'] as $item) {
                $dataItem = array();
                $dataItem['order_name'] = $item['order_name'];
                $dataItem['name'] = $item['name'];
                $dataItem['mobile'] = $item['mobile'];
                $dataItem['telephone'] = $item['telephone'];
                $dataItem['address'] = $item['address'];

                $cityName = '';
                $orderAddressItem = $orderAddressM->where(array('order_id' => array('eq', $item['id'])))->find();
                if(!empty($orderAddressItem)) {
                    $areaItem = $areaM->where(array('id' => array('eq', $orderAddressItem['city'])))->find();
                    if(!empty($areaItem)) {
                        $cityName = $areaItem['name'];
                    }
                }
                $dataItem['recv_city'] = $cityName;
                if(!empty($item['order_product'])) {
                    foreach ($item['order_product'] as $product) {
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
        if(!empty($xls_data)) {
            foreach ($xls_data as $item) {
                $key = md5($item['product_name'] . $item['product_standard']);
                if(isset($productArr[$key])) {
                    $productData = $productArr[$key];
                    $productData['product_num'] = intval($productData['product_num']) + intval($item['product_num']);
                } else {
                    $productData = array('product_num' => $item['product_num'], 'product_standard' => $item['product_standard'], 'product_name' => $item['product_name']);
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
     *  京东快递模板的订单列表
     * @param $orderData
     * @return array
     */
    private function getJdXlsData($orderData) {
        $result = array('xls_cell' => array(), 'xls_data' => array());

        $orderAddressM = M('order_address');
        $areaM = M('area');
        $productM = M('product');

        $result['xls_cell'] = array(array('order_name', '关联订单'), array('name', '姓名'), array('mobile', '手机'), array('telephone', '座机'), array('address', '地址'), array('product_info', '物品内容'), array('qty', '包裹数量'), array('weight', '重量（kg）'), array('insured', '保价'), array('insured_money', '保价金额（元）'), array('money', '订单金额（元）'), array('COD', '代收货款'), array('remark', '备注信息'), array('delivery_type', '配送业务类型'),);

        if(!empty($orderData['order_list'])) {
            foreach ($orderData['order_list'] as $item) {
                $dataItem = array();
                $dataItem['order_name'] = $item['order_name'];
                $dataItem['name'] = $item['name'];
                $dataItem['mobile'] = $item['mobile'];
                $dataItem['telephone'] = $item['telephone'];
                $dataItem['address'] = $item['address'];
                $dataItem['weight'] = 1;
                $dataItem['insured'] = '否';
                $dataItem['insured_money'] = 0;

                //$dataItem['money'] = $item['money'];

                $dataItem['money'] = 0;
                //如果是货到付款的需要代收货款
                if(4 === intval($item['pay_parent_id'])) {
                    $dataItem['COD'] = '是';
                } else {
                    $dataItem['COD'] = '否';
                }
                $dataItem['delivery_type'] = '普通';
                $xlsData[] = $dataItem;

                $orderNameArr[] = $item['order_name'];

                if(!empty($item['order_product'])) {
                    foreach ($item['order_product'] as $product) {
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
    public function exportOrderOld() {

        $exportType = intval(I('export_type', 0));
        switch ($exportType) {
            case 1:
                //未导出过的新订单
                $orderM = new OrderModel();
                //未导出过的, 待发货的订单
                $where = 'has_export = 0 && (operation_id = 10 OR operation_id = 2) && (pay_status = 1 OR pay_parent_id = 4) AND time > "2015-10-13 21:00:00"';
                $xlsName = "export_new_order" . date('_YmdHis');

                $xlsCell = array(array('order_name', '关联订单'), array('name', '姓名'), array('mobile', '手机'), array('telephone', '座机'), array('address', '地址'), array('product_info', '物品内容'), array('qty', '包裹数量'), array('weight', '重量（kg）'), array('insured', '保价'), array('insured_money', '保价金额（元）'), array('money', '订单金额（元）'), array('COD', '代收货款'), array('remark', '备注信息'), array('delivery_type', '配送业务类型'),);

                $orderList = $orderM->relation(true)->where($where)->select();
                $orderNameArr = array();
                $xlsData = array();
                if(!empty($orderList)) {
                    foreach ($orderList as $item) {
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
                        if(4 === intval($item['pay_parent_id'])) {
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
                    $logData = array('export_name' => $xlsName, 'act_uid' => $_SESSION['admin_id'], 'export_orders' => serialize($orderNameArr), 'add_time' => time());
                    $exportOrderLogM->add($logData);

                }


                $this->exportExcel($xlsName, $xlsCell, $xlsData, 'export_order');
                break;

            case 2:
                //选中的订单

                break;
        }
    }

    public function importOrder() {
        $file = '/home/wwwroot/sp.com/manage/Public/export_new_order_20150812160748.xls';
        $this->importExecl($file);
    }

    /**
     *  批量导入京东xls表格数据进行发货
     */
    public function importSendOrder() {
        set_time_limit(0);
        $file = '/mnt/wwwtest/testm1/trunk/manage/upload/orderrecord.xls';
        //        $file = '/Users/chrisying/Desktop/orderrecord_11_24.xls';
        $result = $this->importExecl($file);
        var_dump($result);
        if(!empty($result['data'])) {
            $orderM = M('order');
            $data = array();
            $data['shipping_name'] = '京东快递';
            $data['shipping_id'] = 'jd_delivery';
            $data['is_send_jd'] = '1';
            foreach ($result['data'] as $key => $item) {
                if($key > 1) {
                    $where['order_name'] = array('eq', $item['C']);
                    $data['delivery_id'] = $item['B'];
                    $orderM->where($where)->save($data);
                    $this->doSendGoods($item['C']);
                    //$this->sendOrderMsg($item['C'], $item['I'], $item['B']);

                }

            }
        }
    }

    /**
     *  excel 表导入删除订单
     */
    public function importDelOrder() {
        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileFix = explode('.', $_FILES['import_file']['name']);
        $fileName = md5($_FILES['import_file']['name'] . time()) . '.' . $fileFix[1];
        $uploadFile = $savePath . $fileName;
        move_uploaded_file($_FILES['import_file']['tmp_name'], $uploadFile);
        $result = $this->importExecl($uploadFile);

        if(!empty($result['data'])) {
            $model = M('tmp_jd_order');
            echo '删除的订单：<br/>';
            foreach ($result['data'] as $key => $item) {
                if($key > 2) {
                    $orderName = $item['A'];
                    $where = array();
                    $where['order_name'] = array('eq', $orderName);
                    $model->where($where)->delete();
                    echo $orderName . '<br/>';
                }
            }

            echo '<br/><a href="/JdOrder/index">返回列表</a><br/>';
        }
    }

    /**
     *  excel表导入增加订单
     */
    public function importAddOrder() {
        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileFix = explode('.', $_FILES['import_file']['name']);
        $fileName = md5($_FILES['import_file']['name'] . time()) . '.' . $fileFix[1];
        $uploadFile = $savePath . $fileName;
        move_uploaded_file($_FILES['import_file']['tmp_name'], $uploadFile);
        $result = $this->importExecl($uploadFile);

        if(!empty($result['data'])) {
            $model = M('tmp_jd_order');
            echo '增加的订单：<br/>';
            foreach ($result['data'] as $key => $item) {
                if($key > 2) {
                    $orderName = $item['A'];
                    $where = array();
                    $where['order_name'] = array('eq', $orderName);
                    $model->where($where)->delete();
                    $data = array();
                    $model->add($data);
                    echo $orderName . '<br/>';
                }
            }

            echo '<br/><a href="/JdOrder/index">返回列表</a><br/>';
        }
    }


    /**
     *  将未导入到京东的订单手工导入到京东系统中
     */
    public function importToJd() {
        $sendWarehome = M('send_warehome');
        $wareHouseList = $sendWarehome->select();
        $wareHouseCodeList = array();
        if(empty($wareHouseList)) {
            echo '没有发货仓';

            return;
        }

        foreach ($wareHouseList as $item) {
            $wareHouseCodeList[$item['id']] = $item;
        }


        $isMerge = I('is_merge', 0);
        $sendOrderNames = I('order_names', '');
        $where = array();
        if(!empty($sendOrderNames)) {
            $where['order_name'] = array('IN', explode(',', $sendOrderNames));
        } else {
            //默认只导入从未导入过京东的订单
            $where['import_jd_num'] = array('eq', '0');
            $where['jd_can_shipping'] = array('eq', '2');
            $where['status'] = array('eq', '1');

            //暂时只有上海仓新系统打印
//            $where['send_warehome_id'] = array('eq', 5);
        }

        $tmpJdOrderM = M('tmp_jd_order');
        echo '==isMerge==' . $isMerge;
        //暂时限制2万单
        if($isMerge > 0){
            $orderList = $tmpJdOrderM->field('*')->where($where)->group('rec_key')->limit(0, 500)->select();
//            $orderList = $tmpJdOrderM->field('*, count(*) as package_count')->where($where)->group('rec_key')->limit(0, 500)->select();
        } else {
            $orderList = $tmpJdOrderM->field('*')->where($where)->limit(0, 500)->select();
        }

//        $orderList = $tmpJdOrderM->field('*, count(*) as package_count')->where($where)->group('rec_key')->having('count(*) > 1')->limit(0, 1000)->select();

        $orderNum = count($orderList);
        if($orderNum > 0) {
            $deliveryIdM = D('JdDeliveryId');
            $orderM = M('order');
            $expirtTime = time() - (3600 * 24 * 86);
            $deliveryWhere = array();
            $deliveryWhere['is_used'] = array('eq', '0');
            $deliveryWhere['add_time'] = array('gt', $expirtTime);


            foreach ($orderList as $key => $order) {
                $wareHouse = $wareHouseCodeList[$order['send_warehome_id']];

                $deliveryWhere['send_warehome_id'] = $order['send_warehome_id'];

                $deliveryItem = $deliveryIdM->where($deliveryWhere)->find();

                if(empty($deliveryItem)){
                    $deliveryIdM->getDeliveryId($wareHouse);
                }

                $order['package_count'] = 1;
                $order['delivery_id'] = $deliveryItem['delivery_id'];
                //订单号加前缀
                $order['self_order_name'] = $order['order_name'];
//                $order['order_name'] = 'T' . $order['order_name'];

                if($isMerge > 0 && $order['package_count'] > 1){
                    $order['order_name'] = 'M' . $order['order_name'] . $order['package_count'];
                    $order['merge_order_name'] = $order['order_name'];

                    //给合并发货的订单分配包裹号
                    $mergeWhere = $where;
                    $mergeWhere['rec_key'] = $order['rec_key'];
                    $mergeOrderList = $tmpJdOrderM->where($mergeWhere)->select();
                    foreach ($mergeOrderList as $k => $mergeOrder) {
                        $packageNo = $k + 1;
                        $data = array('package_no' => $packageNo);
                        $saveWhere = $mergeWhere;
                        $saveWhere['order_name'] = $mergeOrder['order_name'];
                        $tmpJdOrderM->where($saveWhere)->save($data);
                    }
                }



                $result = $deliveryIdM->sendWayBill($order, $wareHouse);
                var_dump($result);
                echo '<br/>';
                if($result['status']) {
                    $tmpJdOrderData = array();
                    $tmpJdOrderData['status'] = 2;
                    $tmpJdOrderData['last_import_jd_time'] = date('Y-m-d H:i:s', time());
                    $tmpJdOrderData['shipping_name'] = '京东快递';
                    $tmpJdOrderData['shipping_id'] = 'jd_delivery';
                    $tmpJdOrderData['delivery_id'] = $deliveryItem['delivery_id'];
                    $tmpJdOrderData['package_num'] = $order['package_count'];
                    $tmpJdOrderData['merge_order_name'] = $order['merge_order_name'];
                    //只更新当前查到订单范围内的订单信息
                    $tmpJdOrderWhere = $where;
                    if($isMerge > 0){
                        $tmpJdOrderWhere['rec_key'] = $order['rec_key'];
                    } else {
                        $tmpJdOrderWhere['order_name'] = $order['self_order_name'];
                    }

                    $tmpJdOrderM->where($tmpJdOrderWhere)->save($tmpJdOrderData);
                    echo $tmpJdOrderM->getLastSql() . '<br/><br/>';
                    $tmpJdOrderM->where($tmpJdOrderWhere)->setInc("import_jd_num", 1);
                    echo $tmpJdOrderM->getLastSql() . '<br/><br/>';
                    $deliveryIdM->where('id = ' . $deliveryItem['id'])->save(array('is_used' => 1));
                } else {
                    deBugLog(array('msg' => '运单号' . $order['delivery_id'] . '出错， 订单：' . $order['order_name'], 'result' => $result), 'sendWayBill_error');
                    switch ($result['code']) {
                        case 118:
                            //运单号不存在或者已使用
                            $deliveryIdM->where('delivery_id = "' . $order['delivery_id'] . '"')->save(array('is_used' => 1));
                            $lastSql = $deliveryIdM->getLastSql();
                            deBugLog(array('msg' => '运单号' . $order['delivery_id'] . '已使用或不存在， 订单：' . $order['order_name']) . '===lastsql=' . $lastSql, 'sendWayBill_error');
                            break;
                    }
                }
            }
        }
        deBugLog($orderList, 'sendWayBill');
        echo count($orderList) . '单';
    }


    /**
     *  批量导入京东xls表格数据进行发货
     */
    public function importWarehouseSendOrder(){
        set_time_limit(0);
        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileFix = explode('.', $_FILES['import_file']['name']);
        $fileName = md5($_FILES['import_file']['name'] . time()) . '.' . $fileFix[1];
        $uploadFile = $savePath . $fileName;
        move_uploaded_file($_FILES['import_file']['tmp_name'], $uploadFile);
        $result = $this->importExecl($uploadFile);

        if(empty($result['data'])){
            echo '没有需要导入的数据';
            exit;
        }

        $model = M('tmp_jd_send');
        echo '导入：' . (count($result['data']) -2) . '条数据<br/>';

        $succAddNum = 0;
        foreach ($result['data'] as $key => $item) {
            if($key > 2){
                $dataItem = array();
                $dataItem['order_name'] = str_replace('bf', '', $item['A']);
                $dataItem['rec_name'] = $item['B'];
                $dataItem['rec_mobile'] = $item['C'];
                $dataItem['product_name'] = $item['F'];
                $dataItem['remark'] = $item['M'];
                $dataItem['send_time'] = date('Y-m-d H:i:s', time());
                $dataItem['shipping_name'] = '京东快递';
                $dataItem['shipping_id'] = 'jd_delivery';
                $deliveryIdArr = explode('-', $item['O']);
                $dataItem['delivery_id'] = $deliveryIdArr[0];
                $dataItem['add_time'] = date('Y-m-d H:i:s', time());
                $dataItem['status'] = 0;
                $where = array();
                $where['order_name'] = array('eq', $dataItem['order_name']);
                $result = $model->where($where)->delete();
                $result = $model->add($dataItem);
                if($result == false){
                    echo $dataItem['order_name'] . ' === 导入失败<br/>';
                    Log::write('==import-jd-delivery_id' . $dataItem['order_name']);
                } else {
                    $succAddNum++;
                }
            }
        }

        echo '<br/>导入成功' . $succAddNum . '条记录<br/>';
    }


    public function testImportToJd() {
        $deliveryIdM = D('JdDeliveryId');
        $order = array();
        $order['delivery_id'] = 'VB25499517433';
        //        $order['delivery_id'] = 'VB25499517190';
        $order['order_name'] = '151227002';     //（最多支持20个字符）
        $order['rec_name'] = '应先生';     //收件人名称（最大支持25个汉字）
        $order['rec_address'] = '上海市普陀区云岭东路651号701室';     //收件人地址（最大支持128个汉字）
        $order['rec_tel'] = '15355309566';
        $order['rec_mobile'] = '15355309566';
        $order['package_count'] = '1';     //包裹数(大于0，小于1000)
        $order['product_name'] = '空包测试2';
        $order['remark'] = '空包测试2';


        $result = $deliveryIdM->sendWayBill($order);
        var_dump($result);
    }

    /**
     *  合并同一个发货地址的订单
     *  暂时取消此功能， 直接在导入京东时进行合并,并分配包裹号
     *  这样对操作人员比较方便，不然要长时间等待,操作两次, 可以放在后台定时任务里?
     *  chrisying 2015-12-29
     *
     */
    public function mergeOrder() {
        $mergeOrderData = array();

        $sendOrderNames = I('order_names', '');
        $where = array();
        if(!empty($sendOrderNames)) {
            $where['order_name'] = array('IN', explode(',', $sendOrderNames));
        } else {
            //默认只合并从未导入过京东的订单
            $where['import_jd_num'] = array('eq', '0');
            $where['status'] = array('eq', '1');
        }

        $tmpJdOrderM = M('tmp_jd_order');
        //暂时限制200
        $orderList = $tmpJdOrderM->field('*, count(*) as package_count')->where($where)->group('rec_key')->having('count(*) > 1')->limit(0, 200)->select();

        $orderNum = count($orderList);

        if(!($orderNum > 0)) {
            echo '没有需要合并的订单';
        }

        $deliveryIdM = D('JdDeliveryId');
        $orderM = M('order');
        $expirtTime = time() - (3600 * 24 * 86);
        $deliveryWhere = array();
        $deliveryWhere['is_used'] = array('eq', '0');
        $deliveryWhere['add_time'] = array('gt', $expirtTime);
        $deliveryCount = $deliveryIdM->where($deliveryWhere)->limit(0, $orderNum)->count();
        while ($deliveryCount < $orderNum) {
            $deliveryIdM->getDeliveryId();
            $deliveryCount = $deliveryIdM->where($deliveryWhere)->limit(0, $orderNum)->count();
        }

        $deliveryIdList = $deliveryIdM->where($deliveryWhere)->limit(0, $orderNum)->select();

        foreach ($orderList as $key => $order) {
            $order['delivery_id'] = $deliveryIdList[$key]['delivery_id'];
            //订单号加前缀
            $order['self_order_name'] = $order['order_name'];
            $order['order_name'] = 't' . $order['order_name'];
            if($order['package_count'] > 1) {
                $order['order_name'] = 'M' . $order['order_name'] . $order['package_count'];
                $order['merge_order_name'] = $order['order_name'];
            }

            //更新订单状态
            $tmpJdOrderData = array();
            $tmpJdOrderData['status'] = 5;
            $tmpJdOrderData['shipping_name'] = '京东快递';
            $tmpJdOrderData['shipping_id'] = 'jd_delivery';
            $tmpJdOrderData['delivery_id'] = $deliveryIdList[$key]['delivery_id'];
            $tmpJdOrderData['package_num'] = $order['package_count'];
            $tmpJdOrderData['merge_order_name'] = $order['merge_order_name'];
            $tmpJdOrderWhere = array();
            $tmpJdOrderWhere['rec_key'] = $order['rec_key'];
            $tmpJdOrderM->where($tmpJdOrderWhere)->save($tmpJdOrderData);
            $tmpJdOrderM->where($tmpJdOrderWhere)->setInc("import_jd_num", 1);
            $orderWhere = array('order' => array('eq', $order['self_order_name']));
            $orderM->where($orderWhere)->save(array('is_send_jd' => 1));
            $deliveryIdM->where('id = ' . $deliveryIdList[$key]['id'])->save(array('is_used' => 1));
        }

        echo '合并订单';
    }

    /**
     *  检查地址是否可以用京东生鲜配送
     */
    public function checkCanJdShipping() {
        $error_log = '';
        $printOrderNames = I('order_names', '');
        $where = array();
        if(!empty($printOrderNames)) {
            $where['order_name'] = array('IN', explode(',', $printOrderNames));
        } else {
            //默认只检查重未导入过京东,且未检查过的,或需要手工确认的订单
            $where['import_jd_num'] = array('eq', '0');
            $where['status'] = array('eq', '1');
            $where['print_num'] = array('eq', 0);
            $where['jd_can_shipping'] = array('IN', array(1, 4));
            //暂时只有上海仓新系统打印
//            $where['send_warehome_id'] = array('eq', 4);
        }

        //过滤预售商品，延迟发货订单 chrisying 16-3-24
        $filterResult = $this->filterSendOrder();
        if(!empty($filterResult)){
            foreach($filterResult as $key => $filter){
                $where[$key] = array('not in', $filter);
            }
        }

        $tmpJdOrderM = M('tmp_jd_order');
        $deliveryIdM = D('JdDeliveryId');
        $sendWarehome = M('send_warehome');

        $wareHouseList = $sendWarehome->select();
        $wareHouseCodeList = array();
        if(empty($wareHouseList)) {
            echo '没有发货仓';

            return;
        }

        foreach ($wareHouseList as $item) {
            $wareHouseCodeList[$item['id']] = $item;
        }

        $orderList = $tmpJdOrderM->where($where)->group('rec_key')->order('id asc')->limit(0, 10000)->select();
        if(empty($orderList)) {
            echo '没有需要检查的订单';

            return;
        }

        $successNum = 0;
        $failNum = 0;
        foreach ($orderList as $order) {

                        if(!isset($wareHouseCodeList[$order['send_warehome_id']])){
                            $error_log.= $order['order_name'] . '发货仓号不存在<br/>';
                            continue;
                        }
                        $wareHouseCode = $wareHouseCodeList[$order['send_warehome_id']];
            $result = $deliveryIdM->checkAddress($order['order_name'], $order['rec_address'], $wareHouseCode);

            if(!is_array($result)){
                echo '<br/>---字符串=====' .  $result . '<br/>';
            }
            if(isset($result['jingdong_etms_range_check_responce']['resultInfo']['rcode'])) {
                $rCode = $result['jingdong_etms_range_check_responce']['resultInfo']['rcode'];
                $data = array();
                switch ($rCode) {
                    case 100:
                        $data['jd_can_shipping'] = '2';
                        break;

                    case 200:
                        $data['jd_can_shipping'] = '3';
                        break;

                    case 150:
                        $data['jd_can_shipping'] = '4';
                        break;
                }

                if(empty($data)) {
                    $error_log .= $order['order_name'] . '是否可以京东快递配送检查出错<br/>';
                    continue;
                }

                $data['check_can_jd_result'] = json_encode($result['jingdong_etms_range_check_responce']['resultInfo']);
                $saveWhere = $where;
                $saveWhere['rec_key'] = $order['rec_key'];
                $saveResult = $tmpJdOrderM->where($saveWhere)->save($data);
                if($saveResult == false){
                    $failNum++;
                    echo '更新失败===' . $order['rec_key'];
//                    echo '更新失败===' . $order['order_name'];
                    echo $tmpJdOrderM->getLastSql() . '<br/>';
                } else {
                    $successNum++;
                }
            } else {
                echo '<br/> rcode====' . $result['jingdong_etms_range_check_responce']['resultInfo']['rcode'] . '<br/><br/>';
                echo '<br/>检查失败<br/>';
                var_dump($result);
            }
        }

        echo $error_log;

        echo '<br/>检查完成' . count($orderList) . ' 个订单<br/>';
        echo '<br/>成功' . $successNum . ' 个订单<br/>';
        echo '<br/>失败' . $failNum . ' 个订单<br/>';
    }

    /**
     *  当用户点击打印时,先更新选中的打印订单增加打印次数,
     * 并重新返回原来查询条件的最新数据
     *  在前端进行更新, 然后弹出生成打印pdf文档的页面
     */
    public function addIsPrinted(){
        $printOrderNames = I('order_names', '');
        $productName = I('product_name', '');
        $where = array();
        if(!empty($printOrderNames)) {
            $printOrderNames = base64_decode($printOrderNames);
            $where['id'] = array('IN', explode(',', $printOrderNames));
        } else {
            $this->result['msg'] = '请选择要打印的订单';
            echo json_encode($this->result);
            return;
        }

        $tmpJdOrderM = M('tmp_jd_order');
        //暂时限制2万单
        $orderList = $tmpJdOrderM->where($where)->select();
        if(empty($orderList)) {
            $this->result['msg'] = '没有找到需要打印的订单';
            echo json_encode($this->result);
            return;
        }

        foreach($orderList as $order){
            $saveWhere = array();
            $saveWhere['order_name'] = array('eq', $order['order_name']);
            $tmpJdOrderM->where($saveWhere)->setInc('print_num', 1);
            $tmpJdOrderM->where($saveWhere)->save(array('last_print_time'=>date('Y-m-d H:i:s', time())));
        }

        $params = array();
        $params['status'] = 2;
        $result = $this->getOrderList($params);

//        $where = array();
//        $where['status'] = array("eq", 2);
//        $where['send_warehome_name'] = array("like","%上海%");
//
//        if(!empty($productName)){
//            $where['product_name'] = array("like","%$productName%");
//        }

//        $count = $tmpJdOrderM->where($where)->count();
//        $Page = new Page($count, self::PAGE_NUM);
//        $pageShow = $Page->show();
//        $orderList = $tmpJdOrderM->where($where)->limit($Page->firstRow, $Page->listRows)->select();

        $pageShow = $result['page'];
        $orderList = $result['list'];

//        $content = $this->fetch('Member:read');
        if(!empty($orderList)) {
            $this->assign("list", $orderList);
        } else {
            $this->assign("empty", "<td colspan='13' style='color:#ff0000;font-size:15px;text-align:center;'>未查到信息，请查看信息是否输入错误！</td>");
        }

        $html = $this->fetch('./shipin_manager/Tpl/default/JdOrder/item.html');
        $this->result['status'] = 1;
        $this->result['data'] = array('html' => $html, 'page_str' => $pageShow);
        echo json_encode($this->result);
    }

    /**
     *  模式2，生成打印数据
     */
    public function createJdPrintPdf() {

        $sendWarehome = M('send_warehome');
        $wareHouseList = $sendWarehome->select();
        $wareHouseCodeList = array();
        if(empty($wareHouseList)) {
            echo '没有发货仓';

            return;
        }

        foreach ($wareHouseList as $item) {
            $wareHouseCodeList[$item['id']] = $item;
        }



        $printOrderNames = I('order_names', '');
        $where = array();
        if(!empty($printOrderNames)) {
            $printOrderNames = base64_decode($printOrderNames);
            $where['id'] = array('IN', explode(',', $printOrderNames));
        } else {
            //默认只打印从未打印过的订单
            $where['status'] = array('eq', '1');
            $where['print_num'] = array('eq', 0);
            $where['jd_can_shipping'] = array('eq', 2);
        }

        $tmpJdOrderM = M('tmp_jd_order');
        //暂时限制2万单
        $orderList = $tmpJdOrderM->where($where)->limit(0, 100)->select();
        if(empty($orderList)) {
            echo '没有需要打印的订单';
            return;
        }

        Vendor('tcpdf/JdPrintPdf');
        // create new PDF document
        $pdf = new JdPrintPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        foreach ($orderList as $order) {
            $warehouse = $wareHouseCodeList[$order['send_warehome_id']];
                //            $saveWhere = array();
//            $saveWhere['order_name'] = array('eq', $order['order_name']);
//            $tmpJdOrderM->where($saveWhere)->setInc('print_num', 1);

            $checkCanJdResult = json_decode($order['check_can_jd_result'], true);
            $pdf->AddPage();
            $pdf->write1DBarcode($order['delivery_id'] . '-' . $order['package_no'] . '-' . $order['package_num'] . '-', 'C128A', 10, 7, 85, 12, '', '', 'C');
            $pdf->SetFont('helvetica', '', 12);
            $pdf->MultiCell(97, 6, $order['delivery_id'] . '-' . $order['package_no'] . '-' . $order['package_num'] . '-', 0, 'C', 0, 0, 0, 19, true);

            $pdf->SetFont('sansfallback', '', 9);
            $pdf->MultiCell(50, 8, $checkCanJdResult['sourcetSortCenterName'], 0, 'L', 0, 1, 17, 25, true);
            $pdf->MultiCell(50, 8, $checkCanJdResult['targetSortCenterName'], 0, 'L', 0, 1, 67, 25, true);

            $pdf->SetFont('helvetica', '', 20);
            $pdf->MultiCell(50, 8, $checkCanJdResult['originalCrossCode'] . '-' . $checkCanJdResult['originalTabletrolleyCode'], 0, 'L', 0, 1, 17, 28, true);
            $pdf->MultiCell(50, 8, $checkCanJdResult['destinationCrossCode'] . '-' . $checkCanJdResult['destinationTabletrolleyCode'], 0, 'L', 0, 1, 67, 28, true);

            $pdf->SetFont('sansfallback', '', 10);
            $pdf->MultiCell(50, 8, $checkCanJdResult['siteName'], 0, 'L', 0, 1, 14, 37, true);

            $pdf->SetFont('helvetica', '', 18);
            $pdf->MultiCell(8, 8, $checkCanJdResult['road'], 0, 'C', 0, 1, 57, 36, true);
            $pdf->MultiCell(50, 8, $order['package_no'] . '/' . $order['package_num'], 0, 'C', 0, 1, 60, 36, true);

            $pdf->SetFont('sansfallback', '', 9);
            $pdf->MultiCell(50, 8, $order['rec_address'], 0, 'L', 0, 1, 13, 44, true);
            $pdf->MultiCell(53, 8, $order['rec_name'] . ' ' . $order['rec_mobile'] . ' ' . $order['rec_tel'], 0, 'L', 0, 1, 13, 56, true);

            $pdf->SetFont('helvetica', '', 12);
            $pdf->MultiCell(50, 10, $order['delivery_id'], 0, 'L', 0, 1, 55, 67, true);

            $pdf->SetFont('sansfallback', '', 8);
            $pdf->MultiCell(60, 6, $order['rec_name'] . ' ' . $order['rec_mobile'] . ' ' . $order['rec_tel'], 0, 'L', 0, 1, 19, 73, true);
            $pdf->write1DBarcode($order['delivery_id'], 'C128A', 10, 77, 52, 7, '', '', 'C');
            $pdf->SetFont('helvetica', '', 8);
            $pdf->MultiCell(50, 10, $order['delivery_id'], 0, 'C', 0, 1, 10, 84, true);

            $agingName = $checkCanJdResult['agingName'];
            $agingName = $agingName == '无时效' ? '' : $agingName;

            $pdf->SetFont('sansfallback', '', 12);
            $pdf->MultiCell(26, 10, $agingName, 0, 'C', 0, 1, 6, 90, true);

            $pdf->SetFont('sansfallback', '', 8);
            $pdf->MultiCell(40, 6, $order['remark'], 0, 'L', 0, 1, 65, 77, true);

            $pdf->SetFont('helvetica', '', 7);
            $pdf->MultiCell(30, 3, $order['order_name'], 0, 'L', 0, 1, 76, 99, true);
            $pdf->SetFont('sansfallback', '', 12);
            $pdf->MultiCell(20, 3, $order['source_city'], 0, 'L', 0, 1, 74, 104, true);

            $pdf->SetFont('sansfallback','', 6);
            $pdf->MultiCell(60, 6, '寄方信息:' . $warehouse['send_address'], 0, 'L', 0, 1, 6, 96, true);
            $pdf->MultiCell(80, 6, $warehouse['send_name'] . '' . $warehouse['send_mobile'], 0, 'L', 0, 1, 6, 100, true);

            $pdf->MultiCell(40, 6, '商家ID:  ' . $warehouse['jd_customer_code'], 0, 'L', 0, 1, 65, 96, true);
        }
        $pdf->Output('print_order.pdf', 'I');
    }

    /**
     *  模式1,取api中的打印数据进行打印打印京东快递单
     *  已废弃 chrisying 15-12-29
     */
    public function printJdOrder() {
        Vendor('fpdf/fpdf');
        Vendor('fpdi/fpdi');

        $printOrderNames = I('order_names', '');
        $where = array();
        if(!empty($printOrderNames)) {
            $where['order_name'] = array('IN', explode(',', $printOrderNames));
        } else {
            //默认只导入重未导入过京东的订单
            $where['import_jd_num'] = array('eq', '1');
            $where['status'] = array('eq', '1');
            $where['print_num'] = array('eq', 0);
        }

        $tmpJdOrderM = M('tmp_jd_order');
        //暂时限制2万单
        $orderList = $tmpJdOrderM->where($where)->limit(0, 3)->select();
        foreach ($orderList as $order) {
            if(!empty($order['print_data'])) {
                $jdOrderWhere = array('order_name' => array('eq', $order['order_name']));
                $tmpJdOrderM->where($jdOrderWhere)->setInc('print_num', 1);

                $pdfName = $order['order_name'] . '.pdf';
                $filesArr[] = $pdfName;
                file_put_contents($pdfName, base64_decode($order['print_data']));
            }
        }

        $pdf = new FPDI();

        // iterate through the files
        foreach ($filesArr AS $file) {
            // get the page count
            $pageCount = $pdf->setSourceFile($file);
            // iterate through all pages
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
                // get the size of the imported page
                $size = $pdf->getTemplateSize($templateId);

                // create a page (landscape or portrait depending on the imported page size)
                if($size['w'] > $size['h']) {
                    $pdf->AddPage('L', array($size['w'], $size['h']));
                } else {
                    $pdf->AddPage('P', array($size['w'], $size['h']));
                }

                // use the imported page
                $pdf->useTemplate($templateId);
            }
        }

        // Output the new PDF
        $pdf->Output('printJdOrder', 'I');
    }

    /**
     * 删除问题订单
     */
    public function delOrder(){
        $m = M("tmp_jd_order");
        $result = $m->where("id = {$_POST['oid']}")->delete();
        if($result){
            echo 1;
        }else{
            echo 2;
        }
    }

    /**
     *  小拼拼修改地址
     */
    public function xppSaveAddress(){
        $tmpJdOrderM = M('tmp_jd_order');

        $data['rec_name'] = I("save_rec_name");
        $data['rec_mobile'] = I("save_rec_mobile");
        $data['rec_tel'] = I("save_rec_mobile");
        $data['rec_address'] = I("save_rec_address");
        $data['jd_can_shipping'] = 1;
        $data['check_can_jd_result'] = '';
        $data['status'] = 1;
        $data['print_num'] = 0;
        $data['is_export_to_warehome'] = 1;
        $data['shipping_status'] = '';
        $data['package_no'] = 1;
        $data['package_num'] = 1;

        $where['order_name'] = array("eq",I("save_order_name_h"));
        //只能修改宁波小拼拼的订单
        $where['open_order_id'] = 1;
        //tmp_jd_order表中的数据以及状态修改
        $saveTmlJdOrder = $tmpJdOrderM->where($where)->save($data);

        if($saveTmlJdOrder){
            echo 1;
        }
    }

    /*
     * 修改订单地址
     * */
    public function saveAddress(){
        $tmpJdOrderM = M('tmp_jd_order');
        $groupbuyingOrderM = M('groupbuying_order');
        $orderM = M('order');
        $orderAddressM = M('order_address');

        $data['rec_name'] = I("save_rec_name");
        $data['rec_mobile'] = I("save_rec_mobile");
        $data['rec_tel'] = I("save_rec_mobile");
        $data['rec_address'] = I("save_rec_address");
        $data['jd_can_shipping'] = 1;
        $data['check_can_jd_result'] = '';
        $data['status'] = 1;
        $data['print_num'] = 0;
        $data['is_export_to_warehome'] = 1;
        $data['shipping_status'] = '';
        $data['package_no'] = 1;
        $data['package_num'] = 1;

        $where['order_name'] = array("eq",I("save_order_name_h"));
        $saveTmlJdOrder = $tmpJdOrderM->where($where)->save($data);             //tmp_jd_order表中的数据以及状态修改

        $result['recv_name'] = I("save_rec_name");
        $result['recv_phone'] = I("save_rec_mobile");
        $result['recv_address'] = I("save_rec_address");
        $saveGbo = $groupbuyingOrderM->where($where)->save($result);            //groupbuying_order表中的数据修改


        $orderId = $orderM->field('id')->where($where)->find();                     //订单ID

        $orderAdd['order_id'] = array("eq",$orderId['id']);
        $resu['position'] = I("save_rec_address");
        $resu['address'] = I("save_rec_address");
        $resu['name'] = I("save_rec_name");
        $resu['telephone'] = I("save_rec_mobile");
        $resu['mobile'] = I("save_rec_mobile");
        $saveOrderAdd = $orderAddressM->where($orderAdd)->save($resu);          //order_address表中的数据修改

        $dataOrder['check_can_jd'] = 1;
        $dataOrder['check_can_jd_result'] = '';
        $dataOrder['jd_can_shipping'] = 1;
        $saveOrder = $orderM->where($where)->save($dataOrder);                  //修改order表中的订单状态

        if($saveTmlJdOrder && $saveGbo && $saveOrderAdd){
            echo 1;
        }
    }

    /*
     * 补发订单查询订单收货信息
     * */
    public function search(){
        $order_name = I('order_name');
        $orderAddressM = M('order_address');
        $orderM = M('order');
        $where['order_name'] = array('eq',$order_name);
        $result = $orderM->field('id')->where($where)->find();
        $wheres['order_id'] = array('eq',$result['id']);
        $data = $orderAddressM->field('address,name,mobile')->where($wheres)->find();
        echo json_encode($data);
    }

    /*
     * 查询用户信息
     * */
    public function searchUser(){
        $mobile = I('mobile');
        $userM = M('user');
        $where['mobile'] = array('eq',$mobile);
        $data = $userM->field('username')->where($where)->find();
        echo json_encode($data['username']);
    }

    /*
     * 修改发货仓
     * */
    public function saveSend(){
        $id = I('id');
        $send_id = I('send_id');
        $jdOrderM = M('tmp_jd_order');

        $sendWarehomeM = M('send_warehome');
        $sendWarehome = $sendWarehomeM->where(array('id' => $send_id))->find();
        if(empty($sendWarehome)){
            echo 0;
            exit;
        }

        $where['id'] = array('in',$id);

        $data['jd_can_shipping'] = 1;       //地址检查
        $data['check_can_jd_result'] = '';  //是否可发京东快递的结果
        $data['status'] = 1;                //订单状态
        $data['print_num'] = 0;             //是否打印
        $data['is_export_to_warehome'] = 1; //邮件是否发送
        $data['shipping_status'] = '';      //快递状态
        $data['send_warehome_id'] = $send_id;        //修改发货仓id

        $data['delivery_id'] = '';
        $data['import_jd_num'] = 0;
        $data['print_data'] = '';
        $data['last_import_jd_time'] = '0000-00-00 00:00:00';
        $data['last_print_time'] = '0000-00-00 00:00:00';
        $data['last_send_mail_time'] = '0000-00-00 00:00:00';
        $data['last_check_shipping_time'] = '0000-00-00 00:00:00';
        $data['shipping_finish'] = 1;

        $data['package_no'] = 1;
        $data['package_num'] = 1;

        $data['send_warehome_en_name'] = $sendWarehome['en_name'];
        $data['send_warehome_name'] = $sendWarehome['name'];
        $data['source_city'] = $sendWarehome['source_city'];

        $result = $jdOrderM->where($where)->save($data);
//        dump($result);echo $jdOrderM->getLastSql();exit;
        if($result){
            echo 1;
        }
    }

    /**
     *  缺货的订单进行退款
     */
    public function refundNoStock(){
        $id = I('id', '');
        $jdOrderM = M('tmp_jd_order');
        $where = array();
        $where['id'] = array('in',$id);
        $tmpOrders = $jdOrderM->where($where)->select();

        if(empty($tmpOrders)){
            echo 0;
            exit;
        }

        $userWxM = new UserWxModel();
        $orderNameArr = array();
        foreach($tmpOrders as $order){
            $orderNameArr[] = $order['order_name'];

            $userWxItem = $userWxM->getUserItem($order['uid']);
            $content = '尊敬的顾客您好,很抱歉的通知您,订单号' . $order['order_name'] . ' 订购的' . $order['product_name'] . ' 由于缺货将给您安排退款, 非常抱歉给您带来的不便!【叔小白】http://m.shuxiaobai.com';
            sendWxMsg($userWxItem['openid'], $content);
        }

        $taskM = new TaskModel();
        $groupbuyingM = M('groupbuying_order');
        $where = 'order_name IN(' . implode(',', $orderNameArr) . ') AND state NOT IN (0,3,4)';
        $groupbuyingList = $groupbuyingM->where($where)->select();

        if(!empty($groupbuyingList)){
            foreach($groupbuyingList as $groupbuyOrder){
                $taskM->doGroupOrderRefund($groupbuyOrder, 1);
            }
        }

        echo '1';
        exit;
    }

    /**
     *  宁波小拼拼取消订单
     */
    public function xppCancelOrder(){
        $id = I('id', '');
        $jdOrderM = M('tmp_jd_order');
        $where = array();
        $where['id'] = array('in',$id);
        $tmpOrders = $jdOrderM->where($where)->select();

        if(empty($tmpOrders)){
            echo 0;
            return;
        }

        $orderNameArr = array();
        foreach($tmpOrders as $order){
            $orderNameArr[] = $order['order_name'];
        }

        $saveWhere = array();
        $saveWhere['order_name'] = array('in', $orderNameArr);
        $jdOrderM->where($saveWhere)->save(array('status'=>20));

        foreach($orderNameArr as $orderName){
            $refundResult[] = array('order_name' => $orderName, 'msg' => '订单取消');
        }

        echo json_encode($refundResult);
    }

    public function cancelOrder(){
        $id = I('id', '');
        $jdOrderM = M('tmp_jd_order');
        $where = array();
        $where['id'] = array('in',$id);
        $tmpOrders = $jdOrderM->where($where)->select();

        if(empty($tmpOrders)){
            echo 0;
            return;
        }

        $orderNameArr = array();
        foreach($tmpOrders as $order){
            $orderNameArr[] = $order['order_name'];
        }

        $saveWhere = array();
        $saveWhere['order_name'] = array('in', $orderNameArr);
        $jdOrderM->where($saveWhere)->save(array('status'=>20));

        $taskM = new TaskModel();
        $groupbuyingM = M('groupbuying_order');
        $where = array();
        $where['order_name'] = array('in', $orderNameArr);
        $where['state'] = array('not in', array(0,3,4));

        $groupbuyingList = $groupbuyingM->where($where)->select();

        $refundResult = array();
        if(!empty($groupbuyingList)){
            foreach($groupbuyingList as $groupbuyOrder){
                $refundResult[] = $taskM->doGroupOrderRefund($groupbuyOrder, 1);
            }
        }

        echo json_encode($refundResult);
    }

    private function filterSendOrder(){
        $filterSendOrderM = M('filter_send_order');
        $where = array();
        $where['send_date'] = array('gt', date('Y-m-d', time()));
        $list = $filterSendOrderM->where(array('send_date' ))->select();

        if(empty($list)){
            return array();
        }

        $result = array();
        foreach($list as $item){
            $result[$item['type']][] = $item['value'];
        }

        return $result;
    }

}
