<?php
/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/4/10
 * Time: 下午7:14
 */

/**
 * Class NewUser
 *  按区域筛选用户优惠掉券条件
 *  默认按最近一次的收货地址,如果不存在则找微信表中的地址
 *  限省和直辖市
 */
class Areauser{

    public function __construct($params = array()) {

    }

    /**
     *
     * @return array
     */
    public function setting(){

        return array(
            'area_id'=>array(
                'title'=>'省份id',
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
            || !(isset($params['area_id']) && $params['area_id'] > 0)){
            return $result;
        }

        $userAddressM = M('user_address');

        $filter = array();
        $filter['uid'] = $params['uid'];
        $filter['province'] = $params['area_id'];
        $hasAreaOrder = $userAddressM->where($filter)->find();

        if(!empty($hasAreaOrder)){
            return true;
        }

        $areaM = M('area');
        $userWxM = M('user_wx');

        $area = $areaM->where(array('id'=>$params['area_id']))->find();
        $filterWx = array();
        $filterWx['uid'] = $params['uid'];
        $filterWx['province'] = $area['name'];

        $hasAreaUserWx = $userWxM->where($filterWx)->find();

        if(!empty($hasAreaUserWx)){
            $result = true;
        }

        return $result;
    }


}