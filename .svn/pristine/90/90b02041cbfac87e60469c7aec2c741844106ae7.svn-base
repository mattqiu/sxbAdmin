<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/3/18
 * Time: 下午4:33
 */
class ShareAnalyseAction {

    /**
     * 将redis分享队列中的数据取到数据表中
     */
    public function index(){
        import('@.ORG.RedisObj');
        $redis = new RedisObj();
        $wxShareKey = 'weixin_share_log_list';
        $listSize = $redis->lSize($wxShareKey);

        if(!($listSize > 0)){
            return;
        }

        $wxShareLogM = M('wxshare_log');
//        $listSize=3;
        for($i=0; $i<$listSize; $i++){
            $data = array();
            $logStr = $redis->rPop($wxShareKey);
            $data['log_str'] = $logStr;
            $data['add_time'] = date('Y-m-d H:i:s', time());
            $wxShareLogM->add($data);

            echo '<br/>' . $logStr . '<br/>';
        }

    }

    /**
     *  分析log数据，更新到数据表中
     */
    public function analyse(){
        $wxShareLogM = M('wxshare_log');
        $groupbuyingOrderM = M('groupbuying_order');
        $groupbuyingM = M('groupbuying');
        $userM = M('user');

        $where = array();
        $where['first_uid'] = 0;
        $logList = $wxShareLogM->where($where)->order('id asc, last_up_time asc')->limit(500)->select();

        if(empty($logList)){
            return;
        }

        foreach($logList as $item){
            $logStr = $item['log_str'];
            $logArr = array();

            $typeArr = explode('#', $logStr);
            //增加解析分享时间
            if(strpos($typeArr[0], '_') > 0){
                $timeArr = explode('_', $typeArr[0]);
                $logArr['share_time'] = date('Y-m-d H:i:s', $timeArr[0]);

                $typeArr[0] = $timeArr[1];
            }

            if(count($typeArr) == 2){
                $typeKeyArr = explode(':', $typeArr[0]);
                $uidArr = explode('-', str_replace('u', '', trim($typeArr[1], '-')));
                switch($typeKeyArr[0]){
                    case 'groupbuy_paySucc':
                        //groupbuy_paySucc:1603172003361907#u639582-
                        $groupbuyOrderName = $typeKeyArr[1];

                        $groupOrder = $groupbuyingOrderM->where(array('groupbuy_order_name' => $groupbuyOrderName))->find();
                        if(empty($groupOrder)){
                            continue;
                        }

                        $logArr['groupbuying_id'] = $groupOrder['groupbuying_id'];
                        $logArr['groupbuy_tml_id'] = $groupOrder['groupbuyingtml_id'];
                        $logArr['order_name'] = $groupOrder['order_name'];


                        break;

                    case 'detail_groupbuy':
                        //模板详情页分享
                        $logArr['groupbuy_tml_id'] = $typeKeyArr[1];
                        break;

                    case 'groupbuy':
                        //参团页分享
                        //groupbuy:96568#u693889-u653469-u653454-
                        $groupbuyingId = $typeKeyArr[1];

                        $groupbuying = $groupbuyingM->field('groupbuying_tmlid')->where(array('id' => $groupbuyingId))->find();
                        if(empty($groupbuying)){
                            continue;
                        }

                        $logArr['groupbuying_id'] = $groupbuyingId;
                        $logArr['groupbuy_tml_id'] = $groupbuying['groupbuying_tmlid'];

                        break;
                }


            } else {
                //没有#分隔的类型标识,一般是分享首页
            }

            $logArr['first_uid'] = empty($uidArr[0]) ? 0 : $uidArr[0];
            $logArr['sec_uid'] = empty($uidArr[1]) ? 0 : $uidArr[1];
            $logArr['third_uid'] = empty($uidArr[2]) ? 0 : $uidArr[2];
            $logArr['last_up_time'] = date('Y-m-d H:i:s', time());
            $logArr['relay_num'] = count($uidArr);

            if(!empty($uidArr[0])){
                $firstUser = $userM->field('username')->where(array('id'=>$uidArr[0]))->find();
                $logArr['first_uname'] = $firstUser['username'];
            }

            if(!empty($uidArr[1])){
                $secUser = $userM->field('username')->where(array('id'=>$uidArr[1]))->find();
                $logArr['sec_uname'] = $secUser['username'];
            }

            if(!empty($uidArr[2])){
                $thirdUser = $userM->field('username')->where(array('id'=>$uidArr[2]))->find();
                $logArr['third_uname'] = $thirdUser['username'];
            }

            $wxShareLogM->where(array('id'=>$item['id']))->save($logArr);
        }

    }

    public function testData1(){
        #332776
        $wxShareLogM = M('wxshare_log');
        for($i=0; $i < 30; $i++){
            $data['log_str'] = 'groupbuy_paySucc:1603180714018997#u332776-';
            $data['add_time'] = date('Y-m-d H:i:s', time());
            $wxShareLogM->add($data);
        }

        for($i=0; $i < 13; $i++){
            $data['log_str'] = 'groupbuy_paySucc:1603191318256212#u332256-';
            $data['add_time'] = date('Y-m-d H:i:s', time());
            $wxShareLogM->add($data);
        }

        for($i=0; $i < 27; $i++){
            $data['log_str'] = 'groupbuy_paySucc:1603191801189546#u332535-';
            $data['add_time'] = date('Y-m-d H:i:s', time());
            $wxShareLogM->add($data);
        }
    }

