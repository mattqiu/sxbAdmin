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
class GroupBuyingOrderAction extends CommonAction{

    /**
     *  所有团购订单
     */
    public function index(){
        $where = '';
        $groupbuyOrderM = M('groupbuying_order');

        $timetype = 0;
        if(!empty($_REQUEST['groupbuy_time_type']))
        {
            $timetype = $_REQUEST['groupbuy_time_type'];
        }


        $limitDate = array();
        $limitTime = array();
        if(!empty($_REQUEST['limit_date_From'])){

            $limitDate[0] =$_REQUEST['limit_date_From'];
            $limitTime[0] = $_REQUEST['limit_time_From'];
        }
        if(!empty($_REQUEST['limit_date_To'])){
            $limitDate[1] = $_REQUEST['limit_date_To'];
            $limitTime[1] = $_REQUEST['limit_time_To'];
        }

        if(count($limitDate) > 0)
        {
            $strDateFrom = $limitDate[0]." ".$limitTime[0];
            $strDateTo = $limitDate[1]." ".$limitTime[1];
            $timefrom = strtotime($strDateFrom);
            $timeto = strtotime($strDateTo);
            if($timetype == 0)
            {
                if(strlen($where)>0)
                {
                    $where = $where.'and create_time >='.$timefrom." and create_time<".$timeto;
                }
                else
                {
                    $where = 'create_time >='.$timefrom." and create_time<".$timeto;
                }
            }
            elseif($timetype == 1)
            {
                if(strlen($where)>0)
                {
                    $where = $where.'and last_update_time >='.$timefrom." and last_update_time<".$timeto;
                }
                else
                {
                    $where = 'last_update_time >='.$timefrom." and last_update_time<".$timeto;
                }
            }

        }

        if(!empty($_REQUEST['groupbuy_order_name']))
        {
            $groupbuyorder_name = $_REQUEST['groupbuy_order_name'];
            $where = 'groupbuy_order_name ='.$groupbuyorder_name;
        }

        if(!empty($_REQUEST['order_name']))
        {
            $order_name = $_REQUEST['order_name'];
            $where = 'order_name ='.$order_name;
        }

        if(!empty($_REQUEST['recv_phone']))
        {
            $recv_phone = $_REQUEST['recv_phone'];
            $where = 'recv_phone ='.$recv_phone;
        }

        if(!empty($_REQUEST['recv_name']))
        {
            $recv_name = $_REQUEST['recv_name'];
            $where = 'recv_name ='."'$recv_name'";
        }

        if(!empty($_REQUEST['uid'])){
            $id = $_REQUEST['uid'];
            $where = 'uid = '.$id;
        }

        $count = $groupbuyOrderM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $groupbuyOrderM->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();

        $arr = array();
        foreach($list as $key=>$val){
            $arr[] = $list[$key]['uid'];
        }
        $arrs = implode(',',$arr);

        $userM = M('user_wx');
        $whereUser['uid'] = array('exp',"in($arrs)");
        $userName = $userM->field('nickname,uid')->where($whereUser)->select();

        foreach($list as $key=>$groupbuyorder){
            switch($groupbuyorder['state'])
            {
                case 0:
                    $list[$key]['state'] = "未支付";
                    break;
                case 1:
                    $list[$key]['state'] = "已支付未成团";
                    break;
                case 2:
                    $list[$key]['state'] = "已成团";
                    break;
                case 3:
                    $list[$key]['state'] = "已取消";
                    break;
                case 4:
                    $list[$key]['state'] = "已退款";
                    break;
                case 5:
                    $list[$key]['state'] = "发货";
                    break;
                case 6:
                    $list[$key]['state'] = "待评价";
                    break;
                case 7:
                    $list[$key]['state'] = "退货";
                    break;

            }
            $createTime = date("y-m-d H:i:s",$groupbuyorder['create_time']);
            $lastUpdateTime = date("y-m-d H:i:s",$groupbuyorder['last_update_time']);

            $list[$key]['create_time'] = $createTime;
            $list[$key]['last_update_time'] = $lastUpdateTime;
        }

        foreach($list as $key=>$val){
            foreach($userName as $k=>$v){
                if($list[$key]['uid'] == $userName[$k]['uid']){
                    $list[$key]['nickname'] = $userName[$k]['nickname'];
                }
            }
        }

//        dump($list);
        $this->assign('timetype', $timetype);
        $this->assign('limit_date_From', $_REQUEST['limit_date_From']);
        $this->assign('limit_time_From', $_REQUEST['limit_time_From']);
        $this->assign('limit_date_To', $_REQUEST['limit_date_To']);
        $this->assign('limit_time_To', $_REQUEST['limit_time_To']);

        $this->assign('list', $list);
        $this->assign('post',$_POST);
        $this->assign('page', $strPage);
        $this->display();
    }

    /**
     * 根据订单列表页传来的 团单号搜索
     */
    public function groupSearch() {
        $m = M("groupbuying_order");
        $where['groupbuy_order_name'] = I("groupbuy_order_name");
        $list = $m->where($where)->select();
        foreach ($list as $key => $val) {
            switch ($list[$key]['state']) {
                case 0:
                    $list[$key]['state'] = "未支付";
                    break;
                case 1:
                    $list[$key]['state'] = "已支付未成团";
                    break;
                case 2:
                    $list[$key]['state'] = "已成团";
                    break;
                case 3:
                    $list[$key]['state'] = "已取消";
                    break;
                case 4:
                    $list[$key]['state'] = "已退款";
                    break;
                case 5:
                    $list[$key]['state'] = "发货";
                    break;
                case 6:
                    $list[$key]['state'] = "待评价";
                    break;
                case 7:
                    $list[$key]['state'] = "退货";
                    break;

            }
            if($list) {
                $this->assign("list", $list);
                $this->display("GroupBuyingOrder/index");
            } else {
                $this->error("团单号码有误，请确认!");
            }
        }
    }
} 