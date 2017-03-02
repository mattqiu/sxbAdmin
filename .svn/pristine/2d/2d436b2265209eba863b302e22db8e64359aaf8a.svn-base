<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/3/29
 * Time: 下午4:14
 */

/**
 * Class OpenOrderAction
 *  外部订单导入到发货系统
 */
class OpenOrderAction extends CommonAction{

    public function index(){
        $tmpJdOrderM = M('tmp_jd_order');
        $where = array();
        //暂时只显示宁波周吉的
        $where['open_order_id'] = 1;
        if(isset($_REQUEST['']) && !empty($_REQUEST[''])){
            $fromTime = I('from_date') . ' ' . I('from_time');
            $toTime = I('to_date') . ' ' . I('to_time');
            $where['add_time'] = array(array('egt', $fromTime), array('elt', $toTime));
        }
        $count = $tmpJdOrderM->where($where)->count();

//        echo $tmpJdOrderM->getLastSql();
        $Page = new Page($count, 100);
        $pageShow = $Page->show();
        $list = $tmpJdOrderM->where($where)->order("id desc")->limit($Page->firstRow, $Page->listRows)->select();

        $jdCanshippingArr = array();
        $jdCanshippingArr[1] = '未检查';
        $jdCanshippingArr[2] = '可以发';
        $jdCanshippingArr[3] = '不可发';
        $jdCanshippingArr[4] = '待确认';

        $orderStatusArr = array();
        $orderStatusArr[1] = '已取出';
        $orderStatusArr[2] = '已同步';
        $orderStatusArr[4] = '已发货';
        $orderStatusArr[10] = '地址问题';
        $orderStatusArr[15] = '异常';
        $orderStatusArr[20] = '已取消';

        foreach($list as $key => $item){
            $list[$key]['jd_can_shipping_name'] = $jdCanshippingArr[$item['jd_can_shipping']];
            $list[$key]['status_name'] = $orderStatusArr[$item['status']];
        }


        $this->assign('list', $list);
        $this->assign('page_str', $pageShow);
        $this->display();
    }

    public function importOrder(){
        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileFix = explode('.', $_FILES['import_file']['name']);
        $fileName = md5($_FILES['import_file']['name'] . time()) . '.' . $fileFix[1];
        $uploadFile = $savePath . $fileName;
        move_uploaded_file($_FILES['import_file']['tmp_name'], $uploadFile);
        $result = $this->importExecl($uploadFile);

        if(empty($result['data'])){
            echo '读取数据出错';
        }

        $partnerId = I('import_partner');
        $openPartnerM = M("open_partner");
        $tmpJdOrderM = M('tmp_jd_order');

        $partner = $openPartnerM->where(array('id' => $partnerId))->find();

        $orderNum = 0;
        foreach($result['data'] as $key => $order){
            if($key < 2 || empty($order['C']) || empty($order['A']) || empty($order['Q'])){
//                echo '<br/>检查未通过' . json_encode($order) . '<br/>';
                continue;
            }

            $orderName = trim($partner['open_code']) . trim($order['A']);
            $hasOrder = $tmpJdOrderM->where(array('order_name' => $orderName))->find();

            if(!empty($hasOrder)){
                continue;
            }

            $orderNum++;

            $data = array();
            $data['product_name'] = trim($order['C']);
            $data['order_name'] = $orderName;
            $data['rec_name'] = trim($order['R']);
            $data['rec_mobile'] = trim($order['Q']);
            $data['rec_address'] = trim($order['M']) . trim($order['N']) . trim($order['O']) . trim($order['P']);
            $data['num'] = 1;
            $data['weight'] = 1;
            $data['remark'] = trim($order['C']);
            $data['add_time'] = date('Y-m-d H:i:s', time());
            $data['send_warehome_id'] = 9;
            $data['send_warehome_en_name'] = 'shttgy02';
            $data['send_warehome_name'] = '果园上海仓2';
            $data['rec_key'] = md5($data['rec_name'] . $data['rec_mobile'] . $data['rec_address'] . $data['send_warehome_id']);
            $data['source_city'] = '上海浦东';
            $data['open_order_id'] = $partnerId;
            $data['open_order_code'] = $partner['open_code'];

            $id = $tmpJdOrderM->add($data);
            if($id > 0){
                echo '<br/>导入成功:' . $orderName . '<br/>';
            } else {
                echo '<br/>导入失败:' . $orderName . '<br/>';
            }
        }

        echo '共导入' . $orderNum . '单';
    }

