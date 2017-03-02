<?php

/*
 * 二维码管理
 * */
class GroupcodeAction extends CommonAction{
    const PAGE_NUM = 500;
    /*
     * 二维码列表
     * */
    public function index(){
        $grouWxCodeM = M('groupbuying_wx_group');
        $groupbuyingM = M('groupbuying');
        $where['wx_erweima_id'] = array('neq',0);
        $groupEWM = $groupbuyingM->field('count(id) total_num,id,wx_erweima_id')->where($where)->group('wx_erweima_id')->select();
//    dump($groupEWM);
        $data = $grouWxCodeM->select();
        $page = new Page(count($data),self::PAGE_NUM);
        $show = $page->show();
        $result = $grouWxCodeM->limit($page->firstRow,$page->listRows)->select();
//dump($result);

        foreach ($result as $key=>$val){
            $list[md5($val['id'])] = array(
                    'id' => $val['id'],
                    'img'=>$val['img'],
                    'status' =>$val['status'],
                    'group_num'=>$val['group_num'],
                    'groupbuying_id'=>$val['groupbuying_id'],
                    'add_time'=>$val['add_time'],
                    'expir_time'=>$val['expir_time'],
                    'wx_no'=>$val['wx_no']
                );
        }

        foreach($groupEWM as $key=>$val){
            $list[md5($val['wx_erweima_id'])]['group_num'] = $val['total_num'];
            $list[md5($val['wx_erweima_id'])]['groupbuying_id'] = $val['id'];
        }
//        dump($result);
        foreach($list as $key=>$val){
            $group_num[$key] =$val['group_num'];
        }
        array_multisort($group_num,SORT_DESC,$list);
//dump($result);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();

    }

    /*
     * 添加一个二维码
     * */
    public function add(){
        $this->display();
    }

    /*
     * 执行添加操作
     * */
    public function doadd(){
        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileFix = explode('.', $_FILES['import_file']['name']);
        $fileName = md5($_FILES['import_file']['name'] . time()) . '.' . $fileFix[1];
        $uploadFile = $savePath . $fileName;
        move_uploaded_file($_FILES['import_file']['tmp_name'], $uploadFile);
        $result = $this->importExecl($uploadFile);
        if(!empty($result['data'])){
            $groupWxCodeM = M('groupbuying_wx_group');
            $list = 0;
            foreach($result['data'] as $key=>$val){
                if($key > 1){
                    $data = array();
                    $data['id'] = $val['A'];
                    $data['img'] = $val['B'];
                    $list += $groupWxCodeM->add($data);
                }
            }
            if($list){
                $this->success('二维码上传成功',U('Groupcode/index'));
            }
        }
    }

    /*
     * 输出编辑二维码的页面
     * */
    public function edit(){
        $id = I('id');
        $groupWxCodeM = M('groupbuying_wx_group');
        $where['id'] = array('eq',$id);
        $result = $groupWxCodeM->where($where)->find();
        $this->assign('data',$result);
        $this->display();
    }

    /*
     * 执行修改二维码的操作
     * */
    public function save(){
        $id = I('id');
        $data['img'] = I('img');
        $data['status'] = I('status');
        $data['group_num'] = I('group_num');
        $where['id'] = array('eq',$id);
        $groupWxCodeM = M('groupbuying_wx_group');
        $result = $groupWxCodeM->where($where)->save($data);
        if($result){
            $this->success('二维码修改成功',U('Groupcode/index'));
        }else{
            $this->error('二维码修改失败');
        }
    }

    /*
     * 删除
     * */
    public function del(){
        $id = I('id');
        $groupWxCodeM = M('groupbuying_wx_group');
        $where['id'] = array('eq',$id);
        $result = $groupWxCodeM->where($where)->delete();
        if($result){
            $this->success('二维码删除成功',U('Groupcode/index'));
        }else{
            $this->error('二维码删除失败');
        }
    }

}