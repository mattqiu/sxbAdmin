<?php                                                                 // +----------------------------------------------------------------------
// | 时品网
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2013 http://shipinmmm.com All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Paul
// +----------------------------------------------------------------------
// | @version: $Id: CommonAction.class.php 1528 2014-10-12 09:54:16Z yihua.ying $ 
class CommonAction extends Action {
    protected $result;

    function _initialize() {
        if(empty($_SESSION)){
            $this->redirect("Public/index");
        }
        $mname = MODULE_NAME; //获取控制器名
        $aname = strtolower(ACTION_NAME); //获取方法名
        $nodelist = $_SESSION['nodelist'];
        // dump($nodelist);
        if($_SESSION['user_name'] != 'shipinadmin'){
            //验证操作权限
            if(empty($nodelist[$mname]) || !in_array($aname,$nodelist[$mname])){
                $this->redirect('Index/index',3,'您没有权限操作此方法！');
                exit;
            }

        }

        header("Content-Type:text/html; charset=utf8");

        // import("ORG.Util.RBAC");
        // // 检查认证
        // if(RBAC::checkAccess()) {
        //     //检查认证识别号
        //     //没有登录,则跳转到登录页面
        //     if(!$_SESSION[C('USER_AUTH_KEY')]) {
        //         //跳转到认证网关
        //         redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
        //     }
        //     // 检查权限
        //     if(!RBAC::AccessDecision()) {
        //         $this->error('没有权限！');
        //     }
        // }

        // $listRow = C('LIST_ROW');
        // $accessList = $_SESSION['_ACCESS_LIST'];
        // $menus = array();
        // if(!empty($accessList)){
        //     $nodeM = M('node');
        //     $menuId = 1;
        //     foreach($accessList[strtoupper(APP_NAME)] as $key => $item){
        //         $model = ucfirst(strtolower($key));
        //         $modelItem = $nodeM->where('name ="' . $model . '"')->find();
        //         $menuItem = array('menuid' => $menuId, 'icon' => 'icon-sys', 'menuname' => $modelItem['title']);
        //         $subMenus = array();
        //         foreach($item as $action => $nodeId){
        //             $actItem = $nodeM->where('id = ' . $nodeId . ' AND is_nav = 1')->find();
        //             if(!empty($actItem)){
        //                 $menuId++;
        //                 $subMenu = array('menuid' => $menuId, 'menuname' => $actItem['title'],
        //                     'icon' => 'icon-nav', 'url' => '__APP__?m=' . $model . '&a=' . $actItem['name']);
        //                 $subMenus[] = $subMenu;
        //             }
        //         }
        //         $menuItem['menus'] = $subMenus;
        //         $menus[] = $menuItem;
        //         $menuId++;
        //     }
        // }
        //        $this->assign('menus', json_encode($menus));
        $menus = array();
        $menus[] = array(
            'title' => '首页',
            'son'=>array(
                array('link'=> '__APP__/Index/index', 'name' => '首页', 'is_active' => 0,'way_name' => 'index','act_name'=>'Index')
            ),
            'act_name' => array('IndexAction')
        );

        $menus[] = array(
            'title' => '商品管理',
            'son'=>array(
                array('link'=> '__APP__/Product/index', 'name' => '商品列表', 'is_active' => 0,'way_name' => 'index','act_name' =>'Product')
            ),
            'act_name' => array('ProductAction')
        );

        $menus[] = array(
            'title' => '团购管理',
            'son'=>array(
                array('link'=> '__APP__/GroupBuyingTml/index', 'name' => '团购模板管理', 'is_active' => 0,'way_name' =>'index','act_name' =>'GroupBuyingTml' ),
                array('link'=> '__APP__/GroupBuying/index', 'name' => '团购开团管理', 'is_active' => 0,'way_name' => 'index','act_name'=>'GroupBuying'),
                array('link'=> '__APP__/GroupBuying/joinindex', 'name' => '拼团', 'is_active' => 0,'way_name' => 'joinindex','act_name'=>'GroupBuying'),
                array('link'=> '__APP__/GroupBuying/setWxMiddlePage', 'name' => '微信中间页', 'is_active' => 0,'way_name' => 'setWxMiddlePage','act_name'=>'GroupBuying'),
                array('link'=> '__APP__/GroupBuying/choujiangindex', 'name' => '集中抽奖操作', 'is_active' => 0,'way_name' => 'choujiangindex','act_name'=>'GroupBuying'),
                array('link'=> '__APP__/GroupBuying/returnMoney_LuckDraw', 'name' => '集中抽奖退款操作', 'is_active' => 0,'way_name' => 'returnMoney_LuckDraw','act_name'=>'GroupBuying'),
                array('link'=> '__APP__/GroupBuying/sidesplicingindex', 'name' => '身边拼实例', 'is_active' => 0,'way_name' => 'sidesplicingindex','act_name'=>'GroupBuying'),
            ),
            'act_name' => array('GroupBuyingTmlAction','GroupBuyingAction')
        );
        $menus[] = array(
            'title' => '团购订单管理',
            'son'=>array(
                array('link'=> '__APP__/GroupBuyingOrder/index', 'name' => '团购订单管理', 'is_active' => 0,'way_name' => 'index','act_name'=>'GroupBuyingOrder')
            ),
            'act_name' => array('GroupBuyingOrderAction')
        );

        $menus[] = array(
            'title' => '广告位管理',
            'son'=>array(
                array('link'=> '__APP__/Appbanner/index', 'name' => '首页广告位', 'is_active' => 0 , 'way_name' => 'index','act_name'=>'Appbanner')
            ),
            'act_name' => array('AppbannerAction')
        );

        $menus[] = array(
            'title' => '订单管理',
            'son'=>array(
                array('link'=> '__APP__/Order/index', 'name' => '订单列表', 'is_active' => 0,'way_name' => 'index','act_name'=>'Order'),
                array('link'=> '__APP__/JdOrder/ttgyShWarehouse', 'name' => '果园上海仓打印', 'is_active' => 0,'way_name' => 'ttgyShWarehouse','act_name'=>'JdOrder'),
                array('link'=> '__APP__/JdOrder/ttgyBjWarehouse', 'name' => '果园北京仓打印', 'is_active' => 0,'way_name' => 'ttgyBjWarehouse','act_name'=>'JdOrder'),
                array('link'=> '__APP__/JdOrder/xppTtgyShWarehouse', 'name' => '果园上海仓打印2', 'is_active' => 0,'way_name' => 'xppTtgyShWarehouse','act_name'=>'JdOrder'),
                array('link'=> '__APP__/JdOrder/ttgyCdWarehouse', 'name' => '果园成都仓打印', 'is_active' => 0,'way_name' => 'ttgyCdWarehouse','act_name'=>'JdOrder'),
                array('link'=> '__APP__/JdOrder/ttgySzWarehouse', 'name' => '果园广州仓打印', 'is_active' => 0,'way_name' => 'ttgySzWarehouse','act_name'=>'JdOrder'),


                array('link'=> '__APP__/JdOrder/index', 'name' => '订单打印与发货', 'is_active' => 0,'way_name' => 'index','act_name'=>'JdOrder'),
                array('link'=> '__APP__/JdOrder/xppOrder', 'name' => '宁波神猴订单', 'is_active' => 0,'way_name' => 'xppOrder','act_name'=>'JdOrder'),
                array('link'=> '__APP__/JdSend/index', 'name' => '导入京东发货单管理', 'is_active' => 0,'way_name' => 'index','act_name'=>'JdSend')
            ),
            'act_name' => array('JdOrderAction')

        );

        $menus[] = array(
            'title' => '抢购管理',
            'son'=>array(
                array('link'=> '__APP__/PanicBuying/index', 'name' => '抢购列表', 'is_active' => 0,'way_name' => 'index','act_name'=>'PanicBuying')
            ),
            'act_name' => array('PanicBuyingAction')
        );

        $menus[] = array(
            'title' => '商品分类管理',
            'son'=>array(
                array('link'=> '__APP__/ProductClass/index', 'name' => '商品分类列表', 'is_active' => 0 ,'way_name' => 'index','act_name'=>'ProductClass')
            ),
            'act_name' => array('ProductClassAction')
        );


        $menus[] = array(
            'title' => '退款管理',
            'son'=>array(
                array('link'=> '__APP__/OrderRefund/alipayRefund', 'name' => '支付宝退款', 'is_active' => 0 ,'way_name' => 'alipayRefund','act_name'=>'OrderRefund')
            ),
            'act_name' => array('OrderRefundAction')
        );

        $menus[] = array(
            'title' => '评价管理',
            'son'=>array(
                array('link'=> '__APP__/Comment/index', 'name' => '评价管理', 'is_active' => 0,'way_name' => 'index','act_name'=>'Comment'),
                array('link'=> '__APP__/Comment/tml', 'name' => '评价模板', 'is_active' => 0,'way_name' => 'tml','act_name'=>'Comment'),
                array('link'=> '__APP__/Comment/commentproduct', 'name' => '评价商品', 'is_active' => 0,'way_name' => 'commentproduct','act_name'=>'Comment')
            ),
            'act_name' => array('CommentAction')
        );
        $menus[] = array(
            'title' => '邮费管理',
            'son'=>array(
                array('link'=> '__APP__/Postage/index', 'name' => '邮费管理', 'is_active' => 0,'way_name' => 'index','act_name'=>'Postage')
            ),
            'act_name' => array('PostageAction')
        );
        $menus[] = array(
            'title' => '发货仓管理',
            'son'=>array(
                array('link'=> '__APP__/Sendwarehome/index', 'name' => '发货仓管理', 'is_active' => 0,'way_name' => 'index','act_name'=>'Sendwarehome'),
                array('link'=> '__APP__/Sendwarehome/create', 'name' => '添加发货仓', 'is_active' => 0,'way_name' => 'create','act_name'=>'Sendwarehome')
            ),
            'act_name' => array('SendwarehomeAction')
        );
        $menus[] = array(
            'title' => 'O2O商户管理',
            'son'=>array(
                array('link'=> '__APP__/Omerchant/index', 'name' => '商户列表', 'is_active' => 0,'way_name' => 'index','act_name'=>'Omerchant'),
                array('link'=> '__APP__/Omerchant/add', 'name' => '商户添加', 'is_active' => 0,'way_name' => 'add','act_name'=>'Omerchant'),
            ),
            'act_name' => array('OmerchantAction')
        );
        $menus[] = array(
            'title' => 'O2O商户实例管理',
            'son'=>array(
                array('link'=> '__APP__/Omerchantmsg/index', 'name' => '实例列表', 'is_active' => 0,'way_name' => 'index','act_name'=>'Omerchantmsg'),
                array('link'=> '__APP__/Omerchantmsg/add', 'name' => '实例添加', 'is_active' => 0,'way_name' => 'add','act_name'=>'Omerchantmsg'),
            ),
            'act_name' => array('OmerchantmsgAction')
        );
        $menus[] = array(
            'title' => 'O2O团购模板管理',
            'son'=>array(
                array('link'=> '__APP__/Ogrouptml/index', 'name' => '模板列表', 'is_active' => 0,'way_name' => 'index','act_name'=>'Ogrouptml'),
                array('link'=> '__APP__/Ogrouptml/add', 'name' => '模板添加', 'is_active' => 0,'way_name' => 'add','act_name'=>'Ogrouptml'),
            ),
            'act_name' => array('OgrouptmlAction')
        );
        $menus[] = array(
            'title' => 'O2O商户商品库存管理',
            'son'=>array(
                array('link'=> '__APP__/Ostock/index', 'name' => '商户列表', 'is_active' => 0,'way_name' => 'index','act_name'=>'Ostock'),
            ),
            'act_name' => array('OstockAction')
        );

        $menus[] = array(
            'title' => '用户管理',
            'son'=>array(
                array('link'=> '__APP__/User/index', 'name' => '普通用户管理', 'is_active' => 0,'way_name' => 'index','act_name'=>'User'),
                array('link'=> '__APP__/User/user_robot', 'name' => '机器人用户管理', 'is_active' => 0,'way_name' => 'user_robot','act_name'=>'User'),
                array('link'=> '__APP__/User/removeRepeatUserWx', 'name' => '微信用户重复查看', 'is_active' => 0,'way_name' => 'removeRepeatUserWx','act_name'=>'User')
            ),
            'act_name' => array('UserAction')
        );

        $menus[] = array(
            'title' => '黑名单管理',
            'son'=>array(
                array('link'=> '__APP__/BlackList/index', 'name' => '黑名单用户列表', 'is_active' => 0,'way_name' => 'index','act_name'=>'BlackList'),
                array('link'=> '__APP__/BlackList/add', 'name' => '添加用户至黑名单', 'is_active' => 0,'way_name' => 'add','act_name'=>'BlackList')        
            ),
            'act_name' => array('BlackListAction')
        );

        $menus[] = array(
            'title' => '优惠策略管理',
            'son'=>array(
                array('link'=>'__APP__/CouponTactic/index','name' => '优惠策略','is_active' => 0,'way_name' => 'index','act_name'=>'CouponTactic'),
            ),
            'act_name' => array('CouponTacticAction')
        );

        $menus[] = array(
            'title' => '优惠管理',
            'son'=>array(
                array('link'=> '__APP__/Coupon/index', 'name' => '优惠券', 'is_active' => 0,'way_name' => 'index','act_name'=>'Coupon'),
                array('link'=> '__APP__/CouponTempl/index', 'name' => '优惠券模板', 'is_active' => 0,'way_name' => 'index','act_name'=>'CouponTempl'),
                array('link'=> '__APP__/GroupbuyPermission/index', 'name' => '优惠权限', 'is_active' => 0,'way_name' => 'index','act_name'=>'GroupbuyPermission'),
                array('link'=> '__APP__/GroupbuyLeaderPermission/index', 'name' => '团长等级', 'is_active' => 0,'way_name' => 'index','act_name'=>'GroupbuyLeaderPermission'),
                array('link'=> '__APP__/Droplist/index', 'name' => '掉落组', 'is_active' => 0,'way_name' => 'index','act_name'=>'Droplist'),
                array('link'=> '__APP__/CouponSend/index', 'name' => '发放优惠券', 'is_active' => 0,'way_name' => 'index','act_name'=>'CouponSend')
            ),
            'act_name' => array('CouponAction','CouponTemplAction','GroupbuyPermissionAction','GroupbuyLeaderPermissionAction','DroplistAction','CouponSendAction')
        );

        $menus[] = array(
            'title' => '宝盒管理',
            'son'=>array(
                array('link'=> '__APP__/JewelboxTml/index', 'name' => '宝盒模板', 'is_active' => 0, 'act_name' => 'JewelboxTmlAction'),
                array('link'=> '__APP__/Jewelbox/index', 'name' => '宝盒', 'is_active' => 0, 'act_name' => 'JewelboxAction'),

            )
        );



        $menus[] = array(
            'title' => '供应商管理',
            'son'=>array(
                array('link'=> '__APP__/Supply/index', 'name' => '供应商管理', 'is_active' => 0,'way_name' => 'index','act_name'=>'Supply')
            ),
            'act_name' => array('SupplyAction')
        );

        $menus[] = array(
            'title' => '分销商管理',
            'son'=>array(
                array('link'=> '__APP__/Distributor/index', 'name' => '分销商管理', 'is_active' => 0,'way_name' => 'index','act_name'=>'Distributor')
            ),
            'act_name' => array('DistributorAction')
        );

        $menus[] = array(
            'title' => '节点管理',
            'son'=>array(
                array('link'=>'__APP__/Node/index','name' => '节点列表','is_active' => 0,'way_name' => 'index','act_name'=>'Node'),
                array('link'=>'__APP__/Node/add','name' => '节点添加','is_active' => 0,'way_name' => 'add','act_name'=>'Node'),
            ),
            'act_name' => array('NodeAction')
        );

        $menus[] = array(
            'title' => '角色管理',
            'son'=>array(
                array('link'=>'__APP__/Role/index','name' => '角色列表','is_active' => 0,'way_name' => 'index','act_name'=>'Role'),
                array('link'=>'__APP__/Role/add','name' => '角色添加','is_active' => 0,'way_name' => 'add','act_name'=>'Role'),
            ),
            'act_name' => array('RoleAction')
        );

        $menus[] = array(
            'title' => '后台用户管理',
            'son'=>array(
                array('link'=>'__APP__/Admin/index','name' => '用户列表','is_active' => 0,'way_name' => 'index','act_name'=>'Admin'),
                array('link'=>'__APP__/Admin/add','name' => '用户添加','is_active' => 0,'way_name' => 'add','act_name'=>'Admin'),
            ),
            'act_name' => array('AdminAction')

        );
        $menus[] = array(
            'title' => '数据报表查看',
            'son'=>array(
                array('link'=>'__APP__/DataReport/redpackSendData','name' => '红包发放报表','is_active' => 0,'way_name' => 'redpackSendData','act_name'=>'DataReport'),
                array('link'=>'__APP__/DataReport/userIntimate','name' => '用户亲密度报表','is_active' => 0,'way_name' => 'userIntimate','act_name'=>'DataReport'),
                array('link'=>'__APP__/DataReport/dynamicUser','name' => '活跃用户报表','is_active' => 0,'way_name' => 'dynamicUser','act_name'=>'DataReport'),
                array('link'=>'__APP__/DataReport/group','name' => '团购报表','is_active' => 0,'way_name' => 'group','act_name'=>'DataReport'),
                array('link'=>'__APP__/DataReport/index','name' => '用户报表','is_active' => 0,'way_name' => 'index','act_name'=>'DataReport'),
                array('link'=>'__APP__/DataReport/order','name' => '订单报表','is_active' => 0,'way_name' => 'order','act_name'=>'DataReport'),
//                array('link'=>'__APP__/DataReport/volume','name' => '销量统计','is_active' => 0,'way_name' => 'volume','act_name'=>'DataReport'),
                array('link'=>'__APP__/DataReport/wxShareLog','name' => '微信分享日志','is_active' => 0,'way_name' => 'wxShareLog','act_name'=>'DataReport'),
//                array('link'=>'__APP__/DataReport/orderDeliver','name' => '订单发货报表','is_active' => 0,'way_name' => 'orderDeliver','act_name'=>'DataReport'),
//                array('link'=>'__APP__/DataReport/goods','name' => '商品报表','is_active' => 0,'way_name' => 'goods','act_name'=>'DataReport'),
                array('link'=>'__APP__/DataReport/coupon','name' => '优惠券报表','is_active' => 0,'way_name' => 'coupon','act_name'=>'DataReport'),
            ),
            'act_name' => array('DataReportAction')
        );

        $menus[] = array(
            'title' => '商品销售数据分析',
            'son'=>array(
                array('link'=>'__APP__/ProductSaleData/index','name' => '销量统计','is_active' => 0,'way_name' => 'index','act_name'=>'ProductSaleData'),
            ),
            'act_name' => array('ProductSaleDataAction')
        );

        $menus[] = array(
            'title' => '群二维码管理',
            'son'=>array(
                array('link'=>'__APP__/Groupcode/index','name' => '信息列表','is_active' => 0,'way_name' => 'index','act_name'=>'Groupcode'),
                array('link'=>'__APP__/Groupcode/add','name' => '信息添加','is_active' => 0,'way_name' => 'add','act_name'=>'Groupcode')
            ),
            'act_name' => array('GroupcodeAction')

        );

        $menus[] = array(
            'title' => '外部订单导入发货',
            'son'=>array(
                array('link'=>'__APP__/OpenOrder/index','name' => '外部订单','is_active' => 0,'way_name' => 'index','act_name'=>'OpenOrder'),
            ),
            'act_name' => array('OpenOrderAction')

        );

        $menus[] = array(
            'title' => '微信设置',
            'son'=>array(
                array('link'=>'__APP__/WxMaterial/getMaterialList','name' => '微信素材列表','is_active' => 0,'way_name' => 'getMaterialList','act_name'=>'WxMaterial'),
                array('link'=>'__APP__/WxMenu/edit','name' => '微信菜单设置','is_active' => 0,'way_name' => 'edit','act_name'=>'WxMenu'),
            ),
            'act_name' => array('RdsBinlogAction')

        );

        $menus[] = array(
            'title' => '系统管理',
            'son'=>array(
                array('link'=>'__APP__/RdsBinlog/index','name' => 'RDS 2进制日志','is_active' => 0,'way_name' => 'index','act_name'=>'RdsBinlog'),
            ),
            'act_name' => array('RdsBinlogAction')

        );

        $menus[] = array(
            'title' => '减价活动模板',
            'son'=>array(
                array('link'=> '__APP__/BargainActivityTml/index', 'name' => '模板列表', 'is_active' => 0,'way_name' => 'index','act_name'=>'BargainActivityTml'),
            ),
            'act_name' => array('BargainActivityTmlAction')
        );


        // dump($_SESSION);

        $arr = array();
        foreach ($_SESSION['nodelist'] as $key=>$value){
            $arr[] = $key.'Action';             //获取类名
            foreach($value as $v){
                $way[] = $key."/".strtolower($v);           //获取方法名
            }
        }

        if($_SESSION['user_name'] != 'shipinadmin'){

            foreach($menus as $key=>$itemMenu){
                foreach($itemMenu['act_name'] as $akey => $act){
                    $actTag = $act;
                    // dump($actTag);
                    if(in_array($actTag , $arr)){
                        $rolemenus[] = $menus[$key];
                        // dump($menus[$key]);
                    }
                }
            }
        }else{
            for($i = 0;$i<count($menus);$i++){
                $rolemenus = $menus;
            }
        }

        if($_SESSION['user_name'] != 'shipinadmin'){
            foreach ($rolemenus as $key => $itemMenu) {
                foreach ($itemMenu['son'] as $sonKey => $sonMenu) {
                    $menuTag = $sonMenu['act_name'] . '/' . strtolower($sonMenu['way_name']);
                    if(!in_array($menuTag, $way)){
                        unset($rolemenus[$key]['son'][$sonKey]);
                    }
                }
            }
        }


        foreach($menus as $key => $menuSon){
            foreach($menuSon as $item){
                $class = get_class($this);
                if($class == $item['act_name']){
                    $menus[$key]['is_active'] = 1;
                }
            }
        }
        $this->assign('menus', $rolemenus);
        $this->result = array('status' => 0, 'msg' => '', 'data' => array(), 'log' => '');
        $this->assign('frontSiteUrl', C('FRONT_SITE_URL'));
        $this->assign('publicSiteUrl', C('PUBLIC_SITE_URL'));
        $this->assign('img_site', C('IMG_SITE_URL'));

        $this->assign('request', $_REQUEST);

        //在子类可以添加 _init方法进行初始化
         if(method_exists($this, '_init'))
         {
             $this->_init();
         }
        $this->checkIsLogin();

        import('ORG.Util.Page');
    }

