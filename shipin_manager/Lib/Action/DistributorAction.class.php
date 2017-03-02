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
 * Class SupplyAction
 *  分销商管理
 */
class DistributorAction extends CommonAction{

    public $distributorM;
    public function _init(){
        $this->distributorM = M('distributor');
    }

    public function index(){
        $where = array();

        $count = $this->distributorM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $this->distributorM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        if(!empty($list)){
            $supplyStatus = C('DISTRIBUTOR_STATUS');
            foreach($list as $key => $item){
                $list[$key]['status'] = $supplyStatus[$item['status']];
            }
        }

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }

    public function create(){
        $this->display();
    }

    public function edit(){
        $id = I('id', 0);
        if($id > 0){
            $row = $this->distributorM->where('id = ' . $id)->find();
            $this->assign('item', $row);
        }

        $this->display();
    }

    public function save(){
        $name = I('name', '');
        $real_name = I('real_name', '');
        $address = I('address', '');
        $mobile = I('mobile', '');
        $tel = I('tel', '');
        $certificate_no = I('certificate_no', '');
        $certificate_type = I('certificate_type', 0);
        $email = I('email', '');
        $contacts = I('contacts', '');
        $status = I('status', 0);
        $create_time = time();

        $id = I('id', 0);

        if(!empty($name)){
            $data = array();
            $data['name'] = $name;
            $data['real_name'] = $real_name;
            $data['address'] = $address;
            $data['mobile'] = $mobile;
            $data['tel'] = $tel;
            $data['certificate_no'] = $certificate_no;
            $data['certificate_type'] = $certificate_type;
            $data['email'] = $email;
            $data['contacts'] = $contacts;
            $data['status'] = $status;
            $data['create_time'] = $create_time;
            $data['distributor_id'] = md5($name);

            $data['api_key'] = $this->getApiKey($data['name']);
            $data['api_secret'] = $this->getApiSecret($data['api_key']);


            if($id > 0){
                $this->distributorM->where('id = ' . $id)->save($data);
            } else {
                $this->distributorM->add($data);
            }

        }


        redirect('/Distributor/index');
    }

    private function getApiKey($str){

        return strtoupper(md5($str));

    }

    private function getApiSecret($str){
        return strtoupper(md5(substr(md5($str . rand(1000, 9999)), rand(0, 10), 10)));
    }
} 