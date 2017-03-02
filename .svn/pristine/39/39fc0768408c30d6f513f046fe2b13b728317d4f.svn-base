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
 *  邮费管理
 * Class GroupBuyingAction
 */
class PostageAction extends CommonAction{

    /**
     *  全国邮费（省级）管理
     */
    public function index(){

        $where = 'pid=0';

        $areaM = new AreaModel();
        $count = $areaM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $areaM->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();

        if(!empty($list)) {
            $send_warehomeM = M('send_warehome');//发货仓
            foreach ($list as $key => $item) {
                if(!empty($item['send_warehome']))
                {
                    $js_sendwarehome = json_decode($item['send_warehome'],true);
                    $array_sendwarehome_name = array();


                    foreach($js_sendwarehome as $sendwarehomekey => $value){

                        $sendwarename = "";
                        $sendwareindex = $sendwarehomekey;
                        //$value['postage'] 从此仓到这个地点的邮费
                        $send_warehome_item = $send_warehomeM->where("id=".$value['warehome_id'])->find();
                        if(!empty($send_warehome_item))
                        {
                            $sendwarename = $send_warehome_item['name'];
                        }
                        else{
                            $sendwarename = '查询出错';
                        }

                        $array_sendwarehome_name[]=$sendwareindex.':'.$sendwarename;

                    }

                    $list[$key]['send_warehome'] = $array_sendwarehome_name;
                    $count = count($js_sendwarehome);
                }
            }
        }


        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display('index');
    }

    /**
     *  市级
     */
    public function area(){


        $pid = I('id', 0);//省级id
        $provincename=I('provincename', 0);
        $where = 'pid='.$pid;

        $AreaM = new AreaModel();
        $count = $AreaM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $AreaM->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();

        $this->assign("provincename",$provincename);
        $this->assign("pid",$pid);
        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display("area");
    }

    /*
     * 县级 区
     * */

    public function county(){

        $pid = I('id', 0);//市级id
        $provincename=I('provincename', 0);
        $areaname = I('areaname',0);
        $where = 'pid='.$pid;

        $AreaM = new AreaModel();
        $count = $AreaM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $AreaM->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();

        $this->assign("provincename",$provincename);
        $this->assign("pid",$pid);
        $this->assign("areaname",$areaname);
        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display("county");
    }

    /*
     * 镇级
     * */

    public function town(){

        $pid = I('id', 0);//区（县）id
        $provincename=I('provincename', 0);
        $areaname = I('areaname',0);
        $countyname = I('countyname',0);
        $where = 'pid='.$pid;

        $AreaM = new AreaModel();
        $count = $AreaM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $AreaM->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();

        $this->assign("provincename",$provincename);
        $this->assign("pid",$pid);
        $this->assign("areaname",$areaname);
        $this->assign("countyname",$countyname);
        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display("town");
    }

    public function edit(){
        $id = I('id', 0);
        $areaM = M('area');
        $item = $areaM->where('id =' . $id)->find();

        if(!empty($item))
        {
            if(!empty($item['send_warehome']))
            {
                $send_warehomeM = M('send_warehome');//发货仓


                $js_sendwarehome = json_decode($item['send_warehome'],true);
                foreach($js_sendwarehome as $key => $value){

                    //$value['postage'] 从此仓到这个地点的邮费
                    $send_warehome_item = $send_warehomeM->where("id=".$value['warehome_id'])->find();
                    if(!empty($send_warehome_item))
                    {
                        $js_sendwarehome[$key]['name'] = $send_warehome_item['name'];
                    }
                    else{
                        $js_sendwarehome[$key]['name'] = '查询出错';
                    }

                }

                $item['send_warehome'] = $js_sendwarehome;
                $count = count($js_sendwarehome);
            }
        }

        $this->assign('item', $item);
        $this->assign('send_warehomes',$item['send_warehome']);
        $this->assign('count', $count);
        $this->display("edit");
    }

    public function add()
    {
        $parent_id=I('parent_id',0);
        $this->assign('parent_id', $parent_id);
        $this->display("add");
    }

    public function save(){
        $id = I('id', 0);
        $parent_id=I('parent_id',0);
        $name = I('name','0');
        $zipcode = I('zipcode',0);
        $first_weight = I('first_weight',0);
        $first_weight_price = I('first_weight_price',0);
        $follow_weight_money = I('follow_weight_money',0);
        $active = I('active',0);

        $sendwarehome_ids = $_REQUEST['sendwarehome_id'];
        $sendwarehome_postages = $_REQUEST['sendwarehome_postage'];
        $sendwarehome_indexs = $_REQUEST['sendwarehome_index'];

        $send_warehome_data = array();
        for($i=0;$i<count($sendwarehome_ids);$i++)
        {
            $send_warehome_one = array(
                'warehome_id'=>$sendwarehome_ids[$i],
                'warehome_postage'=>$sendwarehome_postages[$i]
            );
            $send_warehome_data[$sendwarehome_indexs[$i]] = $send_warehome_one;
        }

        $areaM = M('area');

        $data = array();
        $data['pid']=$parent_id;
        $data['name']=$name;
        $data['zipcode']=$zipcode;
        $data['first_weight']=$first_weight;
        $data['first_weight_money']=$first_weight_price;
        $data['follow_weight_money']=$follow_weight_money;
        $data['active']=$active;

        $data['order']=20;
        $data['cut_off_time']=16;
        $data['cut_off_time_m']=0;
        $data['free_post_money_limit']=0.0;
        $data['send_time']='after2to3days';
        $data['can_night_send']=0;
        $send_warehome_data = new arrayobject($send_warehome_data);//需要json数据带下标。
        $data['send_warehome'] =  json_encode($send_warehome_data);

        if($id != 0)
        {
            $res = $areaM->where('id = ' . $id)->save($data);
            //echo $areaM->getLastSql();
            if($res > 0)
                echo '更新成功';
            else
                echo '更新失败';
        }else
        {
            $insert_id =$areaM->add($data);
            if($insert_id != 0)
                echo '新增成功';
            else
                echo '插入失败';
        }

    }

    public function del(){
        $id = I('id', 0);
        if($id > 0){
            $areaM = M('area');
            $res = $areaM->where('id = ' . $id)->delete();

            if($res > 0)
                echo '删除成功';
            else
                echo '删除失败';
        }

    }

    public function selectJsonSendwarehome()
    {
        $where = array();

        $send_warehomeM = M('send_warehome');//发货仓
        $count = $send_warehomeM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $send_warehomeM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        if(!empty($list)){
            $suplyM = M('supply');//发货渠道
            foreach($list as $key => $item){
                $supply = $suplyM->where("id=".$item['supply_id'])->find();
                if(!empty($supply))
                {
                    $list[$key]['supply_name'] = $supply['real_name'];//渠道名
                }
                else{
                    $list[$key]['supply_name'] = '查询出错';
                }

            }
        }

        $result  = array('data' => $list, 'key' => array('id', 'name', 'supply_name'), 'th'=>array('id', '发货渠道', '发货渠道名', ), 'page' => $strPage);
        echo json_encode($result);
    }
} 