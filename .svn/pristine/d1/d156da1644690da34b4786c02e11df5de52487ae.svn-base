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
 * Class AreaAction
 *  地区
 */
class AreaAction extends CommonAction{

    public function index(){
        $where = array();

        $areaM = M('area');
        $count = $areaM->where($where)->count();
        $page = new Page($count, 10);
        $strPage = $page->show();
        $list = $areaM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        if(!empty($list)){
            foreach($list as $key => $item){
//                $list[$key]['isgroupbuy_only'] = 1 == $item['isgroupbuy_only'] ? '<span class="red">是</span>' : '<span class="green">否</span>';

            }
        }

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }

    /**
     *  选择地区
     */
    public function selectJson(){
        $where = array();

        $where[] = array('active' => 1);
        $where[] = array('pid' => 0);
        $areaM = M('area');
        $count = $areaM->where($where)->count();
        $page = new Page($count, 100);
        $strPage = $page->show();
        $list = $areaM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('"order" asc')->select();

        $result  = array('data' => $list, 'key' => array('id', 'name', 'order'), 'th'=>array('id', '名称', '排序'), 'page' => $strPage);
        echo json_encode($result);
    }

} 