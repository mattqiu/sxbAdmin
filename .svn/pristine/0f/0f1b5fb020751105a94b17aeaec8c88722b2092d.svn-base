<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/4/20
 * Time: 下午7:19
 */

/**
 *  平均每单分享多的用户
 * Class Sharemanyuser
 */
class Sharemanyuser {
    public function __construct($params = array()) {

    }

    /**
     *
     * @return array
     */
    public function setting(){
        return array(
            'avg_order_share_num'=>array(
                'title'=>'平均每单分享数',
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
            || !(isset($params['friend_num']) && $params['friend_num'] > 0)){
            return $result;
        }

        $userFriendIntimateM = M('user_friend_intimate');

        $filter = array();
        $filter['uid'] = $params['uid'];
        $filter['avg_order_share_num'] = array('egt', $params['avg_order_share_num']);

        $hasUser = $userFriendIntimateM->where($filter)->order('id desc')->find();

        deBugLog(array('params'=>$params, 'hasUser'=>$hasUser), __FILE__);
        if(!empty($hasUser)){
            return true;
        }

        return $result;
    }
}