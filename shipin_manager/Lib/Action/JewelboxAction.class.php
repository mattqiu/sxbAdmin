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
class JewelboxAction extends CommonAction{

    public function index(){
        $where = array();

        $jewelboxM = M('jewelbox_int');
        $count = $jewelboxM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $jewelboxM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }


    public function del(){
        $id = I('id', 0);
        if($id > 0){
            $droplistM = M('jewelbox_int');
            $droplistM->where('id = ' . $id)->delete();
        }
        redirect('/Jewelbox/index');
    }

    /**
     *  选择关联的掉落组

    public function selectJson_droplist(){
        $where = array();

        $couponTmlM = M('jewelbox_tml');
        $count = $couponTmlM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $couponTmlM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        $result  = array('data' => $list, 'key' => array('id', 'money', 'description', 'lifetime'), 'th'=>array('id', '金额(元)', '描述', '有效期(天)'), 'page' => $strPage);
        echo json_encode($result);
    }*/

} 