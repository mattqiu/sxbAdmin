<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/4/20
 * Time: 下午7:28
 */

/**
 *  购买次数与掉券概率
 * Class Buynumchance
 */
class Buynumchance {
    public function __construct($params = array()) {

    }

    /**
     *
     * @return array
     */
    public function setting(){
        return array(
            'zero_order_chance'=>array(
                'title'=>'最近有0个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
            'one_order_chance'=>array(
                'title'=>'最近有1个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
            'two_order_chance'=>array(
                'title'=>'最近有2个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
            'three_order_chance'=>array(
                'title'=>'最近有3个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
            'four_order_chance'=>array(
                'title'=>'最近有4个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
            'five_order_chance'=>array(
                'title'=>'最近有5个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
            'six_order_chance'=>array(
                'title'=>'最近有6个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
            'seven_order_chance'=>array(
                'title'=>'最近有7个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
            'eight_order_chance'=>array(
                'title'=>'最近有8个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
            'nine_order_chance'=>array(
                'title'=>'最近有9个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
            'ten_order_chance'=>array(
                'title'=>'最近有10个订单未掉券时掉券概率',
                'type'=>'int',
                'validate_type' => 'required',
            ),
        );
    }

    /**
     *
     * @param $params
     * @return bool
     */
    public function check($params){
        $result = false;
        if(!(isset($params['uid']) && $params['uid'] > 0)){
            return $result;
        }

        //找到card表中的最近一次掉券时间, 然后找此时间之后的有效订单数
        $cardM = M('card');
        $filter = array();
        $filter['uid'] = $params['uid'];
        $lastCard = $cardM->where($filter)->order('id desc')->select();
        $lastCardTime = empty($lastCard) ? '0000-00-00' : $lastCard[0]['time'];

        $orderM = M('order');
        $filter = array();
        $filter['uid'] = $params['uid'];
        $filter['operation_id'] = array(2,3,4,6,7,8,9,10);
        $filter['time'] = array('egt', $lastCardTime);
        $orderNum = $orderM->where($filter)->count();
        $chance = 0;
        if($orderNum > 10){
            $chance = $params['ten_order_chance'];
        } else {
            switch($orderNum){
                case 'zero_order_chance':
                    $chance = $params['zero_order_chance'];
                    break;
                case 'one_order_chance':
                    $chance = $params['one_order_chance'];
                    break;
                case 'two_order_chance':
                    $chance = $params['two_order_chance'];
                    break;
                case 'three_order_chance':
                    $chance = $params['three_order_chance'];
                    break;
                case 'four_order_chance':
                    $chance = $params['four_order_chance'];
                    break;
                case 'five_order_chance':
                    $chance = $params['five_order_chance'];
                    break;
                case 'six_order_chance':
                    $chance = $params['six_order_chance'];
                    break;
                case 'seven_order_chance':
                    $chance = $params['seven_order_chance'];
                    break;
                case 'eight_order_chance':
                    $chance = $params['eight_order_chance'];
                    break;
                case 'nine_order_chance':
                    $chance = $params['nine_order_chance'];
                    break;
                case 'ten_order_chance':
                    $chance = $params['ten_order_chance'];
                    break;
            }
        }

        $listrate = floatval($chance) * 100000;
        $randrate = mt_rand(1,100000);
        //产生的随机数小于等于大于设定概率值
        if($randrate <= $listrate){
            $result = true;
        }

        return $result;
    }
}