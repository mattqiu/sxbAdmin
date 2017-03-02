<?php
// +----------------------------------------------------------------------
// | 时品
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://m.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id$ 

/**
 * Class CouponTemplAction
 *  优惠券模板管理
 */
class JewelboxTmlAction extends CommonAction{

    public function index(){
        $where = array();

        $jewelboxTmlM = M('jewelbox_tml');
        $count = $jewelboxTmlM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $jewelboxTmlM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }

    public function add(){
        $this->display('create');
    }

    public function edit(){

        $id = I('id', 0);
        $jewelboxTmlM = M('jewelbox_tml');
        $item = $jewelboxTmlM->where('id =' . $id)->find();

        $this->assign('id', $id);
        $this->assign('item', $item);
        $this->display('edit');
    }

    public function save(){
        $type = I('type', 0);
        $need_key_num = I('need_key_num', 1);
        $drop_group_id = I('drop_group_id', 0);
        $lifetime = I('lifetime', 0);
        $description = I('description', '');
        $sms_show_name = I('sms_show_name',0);
        $sms_send_type = I('sms_send_type', 0);


        if($lifetime > 0 && !empty($description)){
            $jewelboxTmlM = M('jewelbox_tml');
            $data = array();
            $data['type'] = $type;
            $data['need_key_num'] =  $need_key_num;
            $data['drop_group_id'] =  $drop_group_id;
            $data['lifetime'] =  $lifetime;
            $data['description'] =  $description;
            $data['sms_send_showtext'] = $sms_show_name;
            $data['sms_send_type'] = $sms_send_type;

            $jewelboxTmlM->add($data);
        }

        redirect('/JewelboxTml/index');
    }

    public function del(){
        $id = I('id', 0);
        if($id > 0){
            $droplistM = M('jewelbox_tml');
            $droplistM->where('id = ' . $id)->delete();
        }
        redirect('/JewelboxTml/index');
    }

    /**
     *  选择宝盒
    */
    public function selectJson(){
        $where = array();

        $jewelboxTmlM = M('jewelbox_tml');
        $count = $jewelboxTmlM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $jewelboxTmlM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        $result  = array('data' => $list, 'key' => array('id', 'type', 'description', 'lifetime','drop_group_id'), 'th'=>array('id', '宝盒类型', '描述', '有效期(天)','掉落组id'), 'page' => $strPage);
        echo json_encode($result);
    }

} 