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
class SendwarehomeAction extends CommonAction{

    public function index(){
        $where = array();

        $send_warehomeM = M('send_warehome');
        $suplyM = M('supply');
        $count = $send_warehomeM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $send_warehomeM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        if(!empty($list)){
            foreach($list as $key => $item){
                $supply = $suplyM->where("id=".$item['supply_id'])->find();
                if(!empty($supply))
                {
                    $list[$key]['supply_name'] = $supply['real_name'];
                }
                else{
                    $list[$key]['supply_name'] = '查询出错';
                }

            }
        }

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }

    public function create(){
        $this->display();
    }

    public function doCreate(){
        $name = I('name', "");
        $supply_id = I('supply_id', 0);
        $jd_warehome_code = I('jd_warehome_code');
        $en_name = I('en_name');
        $source_city = I('source_city');
        $send_warehomeM = M('send_warehome');

        if(!empty($name)){

            $data['name'] =  $name;
            $data['supply_id'] =  $supply_id;
            $data['jd_warehome_code'] =  $jd_warehome_code;
            $data['en_name'] =  $en_name;
            $data['source_city'] =  $source_city;
            $result = $send_warehomeM->add($data);
            if($result){
                $this->success("发货仓添加成功",U('Sendwarehome/index'));
            }else{
                $this->error("发货仓添加失败");
            }
        }
    }

    public function del(){
        $id = I('id', 0);
        if($id > 0){
            $send_warehomeM = M('send_warehome');
            $result = $send_warehomeM->where('id = ' . $id)->delete();
            if($result){
                $this->success("发货仓删除成功",U('Sendwarehome/index'));
            }else{
                $this->error("发货仓删除失败");
            }
        }
    }

    public function edit()
    {
        $id = I('id', 0);
        $areaM = M('send_warehome');
        $item = $areaM->where('id =' . $id)->find();

        $this->assign('item', $item);
        $this->display("edit");
    }
    public function save()
    {
        $id = I('id', "");
        $name = I('name', "");
        $supply_id = I('supply_id_edit', 0);
        $jd_warehome_code = I('jd_warehome_code');
        $en_name = I('en_name');
        $source_city = I('source_city');

        $data['name'] =  $name;
        $data['supply_id'] =  $supply_id;
        $data['jd_warehome_code'] =  $jd_warehome_code;
        $data['en_name'] =  $en_name;
        $data['source_city'] =  $source_city;

        $send_warehomeM = M('send_warehome');

        if($id != 0)
        {
            $res = $send_warehomeM->where('id = ' . $id)->save($data);
            if($res > 0){
                $this->success("修改成功",U('Sendwarehome/index'));
            }else{
                $this->error("修改失败");
            }
        }

    }

    /**
     *  选择关联的优惠券模板
     */
    public function selectJson(){
        $where = array();

        $SupplyM = M('supply');
        $count = $SupplyM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $SupplyM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        $result  = array('data' => $list, 'key' => array('id', 'name', 'real_name'), 'th'=>array('id', '发货渠道', '发货渠道名', ), 'page' => $strPage);
        echo json_encode($result);
    }

} 