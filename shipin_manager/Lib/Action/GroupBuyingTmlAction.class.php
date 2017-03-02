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
 *  团购管理
 * Class GroupBuyingAction
 */
class GroupBuyingTmlAction extends CommonAction{

    /**
     *  所有团购模板
     */
    public function index(){

        $where = array();
        $where['distributor_id'] = array('eq', '0');

        $groupBuyingTmlM = new GroupbuyingTmlModel();
        $count = $groupBuyingTmlM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $groupBuyingTmlM->where($where)->relation(true)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();

        if(!empty($list)){
            $groupBuyingConf = C('GROUP_BUYING');
            foreach($list as $key => $item){
                $list[$key]['condition_type'] = $groupBuyingConf['condition_type'][$item['condition_type']];
                $list[$key]['state'] = $groupBuyingConf['groupbuying_tml_state'][$item['state']];

                if(!empty($item['old_user_tmlids']))
                {
                    $tmlids = json_decode($item['old_user_tmlids']);
                    $tmlids=implode(',',$tmlids);
                    $list[$key]['old_user_tmlids'] = $tmlids;
                }

            }
        }

        $this->assign('list', $list);

        $this->assign('page', $strPage);
        $this->display();
    }

    /**
     *  新建一个团购模板
     */
    public function add(){
        $this->display('add');
    }

