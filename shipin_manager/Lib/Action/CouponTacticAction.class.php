<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/4/11
 * Time: 上午11:48
 */

/**
 *  优惠券策略管理
 * Class CouponTacticAction
 */
class CouponTacticAction extends CommonAction{


    public function index(){
        $couponTacticM = M('coupon_tactic');
        $count = $couponTacticM->count();
        $page = new Page($count, 20);
        $strPage = $page->show();
        $list = $couponTacticM->limit($page->firstRow, $page->listRows)->order('"trigger" ASC, id DESC')->select();

        $isMutexConf = array(1=>'未设置', 2=>'互斥', 3=>'不互斥');
        foreach($list as $key=>$item){
            $list[$key]['is_mutex'] = $isMutexConf[$item['is_mutex']];
        }

        $this->assign('list', $list);
        $this->assign('page_str', $strPage);
        $this->display();
    }

    public function create(){

        $this->display();
    }

    public function edit(){
        $id = I('id');
        $couponTacticM = M('coupon_tactic');
        $couponTacticTmlM = M('coupon_tactic_tml');
        $tactic = $couponTacticM->where(array('id'=>$id))->find();
        $tacticParams = json_decode($tactic['params'], true);

        $tmlWhere = array();
        $tmlWhere['id'] = array('in', explode(',', $tactic['tml_ids']));
        $tacticTmlList = $couponTacticTmlM->where($tmlWhere)->select();

        foreach($tacticTmlList as $key => $item){

            $params = json_decode($item['params'], true);
            foreach($params as $pKey => $paramsItem){
                $params[$pKey]['value'] = $tacticParams[$item['class_name']][$pKey];
            }

            $tacticTmlList[$key]['params'] = $params;
        }

        $this->assign('tactic', $tactic);

        $this->assign('tml_list', $tacticTmlList);
        $this->display('create');
    }

    public function save(){
        $id = I('id', 0);
        $data = array();
        $data['tml_ids'] = I('tml_id', '');
        $data['logic'] = I('logic', '');
        $data['name'] = I('name', '');
        $data['trigger'] = I('trigger', '');
        $data['groupbuying_tmlid'] = I('groupbuying_tmlid', 0);
        $data['is_mutex'] = I('is_mutex', 1);
        $data['rank'] = I('rank', 100);
        $data['rank'] = $data['rank'] > 0 ? $data['rank'] : 100;
        $data['drop_group_id'] = I('drop_group_id', 0);
        $data['desc'] = I('desc', '');
        $data['add_time'] = date('Y-m-d H:i:s');

        if(empty($data['tml_ids']) || empty($data['logic']) || empty($data['name'])){
            $this->success('参数出错');
        }

        $couponTacticM = M('coupon_tactic');
        $couponTacticTmlM = M('coupon_tactic_tml');
        $tmlWhere = array();
        $tmlWhere['id'] = array('in', explode(',', $data['tml_ids']));
        $tmlList = $couponTacticTmlM->where($tmlWhere)->select();
        if(empty($tmlList)){
            $this->success('模板出错');
        }

        $paramsArr = array();
        foreach($tmlList as $item){
            $paramsArr[$item['class_name']] = $_REQUEST[$item['class_name']];
        }

        $data['params'] = json_encode($paramsArr);

        if($id>0){
            $couponTacticM->where(array('id'=>$id))->save($data);
        } else {
            $couponTacticM->add($data);
        }

        $this->success('保存成功');
    }

    /**
     *  返回策略模板
     */
    public function selectJson(){
        $couponTacticTmlM =M('coupon_tactic_tml');
        $where = array();

        $count = $couponTacticTmlM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $couponTacticTmlM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        $result  = array('data' => $list, 'key' => array('id', 'name', 'class_name', 'last_time'), 'th'=>array('id', '名称', '类名', '最后更新时间'), 'page' => $strPage);
        echo json_encode($result);
    }

