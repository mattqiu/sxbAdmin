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


/**
 *  订单退款管理
 * Class OrderRefundAction
 */
class OrderRefundAction extends CommonAction {
    const PAGE_NUM = 20;
    public function index() {


    }

    /**
     *  支付宝退款
     */
    public function alipayRefund() {
        $batch_no = I('batch_no');
        $order_name = I('order_name');
        if($batch_no){
            $where['batch_no'] = array('eq',$batch_no);
        }
        if($order_name){
            $where['order_name'] = array('eq',$order_name);
        }
        $m = M('alipay_refund');
        $data = $m->where($where)->select();
        $page = new Page(count($data),self::PAGE_NUM);
        $list = $m->where($where)->order("add_time desc")->limit($page->firstRow,$page->listRows)->select();
        $show = $page->show();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->assign('post',$_POST);
        $this->display();
    }

    /**
     *  去支付宝进行退款
     */
    public function alipayDoRefund() {
        header("Content-type:text/html;charset=utf-8");

        $alipayRefundM = M('alipay_refund');
        $orderRefundM = M('order_refund');

        //支付宝实际退款页面要在后台里重新做
        Vendor("alipay/lib/alipay_notify", '', '.class.php');
        Vendor("alipay/lib/alipay_submit", '', '.class.php');

        //支付宝 退款
        $alipayUrl = 'https://mapi.alipay.com/gateway.do?';
        $alipay_config = C('ALIPAY_CONF');

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);

        $alipayParams = array();
        $alipayParams['service'] = 'refund_fastpay_by_platform_pwd';
        $alipayParams['partner'] = $alipay_config['partner'];
        $alipayParams['_input_charset'] = $alipay_config['input_charset'];
        $alipayParams['notify_url'] = 'http://v1manage.shipinmmm.com/Task/alipayRefundNotify';
        $alipayParams['seller_email'] = $alipay_config['seller_id'];
        $alipayParams['seller_user_id'] = $alipay_config['partner'];
        $alipayParams['refund_date'] = date('Y-m-d H:i:s', time());
        //每进行一次即时到账批量 退款,都需要提供一个批次 号,通过该批次号可以查询 这一批次的退款交易记录,
        // 对于每一个合作伙伴,传递 的每一个批次号都必须保 证唯一性。
        //格式为:退款日期(8 位) +流水号(3~24 位)。
        //不可重复,且退款日期必须 是当天日期。流水号可以接 受数字或英文字符,建议使 用数字,但不可接受 “000”。
        $batchId = intval(F('alipay_refund_batch_id'));
        if(!($batchId > 0)){
            $batchId = 1;
        } else {
            $batchId++;
        }
        F('alipay_refund_batch_id', $batchId);
        $alipayParams['batch_no'] = date('Ymd') . sprintf('%05s', $batchId);

        $refundList = $orderRefundM->where('pay_parent_id = 1 AND status = 1 AND money > 0 AND out_bill_id <>"" ')->limit(0, 200)->order('add_time ASC')->select();

//        Log::write('支付宝退款列表===' . json_encode($refundList) . '===sql===' . $orderRefundM->getLastSql());
        if(!empty($refundList)){
            $alipayRefundData = array();
            //总笔数即参数 detail_data 的值 中,“#”字符出现的数量 加 1,最大支持 1000 笔
            //(即 “#”字符出现的最大数量 为 999 个)
            $alipayParams['batch_num'] = count($refundList);
            //交易退款数据集的格式为:原付款支付宝交易号^退款总金额^退款理由;
            $alipayParams['detail_data'] = '';
            foreach($refundList AS $item){
                $alipayParams['detail_data'] .= $item['out_bill_id'] . '^' . $item['money'] . '^' . '未成团退款#';
                $alipayRefundData[] = array(
                    'batch_no' => $alipayParams['batch_no'],
                    'old_out_bill_no' => $item['out_bill_id'],
                    'order_name' => $item['order_name'],
                    'add_time' => time(),
                    'payment_id' => $item['payment_id'],
                );
            }

            if(!empty($alipayRefundData)){
                $alipayRefundM->addAll($alipayRefundData);
            }
//            $alipayParams['detail_data'] = '2015092200001000810064534570^0.1^未成团退款#2015092200001000810064543655^0.1^未成团退款';
            $alipayParams['detail_data'] = trim($alipayParams['detail_data'], '#');

            $reqParams = $alipaySubmit->buildRequestPara($alipayParams);
            $reqParams['sign_type'] = $alipay_config['sign_type'];

            $url = $alipayUrl . $alipaySubmit->buildRequestParaToString($reqParams);
            redirect($url);
        } else {
            echo '暂时没有需要支付宝退款的订单';
        }
    }
} 