    /**
     *  保存团购模板
     */
    public function save(){
        $id = I('id', 0);
        $product_id = I('product_id', 0);
        $groupbuying_name = I('groupbuying_name', '');
        $groupbuying_des = I('groupbuying_des', '');
        $groupbuying_price = I('groupbuying_price', 0);
        $sidesplicing_price = I('sidesplicing_price', 0);
        $groupbuying_reqnums = I('groupbuying_reqnums', 0);
        $separatebuy_price = I('separatebuy_price', 0);
        $condition_type = I('condition_type', 0);
        $condition_num = I('condition_num', 0);
        $state = I('state', 0);
        $salenum = I('salenum', 0);
        $postage = I('postage', 0);
        $begin_selltime_date = I('begin_selltime_date', '');
        $begin_selltime_time = I('begin_selltime_time', '');
        $lifetime = I('lifetime', 0) * 60;
        $original_price = I('original_price', 0);

        $canuse_groupbuy_permission = I('canuse_groupbuy_permission', 0);
        $canuse_groupbuy_coupon = I('canuse_groupbuy_coupon', 0);
        $drop_group_id = I('drop_group_id', 0);
        $use_target = I('use_target', 0);
        $canbuy_times = I('canbuy_times',0);
        $canbuy_open_times = I('canbuy_open_times',0);
        $canbuy_partake_times = I('canbuy_partake_times',0);

        $b_drop_group_id = I('b_drop_group_id', 0);//开（参）团掉落
        $is_begin_give_leader = I('is_begin_give_leader',0);//团长是否给开团掉落
        $after_drop_group_id = I('after_drop_group_id', 0);//领奖掉落


        //以券买券活动指定掉落
        $req_return_coupons = I('req_return_coupons', 0);
        $only_coupon_pay = I('only_coupon_pay', 0);
        $is_coupons_drop_coupons = I('is_coupons_drop_coupons', 0);
        $use_coupon_tml_ids = $_REQUEST['use_coupon_tml_id'];
        $c2c_drop_group_ids = $_REQUEST['c2c_drop_group_id'];

        //
        $can_leader_recv = I('can_leader_recv', 0);
        $leader_recv_discount = I('leader_recv_discount', 0);

        $open_buytype = I('open_buytype', 0);


        $c2c_data=array();
        for($i=0;$i<count($use_coupon_tml_ids);$i++)
        {
            if(empty($use_coupon_tml_ids[$i]))
                continue;

            $mutex_one = array(
                'coupon_tml_id'=>$use_coupon_tml_ids[$i],
                'drop_group_id'=>$c2c_drop_group_ids[$i]
            );
            $c2c_data[] = $mutex_one;
        }
        //=============================================

        $groupbuyopen_type = I('groupbuyopen_type',0);//0表示用户开团,1表示系统开团
        //系统开团内容
        $systemauto_opentype = I('systemauto_opentype',0);//系统开团类型
        $systemauto_day_time = I('systemauto_day_time',0);//每天开团时间
        $systemauto_week_time = I('systemauto_week_time',0);//每周周几时间
        $systemauto_mouth_time = I('systemauto_mouth_time',0);//每月哪天时间
        $systemauto_choose_num = I('systemauto_choose_num',0);//成团后抽几个人
        $systemauto_choose_leader_must = I('systemauto_choose_leader_must',0);//成团后是否必定抽中团长
        $systemauto_opentime_after_succ = I('systemauto_opentime_after_succ',0);//成团后多久结算
        $systemauto_is_succ_nowin_refund = I('systemauto_is_succ_nowin_refund',0);//成团后没有中奖，是否退款。
        //===========================
        //助力团(拼团类型)
        $ismemberprice_diff = I('ismemberprice_diff',0);//是否成员价格与团长不一致
        $member_price = I('member_price',0);//成员价格是多少
        $is_join_create_order = I('is_join_create_order',0);//参团是否生成订单
        $groupbuy_type = I('groupbuy_type',0);//拼团类型
        //===========================
        //集中抽奖参数
        $focus_luckdraw_winning_no = I('focus_luckdraw_winning_no','');//中奖码（没开奖就是空）
        $wx_erweima_id_start = I('wx_erweima_id_start',0);//微信群二维码开始id
        $wx_erweima_id_end = I('wx_erweima_id_end',0);//微信群二维码结束id
        $wx_erweima_id_now = I('wx_erweima_id_now',0);//微信群二维码现在id
        $can_open_afer_luckdraw = I('can_open_afer_luckdraw',0);//中奖后能开团几次
        $can_join_afer_luckdraw = I('can_join_afer_luckdraw',0);//中奖后能参团几次
        //===========================
        //老带新内容
        $is_olduser_bring_new = I('is_olduser_bring_new',0);//是否老带新
        $old_user_num = I('old_user_num',0);//老用户能有几人
        $new_user_num = I('new_user_num',0);//新用户能有几人
        $old_user_type = I('old_user_type',0);//老用户类型
        $old_user_tmlids = I('old_user_tmlids','');//指定的受限团的tmlid为老用户。
        if(!empty($old_user_tmlids))
        {
            $old_user_tmlids = explode(",",$old_user_tmlids);
            $old_user_tmlids = json_encode($old_user_tmlids);
        }
        //===========================

        if($product_id > 0 && !empty($groupbuying_name)){

            $data = array();
            $data['product_id'] = $product_id;
            $data['groupbuying_name'] = $groupbuying_name;
            $data['groupbuying_des'] = $groupbuying_des;
            $data['groupbuying_price'] = $groupbuying_price;
            $data['sidesplicing_price'] = $sidesplicing_price;
            $data['groupbuying_reqnums'] = $groupbuying_reqnums;
            $data['separatebuy_price'] = $separatebuy_price;
            $data['condition_type'] = $condition_type;
            $data['condition_num'] = $condition_num;
            $data['state'] = $state;
            $data['salenum'] = $salenum;
            $data['postage'] = $postage;
            $data['lifetime'] = $lifetime;
            $data['original_price'] = $original_price;
            $data['canuse_groupbuy_permission'] = $canuse_groupbuy_permission;
            $data['canuse_groupbuy_coupon'] = $canuse_groupbuy_coupon;
            $data['drop_group_id'] = $drop_group_id;
            $data['use_target'] = $use_target;
            $data['canbuy_times'] = $canbuy_times;
            $data['canbuy_partake_times'] = $canbuy_partake_times;
            $data['canbuy_open_times'] = $canbuy_open_times;

            //以券买券
            $data['req_return_coupons'] = $req_return_coupons;
            $data['only_coupon_pay'] = $only_coupon_pay;
            $data['is_coupons_drop_coupons'] = $is_coupons_drop_coupons;
            $data['c_drop_c_data'] = json_encode($c2c_data);

            $data['opentype'] = $groupbuyopen_type;
            $data['systemauto_opentype'] = $systemauto_opentype;
            $data['systemauto_day_time'] = $systemauto_day_time;
            $data['systemauto_week_time'] = $systemauto_week_time;
            $data['systemauto_mouth_time'] = $systemauto_mouth_time;
            $data['systemauto_choose_num'] = $systemauto_choose_num;
            $data['systemauto_choose_leader_must'] = $systemauto_choose_leader_must;
            $data['systemauto_opentime_after_succ'] = $systemauto_opentime_after_succ;
            $data['systemauto_is_succ_nowin_refund'] = $systemauto_is_succ_nowin_refund;

            $data['ismemberprice_diff'] = $ismemberprice_diff;
            $data['member_price'] = $member_price;
            $data['is_join_create_order'] = $is_join_create_order;
            $data['groupbuy_type'] = $groupbuy_type;
            $data['focus_luckdraw_winning_no'] = $focus_luckdraw_winning_no;
            $data['wx_erweima_id_start'] = $wx_erweima_id_start;//微信群二维码开始id
            $data['wx_erweima_id_end'] = $wx_erweima_id_end;//微信群二维码结束id
            $data['wx_erweima_id_now'] = $wx_erweima_id_now;//微信群二维码现在id

            //老带新
            $data['is_olduser_bring_new'] = $is_olduser_bring_new;
            $data['old_user_num'] = $old_user_num;
            $data['new_user_num'] = $new_user_num;
            $data['old_user_type'] = $old_user_type;
            $data['old_user_tmlids'] = $old_user_tmlids;

            //开参团掉落，领奖掉落
            $data['begin_drop_group_id'] = $b_drop_group_id;
            $data['is_begin_give_leader'] = $is_begin_give_leader;
            $data['after_drop_group_id'] = $after_drop_group_id;

            //是否可以团长收货
            $data['can_leader_recv'] = $can_leader_recv;
            $data['leader_recv_discount'] = $leader_recv_discount;
            $data['open_buytype'] = $open_buytype;

            //中奖后能开团几次
            //中奖后能参团几次
            $data['can_open_afer_luckdraw'] = $can_open_afer_luckdraw;
            $data['can_join_afer_luckdraw'] = $can_join_afer_luckdraw;




            if(!empty($begin_selltime_date) && !empty($begin_selltime_time)){
                $data['begin_selltime'] = strtotime($begin_selltime_date . ' ' . $begin_selltime_time);
            }

            $groupbuyingTmlM = M('groupbuying_tml');
            if($id> 0){
                $groupbuyingTmlM->where('id = ' . $id)->save($data);
            } else {
                $groupbuyingTmlM->add($data);
            }

            $this->success('操作成功', U('GroupBuyingTml/index'));
        } else {
            $this->error('参数出错请重试', U('GroupBuyingTml/index'));
        }
//        redirect(U('GroupBuyingTml/index'));
    }

