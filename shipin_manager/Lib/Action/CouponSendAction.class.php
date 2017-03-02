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
 * Class CouponTemplAction
 *  发优惠券管理
 */
class CouponSendAction extends CommonAction{

    public function index(){

        $where = 'id>10000';//小于10000的为机器人


        $user_id = I('id', 0);
        if($user_id != 0)
        {
            $where = 'id='.$user_id;
        }

        $user_name = I('name', '');
        if(!empty($user_name))
        {
            $where = "username like '%".$user_name."%'";
        }

        $user_mobile = I('mobile', '');
        if(!empty($user_mobile))
        {
            $where = 'mobile ='.$user_mobile;
        }




        $userM = M('user');
        $count = $userM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $userM->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();


//        var_dump($list);
        $this->assign('list', $list);

        $this->assign('page', $strPage);
        $this->display('index');
    }

    public function sendcoupon(){
        $user_id = I('id', 0);
        if($user_id <= 0)
            return;

        $where = 'id='.$user_id;//小于10000的为机器人

        $userM = M('user');
        $UserInfo = $userM->where($where)->select();

        $this->assign('userinfo', $UserInfo[0]);
        $this->display('sendcoupon');
    }

    public function someUserSend(){
        $this->display('someusersend');
    }

    public function dosomeUserSend(){

        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileFix = explode('.', $_FILES['import_file']['name']);
        $fileName = md5($_FILES['import_file']['name'] . time()) . '.' . $fileFix[1];
        $uploadFile = $savePath . $fileName;
        move_uploaded_file($_FILES['import_file']['tmp_name'], $uploadFile);
        $result = $this->csv_to_array(file_get_contents($uploadFile));
        if(!empty($result))
        {
            $array_tml_ids = array_column($result,'groupbuy_tml_id');
            $coupon_tml_ids = array_column($result,'coupon_tml_id');
            $order_states = array_column($result,'order_state');
            $exclude_user_order_state_list = array_column($result,'exclude_user_order_state');
        }


        if(count($coupon_tml_ids)==0 || count($array_tml_ids)==0 || count($order_states)==0)
        {
            echo '数据不能为空';
            return;
        }

        //根据订单状态来发优惠券
        $groubuyorderM = M('groupbuying_order');
        $orderM = M('order');

        foreach ($array_tml_ids as $index_key=>$groupbuy_tml_id) {
            if (!empty($groupbuy_tml_id)) {

                $order_state = $order_states[$index_key];
                $coupon_tml_id = $coupon_tml_ids[$index_key];
                $exclude_user_order_state = $exclude_user_order_state_list[$index_key];

                $ready_send_uids = array();
                $pagesize = 1000;
                //
                $groupbuyorder_where = array(
                    'groupbuyingtml_id'=>$groupbuy_tml_id,
                    'state'=>2,
                );

                $alltml_ordernamelist = $groubuyorderM->where($groupbuyorder_where)->order("id ASC")->field('order_name')->select();
                $exclude_ordername_array = array_column($alltml_ordernamelist,'order_name');
                $exclude_order_where = array();
                $exclude_order_where['order_name'] = array('in', $exclude_ordername_array);
                $exclude_order_where['operation_id'] = $exclude_user_order_state;

                $exclude_user_list=$orderM->where($exclude_order_where)->order("id ASC")->field('uid')->select();
                $exclude_user_list = array_column($exclude_user_list,'uid');

                $count = $groubuyorderM->where($groupbuyorder_where)->count();
                for($i = 0;$i<$count;$i+=$pagesize)
                {
                    $row_begin = $i;
                    $row_end = $i + $pagesize;
                    if($row_end > $count)
                    {
                        $row_end = $count;
                    }
                    $list = $groubuyorderM->where($groupbuyorder_where)->order("id ASC")->limit($row_begin . ',' . $row_end)->select();

                    if(!empty($list)){
                        $ordername_array = array_column($list,'order_name');
                        $order_where = array();
                        $order_where['order_name'] = array('in', $ordername_array);
                        $order_where['operation_id'] = $order_state;//13;//已成团待处理

                        $order_list=$orderM->where($order_where)->order("id ASC")->select();
                        if(!empty($order_list)) {
                            $uid_array = array_column($list, 'uid');

                            foreach ($uid_array as $uid_key=>$user_id) {
                                if(in_array($user_id,$exclude_user_list))
                                {
                                    continue;
                                }

                                if(!in_array($user_id,$ready_send_uids))
                                {
                                    $ready_send_uids[] = $user_id;
                                    //生成优惠券给用户
                                    $this->giveUserCouponByTml($user_id,$coupon_tml_id);
                                }

                            }
                        }
                    }
                }
            }
        }
    }

