<?php
// +----------------------------------------------------------------------
// | 上海时品信息科技有限公司
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id: Orders.class.php 1326 2014-10-09 06:14:10Z yihua.ying $ 


/**
 * 订单相关的
 * Class Orders
 */
class Orders {
    public function getActionButton(&$order =array(), $isAllDisable = false){
        //订单的最终状态：已完成，退货完成，关闭
        //        1=>"待付款",2=>"已付款",3=>"待发货",4=>"待收货",5=>"已收货",6=>"已完成",7=>"退货中"
        //        ,8=>"退货完成", 9=>"关闭"

        //全部操作: 审核，付款，发货，完成，关闭
        //全部状态: 未审核，待付款，待发货，待收货，已收货，已完成，退货中，退货完成，关闭

//        `operation_id` int(2) NOT NULL DEFAULT '0' COMMENT '0=>''待审核'',1=>''已审核'',2=>''已发货'',3=>''已完成'',4=>''未完成'',5=>''已取消'',6=>''等待完成'',7=>''退货中'',8=>''换货中'',9=>''已收货'',10=>''待发货''',
//        `order_status` smallint(2) NOT NULL DEFAULT '0' COMMENT '0:所有订单、1:未完成、2:已完成、3:已取消、4:已完成＋已收货',

//        $config['MANAGE_ORDER_STATUS'] = array(
//            0=>'全部',
//            1=>'待审核',
//            2=>'待付款',
//            3=>'已付款',
//            4=>'待发货',
//            5=>'已发货',
//            6=>'已完成',
//            7=>'已取消',
//            8=>'退货中',
//            9=>'换货中',
//            10=>'已退货'
//        );

        //客服审核
        $disableCheck = false;
        $disablePayed = false;
        $disableDelivery = false;
        $disableFinish = false;
        $disableClose = false;

        $operationId = intval($order['operation_id']);
        $status = intval($order['order_status']);
        $payStatus = intval($order['pay_status']);
        $payParentId = intval($order['pay_parent_id']);

        if(0 != $status){
            //不等于0就表示已经审核
            $disableCheck = true;
        }

        if(1 === $payStatus){
            //已付款
            $disablePayed = true;
        }

        //如果用户选择的支付方式不是线下支付(如货到付款), 且未付款的情况下不能发货
        if(4 != $payParentId && 1  != $payStatus){
            $disableDelivery = true;
        }

        //如果订单状态不是已发货的状态下，不能点完成
        if(2 != $operationId) {
            $disableFinish = true;
        }

        //不是待发货状态，不显示发货按钮
        if(10 != $operationId){
            $disableDelivery = true;
        }

        //  3=>'已完成',5=>'已取消',9=>'已收货' 的订单不能再做取消,付款操作
        if(in_array($operationId, array(3, 5,9))){
            $disableClose = true;
            //已付款
            $disablePayed = true;
        }

        $actionButton= array(
            'check' => array(
                'label' => '审核',
                'disable' => $disableCheck,
                'act' => 'check',
            ),
            'payed' => array(
                'label' => '付款',
                'disable' => $disablePayed,
                'act' => 'payed',
            ),
            'delivery' => array(
                'label' => '发货',
                'disable' => $disableDelivery,
                'act' => 'delivery',
            ),
            'finish' => array(
                'label' => '完成',
                'disable' => $disableFinish,
                'act' => 'finish',
            ),
            'close' => array(
                'label' => '取消',
                'disable' => $disableClose,
                'act' => 'close',
            ),
        );

        foreach($actionButton as $key => $button){
            if($button['disable']){
                unset($actionButton[$key]);
            }
        }

        return $actionButton;
    }

}