<?php
/**
 * 后台用户管理
 * Created by PhpStorm.
 * User: chrisying
 * Date: 15/12/21
 * Time: 下午17:10
 */
class AdminAction extends CommonAction{

	private $_model = null; 
	private $_role = null; 
	private $_role_user = null; 
	//初始化操作
	public function _initialize(){
		parent::_initialize();
		$this->_model = M('Admin');
		$this->_role = M('role');
		$this->_role_user = M('role_user');
	}

	public function index(){
		$list = $this->_model->select();
		$arr = array();
		//遍历用户信息
		foreach($list as $v){
			$role_ids = $this->_role_user->field("rid")->where("uid = {$v['id']}")->select();
			$roles = array();
			foreach($role_ids as $value){
				$roles[] = $this->_role->where("id = {$value['rid']} and status = 1")->getField("name");
			}
			$v['role'] = $roles;
			$arr[] = $v;	//将新拿到的角色信息放到$v中
		}
		// dump($arr);
		$this->assign("list",$arr);
		$this->display();
	}

	/**
	 * 输出添加用户页面
	 */
	public function add(){
		$this->display();
	}

	/**
	 * 执行用户添加的操作
	 */
	public function doadd(){
   		$post['admin_name'] = I('post.admin_name');
   		$post['nickname'] = I('post.nickname');
   		$post['status'] = I('post.status');
		$post['password'] =  md5(I('post.password'));
   		$result = $this->_model->add($post);
   		if($result){
   			$this->success('添加成功',U('Admin/index'));
   		}else{
   			$this->error('添加失败');
   		}
	}

	/**
	 * 输出用户信息以及用户信息修改页面
	 */
	public function edit(){
		$data = $this->_model->find($_GET['id']);
		$this->assign('vo',$data);
		$this->display();
	}

	/**
	 * 执行用户修改信息
	 */
	public function save(){
		$post['admin_name'] = I('post.admin_name');
   		$post['nickname'] = I('post.nickname');
   		$post['status'] = I('post.status');
   		$id = I('post.admin_id');
		$post['password'] =  md5(I('post.password'));
		$data = $this->_model->where("admin_id = {$id}")->save($post);
		// dump($data);echo $m->getlastSql();exit;
		if($data){
			$this->success("用户信息修改成功!",U("Admin/index"));
		}else{
			$this->error("用户信息修改失败!");
		}
	}

	/**
	 * 用户删除
	 */
	public function del(){
		
		if($this->_model->delete($_GET['id']) > 0 && $this->_role_user->where("uid = {$_GET['id']}")->delete() > 0){
			$this->success("用户删除成功!",U("Admin/index"));
		}else{
			$this->error("用户删除失败!");
		}
	}

	/**
	 * 查看用户角色信息
	 */
	public function rolelist(){

		$list = $this->_role->where("status = 1")->select();
		$users = $this->_model->where("admin_id = {$_GET['id']}")->find();
		$rolelist = $this->_role_user->where("uid = {$_GET['id']}")->select();
		$myrole = array();
		foreach($rolelist as $v){
			$myrole[] =$v['rid'];
		}

		// dump($list);
		// dump($users);
		// dump($rolelist);
		// dump($myrole);		
		
		$this->assign("list",$list);
		$this->assign("users",$users);
		$this->assign("role",$myrole);
		$this->display();
	}

	/**
	 * 执行保存用户的角色
	 */
	public function saverole(){
		// dump($_POST);
		if(empty($_POST['role'])){
			$this->error("请选择一个角色！");
		}
		$uid = $_POST['uid'];
		$role_id = $_POST['role'];
		$this->_role_user->where("uid = {$uid}")->delete();
		foreach($role_id as $v){
			$data['uid'] = $uid;
			$data['rid'] = $v;
			$role_name = $this->_role->where("id = {$data['rid']}")->find();
			$admin_role_name['role_name'] = $role_name['name'];
			// dump($admin_role_name);exit;
			$this->_model->where("admin_id = {$uid}")->save($admin_role_name); //修改admin表内的role_name
			$this->_role_user->data($data)->add();	//添加role_user表内的数据
		}
		// dump($datas);echo $this->_model->getlastSql();exit;
		$this->success("角色分配成功!",U('Admin/index'));
	}
}