    public function edit(){
        $id = I('id', 0);
        $groupbuyingTmlM = M('groupbuying_tml');
        $item = $groupbuyingTmlM->where('id =' . $id)->find();

        if(!($item['begin_selltime'] > 0)){
            $item['begin_selltime'] = time();
        }
        $item['begin_selltime'] = date('Y-m-d H:i:s', $item['begin_selltime']);
        $beginTimeArr = explode(' ', $item['begin_selltime']);
        $item['begin_selltime_date'] = $beginTimeArr[0];
        $item['begin_selltime_time'] = $beginTimeArr[1];
        $item['lifetime'] = $item['lifetime'] / 60;

        if(!empty($item['old_user_tmlids']))
        {
            $tmlids = json_decode($item['old_user_tmlids']);
            $tmlids=implode(',',$tmlids);
            $item['old_user_tmlids'] = $tmlids;
        }

        $array_c_drop_c_data = array();
        if(!empty($item['c_drop_c_data']))
        {
            $array_c_drop_c_data = json_decode($item['c_drop_c_data'],true);
        }

        $this->assign('c2c_count', count($array_c_drop_c_data));
        $this->assign('c2c_data', $array_c_drop_c_data);
        $this->assign('item', $item);
        $this->display();
    }

    /**
     *  下架
     */
    public function close(){
        $id = I('id', 0);

        if($id > 0){
                $groupBuyingTmlM = M('groupbuying_tml');
            $groupBuyingTmlM->where('id = ' . $id)->save(array('state' => 2));
        }

        redirect(U('GroupBuyingTml/index'));
    }

    public function del(){
        $id = I('id', 0);
        if($id > 0){
            $groupbuyingTmlM = M('groupbuying_tml');
            $groupbuyingTmlM->where('id = ' . $id)->delete();
        }
        redirect(U('GroupBuyingTml/index'));
    }

    public function selectJson(){
        $where = '';
        $groupBuyingTmlM = new GroupbuyingTmlModel();
        $count = $groupBuyingTmlM->where($where)->count();
        $page = new Page($count, 10);
        $strPage = $page->show();
        $list = $groupBuyingTmlM->where($where)->relation(true)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();

        if(!empty($list)){
            $groupBuyingConf = C('GROUP_BUYING');
            foreach($list as $key => $item){
                $list[$key]['condition_type'] = $groupBuyingConf['condition_type'][$item['condition_type']];
                $list[$key]['state'] = $groupBuyingConf['groupbuying_tml_state'][$item['state']];
            }
        }

        $result  = array('data' => $list, 'key' => array('id', 'groupbuying_name'), 'th'=>array('id', '团购名'), 'page' => $strPage);
        echo json_encode($result);
    }

    public function clear_userlimit()
    {
        $id = I('id', 0);
        if($id == 0)
        {
            echo '错误的操作';
            return;
        }

        $action_limitM = M('user_action_limit_record');

        $where = 'type like "partake_groupbuy" and value like "'.$id.'"';
        $res = $action_limitM->where($where)->delete();
        if($res>0)
        {
            echo '清除成功';
        }
        else
        {
            echo '没有可清除的数据';
        }

    }

    public function clear_succ_userlimit()
    {
        $id = I('id', 0);
        if($id == 0)
        {
            echo '错误的操作';
            return;
        }

        $groupbuy_limitM = M('user_groupbuy_limit_buy_record');

        $where = 'groupbuy_tml_id = '.$id;
        $res = $groupbuy_limitM->where($where)->delete();
        if($res>0)
        {
            echo '清除成功';
        }
        else
        {
            echo '没有可清除的数据';
        }


    }

    public function getGroupbuyTmlInfo(){

        $tmlId = I('tml_id', 0);
        $groupbuyingTmlM = M('groupbuying_tml');
        $item = $groupbuyingTmlM->where('id =' . $tmlId)->find();

        echo json_encode($item);
    }

} 