<?php

/**
 * 微信接口
 * 接收微信事件通知,及发送微信通知等与微信接口相关功能
 * User: chrisying
 * Date: 15/9/21
 * Time: 下午12:00
 */
class WxApiAction extends Action {

    public $token;
    public $redis;
    private $todayMaxMoneyKey;
    private $todayMaxMoneyHistoryKey;
    private $newSubscribeUserKey;  //新关注的
    private $newUnsubscribeUserKey;  //取消关注的

    public function _initialize() {
        import('@.ORG.RedisObj');
        $this->redis = new RedisObj();

        //当天的可用红包余额
        $this->todayMaxMoneyKey = 'today_max_redpack_money_key';
        //初始红包余额历史记录
        $this->todayMaxMoneyHistoryKey = 'today_max_redpack_money_history_key';

        $this->newSubscribeUserKey = 'new_subscribe_user_key_2';  //新关注的
        $this->newUnsubscribeUserKey = 'new_unsubscribe_user_key_2';  //取消关注的

        header("Content-type: text/html; charset=utf-8");
        $this->token = 'b6cb06c668a0e21ab1733505533cd8b5';
        $passKey = I('pass_key', md5('abc12376446'));
        $autoTaskKey = C('AUTO_TASK_KEY');
        if($autoTaskKey != $passKey) {
            return;
        }
    }

    public function index() {

    }

    /**
     *  创建带参二维码
     */
    public function getTicket() {
        $accessToken = S('wx_api_access_token');
        //        $accessToken = 'AxfVEtbAnIXcKMUYdCjBtN6CcTqiOMHTTsUGJDLSUlbGfVjUZWrbFus705Cc9YiXq8uZXihNdjn2gQM0rgEIO97dN8ts-zBnnRmHf7aclMUBSTjACAOFG';
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $accessToken;

        $ticketType = I('ticket_type', 'QR_LIMIT_SCENE');
        $sceneName = I('scene_name', '送百万红包带参二维码');

        switch ($ticketType) {
            case 'QR_LIMIT_STR_SCENE':
            case 'QR_LIMIT_SCENE':
                //永久的
                $wxQrLimitSceneM = M('wx_qr_limit_scene');
                $id = $wxQrLimitSceneM->add(array('scene_name' => $sceneName));
                if($id > 0 && $id < 100000)
                    $reqData = array();
                $reqData['action_name'] = $ticketType;
                $reqData['action_info'] = array('scene' => array('scene_id' => $id));
                $result = getCurlRequest($url, json_encode($reqData));
                //                var_dump($result);

                if(isset($result['ticket'])) {
                    $saveData = array();
                    $saveData['ticket'] = $result['ticket'];
                    $saveData['ticket_result'] = json_encode($result);
                    $saveData['add_time'] = date('Y-m-d H:i:s', time());
                    $saveData['scene_name'] = $sceneName;
                    $saveData['url'] = $result['url'];
                    $wxQrLimitSceneM->where(array('id' => $id))->save($saveData);

                    //HTTP GET请求（请使用https协议）
                    //https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=TICKET
                    //提醒：TICKET记得进行UrlEncode
                    $qrUrl = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($result['ticket']);
                    //                redirect($qrUrl);
                    redirect($qrUrl);
                }

                //            永久二维码请求说明
                //            POST数据格式：json
                //            POST数据例子：{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
                //            或者也可以使用以下POST数据创建字符串形式的二维码参数：
                //            {"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "123"}}}

                break;

            case '':
                //临时的

                break;
        }

    }

    public function getQrImg() {
        $qrUrl = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode('gQGA8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2VrUnhBaUxseE9POUkwNGlPbWlqAAIE3/fyVQMEAAAAAA==');
        //                redirect($qrUrl);

        $qrResult = getCurlRequest($qrUrl, '');
    }

