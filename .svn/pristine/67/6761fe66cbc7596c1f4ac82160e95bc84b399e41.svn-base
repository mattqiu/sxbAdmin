<?php
/**
 * 角色管理
 * Created by PhpStorm.
 * User: chrisying
 * Date: 15/12/18
 * Time: 下午17:50
 */

class RoleAction extends CommonAction{
	/**
	 * 初始化操作
	 */
	private $_model = null; 
	private $_node = null; 
	private $_role_node = null;
	private $_role_user = null;

	//初始化操作
	public function _initialize(){
		parent::_initialize();
		$this->_model = M('role');
		$this->_node = M('node');
		$this->_role_node = M("role_node");
		$this->_role_user = M("role_user");
	}

	public function index(){
		$list = $this->_model->select();
		//循环加权限信息
		$arr = array();
		foreach($list as $v){
			$nodes = $this->_role_node->where("rid = {$v['id']}")->select();
			$node = array();
			foreach($nodes as $value){
				$node[] = $this->_node->where("id = {$value['nid']}")->getField('name');
			}
			$v['node'] = $node;
			$arr[] = $v;
		}
		// echo $this->_model->getLastSql();
		// var_dump($arr);
		$this->assign("list",$arr);
		$this->display();
	}

	/**
	 * 添加角色
	 */
	public function add(){
		$this->display();
	}

	/**
	 * 执行添加信息操作 
	 */
	public function doadd(){
		if(!$this->_model->create()){
			$this->error($this->_model->getError());
			exit;
		}

		if($this->_model->add() > 0){
			$this->success("角色添加成功!",U("Role/index"));
		}else{
			$this->error("角色添加失败!");
		}
	}

	/**
	 * 删除角色
	 * 删除角色的同时也删除了角色的权限
	 */
	public function del(){

		if($this->_model->delete($_GET['id']) > 0 && $this->_role_user->where("rid = {$_GET['id']}")->delete() > 0 && $this->_role_node->where("rid = {$_GET['id']}")->delete() > 0){
			$this->success("角色删除成功!",U("Role/index"));
		}else{
			$this->error("角色删除失败!");
		}
	}

	/**
	 * 加载修改的页面
	 */
	public function edit(){

		$vo = $this->_model->where("id = {$_GET['id']}")->find();

		$this->assign("vo",$vo);
		$this->display();
	}

	/**
	 * 执行修改操作
	 */
	public function save(){
		// dump($_POST);exit;
		if(!$this->_model->create()){
			$this->error($this->_model->getError());
			exit;
		}

		if($this->_model->save() >= 0){
			$this->success("信息修改成功!",U("Role/index"));
		}else{
			$this->errot("信息修改失败!");
		}
	}

	/**
	 * 给角色分配权限
	 */
	public function nodelist(){

		$role = $this->_model->where("id = {$_GET['id']}")->find();
		// dump($role);exit;
		$nodes = $this->_node->select();
		// 查看用户的权限
		$ro_node = $this->_role_node->where("rid = {$role['id']}")->select();
		//重新组合数组
		$ro_nodes = array();
		foreach($ro_node as $v){
			$ro_nodes[] = $v['nid'];
		}
		// dump($ro_nodes);
		$this->assign('ro_nodes',$ro_nodes);
		$this->assign('nodes',$nodes);
		$this->assign('role',$role);
		$this->display();
	}

	/**
	 * 给角色添加权限执行
	 */
	public function savenode(){
		// dump($_POST);exit;
		if(empty($_POST['node'])){
			$this->error("您必须选择一个节点！");
		}
		$rid = $_POST['rid'];
		//删除原有的节点  以免重复添加
		$this->_role_node->where("rid = {$rid}")->delete();

		foreach($_POST['node'] as $v){
			$data['nid'] = $v;
			$data['rid'] = $rid;
			$datas = $this->_role_node->data($data)->add();
		}
		// dump($datas);echo $this->_role_node->getLastSql();exit;
		$this->success("权限分配成功!",U("Role/index"));
	}
}
