<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/4/10
 * Time: 下午7:14
 */

/**
 *  新注册的用户
 * Class Newreguser
 */
class Newreguser{

    public function __construct($params = array()) {

    }

    /**
     *
     * @return array
     */
    public function setting(){
                return array(
                    'reg_hour'=>array(
                        'title'=>'注册后多少小时内',
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

        $userM = M('user');

        $beTime = date('Y-m-d H:i:s', time() - (3600 * $params['reg_hour']));

        $filter = array();
        $filter['id'] = $params['uid'];
        $filter['reg_time'] = array('gt', $beTime);
        $hasRow = $userM->where($filter)->find();
        deBugLog(array('has_row'=>$hasRow, 'model_obj'=>serialize($this->ci->user_model), 'params'=>$params), __FILE__);
        if(!empty($hasRow)){
            $result = true;
        }

        return $result;
    }


}