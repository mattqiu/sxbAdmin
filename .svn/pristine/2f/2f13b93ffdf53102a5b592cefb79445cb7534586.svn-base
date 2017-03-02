<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/4/19
 * Time: 下午3:45
 */

/**
 *  好友少的用户
 * Class Friendlessuser
 */
class Friendlessuser {
    public function __construct($params = array()) {

    }

    /**
     *
     * @return array
     */
    public function setting(){
        return array(
            'friend_num'=>array(
                'title'=>'好友数小于',
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
        $filter['friend_num'] = array('lt', $params['friend_num']);
        $hasUser = $userFriendIntimateM->where($filter)->find();

        deBugLog(array('params'=>$params, 'hasUser'=>$hasUser), __FILE__);
        if(!empty($hasUser)){
            return true;
        }

        return $result;
    }
}