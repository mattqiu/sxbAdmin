<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 15/11/12
 * Time: 下午6:54
 */
class SupplyApiAction extends Action{

    public $supplyM;
    public $supplyName;
    public $result = array('code'=> 200, 'msg'=>'', 'data' => array());
    function _initialize() {
        $this->supplyM = M('supply');

        //验证签名
        if($_REQUEST['_URL_'][1] != 'addUser' && !($this->checkSign($_POST))){
            $this->result['code'] = 300;
            $this->result['msg'] = '参数错误';
            unset($this->result['data']);
            $this->echoResult($this->result);
        }
    }

    public function orders(){
        //取订单信息
        $model = new OrderModel();
        $orderStatus = 0;
        if(isset($_POST['order_status_sel'])){
            $orderStatus = $_POST['order_status_sel'];
        }

        //2015/10/30 - 2015/10/31
        $whereArr = array();
        if(!empty($_POST['limit_date'])){
            $_POST['limit_date'] = trim(str_replace('+', ' ', $_POST['limit_date']));
            $limitDate = explode(' - ', $_POST['limit_date']);
            if(!empty($limitDate)){
                $whereArr['time'] = array(array('egt', trim($limitDate[0]) . ' 00:00:00'), array('elt', trim($limitDate[1]) . ' 23:59:59'));
            }
        }

        $send_channel = $this->supplyName;
        $whereArr[C('DB_PREFIX') . 'order_product.send_channel'] = array('eq', $send_channel);

        $deliveryId = I('delivery_id', '');
        if(!empty($deliveryId)){
            $whereArr[C('DB_PREFIX') . 'order.delivery_id'] = array('like', '%' . $deliveryId . '%');
        }

        $orderName = I('order_name', '');
        if(!empty($orderName)){
            $whereArr[C('DB_PREFIX') . 'order.order_name'] = array('like', '%' . $orderName . '%');
        }

        $productName = I('product_name', '');
        if(!empty($productName)){
            $whereArr[C('DB_PREFIX') . 'order_product.product_name'] = array('like', '%' . $productName . '%');
        }

        $recName = I('rec_name', '');
        if(!empty($recName)){
            $whereArr[C('DB_PREFIX') . 'order_address.name'] = array('like', '%' . $recName . '%');
        }

        $recPhone = I('rec_phone', '');
        if(!empty($recPhone)){
            $whereArr['_string'] = '(' . C('DB_PREFIX') . 'order_address.mobile LIKE "%' . $recPhone . '%" OR ' . C('DB_PREFIX') . 'order_address.telephone LIKE"%' . $recPhone . '%")';
        }

        $tradeNo = I('trade_no', '');
        if(!empty($tradeNo)){
            $whereArr[C('DB_PREFIX') . 'order_payment.out_bill_id'] = array('like', '%' . $tradeNo . '%');
        }

        $orderList = $model->getOrdersList($orderStatus, $whereArr);

        if(!empty($orderList['order_list'])){
            foreach($orderList['order_list'] as $key => $item){
                $orderItem = array();
                $orderItem['order_name'] = $item['order_name'];
                $orderItem['create_time'] = $item['time'];
                $orderItem['last_modify_time'] = $item['last_modify_time'];
                $orderItem['pay_status_name'] = $item['pay_status_name'];
                $orderItem['order_status_name'] = $item['order_status_name'];
                $orderItem['consignee_name'] = $item['name'];
                $orderItem['consignee_telephone'] = $item['telephone'];
                $orderItem['consignee_mobile'] = $item['mobile'];
                $orderItem['consignee_address'] = $item['address'];
                foreach($item['order_product'] as $product){
                    $orderProduct = array();
                    $orderProduct['product_name'] = $product['product_name'];
                    $orderProduct['product_no'] = $product['product_no'];
                    $orderProduct['specification'] = $product['gg_name'];
                    $orderProduct['num'] = $product['qty'];
                    $orderProduct['photo'] = $product['photo'];

                    $orderItem['order_product'][] = $orderProduct;
                }

                $this->result['data']['order_list'][] = $orderItem;
            }
        }

        $this->result['data']['page_data'] = $orderList['page_data'];

        $this->echoResult($this->result);
    }

    private function checkSign($params){
        $result = false;
        if(!(isset($params['key']) && !empty($params['key']))){
            return $result;
        }

        $reqSign = $params['sign'];
        unset($params['sign']);

        $row = $this->supplyM->where('api_key = "' . $params['key'] . '"')->find();

            $secret = $row['api_secret'];
        $this->supplyName = $row['name'];
            $sign = '';
            $argsStr = '';
            if(!empty($params)) {
                ksort($params);
                $sortArr = array();

                $sortArr = $params;
                foreach ($sortArr as $k => $v) {
                    $argsStr .= $k . $v;
                }

                $argsStr = $secret . $argsStr . $secret;
                $sign = strtoupper(md5($argsStr));
            }

        if($reqSign == $sign){
            $result = true;
        }

        return $result;
    }

    public function addUser(){
        $data = array();
        $data['name'] = 'shipinmmm';
        $data['real_name'] = '时品';
        $data['address'] = '上海普陀';
        $data['mobile'] = '18988888888';
        $data['api_key'] = $this->getApiKey($data['name']);
        $data['api_secret'] = $this->getApiSecret($data['api_key']);
        $data['status'] = 1;

        $supplyM = M('supply');
        $isHave = $supplyM->where('name = "' . $data['name'] . '"')->find();
        if(!empty($isHave)){
            echo '用户名已存在';
        } else {
            $supplyM->add($data);
            echo '添加用户成功';
        }
    }

    private function getApiKey($str){

        return strtoupper(md5($str));

    }

    private function getApiSecret($str){
        return strtoupper(md5(substr(md5($str . rand(1000, 9999)), rand(0, 10), 10)));
    }

    /**
     *  让中文json后还是显示中文
     * @param $result
     */
    private function echoResult($result){
//        foreach($result as $key => $item){
//            if(is_array($item)){
//                foreach($item as $k=>$v){
//                    if(is_array($v)){
//                        foreach($v as $k2 => $v2){
//                            $v[$k2] = urlencode($v2);
//                        }
//                        $item[$k] = $v;
//                    } else {
//                        $item[$k] = urlencode($v);
//                    }
//                }
//                $result[$key] = $item;
//            } else {
//                $result[$key] = urlencode($item);
//            }
//        }

//        echo urldecode(json_encode($result));

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

}