    /**
     *  URL是开发者用来接收微信消息和事件的接口URL
     */
    public function event() {
        $beginTime = microtime(true); //获取程序开始执行的时间



        if(empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
            if($this->checkSignature()) {
                echo $_GET['echostr'];
            } else {
                echo 'success';
            }

            return;
        }

        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $eventData = fromXml($xml);

        //用户发给公众号的消息转到多客服处理
        if(isset($eventData['MsgType']) && $eventData['MsgType'] != 'event'){

            if($eventData['MsgType'] == 'text' &&
                in_array($eventData['Content'], array('在吗', '你好','1','2','3','4','5','6','7','8','9','10'))){
                $this->autoAnswerMsg($eventData['FromUserName'], $eventData['Content']);
            }

            $params = array();
            $params['ToUserName'] = $eventData['FromUserName'];
            $params['FromUserName'] = $eventData['ToUserName'];
            $params['CreateTime'] = $eventData['CreateTime'];
            $params['MsgType'] = 'transfer_customer_service';

            $toDkfXml = toXml($params);
            deBugLog(array('to_xml'=>$toDkfXml), 'wxapi_transfer_customer_service');
            echo $toDkfXml;

            $endTime=microtime(true);//获取程序执行结束的时间
            $total=$endTime-$beginTime; //计算差值
            deBugLog(array('beginTime'=> $beginTime, 'endTime'=> $endTime, 'use_time_log'=>"此php文件中代码执行了 $total 秒", 'post_data'=>$GLOBALS['HTTP_RAW_POST_DATA']),  'wx_event_change_msg_use_time');
            exit;
        }

        $wxMsgListM = M('wx_msg_list');
        $msgData = array();
        $msgData['add_time'] = time();
        $msgData['scene_type'] = 'event_msg';
        if(isset($eventData['Event'])) {
            $eventKey = $eventData['EventKey'];
            switch ($eventData['Event']) {
                case 'subscribe':

                    $qrItem = S($eventKey);
                    $qrItem = (array)$qrItem;
                    //一般关注,发送欢迎关注消息
//                    sendWxMsg($eventData['FromUserName'], C('WX_SUBSCRIBE_MSG'));

                    if(!empty($qrItem) && isset($qrItem['send_msg'])){
                        //带参二维码关注
//                        $msgData['openid'] = $eventData['FromUserName'];
//                        $msgData['content'] = $qrItem['send_msg'];

                        sendWxMsg($eventData['FromUserName'], $qrItem['send_msg']);
                    } else {
                        $msgData['openid'] = $eventData['FromUserName'];
                        $msgData['content'] = C('WX_SUBSCRIBE_MSG');
                    }

                    $this->redis->sAdd($this->newSubscribeUserKey . '_' . $eventKey, $eventData['FromUserName']);
                    break;

                case 'SCAN':
                    //已关注用户扫带参二维码
                    $qrItem = S('qrscene_' . $eventKey);

                    sendWxMsg($eventData['FromUserName'], $qrItem['send_msg']);
//                    $msgData['openid'] = $eventData['FromUserName'];
//                    $msgData['content'] = $qrItem['send_msg'];
                    break;

                case 'CLICK':
                    //点击click菜单事件
                    if($eventKey == 'customer_service'){
                        //在线客服
                        sendWxMsg($eventData['FromUserName'], '小白来也！感谢帅锅妹纸@叔小白！' . "\n" .
                        '在线客服时间：周一至周日9:00~22:00。' . "\n" .
                        '您提交您的售后要求后，萝莉客服会尽快跟您主动联系，帮您解决遇到的售后问题。');

//                        $msgData['openid'] = $eventData['FromUserName'];
//                        $msgData['content'] = '小白来也！感谢帅锅妹纸@叔小白！' . "\n" .
//                            '在线客服时间：周一至周日9:00~22:00。' . "\n" .
//                            '您提交您的售后要求后，萝莉客服会尽快跟您主动联系，帮您解决遇到的售后问题。';

                    }elseif($eventKey=='cooperate'){
                        //合作建议
//                        sendWxMsg($eventData['FromUserName'], '我们接受每一位客户的批评与建议，因为这将会让您得到的服务更加满意，谢谢您对我们的支持与信任。如果您有优质产品以及商务合作的需求，请发送邮件至wangs@shipinmmm.com。');

                        $msgData['openid'] = $eventData['FromUserName'];
                        $msgData['content'] = '我们接受每一位客户的批评与建议，因为这将会让您得到的服务更加满意，谢谢您对我们的支持与信任。如果您有优质产品以及商务合作的需求，请发送邮件至wangs@shipinmmm.com。';

                    }

                    break;

                case 'unsubscribe':
                    //记录取消关注的人
                    $this->redis->sAdd($this->newUnsubscribeUserKey, $eventData['FromUserName']);
                    break;

                default:
//                    假如服务器无法保证在五秒内处理并回复，可以直接回复空串，微信服务器不会对此作任何处理，并且不会发起重试。

                    echo '';
                    return;
                    break;

            }

            if(isset($msgData['openid']) && !empty($msgData['openid'])
            && !empty($msgData['content'])){
                $wxMsgListM->add($msgData);
            }
        }

        echo '';
//        deBugLog($qrItem, 'wxapi_qrItem');
//        deBugLog($GLOBALS['HTTP_RAW_POST_DATA'], 'wxapi_event');
//
//
//        deBugLog($_REQUEST, 'testwxapi');

        $endTime=microtime(true);//获取程序执行结束的时间
        $total=$endTime-$beginTime; //计算差值
        deBugLog(array('beginTime'=> $beginTime, 'endTime'=> $endTime, 'use_time_log'=>"此php文件中代码执行了 $total 秒", 'post_data'=>$GLOBALS['HTTP_RAW_POST_DATA']),  'wx_event_msg_use_time');
        exit;
    }

