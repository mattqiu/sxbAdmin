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
 * Class GroupbuyPermissionAction
 *  优惠权限管理
 */
class GroupbuyPermissionAction extends CommonAction{

    public function index(){
        $where = array();

        $groupbuyPermissionM = M('groupbuy_permission');
        $count = $groupbuyPermissionM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $groupbuyPermissionM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        if(!empty($list)){
            foreach($list as $key => $item){
                switch($item['permission_type']){
                    case 1:
                        $list[$key]['permission_type'] = '降价指定数额';
                        break;
                    case 2:
                        $list[$key]['permission_type'] = '降价百分比';
                        break;
                    case 3:
                        $list[$key]['permission_type'] = '返现指定数额';
                        break;
                    case 4:
                        $list[$key]['permission_type'] = '返现百分比';
                        break;
                    case 5:
                        $list[$key]['permission_type'] = '固定价格购';
                        break;
                    case 6:
                        $list[$key]['permission_type'] = '免邮';
                        break;
                    case 7:
                        $list[$key]['permission_type'] = '团长统一收货优惠';
                        break;

                }

                $list[$key]['effect_range'] = 1 == $item['effect_range'] ? '<span class="red">全团</span>' : '<span class="green">本人</span>';

            }
        }

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }

    public function doCreate(){
        $permission_groupid = I('permission_groupid', 0);
        $permission_type = I('permission_type', 0);
        $permission_value = I('permission_value', 0);
        $description = I('description', '');
        $effect_range = I('effect_range', 0);

        if($permission_type > 0 && !empty($description)){
            $thisModel = M('groupbuy_permission');
            $data = array();
            $data['permission_groupid'] = $permission_groupid;
            $data['permission_type'] = $permission_type;
            $data['permission_value'] = $permission_value;
            $data['description'] = $description;
            $data['effect_range'] = $effect_range;

            $thisModel->add($data);
        }

        redirect('/GroupbuyPermission/index');
    }

    public function edit(){
        $id = I('id', 0);
        $groupbuyingPermM = M('groupbuy_permission');
        $item = $groupbuyingPermM->where('id =' . $id)->find();

        $this->assign('item', $item);
        $this->display();
    }

    public function save(){
        $id = I('id', 0);
        $permission_groupid = I('permission_groupid', 0);
        $permission_type = I('permission_type', 0);
        $permission_value = I('permission_value', 0);
        $description = I('description', '');
        $effect_range = I('effect_range', 0);

        if($permission_type > 0 && !empty($description)){
            $data = array();
            $data['permission_groupid'] = $permission_groupid;
            $data['permission_type'] = $permission_type;
            $data['permission_value'] = $permission_value;
            $data['description'] = $description;
            $data['effect_range'] = $effect_range;

            if($id> 0){
                $groupbuyingPermM = M('groupbuy_permission');
                $groupbuyingPermM->where('id = ' . $id)->save($data);
            }
        }

        redirect('/GroupbuyPermission/index');
    }

    public function del(){
        $id = I('id', 0);
        if($id > 0){
            $groupbuyingTmlM = M('groupbuy_permission');
            $groupbuyingTmlM->where('id = ' . $id)->delete();
        }
        redirect(U('/GroupbuyPermission/index'));
    }

    public function selectJson(){
        $where = array();

        $groupbuyPermissionM = M('groupbuy_permission');
        $count = $groupbuyPermissionM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $groupbuyPermissionM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        if(!empty($list)){
            foreach($list as $key => $item){
                switch($item['permission_type']){
                    case 1:
                        $list[$key]['permission_type'] = '降价指定数额';
                        break;
                    case 2:
                        $list[$key]['permission_type'] = '降价百分比';
                        break;
                    case 3:
                        $list[$key]['permission_type'] = '返现指定数额';
                        break;
                    case 4:
                        $list[$key]['permission_type'] = '返现百分比';
                        break;
                    case 5:
                        $list[$key]['permission_type'] = '固定价格购';
                        break;
                    case 6:
                        $list[$key]['permission_type'] = '免邮';
                        break;
                    case 7:
                        $list[$key]['permission_type'] = '团长统一收货优惠';
                        break;

                }

                $list[$key]['effect_range'] = 1 == $item['effect_range'] ? '<span class="red">全团</span>' : '<span class="green">本人</span>';

            }
        }
        $result  = array('data' => $list, 'key' => array('id', 'permission_groupid', 'permission_type', 'permission_value', 'description', 'effect_range'), 'th'=>array('id', '组id', '类型', '数值', '描述', '效用范围'), 'page' => $strPage);
        echo json_encode($result);
    }
} 