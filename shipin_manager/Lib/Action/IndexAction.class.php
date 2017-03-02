<?php                                                                 // +----------------------------------------------------------------------
// | 时品网
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2013 http://shipinmmm.com All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Paul
// +----------------------------------------------------------------------
// | @version: $Id: IndexAction.class.php 836 2014-10-06 03:36:14Z yihua.ying $
class IndexAction extends CommonAction {
    
    // thinkphp 内置构造函数
//    public function _initialize() {
//        $this->checkIsLogin();
//    }
    
    function index() {

        $tmpJdM = M('tmp_jd_order');
        $list = $tmpJdM->limit(0, 2000)->select();
        $orderIds = array();
        foreach($list as $item){
            $orderIds[] = $item['order_name'];
        }

        $where = array();
        $where['order_name'] = array('in', $orderIds);
        $data = $tmpJdM->where($where)->select();
        echo '<span style="display: none;">  ===sql===' . $tmpJdM->getLastSql() . '</span>';
        //var_dump($data);

//        var_dump($_SESSION);
        $this->assign('title', "叔小白-管理中心");
        $this->display();
    }


    /**
     * 初始化微信二维码图片库
     */
    public function initWxGroupImg(){
        $imgSite = '';
        $groupbuyingWxGroupM = M('groupbuying_wx_group');

        $n=10;
        for($i=1; $i<$n; $i++){
            $img = $imgSite . '/upload/images/wxgroup/' . $i . '.jpg';
            $data = array();
            $data['img'] = $img;
            $groupbuyingWxGroupM->add($data);
        }
    }
}