    /**
     *  自动回复消息
     */
    private function autoAnswerMsg($openid, $content){

        $answer = '';
        //'在吗', '你好','1','2','3','4','5','6','7','8','9','10'
        switch($content){
            case '你好':
            case '在吗':
                $answer = C('WX_SUBSCRIBE_MSG');
                break;

            case '1':
                $answer = '叔小白是一个社交化购物商城，提供更有趣的购物体验。“大叔、逗比、吃货”的卡通形象与社交购物紧紧结合在一起，定位于年轻吃货消费群，提供进口水果、零食、牛奶、干货和生鲜等，富含时代感和卡通气息。我们的理想是为吃货服务，努力寻找最具特色的各国产品，以最实惠的价格，满足吃货们多吃好省的心愿。不要怀疑我们的找货能力，即使掘地三尺也会把好吃的找到哦！';
                break;

            case '2':
                $answer = '叔小白，每个商品都有单独购买价和拼团价。当用户通过单独购买价购买时，选择单独购买下单即可。当用户通过拼团价购买时，需要在成功支付开团后再邀请朋友参团，当参团人数达到组团规定时，订单才会生效。若人数不足则将会在组团时间结束后一个工作日内收到退款。';

                break;

            case '3':
                $answer = '拼团成功就有机会获得指定商品的X元开团券。获赠X元开团券后，从微信公众号的叔小白商城进入个人中心，在优惠券里面找到X元开团券，点击X元开团券，直接跳转到拼团商品的页面，使用X元开团券支付即可享受X元支付开团。当参团人数达到组团规定时，订单生效；参团人数未达到组团规定时，X元开团券失效，不退回，参团人员将会在组团时间结束后一个工作日内收到退款。请在有效期内使用X元开团券。';
                break;

            case '4':
                $answer = '拼团成功两次即可获得团长特权（8折技能）。获赠团长特权（8折技能）后，去开团，使用团长特权（8折技能）支付，团内成员均可以8折优惠支付参团。当参团人数达到组团规定时，订单生效；参团人数未达到组团规定时，团长特权（8折技能）失效，不退回，参团人员将会在组团时间结束后一个工作日内收到退款。每人每月限两次团长特权（8折技能）使用机会，团长特权（8折技能）月底清空。';
                break;

            case '5':
                $answer = '为了保证商品的新鲜和口感，叔小白加强了配送时效管理，采用京东全程冷链发货，所以拼团前请务必谨慎填写和确认收货人姓名、联系电话、详细的收货地址，订单提交后订单中的信息无法再变更修改，同时订单也无法取消。';
                break;
            case '6':
                $answer = '全国包邮，偏远地区除外。部分县城或岛屿地址暂时无法配送，敬请谅解。
单独购买或拼团成功后48小时内京东全程冷链发货，问题订单除外。发货后会有信息通知到微信和手机。
促销/预售等活动的发货时间视具体情况而定。';

                break;

            case '7':
                $answer = '具体快递信息，请在查询订单里点击查看物流信息自助查看或者登入京东快递官网http://jd-ex.com/，输入京东运单号查询。配送过程中，请耐心坐等美味到货。';

                break;

            case '8':
                $answer = '在您签收我们的商品时，请您仔细核对商品的名称、数量以及商品包装、破损等问题。如核对时发现以上问题，请联系客服处理售后。如果您未收到商品，快递查询显示被签收时，您可以联系配送员查询快递。';
                break;

            case '9':
                $answer = '如果您收到的商品有损坏或缺少，请您及时拍下损坏或缺少的商品，说明损坏情况，并提供您的姓名+电话+订单号给客服，以便客服快速处理您的订单。谢谢！';

                break;

            case '10':
                $answer = '在线客服时间：周一至周日9:00~22:00 ' . "\n" .
                '在您提交您的售后要求后，萝莉客服会尽快跟您主动联系，帮您解决遇到的售后问题。';

                break;
        }

        sendWxMsg($openid, $answer);

        echo '';
        exit;
    }