    /**
     * 同步中奖用户的信息
     */
    public function synLuckUidKey(){
        $wxshareLuckUserM = M('wxshare_luck_user');
        $groupbuyingM = M('groupbuying');
        $groupbuyingOrderM = M('groupbuying_order');
        $orderM = M('order');
        $orderAddressM = M('order_address');
        $areaM = M('area');

        $luckList = $wxshareLuckUserM->where(array('luck_key' => ''))->limit(500)->select();
        echo $wxshareLuckUserM->getLastSql() . '<br/><br/>';
        if(empty($luckList)){
            return;
        }

        foreach($luckList as $item){
            $where = array();
            $where['state'] = 2;
            $where['uid'] = $item['uid'];
            $where['groupbuyingtml_id'] = 136;
            $where['pay_money'] = array('gt', 1);
            $groupOrder = $groupbuyingOrderM->where($where)->find();
            if(empty($groupOrder)){
                continue;
            }

            $whereGroupbuying = array();
            $whereGroupbuying['id'] = $groupOrder['groupbuying_id'];
            $groupbuying = $groupbuyingM->where($whereGroupbuying)->find();

            $uidArr = json_decode($groupbuying['partake'], true);

            $data = array();
            foreach($uidArr as $key => $uid){
                if($uid == $item['uid']){
                    $data['luck_key'] = $key;
                }
            }

            $data['groupbuying_id'] = $groupOrder['groupbuying_id'];
            $data['groupbuy_tml_id'] = $groupOrder['groupbuyingtml_id'];
            $data['order_name'] = $groupOrder['order_name'];
            $data['rec_name'] = $groupOrder['recv_name'];
            $data['rec_mobile'] = substr($groupOrder['recv_phone'], 0, 3) . 'XXXX' . substr($groupOrder['recv_phone'], -4);


            $orderId = $orderM->field('id')->where(array('order_name' => $groupOrder['order_name']))->find();
            $orderAddress = $orderAddressM->where(array('order_id' => $orderId['id']))->find();

            $province = $areaM->where(array('id' => $orderAddress['province']))->find();
            $city = $areaM->where(array('id' => $orderAddress['city']))->find();
            $county = $areaM->where(array('id' => $orderAddress['area']))->find();

            $data['rec_area'] = $province['name'] . $city['name'] . $county['name'];

            $wxshareLuckUserM->where(array('id' => $item['id']))->save($data);
            echo $wxshareLuckUserM->getLastSql() . '<br/>';
        }
    }

    /**
     *  按订单号抽试吃用户
     */
    public function openLuck(){
        $wxshareLuckUserM = M('wxshare_luck_user');
        $luckList = $wxshareLuckUserM->where(array('state' => 0))->limit(500)->order('id desc')->select();

        if(empty($luckList)){
            return;
        }

        $userWxM = new UserWxModel();

        $orderM = M('order');
        $groupbuyOrderM = M('groupbuying_order');
        $wxMsgListM = M('wx_msg_list');
//        $groupbuyingM = M('groupbuying');

        foreach($luckList as $item){
            $orderM->where(array('order_name' => $item['order_name']))->save(array('operation_id' => 10));

            $userWx = $userWxM->getUserItem($item['uid']);

            $msgData = array();
            $msgData['uid'] = $item['uid'];
            $msgData['openid'] = $userWx['openid'];
            $msgData['content'] = '恭喜小主人品爆发，获得小白家幸运试吃资格，叔会第一时间安排发货，收到记得评价哦!';
            $msgData['add_time'] = time();
            $msgData['groupbuyinst'] = $item['groupbuying_id'];
            $msgData['groubuytml'] = $item['groupbuy_tml_id'];
            $msgData['scene_type'] = 'luckdraw_msg';

            $wxMsgListM->add($msgData);

            $wxshareLuckUserM->where(array('id' => $item['id']))->save(array('state' => 1));
        }
    }

    /**
     *   同步分享次数到用户亲密度表
     */
    public function sysnShareNum(){
        $wxshareLogM = M('wxshare_log');
        $where = array();
        $where['up_share_num'] = '0000-00-00 00:00:00';
        $list = $wxshareLogM->where($where)->limit(1000)->order('up_share_num ASC')->select();
        if(empty($list)){
            return;
        }

        $userFriendIntimateM = M('user_friend_intimate');

        foreach($list as $item){
            $logStrArr = explode('#', $item['log_str']);
            $uidArr = explode('u', $logStrArr[1]);
            $lastUid = trim($uidArr[count($uidArr) -1], '-');

            $result = $userFriendIntimateM->where(array('uid'=>$lastUid))->setInc('share_num');
            if(!$result){
                $hasUser = $userFriendIntimateM->where(array('uid' =>$lastUid))->find();
                if(empty($hasUser)){
                    $userFriendIntimateM->add(array('uid'=>$lastUid, 'share_num'=>1));
                }
            }

            $wxshareLogM->where(array('id' => $item['id']))->save(array('up_share_num'=> date('Y-m-d H:i:s')));
        }
    }

    public function synLastShareUid(){
        $wxshareLogM = M('wxshare_log');
        $where = array();
        $where['last_uid'] = 0;
        $list = $wxshareLogM->where($where)->limit(1000)->select();
        if(empty($list)){
            return;
        }

        foreach($list as $item){
            $lastUid = $this->getLastUid($item['log_str']);
            $wxshareLogM->where(array('id' => $item['id']))->save(array('last_uid'=>$lastUid));
            echo $wxshareLogM->getLastSql();
        }
    }

    private function getLastUid($logStr){
        $logStrArr = explode('#', $logStr);
        $uidArr = explode('u', $logStrArr[1]);
        $lastUid = trim($uidArr[count($uidArr) -1], '-');

        return $lastUid;
    }
}