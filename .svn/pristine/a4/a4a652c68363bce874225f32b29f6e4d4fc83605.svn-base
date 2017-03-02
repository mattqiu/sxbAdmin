<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/4/18
 * Time: 下午7:40
 */

/**
 *  快流失用户
 * Class LoseSoonUser
 */
class Losesoonuser {
    public function __construct($params = array()) {

    }

    /**
     *
     * @return array
     */
    public function setting(){
        return array(
            'unbuy_hours_num'=>array(
                'title'=>'未购买小时数',
                'type'=>'int',
                'validate_type' => 'required',
            )
        );
    }

    /**
     *
     * @param $params
     * @return bool
     */
    public function check($params){
        $result = false;
        if(!(isset($params['uid']) && $params['uid'] > 0)
            || !(isset($params['unbuy_hours_num']) && $params['unbuy_hours_num'] > 0)){
            return $result;
        }

        $orderM = M('order');

        $unbuyHours = intval($params['unbuy_hours_num']);
        $begianTime = date('Y-m-d H:i:s', time() - ($unbuyHours * 3600));
        $filter = array();
        $filter['uid'] = $params['uid'];
        $filter['operation_id'] = array(2,3,4,6,7,8,9,10);

        $lastOrder = $orderM->where($filter)->order('id desc')->find();
        $lastOrderTime = $lastOrder['time'];
        $secs = time() - strtotime($lastOrderTime);
        $beginSecs = $unbuyHours * 3600;
        deBugLog(array('lastorder=='=> $lastOrder), __FILE__);

        if($secs >= $beginSecs){
            $result = true;
        }

        return $result;
    }
}