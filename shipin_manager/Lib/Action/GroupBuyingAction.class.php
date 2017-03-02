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
class GroupBuyingAction extends CommonAction{

    /**
     *  所有团购
     */
    public function index(){
        $where = '';

        $id = I('id');
        if($id){
            $where['id'] = array('eq',$id);
        }

        $groupBuyingM = new GroupbuyingModel();
        $count = $groupBuyingM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $groupBuyingM->where($where)->relation(true)
            ->limit($page->firstRow . ',' . $page->listRows)->order("groupbuying_begintime desc")->select();
        if(!empty($list)){
            $userM = M('user');
            $groupBuyingConf = C('GROUP_BUYING');
            foreach($list as $key => $item){
                $list[$key]['condition_type'] = $groupBuyingConf['condition_type'][$item['condition_type']];
                $list[$key]['state'] = $groupBuyingConf['groupbuying_state'][$item['state']];

                if(!empty($item['user_head'])){
                    $list[$key]['user_head'] = unserialize($item['user_head']);
                }

                if(!empty($item['partake'])){
                    $userIds = implode(',', json_decode($item['partake'], true));
                    $userList = $userM->where('id IN (' . $userIds . ')')->select();
                    $list[$key]['partake_list'] = $userList;
                }

                $list[$key]['groupbuying_begintime'] = date('y-m-d H:i:s', $item['groupbuying_begintime']);
                $list[$key]['groupbuying_endtime'] = date('y-m-d H:i:s', $item['groupbuying_endtime']);
                $list[$key]['create_time'] = date('y-m-d H:i:s', $item['create_time']);
            }
        }

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }

    /**
     *  查询指定开团日期和状态的团购
     */
    public function getgroupbuy_condition(){
//         dump($_POST);
        $time = I('limit_date_From');
        if($time) {
            $opentime_begin = strtotime(I('limit_date_From', 0) . ' ' . I('limit_time_From', 0));
            $opentime_end = strtotime(I('limit_date_To', 0) . ' ' . I('limit_time_To', 0));
        }
        $tmp_id = I('tmp_id');

        $groupbuystate = I('groupbuystate', 0);
        $timetype = I('timetype', 0);
        $where = '';

        if($opentime_begin != 0)
        {
            if($timetype == 0)
            {
                $where = $where."create_time>=".$opentime_begin." AND create_time<=".$opentime_end;
            }
            else
            {
                $where = $where."groupbuying_endtime>=".$opentime_begin." AND groupbuying_endtime<=".$opentime_end;
            }

        }

        if($groupbuystate != 0)
        {
            if(!empty($where))
                $where = $where." AND state =".$groupbuystate;
            else
                $where = "state =".$groupbuystate;
        }

        if($tmp_id){
            if(empty($where)){
                $where = $where."  groupbuying_tmlid = ".$tmp_id;
            }else{
                $where = $where." AND groupbuying_tmlid = ".$tmp_id;
            }

            $order = "groupbuying_nownums desc";
        }else{
            $order = "create_time desc";
        }
//        dump($where);
        $groupBuyingM = new GroupbuyingModel();
        $count = $groupBuyingM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $groupBuyingM->where($where)->relation(true)
            ->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
//             echo $groupBuyingM->getLastSql();
        if(!empty($list)){
            $userM = M('user');
            $groupBuyingConf = C('GROUP_BUYING');
            foreach($list as $key => $item){
                $list[$key]['condition_type'] = $groupBuyingConf['condition_type'][$item['condition_type']];
                $list[$key]['state'] = $groupBuyingConf['groupbuying_state'][$item['state']];

                if(!empty($item['user_head'])){
                    $list[$key]['user_head'] = unserialize($item['user_head']);
                }

                if(!empty($item['partake'])){
                    $userIds = implode(',', json_decode($item['partake'], true));
                    $userList = $userM->where('id IN (' . $userIds . ')')->select();
                    $list[$key]['partake_list'] = $userList;
                }

                $list[$key]['groupbuying_begintime'] = date('y-m-d H:i:s', $item['groupbuying_begintime']);
                $list[$key]['groupbuying_endtime'] = date('y-m-d H:i:s', $item['groupbuying_endtime']);
                $list[$key]['create_time'] = date('y-m-d H:i:s', $item['create_time']);
                $list[$key]['groupbuying_endtime'] = date('y-m-d H:i:s', $item['groupbuying_endtime']);
            }
        }

        if($opentime_begin == 0)
        {

        }
        else
        {
            $datebegin=date('Y-m-d',$opentime_begin);
            $dateend=date('Y-m-d',$opentime_end);

            $choosetime = $datebegin." - ".$dateend;
            $this->assign('choosetime',$choosetime);
        }


        $this->assign('post',$_POST);
        $this->assign('timetype',$timetype);
        $this->assign('groupbuystate',$groupbuystate);
        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display("index");
    }

    public function joinindex()
    {
//        dump($_GET);
        $opentime_begin = strtotime(I('limit_date_From',0).' '.I('limit_time_From',0));
        $opentime_end = strtotime(I('limit_date_To',0).' '.I('limit_time_To',0));
        $tmp_id = I('tmp_id');
        //$nowdate=time();
        // $opentime_begin = I('opentime_begin', 0);
        // $opentime_end = I('opentime_end', 0);
        $groupbuystate = 1;//进行中
        $timetype = I('timetype', 0);
        $where = '';

        if($opentime_begin != 0)
        {
            if($timetype == 0)
            {
                $where = $where."create_time>=".$opentime_begin." AND create_time<=".$opentime_end;
            }
            else
            {
                $where = $where."groupbuying_endtime>=".$opentime_begin." AND groupbuying_endtime<=".$opentime_end;
            }

        }

        if($groupbuystate != 0)
        {
            if(!empty($where))
                $where = $where." AND state =".$groupbuystate;
            else
                $where = "state =".$groupbuystate;
        }
         if($tmp_id){
             if(empty($where)){
                 $where = $where." groupbuying_tmlid = ".$tmp_id;
             }else{
                 $where = $where." AND groupbuying_tmlid = ".$tmp_id;
             }
        }

        $groupBuyingM = new GroupbuyingModel();
        $count = $groupBuyingM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $groupBuyingM->where($where)->relation(true)
            ->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();
//    echo $groupBuyingM->getLastSql();

        if(!empty($list)){
            $userM = M('user');
            $groupBuyingConf = C('GROUP_BUYING');
            foreach($list as $key => $item){
                $list[$key]['condition_type'] = $groupBuyingConf['condition_type'][$item['condition_type']];
                $list[$key]['state'] = $groupBuyingConf['groupbuying_state'][$item['state']];

                if(!empty($item['user_head'])){
                    $list[$key]['user_head'] = unserialize($item['user_head']);
                }

                if(!empty($item['partake'])){
                    $userIds = implode(',', json_decode($item['partake'], true));
                    $userList = $userM->where('id IN (' . $userIds . ')')->select();
                    $list[$key]['partake_list'] = $userList;
                }

                $list[$key]['groupbuying_begintime'] = date('y-m-d H:i:s', $item['groupbuying_begintime']);
                $list[$key]['groupbuying_endtime'] = date('y-m-d H:i:s', $item['groupbuying_endtime']);
                $list[$key]['create_time'] = date('y-m-d H:i:s', $item['create_time']);
            }
        }

        if($opentime_begin == 0)
        {

        }
        else
        {
            $datebegin=date('Y-m-d',$opentime_begin);
            $dateend=date('Y-m-d',$opentime_end);

            $choosetime = $datebegin." - ".$dateend;
            $this->assign('choosetime',$choosetime);
        }


        $this->assign('timetype',$timetype);
        $this->assign('groupbuystate',$groupbuystate);
        $this->assign('list', $list);
        $this->assign('get',$_GET);
        $this->assign('page', $strPage);
        $this->display("joinindex");
    }
    public function pingtuan()
    {
        $id = I('id', 0);
        $where = 'id='.$id;
        $groupBuyingM = new GroupbuyingModel();
        $list = $groupBuyingM->where($where)->select();
        $this->assign('item', $list[0]);
        $this->display("joinedit");
    }