    /**
     *  进入发红包系统
     */
    public function sendRedPackTask() {
        $wxMsgListM = M('wx_msg_list');
        $redpackResultM = M('redpack_result');
        $groupbuyingM = M('groupbuying');
        $userWxM = new UserWxModel();
        $initChance = C('INIT_CHANCE'); //初始中奖概率,百分点   代表10%
        $recurLuckRatio = C('RECUR_LUCK_RATIO'); //重复中奖概率的百分数  代表1%
        $mostLuckNum = C('MOST_LUCK_NUM'); //每个人最多重复中奖次数
        $minMoney = 100;  //100分 RMB
        $maxMoney = 150;  //150分 RMB

        //        $wxMsgListM->startTrans();
        $msgWhere = array('status' => 1);
        //集中抽奖团
        $msgWhere['groupbuy_type'] = array('eq', 2);

        $msgList = $wxMsgListM->where($msgWhere)->group('groupbuyinst')->order('id asc')->limit(0, 10)->select();
        if(empty($msgList)) {
            echo '无需发微信红包';

            return;
        }

        $hasGroupbuySuccUsersKey = 'redpack_groupbuy_succ_uids';

        $groupbuyinstArr = array();
        foreach ($msgList as $msgItem) {
            $groupbuyinstArr[] = $msgItem['groupbuyinst'];
        }

        $upWhere = $msgWhere;
        $upWhere['groupbuyinst'] = array('in', $groupbuyinstArr);
        $wxMsgListM->where($upWhere)->save(array('status' => 3));


        foreach ($msgList as $item) {
            $redpackItem = $redpackResultM->where(array('groupbuyinst' => $item['groupbuyinst']))->find();
            if(!empty($redpackItem)) {
                //已经发过的团不再重复发红包
                $msgWhere = array('status' => 1);
                $msgWhere['groupbuy_type'] = array('eq', 2);
                $msgWhere['groupbuyinst'] = $item['groupbuyinst'];
//                $wxMsgListM->where($msgWhere)->delete();
                continue;
            }

            $groupItem = $groupbuyingM->where(array('id' => $item['groupbuyinst']))->find();
            if(empty($groupItem) || $groupItem['state'] != 2) {
                //排除未成团的订单
                continue;
            }


            $thisGroupbuySuccUsersKey = 'this_redpack_groupbuy_succ_uids_' . $item['groupbuyinst'];
            $uidsArr = json_decode($groupItem['partake'], true);
            $sponsorWxItem = $userWxM->field('openid,uid,id,nickname')->where(array('uid' => $groupItem['sponsor_id']))->find();

            //参加本团活动的用户redis集合
            foreach ($uidsArr as $uid) {
                $this->redis->sAdd($thisGroupbuySuccUsersKey, $uid);
            }

            $oldUserArr = $this->redis->sInter($hasGroupbuySuccUsersKey, $thisGroupbuySuccUsersKey);

            //全部参加过活动的用户redis集合
            //参加抽红包的uid，排除非微信用户
            $joinLuckUidsArr = array();
            foreach ($uidsArr as $uid) {
                $this->redis->sAdd($hasGroupbuySuccUsersKey, $uid);
                $userWxItem = $userWxM->getUserItem($uid);
                if(!empty($userWxItem) && !empty($userWxItem['openid'])){
                    $joinLuckUidsArr[] = $uid;
                }
            }

            //算当前团有几个中奖名额    groupbuying_reqnums
            $totalGroupUserNum = $groupItem['groupbuying_reqnums'];
            $oldUserNum = count($oldUserArr);
//            if(C('SHOW_PAGE_TRACE')){
//                //如果是调试模式,设置1半是新用户
//                $newUserNum = ceil($totalGroupUserNum/2);
//            } else {
                $newUserNum = $totalGroupUserNum - $oldUserNum;
//            }

            $newUserRatio = floor(($newUserNum / $totalGroupUserNum) * 100);

            $luckNum = ceil($totalGroupUserNum * ($initChance / 100 * $newUserRatio / 100));

            $data = array();
            //`luck_uids` text NOT NULL COMMENT '被抽中的用户id及其中奖金额',
            $data['sponsor_id'] = $groupItem['sponsor_id'];
            $data['uids'] = $groupItem['partake'];
            $data['groupbuyinst'] = $groupItem['id'];
            $data['groubuytml'] = $groupItem['groupbuying_tmlid'];
            $data['msg'] = $item['content'];
            $data['init_chance'] = $initChance;
            $data['new_user_ratio'] = $newUserRatio;
            $data['recur_luck_ratio'] = $recurLuckRatio;
            $data['add_time'] = date('Y-m-d H:i:s', time());
            //            $thisMoney = 500000;  //剩余额度, 放在redis里更新, 单位分
            $thisMoney = $this->redis->get($this->todayMaxMoneyKey);  //剩余额度, 放在redis里更新, 单位分
            if(!($luckNum > 0 && $luckNum <= $totalGroupUserNum && $thisMoney > 0)) {
                $data['status'] = 3;
                $data['log'] = '中奖人数为' . $luckNum . ' 剩余额度' . $thisMoney;
                $redpackResultM->add($data);

                $this->sendGroupbuySuccMsg($userWxM, $wxMsgListM, $sponsorWxItem['nickname'], $groupItem['groupbuying_name'], $groupItem['id'], $uidsArr);
                continue;
            }

            $luckUserArr = array();

            for ($i = 0; $i < $luckNum; $i++) {
                if($thisMoney > 100) {
                    //剩余额度大于100分再发
                    $maxLuckKey = count($joinLuckUidsArr) - 1;
                    $luckUid = $joinLuckUidsArr[rand(0, $maxLuckKey)];
                    $luckMoney = rand($minMoney, $maxMoney);
                    //保证一个用户只中一份
                    $luckUserArr[$luckUid] = array('uid' => $luckUid, 'money' => $luckMoney);
                    //扣除总额度
                    $thisMoney = $thisMoney - $luckMoney;
                    $this->redis->set($this->todayMaxMoneyKey, $thisMoney);
                }
            }

            if(empty($luckUserArr)) {
                $data['status'] = 3;
                $data['log'] = '中奖人数为' . $luckNum . ' 剩余额度' . $thisMoney . '发奖人数0';
                $redpackResultM->add($data);

                $this->sendGroupbuySuccMsg($userWxM, $wxMsgListM, $sponsorWxItem['nickname'], $groupItem['groupbuying_name'], $groupItem['id'], $uidsArr);
                continue;
            }

            $sendRedPackResult = array();
            foreach ($luckUserArr as $luckUser) {
                //TODO 控制重复中奖的概率及数量, 重复中奖的概率是 中奖次数的 1/100 的幂，最多中奖3次
                $uid = $luckUser['uid'];
                $money = $luckUser['money'];
                $msg = $item['content'];

                //某个用户中奖次数key
                $userLuckNumKey = 'user_luck_num_' . $uid;
                $userLuckNum = $this->redis->get($userLuckNumKey);
                if(empty($userLuckNum)) {
                    $userLuckNum = 0;
                }

                //如果一个用户的中奖次数大于等于允许的最多中奖次数则不再发奖
                if(!($userLuckNum < $mostLuckNum)) {
                    //如果调度模式不限制
//                    if(!C('SHOW_PAGE_TRACE')){
                        continue;
//                    }
                }

                //如果是中过奖的用户,则要再次抽奖
                $reLuck = true;
                if($userLuckNum > 0) {
                    //要每次抽都在允许的百分比值之内
                    for ($i = 0; $i < $userLuckNum; $i++) {
                        $recurLuckValue = rand(1, 100);
                        if($recurLuckValue > $recurLuckRatio) {
                            $reLuck = false;
                            break;
                        }
                    }

                    if(!$reLuck) {
                        //如果调度模式不限制
//                        if(!C('SHOW_PAGE_TRACE')){
                            continue;
//                        }
                    }
                }

                if(!empty($uid) && !empty($msg) && $money > 0) {
                    $userWxItem = $userWxM->where('uid = ' . $uid)->find();
                    if(!empty($userWxItem)) {
                        $sendRedPackResult[] = $this->sendRedPack($userWxItem['openid'], $money);
                        $this->redis->incr($userLuckNumKey);  //中奖次数加1
                    }
                } else {

                }
            }

            $data['luck_uids'] = json_encode($luckUserArr);
            $data['status'] = 2;
            $data['log'] = '中奖人数为' . $luckNum . ' 剩余额度' . $thisMoney . '发奖人数' . count($luckUserArr) . json_encode($sendRedPackResult);
            $redpackResultM->add($data);

            //发完红包后发成团消息
            $this->sendGroupbuySuccMsg($userWxM, $wxMsgListM, $sponsorWxItem['nickname'], $groupItem['groupbuying_name'], $groupItem['id'], $uidsArr);
        }
        //                $wxMsgListM->commit();
    }