    public function exportOrder(){
        $partnerId = I('export_partner', 0);
        $fromTime = I('export_from_date') . ' ' . I('export_from_time');
        $toTime = I('export_to_date') . ' ' . I('export_to_time');

        if($partnerId < 1 || empty($_REQUEST['export_from_date'])){
            echo '参数出错';
        }

        $tmpJdOrderM = M('tmp_jd_order');
        $where = array();
        $where['add_time'] = array(array('egt', $fromTime), array('elt', $toTime));
        $where['open_order_id'] = 1;
        $where['delivery_id'] = array('neq', '');
        $where['open_order_export_num'] = 0;

        $field = 'product_name, order_name, rec_name, rec_mobile, rec_address, shipping_name, delivery_id,open_order_code';
        $orderList = $tmpJdOrderM->field($field)->where($where)->select();
        $sql = $tmpJdOrderM->getLastSql();

        $orderNameArr = array();
        foreach($orderList as $key => $order){
            $orderNameArr[] = $order['order_name'];
            $orderList[$key]['order_name'] = substr($order['order_name'], strlen($order['open_order_code']));
            unset($orderList[$key]['open_order_code']);
        }

        $tmpJdOrderM->where(array('order_name'=>array('in', $orderNameArr)))->setInc('open_order_export_num');

        $excelTitle = array(array('product_name', '商品名称'), array('order_name', '商家订单号'), array('rec_name', '收货人'), array('rec_mobile', '收货人电话')
        , array('rec_address', '收货人地址'), array('shipping_name', '快递公司'), array('delivery_id', '快递单号'));

        exportExcel('订单发货导出表' . $fromTime . '-' . $toTime, $excelTitle, $orderList, '', true);
    }

    /**
     *  导出榴莲的订单时效
     */
    public function test(){
        $areaM = M('area');
        $areaList = $areaM->where(array('pid' => 0))->select();
        $areaArr = array();
        foreach($areaList as $area){
            $areaArr[$area['id']] = $area['name'];
        }

        $tmpJdOrderM = M('tmp_jd_order');
        $where = array();
        $productName = I("product_name");
        if(!empty($productName)){
            $where['product_name'] = array('like', '%' . $productName . '%');
        }

        $where['send_use_date'] = array('gt', 0);
        $where['product_id'] = array('in', array(4647, 4646, 4645, 4644, 4643));
        $field = 'product_name, order_name, rec_name, rec_mobile, rec_address, shipping_name, delivery_id, jd_rec_time,province_id,jd_arrive_time,send_use_date';
        $orderList = $tmpJdOrderM->field($field)->where($where)->select();
        foreach($orderList as $key => $order){
            $orderList[$key]['province_id'] = $areaArr[$order['province_id']];
        }

        $excelTitle = array(array('product_name', '商品名称'), array('order_name', '商家订单号'), array('rec_name', '收货人'), array('rec_mobile', '收货人电话')
        , array('rec_address', '收货人地址'), array('shipping_name', '快递公司'), array('delivery_id', '快递单号')
        , array('jd_rec_time', '取件时间'), array('jd_arrive_time', '送达时间'), array('send_use_date', '使用天数')
        , array('province_id', '省份'));

        exportExcel('榴莲订单发货时效表', $excelTitle, $orderList, '', true);
    }
}