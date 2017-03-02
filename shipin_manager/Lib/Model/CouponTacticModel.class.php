<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/4/22
 * Time: 下午3:40
 */
class CouponTacticModel extends CommonModel{

    public function getEventTacticList($event, $groupbuyingTmlId=0){
        $filter = array();
        $filter['trigger'] = $event;
        $filter['groupbuying_tmlid'] = $groupbuyingTmlId;
        $list = $this->where($filter)->order('rank desc')->select();

        //deBugLog(array('model_obj'=>serialize($this)), __FILE__);
        //如果指定了团购模板且没有找到对应的事件策略，则使用普通的事件策略
        if(empty($list) && $groupbuyingTmlId > 0){
            unset($filter['groupbuying_tmlid']);
            $list = $this->where($filter)->order('rank desc')->select();
        }
        return $list;
    }

    /**
     *  触发掉券事件
     * @param $uid
     * @param $dropCouponGroupId
     * @param $event
     */
    public function triggerDropCoupon($uid, $event, $groupbuyingTmlid=0){
        if(!($uid > 0)){
            return;
        }

        //如果是有团购模板的事件,先判断是否有配置指定团购模板的事件,
        //不存在则用全局事件
        $tacticList = $this->getEventTacticList($event, $groupbuyingTmlid);

        if(empty($tacticList)){
            return;
        }

        define('MUTEX_YES', 2);
        define('MUTEX_NO', 3);
//        $this->load->model('groupbuying_model');
        //        deBugLog(array('tacticList'=>$tacticList, ), __FILE__);
        //如果权重值最大的策略是互斥的，则只应用这一个策略,
        //        if($tacticList[0]['is_mutex'] == MUTEX_YES){

        $checkResult = array();
        //如果权重值最大的策略是共存的，则应用所有符合触发时间的策略
        $allCheckResult = array();
        foreach($tacticList as $key => $tacticItem){

            $paramsArr = json_decode($tacticItem['params'], true);
            $tacticNum = count(explode(',', $tacticItem['tml_ids']));
            $tacticCheckResult = array();
            foreach($paramsArr as $key=>$paramsItem){
                $classKey = $key;
                vendor('coupontactic/' . $classKey);
                $coupontacticObj = new $classKey;

                $paramsItem['uid'] = $uid;
                $paramsItem['event'] = $event;
                $paramsItem['groupbuy_tml_id'] = $groupbuyingTmlid;

                deBugLog(array('classKey'=>$classKey, 'paramsItem'=>$paramsItem), __FILE__);
                $tacticCheckResult[] = $coupontacticObj->check($paramsItem);

            }

            $logicResult = false;
            switch($tacticItem['logic']){
                case 'and':
                    if(!(in_array(false, $tacticCheckResult))){
                        $logicResult = true;
                    }

                    break;

                case 'or':
                    if(in_array(true, $tacticCheckResult)){
                        $logicResult = true;
                    }
                    break;
            }
            deBugLog(array('logicResult'=>$logicResult, 'give_coupon_uid'=>$uid, 'group_id'=>$tacticItem['drop_group_id']), __FILE__);
            if($logicResult){
                $tacticItem['logic_result'] = $logicResult;
                $checkResult[] = $tacticItem;
            }

            $allCheckResult[$classKey] = $tacticCheckResult;
        }

        deBugLog(array('all_succ'=>$checkResult), __FILE__);
        deBugLog(array('all_check_result'=>$allCheckResult), __FILE__);
        if(empty($checkResult)){
            return $tacticCheckResult;
        }

        if($checkResult[0]['is_mutex'] == MUTEX_YES){
            $resultItem = $checkResult[0];
            deBugLog(array('开始掉券'=>array('uid'=>$uid, 'drop_group_id'=> $resultItem['drop_group_id'], 'name'=>$resultItem['name'])), __FILE__);
//            $this->groupbuying_model->giveUserCouponByDropgroupId($uid, $resultItem['drop_group_id']);
            return $tacticCheckResult;
        } else {
            foreach($checkResult as $key => $resultItem){
                if($resultItem['is_mutex'] == MUTEX_NO){
                    deBugLog(array('开始掉券2'=>array('uid'=>$uid, 'drop_group_id'=> $resultItem['drop_group_id'], 'key'=>$key)), __FILE__);
//                    $this->groupbuying_model->giveUserCouponByDropgroupId($uid, $resultItem['drop_group_id']);
                }
            }
        }

        return $allCheckResult;
    }



}