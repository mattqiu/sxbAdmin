<?php
/**
 * O2O商家管理
 */
class OmerchantAction extends CommonAction{

    /*
     * O2O商家列表
     * */
    public function index(){
        $merchantM = M('o2o_merchant');
        $data = $merchantM->select();
        $page = new Page(count($data),20);
        $list = $merchantM->limit($page->firstRow . ',' . $page->listRows)->select();
        $show = $page->show();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    /*
     * O2O商家添加
     * */
    public function add(){
        $this->display();
    }

    /*
     * 三级联动 省市区
     * **/
    public function areaList(){
        $areaM = M('area');
        $pid = I('pid');
        $where['pid'] = array('eq',$pid);
        $provList = $areaM->field('id,name')->where($where)->select();
        echo json_encode($provList);
    }

    /*
     * 添加O2O商户
     * */
    public function doadd(){
        $data['o2o_name'] = I('o2o_name');
        $data['province'] = I('province');
        $data['city'] = I('city');
        $data['area'] = I('area');
        $data['phone'] = I('phone');
        $data['town'] = I('town');
        $data['address'] = I('address');

        $merchantM = M('o2o_merchant');
        $result = $merchantM->add($data);
        if($result){
            $this->success('商户添加成功',U('Omerchant/index'));
        }else{
            $this->error('商户添加失败');
        }
    }

    /*
     * O2O商户信息修改
     * */
    public function edit(){
        $id = I('id');
        $where['id'] = array('eq',$id);
        $merchantM = M('o2o_merchant');
        $result = $merchantM->where($where)->find();
        $address = '';
        $address = $result['province'].','.$result['city'].','.$result['area'].','.$result['town'];;
        $areaM = M('area');
        $where['id'] = array('in',$address);
        $address = $areaM->where($where)->select();
        $list = json_encode($result);
        $this->assign('list',$list);
        $this->assign('address',$address);
        $this->assign('result',$result);
        $this->display();
    }

    /*
     *O2O商户修改信息执行
     * */
    public function save(){
        $data['o2o_name'] = I('o2o_name');
        $data['province'] = I('province');
        $data['city'] = I('city');
        $data['area'] = I('area');
        $data['phone'] = I('phone');
        $data['town'] = I('town');
        $data['address'] = I('address');
        $id = I('id');
        $where['id'] = array('eq',$id);
        $merchantM = M('o2o_merchant');
        $result = $merchantM->where($where)->save($data);
        if($result){
            $this->success('信息修改成功',U('Omerchant/index'));
        }else{
            $this->error('信息修改失败');
        }
    }

    /*
     * O2O商户删除
     * */
    public function del(){
        $id = I('id');
        $where['id'] = array('eq',$id);
        $merchantM = M('o2o_merchant');
        $result = $merchantM->where($where)->delete();
        if($result){
            $this->success('商户删除成功',U('Omerchant/index'));
        }else{
            $this->error('商户失败');
        }
    }

    /*
     * 给商户开第一团
     * */
    public function create(){
        $merchant_id = I('id');
        $nowTime = date('H:i' , time());

        //查询商户拥有的配送时间列表
        $merchantMsgM = M('o2o_merchantmsg');
        $where['o2o_id'] = array('eq' , $merchant_id);
        $merchantMsg = $merchantMsgM->where($where)->find();
        $timeTml = json_decode($merchantMsg['o2o_time_list']);

        //取现在可配送的模板ID
        $timeTmlM = M('o2o_timetml');
        $where['id'] = array('in' , $timeTml);
        $timeList = $timeTmlM->where($where)->select();
        foreach($timeList as $key => $val){
            if($nowTime < $timeList[$key]['delivery_time']){
                $o2o_timetml_id = $timeList[$key]['id'];
                break;
            }
        }
        $insert = array(
                'merchant_id' => $merchant_id,
                'group_user' => '',
                'o2o_timetml_id' => $o2o_timetml_id,
                'now_money' => 0.00,
                'group_status' => 0,
            );
        $o2oGroupBuyM = M('o2o_groupbuy');

        $result = $o2oGroupBuyM->add($insert);
        if($result){
            echo 1;
        }else{
            echo 0;
        }
    }
}