    public function addjoinnum()
    {
        $id = I('id', 0);
        if($id == 0) {
            echo '更新失败';
            return;
        }

        $addnum = I('addnum', 0);

        $where = 'id<10000';//机器人

        $groupBuyingM = new GroupbuyingModel();
        $userM = M('user');
        $count = $userM->where($where)->count();

        if($count<$addnum)
        {
            echo '更新失败';
            return;
        }

        $wheregroupbuy='id='.$id;
        $groupbuylist = $groupBuyingM->where($wheregroupbuy)->select();
        $allnum = $groupbuylist[0]['groupbuying_nownums'] + $addnum;
        if($allnum >= $groupbuylist[0]['groupbuying_reqnums'])
        {
            echo '更新失败,加入人数超过团的限制，至少要留一个空位置。';
            return;
        }

        $randuseridarray=array();
        $maxiduser = $userM->where('id<10000')->order('id desc')->limit(0 . ',' . 1)->select();
        $findcount=0;
        for($inum=0;$inum<$addnum;$inum++)
        {
            $ranid = rand(1,$maxiduser[0]['id']);

            if(in_array($ranid,$randuseridarray))
            {
                $inum--;//随机的id有错，再随机一次；
                continue;
            }

            $whereid = 'id='.$ranid;
            //先查询用户

            $userlist = $userM->where($whereid)->select();
            if(empty($userlist))
            {
                $findcount = $findcount+1;
                if($findcount>999)
                {
                    //找了1000次都没找到一个用户，继续下一个
                }
                else
                {
                    $inum--;//随机的id有错，再随机一次；
                }
            }
            else
            {
                $findcount = 0;

                $randuseridarray[]=$ranid;

                $wheregroupbuy='id='.$id;
                $groupbuylist = $groupBuyingM->where($wheregroupbuy)->select();

                $nownum = $groupbuylist[0]['groupbuying_nownums'] + 1;
                if($nownum < $groupbuylist[0]['groupbuying_reqnums'])//至少留一个空位置，如果没有真实用户进来，这个团就不管了。
                {
                    $partake = json_decode($groupbuylist[0]['partake']);

                    if(!in_array($userlist[0]['id'],$partake))
                    {
                        array_push($partake,$userlist[0]['id']);//插入元素

                        $data = array();
                        $data['groupbuying_nownums']= $nownum;
                        $data['partake']=json_encode($partake);

                        $res = $groupBuyingM->where($wheregroupbuy)->save($data);
                        if ($res > 0)
                            echo $userlist[0]['id'].'加团成功';
                        else
                            echo $userlist[0]['id'].'加团失败';
                    }

                }

            }
        }

    }

    public function choujiangindex()
    {
        $this->display("choujiangindex");
    }

