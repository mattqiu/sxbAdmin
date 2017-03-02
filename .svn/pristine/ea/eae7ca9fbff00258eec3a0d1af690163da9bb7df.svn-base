<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 15/9/17
 * Time: 下午7:28
 */
class ProductClassAction extends CommonAction{


    /**
     *  商品分类列表
     */
    public function index(){

        $where = '';
        $classM = M('class');
        $count = $classM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $classM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();

        $this->assign('list', $list);

        $this->assign('page', $strPage);
        $this->display();
//
//        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `name` varchar(120) NOT NULL DEFAULT '',
//  `parent_id` int(11) NOT NULL DEFAULT '1',
//  `order_id` decimal(10,2) NOT NULL DEFAULT '0.00',
//  `is_show` tinyint(3) NOT NULL DEFAULT '1',
//  `step` smallint(11) NOT NULL DEFAULT '1',
//  `cat_path` varchar(20) DEFAULT NULL,
//  `ename` varchar(100) DEFAULT NULL,
//  `photo` varchar(120) DEFAULT NULL,
//  `product_id` varchar(100) DEFAULT NULL,
//  `class_photo` varchar(120) DEFAULT NULL,
//  `send_region` text,
//  `link` varchar(255) DEFAULT NULL,
//  `is_split` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-不分割，1-分割',
//  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
    }

    /**
     *  编辑商品分类
     */
    public function edit(){
        $id = I('id', 0);
        $modelM = M('class');
        $info = array();
        if($id > 0){
            $info = $modelM->where('id = ' . $id)->find();
            if(!empty($info['send_region'])){
                $info['send_region'] = implode(',', unserialize($info['send_region']));
            }
        }

        $this->assign('item',  $info);
        $this->display();
    }

    /**
     *  添加商品分类
     */
    public function add(){
        $classM = M('class');
        $classList = $classM->where('parent_id = 0')->select();
        $this->assign('class_top_list', $classList);
        $this->display();
    }

    /**
     *  保存添加或新建的商品分类信息
     */
    public function save(){

        $classM = M('class');
        $classData = array();
        $classData['name'] = I('name', '');
        $classData['parent_id'] = I('parent_id', 0);
        $classData['order_id'] = I('order_id', 0);
        $classData['is_show'] = I('is_show', 1);
        $classData['step'] = I('step', 0);
        $classData['cat_path'] = I('cat_path', '');
        $classData['ename'] = I('ename', '');

        $classData['product_id'] = I('product_id', 0);
        $classData['product_id'] = I('product_id', 0);

        $classData['send_region'] = I('send_region', '');
        if(!empty($classData['send_region'])){
            $classData['send_region'] = serialize(explode(',', $classData['send_region']));
        }
        $classData['link'] = I('link', '');
        $classData['is_split'] = I('is_split', 0);
        $classData['is_hot'] = I('is_hot', 0);

        $upyunPhotoPath = I('old_photo', '');
        if(isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])){
            $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
            if(!is_dir($savePath)) {
                mkdir($savePath);
            }
            $fileFix = explode('/', $_FILES['photo']['type']);
            $fileName = md5($_FILES['photo']['name'] . time()) . '.' . $fileFix[1];
            $uploadFile = $savePath . $fileName;
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile);
            $dateArr = explode('-', date('Y-m-d', time()));
            $upyunPhotoPath = '/product_class/' . $dateArr[0] . '/' . $dateArr[1] . '/' . $dateArr[2] . '/'. $fileName;
            uploadToUpYum($upyunPhotoPath, $uploadFile);

        }

        $upyunClassPhotoPath = I('old_class_photo', '');
        if(isset($_FILES['class_photo']['name']) && !empty($_FILES['class_photo']['name'])){
            $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
            if(!is_dir($savePath)) {
                mkdir($savePath);
            }
            $fileFix = explode('/', $_FILES['class_photo']['type']);
            $fileName = md5($_FILES['class_photo']['name'] . time()) . '.' . $fileFix[1];
            $uploadFile = $savePath . $fileName;
            move_uploaded_file($_FILES['class_photo']['tmp_name'], $uploadFile);
            $dateArr = explode('-', date('Y-m-d', time()));
            $upyunClassPhotoPath = '/product_class/' . $dateArr[0] . '/' . $dateArr[1] . '/' . $dateArr[2] . '/'. $fileName;
            uploadToUpYum($upyunClassPhotoPath, $uploadFile);
        }

        $classData['photo'] = $upyunPhotoPath;   //分类icon图片
        $classData['class_photo'] = $upyunClassPhotoPath;  //热门图片

        $id = I('id', 0);
        if($id > 0){
            $classM->where('id =' . $id)->save($classData);
        } else {
            $classM->add($classData);
        }

        redirect('/ProductClass/index');
    }

    /**
     *  删除商品分类
     */
    public function del(){
        $id = I('id', 0);
        if($id > 0){
            $modelM = M('class');
            $modelM->where('id = ' . $id)->delete();
        }

        redirect('/ProductClass/index');
    }

    public function selectJson(){
        $where = '';

        $classM = M('class');
        $count = $classM->where($where)->count();
        $page = new Page($count, 10);
        $strPage = $page->show();
        $list = $classM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();
        $result  = array('data' => $list, 'key' => array('id', 'name'), 'th'=>array('id', '名称'), 'page' => $strPage);
        echo json_encode($result);
    }


}