    //  操作 错误提示页
    public function error($errormsg = '操作出错', $url = '', $second = '3') {
        $info = array('msg' => $errormsg, 'second' => $second, 'url' => $url);
        $this->assign('info', $info);
        $this->assign('nav', L('notice'));
        $this->display("Public:error");
        exit();
    }

    //操作成功提示页
    public function success($errormsg = '操作成功', $url = '', $second = '1') {
        $info = array('msg' => $errormsg, 'second' => $second, 'url' => $url);
        $this->assign('info', $info);
        $this->assign('nav', L('notice'));
        $this->display("Public:success");
        exit();
    }

    /**
     * +-------------------------------------------------
     * 验证是否已经登录
     * +-------------------------------------------------
     * @access public
     * +-------------------------------------------------
     * @return void
     */
    protected function checkIsLogin() {
        if(empty($_SESSION['admin_id']) || empty($_SESSION["user_name"]))
            R('Public/checkCookieAuthLogin');
    }

    protected function navAndDo($actUrl = '', $nav, $actName = '返回列表') {
        $this->assign('doAct', array('actUrl' => $actUrl, 'actName' => $actName));
        $this->assign('nav', $nav);
    }

    /**
     * 店铺信息
     * @return mixed
     */
    protected function get_shop_info() {
        $shop = M("shop");
        $shop_info = $shop->order(" `add_time` DESC ")->select();
        $this->assign('shop_info', $shop_info);

        return $shop_info;
    }