    /**
     *  助力发红包, 可以配置是否团长必中红包, 及参团者中奖概率, 默认至少有一个参团的人会中奖
     */
    public function zhuLiSendRedPackTask() {
        $wxMsgListM = M('wx_msg_list');

        $userWxM = new UserWxModel();
        $minMoney = 100;  //100分 RMB
        $maxMoney = 150;  //150分 RMB

        $msgWhere = array('status' => 1);

        $msgWhere['groupbuy_type'] = array('eq', 3);
        $msgWhere['scene_type'] = array('eq', 'redpack');

        $msgList = $wxMsgListM->where($msgWhere)->order('id asc')->limit(0, 30)->select();
        echo $wxMsgListM->getLastSql();
        if(empty($msgList)) {
            echo '无需发微信红包';

            return;
        }

        $msgArr = array();
        foreach ($msgList as $msgItem) {
            $msgArr[] = $msgItem['id'];
        }

        $upWhere = $msgWhere;
        $upWhere['id'] = array('in', $msgArr);
        $wxMsgListM->where($upWhere)->save(array('status' => 3));

        $thisMoney = $this->redis->get($this->todayMaxMoneyKey);  //剩余额度, 放在redis里更新, 单位分

        $sendRedPackResult = array();
        $luckMoney = 0;
        foreach($msgList as $item){
            if($thisMoney > 100) {
                //剩余额度大于100分再发
                //扣除总额度
                $luckMoney = rand($minMoney, $maxMoney);
                $thisMoney = $thisMoney - $luckMoney;
                $this->redis->set($this->todayMaxMoneyKey, $thisMoney);
            } else {
                echo '<br/>余额不足<br/>';
            }

            if(!empty($item['uid']) && $luckMoney > 0) {
                $userWxItem = $userWxM->where('uid = ' . $item['uid'])->find();
                if(!empty($userWxItem)) {
                    $sendRedPackResult[] = $this->sendRedPack($userWxItem['openid'], $luckMoney);
                }
            } else {
                echo '<br/>用户不存在或中奖金额为0<br/>' . $luckMoney . '<br/>';
                var_dump($item);
            }
        }

        var_dump($msgList);
        echo '<br/>======<br/>';
        var_dump($sendRedPackResult);
    }

