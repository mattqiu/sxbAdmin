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
 * Class CouponAction
 *  优惠券管理
 */
class CouponAction extends CommonAction{

    public function index(){
        $where = array();

        $isUsed = I('is_used');
        $uid = I('user_name');
        $isSent = I('is_sent');
        $time = I('time');
        $cardNumber = I('card_number');
        if(!empty($uid)){
            $where['uid'] = $uid;
        }

        if($isUsed > 0){
            $where['is_used'] = $isUsed == 1 ? 1 : 0;
        }

        if($isSent > 0){
            $where['is_sent'] = $isSent == 1 ? 1 : 0;
        }

        if(!empty($time)){
            $where['time'] = array('gt', $time);
        }

        if(!empty($cardNumber)){
            $where['card_number'] = $cardNumber;
        }

        $cardM = M('card');
        $count = $cardM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $cardM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        if(!empty($list)){
            $channelConf = array(0=>'全站', 1=>'官网', 2=>'app', 3=>'wap');
            foreach($list as $key => $item){
                $list[$key]['is_used'] = 1 == $item['is_used'] ? '<span class="red">是</span>' : '<span class="green">否</span>';
                $list[$key]['is_sent'] = 1 == $item['is_used'] ? '<span class="red">是</span>' : '<span class="green">否</span>';
                $list[$key]['coupon_type'] = 1 == $item['coupon_type'] ? '<span class="red">团购</span>' : '<span class="green">普通</span>';
                $list[$key]['use_target'] = 1 == $item['use_target'] ? '<span class="red">限团长</span>' : '<span class="green">不限</span>';

                //0-全站1-官网2-app3-wap
                $itemArr = unserialize($item['channel']);

                if(is_array($itemArr)){
                    $channelStr = '';
                    foreach($itemArr as $value){
                        $channelStr  .= $channelConf[$value] . '<br/>';
                    }
                    $list[$key]['channel'] = $channelStr;
                } else {
                    $list[$key]['channel'] = $channelConf[0];
                }

            }
        }

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }

    public function create(){
        $this->display();
    }

    public function doCreate(){
        $create_num = I('create_num', 0);
        $money = I('money', 0);
        $group_tml_id = I('group_tml_id', 0);
        $time = I('time', '');
        $to_date = I('to_date', '');
        $remarks = I('remarks', '');
        $uids = trim(I('uids', ''));
        $direction = I('direction', '');
        $groupbuy_only = I('groupbuy_only', 1);
        $is_sent = I('is_sent', 0);
        $coupon_type = I('coupon_type', 1);
        $groupbuy_permission = I('groupbuy_permission', '');
        $channel = $_REQUEST['channel'];
        $use_target = I('use_target', 0);


        if($create_num > 0 && !empty($to_date)){
            for($i=0; $i < $create_num; $i++){
                $cardM = M('card');
                $data = array();
                $data['card_number'] = $this->createCouponNo();
                $data['card_money'] =  $money;
                $data['card_discount'] =  1;
                $data['is_used'] =  0;
                $data['is_sent'] =  $is_sent;
                $data['remarks'] =  $remarks;
                $data['time'] =  $time;
                $data['to_date'] =  $to_date;
                $data['max_use_times'] =  1;
                $data['direction'] =  $direction;
                $data['groupbuy_only'] =  $groupbuy_only;
                $data['coupon_type'] =  $coupon_type;
                $data['groupbuy_permission'] =  $groupbuy_permission;
                $data['groupbuy_limit_value'] =  $group_tml_id;
                $data['use_target'] = $use_target;

                if($group_tml_id != 0){
                    $data['groupbuy_limit'] = 1;
                }

                if(!empty($channel)){
                    $data['channel'] = serialize($channel);
                }

                $uidsArr = explode(',', $uids);
                if(!empty($uids) && !empty($uidsArr)){
                    foreach($uidsArr as $uid){
                        $uid = intval($uid);
                        if($uid > 0){
                            $data['uid'] = $uid;
                            $cardM->add($data);
                        } else {
                            $cardM->add($data);
                        }
                    }
                } else {
                    $cardM->add($data);
                }
            }
        }

        redirect('/Coupon/index');
    }

    public function createCouponNo(){

        $couponNo = 'sp' . substr(time(), 1, 6) . rand(1000, 9999);
        $cardM = M('card');
        $is_had = $cardM->where('card_number = "' . $couponNo . '"')->find();
        while(!empty($is_had)){
            $is_had = $cardM->where('card_number = "' . $couponNo . '"')->find();
        }

        return $couponNo;
    }


    /**
     *  选择关联的团购模板
     */
    public function selectGroupTml(){

    }

    /**
     *  选择团购对应的权限
     */
    public function selectCouponPermission(){

    }
} 