    public function savechoujiang()
    {
        $focus_luckdraw_winning_no = I('focus_luckdraw_winning_no', '');
        $focus_luckdraw_winning_groupbuyinsts = I('focus_luckdraw_winning_groupbuyinsts', '');

        if(strlen($focus_luckdraw_winning_no)==0 || strlen($focus_luckdraw_winning_groupbuyinsts)==0)
        {
            echo '数据不能为空';
            return;
        }

        //要输出的结果
        $print_result_array = array();
        $all_user_ids = array();
        $all_groupbuy_leader_ids=array();
        $get_luckdraw_userData = array();//要发微信消息的获奖用户
        $unget_luckdraw_userData = array();//要发微信消息的未获奖用户
        //=======================================

        $focus_luckdraw_winning_groupbuyinst_array = explode(",",$focus_luckdraw_winning_groupbuyinsts);
        if(!empty($focus_luckdraw_winning_groupbuyinst_array))
        { 
            $collect_groupbuy_inst_ids = array();
            foreach($focus_luckdraw_winning_groupbuyinst_array as $groupbuy_inst_id)
            {
                if(!empty($groupbuy_inst_id))
                {
                    $collect_groupbuy_inst_ids[] = $groupbuy_inst_id;
                }
            }

            //保存中奖结果
            $data = array();
            $data['focus_luckdraw_winning_no'] =  $focus_luckdraw_winning_no;
            $data['is_focus_luckdraw_winning'] = 1;

            $groupBuyingM = new GroupbuyingModel();
            $where = array();
            $where['id'] = array('in', $collect_groupbuy_inst_ids);
            $groupBuyingM->where($where)->save($data);

            //修改中奖者的订单状态
            $groupbuyinst_list = $groupBuyingM->where($where)->select();
            $need_change_order_data = array();
            //找到用户uid
            foreach($groupbuyinst_list as $groupbuy_inst_key=>$groupbuy_inst)
            {
                $partake_array = json_decode($groupbuy_inst['partake'],true);
                if(empty($partake_array))
                {
                    continue;
                }
                foreach($partake_array as $partakekey=>$uid)
                {
                    if($focus_luckdraw_winning_no == $partakekey)
                    {
                        $need_change_order_data[] = array(
                            'groupbuy_inst_id'=>$groupbuy_inst['id'],
                            'uid'=>$uid,
                        );

                        //把中奖的人的微信信息
                        $get_luckdraw_userData[] = array(
                            'groupbuy_inst_id'=>$groupbuy_inst['id'],
                            'groupbuy_tml_id'=>$groupbuy_inst['groupbuying_tmlid'],
                            'uid'=>$uid,
                        );
                    }
                    else
                    {
                        //把未中奖的人的微信信息
                        $unget_luckdraw_userData[] = array(
                            'groupbuy_inst_id'=>$groupbuy_inst['id'],
                            'groupbuy_tml_id'=>$groupbuy_inst['groupbuying_tmlid'],
                            'uid'=>$uid,
                        );
                    }
                }


            }
            //修改订单数据
            $groubuyorderM = M('groupbuying_order');
            $orderM = M('order');
            foreach($need_change_order_data as $ncod_key=>$ncod_value)
            {
                $groupbuyorder_where = array(
                    'uid'=>$ncod_value['uid'],
                    'groupbuying_id'=>$ncod_value['groupbuy_inst_id'],
                    'state'=>2,
                );
                $groupbuy_order_list = $groubuyorderM->where($groupbuyorder_where)->select();
                if(!empty($groupbuy_order_list))
                {
                    //修改数据
                    $groupbuy_order = $groupbuy_order_list[0];


                    $order_where=array(
                        'order_name'=>$groupbuy_order['order_name'],
                    );
                    $data_order=array();
                    $data_order['operation_id'] = 10;
                    $orderM->where($order_where)->save($data_order);

                    //把要输出的数据整合在一起
                    $array_uid_groupbuy_and_order = array();
                    foreach($groupbuyinst_list as $groupbuy_inst_key=>$groupbuy_inst)
                    {
                        if($groupbuy_inst['id'] == $groupbuy_order['groupbuying_id'])
                        {
                            $array_uid_groupbuy_and_order['uid'] = $ncod_value['uid'];
                            $array_uid_groupbuy_and_order['groupbuy_order'] = $groupbuy_order;
                            $array_uid_groupbuy_and_order['groupbuy_inst'] = $groupbuy_inst;

                            if(!in_array($ncod_value['uid'],$all_user_ids))
                            {
                                $all_user_ids[]=$ncod_value['uid'];
                            }
                            $print_result_array[] = $array_uid_groupbuy_and_order;
                        }
                    }
                    //======================
                }
            }


        }

        $user_result_datas = array();
        $csv_ouput_datas = array();

        if(!empty($all_user_ids))
        {
            //合并数组
            $all_user_ids = array_merge($all_user_ids, $all_groupbuy_leader_ids);

            $userM = M('user');
            $user_where = array();
            $user_where['id'] = array('in', $all_user_ids);
            $user_list = $userM->where($user_where)->select();

            $user_map=array();
            if(!empty($user_list))
            {
                foreach($user_list as $user_key=>$user_value)
                {
                    $user_map[$user_value['id']] = $user_value;
                }
            }

            foreach($print_result_array as $print_result_key=>$print_result_value)
            {
                $luck_user = array();
                $luck_user['uid'] = $print_result_value['uid'];
                $luck_user['order_name'] = $print_result_value['groupbuy_order']['order_name'];
                $luck_user['groupbuy_inst_id'] = $print_result_value['groupbuy_inst']['id'];

                //收件人信息
                $luck_user['recvname'] = $print_result_value['groupbuy_order']['recv_name'];
                $luck_user['recv_phone'] = $print_result_value['groupbuy_order']['recv_phone'];
                $luck_user['recv_address'] = $print_result_value['groupbuy_order']['recv_address'];

                //昵称
                $luck_user['nick_name'] = $user_map[$print_result_value['uid']]['username'];
                $luck_user['groupbuy_leader_nick_name'] = $user_map[$print_result_value['groupbuy_inst']['sponsor_id']]['username'];
                $luck_user['succ_time'] = date("Y-m-d H:i:s",$print_result_value['groupbuy_inst']['groupbuying_endtime']);

                $user_result_datas[] = $luck_user;

                //用于写入csv
                $csv_data = array();
                $csv_data[] = $print_result_value['uid'];
                $csv_data[] = $print_result_value['groupbuy_order']['order_name'];
                $csv_data[] = $print_result_value['groupbuy_inst']['id'];

                //收件人信息
                $csv_data[] = $print_result_value['groupbuy_order']['recv_name'];
                $csv_data[] = $print_result_value['groupbuy_order']['recv_phone'];
                $csv_data[] = $print_result_value['groupbuy_order']['recv_address'];

                //昵称
                $csv_data[] = $user_map[$print_result_value['uid']]['username'];
                $csv_data[] = $user_map[$print_result_value['groupbuy_inst']['sponsor_id']]['username'];
                $csv_data[] = date("Y-m-d H:i:s",$print_result_value['groupbuy_inst']['groupbuying_endtime']);

                $csv_ouput_datas[] = $csv_data;
                //=============================

            }
        }

        $nowdate = date('Y-m-d');
        $mouth = substr($nowdate,5,2);
        $day = substr($nowdate,8,2);

        //$html = '<table>';
        foreach($user_result_datas as $user_result_key=>$user_result_value)
        {
            //$html = $html.'<tr>'.'<td>'.$user_result_value['uid'].',</td><td>'.$user_result_value['order_name'].',</td><td>'.$user_result_value['groupbuy_inst_id'].',</td>';
            //$html = $html.'<td>'.$user_result_value['recvname'].',</td><td>'.$user_result_value['recv_phone'].',</td><td>'.$user_result_value['recv_address'].',</td>';
            //$html = $html.'<td>'.$user_result_value['nick_name'].',</td><td>'.$user_result_value['groupbuy_leader_nick_name'].',</td><td>'.$user_result_value['succ_time'].',</td>';
            //$html = $html.'</tr>';


            //$this->sendsmsMsg($user_result_value['recv_phone'],'恭喜你获得叔小白商城'.$mouth.'月'.$day.'日送出的88元豪华水果礼盒一个，请通过微信进入叔小白商城查询您的订单发货信息。回复TD退订');

        }
        //$html = $html.'</table>';
        //echo $html;
        //echo '提交成功';

        //发微信消息
        foreach($get_luckdraw_userData as $a_key=>$a_value)
        {
            $user_ids_get = array();
            $user_ids_get[] = $a_value['uid'];
            $strText = '恭喜小主人品爆发，获得小白家幸运试吃资格，叔会第一时间安排发货，收到记得评价哦!';
            $this->send_WX_MSG_LuckdrawMsgs($user_ids_get,$strText,$a_value['groupbuy_inst_id'],$a_value['groupbuy_tml_id']);
        }

        /*
         * 未被抽中的用户不需要通知 chris 16-3-22
        foreach($unget_luckdraw_userData as $a_key=>$a_value)
        {
            $user_ids_unget = array();
            $user_ids_unget[] = $a_value['uid'];
            $strText = '很抱歉你没有获得试吃资格';
            $this->send_WX_MSG_LuckdrawMsgs($user_ids_unget,$strText,$a_value['groupbuy_inst_id'],$a_value['groupbuy_tml_id']);
        }*/


        //下载文件
        $str_today = $mouth.'_'.$day;
        header ( 'Content-Type: application/vnd.ms-excel' );
        header ( 'Content-Disposition: attachment;filename="'.$str_today.'抽奖数据.csv"' );
        header ( 'Cache-Control: max-age=0' );
        $file = fopen('php://output', 'a');
        foreach($csv_ouput_datas as $csv_ouput_key=>$csv_ouput_value)
        {
            fputcsv($file,$csv_ouput_value);
        }
        fclose($file);

    }