    /**
     * 发送抽奖后的成团通知
     * @param $userWxM
     * @param $wxMsgListM
     * @param $sponsorNickname
     * @param $productName
     * @param $groupbuyinst
     * @param $uidsArr
     */
    private function sendGroupbuySuccMsg($userWxM, $wxMsgListM, $sponsorNickname, $productName, $groupbuyinst, $uidsArr) {
        $groupbuySuccWhere = array();
        $groupbuySuccWhere['uid'] = array('in', $uidsArr);
        $groupbuySuccWhere['status'] = 1;
        $groupbuySuccWhere['groupbuyinst'] = $groupbuyinst;
        $groupbuySuccWhere['scene_type'] = 'groupbuy_succ';
        $wxUserList = $userWxM->field('openid,uid,id,nickname')->where($groupbuySuccWhere)->select();

        $userWxM->where($groupbuySuccWhere)->save(array('status' => 3));

        if(!empty($wxUserList)) {
            foreach ($wxUserList as $wxUserItem) {
                //发成团消息模板
                $params = array('url' => C('FRONT_SITE_URL') . '/groupbuy/joinGroupBuy/' . $groupbuyinst);
                $params['product_name'] = $productName;
                $params['nickname'] = $sponsorNickname;
                $wxMsgResult = sendWxTmplMsg($wxUserItem['openid'], 'groupbuy_succ', $params);
                $where = array();
                $where['uid'] = $wxUserItem['uid'];
                $where['groupbuyinst'] = $groupbuyinst;
                $where['groupbuy_type'] = 2;
                $where['scene_type'] = 'groupbuy_succ';

                if($wxMsgResult['errmsg'] == 'ok') {
//                    $wxMsgListM->where($where)->delete();
                } else {
                    $saveData = array();
                    $saveData['result'] = $wxMsgResult['errmsg'];
                    $saveData['status'] = 2;
                    $wxMsgListM->where($where)->save($saveData);
                }
            }
        }
    }

    /**
     *  给指定用户发现金红包
     */
    private function sendRedPack($openid, $amount = 100) {
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        $data = array();
        $data['nonce_str'] = 'b6cb06c668a0e21ab1733505533cd8b5';  //随机字符串

        $billNoSortKey = 'now_wx_redpack_billno_sort_key';
        $nowBillNoSort = $this->redis->get($billNoSortKey);
        if(empty($nowBillNoSort)){
            $nowBillNoSort = 1;
            $this->redis->set($billNoSortKey, 1);
        }

        $this->redis->incr($billNoSortKey);

        //生成10位数，不足前面补0
        $sortNum=sprintf("%010d", $nowBillNoSort);
        $data['mch_billno'] = C('WX_PAY_MCHID') . date('Ymd', time()) . $sortNum;  //商户订单号 组成：mch_id+yyyymmdd+10位一天内不能重复的数字
        $data['mch_id'] = C('WX_PAY_MCHID');  //微信支付分配的商户号
        $data['wxappid'] = C('WX_APP_ID');  //公众账号appid
        $data['send_name'] = '叔小白商城';  //红包发送者名称
        $data['re_openid'] = $openid;  //用户openid
        $data['total_amount'] = $amount;  //付款金额，单位分
        $data['total_num'] = '1';  //红包发放总人数
        $data['wishing'] = '叔小白祝新年快乐!'; // '感谢您参加叔小白新年百万红包送祝福活动，祝您新年快乐！';  //红包祝福语
        $data['client_ip'] = $_SERVER['REMOTE_ADDR'];  //调用接口的机器Ip地址
//        $data['client_ip'] = '192.168.1.15';  //调用接口的机器Ip地址
        $data['act_name'] = '叔小白红包'; // '叔小白新年抢红包';  //猜灯谜抢红包活动
        $data['remark'] = '每团必中，快来抢！'; // '每团必中，快来抢！';  //猜越多得越多，快来抢！

        $data['sign'] = $this->getWxPaySign($data);  //签名

        $data['ssl_cert'] = C('WX_PAY_SSL_CERT');
        $data['ssl_key'] = C('WX_PAY_SSL_KEY');

        //        $xml = toXml($data);
        deBugLog($data, 'sendRedPack-data');
        $result = getCurlRequestXML($url, $data);
        deBugLog($result, 'sendRedPack');

        return $result;
    }

