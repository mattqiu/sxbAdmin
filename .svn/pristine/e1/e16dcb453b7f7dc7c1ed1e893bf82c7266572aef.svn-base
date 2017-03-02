<?php

/**
 * Class JOrderAction
 *  京东订单导入临时表及发货功能
 */
class JdSendAction extends CommonAction {

    public function _init(){
        set_time_limit(0);
        header('"text/html; charset=UTF-8"');
    }

    //订单列表
    public function index() {
        $where = array();

        $order_name = I('order_name', '');
        $delivery_id = I('delivery_id', '');
        $rec_phone = I('rec_phone', '');
        $rec_name = I('rec_name', '');

        if(!empty($order_name)){
            $where['order_name'] = array('eq', $order_name);
        }

        if(!empty($delivery_id)){
            $where['delivery_id'] = array('eq', $delivery_id);
        }

        if(!empty($rec_phone)){
            $where['rec_mobile'] = array('eq', $rec_phone);
        }

        if(!empty($rec_name)){
            $where['rec_name'] = array('eq', $rec_name);
        }

        $model = M('tmp_jd_send');
        $count = $model->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $model->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        $supplyM = M('supply');
        $supplyList = $supplyM->where('status = 1')->select();
        $this->assign("supply_list", $supplyList);

        $manageOrderStatusArr = C('MANAGE_ORDER_STATUS');
        $this->assign('manage_order_status', $manageOrderStatusArr);

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }

    public function importOrder(){
        $file = '/home/wwwroot/sp.com/manage/Public/export_new_order_20150812160748.xls';
        $this->importExecl($file);
    }

    /**
     *  批量导入京东xls表格数据进行发货
     */
    public function importSendOrder(){
        set_time_limit(0);
        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileFix = explode('.', $_FILES['import_file']['name']);
        $fileName = md5($_FILES['import_file']['name'] . time()) . '.' . $fileFix[1];
        $uploadFile = $savePath . $fileName;
        move_uploaded_file($_FILES['import_file']['tmp_name'], $uploadFile);
        $result = $this->importExecl($uploadFile);

        if(!empty($result['data'])){
            $model = M('tmp_jd_send');
            echo '增加的订单：' . count($result['data']) . '<br/>';

//            var_dump($result['data']);
            foreach ($result['data'] as $key => $item) {
                if($key > 1){
                    $dataItem = array();
                    $dataItem['order_name'] = str_replace('C', '', $item['C']);
                    $dataItem['rec_name'] = $item['I'];
                    $dataItem['rec_mobile'] = $item['J'];
                    $dataItem['product_name'] = $item['E'];
                    $dataItem['remark'] = $item['N'];
                    $dataItem['send_time'] = $item['A'];
                    $dataItem['shipping_name'] = empty($item['O']) ?  '京东快递' : $item['O'];
                    $dataItem['shipping_id'] = empty($item['O']) ?  'jd_delivery' : 'other_delivery';
                    $dataItem['delivery_id'] = $item['B'];
                    $dataItem['add_time'] = date('Y-m-d H:i:s', time());
                    $dataItem['status'] = 0;
//                    t151124160874c
//                    tBB151123248229c
                    $dataItem['order_name'] = str_replace('t', '', str_replace('gdz', '',str_replace('bf', '', trim($dataItem['order_name']))));
                    $where = array();
                    $where['order_name'] = array('eq', $dataItem['order_name']);
                    $result = $model->where($where)->delete();
                    if($result > 0){
                        echo  '<br/>删除' . $model->getLastSql() . '====' . $result . '<br/>';
                    }
                    $result = $model->add($dataItem);


                    if($result == false){
                        echo $dataItem['order_name'] . ' === 导入失败<br/>' . $model->getLastSql();
                        Log::write('==import-jd-delivery_id' . $dataItem['order_name']);
                    }
                    echo $dataItem['order_name'] . '<br/>';
                }

                }
            }

            echo '<br/><a href="/JdSend/index">返回列表</a><br/>';
    }

    /**
     *  去发货
     */
    public function doSendOrder(){
        $model = M('tmp_jd_send');
        $tmpJdOrderM = new TmpJdOrderModel();

        $where = array();
        $where['status'] = array('eq', 0);
        $list = $model->where($where)->limit(0, 10000)->select();
        if(!empty($list)){
            $orderM = M('order');
            $data = array();
//            $data['is_send_jd'] = '1';
            foreach($list as $key => $item){
                $tmpResult = $tmpJdOrderM->sendGoods($item['order_name']);

                $where = array();
                $where['order_name'] = array('eq', $item['order_name']);
                $data['delivery_id'] = $item['delivery_id'];
                $data['shipping_name'] = $item['shipping_name'];
                $data['shipping_id'] = $item['shipping_id'];
                $orderResult = $orderM->where($where)->save($data);

                $orderAction = new OrderAction();
                $orderAction->doSendGoods($item['order_name']);

                if($tmpResult && $orderResult){
                    $model->where($where)->delete();
                }
            }
        }
    }

    /**
     *  站内系统进行发货
     */
    public function sysSendOrder(){
        $tmpJdOrderM = M('tmp_jd_order');
        $tmpJdSendM = M('tmp_jd_send');
        $where = array();
        $where['status'] = array('eq', 2);
        $where['print_num'] = array('gt', 0);
        $where['is_export_to_warehome'] = array('eq', 2);
        //暂时仅限上海仓的
//        $where['send_warehome_id'] = array('eq', 4);
        $page = new Page();

        $count = $tmpJdOrderM->where($where)->count();
        $page = new Page($count, 1000);
        $strPage = $page->show();
        $orderList = $tmpJdOrderM->where($where)->limit($page->firstRow, $page->listRows)->select();

        if(empty($orderList)){
            echo '没有需要发货的订单';
            return;
        }

        foreach($orderList as $item){
            if(!empty($item['delivery_id'])){
                $sendWhere = array();
                $sendWhere['order_name'] = array('eq', $item['order_name']);
                $tmpJdSendM->where($sendWhere)->delete();
                $data = array();

                $dataItem = array();
                $dataItem['order_name'] = $item['order_name'];
                $dataItem['rec_name'] = $item['rec_name'];
                $dataItem['rec_mobile'] = $item['rec_mobile'];
                $dataItem['product_name'] = $item['product_name'];
                $dataItem['remark'] = $item['remark'];
                $dataItem['send_time'] = date('Y-m-d H:i:s', time());
                $dataItem['shipping_name'] = $item['shipping_name'];
                $dataItem['shipping_id'] = $item['shipping_id'];
                $dataItem['delivery_id'] = $item['delivery_id'];
                $dataItem['add_time'] = date('Y-m-d H:i:s', time());
                $dataItem['status'] = 0;

                $dataItem['order_name'] = str_replace('T', '', str_replace('gdz', '',str_replace('bf', '', trim($dataItem['order_name']))));

                $tmpJdSendM->add($dataItem);
            }
        }

        echo $strPage;

    }

    /**
     * 删除订单order_status 变为100
     */
    public function del() {
        $model = M('tmp_jd_send');
        $id = I('id', 0);
        if($id > 0){
            $where = array();
            $where['id'] = array('eq', $id);
            $model->where($where)->delete();

            $this->success('操作成功', '/JdSend/index', 1);
        } else {
            $this->error('参数错误', '/JdSend/index', 3);
        }
    }

    public function delAll(){
        $model = M('tmp_jd_send');
        $model->where('1=1')->delete();
    }
}