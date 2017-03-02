<?php
/**
 * O2O模板管理
 */
class OgrouptmlAction extends CommonAction{

    /*
     * O2O模板列表
     * */
    public function index(){
        $grouptmlM = M('o2o_timetml');
        $list = $grouptmlM->select();
        $this->assign('list',$list);
        $this->display();
    }

    /*
     * O2O模板添加
     * */
    public function add(){
        $this->display();
    }

    /*
     * 添加O2O模板
     * */
    public function doadd(){
        $data['o2o_money'] = I('o2o_money');
        $data['o2o_nums'] = I('o2o_nums');
        $data['condition'] = I('condition');
        $data['delivery_time'] = I('delivery_time');
        $data['group_ok_time'] = I('group_ok_time');

        $grouptmlM = M('o2o_timetml');
        $result = $grouptmlM->add($data);
        if($result){
            $this->success('模板添加成功',U('Ogrouptml/index'));
        }else{
            $this->error('模板添加失败');
        }
    }

    /*
     * O2O模板信息修改
     * */
    public function edit(){
        $id = I('id');
        $where['id'] = array('eq',$id);
        $grouptmlM = M('o2o_timetml');
        $result = $grouptmlM->where($where)->find();
        $this->assign('result',$result);
        $this->display();
    }

    /*
     *O2O模板修改信息执行
     * */
    public function save(){
        $data['o2o_money'] = I('o2o_money');
        $data['o2o_nums'] = I('o2o_nums');
        $data['condition'] = I('condition');
        $data['delivery_time'] = I('delivery_time');
        $data['group_ok_time'] = I('group_ok_time');
        $id = I('id');
        $where['id'] = array('eq',$id);
        $grouptmlM = M('o2o_timetml');
        $result = $grouptmlM->where($where)->save($data);
        if($result){
            $this->success('信息修改成功',U('Ogrouptml/index'));
        }else{
            $this->error('信息修改失败');
        }
    }

    /*
     * O2O模板删除
     * */
    public function del(){
        $id = I('id');
        $where['id'] = array('eq',$id);
        $grouptmlM = M('o2o_timetml');
        $result = $grouptmlM->where($where)->delete();
        if($result){
            $this->success('模板删除成功',U('Ogrouptml/index'));
        }else{
            $this->error('模板失败');
        }
    }
}
