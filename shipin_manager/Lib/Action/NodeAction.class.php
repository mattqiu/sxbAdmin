<?php

/**
 * 节点管理
 * Created by PhpStorm.
 * User: chrisying
 * Date: 15/12/18
 * Time: 上午10:22
 */

class NodeAction extends CommonAction{

	private $_model = null;		//数据库操作类

	/**
	 * 操作初始化
	 */
	public function _initialize(){
		
		parent::_initialize();
		$this->_model = M('node');
	}

	/**
	 * 节点列表详情
	 */	
	public function index(){
		
		$data = $this->_model->select();
		$page = new Page(count($data));
		$list = $this->_model->limit($page->firstRow . ',' . $page->listRows)->select();		
		$strPage = $page->show();
		$this->assign('list',$list);
		$this->assign('page',$strPage);
		$this->display();

	}

	/**
	 *	节点添加 
	 */
	public function add(){
		
		$this->display();
	}

	/**
	 * 节点添加处理
	 */
	public function doadd(){
		$post['name'] = I('name');
		$post['mname'] = I('mname');
		$post['aname'] = strtolower(I('aname'));
		$post['status'] = I('status');
		if($this->_model->add($post) > 0){
			$this->success('节点添加成功',U('Node/index'));
		}else{
			$this->error('节点添加失败');
		}
	}

	/**
	 * 节点删除
	 */
	public function del(){

		if($this->_model->delete($_GET['id']) > 0){
			$this->success('节点删除成功',U('Node/index'));
		}else{
			$this->error('节点删除失败');
		}
	}
	/**
	 * 节点编辑页面调出
	 */
	public function edit(){

		$vo = $this->_model->where("id={$_GET['id']}")->find();
		$this->assign('vo',$vo);
		$this->display();
	}

	/**
	 * 节点修改执行
	 */
	public function save(){
		// dump($_POST);exit;
		if(!$this->_model->create()){
			$this->error($this->_model->getError());
			exit;
		}
		if($this->_model->save() >= 0){
			$this->success('节点修改成功',U('Node/index'));
		}else{
			$this->error('节点修改失败');
		}
	}
}