    public function returnMoney_LuckDraw()
    {
        $this->display("choujiangtuikuanindex");
    }

    public function DoreturnMoney_LuckDraw()
    {
        $ld_groupbuy_inst_id = I('ld_groupbuy_inst_id', 0);
        $return_by_inst_state_btn = I('return_by_inst_state_btn', 0);

        $ld_groupbuy_tml_id = I('ld_groupbuy_tml_id', 0);
        $return_by_tml_state_btn = I('return_by_tml_state_btn', 0);

        $group_order_where = '';

        if($ld_groupbuy_inst_id != 0)
        {
            $group_order_where = 'groupbuying_id = '.$ld_groupbuy_inst_id;
            $groupOrderM = M('groupbuying_order');
            $OrderM = M('order');

            $count = $groupOrderM->where($group_order_where)->count();
            $pagesize = 1000;
            for($i = 0;$i<$count;$i+=$pagesize)
            {
                $row_begin = $i;
                $row_end = $i + $pagesize;
                if($row_end > $count)
                {
                    $row_end = $count;
                }
                $list = $groupOrderM->where($group_order_where)->order("id ASC")->limit($row_begin . ',' . $row_end)->select();

                if(!empty($list)){
                    $ordername_array = array_column($list,'order_name');
                    $order_where = array();
                    $order_where['order_name'] = array('in', $ordername_array);

                    if($return_by_inst_state_btn == 0)
                    {
                        $order_where['operation_id'] = 13;//已成团待处理
                    }
                    else
                    {
                        $order_where['operation_id'] = 10;//待发货
                    }


                    $order_where['pay_status'] = 1;//已支付

                    $order_update_data = array();
                    $order_update_data['operation_id'] = 12;//等待退款

                    $OrderM->where($order_where)->save($order_update_data);
                }
            }

            echo '执行完成';
            return;

        }
        elseif($ld_groupbuy_tml_id != 0)
        {
            $group_order_where = 'groupbuyingtml_id = '.$ld_groupbuy_tml_id;
            $groupOrderM = M('groupbuying_order');
            $OrderM = M('order');

            $count = $groupOrderM->where($group_order_where)->count();
            $pagesize = 10000;
            for($i = 0;$i<$count;$i+=$pagesize)
            {
                $row_begin = $i;
                $row_end = $i + $pagesize;
                if($row_end > $count)
                {
                    $row_end = $count;
                }
                $list = $groupOrderM->where($group_order_where)->limit($row_begin . ',' . $row_end)->select();

                if(!empty($list)){
                    $ordername_array = array_column($list,'order_name');
                    $order_where = array();
                    $order_where['order_name'] = array('in', $ordername_array);

                    if($return_by_tml_state_btn == 0)
                    {
                        $order_where['operation_id'] = 13;//已成团待处理
                    }
                    else
                    {
                        $order_where['operation_id'] = 10;//待发货
                    }


                    $order_where['pay_status'] = 1;//已支付

                    $order_update_data = array();
                    $order_update_data['operation_id'] = 12;//等待退款

                    $OrderM->where($order_where)->save($order_update_data);
                }
            }

            echo '执行完成';
            return;
        }

    }