    public function commonUploadImg() {
        // 5 minutes execution time
        @set_time_limit(5 * 60);

        $date = date('Y-m-d', time());
        $targetDir = PUBLIC_PATH . "images/" . $date;
        //$targetDir = 'uploads';
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds


        // Create target dir
        if(!file_exists($targetDir)) {
            @mkdir($targetDir);
        }


        // Get a file name
        if(isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif(!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

        // Read binary input stream and append it to temp file
        if(!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        }


        if(!empty($_FILES)) {
            if($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }


        } else {
            if(!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        $fileSize = filesize($_FILES["file"]["tmp_name"]);
        while ($buff = fread($in, $fileSize)) {

            $name = md5($buff);
            $extName = substr($fileName, strripos($fileName, '.'));
            $fileName = $name . $extName;
            $filePath = $targetDir . '/' . $fileName;
            // Open temp file
            if(!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }
            fwrite($out, $buff);
        }


        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if(!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }

        $imgPath = substr($filePath, 2);
        $imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $imgPath;

        //返回图片地址到hidden 的input  中， 在保存编辑表单时，提交到editGoods一起保存
        //        if(isset($_REQUEST['id']) && $_REQUEST['id']>0){
        //            $id = intval($_REQUEST['id']);
        //            if(isset($_REQUEST['field'])){
        //                $field = trim($_REQUEST['field']);
        //                $goodsM = M('details', 'mh_');
        //                $goodsM->where('id=' . $id)->save(array($field=>$imgPath));
        //            }
        //        }
        die('{"jsonrpc" : "2.0", "result" : null, "img" : "' . $imgUrl . '", "imgPath" : "' . $imgPath . '"}');
    }

    /**
     * 通用的生成数据表的列表页面
     * @author chris.ying
     * @param $model
     * @param $nav
     * @param $doAct
     */
    public function showList($model, $nav, $doAct) {
        $modelM = M($model);
        $allrow = $modelM->count();
        import("ORG.Util.Page");
        $page = new Page($allrow);
        $pageStr = $page->show();
        $this->assign('page', $pageStr);
        $listInfo = $modelM->order('id DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign("list", $listInfo);
        $this->assign('nav', $nav);
        $this->assign('doAct', $doAct);
        $this->display($model);
    }

    /**
     * 显示添加及编辑页面
     * @author chris.ying
     * @param $model
     * @param $doAct
     * @param $done
     * @param $nav
     * @param int $step
     * @param array $data
     * @param string $redirect
     */
    public function doEdit($model, $doAct, $done, $nav, $step = 1, $data = array(), $redirect = '') {
        $id = intval($_REQUEST['id']);
        $modelM = M($model);

        //编辑完成后保存
        if(2 == $step) {
            if(!$id) {
                $modelM->add($data);
            } else {
                $modelM->where('id=' . $id)->save($data);
            }

            $this->redirect($redirect);
        } else {
            //显示编辑商品的内容
            $info = $modelM->where('id =' . $id)->find();
        }

        $this->assign('info', $info);
        $this->assign('doAct', $doAct);
        $this->assign('nav', $nav);
        $this->assign('done', $done);
        $this->display('edit' . ucfirst($model));
    }


    /**
    +----------------------------------------------------------
     * Export Excel | 2013.08.23
     * Author:HongPing <hongping626@qq.com>
    +----------------------------------------------------------
     * @param $expTitle     string File name
    +----------------------------------------------------------
     * @param $expCellName  array  Column name
    +----------------------------------------------------------
     * @param $expTableData array  Table data
    +----------------------------------------------------------
     */
    public function exportExcel($expTitle,$expCellName,$expTableData,$type = 'normal', $isDown=false){
        $xlsTitle = iconv('utf-8', 'utf-8', $expTitle);//文件名称
        $fileName = $xlsTitle; //文件名称
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel");
        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        switch($type){
            //原导出订单功能 2015-11-11 chrisying
            case 'export_order':
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '运单信息');
                $objPHPExcel->getActiveSheet(0)->mergeCells('B1:E1');//合并单元格
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '收件人信息');
                $objPHPExcel->getActiveSheet(0)->mergeCells('F1:H1');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '托寄物信息');
                $objPHPExcel->getActiveSheet(0)->mergeCells('I1:J1');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '保价信息');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '订单金额');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '服务类型');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '运单备注');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '配送业务类型');

                $objPHPExcel->getActiveSheet(0)->getStyle("B1")->getFont()
                    ->setName('宋体')
                    ->setSize(11);
                $objPHPExcel->getActiveSheet(0)->getStyle("F1")->getFont()
                    ->setName('宋体')
                    ->setSize(11);

                //        if(!empty($expTitleData)){
                //            foreach($expTitleData as $k => $titleData){
                //                if($titleData[1] > 1){
                ////                    $objPHPExcel->getActiveSheet(0)->mergeCells($cellName[$k]      'A1:'.$cellName[$cellNum-1].'1');//合并单元格
                //                }
                //            }
                //
                //            $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
                //            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
                //        }

                for($i=0;$i<$cellNum;$i++){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
                }
                // Miscellaneous glyphs, UTF-8
                for($i=0;$i<$dataNum;$i++){
                    for($j=0;$j<$cellNum;$j++){

                        switch($j){
                            case 8:
                                //保价
                                $objActSheet = $objPHPExcel->getActiveSheet(0);
                                $objValidation = $objActSheet->getCell($cellName[$j].($i+3))->getDataValidation();
                                //这一句为要设置数据有效性的单元格
                                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                                    ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                                    ->setAllowBlank(false)
                                    ->setShowInputMessage(true)
                                    ->setShowErrorMessage(true)
                                    ->setShowDropDown(true)
                                    ->setErrorTitle('请选择保价')
                                    ->setError('您输入的值不在下拉框列表内.')
                                    ->setPromptTitle('保价')
                                    ->setFormula1('"是,否"')
                                    ->setFormula2('"是,否"');
                                $objActSheet->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);

                                break;

                            case 11:
                                //代收货款
                                $objActSheet = $objPHPExcel->getActiveSheet(0);
                                $objValidation = $objActSheet->getCell($cellName[$j].($i+3))->getDataValidation();
                                //这一句为要设置数据有效性的单元格
                                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                                    ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                                    ->setAllowBlank(false)
                                    ->setShowInputMessage(true)
                                    ->setShowErrorMessage(true)
                                    ->setShowDropDown(true)
                                    ->setErrorTitle('请选择代收货款')
                                    ->setError('您输入的值不在下拉框列表内.')
                                    ->setPromptTitle('代收货款')
                                    ->setFormula1('"是,否"')
                                    ->setFormula2('"是,否"');
                                $objActSheet->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
                                break;

                            case 13:
                                //配送业务类型
                                $objActSheet = $objPHPExcel->getActiveSheet(0);
                                $objValidation = $objActSheet->getCell($cellName[$j].($i+3))->getDataValidation();
                                //这一句为要设置数据有效性的单元格
                                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                                    ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                                    ->setAllowBlank(false)
                                    ->setShowInputMessage(true)
                                    ->setShowErrorMessage(true)
                                    ->setShowDropDown(true)
                                    ->setErrorTitle('请选择配送业务类型')
                                    ->setError('您输入的值不在下拉框列表内.')
                                    ->setPromptTitle('配送业务类型')
                                    ->setFormula1('"普通,控温,冷藏,冷冻,深冷"')
                                    ->setFormula2('"普通,控温,冷藏,冷冻,深冷"');
                                $objActSheet->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
                                break;

                            default:
                                //                            echo $expTableData[$i][$expCellName[$j][0]];
                                //由PHPExcel根据传入内容自动判断单元格内容类型  setCellValue('A1', '字符串内容');
                                //显式指定内容类型  setCellValueExplicit('A1', '字符串内容', PHPExcel_Cell_DataType::TYPE_STRING)
                                $objPHPExcel->getActiveSheet(0)->setCellValueExplicit($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]], PHPExcel_Cell_DataType::TYPE_STRING);
                                break;
                        }

                    }
                }
                break;

            //按发货渠道导出订单
            case 'export_send_channel_order':
                for($i=0;$i<$cellNum;$i++){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);
                }
                // Miscellaneous glyphs, UTF-8
                for($i=0;$i<$dataNum;$i++){
                    for($j=0;$j<$cellNum;$j++){

                        switch($j){
                            case 83:
                                //保价
                                $objActSheet = $objPHPExcel->getActiveSheet(0);
                                $objValidation = $objActSheet->getCell($cellName[$j].($i+2))->getDataValidation();
                                //这一句为要设置数据有效性的单元格
                                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                                    ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                                    ->setAllowBlank(false)
                                    ->setShowInputMessage(true)
                                    ->setShowErrorMessage(true)
                                    ->setShowDropDown(true)
                                    ->setErrorTitle('请选择保价')
                                    ->setError('您输入的值不在下拉框列表内.')
                                    ->setPromptTitle('保价')
                                    ->setFormula1('"是,否"')
                                    ->setFormula2('"是,否"');
                                $objActSheet->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);

                                break;

                            default:
                                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
                                break;
                        }
                    }
                }

                break;


            default:
                for($i=0;$i<$cellNum;$i++){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);
                }
                // Miscellaneous glyphs, UTF-8
                for($i=0;$i<$dataNum;$i++){
                    for($j=0;$j<$cellNum;$j++){

                        switch($j){
                            default:
                                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
                                break;
                        }
                    }
                }

                break;

        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $filename = $fileName . ".xlsx";

        if($isDown){

            //excel 5格式
            //        header('pragma:public');
            //        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
            //        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
            //        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //        $objWriter->save('php://output');

            //excel 2007 格式
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header('Content-Disposition:inline;filename="'.$filename.'"');
            header("Content-Transfer-Encoding: binary");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: no-cache");
            $objWriter->save('php://output'); //文件通过浏览器下载
        }else{
            $dateStr = str_replace('-', '/', date('Y-m-d', time()));
            $filePath = BASE_PATH . '/upload' . '/' . $dateStr . '/';
            createDir($filePath);
            $objWriter->save($filePath . $filename); //脚本方式运行，保存在当前目录
        }
    }

    /**
    +----------------------------------------------------------
     * Import Excel | 2013.08.23
     * Author:HongPing <hongping626@qq.com>
    +----------------------------------------------------------
     * @param  $file   upload file $_FILES
    +----------------------------------------------------------
     * @return array   array("error","message")
    +----------------------------------------------------------
     */
    public function importExecl($file){
        if(!file_exists($file)){
            return array("error"=>0,'message'=>'file not found!');
        }
        Vendor("PHPExcel.IOFactory");
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        try{
            $PHPReader = $objReader->load($file);
        }catch(Exception $e){}


        //
        //
        //        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        //        import("Org.Util.PHPExcel");
        //        //创建PHPExcel对象，注意，不能少了\
        //        $PHPExcel = new \PHPExcel();
        //        //如果excel文件后缀名为.xls，导入这个类
        //
        //        if ($exts == 'xls') {
        //            import("Org.Util.PHPExcel.Reader.Excel5");
        //            $PHPReader = new \PHPExcel_Reader_Excel5();
        //        } else if ($exts == 'xlsx') {
        //            import("Org.Util.PHPExcel.Reader.Excel2007");
        //            $PHPReader = new \PHPExcel_Reader_Excel2007();
        //        }
        //载入文件
        //        $PHPExcel = $PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        //        $currentSheet = $PHPExcel->getSheet(0);
        //        //获取总列数
        //        $allColumn = $currentSheet->getHighestColumn();
        //        //获取总行数
        //        $allRow = $currentSheet->getHighestRow();
        //        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        //        for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
        //            //从哪列开始，A表示第一列
        //            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
        //                //数据坐标
        //                $address = $currentColumn . $currentRow;
        //                //读取到的数据，保存到数组$arr中
        //                $data[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue();
        //            }
        //        }
        //        $this->save_import($data);























        if(!isset($PHPReader)) return array("error"=>0,'message'=>'read error!');
        $allWorksheets = $PHPReader->getAllSheets();
        $i = 0;
        foreach($allWorksheets as $objWorksheet){



            $currentSheet = $objWorksheet;

            //获取总列数
            $allColumn = $currentSheet->getHighestColumn();
            //获取总行数
            $allRow = $currentSheet->getHighestRow();
            //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
            for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
                //从哪列开始，A表示第一列
                for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                    //数据坐标
                    $address = $currentColumn . $currentRow;
                    //读取到的数据，保存到数组$arr中
                    $data[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue();
                }
            }


            //
            //
            //            $sheetname=$objWorksheet->getTitle();
            //            $allRow = $objWorksheet->getHighestRow();//how many rows
            //            $highestColumn = $objWorksheet->getHighestColumn();//how many columns
            //            $allColumn = PHPExcel_Cell::columnIndexFromString($highestColumn);
            //            $array[$i]["Title"] = $sheetname;
            //            $array[$i]["Cols"] = $allColumn;
            //            $array[$i]["Rows"] = $allRow;
            //            $arr = array();
            //            $isMergeCell = array();
            //            foreach ($objWorksheet->getMergeCells() as $cells) {//merge cells
            //                foreach (PHPExcel_Cell::extractAllCellReferencesInRange($cells) as $cellReference) {
            //                    $isMergeCell[$cellReference] = true;
            //                }
            //            }
            //            for($currentRow = 1 ;$currentRow<=$allRow;$currentRow++){
            //                $row = array();
            //                for($currentColumn=0;$currentColumn<$allColumn;$currentColumn++){;
            //                    $cell =$objWorksheet->getCellByColumnAndRow($currentColumn, $currentRow);
            //                    $afCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn+1);
            //                    $bfCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn-1);
            //                    $col = PHPExcel_Cell::stringFromColumnIndex($currentColumn);
            //                    $address = $col.$currentRow;
            //                    $value = $objWorksheet->getCell($address)->getValue();
            //                    if(substr($value,0,1)=='='){
            //                        return array("error"=>0,'message'=>'can not use the formula!');
            //                        exit;
            //                    }
            //                    if($cell->getDataType()==PHPExcel_Cell_DataType::TYPE_NUMERIC){
            //                        $cellstyleformat=$cell->getParent()->getStyle( $cell->getCoordinate() )->getNumberFormat();
            //                        $formatcode=$cellstyleformat->getFormatCode();
            //                        if (preg_match('/^([$[A-Z]*-[0-9A-F]*])*[hmsdy]/i', $formatcode)) {
            //                            $value=gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value));
            //                        }else{
            //                            $value=PHPExcel_Style_NumberFormat::toFormattedString($value,$formatcode);
            //                        }
            //                    }
            //                    if($isMergeCell[$col.$currentRow]&&$isMergeCell[$afCol.$currentRow]&&!empty($value)){
            //                        $temp = $value;
            //                    }elseif($isMergeCell[$col.$currentRow]&&$isMergeCell[$col.($currentRow-1)]&&empty($value)){
            //                        $value=$arr[$currentRow-1][$currentColumn];
            //                    }elseif($isMergeCell[$col.$currentRow]&&$isMergeCell[$bfCol.$currentRow]&&empty($value)){
            //                        $value=$temp;
            //                    }
            //                    $row[$currentColumn] = $value;
            //                }
            //                $arr[$currentRow] = $row;
            //            }
            //            $array[$i]["Content"] = $arr;
            $i++;
        }
        spl_autoload_register(array('Think','autoload'));//must, resolve ThinkPHP and PHPExcel conflicts
        unset($objWorksheet);
        unset($PHPReader);
        unset($PHPExcel);
        unlink($file);
        //        return array("error"=>1,"data"=>$array);
        return array("error"=>1,"data"=>$data);
    }

    /**
     * 把csv文件解析为一个数组返回
     *
     * @param string $file 要解析的csv文件路径
     * @param char $delimiter csv文件里的内容分隔符 默认为","
     * @return array
     *
     * csv_to_array(file_get_contents('aaa.csv'));
     */

    function csv_to_array($input, $delimiter=',')
    {
        $header = null;
        $data = array();
        $csvData = str_getcsv($input, "\n");

        foreach($csvData as $csvLine){
            if(is_null($header)) $header = explode($delimiter, $csvLine);
            else{

                $items = explode($delimiter, $csvLine);

                for($n = 0, $m = count($header); $n < $m; $n++){
                    $prepareData[$header[$n]] = $items[$n];
                }

                $data[] = $prepareData;
            }
        }

        return $data;
    }
    //=============================================================================
}