    public function getCouponTacticTml(){
        $result = array();
        $result['status'] = 0;
        $result['msg'] = '';
        $ids = I('ids', 0);
        if(empty($ids)){
            $result['msg'] = '参数错误';
            echo json_encode($result);
            exit;
        }

        $couponTacticTmlM =M('coupon_tactic_tml');
        $where = array();
        $where['id'] = array('in', explode(',', $ids));
        $data = $couponTacticTmlM->where($where)->select();
        $result['status'] = 1;

        if(!empty($data)){
            foreach($data as $key => $item){
                $data[$key]['params'] = json_decode($item['params'], true);
            }
        }
        $this->assign('tml_list', $data);
        $result['data'] = $this->fetch('tml_item');

        echo json_encode($result);
    }

    /**
     *  初始化测试的策略类配置
     */
    public function testInit(){
        $couponTacticTmlM = M('coupon_tactic_tml');
//        $className = 'NewUser';
//        $paramsArr = array(
//            'order_num'=>array(
//                'title'=>'订单数',
//                'type'=>'int',
//                'validate_type' => 'required',
//            )
//        );

//        $className = 'AreaUser';
//        $paramsArr = array(
//            'area_id'=>array(
//                'title'=>'省份id',
//                'type'=>'int',
//                'validate_type' => 'required',
//            )
//        );

//        $className = 'LoseSoonUser';
//        $paramsArr = array(
//            'unbuy_hours_num'=>array(
//                'title'=>'未购买小时数',
//                'type'=>'int',
//                'validate_type' => 'required',
//            )
//        );

//        $className = 'OldUser';
//        $paramsArr = array(
//            'order_num'=>array(
//                'title'=>'订单数不少于',
//                'type'=>'int',
//                'validate_type' => 'required',
//            )
//        );

//        $className = 'AffectUser';
//
//        $paramsArr = array(
//            'friend_num'=>array(
//                'title'=>'好友数不少于',
//                'type'=>'int',
//                'validate_type' => 'required',
//            )
//        );

//        $className = 'Buynumchance';
//        $paramsArr = array(
//            'zero_order_chance'=>array(
//                'title'=>'最近有0个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//            'one_order_chance'=>array(
//                'title'=>'最近有1个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//            'two_order_chance'=>array(
//                'title'=>'最近有2个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//            'three_order_chance'=>array(
//                'title'=>'最近有3个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//            'four_order_chance'=>array(
//                'title'=>'最近有4个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//            'five_order_chance'=>array(
//                'title'=>'最近有5个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//            'six_order_chance'=>array(
//                'title'=>'最近有6个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//            'seven_order_chance'=>array(
//                'title'=>'最近有7个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//            'eight_order_chance'=>array(
//                'title'=>'最近有8个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//            'nine_order_chance'=>array(
//                'title'=>'最近有9个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//            'ten_order_chance'=>array(
//                'title'=>'最近有10个订单未掉券时掉券概率',
//                'type'=>'int',
//                'validate_type' => 'required',
//            ),
//        );

//        $className = 'Sharemanyuser';
//        $paramsArr = array(
//            'avg_order_share_num'=>array(
//                'title'=>'平均每单分享数',
//                'type'=>'int',
//                'validate_type' => 'required',
//            )
//        );


//        $className = 'Sharetotaluser';
//        $paramsArr = array(
//            'share_num'=>array(
//                'title'=>'分享数大于等于',
//                'type'=>'int',
//                'validate_type' => 'required',
//            )
//        );

//        $className = 'Friendlessuser';
//        $paramsArr = array(
//            'friend_num'=>array(
//                'title'=>'好友数小于',
//                'type'=>'int',
//                'validate_type' => 'required',
//            )
//        );

        $className = 'Newreguser';
        $paramsArr = array(
            'reg_hour'=>array(
                'title'=>'注册后多少小时内',
                'type'=>'int',
                'validate_type' => 'required',
            )
        );

        $params = $paramsArr;

        $where = array();
        $where['class_name'] = $className;
        $couponTacticTmlM->where($where)->save(array('params' => json_encode($params)));

        echo $couponTacticTmlM->getLastSql();
    }

    public function del(){
        $id = I('id', 0);
        if(!($id > 0)){
            exit('参数出错');
        }

        $couponTacticM = M('coupon_tactic');
        $couponTacticM->where(array('id'=>$id))->delete();
        echo '删除成功';
    }

}