    /*
     * 导入中奖名单EXCL表格
     * */
    public function importLuck(){
        //要输出的结果
        $print_result_array = array();
        $all_user_ids = array();
        $all_groupbuy_leader_ids=array();
        $get_luckdraw_userData = array();//要发微信消息的获奖用户
        $unget_luckdraw_userData = array();//要发微信消息的未获奖用户
        //=======================================


        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileFix = explode('.', $_FILES['import_file']['name']);
        $fileName = md5($_FILES['import_file']['name'] . time()) . '.' . $fileFix[1];
        $uploadFile = $savePath . $fileName;
        move_uploaded_file($_FILES['import_file']['tmp_name'], $uploadFile);
        /*$result = $this->importExecl($uploadFile);
        if(!empty($result['data'])){
            foreach($result['data'] as $key=>$val){
                if($key>1){
                    $focus_luckdraw_winning_groupbuyinsts[] = $val['B'];
                    $focus_luckdraw_winning_no = $val['C'];
                }
            }
        }*/
        $result = $this->csv_to_array(file_get_contents($uploadFile));
        if(!empty($result))
        {
            $array_inst_ids = array_column($result,'groupbuy_inst_id');
            $array_winning_no = array_column($result,'winning_no');
            $focus_luckdraw_winning_groupbuyinsts = $array_inst_ids;
            $focus_luckdraw_winning_no = $array_winning_no[0];
        }

        $instid_2_winning_no = array();//中奖实例id对应中奖号码


        if(strlen($focus_luckdraw_winning_no)==0 || count($focus_luckdraw_winning_groupbuyinsts)==0)
        {
            echo '数据不能为空';
            return;
        }

        $focus_luckdraw_winning_groupbuyinst_array = $focus_luckdraw_winning_groupbuyinsts;
        if(!empty($focus_luckdraw_winning_groupbuyinst_array))
        {
            $collect_groupbuy_inst_ids = array();
            foreach($focus_luckdraw_winning_groupbuyinst_array as $key=>$groupbuy_inst_id)
            {
                if(!empty($groupbuy_inst_id))
                {
                    $collect_groupbuy_inst_ids[] = $groupbuy_inst_id;

                    $instid_2_winning_no[$groupbuy_inst_id] = $array_winning_no[$key];

                }
            }

            $groupBuyingM = new GroupbuyingModel();
            $where = array();
            $where['id'] = array('in', $collect_groupbuy_inst_ids);



            //修改中奖者的订单状态
            $groupbuyinst_list = $groupBuyingM->where($where)->select();
            $groupbuyinst_map = array();
            foreach($groupbuyinst_list as $groupbuy_inst_key=>$groupbuy_inst)
            {
                $groupbuyinst_map[$groupbuy_inst['id']] = $groupbuy_inst;
            }

            $need_change_order_data = array();
            //找到用户uid
            foreach($groupbuyinst_list as $groupbuy_inst_key=>$groupbuy_inst)
            {

                $focus_luckdraw_winning_no = $instid_2_winning_no[$groupbuy_inst['id']];

                $partake_array = json_decode($groupbuy_inst['partake'],true);
                if(empty($partake_array))
                {
                    continue;
                }
                foreach($partake_array as $partakekey=>$uid)
                {
                    if($focus_luckdraw_winning_no == $partakekey)
                    {
                        $need_change_order_data[] = array(
                            'groupbuy_inst_id'=>$groupbuy_inst['id'],
                            'uid'=>$uid,
                        );

                        //把中奖的人的微信信息
                        $get_luckdraw_userData[] = array(
                            'groupbuy_inst_id'=>$groupbuy_inst['id'],
                            'groupbuy_tml_id'=>$groupbuy_inst['groupbuying_tmlid'],
                            'uid'=>$uid,
                        );
                    }
                    else
                    {
                        //把未中奖的人的微信信息
                        $unget_luckdraw_userData[] = array(
                            'groupbuy_inst_id'=>$groupbuy_inst['id'],
                            'groupbuy_tml_id'=>$groupbuy_inst['groupbuying_tmlid'],
                            'uid'=>$uid,
                        );
                    }

                    //保存中奖结果
                    $where_groupbuy_inst = array();
                    $where_groupbuy_inst['id'] = $groupbuy_inst['id'];
                    $data = array();
                    $data['focus_luckdraw_winning_no'] =  $focus_luckdraw_winning_no;
                    $data['is_focus_luckdraw_winning'] = 1;
                    $groupBuyingM->where($where_groupbuy_inst)->save($data);
                }


            }
//                        dump($need_change_order_data);exit;
            //修改订单数据
            $groubuyorderM = M('groupbuying_order');
            $orderM = M('order');
            $db_result = 0;
            foreach($need_change_order_data as $ncod_key=>$ncod_value)
            {
                $groupbuyorder_where = array(
                    'uid'=>$ncod_value['uid'],
                    'groupbuying_id'=>$ncod_value['groupbuy_inst_id'],
                    'state'=>2,
                );
                $groupbuy_order_list = $groubuyorderM->where($groupbuyorder_where)->select();
                if(!empty($groupbuy_order_list))
                {
                    //修改数据
                    $groupbuy_order = $groupbuy_order_list[0];

                    $order_where=array(
                        'order_name'=>$groupbuy_order['order_name'],
                    );
                    $data_order=array();
                    $data_order['operation_id'] = 10;
                    $db_result += $orderM->where($order_where)->save($data_order);


                    //把要输出的数据整合在一起
                    $array_uid_groupbuy_and_order = array();
                    foreach($groupbuyinst_list as $groupbuy_inst_key=>$groupbuy_inst)
                    {
                        if($groupbuy_inst['id'] == $groupbuy_order['groupbuying_id'])
                        {
                            $array_uid_groupbuy_and_order['uid'] = $ncod_value['uid'];
                            $array_uid_groupbuy_and_order['groupbuy_order'] = $groupbuy_order;
                            $array_uid_groupbuy_and_order['groupbuy_inst'] = $groupbuy_inst;

                            if(!in_array($ncod_value['uid'],$all_user_ids))
                            {
                                $all_user_ids[]=$ncod_value['uid'];
                            }
                            $print_result_array[] = $array_uid_groupbuy_and_order;
                        }
                    }
                    //======================
                }
            }

            $user_result_datas = array();
            $csv_ouput_datas = array();

            if(!empty($all_user_ids))
            {
                //合并数组
                $all_user_ids = array_merge($all_user_ids, $all_groupbuy_leader_ids);

                $userM = M('user');
                $user_where = array();
                $user_where['id'] = array('in', $all_user_ids);
                $user_list = $userM->where($user_where)->select();

                $user_map=array();
                if(!empty($user_list))
                {
                    foreach($user_list as $user_key=>$user_value)
                    {
                        $user_map[$user_value['id']] = $user_value;
                    }
                }

                foreach($print_result_array as $print_result_key=>$print_result_value)
                {
                    $luck_user = array();
                    $luck_user['uid'] = $print_result_value['uid'];
                    $luck_user['order_name'] = $print_result_value['groupbuy_order']['order_name'];
                    $luck_user['groupbuy_inst_id'] = $print_result_value['groupbuy_inst']['id'];

                    //收件人信息
                    $luck_user['recvname'] = $print_result_value['groupbuy_order']['recv_name'];
                    $luck_user['recv_phone'] = $print_result_value['groupbuy_order']['recv_phone'];
                    $luck_user['recv_address'] = $print_result_value['groupbuy_order']['recv_address'];

                    //昵称
                    $luck_user['nick_name'] = $user_map[$print_result_value['uid']]['username'];
                    $luck_user['groupbuy_leader_nick_name'] = $user_map[$print_result_value['groupbuy_inst']['sponsor_id']]['username'];
                    $luck_user['succ_time'] = $print_result_value['groupbuying_endtime'];

                    $user_result_datas[] = $luck_user;

                    //用于写入csv
                    $csv_data = array();
                    $csv_data[] = $print_result_value['uid'];
                    $csv_data[] = $print_result_value['groupbuy_order']['order_name'];
                    $csv_data[] = $print_result_value['groupbuy_inst']['id'];

                    //收件人信息
                    $csv_data[] = $print_result_value['groupbuy_order']['recv_name'];
                    $csv_data[] = $print_result_value['groupbuy_order']['recv_phone'];
                    $csv_data[] = $print_result_value['groupbuy_order']['recv_address'];

                    //昵称
                    $csv_data[] = $user_map[$print_result_value['uid']]['username'];
                    $csv_data[] = $user_map[$print_result_value['groupbuy_inst']['sponsor_id']]['username'];
                    $csv_data[] = date("Y-m-d H:i:s",$print_result_value['groupbuy_inst']['groupbuying_endtime']);

                    $csv_ouput_datas[] = $csv_data;
                    //=============================
                }
            }

            $nowdate = date('Y-m-d');
            $mouth = substr($nowdate,5,2);
            $day = substr($nowdate,8,2);

            //$html = '<table>';
            foreach($user_result_datas as $user_result_key=>$user_result_value)
            {
                //$html = $html.'<tr>'.'<td>'.$user_result_value['uid'].'</td><td>'.$user_result_value['order_name'].'</td><td>'.$user_result_value['groupbuy_inst_id'].'</td>';
                //$html = $html.'<td>'.$user_result_value['recvname'].'</td><td>'.$user_result_value['recv_phone'].'</td><td>'.$user_result_value['recv_address'].'</td>';
                //$html = $html.'<td>'.$user_result_value['nick_name'].'</td><td>'.$user_result_value['groupbuy_leader_nick_name'].'</td><td>'.$user_result_value['succ_time'].'</td>';
                //$html = $html.'</tr>';

                //$this->sendsmsMsg($user_result_value['recv_phone'],'恭喜你获得叔小白商城'.$mouth.'月'.$day.'日送出的88元豪华水果礼盒一个，请通过微信进入叔小白商城查询您的订单发货信息。回复TD退订');

            }
            //$html = $html.'</table>';
            //echo $html;

            if($db_result){
                //echo '上传成功,修改订单数：'.$db_result.'条';
            }
            else{
                //echo '操作失败：'.$db_result.'条';
            }

            //下载文件
            $str_today = $mouth.'_'.$day;
            header ( 'Content-Type: application/vnd.ms-excel' );
            header ( 'Content-Disposition: attachment;filename="'.$str_today.'抽奖数据.csv"' );
            header ( 'Cache-Control: max-age=0' );
            $file = fopen('php://output', 'a');
            foreach($csv_ouput_datas as $csv_ouput_key=>$csv_ouput_value)
            {
                fputcsv($file,$csv_ouput_value);
            }
            fclose($file);


            //发微信消息
            foreach($get_luckdraw_userData as $a_key=>$a_value)
            {
                $user_ids_get = array();
                $user_ids_get[] = $a_value['uid'];
                $strText = '恭喜小主人品爆发，获得小白家幸运试吃资格，叔会第一时间安排发货，收到记得评价哦!';
                $this->send_WX_MSG_LuckdrawMsgs($user_ids_get,$strText,$a_value['groupbuy_inst_id'],$a_value['groupbuy_tml_id']);
            }
//            foreach($unget_luckdraw_userData as $a_key=>$a_value)
//            {
//                $user_ids_unget = array();
//                $user_ids_unget[] = $a_value['uid'];
//                $strText = '很抱歉你没有获得试吃资格';
//                $this->send_WX_MSG_LuckdrawMsgs($user_ids_unget,$strText,$a_value['groupbuy_inst_id'],$a_value['groupbuy_tml_id']);
//            }
        }
    }

