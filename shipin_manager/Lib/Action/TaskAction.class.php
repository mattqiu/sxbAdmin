<?php

/**
 * 定时任务
 * User: chrisying
 * Date: 15/9/21
 * Time: 下午12:00
 */
class TaskAction extends Action {


    public $redis;
    public function _initialize() {
        header("Content-type: text/html; charset=utf-8");
        import('@.ORG.RedisObj');
        $this->redis = new RedisObj();
        $passKey = I('pass_key', md5('abc12376446'));
        $autoTaskKey = C('AUTO_TASK_KEY');
        if($autoTaskKey != $passKey) {
            return;
        }
    }

    /**
     *  拼团未成团的订单自动退款给用户
     */
    public function groupbuy_autorefund() {
        //取未成团的订单
        $groupbuyingM = M('groupbuying');
        $groupbuyingOrderM = M('groupbuying_order');
        $orderRefundM = M('order_refund');
        $orderPaymentM = M('order_payment');
        $taskM = new TaskModel();

        $time = time();

        $where = ' groupbuying_endtime < ' . $time . ' AND state = 1';
//        $where = 'state = 1';
        $count = $groupbuyingM->where($where)->count();
        $pageNum = 100;
        $offset = 0;
        $page = 1;
        $list = $groupbuyingM->where($where)->limit($offset, $pageNum)->order('id DESC')->select();

        echo 'totao===' . $count . '<br/>';
        echo $groupbuyingM->getLastSql() . '<br/>';


        while (!empty($list)) {
            $groupbuyingM->startTrans();
            foreach ($list as $item) {
                echo $item['id'] . '<br/>';
                if($item['groupbuying_nownums'] < $item['groupbuying_reqnums']) {
                    //未达到成团人数，则退款
                    $orderList = $groupbuyingOrderM->where('groupbuying_id = ' . $item['id']
                        . ' AND state = 1')->select();
                    if(empty($orderList)) {
                        continue;
                    }

                    foreach ($orderList as $groupbuyOrder) {
                        if($groupbuyOrder['pay_money'] > 0){
                            $taskM->doGroupOrderRefund($groupbuyOrder);
                        } else {
                            $taskM->doZeroOrderRefund($groupbuyOrder);
                        }

                    }
                }
            }

            $page++;
            $offset = ($page - 1) * $pageNum;
            $list=array();
//            $list = $groupbuyingM->where($where)->limit($offset, $pageNum)->select();

            $groupbuyingM->commit();
        }
    }

    /**
     *  对指定的定单进行退款
     *  如,参加付款抽奖的团的订单
     *  2016-3-17
     */
    public function groupbuyorderautorefund(){
        $orderM = M('order');
        $orderWhere = array();
        $orderWhere['pay_status'] = 1;
        $orderWhere['operation_id'] = 12;
        $orderList = $orderM->where($orderWhere)->limit(500)->select();

        if(empty($orderList)){
            return;
        }

        echo $orderM->getLastSql();

        $taskM = new TaskModel();
        $groupbuyingOrderM = M('groupbuying_order');

        foreach($orderList as $order){
            $orderM->startTrans();
            $groupOrder = $groupbuyingOrderM->where(array('order_name' => $order['order_name']))->find();
            deBugLog($groupOrder, __FILE__);
            if($groupOrder['pay_money'] > 0){
                $singleRefund = 1;
                $taskM->doGroupOrderRefund($groupOrder, $singleRefund);
            } else {
                $taskM->doZeroOrderRefund($groupOrder);
            }
            $orderM->commit();
        }
    }

    public function testAlipayRefund(){
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
        $alipayParams['batch_no'] = date('Ymd') . sprintf('%05s', 1);
        //总笔数即参数 detail_data 的值 中,“#”字符出现的数量 加 1,最大支持 1000 笔
        //(即 “#”字符出现的最大数量 为 999 个)
        $alipayParams['batch_num'] = '2';
        //交易退款数据集的格式为:原付款支付宝交易号^退款总金额^退款理由;
        $alipayParams['detail_data'] = '2015092200001000810064534570^0.1^未成团退款#2015092200001000810064543655^0.1^未成团退款';

        $reqParams = $alipaySubmit->buildRequestPara($alipayParams);
        $reqParams['sign_type'] = $alipay_config['sign_type'];

        $url = $alipayUrl . $alipaySubmit->buildRequestParaToString($reqParams);
    }

    public function alipayRefundNotify(){
//http://商户自定义地址 /alipay/notify_url.php?notify_time=2009-08-12+11%3A08%3A32&notify_type=b atch_refund_notify&notify_id=70fec0c2730b27528665af4517c27b95&sign_type =MD5&sign=_p_w_l_h_j0b_gd_aejia7n_ko4_m%252Fu_w_jd3_nx_s_k_mxus9 _hoxg_y_r_lunli_pmma29_t_q%3D%3D&batch_no=20060702001&success_nu m=2&result_details=2010031906272929%5E80%5ESUCCESS
        $alipayRefundM = M('alipay_refund');
        $orderRefundM = M('order_refund');
        $groupbuyingOrderM = M('groupbuying_order');
        $taskM = new TaskModel();

        Vendor("alipay/lib/alipay_notify", '', '.class.php');
        $alipay_config = C('ALIPAY_CONF');
        $alipayNotify = new AlipayNotify($alipay_config);
        $post = $_POST;
//        $post = json_decode('{"result_details":"2015092200001000810064534570^0.10^SUCCESS#2015092200001000810064543655^0.10^SUCCESS","notify_time":"2015-10-11 01:04:27","notify_type":"batch_refund_notify","notify_id":"4d3c7bdb1a08eb104f3c7022d6e8a0alpk","batch_no":"2015101000001","success_num":"2"}";}');


//        $post = json_decode('{"sign":"f0012ca7e2444610186ffc5b9bca49a3","result_details":"2015092300001000240061197086^0.10^TRADE_HAS_CLOSED#2015092300001000240061198187^0.10^TRADE_HAS_CLOSED","notify_time":"2015-11-17 16:26:41","sign_type":"MD5","notify_type":"batch_refund_notify","notify_id":"16479c452a900eb399d8a94b1c26ac8img","batch_no":"20151117002","success_num":"0"}', true);

        $sign = $post['sign'];
        $signType = $post['sign_type'];

        Log::write('===alipay refund notify ===post= ' . json_encode($_POST));

        if($alipayNotify->getSignVeryfy($post, $sign, true)){
            //确认是支付宝发来的消息，并且签名验证通过
            $batch_no = $post['batch_no'];
            $success_num = $post['success_num'];
            $result_details = $post['result_details'];
//            不退手续费结果返回格式: 交易号^退款金额^处理结果。
//若退款申请提交成功,处理结果 会返回“SUCCESS”。

//            ﻿[2015-10-11 01:04:27 ]        a:1:{s:4:"post";s:299:"======alipayrefundnotify====={"result_details":"2015092200001000810064534570^0.10^SUCCESS#2015092200001000810064543655^0.10^SUCCESS","notify_time":"2015-10-11 01:04:27","notify_type":"batch_refund_notify","notify_id":"4d3c7bdb1a08eb104f3c7022d6e8a0alpk","batch_no":"2015101000001","success_num":"2"}";}
            if(!empty($result_details)){
                $resultList = explode('#', $result_details);
                if(count($resultList) > 1){
                    foreach($resultList as $item){
                        $itemArr = explode('^', $item);
                        $aliWhere = 'batch_no = "' . $batch_no . '" AND old_out_bill_no = "' . $itemArr[0] . '"';
                        $aliItem  = $alipayRefundM->where($aliWhere)->find();
                        $alipayRefundM->where($aliWhere)->save(array('status' => $itemArr[2]));
                        deBugLog(array('itemArr' => '====alipay refund==itemArr=====' . json_encode($itemArr)), __FILE__);
                        deBugLog(array('itemArr' => '====alipay refund==itemArr=====' . json_encode($itemArr)), __FILE__);
                        if($itemArr[2] == 'SUCCESS'){
                            $orderRefundData = $orderRefundM->where('payment_id = "' . $aliItem['payment_id'] . '"')->find();
                            $groupbuyOrder = $groupbuyingOrderM->where('order_name = "' . $aliItem['order_name'] . '"')->find();
                            $taskM->upOrderRefund(true, $aliItem['payment_id'], $orderRefundData, $groupbuyOrder, $itemArr[1]);
                        } else {
                            $taskM->failOrderRefund($aliItem['payment_id']);
                        }

                    }
                } else {
                    if(!empty($resultList)){
                        $itemArr = explode('^', $resultList[0]);
                        $aliWhere = 'batch_no = "' . $batch_no . '" AND old_out_bill_no = "' . $itemArr[0] . '"';
                        $aliItem  = $alipayRefundM->where($aliWhere)->find();
                        $alipayRefundM->where($aliWhere)->save(array('status' => $itemArr[2]));
                        deBugLog(array('itemArr' => '====alipay refund==itemArr=====' . json_encode($itemArr)), __FILE__);
                        if($itemArr[2] == 'SUCCESS'){
                            $orderRefundData = $orderRefundM->where('payment_id = "' . $aliItem['payment_id'] . '"')->find();
                            $groupbuyOrder = $groupbuyingOrderM->where('order_name = "' . $aliItem['order_name'] . '"')->find();
                            $taskM->upOrderRefund(true, $aliItem['payment_id'], $orderRefundData, $groupbuyOrder, $itemArr[1]);
                        } else {
                            $taskM->failOrderRefund($aliItem['payment_id']);
                        }
                    }
                }
            }

            echo 'success';
        }

        deBugLog(array('post' => '======alipayrefundnotify=====' . json_encode($post)), __FILE__);
    }

