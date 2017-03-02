<?php
/**
 * O2O商户实例管理
 */
class OmerchantmsgAction extends CommonAction{

    /*
     * O2O商户实例列表
     * */
    public function index(){
        $merchantmsgM = M('o2o_merchantmsg');
        $list = $merchantmsgM->select();
        $timeListM = M('o2o_timetml');
        $merchantM = M('o2o_merchant');
        foreach($list as $key => $val){
            $list[$key]['o2o_time_list'] = json_decode($list[$key]['o2o_time_list'] , true );
            $where['id'] = array('in' , $list[$key]['o2o_time_list']);
            $result = $timeListM->field('delivery_time')->where($where)->select();
            foreach($result as $k => $v){
                $list[$key]['timeList'] .= '&nbsp;&nbsp;' . $result[$k]['delivery_time'];
            }
            $where['id'] = $list[$key]['o2o_id'];
            $merchantName = $merchantM->field('o2o_name')->where($where)->find();
            $list[$key]['merchant'] = $merchantName['o2o_name'];

        }
        $this->assign('list',$list);
        $this->display();
    }

    /*
     * O2O商户实例添加
     * */
    public function add(){
        $merchantM = M('o2o_merchant');
        $merchant = $merchantM->select();

        $grouptmlM = M('o2o_timetml');
        $timeList = $grouptmlM->select();

        $this->assign('timeList',$timeList);
        $this->assign('merchant',$merchant);
        $this->display();
    }

    /*
     * 添加O2O商户实例添加执行
     * */
    public function doadd(){
        $data['longitade'] = I('longitade');
        $data['lat'] = I('lat');
        $data['o2o_id'] = I('o2o_id');
        $data['distribution_time_id'] = I('distribution_time_id');
        $o2o_time_list = $_POST['o2o_time_list'];
        $data['o2o_time_list'] = json_encode($o2o_time_list,true);

        $merchantmsgM = M('o2o_merchantmsg');
        $result = $merchantmsgM->add($data);
        if($result){
            $this->success('商户实例添加成功',U('Omerchantmsg/index'));
        }else{
            $this->error('商户实例添加失败');
        }
    }

    /*
     * O2O商户实例信息修改
     * */
    public function edit(){
        $id = I('id');
        $where['id'] = array('eq',$id);
        $merchantmsgM = M('o2o_merchantmsg');
        $result = $merchantmsgM->where($where)->find();

        $merchantM = M('o2o_merchant');
        $merchant = $merchantM->select();

        $grouptmlM = M('o2o_timetml');
        $timeList = $grouptmlM->select();
        $this->assign('timeList',$timeList);
        $this->assign('merchant',$merchant);
        $this->assign('result',$result);
        $this->display();
    }

    /*
     *O2O商户实例修改信息执行
     * */
    public function save(){
        $data['longitade'] = I('longitade');
        $data['lat'] = I('lat');
        $data['o2o_id'] = I('o2o_id');
        $data['distribution_time_id'] = I('distribution_time_id');
        $o2o_time_list = $_POST['o2o_time_list'];
        $data['o2o_time_list'] = json_encode($o2o_time_list,true);
        $id = I('id');
        $where['id'] = array('eq',$id);
        $merchantmsgM = M('o2o_merchantmsg');
        $result = $merchantmsgM->where($where)->save($data);
        if($result){
            $this->success('商户实例信息修改成功',U('Omerchantmsg/index'));
        }else{
            $this->error('商户实例信息修改失败');
        }
    }

    /*
     * O2O商户实例删除
     * */
    public function del(){
        $id = I('id');
        $where['id'] = array('eq',$id);
        $merchantmsgM = M('o2o_merchantmsg');
        $result = $merchantmsgM->where($where)->delete();
        if($result){
            $this->success('商户实例删除成功',U('Omerchantmsg/index'));
        }else{
            $this->error('商户实例删除失败');
        }
    }
}