    /*
     * 根据时间段，团数，tmlid,中奖码直接抽奖。表格
     * */
    public function importLuck_by_tml_no(){

        $get_luckdraw_userData = array();//要发微信消息的获奖用户
        $unget_luckdraw_userData = array();//要发微信消息的未获奖用户


        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileFix = explode('.', $_FILES['import_file']['name']);
        $fileName = md5($_FILES['import_file']['name'] . time()) . '.' . $fileFix[1];
        $uploadFile = $savePath . $fileName;
        move_uploaded_file($_FILES['import_file']['tmp_name'], $uploadFile);

        $result = $this->csv_to_array(file_get_contents($uploadFile));

        $array_tml_ids = array();
        $array_winning_no = array();
        $array_begin_time = array();
        $array_end_time = array();
        $array_before_a_few_nums = array();

        if(!empty($result))
        {
            $array_tml_ids = array_column($result,'groupbuy_tml_id');
            $array_winning_no = array_column($result,'winning_no');
            $array_begin_time = array_column($result,'begin_time');
            $array_end_time = array_column($result,'end_time');
            $array_before_a_few_nums = array_column($result,'before_a_few_nums');
        }

        //输出文件内容
        $csv_ouput_datas = array();
        //查找指定时间段内的前x团
        $groupBuyingM = new GroupbuyingModel();
        foreach($array_tml_ids as $tmlkey=>$tmlid)
        {
            $print_result_array = array();
            $all_user_ids = array();
            $all_groupbuy_leader_ids=array();
            //=======================================

            $where_groupbuy = array();
            $where_groupbuy['groupbuying_tmlid'] = array('in', $array_tml_ids);
            $where_groupbuy['state'] = 2;
            $where_groupbuy['groupbuying_endtime'] = array(array('egt', strtotime($array_begin_time[$tmlkey])),array('lt', strtotime($array_end_time[$tmlkey])));
            //查出所有的tmlid 对应的团
            $groupbuyinst_list = $groupBuyingM->where($where_groupbuy)->order("groupbuying_endtime ASC")->limit(0 . ',' . $array_before_a_few_nums[$tmlkey])->select();

            //$groupbuyinst_list = $groupBuyingM->where($where_groupbuy)->orderby()->limit(0,$array_before_a_few_nums[$tmlkey])->select();

            //
            if(!empty($groupbuyinst_list))
            {
                $focus_luckdraw_winning_groupbuyinsts = $groupbuyinst_list;
                $focus_luckdraw_winning_no = $array_winning_no[$tmlkey];

                if(strlen($focus_luckdraw_winning_no)==0 || count($focus_luckdraw_winning_groupbuyinsts)==0)
                {
                    echo '数据不能为空';
                    return;
                }
            }

            $focus_luckdraw_winning_groupbuyinst_array = $focus_luckdraw_winning_groupbuyinsts;
            if(!empty($focus_luckdraw_winning_groupbuyinst_array))
            {
                $collect_groupbuy_inst_ids = array();
                foreach($focus_luckdraw_winning_groupbuyinst_array as $groupbuy_inst_id)
                {
                    if(!empty($groupbuy_inst_id))
                    {
                        $collect_groupbuy_inst_ids[] = $groupbuy_inst_id;
                    }
                }

                //保存中奖结果
                $data = array();
                $data['focus_luckdraw_winning_no'] =  $focus_luckdraw_winning_no;
                $data['is_focus_luckdraw_winning'] = 1;


                $need_change_order_data = array();
                //找到用户uid
                foreach($groupbuyinst_list as $groupbuy_inst_key=>$groupbuy_inst)
                {
                    $partake_array = json_decode($groupbuy_inst['partake'],true);
                    if(empty($partake_array))
                    {
                        continue;
                    }
                    foreach($partake_array as $partakekey=>$uid)
                    {
                        if($focus_luckdraw_winning_no == $partakekey)
                        {
                            $need_change_order_data[] = array(
                                'groupbuy_inst_id'=>$groupbuy_inst['id'],
                                'uid'=>$uid,
                            );


                            //把中奖的人的微信信息
                            $get_luckdraw_userData[] = array(
                                'groupbuy_inst_id'=>$groupbuy_inst['id'],
                                'groupbuy_tml_id'=>$groupbuy_inst['groupbuying_tmlid'],
                                'uid'=>$uid,
                            );
                        }
                        else
                        {
                            //把未中奖的人的微信信息
                            $unget_luckdraw_userData[] = array(
                                'groupbuy_inst_id'=>$groupbuy_inst['id'],
                                'groupbuy_tml_id'=>$groupbuy_inst['groupbuying_tmlid'],
                                'uid'=>$uid,
                            );
                        }
                    }


                }
//                        dump($need_change_order_data);exit;
                //修改订单数据
                $groubuyorderM = M('groupbuying_order');
                $orderM = M('order');
                $db_result = 0;
                foreach($need_change_order_data as $ncod_key=>$ncod_value)
                {
                    $groupbuyorder_where = array(
                        'uid'=>$ncod_value['uid'],
                        'groupbuying_id'=>$ncod_value['groupbuy_inst_id'],
                        'state'=>2,
                    );
                    $groupbuy_order_list = $groubuyorderM->where($groupbuyorder_where)->select();
                    if(!empty($groupbuy_order_list))
                    {
                        //修改数据
                        $groupbuy_order = $groupbuy_order_list[0];

                        $order_where=array(
                            'order_name'=>$groupbuy_order['order_name'],
                        );
                        $data_order=array();
                        $data_order['operation_id'] = 10;
                        $db_result += $orderM->where($order_where)->save($data_order);


                        //把要输出的数据整合在一起
                        $array_uid_groupbuy_and_order = array();
                        foreach($groupbuyinst_list as $groupbuy_inst_key=>$groupbuy_inst)
                        {
                            if($groupbuy_inst['id'] == $groupbuy_order['groupbuying_id'])
                            {
                                $array_uid_groupbuy_and_order['uid'] = $ncod_value['uid'];
                                $array_uid_groupbuy_and_order['groupbuy_order'] = $groupbuy_order;
                                $array_uid_groupbuy_and_order['groupbuy_inst'] = $groupbuy_inst;

                                if(!in_array($ncod_value['uid'],$all_user_ids))
                                {
                                    $all_user_ids[]=$ncod_value['uid'];
                                }
                                $print_result_array[] = $array_uid_groupbuy_and_order;
                            }
                        }
                        //======================
                    }
                }

                $user_result_datas = array();

                if(!empty($all_user_ids))
                {
                    //合并数组
                    $all_user_ids = array_merge($all_user_ids, $all_groupbuy_leader_ids);

                    $userM = M('user');
                    $user_where = array();
                    $user_where['id'] = array('in', $all_user_ids);
                    $user_list = $userM->where($user_where)->select();

                    $user_map=array();
                    if(!empty($user_list))
                    {
                        foreach($user_list as $user_key=>$user_value)
                        {
                            $user_map[$user_value['id']] = $user_value;
                        }
                    }

                    foreach($print_result_array as $print_result_key=>$print_result_value)
                    {
                        $luck_user = array();
                        $luck_user['uid'] = $print_result_value['uid'];
                        $luck_user['order_name'] = $print_result_value['groupbuy_order']['order_name'];
                        $luck_user['groupbuy_inst_id'] = $print_result_value['groupbuy_inst']['id'];

                        //收件人信息
                        $luck_user['recvname'] = $print_result_value['groupbuy_order']['recv_name'];
                        $luck_user['recv_phone'] = $print_result_value['groupbuy_order']['recv_phone'];
                        $luck_user['recv_address'] = $print_result_value['groupbuy_order']['recv_address'];

                        //昵称
                        $luck_user['nick_name'] = $user_map[$print_result_value['uid']]['username'];
                        $luck_user['groupbuy_leader_nick_name'] = $user_map[$print_result_value['groupbuy_inst']['sponsor_id']]['username'];
                        $luck_user['succ_time'] = $print_result_value['groupbuying_endtime'];

                        $user_result_datas[] = $luck_user;

                        //用于写入csv
                        $csv_data = array();
                        $csv_data[] = $print_result_value['uid'];
                        $csv_data[] = $print_result_value['groupbuy_order']['order_name'];
                        $csv_data[] = $print_result_value['groupbuy_inst']['id'];

                        //收件人信息
                        $csv_data[] = $print_result_value['groupbuy_order']['recv_name'];
                        $csv_data[] = $print_result_value['groupbuy_order']['recv_phone'];
                        $csv_data[] = $print_result_value['groupbuy_order']['recv_address'];

                        //昵称
                        $csv_data[] = $user_map[$print_result_value['uid']]['username'];
                        $csv_data[] = $user_map[$print_result_value['groupbuy_inst']['sponsor_id']]['username'];
                        $csv_data[] = date("Y-m-d H:i:s",$print_result_value['groupbuy_inst']['groupbuying_endtime']);

                        $csv_ouput_datas[] = $csv_data;
                        //=============================
                    }
                }

                $nowdate = date('Y-m-d');
                $mouth = substr($nowdate,5,2);
                $day = substr($nowdate,8,2);

                //$html = '<table>';
                foreach($user_result_datas as $user_result_key=>$user_result_value)
                {
                    //$html = $html.'<tr>'.'<td>'.$user_result_value['uid'].'</td><td>'.$user_result_value['order_name'].'</td><td>'.$user_result_value['groupbuy_inst_id'].'</td>';
                    //$html = $html.'<td>'.$user_result_value['recvname'].'</td><td>'.$user_result_value['recv_phone'].'</td><td>'.$user_result_value['recv_address'].'</td>';
                    //$html = $html.'<td>'.$user_result_value['nick_name'].'</td><td>'.$user_result_value['groupbuy_leader_nick_name'].'</td><td>'.$user_result_value['succ_time'].'</td>';
                    //$html = $html.'</tr>';

                    //$this->sendsmsMsg($user_result_value['recv_phone'],'恭喜你获得叔小白商城'.$mouth.'月'.$day.'日送出的88元豪华水果礼盒一个，请通过微信进入叔小白商城查询您的订单发货信息。回复TD退订');

                }
                //$html = $html.'</table>';
                //echo $html;

                if($db_result){
                    //echo '上传成功,修改订单数：'.$db_result.'条';
                }
                else{
                    //echo '操作失败：'.$db_result.'条';
                }

            }

        }

        //发微信消息
        foreach($get_luckdraw_userData as $a_key=>$a_value)
        {
            $user_ids_get = array();
            $user_ids_get[] = $a_value['uid'];
            $strText = '恭喜小主人品爆发，获得小白家幸运试吃资格，叔会第一时间安排发货，收到记得评价哦!';
            $this->send_WX_MSG_LuckdrawMsgs($user_ids_get,$strText,$a_value['groupbuy_inst_id'],$a_value['groupbuy_tml_id']);
        }
//        foreach($unget_luckdraw_userData as $a_key=>$a_value)
//        {
//            $user_ids_unget = array();
//            $user_ids_unget[] = $a_value['uid'];
//            $strText = '很抱歉你没有获得试吃资格';
//            $this->send_WX_MSG_LuckdrawMsgs($user_ids_unget,$strText,$a_value['groupbuy_inst_id'],$a_value['groupbuy_tml_id']);
//        }

        //下载文件
        $str_today = $mouth.'_'.$day;
        header ( 'Content-Type: application/vnd.ms-excel' );
        header ( 'Content-Disposition: attachment;filename="'.$str_today.'抽奖数据.csv"' );
        header ( 'Cache-Control: max-age=0' );
        $file = fopen('php://output', 'a');
        foreach($csv_ouput_datas as $csv_ouput_key=>$csv_ouput_value)
        {
            fputcsv($file,$csv_ouput_value);
        }
        fclose($file);

    }