    /**
     *  测试微信支付退款接口
     */
    public function testwxrefund() {
        //如果的微信支付则调用微信支付退款接口
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
//        $url = 'https://api.sp.com/api';

        $wxParams = array();
        $wxParams['appid'] = C('WX_APP_ID');
        $wxParams['mch_id'] = C('WX_PAY_MCHID');
        $wxParams['nonce_str'] = C('WX_JSSDK_NONCESTR');

        $wxParams['out_trade_no'] = '1512031549522755';
//        $wxParams['out_refund_no'] = time();
        $wxParams['out_refund_no'] = 1449114348;
        $wxParams['total_fee'] = 12.50 * 100;
        $wxParams['refund_fee'] = 12.50 * 100;
        $wxParams['op_user_id'] = C('WX_PAY_MCHID');
        $wxParams['sign'] = $this->makeWxSign($wxParams);
        $wxParams['ssl_cert'] = BASE_PATH . '/shipin_manager/Conf/weixinpay/cert/apiclient_cert.pem';
        $wxParams['ssl_key'] = BASE_PATH . '/shipin_manager/Conf/weixinpay/cert/apiclient_key.pem';

        $isShipin = true;
        if($isShipin){
            $wxParams = array();
            $wxParams['appid'] = 'wx50d24bb15d0567a0';
            $wxParams['mch_id'] = '1261897201';
            $wxParams['nonce_str'] = 'spai689898djjduejdud';
            $wxParams['out_trade_no'] = '151130317243';
            //        $wxParams['out_refund_no'] = time();
            $wxParams['out_refund_no'] = 1449114349;
            $wxParams['total_fee'] = 1 * 100;
            $wxParams['refund_fee'] = 1 * 100;
            $wxParams['op_user_id'] = '1261897201';

            $wxParams['sign'] = $this->makeWxSign($wxParams);

            $wxParams['ssl_cert'] = BASE_PATH . '/shipin_manager/Conf/weixinpay/cert/shipin/apiclient_cert.pem';
            $wxParams['ssl_key'] = BASE_PATH . '/shipin_manager/Conf/weixinpay/cert/shipin/apiclient_key.pem';
        }


        var_dump($wxParams);
        echo '<br/>';
        $result = getCurlRequestXML($url, $wxParams);
        echo $result .'<br/>';
        $resultArr = fromXml($result);
        var_dump($resultArr);
    }

    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function makeWxSign($data) {
        if(isset($data['sign'])){
            unset($data['sign']);
        }
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string = $this->toUrlParams($data);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=6a50ea01b41e4239a991f6419d19c0b3";
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);