    public function doSend(){

        $user_id = I('userid', 0);
        $usermobile = I('usermobile', 0);

        $coupon_tml_id = I('give_coupon_tml_id_0', 0);
        $lifttime = I('lifttime', 0);

        //生成优惠券给用户
        $this->giveUserCouponByTml($user_id,$coupon_tml_id);

    }

    //根据模板生成优惠券发给用户(此接口只能在api站内使用)
    public function giveUserCouponByTml($uid,$coupontmlid,$card_number='0')
    {

        $where = "id=".$coupontmlid;
        $coupontmlM = M('coupon_tml');
        $resTml = $coupontmlM->where($where)->select();
        $resTml = $resTml[0];

        $createtime = time();
        $couponendtime = $createtime + $resTml['lifetime']*24*3600;
        $today = date("Y-m-d");
        $endday = date("Y-m-d",$couponendtime);

        //插入新数据
        $insertcoupon_data = array(
            'uid'=>$uid,
            'card_number'=>$card_number,
            'card_money'=>$resTml['money'],
            'is_sent'=>1,
            'content'=>" ",
            'time'=>$today,
            'to_date'=>$endday,
            'channel'=>" ",
            'direction'=>$resTml['description'],
            'coupon_type'=>$resTml['coupon_type'],
            'groupbuy_permission'=>$resTml['permission_id'],
            'groupbuy_limit'=>$resTml['islimit_tml'],
            'groupbuy_limit_value'=>$resTml['limit_value'],
            'ext_limit_value'=>$resTml['ext_limit_value'],
            'groupbuy_only'=>$resTml['isgroupbuy_only'],
            'use_target'=>$resTml['use_target'],
            'sms_send_showtext'=>$resTml['sms_send_showtext'],
            'coupon_tml'=>$resTml['id'],
        );

        $table = 'card';
        //插入新的
        $cardM = M('card');
        $coupon_id = $cardM->add($insertcoupon_data);
        if($coupon_id==0){
            //$coupon_id=0;
            echo '失败';
        }
        else
        {
            //存入微信消息通知列表
            $wxMsgData = array(
                'uid' => $uid,
                'content' => '系统安慰奖：'.$resTml['sms_send_showtext'].'一张，感谢您的支持。',
                'add_time' => time(),
                'scene_type'=>'coupon_get'

            );

            $wx_msg_listM = M('wx_msg_list');
            $wx_msg_listM->add($wxMsgData);

            echo '成功';
        }
        return  $coupon_id;
    }

    /**
     *  选择关联的优惠券模板
     */
    public function selectJson(){
        $where = array();

        $couponTmlM = M('coupon_tml');
        $count = $couponTmlM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $couponTmlM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        if(!empty($list)){
            foreach($list as $key => $item){
                $list[$key]['isgroupbuy_only'] = 1 == $item['isgroupbuy_only'] ? '<span class="red">是</span>' : '<span class="green">否</span>';
                $list[$key]['coupon_type'] = 1 == $item['coupon_type'] ? '<span class="red">团购</span>' : '<span class="green">普通</span>';
                $list[$key]['use_target'] = 1 == $item['use_target'] ? '<span class="red">团长</span>' : '<span class="green">不限</span>';

            }
        }

        $result  = array('data' => $list, 'key' => array('id','sms_send_showtext' ,'money', 'description', 'lifetime'), 'th'=>array('id','显示名称', '金额(元)', '描述', '有效期(天)'), 'page' => $strPage);
        echo json_encode($result);
    }

} 