    public function getWxPaySign($data) {
        //KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
        //设置地址：https://pay.weixin.qq.com/index.php/account/api_cert
        $key = '6a50ea01b41e4239a991f6419d19c0b3';
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string = $this->toUrlParams($data);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);

        return $result;
    }

    /**
     *  计算开奖的团中实际新用户的人数
     */
    public function calRealNewUserRatioTask(){
        $redpackResultM = M('redpack_result');
        $where = array();
        $where['status'] = 2;
        $list = $redpackResultM->where($where)->limit(0, 50)->select();
        if(empty($list)){
            return;
            exit;
        }

        $userWxM = new UserWxModel();

        $idArr = array();
        foreach($list as $item){
            $idArr[] = $item['id'];
        }

        $saveWhere = $where;
        $saveWhere['id'] = array('in', $idArr);
        $redpackResultM->where($saveWhere)->save(array('status' => 4));

        foreach($list as $item){
            $redpackMoney = 0;
            $luckUserArr = json_decode($item['luck_uids'], true);

            $luckNewUserNum = 0;
            $groupNewUserNum = 0;
            if(!empty($luckUserArr)){
                foreach($luckUserArr as $luckItem){
                    $redpackMoney = $redpackMoney + $luckItem['money'];

                    $userWxItem = $userWxM->getUserItem($luckItem['uid']);
                    if($this->redis->sIsMember($this->newSubscribeUserKey, $userWxItem['openid'])){
                        $luckNewUserNum++;
                    }
                }

                $redpackMoney = $redpackMoney / 100;
            }

            $groupUserArr = json_decode($item['uids'], true);
            foreach($groupUserArr as $uid){

                $userWxItem = $userWxM->getUserItem($uid);
                if($this->redis->sIsMember($this->newSubscribeUserKey, $userWxItem['openid'])){
                    $groupNewUserNum++;
                }
            }

            $data = array();
            $data['total_money'] = $redpackMoney;
            $data['real_luck_new_user_num'] = $luckNewUserNum;
            $data['luck_user_num'] = count($luckUserArr);
            $data['real_group_new_user_num'] = $groupNewUserNum;
            $data['group_total_user_num'] = count($groupUserArr);
            $redpackResultM->where(array('id'=>$item['id']))->save($data);
        }
    }

    private function echoMsgToDkf(){
//        消息转发到多客服
//如果公众号处于开发模式，普通微信用户向公众号发消息时，微信服务器会先将消息POST到开发者填写的url上，如果希望将消息转发到多客服系统，则需要开发者在响应包中返回MsgType为transfer_customer_service的消息，微信服务器收到响应后会把当次发送的消息转发至多客服系统。 示例代码
        $data = array();
        $data['ToUserName'] = '';
        $data['FromUserName'] = '';
        $data['CreateTime'] = '';
        $data['MsgType'] = 'transfer_customer_service';

        $xml = toXml($data);
        echo $xml;
        exit;
//        <xml>
//     <ToUserName><![CDATA[touser]]></ToUserName>
//     <FromUserName><![CDATA[fromuser]]></FromUserName>
//     <CreateTime>1399197672</CreateTime>
//     <MsgType><![CDATA[transfer_customer_service]]></MsgType>
// </xml>
//
//        参数说明
//参数 	是否必须 	描述
//ToUserName 	是 	接收方帐号（收到的OpenID）
//FromUserName 	是 	开发者微信号
//CreateTime 	是 	消息创建时间 （整型）
//MsgType 	是 	transfer_customer_service



    }

    /**
     * 格式化参数格式化成url参数
     */
    public function toUrlParams($data) {
        $buff = "";
        foreach ($data as $k => $v) {
            if($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");

        return $buff;
    }

    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }


    /**
     *  初始化带参二维码数据到redis中, 免得每次发信息都要从数据表中取
     */
    public function initQrTicket() {
        $id = I('id', 0);
        $wxQrLimitSceneM = M('wx_qr_limit_scene');
        $where = array();
        $where['ticket'] = array('neq', '');
        if($id > 0) {
            $where['id'] = array('eq', $id);
        }
        $qrList = $wxQrLimitSceneM->where($where)->limit(0, 1000)->select();
        foreach ($qrList as $item) {
            S('qrscene_' . $item['id'], json_encode($item), 864000000);
        }
    }

    public function getTokenStr() {
        echo md5('18R9!ke88');

        echo $_SERVER['HTTP_HOST'];

        $str = 'a:5:{s:9:"signature";s:40:"ab5b6d76f5bf82acf4ee6efa3c00157f776b4f01";s:7:"echostr";s:19:"7541262790047034877";s:9:"timestamp";s:10:"1453190580";s:5:"nonce";s:9:"874564181";s:5:"_URL_";a:2:{i:0;s:5:"WxApi";i:1;s:5:"event";}}';
        $params = unserialize($str);
        var_dump($params);
    }

    public function getTmpMsg() {
        sendWxTmplMsg();
    }

    public function testRedpack() {
        //$openid = 'oZ2Bkvwcl6ESefGrg_7hotsal_gc'; //dachuan
//        $openid = 'oZ2Bkv1dWQDJM6tDCRW0C3fUah-I'; //zzz
        $openid = 'o3IuTvxC2k37_cr-h27gjA50ztJ8'; //chris
        $this->sendRedPack($openid);
    }

    /**
     *  初始化额度等红包信息
     */
    public function initRedpack() {
        $todayMaxMoney = C('TODAY_MAX_MONEY');

        //当天的可用红包余额
        $todayMaxMoneyKey = $this->todayMaxMoneyKey;
        //初始红包余额历史记录
        $todayMaxMoneyHistoryKey = $this->todayMaxMoneyHistoryKey;

        if(!($todayMaxMoney > 0)) {
            return;
        }

        $todayMaxMoneyHistoryArr = $this->redis->get($todayMaxMoneyHistoryKey);
        if(empty($todayMaxMoneyHistoryArr)) {
            $todayMaxMoneyHistoryArr = array();
            $todayMaxMoneyHistoryArr[] = array('time' => date('Y-m-d H:i:s', time()), 'money' => $todayMaxMoney, 'old_money' => 0);
        } else {
            $oldMoney = $this->redis->get($todayMaxMoneyKey);
            $todayMaxMoneyHistoryArr[] = array('time' => date('Y-m-d H:i:s', time()), 'money' => $todayMaxMoney, 'old_money' => $oldMoney);
        }

        $this->redis->set($todayMaxMoneyKey, $todayMaxMoney);
        $this->redis->set($todayMaxMoneyHistoryKey, $todayMaxMoneyHistoryArr);
    }

    public function refreshMiddlePageTask(){
        $keyArr = array();
        $keyArr[] = 'weixin_middle_page_url_key1';
        $keyArr[] = 'weixin_middle_page_url_key2';
        $keyArr[] = 'weixin_middle_page_url_key3';
        $keyArr[] = 'weixin_middle_page_url_key4';

//        $groupTmplIdKey = 'group_tmpl_id_key';
//        $groupTmplId = $this->redis->get($groupTmplIdKey);
        $groupTmplId = C('WX_MIDDLE_PAGE_GROUP_TMP_ID');
        $limitRatio = C('WX_MIDDLE_PAGE_LIMIT_RATIO');
        $groupbuyingTmlM = M('groupbuying_tml');
        $groupbuyingM = M('groupbuying');
        $groupTmpl = $groupbuyingTmlM->where(array('id' => $groupTmplId))->find();

        if(empty($groupTmpl)){
            echo '请配置自动跳转的团购模板';
            exit;
        }

        $reqnums = $groupTmpl['groupbuying_reqnums'];
        //只找参团人数是在xx比例以下的
        $limitNum  = floor($reqnums * $limitRatio);

        $where = array();
        $where['groupbuying_nownums'] = array('elt', $limitNum);
        $where['groupbuying_tmlid'] = $groupTmplId;
        $where['state'] = 1;
        $groupbuyingList = $groupbuyingM->where($where)->limit(100)->select();

        echo $groupbuyingM->getLastSql() . '<br/>';
        if(empty($groupbuyingList)){
            echo '没有符合条件的实例';
            exit;
        }

        $toUrl = C('FRONT_SITE_URL') . '/groupbuy/joinGroupBuy/';
        $countList = count($groupbuyingList);

        var_dump($groupbuyingList);

        foreach($keyArr as $key => $keyValue){
            $item = $groupbuyingList[rand(0, $countList -1)];
            $setValue = $toUrl . $item['id'];
            echo 'key==' . $keyValue . '==value=' . $setValue;
            $this->redis->set($keyValue, $setValue);
        }
    }
}