        return $result;
    }

    /**
     * 格式化参数格式化成url参数
     */
    public function toUrlParams($data) {
        $buff = "";
        foreach ($data as $k => $v) {
            if($v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");

        return $buff;
    }

    /**
     *  如果支付方式是在线支付且超过30分钟未付款的订单自动取消
     * TODO 如果量大的话要放在队列中处理, 目前没有积分，赠品，部分付款之类的，不需要做退回处理，后期
     *  如果有的话要做退回处理， 并记录订单处理日志
     * @author chrisying 2015-10-10
     */
    public function overTimeCancelOrder(){
        $orderM = M('order');
        $overTime = date('Y-m-d H:i:s', time() - 7200);
        $where = 'pay_parent_id <> 4 AND pay_status = 0 AND time < "' . $overTime . '"';
        $orderM->where($where)->save(array('operation_id' => 5, 'order_status' => 3));
        echo $orderM->getLastSql();
    }

    public function collectLocalAvatar(){
        $path = '/Volumes/Macintosh HD/Users/chrisying/360云盘/360网络同步盘/work_doc_15/时品网/avatar_wx/';

        $fileArr = getDirAllFileName($path);

        if(empty($fileArr)){
            return;
        }

        $collectAvatarM = M('collect_avatar');
        foreach($fileArr as $fileName){
            $fileNameArr = explode('.', $fileName);
            if(in_array(strtolower($fileNameArr[1]), array('jpg', 'jpeg', 'png'))){

                $upyunPath = '/upload/avatar_2/2016/';
                $avatarPath = $upyunPath . $fileName;
                $avatarHead = array(
                    'big' => $avatarPath . '!middleavatar',
                    'middle' => $avatarPath . '!thumavatar',
                    'small' => $avatarPath . '!thumminavatar'
                );
                $collectAvatarM->add(array(
                    'avatar_img' => serialize($avatarHead),
                    'source_site' => 'local_wx',
                    'add_time' => time(),
                ));
            }
        }


        var_dump($fileArr);
    }


    public function collectAvatar(){
        Vendor('simple_html_dom');
        $collectAvatarM = M('collect_avatar');
        $p = I('p', 2);
        $inUrl = I('url', 'http://www.qqtn.com/tx/meinvtx_' . $p . '.html');
        $site = 'http://www.qqtn.com/';

        $html = file_get_html($inUrl);

        // Find all images
        foreach($html->find('ul.m_txul img') as $element){
            echo $element->src . '<br>';
            $hasHttp = strpos($element->src,'ttp://');
            if(!$hasHttp){
                $element->src = $site . $element->src;
            }
            $img=file_get_contents($element->src);
            $imgFix = explode('.', $element->src);
            $savename = md5($img . time()).'.' . $imgFix[count($imgFix) - 1];
            $dateArr = explode('-', date('Y-m-d', time()));
            $upyunPath = '/upload/avatar_2/';

            $avatarPath = $upyunPath . $savename;
            $avatarHead = array(
                'big' => $avatarPath . '!middleavatar',
                'middle' => $avatarPath . '!thumavatar',
                'small' => $avatarPath . '!thumminavatar'
            );
            $collectAvatarM->add(array(
                'avatar_img' => serialize($avatarHead),
                'source_site' => $inUrl,
                'add_time' => time(),
            ));
            $savePath = $_SERVER['DOCUMENT_ROOT'] . $upyunPath;
            $ret=@file_put_contents($savePath . $savename,$img);
        }

        $p++;
        if($p < 10){
            redirect('/Task/collectAvatar/p/' . $p);
        }
    }

    /**
     *  定时下载微信头像
     */
    public function downWeixinAvatar(){
        $descId = I('desc_id', 0);
        $orderBy = 'id ASC';
        if($descId > 0){
            $orderBy = 'id DESC';
        }
        $startTime = time();
        $userWxM = M('user_wx');
        $userM = M('user');
        $needDownList = $userWxM->where('is_down_avatar = 0')->order($orderBy)->limit(0, 20)->select();
        if(empty($needDownList)){
           return;
        }

        Vendor('upyun');

        foreach($needDownList as $item){
            $img=file_get_contents($item['headimgurl']);
            $upyun = new UpYun('shipinmmm-img', 'spchris', 'sp&98chris123');

            $savename = md5($img . time()).'.jpeg'; //localResizeIMG压缩后的图片都是jpeg格式
            $dateArr = explode('-', date('Y-m-d', time()));
            $upyunPath = '/upload/avatar/' . $dateArr[0] . '/' . $dateArr[1] . '/' . $dateArr[2] . '/';

            $savePath = $_SERVER['DOCUMENT_ROOT'] . $upyunPath;
            createDir($savePath);
            $ret=@file_put_contents($savePath . $savename,$img);

            $fh = fopen($savePath . $savename, 'rb');
            $rsp = $upyun->writeFile($upyunPath . $savename, $fh, True);   // 上传图片，自动创建目录
            fclose($fh);

            $avatarFullPath = $upyunPath . $savename;

            $user_head = serialize(array(
                'big'=> $avatarFullPath . '!middleavatar',
                'middle'=> $avatarFullPath . '!thumavatar',
                'small'=> $avatarFullPath . '!thumminavatar',
            ));

            $userM->where('id = ' . $item['uid'])->save(array('user_head' => $user_head));
            $userWxM->where('id = ' . $item['id'])->save(array('is_down_avatar' => 1));
            echo $userWxM->getLastSql() . '<br/>';
        }
        echo '使用时间' . (time()-$startTime) . '秒';
    }

    public function testMem(){
        $wxToken = getMem('wx_api_access_token');
        $userWxM = M('user_wx');
        $userWxItem = $userWxM->where('uid = 332885')->find();

        if(!empty($wxToken) && !empty($userWxItem)){
            $wxUrl = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $wxToken;
            $wxData = array(
                'touser' => $userWxItem['openid'],
                'msgtype' => 'text',
                'text' => array(
                    'content' => urlencode('您的订单：'.'2015test111'.' 已发货。由[京东]快递进行配送，快递单号为：textjd001')
                ),
            );

            $wxDataJson = urldecode(json_encode($wxData));
            $wxResult = getCurlRequest($wxUrl, $wxDataJson);
        }
    }

    /**
     *  给用户事件(关注，取消关注，自动回复等)发送微信通知
     *  只要openid 就可以
     *  chrisying 16-3-22
     *  type  event_msg
     */
    public function sendEventWxMsg(){
        $startTime = time();

        while((time() - $startTime) < 59){
            $wxMsgListM = M('wx_msg_list');

            $msgWhere = array('status'=>1);
            $msgWhere['openid'] = array('neq', '');
            $msgWhere['content'] = array('neq', '');
            $msgWhere['scene_type'] = array('eq', 'event_msg');

            $msgList = $wxMsgListM->where($msgWhere)->order('id asc')->limit(0, 10)->select();
            if(empty($msgList)){
                return;
            }
            $this->upWxMsgList($wxMsgListM, $msgWhere, $msgList);
            foreach($msgList as $item){
                $wxResult =  sendWxMsg($item['openid'], $item['content']);

                $where = array('id' => $item['id']);
                if($wxResult['errmsg'] == 'ok'){
                    //                    $wxMsgListM->where($where)->delete();
                } else {
                    $saveData = array();
                    $saveData['result'] = $wxResult['errmsg'];
                    $saveData['status'] = 2;
                    $wxMsgListM->where($where)->save($saveData);
                }
            }

            sleep(1);
        }
    }

    /**
     *  给微信号发通知消息
     */
    public function sendWxMsg(){
        $wxMsgListM = M('wx_msg_list');
        $groupbuyingM = M('groupbuying');
        $userWxM = new UserWxModel();
//        $wxMsgListM->startTrans();
        $msgWhere = array('status'=>1);
        $msgWhere['uid'] = array('gt', 0);
        $msgWhere['content'] = array('neq', '');
        //排除集中抽奖团
        $msgWhere['groupbuy_type'] = array(array('neq', 2), array('neq', 3));
        $msgWhere['scene_type'] = array('neq', 'coupon_get');

        $msgList = $wxMsgListM->where($msgWhere)->order('id asc')->limit(0, 300)->select();
        echo $wxMsgListM->getLastSql();
        if(empty($msgList)){
        }
        else
        {
            //先把待发送的消息更新成待发送状态避免后面的进程重复发送
            $this->upWxMsgList($wxMsgListM, $msgWhere, $msgList);
            foreach($msgList as $item){
                $uid = $item['uid'];
                $msg = $item['content'];

                if(empty($uid) || empty($msg)){
                    continue;
                }

                $userWxItem = $userWxM->getUserItem($uid);
                if(empty($userWxItem)){
                    continue;
                }

                //暂时取消luckdraw_msg
                if(!empty($item['scene_type']) && in_array($item['scene_type'], array('groupbuy_succ', 'coupon_get'))){
                    $params = array();
                    //消息场景, groupbuy_succ  成团消息, send_goods 发货消息,
                    //pay_succ 支付成功消息，coupon_get 发优惠券通知',
                    switch($item['scene_type']){
                        case 'groupbuy_succ':
                            //加入实例redis缓存,以免一个团中发送多个用户信息，每次都要查数据库
                            $groupItemKey = 'send_wx_msg_groupbuying_item' . $item['groupbuyinst'];
                            $groupItem = S($groupItemKey);
                            if(empty($groupItem)){
                                $groupItem = $groupbuyingM->field('id,sponsor_id,product_id,groupbuying_name')->where(array('id'=>$item['groupbuyinst']))->find();
                                S($groupItemKey, $groupItem, 864000);
                            }
                            $sponsorUserWxItem = $userWxM->getUserItem($groupItem['sponsor_id']);
                            $params['url'] = C('FRONT_SITE_URL') . '/groupbuy/joinGroupBuy/' . $item['groupbuyinst'];
                            $params['product_name'] = $groupItem['groupbuying_name'];  //商品名
                            $params['nickname'] = $sponsorUserWxItem['nickname'];   //团长昵称
                            break;

                        //                            case 'send_goods':
                        //
                        //                                break;
                        //
                        //                            case 'pay_succ':
                        //
                        //                                break;

                        case 'coupon_get':
                            $params['url'] = C('FRONT_SITE_URL') . '/user/coupon';
                            $params['content'] = $msg;  //商品名
                            break;

                        case 'luckdraw_msg':
                            $params['url'] = C('FRONT_SITE_URL') . '/groupbuy/joinGroupBuy/' . $item['groupbuyinst'];
                            $params['content'] = $msg;  //商品名
                            break;

                    }
                    $wxResult = sendWxTmplMsg($userWxItem['openid'], $item['scene_type'], $params);
                } else {
                    $wxResult =  sendWxMsg($userWxItem['openid'], $msg);
                }

                $where = array('id' => $item['id']);
                if($wxResult['errmsg'] == 'ok'){
//                    $wxMsgListM->where($where)->delete();
                } else {
                    $saveData = array();
                    $saveData['result'] = $wxResult['errmsg'];
                    $saveData['status'] = 2;
                    $wxMsgListM->where($where)->save($saveData);
                }
            }
        }

        //优惠券处理
        $msgWhere = array('status'=>1);
        $msgWhere['uid'] = array('gt', 0);
        $msgWhere['content'] = array('neq', '');
        $msgWhere['scene_type'] = array('eq', 'coupon_get');

        $msgList = $wxMsgListM->where($msgWhere)->order('id asc')->limit(0, 200)->select();
        if(empty($msgList)){
        }
        else
        {
            //先把待发送的消息更新成待发送状态避免后面的进程重复发送
            $this->upWxMsgList($wxMsgListM, $msgWhere, $msgList);

            //需要合并的消息，在合并后发送
            $coupon_merge_array=array();

            foreach($msgList as $item) {
                $uid = $item['uid'];
                $msg = $item['content'];

                if (empty($uid) || empty($msg)) {
                    continue;
                }

                if(empty($coupon_merge_array[$uid])) {
                    $coupon_merge_array[$uid] = array();
                    $coupon_merge_array[$uid]['msg'] = $msg;
                    $coupon_merge_array[$uid]['id'] = array();
                    $coupon_merge_array[$uid]['id'][] = $item['id'];
                }
                else{
                    $coupon_merge_array[$uid]['msg'] = $coupon_merge_array[$uid]['msg'].','.$msg;
                    $coupon_merge_array[$uid]['id'][] = $item['id'];
                }
            }

            deBugLog($coupon_merge_array, 'send_coupon_msg_user_arr');
            foreach($coupon_merge_array as $uid=>$cma_value)
            {
                $userWxItem = $userWxM->getUserItem($uid);
                if(empty($userWxItem)){
                    continue;
                }

                $params = array();
                $params['url'] = C('FRONT_SITE_URL') . '/user/coupon';
                $params['content'] = $cma_value['msg'];  //商品名
                $wxResult = sendWxTmplMsg($userWxItem['openid'], 'coupon_get', $params);
                //$wxResult =  sendWxMsg($userWxItem['openid'], $msg);


                $where['id'] = array('in', $coupon_merge_array[$uid]['id']);
                if($wxResult['errmsg'] == 'ok'){
//                    $wxMsgListM->where($where)->delete();
                } else {
                    $saveData = array();
                    $saveData['result'] = $wxResult['errmsg'];
                    $saveData['status'] = 2;
                    $wxMsgListM->where($where)->save($saveData);
                }

            }
        }

//        $wxMsgListM->commit();
    }

    /**
     *  根据京东收件记录及订单状态自动发货
     */
    public function autoSendGoods(){
        //晚上21点到第2天9点之间不发送发货信息
        $time = date('H:i:s', time());
        $timeArr = explode(':', $time);
        if($timeArr[0] > 21 || $timeArr[0] < 9){
            exit;
        }

        $tmpJdOrderM = new TmpJdOrderModel();
        $where = array();
        $where['status'] = 2;
        $where['print_num'] = array('gt', 0);
        //14天之内
        $where['add_time'] = array('gt', date('Y-m-d H:i:s', (time() - 86400 * 14)));
        $where['is_export_to_warehome'] = 2;
        $where['shipping_status'] = array('neq', '');

        //测试订单用的
//        $where['order_name'] = array('in', array('1601132043244220', '1601132014375612'));

        $orderList = $tmpJdOrderM->where($where)->limit(0, 50)->select();
        if(empty($orderList)){
            echo '没有需要发货的订单';
            exit;
        }

        $model = M('tmp_jd_send');
        $orderM = M('order');
        $data = array();
        foreach($orderList as $key => $item){
            $tmpResult = $tmpJdOrderM->sendGoods($item['order_name']);
            $where = array();
            $where['order_name'] = array('eq', $item['order_name']);
            $data['delivery_id'] = $item['delivery_id'];
            $data['shipping_name'] = $item['shipping_name'];
            $data['shipping_id'] = $item['shipping_id'];
            $orderResult = $orderM->where($where)->save($data);

            set_time_limit(0);
            $orderNames = $item['order_name'];
            if(!empty($orderNames)){
                $orderM = M('order');
                $groupbuyOrderM = M('groupbuying_order');

                $resrow = $orderM->where('order_name IN (' . $orderNames . ') && operation_id = 10')->save(array('operation_id' => 2));
                $groupbuyOrderM->where('order_name IN (' . $orderNames . ')')->save(array('state' => 5));

                if($resrow !=0)
                {
                    $content = '您的订单：'.$orderNames.' 已发货。由['.$item['shipping_name'].']快递进行配送，快递单号为：'.$item['delivery_id'].'，回复TD退订';//内容

                    $send_res = sendMobileMsg($item['rec_mobile'],$content);
                    //短信发送日志
                    $strNow = date("Y-m-d H:i:s");
                    $insertLog_data = array(
                        'mobile'=>$item['rec_mobile'],
                        'content'=>$content,
                        'send_result'=>$send_res,
                        'add_time'=>$strNow,
                        'type'=>1,
                    );

                    $mobile_msg_logM = M('mobile_msg_log');
                    $mobile_msg_logM->add($insertLog_data);

                    $userWxM = new UserWxModel();
                    $userWxItem = $userWxM->getUserItem($item['uid']);

                    if(!empty($userWxItem)){
                        sendWxMsg($userWxItem['openid'], '您在叔小白 m.shuxiaobai.com 的订单：'.$orderNames.' 已发货。由[' . $item['shipping_name'].  ']快递进行配送，快递单号为：'.$item['delivery_id']);
                    }
                }
            }

            if($tmpResult && $orderResult){
                $model->where($where)->delete();
            }
        }
    }

    private function upWxMsgList($wxMsgListM, $msgWhere, $msgList){
        $msgIdArr = array();
        foreach($msgList as $item){
            $msgIdArr[] = $item['id'];
        }

        $upWhere = $msgWhere;
        $upWhere['id'] = array('in', $msgIdArr);
        $wxMsgListM->where($upWhere)->save(array('status' => 3));
    }

    /**
     *  抓取已经导入京东且没有打印数据的快递单打印数据
     */
    public function crawlJdPrintData(){
        Vendor('fpdf/fpdf');
        Vendor('fpdi/fpdi');
        $tmpJdOrderM = M('tmp_jd_order');
        $deliveryIdM = D('JdDeliveryId');
        $where = array();
        $where['status'] = array('eq', 1);
        $where['delivery_id'] = array('neq', '');
//        $where['print_num'] = array('eq', 0);
        $where['print_data'] = array('eq', '');
        $orderList = $tmpJdOrderM->field('*')->where($where)->group('rec_key')
            ->limit(0, 100)->select();
        foreach($orderList as $order){
            $result = $deliveryIdM->getOrderPrint($order['delivery_id']);

            if(!(isset($result['jingdong_etms_order_print_responce']['response']['pdfArr'])
                && !empty($result['jingdong_etms_order_print_responce']['response']['pdfArr']))){
                deBugLog($order, 'getOrderPrint_error');
                continue;
            }

            if($order['package_num'] > 1){
                $tmpJdOrderM->startTrans();
                $printData = base64_decode($result['jingdong_etms_order_print_responce']['response']['pdfArr']);
                $fileName= $order['delivery_id'] . '.pdf';
                file_put_contents($fileName, $printData);
                // initiate FPDI

                $mergeWhere = array();
                $mergeWhere['rec_key'] = array('eq', $order['rec_key']);
                $mergeOrderList = $tmpJdOrderM->where($mergeWhere)->select();
                $i=0;
                foreach($mergeOrderList as $key => $mergeItem){
                    $i=$key+1;
                    $pdf = new FPDI();
                    // add a page
                    $pdf->AddPage();
                    // set the source file
                    $pdf->setSourceFile($fileName);
                    // import page 1
                    $tplIdx = $pdf->importPage($i);
                    $pdf->useTemplate($tplIdx);

                    $outFileName = $i . '_' . $fileName;
                    $pdf->Output($outFileName, 'F');
                    $mergePrintData = $pdf->Output($outFileName, 'S');
                    $orderData = array('print_data'=>base64_encode($mergePrintData));
                    $mergeOrderWhere = array();
                    $mergeOrderWhere['order_name'] = array('eq', $mergeItem['order_name']);
                    $tmpJdOrderM->where($mergeOrderWhere)->save($orderData);
                }
                $tmpJdOrderM->commit();
            } else {
                $orderData = array();
                $orderData['print_data'] = $result['jingdong_etms_order_print_responce']['response']['pdfArr'];
                $orderWhere = array();
                $orderWhere['order_name'] = array('eq', $order['order_name']);
                $tmpJdOrderM->where($orderWhere)->save($orderData);
            }
        }
    }

    /**
     *  按条件取出订单数据到ttgy_tmp_jd_order 表
     */
    public function fetchOrderToTmpJdOrder() {
        $whereArr = array();
        $model = new OrderModel();
        //只取出待发货的订单
        $orderStatus = 4;

        if(isset($_REQUEST['send_channel'])) {
            $send_channel = I('send_channel', '');
            if(!empty($send_channel)) {
                $whereArr[C('DB_PREFIX') . 'order_product.send_channel'] = array('eq', $send_channel);
            }
        }

        //只取最近7天的
        $time = time();
        $startTime = date('Y-m-d H:i:s', $time - (86400 * 30));
        $thisTime = date('Y-m-d H:i:s', $time);

        //改成最后更新时间 chrisying 2015-11-26
        $whereArr['last_modify_time'] = array(array('egt',$startTime), array('elt', $thisTime));

        //自动任务导出限制,只取未导出过的订单
        $whereArr['has_export'] = array('eq', 0);
        $result = $model->getFetchOrdersList($orderStatus, $whereArr);
        echo 'sql=====' . $model->getLastSql() . '<br/>';
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

        foreach ($result['order_list'] as $item) {
            $where = array();
            $where['order_name'] = array('eq', $item['order_name']);
            $isHave = $tmp_jd_orderM->where($where)->find();
            //已经存在且不是取出状态且是地址不配送的订单不再重复导入
            if(!empty($isHave) && in_array($isHave['status'], array(2,4,15,20))) {
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

                    //合并订单的标识条件增加发货仓的id, 确保只在同一个发货仓内合单 chris 16-2-24
                    $data['rec_key'] = md5($data['rec_name'] . $data['rec_mobile'] . $data['rec_address'] . $data['send_warehome_id']);

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
     *  检查订单的发货仓
     */
    public function checkSendWare(){
        $tmp_jd_orderM = M('tmp_jd_order');
        $productM = M('product');
        $sendWareHomeM = new SendWarehomeModel();
        $tmpWhere = array();
        $tmpWhere['status'] = array('in', array(1,2));
        $tmpWhere['print_num'] = 0;
        $tmpWhere['is_export_to_warehome'] = 1;
        $tmpWhere['send_warehome_id'] = 0;
        $tmpWhere['add_time'] = array('gt', '2015-03-01');
//        $tmpWhere['rec_mobile'] = '15355309566';
        $orderList = $tmp_jd_orderM->where($tmpWhere)->limit(0, 500)->select();
        echo $tmp_jd_orderM->getLastSql();
//        exit;
        foreach ($orderList as $item) {
            $data = array();
            $productItem = $productM->where(array('id' => array('eq', $item['product_id'])))->find();
            //发货仓
            $prodWareHome = $productItem['send_warehome'];
            $provinceCode = $item['province_id'];//省份代号
            $wareHomeData = $sendWareHomeM->getOrderWareHome($provinceCode, $prodWareHome);

            $data['send_warehome_id'] = $wareHomeData['send_warehome_id'];
            $data['send_warehome_name'] = $wareHomeData['send_warehome_name'];
            $data['send_warehome_en_name'] = $wareHomeData['send_warehome_en_name'];
            $data['source_city'] = $wareHomeData['source_city'];

            //合并订单的标识条件增加发货仓的id, 确保只在同一个发货仓内合单 chris 16-2-24
            $data['rec_key'] = md5($item['rec_name'] . $item['rec_mobile'] . $item['rec_address'] . $data['send_warehome_id']);
            $data['jd_can_shipping'] = 1;
            $data['check_can_jd_result'] = '';

            $tmp_jd_orderM->where(array('id' => $item['id']))->save($data);

            echo '<br/>' .  $tmp_jd_orderM->getLastSql() . '<br/>';
        }
    }

    /**
     *  检查地址是否可以用京东生鲜配送
     */
    public function checkTmpJdOrderCanJdShipping() {
        $error_log = '';
        $printOrderNames = I('order_names', '');
        $where = array();
        if(!empty($printOrderNames)) {
            $where['order_name'] = array('IN', explode(',', $printOrderNames));
        } else {
            //默认只检查未发邮件且未检查过的,或需要手工确认的订单
            $where['is_export_to_warehome'] = array('eq', 1);
            $where['status'] = array('IN', array(1,2));
            $where['print_num'] = array('eq', 0);
            $where['jd_can_shipping'] = array('IN', array(1, 4));
        }

        //过滤预售商品，延迟发货订单 chrisying 16-3-24
//        $filterResult = $this->filterSendOrder();
//        if(!empty($filterResult)){
//            foreach($filterResult as $key => $filter){
//                $where[$key] = array('not in', $filter);
//            }
//        }

        $tmpJdOrderM = M('tmp_jd_order');
        $deliveryIdM = D('JdDeliveryId');
        $wxMsgList = M('wx_msg_list');
        $orderM = M('order');

        $wareHouseCodeList = $this->getWarehouseList();

        if(C('IS_MERGE_ORDER')){
            $orderList = $tmpJdOrderM->where($where)->group('rec_key')->order('id asc')->limit(0, 10000)->select();
        } else {
            //暂时限制2000单, 不再合并包裹
            $orderList = $tmpJdOrderM->where($where)->order('id asc')->limit(0, 2000)->select();
        }

        deBugLog(array('tmp_order_sql_checkTmpJdOrderCanJdShipping' => $tmpJdOrderM->getLastSql()), 'order_task_filter_send_sql');

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
                        $wareHouse = $wareHouseCodeList[$order['send_warehome_id']];
            $result = $deliveryIdM->checkAddress($order['order_name'], $order['rec_address'], $wareHouse);
            if(isset($result['jingdong_etms_range_check_responce']['resultInfo']['rcode'])) {
                $rCode = $result['jingdong_etms_range_check_responce']['resultInfo']['rcode'];
                $data = array();
                switch ($rCode) {
                    case 100:
                        $data['jd_can_shipping'] = '2';
                        break;

                    case 200:
                        $data['jd_can_shipping'] = '3';
                        //地址检查未通过,给用户发提示信息
                        $orderItem = $orderM->field('uid')->where(array('order_name'=>$order['order_name']))->find();
                        $wxData = array();
                        $wxData['uid'] = $orderItem['uid'];
                        $wxData['content'] = '尊敬的叔小白用户您好: 订单[' . $order['order_name'] .
                            ']由于地址[' . $order['rec_address'] . ']未能通过京东快递的检查,造成无法发货,请联系 微信公众号[叔小白] 官方客服进行修改地址,建议您填写完整的省,市,县（区）,乡镇（街道）,路号,完整的四级地址更有可能通过地址检查。 ';
                        $wxData['add_time'] = time();
                        $wxMsgList->add($wxData);
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

                if(C('IS_MERGE_ORDER')){
                    $saveWhere['rec_key'] = $order['rec_key'];
                } else {
                    $saveWhere['order_name'] = $order['order_name'];
                }

                $saveResult = $tmpJdOrderM->where($saveWhere)->save($data);
                if($saveResult == false){
                    $failNum++;
                    echo '<br/>更新失败===' . $order['order_name'];
                    echo '<br/>更新失败===' . $order['rec_key'];
                } else {
                    $successNum++;
                }

                echo $tmpJdOrderM->getLastSql() . '<br/>';
            } else {
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
     *  检查order表中生鲜冷链商品是否可以京配
     * chrisying 16-01-10
     * 暂时取消，要先分好仓才能做是否可以配送检查,否则返回的数据会跟实际发的不对
     */
    public function checkCanJdShipping(){

        return;

        $orderWhere = array();
        $orderWhere['time'] = array('gt', '2016-01-03 00:00:00');
        $orderWhere['operation_id'] = array('eq', '10');
        $orderWhere['check_can_jd'] = array('eq', 1);
        $orderM = M('order');
        $orderAddrM = M('order_address');
        $orderList = $orderM->where($orderWhere)->order('time ASC')->limit(0, 1)->select();
        if(!empty($orderList)){
            foreach($orderList as $order){
                $addrWhere = array();
                $addrWhere['order_id'] = array('eq', $order['id']);
                $orderAddr = $orderAddrM->where($addrWhere)->find();
            }
        }

        $deliveryIdM = D('JdDeliveryId');
        $orderId = '15122701';
        $address='上海市普陀区云岭东路651号701室';
        //发货仓号
        $wareHouseCode = 'shpdttgy01';

        $result = $deliveryIdM->checkAddress($orderId, $address, $wareHouseCode);
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
        $productIds = I('product_ids', '');
        $where = array();
        if(!empty($productIds)) {
//            $where['product_id'] = array('IN', explode(',', $productIds));
        }

        //默认只合并从未导入过京东的订单
        $where['delivery_id'] = '';
        $where['is_export_to_warehome'] = array('eq', 1);
        $where['status'] = array('eq', 1);
        //最近15天
        $where['add_time'] = array('gt', date('Y-m-d H:i:s', time()-86400*15));

        //合并指定商品的同一收货信息订单
        $where['product_id'] = array('in',array(4618, 4621, 4622));


        $tmpJdOrderM = M('tmp_jd_order');

        //暂时限制1万单
        $orderList = $tmpJdOrderM->field('*, count(*) as package_count')->where($where)->group('rec_key')->having('package_count > 1')->limit(0, 10000)->select();

        echo $tmpJdOrderM->getLastSql();
//        exit;

        $orderNum = count($orderList);
        if($orderNum > 0) {
            foreach ($orderList as $key => $order) {
                if($order['package_count'] > 1){
                    $saveOrder = array();
                    $saveOrder['merge_order_name'] = 'M' . $order['order_name'] . $order['package_count'];
                    $saveOrder['package_num'] = $order['package_count'];

                    //给合并发货的订单分配包裹号
                    $mergeWhere = $where;
                    $mergeWhere['rec_key'] = $order['rec_key'];
                    $tmpJdOrderM->where($mergeWhere)->save($saveOrder);

                    $mergeOrderList = $tmpJdOrderM->where($mergeWhere)->limit(0, $order['package_count'])->select();
                    foreach ($mergeOrderList as $k => $mergeOrder) {
                        $packageNo = $k + 1;
                        $data = array('package_no' => $packageNo);
                        $saveWhere = $mergeWhere;
                        $saveWhere['order_name'] = $mergeOrder['order_name'];
                        $tmpJdOrderM->where($saveWhere)->save($data);
                    }
                }
            }
        }

        echo '<br/>' .  count($orderList) . '单';
    }

    public function showInfo(){
        $wxToken = getMem('wx_api_access_token');
        echo $wxToken;

//        echo RD('wx_api_access_token');
    }

    /**
     *  发订单邮件给仓库
     */
    public function sendMailToWarehouse(){
        $warehouseId = I('warehouse', 0);
        $sendWarehouseM = M('send_warehome');

        //条件,没有发送过的，可以京配且已经同步到京东的，订单。
        $where = array();
        $where['is_export_to_warehome'] = 1;
        $where['status'] = 2;
        $where['jd_can_shipping'] = 2;
        $where['add_time'] = array('gt', date('Y-m-d H:i:s', time() - 86400 * 30));

        //过滤预售商品，延迟发货订单 chrisying 16-3-24
        $filterResult = $this->filterSendOrder();
        if(!empty($filterResult)){
            foreach($filterResult as $key => $filter){
                $where[$key] = array('not in', $filter);
            }
        }

        //黑提预售
//        $where['product_id'] = array('not in',array(4618, 4621, 4622));

        //从2月3日起到年后2月13日只有部分地址发货
        $isHoliday = C('IS_HOLIDAY');
        $month = date('m', time());
        $date = date('d', time());
        if($isHoliday && $month == '02' && $date  > 2 && $date < 14){
            $sendCityIdArr = array(143950,144006,144032,106093,17771,74881,4536,14270,23730,2,46290,144261,144422,144355,144356,144296,144444,144644);
            //#143950  144006  144032   106093  17771  74881  4536  14270  23730  2  46290  144261  144422  144355 144356  144296  144444  144644
            $where['city_id'] = array('in', $sendCityIdArr);
        }

        $sendWarehouseM->startTrans();
        if($warehouseId > 0){
            $where['send_warehome_id'] = $warehouseId;
            $warehouseWhere = array('id'=>$warehouseId);
            $warehouse = $sendWarehouseM->where($warehouseWhere)->find();
            $this->sendOrderMail($where, $warehouse);
        } else{
            $warehouseList = $sendWarehouseM->select();
            foreach($warehouseList as $warehouse){
                //一次发送最多支持1万单
                $where['send_warehome_id'] = $warehouse['id'];
                $this->sendOrderMail($where, $warehouse);
            }
        }

        $sendWarehouseM->commit();
    }

    /**
     *  发每天的总报表
     */
    public function sendMailToManager(){
        $warehouseId = I('warehouse', 0);
        $sendWarehouseM = M('send_warehome');
        $date = I('date', date('Y-m-d'));

        $where = array();
        $where['is_export_to_warehome'] = 2;
        $where['jd_can_shipping'] = 2;
        $where['last_send_mail_time'] = array(array('egt', $date . ' 00-00-00'), array('elt', $date . ' 23-59-59'));

        //从2月3日起到年后2月13日只有部分地址发货
        $month = date('m', time());
        $date = date('d', time());
        $isHoliday = C('IS_HOLIDAY');
        if($isHoliday && $month == '02' && $date  > 2 && $date < 14){
            $sendCityIdArr = array(143950,144006,144032,106093,17771,74881,4536,14270,23730,2,46290,144261,144422,144355,144356,144296,144444,144644);
            //#143950  144006  144032   106093  17771  74881  4536  14270  23730  2  46290  144261  144422  144355 144356  144296  144444  144644
            $where['city_id'] = array('in', $sendCityIdArr);
        }

        $sendWarehouseM->startTrans();
        if($warehouseId > 0){
            $where['send_warehome_id'] = $warehouseId;
            $warehouseWhere = array('id'=>$warehouseId);
            $warehouse = $sendWarehouseM->where($warehouseWhere)->find();
            $this->sendManagerOrderMail($where, $warehouse, $date);
        } else{
            $warehouseList = $sendWarehouseM->select();
            foreach($warehouseList as $warehouse){
                //一次发送最多支持1万单
                $where['send_warehome_id'] = $warehouse['id'];
                $this->sendManagerOrderMail($where, $warehouse, $date);
            }
        }

        $sendWarehouseM->commit();
    }

    /**
     * 同步收货地址的ID
     */
    public function syncRecAddressId(){
        //条件,没有发送过的，可以京配且已经同步到京东的，订单。
        $where = array();
        $where['is_export_to_warehome'] = 1;
        $where['status'] = array('in', array(1,2));
//        $where['jd_can_shipping'] = 2;
        $where['open_order_id'] = 0;
        $where['city_id'] = 0;
        $where['add_time'] = array('gt', date('Y-m-d H:i:s', (time() - 86400 * 14)));

        $tmpJdOrderM = M('tmp_jd_order');
        $orderAddressM = M('order_address');
        $orderM = M('order');
        $orderList = $tmpJdOrderM->where($where)->limit(0, 500)->select();
        if(empty($orderList)){
            echo '没有需要同步地址id的订单';
            exit;
        }

        foreach($orderList as $order){
            $orderId = $orderM->field('id')->where(array('order_name'=>$order['order_name']))->find();
            $orderAddressItem = $orderAddressM->where(array('order_id' => $orderId['id']))->find();
            $data = array();
            $data['province_id'] = $orderAddressItem['province'];
            $data['city_id'] = $orderAddressItem['city'];
            $data['area_id'] = $orderAddressItem['area'];
            $tmpJdOrderM->where(array('order_name' => $order['order_name']))->save($data);

            echo '<br/>' . $tmpJdOrderM->getLastSql() . '<br/>';
        }
    }

    private function sendManagerOrderMail($where, $warehouse, $date=''){
        $warehouseOrderLogM = M('warehouse_order_log');
        $tmpJdOrderM = new TmpJdOrderModel();
        $orderList = $tmpJdOrderM->where($where)->limit(0, 10000)->select();
//        echo '<br/>' . $tmpJdOrderM->getLastSql() . '<br/>';
        $sendOrders = array();
        $errorOrders = array();
        if(empty($orderList)){
            return;
        }

        $excelFiles = $tmpJdOrderM->exportWarehouseOrder($orderList, $warehouse['name']);

//        echo '导出的excel文件是<br/>';
//        var_dump($excelFiles);
        if($excelFiles == false){
            return;
        }

        try {
            $mail  = getMail();

            $mailList = C(WAREHOUSE_MANAGE_EMAIL);
            if(empty($mailList)){
                $mailList[] = 'yyh96@126.com';
                $mailList[] = 'christhink@qq.com';
                $mailList[] = 'tianiao@126.com';
                $mailList[] = '277522155@qq.com';
                $mailList[] = 'shenli@fruitday.com';
                $mailList[] = 'wuyf@fruitday.com';
                $mailList[] = 'yangrr@fruitday.com';
            }

            foreach($mailList as $mailAddress){
                $mail->AddAddress($mailAddress);
            }

            $goodsNum = $tmpJdOrderM->getTmpGoodsXlsData($orderList);
            $this->assign('goods_num_list', $goodsNum['xls_data']);
            $goodsNumHtml = $this->fetch('Task:goods_num_list');

            $date = empty($date) ? date('Y-m-d', time()) : $date;
            $mail->Subject  = $date . $warehouse['name']  . "订单";
            $mail->Body = "大家好: 今天订单" . count($orderList) . '单' . $goodsNumHtml;
            $mail->AltBody    = "大家好: 今天订单" . count($orderList) . '单'; //当邮件不支持html时备用显示，可以省略
            $mail->WordWrap   = 80; // 设置每行字符串的长度
            $mail->AddAttachment($excelFiles['product_total']);  //可以添加附件
            $mail->IsHTML(true);
            $sendResult = $mail->Send();
            if($sendResult){
                $mailResult =  '邮件已发送';
            } else {
                $mailResult =  "邮件发送失败";
            }
        } catch (phpmailerException $e) {
            $mailResult = "邮件发送失败：".$e->errorMessage();
        } finally{

        }
    }

    private function sendOrderMail($where, $warehouse){
        $warehouseOrderLogM = M('warehouse_order_log');
        $orderM=M('order');
        $tmpJdOrderM = new TmpJdOrderModel();
        $orderList = $tmpJdOrderM->where($where)->limit(0, 10000)->select();
        deBugLog(array('tmp_order_sql_sendOrderMail' => $tmpJdOrderM->getLastSql()), 'order_task_filter_send_sql');
        echo $tmpJdOrderM->getLastSql();
        $sendOrders = array();
        $errorOrders = array();
        if(empty($orderList)){
            echo '<br/>没有订单<br/>';
            return;
        }

        //检查订单状态是否与order表中一致
        $this->checkSendMailOrder($orderList, $sendOrders, $errorOrders, $orderM, $tmpJdOrderM, $where);

        $excelFiles = $tmpJdOrderM->exportWarehouseOrder($orderList, $warehouse['name']);
        if($excelFiles == false){
            echo '<br/>excel文件出错<br/>';
            return;
        }

        try {
            $mail  = getMail();

            $mailList = json_decode($warehouse['contact_email'], true);
            if(empty($mailList)){
                echo '<br/>mail 地址出错<br/>';
                return;
            }

            foreach($mailList as $mailAddress){
                $mail->AddAddress($mailAddress);
            }

            $goodsNum = $tmpJdOrderM->getTmpGoodsXlsData($orderList);
            $this->assign('goods_num_list', $goodsNum['xls_data']);
            $goodsNumHtml = $this->fetch('Task:goods_num_list');

            $mail->Subject  = date('Y-m-d H:i:s', time()) . $warehouse['name']  . "订单";
            $mail->Body = "大家好: 本次订单" . count($orderList) . '单' . $goodsNumHtml;
            $mail->AltBody    = "大家好: 本次订单" . count($orderList) . '单'; //当邮件不支持html时备用显示，可以省略
            $mail->WordWrap   = 80; // 设置每行字符串的长度
            $mail->AddAttachment($excelFiles['product_total']);  //可以添加附件
            $mail->AddAttachment($excelFiles['order_list']);  //可以添加附件
            $mail->IsHTML(true);
            $sendResult = $mail->Send();
            if($sendResult){
                $mailResult =  '邮件已发送';
            } else {
                $mailResult =  "邮件发送失败";
            }
        } catch (phpmailerException $e) {
            $mailResult = "邮件发送失败：".$e->errorMessage();
        } finally{
            $logData = array();
            $logData['create_time'] = date('Y-m-d H:i:s', time());
            $logData['order_names'] = json_encode($sendOrders);
            $logData['check_result'] = json_encode(array('error_orders' => $errorOrders, 'mail_result' => $mailResult));
            $logData['to_email'] = $warehouse['contact_email'];
            $logData['warehouse_id'] = $warehouse['id'];
            $logData['warehouse_name'] = $warehouse['name'];
            $logData['content'] = '大家好: 本次发货订单' . count($sendOrders);

            echo '<br/>======邮件发送日志=======<br/>';
            var_dump($logData);
            $warehouseOrderLogM->add($logData);
            echo '<br/>===addlog===' . $warehouseOrderLogM->getLastSql() . '<br/>';

        }
    }

    /**
     *  将单个包裹未导入到京东的订单手工导入到京东系统中
     */
    public function importToJd() {
        $wareHouseCodeList = $this->getWarehouseList();
//        $isMerge = I('is_merge', 0);
        $isMerge = 0;
        $sendOrderNames = I('order_names', '');
        $where = array();
        if(!empty($sendOrderNames)) {
            $where['order_name'] = array('IN', explode(',', $sendOrderNames));
        } else {
            //默认只导入从未导入过京东且包裹数为1的订单
            $where['is_export_to_warehome'] = array('eq', 1);
            $where['jd_can_shipping'] = array('eq', '2');
            $where['status'] = array('eq', 1);
            $where['package_num'] = 1;
        }

        //过滤预售商品，延迟发货订单 chrisying 16-3-24
//        $filterResult = $this->filterSendOrder();
//        if(!empty($filterResult)){
//            foreach($filterResult as $key => $filter){
//                $where[$key] = array('not in', $filter);
//            }
//        }

        //黑提预售
//        $where['product_id'] = array('not in',array(4618, 4621, 4622));



        $tmpJdOrderM = M('tmp_jd_order');
        echo '==isMerge==' . $isMerge;
        //暂时限制1万单
        if($isMerge > 0){
            $orderList = $tmpJdOrderM->field('*, count(*) as package_count')->where($where)->group('rec_key')->limit(0, 10000)->select();
        } else {
            $orderList = $tmpJdOrderM->field('*')->where($where)->limit(0, 500)->select();
        }


        deBugLog(array('tmp_order_sql_importToJd' => $tmpJdOrderM->getLastSql()), 'order_task_filter_send_sql');


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

                if(!($isMerge > 0)){
                    $order['package_count'] = 1;
                }

                $order['delivery_id'] = $deliveryItem['delivery_id'];
                //订单号加前缀
                $order['self_order_name'] = $order['order_name'];

                if($isMerge > 0 && $order['package_count'] > 1){
                    $order['order_name'] = 'M' . $order['order_name'] . $order['package_count'];
                    $order['merge_order_name'] = $order['order_name'];

                    //给合并发货的订单分配包裹号
                    $mergeWhere = $where;
                    $mergeWhere['rec_key'] = $order['rec_key'];
                    $mergeOrderList = $tmpJdOrderM->where($mergeWhere)->limit(0, $order['package_count'])->select();
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
     *  将合并包裹的订单导入京东,与单个包裹的导入京东分开
     */
    public function importMergeOrderToJd(){
        $wareHouseCodeList = $this->getWarehouseList();
        //        $isMerge = I('is_merge', 0);
        $isMerge = 1;
        $sendOrderNames = I('order_names', '');
        $where = array();
        if(!empty($sendOrderNames)) {
            $where['order_name'] = array('IN', explode(',', $sendOrderNames));
        } else {
            //默认只导入从未导入过京东且包裹数大于1的订单
            $where['is_export_to_warehome'] = array('eq', 1);
            $where['jd_can_shipping'] = array('eq', '2');
            $where['status'] = array('eq', 1);
            $where['package_num'] = array('gt', 1);
        }

        //过滤预售商品，延迟发货订单 chrisying 16-3-24
        $filterResult = $this->filterSendOrder();
        if(!empty($filterResult)){
            foreach($filterResult as $key => $filter){
                $where[$key] = array('not in', $filter);
            }
        }

        //黑提预售
        //$where['product_id'] = array('not in',array(4618, 4621, 4622));


        $tmpJdOrderM = M('tmp_jd_order');
        echo '==isMerge==' . $isMerge;
        //暂时限制500
        $orderList = $tmpJdOrderM->field('*')->where($where)->group('rec_key')->limit(0, 500)->select();


        deBugLog(array('tmp_order_sql_importMergeOrderToJd' => $tmpJdOrderM->getLastSql()), 'order_task_filter_send_sql');

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

                $order['delivery_id'] = $deliveryItem['delivery_id'];
                //订单号加前缀
                $order['self_order_name'] = $order['order_name'];

                if($order['package_num'] > 1){
                    $order['order_name'] = 'M' . $order['order_name'] . $order['package_num'];
                    $order['merge_order_name'] = $order['order_name'];
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
                    //只更新当前查到订单范围内的订单信息
                    $tmpJdOrderWhere = $where;

                    $tmpJdOrderWhere['rec_key'] = $order['rec_key'];

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



    public function getDeliveryTrace(){
        $tmpJdOrderM = M('tmp_jd_order');
        $where = array();
        $where['is_export_to_warehome'] = 2;
        $where['print_num'] = array('gt', 0);
        $where['jd_can_shipping'] = array('eq', 2);
        $where['delivery_id'] = array('neq', '');
        $this7days = date('Y-m-d H:i:s', time()-86400*17);
        $where['last_import_jd_time'] = array('gt', $this7days);
        $where['shipping_finish'] = 1;

        $orderList = $tmpJdOrderM->where($where)->limit(0, 1000)->order('last_check_shipping_time asc')->select();
        if(empty($orderList)){
            echo '没有需要检查的订单';
        }

        $warehouseList = $this->getWarehouseList();
        $jdDeliveryM = new JdDeliveryIdModel();

        echo $tmpJdOrderM->getLastSql() . '<br/>';
        echo '<br/>===需要检查' . count($orderList) . '个订单<br/>';
        foreach($orderList as $order){
            $warehouse = $warehouseList[$order['send_warehome_id']];
            $params =  array();
            $params['v'] = '2.0';
            $params['method'] = 'jingdong.etms.trace.get';
            $params['app_key'] = $warehouse['jd_app_key'];
            $params['access_token'] = $warehouse['jd_access_token'];
            $params['timestamp'] = date('Y-m-d H:i:s', time());
            $params['format'] = 'json';
            $params['waybillCode'] = $order['delivery_id'];

            ksort($params);
            $params['sign'] = $jdDeliveryM->getJdSign($params);
            $result = getCurlRequest($jdDeliveryM->routerJsonUrl, $params);

            $saveData = array();
            $saveData['last_check_shipping_time'] = date('Y-m-d H:i:s', time());
            if(isset($result['jingdong_etms_trace_get_responce']['code'])){
                $code = $result['jingdong_etms_trace_get_responce']['code'];
                $searchResult = $result['jingdong_etms_trace_get_responce']['trace_api_dtos'];
                $count = count($searchResult);
                if($code == 0 && $count > 0){
                    $saveData['shipping_status'] = json_encode($searchResult);
                    if($searchResult[$count-1]['ope_title'] == '妥投'){
                        $saveData['shipping_finish'] = 2;
                    }
                }

            }

            $tmpJdOrderM->where(array('order_name'=>$order['order_name']))->save($saveData);
            echo $tmpJdOrderM->getLastSql() . '<br/>';
        }
    }

    private function checkSendMailOrder(&$orderList, &$sendOrders, &$errorOrders, $orderM, $tmpJdOrderM, $where){
        //检查原order表中的订单状态
        foreach ($orderList as $key => $item) {
            //如果补发的订单,跳过检查
            $isBf =strpos(strtolower($item['order_name']), 'bf');

            $order = $orderM->where(array('order_name'=>array('eq', $item['order_name'])))->find();

            $checkStatus = ($item['open_order_id'] > 0) || !(is_bool($isBf) && false === $isBf) || (!empty($order) && $order['pay_status'] == 1 && $order['operation_id'] = 10);
            if($checkStatus){
                $sendOrders[] = $item['order_name'];
                $upData = array('is_export_to_warehome' => 2);
                $upData['last_send_mail_time'] = date('Y-m-d H:i:s', time());
                $upWhere = $where;
                $upWhere['order_name'] = $item['order_name'];
                $result = $tmpJdOrderM->where($upWhere)->save($upData);
                if($result == false){
                    unset($orderList[$key]);
                    $errorOrders[] = array('order_name' => $item['order_name'], 'msg' => '订单状态更新出错!' . $tmpJdOrderM->getLastSql());
                }
            } else {
                $tmpJdOrderM->addErrorOrder($item);
                unset($orderList[$key]);
                $errorOrders[] = array('order_name' => $item['order_name'], 'msg' => '原order表中订单状态不正确!');
            }
        }
    }

    /**
     *  计算用户好友及其亲密度
     */
    public function calUserFriendIntimate(){
        $startCheckTime = time();
        $groupbuyingOrderM = M('groupbuying_order');
        $userM = M('user');
        $groupbuyingM = M('groupbuying');
        $userFriendIntimateM = M('user_friend_intimate');

        $where = array();
        //12小时内只检查一次
        $halfDayBefore = time() - (3600 * 24);
        $where['last_check_friend_intimate'] = array('lt', date('Y-m-d H:i:s', $halfDayBefore));
        $theUser = I('the_user', 0);
        if($theUser > 0){
            $where['id'] = array('IN', array(338802,349928,339981,355237,363356,385347,518541,332654,338748,334785));
        }

        $uid = I('uid', 0);
        if($uid > 0){
            $where['id'] = $uid;
        }

        $userList = $userM->field('id,username')->where($where)->order('last_check_friend_intimate asc, id desc')->limit(0, 100)->select();

        echo $userM->getLastSql() . '<br/>';
        if(empty($userList)){
            echo '最近24小时内没有需要检查的用户!';
        }

        $userIdArr = array();
        foreach($userList as $user){
            $userIdArr[] = $user['id'];
        }

        $userM->where(array('id'=>array('in', $userIdArr)))->save(array('last_check_friend_intimate' => date('Y-m-d H:i:s', time())));

        foreach($userList as $key => $user){
            $whereSponsorSuccNum = array();
            $whereSponsorSuccNum['sponsor_id'] = array('eq', $user['id']);
            //49人及以上团不进入统计
            $whereSponsorSuccNum['groupbuying_reqnums'] = array('lt', 49);
            $sponsorNum = $groupbuyingM->where($whereSponsorSuccNum)->count();

            if($sponsorNum > 0){
                $whereSponsorSuccNum['state'] = array('eq', 2);
                $sponsorSuccNum = $groupbuyingM->where($whereSponsorSuccNum)->count();
            } else {
                $sponsorSuccNum = 0;
            }

            $sql = 'select count(*) as c_num from ' . C('DB_PREFIX') . 'groupbuying as g right join ' . C('DB_PREFIX') . 'groupbuying_order as go on g.id = go.groupbuying_id where g.groupbuying_reqnums < 50 and go.uid=' . $user['id'] . ' AND go.state IN(2,5,6)';
            $succOrderNum = M()->query($sql);

            $sql = 'select count(*) as c_num from ' . C('DB_PREFIX') . 'groupbuying as g right join ' . C('DB_PREFIX') . 'groupbuying_order as go on g.id = go.groupbuying_id where g.groupbuying_reqnums < 50 and go.uid=' . $user['id'] . ' AND go.state IN(3,4,7)';
            $failOrderNum = M()->query($sql);

            $data = array();
            $data['uid'] = $user['id'];
            $data['nickname'] = $user['username'];
//            $data['last_check_time'] = date('Y-m-d H:i:s', time());
            $data['sponsor_num'] = $sponsorNum;
            $data['sponsor_succ_num'] = $sponsorSuccNum;
            $data['succ_order_num'] = $succOrderNum[0]['c_num'];
            $data['fail_order_num'] = $failOrderNum[0]['c_num'];

            //最多统计最近90天的1000单
            $userOrderWhere = array();
            $lastThreeMonth = time() - (86400 * 30);
            $userOrderWhere['create_time'] = array('gt', $lastThreeMonth);
            $userOrderWhere['uid'] = array('eq', $user['id']);
            $userGroupbuyOrderList = $groupbuyingOrderM->where($userOrderWhere)->group('groupbuying_id')->order('create_time desc')->limit(0, 1000)->select();

            $userFriendIntimateKey = 'user_friend_intimate_key_' . $user['id'];
            if(empty($userGroupbuyOrderList)){
                $friendIntimate = $this->redis->zRevRange($userFriendIntimateKey, 0, -1, true);
                if(!empty($friendIntimate)){
                    $data['friend_intimate'] = json_encode($friendIntimate);
                    $data['friend_num'] = count($friendIntimate);
                }
                $this->updateUserFriendIntimate($userFriendIntimateM, $data);
                continue;
            }

            //已经计算过的团不再重新计算, key = 'user_friend_intimate_cal_key_' . $user['id'],
            //团实例的集合，存在则跳过，不存在，则写入并把 此团中的用户，好友亲密度加1
            $data['last_order_time'] = date('Y-m-d H:i:s', $userGroupbuyOrderList['0']['create_time']);
            foreach($userGroupbuyOrderList as $groupbuyOrder){
                $groupbuyingItem = $groupbuyingM->where(array('id' => $groupbuyOrder['groupbuying_id']))->find();
                //49以上团不参与统计
                if($groupbuyingItem['groupbuying_reqnums'] > 49){
                    continue;
                }

                //已经计算过的团实例,写在集合里
                $userFriendIntimateGroupidCheckKey = 'user_friend_intimate_groupid_check_key' . $user['id'];
                $isCheckGroup = $this->redis->sAdd($userFriendIntimateGroupidCheckKey, $groupbuyOrder['groupbuying_id']);
                if(!$isCheckGroup){
                    continue;
                }


                $groupUidsArr = json_decode($groupbuyingItem['partake'], true);
                foreach($groupUidsArr as $groupUid){
                    if($groupUid == $user['id']){
                        continue;
                    }

                    //一个用户跟另一个用户一起拼团的次数,代表他们的亲密度
                    $userFriendIntimateValueKey = 'user_friend_intimate_value_key' . $user['id'] . '_' . $groupUid;
                    $this->redis->incr($userFriendIntimateValueKey);
                    $intimateValue = $this->redis->get($userFriendIntimateValueKey);

                    $this->redis->zAdd($userFriendIntimateKey, $intimateValue, $groupUid);
                }
            }

            $friendIntimate = $this->redis->zRevRange($userFriendIntimateKey, 0, -1, true);
            if(!empty($friendIntimate)){
                $data['friend_intimate'] = json_encode($friendIntimate);
                $data['friend_num'] = count($friendIntimate);
            }
            $this->updateUserFriendIntimate($userFriendIntimateM, $data);
        }

        echo '本次检查结束' . date('Y-m-d H:i:s', time()) . '用时' . (time() - $startCheckTime) . '秒';
    }



    /**
     *  统计商品销量定时任务
     */
    public function calSaleVolume(){
        //第一次运行时,统计前60天每天的销量, 之后只统计前一天的, 每天1:30 运行一次就可以了
        $endDate = I('end_date', date('Y-m-d'));
        $todayBeginTime = strtotime($endDate);

        $fromDate = I('from_date', date('Y-m-d', $todayBeginTime - 86400 * 30));
        $fromTime = strtotime($fromDate);

        $toDate = I('to_date', $endDate);
        $toTime = strtotime($toDate);

        $tmpJdOrderM = M('tmp_jd_order');
        $productSaleVolumeM = M('product_sale_volume');
        for($fromTime; $fromTime < $toTime; $fromTime=$fromTime+86400){
            $endDate = date('Y-m-d H:i:s', $fromTime);
            $nextDate = date('Y-m-d H:i:s', $fromTime + 86400);

            $orderWhere = array();
            $orderWhere['add_time'] = array(array('egt', $endDate), array('lt', $nextDate));
            $orderWhere['status'] = array('in', array(1,2,4));
            //销量不计算外部合作的订单
//            $orderWhere['open_order_id'] = 0;
//            $orderWhere['product_id'] = array('gt', 0);
            $orderList = $tmpJdOrderM->field('*, sum(num) as sale_num')->where($orderWhere)->group('product_id, product_standard,send_warehome_id')->select();

            echo $tmpJdOrderM->getLastSql() . '<br/>';
            if(empty($orderList)){
                continue;
            }

            $date = substr($endDate, 0, 10);
            foreach($orderList as $item){
                $saleData = array();

                $saleData['product_name'] = $item['product_name'];
                $saleData['product_id'] = $item['product_id'];
                $saleData['standard'] = $item['product_standard'];
                $saleData['product_key'] = md5($item['product_id'] . $item['product_name'] . $item['product_standard'] . $item['send_warehome_id']);
                $saleData['date'] = $date;
                $saleData['sale_volume'] = $item['sale_num'];
                $saleData['add_time'] = date('Y-m-d H:i:s', time());
                $saleData['send_warehome_id'] = $item['send_warehome_id'];
                $saleData['send_warehome_en_name'] = $item['send_warehome_en_name'];
                $saleData['send_warehome_name'] = $item['send_warehome_name'];

                $isHavedWhere = array('date' => $date, 'product_key' => $saleData['product_key']);
                $isHaved = $productSaleVolumeM->where($isHavedWhere)->find();
                if(!empty($isHaved)){
//                    continue;
                    $productSaleVolumeM->where($isHavedWhere)->save($saleData);
                } else {
                    $productSaleVolumeM->add($saleData);
                }
            }
        }
    }

    public function sendOpenOrderDeliveryIdMail(){

        $partnerId = I('export_partner', 1);
        $fromTime = date('Y-m-d', time()-86400 * 3) . ' ' . '00:00:00';
        $toTime = date('Y-m-d H:i:s');

        $tmpJdOrderM = M('tmp_jd_order');
        $where = array();
        $where['add_time'] = array(array('egt', $fromTime), array('elt', $toTime));
        $where['open_order_id'] = $partnerId;
        $where['delivery_id'] = array('neq', '');
        $where['open_order_export_num'] = 0;

        $field = 'product_name, order_name, rec_name, rec_mobile, rec_address, shipping_name, delivery_id,open_order_code';
        $orderList = $tmpJdOrderM->field($field)->where($where)->limit(0, 10000)->select();
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

        $excelFile = exportExcel('订单发货快递单号导出表' . $fromTime . '-' . $toTime, $excelTitle, $orderList);

        //        echo '导出的excel文件是<br/>';
        //        var_dump($excelFiles);
        if($excelFile == false){
            return;
        }

        try {
            $mail  = getMail();

            $mailList = array();
            $mailList[] = 'yyh96@126.com';
            $mailList[] = 'christhink@qq.com';
            $mailList[] = '291908652@qq.com';
            $mailList[] = '1125599999@qq.com';

            foreach($mailList as $mailAddress){
                $mail->AddAddress($mailAddress);
            }

            $mail->Subject  = date('Y-m-d H:i:s', time()) . "订单发货快递单号导出表";
            $mail->Body = "大家好: 今天订单" . count($orderList) . '单已发货';
            $mail->AltBody    = "大家好: 今天订单" . count($orderList) . '单已发货'; //当邮件不支持html时备用显示，可以省略
            $mail->WordWrap   = 80; // 设置每行字符串的长度
            $mail->AddAttachment($excelFile);  //可以添加附件
            $mail->IsHTML(true);
            $sendResult = $mail->Send();
            if($sendResult){
                $mailResult =  '邮件已发送';
            } else {
                $mailResult =  "邮件发送失败";
            }
        } catch (phpmailerException $e) {
            $mailResult = "邮件发送失败：".$e->errorMessage();
        } finally{

        }
    }

    /**
     *  计算京东快递送货使用的天数
     */
    public function syncSendUseDate(){
        $productId = I('product_id');
        $isRec = I('is_rec', 1);

        $where = array();
        if(!empty($productId) && $productId > 0){
            $where['product_id'] = $productId;
        }

        //默认同步已经收件的订单
        if($isRec > 0){
            $where['shipping_finish'] = 2;
            $where['send_use_date'] = 0;
        } else {
            $where['shipping_finish'] = 1;
        }

        $minAddTime = date('Y-m-d H:i:s', time()-86400 * 10);
        $where['add_time'] = array('egt', $minAddTime);


        $where['status'] = 4;
        $tmpJdOrderM = M('tmp_jd_order');
        $orderList = $tmpJdOrderM->where($where)->order('id asc')->limit(1000)->select();
        if(empty($orderList)){
            echo '没有需要同步的订单';
        }

        foreach($orderList as $item){
            $shippingStatus = $item['shipping_status'];
            $shippingStatusResult = json_decode($shippingStatus, true);

            $sendGoodDateTime = $shippingStatusResult[0]['ope_time'];
            $sendTime = strtotime($sendGoodDateTime);
            $recGoodsDateTime = $shippingStatusResult[count($shippingStatusResult) -1]['ope_time'];
            $recTime = strtotime($recGoodsDateTime);

            $sendDate = date('Y-m-d', $sendTime);
            $sendDateTime = strtotime($sendDate . ' 23:59:59');
            $dateNum = ceil(($recTime - $sendDateTime) / 86400);

            $data = array();
            $data['jd_rec_time'] = $sendGoodDateTime;
            $data['jd_arrive_time'] = $recGoodsDateTime;
            $data['send_use_date'] = $dateNum;
            $tmpJdOrderM->where(array('id'=>$item['id']))->save($data);
//            echo $tmpJdOrderM->getLastSql() . '<br/>';
        }
    }

    /**
     *  定时更新商品库存
     */
    public function updateProductStock(){
        //添加的最大库存量
        $stock = I('max_stock', 0);
        $productId = I('product_id', 0);
        $stepStock = I('step_stock', 1);
        $totalAddStockKey = 'total_add_stock_key_product_' . $productId;
        //重新初始化
        $isInit = I('is_init', 0);
        if($isInit > 0){
            $this->redis->set($totalAddStockKey, 0);
        }

        if(!($productId > 0)){
            echo '参数错误';
            return;
        }

        $nowAddStock = $this->redis->get($totalAddStockKey);
        if($nowAddStock > $stock){
            echo '<br/>已到最大库存量<br/>';
            return;
        }

        $newAddStock = $nowAddStock + $stepStock;
        if($newAddStock > $stock){
            $stepStock = $stock - $nowAddStock;
        }

        echo '<br/>当前已经加的库存量:' . $nowAddStock . '<br/>';

        $productPriceM = M("product_price");
        $where = array();
        $where['product_id'] = $productId;
//        $productPriceItem = $productPriceM->where($where)->find();
        $productPriceM->where($where)->setInc('stock', $stepStock);
        echo $productPriceM->getLastSql();

        $this->redis->set($totalAddStockKey, $newAddStock);
        echo '<br/>最新加后库存量:' . $newAddStock . '<br/>';
    }

    private function updateUserFriendIntimate($userFriendIntimateM, $data){
        $data['last_check_time'] = date('Y-m-d H:i:s');
        $item = $userFriendIntimateM->where(array('uid'=>$data['uid']))->find();

        $beCreateTime = strtotime('2016-03-18 18:13:00');
        //同步平均每单分享数和3.18后的订单数到亲密度表
        $sql = 'select count(*) as c_num from ' . C('DB_PREFIX') . 'groupbuying as g right join ' . C('DB_PREFIX') . 'groupbuying_order as god on g.id = god.groupbuying_id where god.create_time > ' . $beCreateTime . ' AND g.groupbuying_reqnums < 50 and god.uid=' . $data['uid'] . ' AND god.state IN(2,5,6)';
        echo '<br/>' . $sql;
        $afterShareSuccOrderNum = M()->query($sql);
        $data['after_share_order_num'] = $afterShareSuccOrderNum[0]['c_num'];

        if(empty($item)){
            $data['avg_order_share_num'] = 0;
            $userFriendIntimateM->add($data);
        } else {
            $data['avg_order_share_num'] = round($item['share_num'] / $data['after_share_order_num'], 2);
            $userFriendIntimateM->where(array('uid'=>$data['uid']))->save($data);
        }

        echo '<br/>' . $data['after_share_order_num'] . '=======' .  $userFriendIntimateM->getLastSql();
    }

    /**
     *  更新用户亲密度表中的平均每单分享次数
     */
    public function updateIntimateAvgShareNum(){
        $userFriendIntimateM = M('user_friend_intimate');
        $intimateList = $userFriendIntimateM->where(array('after_share_order_num'=>0))->limit(1000)->order('last_check_time asc')->select();
        if(empty($intimateList)){
            return;
        }

        foreach($intimateList as $item){
            $this->updateUserFriendIntimate($userFriendIntimateM, $item);
        }
    }

    /**
     *  以warehouseid为下标的仓库列表
     * @return array
     */
    private function getWarehouseList(){
        $sendWarehome = M('send_warehome');
        $wareHouseList = $sendWarehome->select();
        $wareHouseCodeList = array();
        foreach ($wareHouseList as $item) {
            $wareHouseCodeList[$item['id']] = $item;
        }

        return $wareHouseCodeList;
    }


    private function filterSendOrder(){
        $filterSendOrderM = M('filter_send_order');
        $where = array();
        $where['send_date'] = array('gt', date('Y-m-d', time()));
        $list = $filterSendOrderM->where($where)->select();

        if(empty($list)){
            return array();
        }

        $result = array();
        foreach($list as $item){
            $result[$item['type']][] = $item['value'];
        }

        return $result;
    }



    public function test(){
      $str = 'huadd@fruitday.com;tianiao@126.com;wenzh@fruitday.com;yumm@fruitday.com;wangjian@fruitday.com;zhangxx@fruitday.com;liming3@fruitday.com;yangxx@fruitday.com';

        $mailArr = explode(';', $str);

        $mailList = array();
        foreach($mailArr as $item){
            $mailList[] = trim($item);
        }
        var_dump($mailList);

        echo '<br>'  . json_encode($mailList);
    }


    public function test2(){
        $data = array();
        $data['uid'] = 32;
        $data['content'] = 'ttttttt';
        $data['add_time'] = time();



    }
}