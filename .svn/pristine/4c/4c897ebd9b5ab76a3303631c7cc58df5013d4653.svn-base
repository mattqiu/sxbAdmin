<?php
/**
 * 黑名单用户管理
 * Created by PhpStorm.
 * User: chrisying
 * Date: 15/12/29
 * Time: 下午15:10
 */
class BlackListAction extends CommonAction{
	/**
	 * 输出黑名单列表
	 */
	public function index(){
		$m = M();
		$data = $m->table("ttgy_user as u,ttgy_user_black as b")->field("u.username,b.id,b.uid")->where("b.uid = u.id")->select();
		$this->assign("list",$data);
		$this->display();
	}

	/**
	 * 输出添加用户至黑名单页面
	 */
	public function add(){
		$this->display();
	}

	/**
	 * 执行添加用户至黑名单操作
	 */
	public function doadd(){
		$m = M("user_black");
		$data['uid'] = I('uid');
		if($m->add($data)){
			$this->success("添加成功",U('BlackList/index'));
		}else{
			$this->error("添加失败");
		}
	}

	/**
	 * 把用户移出黑名单
	 */
	public function del(){
		$m = M("user_black");
		if($m->delete(I('id'))){
			$this->success("用户移出成功",U('BlackList/index'));
		}else{
			$this->error("用户移出失败");
		}
	}
	/**
	 * 用手机号搜索用户的ID
	 */
	public function search(){
		$mobile = $_POST['data'];
		$m = M("user");
		$data = $m->field("id")->where("mobile = {$mobile}")->find();
		echo json_encode($data['id']);
	}
}