    protected function sendsmsMsg($phone,$content)
    {
        $smsUrl = C('SMS_URL');
        //发货成功
        //发送短信通知
        $account = C('SMS_ACCOUNT');
        $password = C('SMS_PASSWD');
        $userid = C('SMS_USERID');
        $contentSend = $content;
        $timestamps = time()*1000;

        $md5Paswd = md5($password.$phone.$timestamps);

        $params = array(
            'account' => $account,
            'password' => $md5Paswd,
            'mobile' => $phone,
            'content' => $contentSend,
            'timestamps' => $timestamps
        );

        $response =  getCurlRequest($smsUrl, http_build_query($params));

        if(!empty($response))
        {
            $json_data = $response;
            if(!empty($json_data))
            {
                if(count($json_data['Rets']) != 0 )
                {
                    foreach($json_data['Rets'] as $key => $value )
                    {
                        if($value['Rspcode'] == 0)
                        {
                            //某条发送成功
                            return true;
                        }
                    }
                }
            }

            return false;
        }
        else{
            return false;
        }
    }

    /**
     *  设置微信跳转的中间页链接
     */
    public function setWxMiddlePage(){
        import('@.ORG.RedisObj');
        $redis = new RedisObj();
        if(isset($_POST['url_1'])){
            $redis->set('weixin_middle_page_url_key1', I('url_1'));
        }

        if(isset($_POST['url_2'])){
            $redis->set('weixin_middle_page_url_key2', I('url_2'));
        }

        if(isset($_POST['url_3'])){
            $redis->set('weixin_middle_page_url_key3', I('url_3'));
        }

        if(isset($_POST['url_4'])){
            $redis->set('weixin_middle_page_url_key4', I('url_4'));
        }

        $url1 = $redis->get('weixin_middle_page_url_key1');

        $this->assign('url1', $redis->get('weixin_middle_page_url_key1'));
        $this->assign('url2', $redis->get('weixin_middle_page_url_key2'));
        $this->assign('url3', $redis->get('weixin_middle_page_url_key3'));
        $this->assign('url4', $redis->get('weixin_middle_page_url_key4'));

        $this->display('GroupBuying/setWxMiddlePage');
    }

