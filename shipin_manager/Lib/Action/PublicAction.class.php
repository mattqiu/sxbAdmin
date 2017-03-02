<?php
// +----------------------------------------------------------------------
//  时品网   订单管理 功能
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2013 http://shipinmmm.com All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris Ying
// +----------------------------------------------------------------------
// | @version: $Id: OrdersAction.class.php 1564 2014-10-13 03:52:01Z yihua.ying $
class PublicAction extends  Action{
       
    function index() {
        if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0 && $_SESSION['user_name'])
            $this->redirect('Index/index');
        $this->display();
    }   
    
    //检查cookie中的登录信息
    function checkCookieAuthLogin() {
            if($_COOKIE['authLogin']) {
                $cookie = base64_decode($_COOKIE['authLogin']);          
                list($username,$uid,$time) = explode('|', $cookie); 
                if((time() - $time) > 604800) {
                    $this->redirect('Public/index');
                }else{
                    $user = $this->getAdminInfo(ltrim($username, 'bbul'), $uid);
                    if($user['username']) {
                        session('admin_id',  $user['admin_id']);
                        session('user_name', $user['admin_name']);
                    }
                }         
            }else
                $this->redirect('Public/index');
    }
    
    //后台登录    
    function toLogin() {
        $this->check_code();//检查验证码
        import('ORG.Util.Input');
        // import('ORG.Util.RBAC');
        $username = Input::getVar($_POST['username']);
        $password = Input::getVar($_POST['password']);
        $result   = $this->getAdminInfo($username);

        if($result) {
            if(md5($password) == $result['password']) {
                $data = '';

                // //取用户的权限列表
                // RBAC::saveAccessList($result['admin_id']);

                // //如果用户名是超级管理员, 则设置为免认证用户
                // if($username == C('ADMIN_AUTH_KEY')){
                //     session(C('ADMIN_AUTH_KEY'), true);
                // }

                //session(array('name'=>'admin_id', 'expire'=>10800));
                session('admin_id', $result['admin_id']);
               //session(array('name'=>'user_name', 'expire'=>10800));
                session('user_name', $result['admin_name']);




                $list = M('node')->field('mname,aname')->where('id in'.M('role_node')->field('nid')->where("rid in ".M('role_user')->field('rid')->where("uid = {$result['admin_id']}")->buildSql())->buildSql())->select();
                // dump($list);exit;
                $nodelist = array();
                $nodelist['Index'] = array('index');

                foreach($list as $v){
                    $nodelist[$v['mname']][] = $v['aname'];
                    if($v['aname'] == "edit"){
                        $nodelist[$v['mname']][] = "save";
                    }
                    if($v['aname'] == "add"){
                        $nodelist[$v['mname']][] = "doadd";
                    }
                }

                // dump($nodelist[$mname]);exit;
                session('nodelist', $nodelist); //把用户权限信息放到SESSION中
                // dump($_SESSION);exit;

                //最近一次登录时间
                $data['last_login_time'] = time() + 60*60*8;
                //登录的IP
                $data['last_login_ip']   = $_SERVER['REMOTE_ADDR'];
                //登录次数
                $data['login_count']     = $result['login_count'] +1;
                M('admin')->where(" `id` = '{$result['id']}'")->data($data)->save();                                      
                
                if($_POST['remember']) {//如果勾选了保存登录信息 则写入cookie
                    $cookie = 'bbul'.$result['admin_name'].'|'.$result['id'].'|'.time();
                    //保存一个星期
                    cookie('authLogin', base64_encode($cookie),array('expire'=>604800,'prefix'=>'bbul_'));
                }                
                $this->redirect("Index/index");        
          }else
              $this->redirect("Public/index", '', 3, '帐号信息不正确');
      }else
          $this->redirect("Public/index", '', 3, '帐号信息不正确');
    }
    
    /**
     +-------------------------------------------------
     * 获取管理员信息
     +-------------------------------------------------
     * @access private
     +-------------------------------------------------
     * @param string $username 用户名
     * @param int    $uid      用户id
     +-------------------------------------------------
     * @return array
     */ 
    private function getAdminInfo($username, $uid = '') {
        $model = M('admin');
        $where = "admin_name='".$username."'";
        if($uid) 
            $where = 'admin_id='.$uid." AND ".$where;      
        return $model->where($where)->find();
    }
    
    //登出操作
    function toLogout() {       
        cookie(null,'bbul_');
        session('[destroy]');  
        $this->success('成功退出', U('Public/index')); 
    }
    
    //验证码的生成 4位
    public function verify() {
        import("ORG.Util.Image");
        Image::buildImageVerify(5, 1, 'gif', 145);
    }
    
    //检查验证码 不区分大小写
    public function check_code() {
        $verify = md5(strtolower(trim($_SESSION['verify'])));
        $code   = md5(strtolower(trim($_REQUEST['code'])));
//        暂时不验证后台验证码 yihua.ying 2014-9-22
        return;
        if( $verify != $code ) {
           if($_REQUEST['is_ajax'] == 'yes') {
               $result['status'] = -10;
               $this->ajaxReturn($result);  
               exit();                            
           }else{
               $this->error("验证码不正确");
               exit();
            }         
        }

    }
    
    //引入ucenter里面的配置文件和函数库
    public function include_ucenter() {
        require_once ('./config.inc.php');
        require_once ('./uc_client/client.php');
    }
}