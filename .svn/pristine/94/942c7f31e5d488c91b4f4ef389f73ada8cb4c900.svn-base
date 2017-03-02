<?php
include_once('CouponTactic.php');

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/4/10
 * Time: 下午7:14
 */

/**
 * Class NewUser
 *  新用户优惠掉券条件
 */
class Newuser {

    public function __construct($params = array()) {

    }

    /**
     *
     * @return array
     */
    public function setting(){
                return array(
                    'order_num'=>array(
                        'title'=>'订单数',
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
        if(!(isset($params['uid']) && $params['uid'] > 0)){
            return $result;
        }

        $orderM = M('order');

        $filter = array();
        $filter['uid'] = $params['uid'];
        $filter['operation_id'] = array(2,3,4,6,7,8,9,10);
        $hasOrderNum = $orderM->where($filter)->count();
        if($hasOrderNum <= $params['order_num']){
            $result = true;
        }

        return $result;
    }


}