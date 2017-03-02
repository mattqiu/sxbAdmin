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
 * Class GroupbuyLeaderPermissionAction
 * 团长等级管理
 */
class GroupbuyLeaderPermissionAction extends CommonAction{

    public function index(){
        $where = array();

        $groupbuyLeaderPermissionM = M('groupbuy_leader_permission');
        $count = $groupbuyLeaderPermissionM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $groupbuyLeaderPermissionM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('level desc')->select();

        if(!empty($list)){
            $groupbuy_permissionM = M('groupbuy_permission');

            foreach($list as $key => $item){
                $js_permission = json_decode($item['permission'],true);
                $permissonids = array_column($js_permission,'permission_id');
                $permissonids = implode(',', $permissonids);

                $array_permissonid2per_data = array();
                foreach($js_permission as $permkey => $permitem){
                    $array_permissonid2per_data[$permitem['permission_id']] = $permitem;
                }

                $permissionList = $groupbuy_permissionM->where('id IN(' . $permissonids . ')')->select();

                $permissionListName = array();
                if(!empty($permissionList)){
                    foreach($permissionList as $permission){
                        $permissionListName[] = $permission['description'] . "(" . $permission['id'] . ") 每月可用：".$array_permissonid2per_data[$permission['id']]['canuse_num_months'].'次';
                    }
                }
                $list[$key]['isgroupbuy_only'] = 1 == $item['isgroupbuy_only'] ? '<span class="red">是</span>' : '<span class="green">否</span>';
                $list[$key]['coupon_type'] = 1 == $item['coupon_type'] ? '<span class="red">团购</span>' : '<span class="green">普通</span>';
                $list[$key]['permission'] = implode('<br/>', $permissionListName);

            }
        }

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }

    public function doCreate(){
        $level = I('level', 0);
        $req_complete_num = I('req_complete_num', 0);
        $level_title = I('level_title', '无称号');
        $sms_send_skill_text = I('sms_send_skill_text', '无名称');

        $array_permission_ids = $_REQUEST['permission_id'];
        $array_canuse_num_months = $_REQUEST['canuse_num_month'];

        $permission_data = array();

        for($i=0;$i<count($array_permission_ids);$i++)
        {
            $permission_data_one = array(
                'permission_id'=>$array_permission_ids[$i],
                'canuse_num_months'=>$array_canuse_num_months[$i]
            );
            $permission_data[] = $permission_data_one;
        }


        if($level > 0 && $req_complete_num > 0 && !empty($permission_data)){
            $thisModel = M('groupbuy_leader_permission');
            $data = array();
            $data['level'] = $level;
            $data['req_complete_num'] = $req_complete_num;
            $data['leveltitle'] = $level_title;
            $data['sms_send_skill_text'] = $sms_send_skill_text;

            $data['permission'] = json_encode($permission_data);

            $thisModel->add($data);
        }

        redirect('/GroupbuyLeaderPermission/index');
    }

    public function edit(){
        $level = I('level', 0);
        $thisModel = M('groupbuy_leader_permission');
        $item = $thisModel->where('level = ' . $level)->find();
        $item['permission'] = json_decode($item['permission'],true);
        $this->assign('item', $item);
        $this->assign('permission_data', $item['permission']);
        $this->assign('count', count($item['permission']));


        $this->display();
    }

    public function save(){
        //编辑更新

        $level = I('level', 0);
        $req_complete_num = I('req_complete_num', 0);
        $level_title = I('level_title', '无称号');
        $sms_send_skill_text = I('sms_send_skill_text', '无名称');

        $array_permission_ids = $_REQUEST['permission_id'];
        $array_canuse_num_months = $_REQUEST['canuse_num_month'];

        $permission_data = array();

        for($i=0;$i<count($array_permission_ids);$i++)
        {
            $permission_data_one = array(
                'permission_id'=>$array_permission_ids[$i],
                'canuse_num_months'=>$array_canuse_num_months[$i]
            );
            $permission_data[] = $permission_data_one;
        }

        if($level > 0 && $req_complete_num > 0 && !empty($permission_data)){
            $thisModel = M('groupbuy_leader_permission');
            $data = array();
            $data['level'] = $level;
            $data['req_complete_num'] = $req_complete_num;
            $data['leveltitle'] = $level_title;
            $data['sms_send_skill_text'] = $sms_send_skill_text;

            $data['permission'] = json_encode($permission_data);

            $thisModel->where('level = ' . $level)->save($data);
        }

        redirect('/GroupbuyLeaderPermission/index');
    }

    public function del(){
        $level = I('level', 0);
        if($level > 0){
            $droplistM = M('groupbuy_leader_permission');
            $droplistM->where('level = ' . $level)->delete();
        }
        redirect('/GroupbuyLeaderPermission/index');
    }
} 