    //发送抽奖结果通知
    public function send_WX_MSG_LuckdrawMsgs($userids,$textcontent,$groupbuyinstid,$groupbuytmlid) {

        $wx_msgM = M('wx_msg_list');
        //成团后,写入微信消息表
        if(!empty($userids)){
            foreach($userids as $uid){
                $wxMsgData = array(
                    'uid' => $uid,
                    'add_time' => time(),
                    'groupbuyinst'=>$groupbuyinstid,
                    'groubuytml'=>$groupbuytmlid,
                    'content' => $textcontent,
                    'scene_type'=>'luckdraw_msg'
                );

                $wx_msgM->add($wxMsgData);
            }
        }

    }

    /**
     *  所有身边拼实例
     */
    public function sidesplicingindex(){

        $where = array();

        $time = I('limit_date_From');
        if($time) {
            $opentime_begin = I('limit_date_From', 0) . ' ' . I('limit_time_From', 0);
            $opentime_end = I('limit_date_To', 0) . ' ' . I('limit_time_To', 0);
        }
        $tmp_id = I('tmp_id',0);

        $groupbuystate = I('groupbuystate', -1);
        $timetype = I('timetype', 0);
        $where = '';

        if(!empty($opentime_begin))
        {
            if($timetype == 0)
            {
                $where = $where."create_time>='".$opentime_begin."' AND create_time<='".$opentime_end."'";
            }
            else
            {
                $where = $where."end_time>='".$opentime_begin."' AND end_time<='".$opentime_end."'";
            }

        }

        if($groupbuystate != -1)
        {
            if(!empty($where))
                $where = $where." AND state =".$groupbuystate;
            else
                $where = "state =".$groupbuystate;
        }

        if($tmp_id){
            if(empty($where)){
                $where = $where."  groupbuying_tmlid = ".$tmp_id;
            }else{
                $where = $where." AND groupbuying_tmlid = ".$tmp_id;
            }

        }else{

        }


        $sidesplicingM = M('splicingthestars_inst');
        $count = $sidesplicingM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $sidesplicingM->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();


        if(!empty($list)){
            $userM = M('user');
            $groupBuyingTmlM = new GroupbuyingTmlModel();
            foreach($list as $key => $item){
                switch($item['state'])
                {
                    case 0:
                        $list[$key]['state'] = '未完成';
                        break;
                    case 1:
                        $list[$key]['state'] = '完成';
                        break;
                    case 2:
                        $list[$key]['state'] = '已取消';
                        break;
                }


                if(!empty($item['sponsor_id'])){
                    $sponsor = $userM->where('id ='.$item['sponsor_id'])->find();
                    $sponsor['user_head'] = unserialize($sponsor['user_head']);
                    $list[$key]['sponsor'] = $sponsor;

                }

                if(!empty($item['partake'])){
                    $partake = json_decode($item['partake'], true);
                    $list[$key]['now_nums'] = count($partake);
                    $userIds = implode(',', $partake);
                    $userList = $userM->where('id IN (' . $userIds . ')')->select();
                    $list[$key]['partake_list'] = $userList;
                }
                else
                {
                    $list[$key]['now_nums'] = 0;
                }

                if(!empty($item['groupbuying_tmlid'])){
                    $groupbuytml = $groupBuyingTmlM->where('id='.$item['groupbuying_tmlid'])->relation(true)->find();
                    $list[$key]['groupbuytml'] = $groupbuytml;
                }

                if($item['is_leader_recv']==0)
                {
                    $list[$key]['recv_data'] = '';
                }
                else
                {
                    $recv_data = json_decode($item['recv_data'], true);
                    $str_recv_data = $recv_data['recv_name'].'  '.$recv_data['recv_phone'].'  ';
                    $list[$key]['recv_data'] = $str_recv_data;
                }
            }
        }

        $this->assign('timetype',$timetype);
        $this->assign('groupbuystate',$groupbuystate);
        $this->assign('post',$_POST);

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display('sidesplicingindex');
    }

} 