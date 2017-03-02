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
 *  商品管理
 * Class ProductAction
 */
class ProductAction extends CommonAction{


    /**
     *  商品列表
     */
    public function index(){
        $where = array();
        $where['distributor_id'] = array('eq', '0');

        $productM = new ProductModel();
        $count = $productM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $productM->where($where)->relation(true)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();

        $this->assign('list', $list);

        $this->assign('page', $strPage);
        $this->display();
    }

    /**
     *  编辑或添加商品信息
     */
    public function edit(){
        $id = I('id', 0);

        $proClassM = M('pro_class');
        $classList = $proClassM->where('product_id = ' . $id)->select();
        $classIdsArr = array();
        if(!empty($classList)){
            foreach($classList as $item){
                $classIdsArr[] = $item['class_id'];
            }
        }



        if($id > 0){
            $productM = new ProductModel();
            $productInfo = $productM->relation(true)->where('id = ' . $id)->find();

            $productInfo['pro_class_ids'] = implode(',', $classIdsArr);
            $productInfo['send_region_ids'] = '';

            $sendRegionArr = unserialize($productInfo['send_region']);
            $productInfo['send_region_ids'] = implode(',', $sendRegionArr);

            $productInfo['production_date'] = substr($productInfo['production_date'], 0, 10);
            $productInfo['expiration_date'] = substr($productInfo['expiration_date'], 0, 10);

            if(!empty($productInfo['send_warehome']))
            {
                $send_warehomeM = M('send_warehome');//发货仓


                $js_sendwarehome = json_decode($productInfo['send_warehome'],true);
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

                $productInfo['send_warehome'] = $js_sendwarehome;
                $count = count($js_sendwarehome);
            }
        }

        $supplyM = M('supply');
        $supplyList = $supplyM->where('status = 1')->select();
        $this->assign("supply_list", $supplyList);
        $this->assign('product', $productInfo);

        $this->assign('send_warehomes',$productInfo['send_warehome']);
        $this->assign('send_warehomecount', $count);
        $this->display();
    }

    /**
     *  复制商品信息
     */
    public function copy(){
        $id = I('id', 0);

        $classM = M('class');
        $classList = $classM->select();
        $this->assign('class_list', $classList);
        $allClassStr = '';
        if(!empty($classList)){
            foreach($classList as $item){
                $classIdsArr[] = $item['id'];
            }
            $allClassStr = implode(',', $classIdsArr);
        }
        $this->assign('class_ids', $allClassStr);

        $productPhotoM = M('product_photo');
        $productPriceM = M('product_price');
        $proClassM = M('pro_class');
        $productGiftsM = M('product_gifts');

        if($id > 0){
            $productM = new ProductModel();
            $productInfo = $productM->relation(true)->where('id = ' . $id)->find();
            $productData = $productM->where('id = ' . $id)->find();

            if(!empty($productData)){
                unset($productData['id']);
                $productId = $productM->add($productData);
            }

            if(!empty($productInfo['product_photo'])){
                foreach($productInfo['product_photo'] as $photo){
                    unset($photo['id']);
                    $photo['product_id'] = $productId;
                    $productPhotoM->add($photo);
                }
            }

            if(!empty($productInfo['product_price'])){
                foreach($productInfo['product_price'] as $item){
                    unset($item['id']);
                    $item['product_id'] = $productId;
                    $productPriceM->add($item);
                }
            }

            if(!empty($productInfo['product_gifts'])){
                foreach($productInfo['product_gifts'] as $item){
                    unset($item['id']);
                    $item['pid'] = $productId;
                    $productGiftsM->add($item);
                }
            }

            $productInfo['pro_class_ids'] = '';
            $productInfo['send_region_ids'] = '';
            if(!empty($productInfo['pro_class'])){
                $proClassArr = array();
                foreach($productInfo['pro_class'] as $pclass){
                    $proClassM->add(array(
                        'product_id' => $productId,
                        'class_id' => $pclass['class_id']
                    ));

                    $proClassArr[] = $pclass['class_id'];
                }

                $sendRegionArr = unserialize($productInfo['send_region']);
                $productInfo['send_region_ids'] = implode(',', $sendRegionArr);

                $productInfo['pro_class_ids'] = implode(',', $proClassArr);
            }

        }

        $productInfo = $productM->relation(true)->where('id = ' . $productId)->find();
        $this->assign('product', $productInfo);
        $this->display('edit');
    }

    /**
     *  新增或编辑后保存
     */
    public function save(){
        $productId = I('id', 0);

        $productData = array();
        $productData['product_name'] = I("product_name", '');
        $productData['product_number'] = I("product_number", '');
        $productData['production_date'] = I("production_date", '');
        $productData['expiration_date'] = I("expiration_date", '');
        $productData['promo_code'] = I("promo_code", '');
        $productData['discount'] = I("discount", 0);
        $productData['period'] = I("period", '0000-00-00');
        $productData['summary'] = $_POST['summary'];
        $productData['tips'] = $_POST['tips'];
        $productData['discription'] = $_POST['discription'];
        $productData['consumer_tips'] = $_POST['consumer_tips'];

        $productData['photo'] = I("photo", '');
        $productData['join_img'] = I("join_img", '');
        $productData['online'] = I('online', 1);
        $productData['mobile_online'] = I('mobile_online', 1);
        $productData['app_online'] = I('app_online', 1);

        //有库存的发货仓信息
        $sendwarehome_ids = $_REQUEST['sendwarehome_id'];

        $send_warehome_data = array();
        for($i=0;$i<count($sendwarehome_ids);$i++)
        {
            $send_warehome_one = array(
                'warehome_id'=>$sendwarehome_ids[$i],
            );
            $send_warehome_data[] = $send_warehome_one;
        }
        $productData['send_warehome'] = json_encode($send_warehome_data);
        //=======================

        if(!empty($productData['photo'])){
            $productData['thum_photo'] = $productData['photo'] . '!miniproductimg';
            $productData['middle_photo'] = $productData['photo'] . '!middlephoto';
            $productData['bphoto'] = $productData['photo'] . '!bphoto';
            $productData['thum_min_photo'] = $productData['photo'] . '!thumminphoto';
        }

        $productData['send_region'] = serialize(explode(',', I('send_region')));
        $productData['jzw_order_id'] = I('jzw_order_id', '0.00');

        $productM = M('product');
        $productPriceM = M('product_price');
        $productGiftsM = M('product_gifts');

        foreach($productData as $k=>$v){
            if(empty($v)){
                unset($productData[$k]);
            }
        }
        if($productId > 0){
            $productM->where('id = ' . $productId)->save($productData);
        } else {
            $productId =  $productM->add($productData);
        }

        //商品分类
        $proClassM = M('pro_class');


        $product_class = I('product_class', '');
        if(!empty($product_class)){
            $proClassM->where('product_id = ' . $productId)->delete();
            $proClassArr = explode(',', $product_class);
            $classData = array();
            foreach($proClassArr as $classId){
                $classData[] = array('product_id' => $productId, 'class_id' => $classId);
            }
            $proClassM->addAll($classData);
        }

        $price = $_POST['price'];
        if(!empty($price)){
            $volume = $_POST['volume'];
            $product_no = $_POST['product_no'];
            $mobile_product_no = $_POST['mobile_product_no'];
//            $price = $_POST['price'];
            $mobile_price = $_POST['mobile_price'];
            $unit = $_POST['unit'];
            $price_order_id = $_POST['price_order_id'];
            $stock = $_POST['stock'];
            $weight = $_POST['weight'];
            $mem_lv = $_POST['mem_lv'];
            $mem_lv_price = $_POST['mem_lv_price'];
            $can_mem_buy = $_POST['can_mem_buy'];
            $old_price = $_POST['old_price'];
            $start_time = $_POST['start_time'];
            $over_time = $_POST['over_time'];
            $send_channel = $_POST['send_channel'];

            $productPriceData = array();
            foreach($price as $k=> $value){
                if(empty($value) || empty($product_no[$k])){
                    continue;
                }
                $priceItem = array();
                $priceItem['product_id'] = $productId;
                $priceItem['volume'] = $volume[$k];
                $priceItem['product_no'] = $product_no[$k];
                $priceItem['mobile_product_no'] = $mobile_product_no[$k];
                $priceItem['price'] = $price[$k];
                $priceItem['mobile_price'] = $mobile_price[$k];
                $priceItem['unit'] = $unit[$k];
                $priceItem['price_order_id'] = $price_order_id[$k];
                $priceItem['stock'] = $stock[$k];
                $priceItem['weight'] = $weight[$k];
                $priceItem['mem_lv'] = $mem_lv[$k];
                $priceItem['mem_lv_price'] = $mem_lv_price[$k];
                $priceItem['can_mem_buy'] = empty($can_mem_buy[$k]) ? 1 : $can_mem_buy[$k];
                $priceItem['old_price'] = $old_price[$k];
                $priceItem['start_time'] = $start_time[$k];
                $priceItem['over_time'] = $over_time[$k];
                $priceItem['send_channel'] = $send_channel[$k];

                foreach($priceItem as $k=>$v){
                    if(empty($v)){
                        unset($priceItem[$k]);
                    }
                }

                $productPriceData[] = $priceItem;
            }



            $productPriceM->addAll($productPriceData);
        }

        $gift_photo = $_POST['gift_photo'];
        $gname = $_POST['gname'];
        $gno = $_POST['gno'];
        $gnum = $_POST['gnum'];
        $gprice = $_POST['gprice'];
        $gift_weight = $_POST['gift_weight'];
        $gift_order_id = $_POST['gift_order_id'];

        if(!empty($gname)){
            $giftsData = array();
            foreach($gname as $key => $value){
                if(empty($value)){
                    continue;
                }

                $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
                if(!is_dir($savePath)) {
                    mkdir($savePath);
                }
                $fileFix = explode('/', $_FILES['gift_photo']['type'][$key]);
                $fileName = md5($_FILES['gift_photo']['name'][$key] . time()) . '.' . $fileFix[1];
                $uploadFile = $savePath . $fileName;
                move_uploaded_file($_FILES['gift_photo']['tmp_name'][$key], $uploadFile);
                $dateArr = explode('-', date('Y-m-d', time()));
                $upyunPath = '/product_gifts/' . $dateArr[0] . '/' . $dateArr[1] . '/' . $dateArr[2] . '/'. $fileName;
                uploadToUpYum($upyunPath, $uploadFile);

                $giftsItem = array();
                $giftsItem['gift_photo'] = $upyunPath;
                $giftsItem['pid'] = $productId;
                $giftsItem['gname'] = $gname[$key];
                $giftsItem['gno'] = $gno[$key];
                $giftsItem['gnum'] = $gnum[$key];
                $giftsItem['gprice'] = $gprice[$key];
                $giftsItem['gift_weight'] = $gift_weight[$key];
                $giftsItem['gift_order_id'] = $gift_order_id[$key];

                foreach($giftsItem as $k=>$v){
                    if(empty($v)){
                        unset($giftsItem[$k]);
                    }
                }

                $giftsData[] = $giftsItem;
            }

            $productGiftsM->addAll($giftsData);
        }

        redirect('/index.php?s=/Product/index');
    }


    /**
     *  删除商品
     */
    public function del(){
        $id = I('id', 0);
        if($id > 0){
            $productM = M('product');
            $productPriceM = M('product_price');
            $productGiftsM = M('product_gifts');
            $productM->where('id = ' . $id)->delete();
            $productPriceM->where('product_id = ' . $id)->delete();
            $productGiftsM->where('pid = ' . $id)->delete();
        }

        redirect('/Product/index');
    }

    /**
     *  更新 product_price （规格） 表 中的某一个字段
     */
    public function update_product_price(){
        $productPriceM = M('product_price');
        $field = I('field', '');
        $productId = I('product_id', 0);
        $id = I('id', 0);
        $value = I('val', '');
        if(!empty($field) && $productId > 0 && $id > 0){
            $data = array();
            $data[$field] = $value;
            $productPriceM->where('id = ' . $id . ' AND  product_id = ' . $productId)->save($data);
        }

        echo $productPriceM->getLastSql();
    }

    public function update_product_gifts(){
        $modelM = M('product_gifts');
        $field = I('field', '');
        $productId = I('product_id', 0);
        $id = I('id', 0);
        $value = I('val', '');
        if(!empty($field) && $productId > 0 && $id > 0){
            $data = array();
            $data[$field] = $value;
            $modelM->where('id = ' . $id . ' AND  pid = ' . $productId)->save($data);
        }

        echo $modelM->getLastSql();
    }

    public function del_product_price(){
        $id = I('id', 0);
        $productId = I('product_id', 0);
        if($id > 0 && $productId > 0){
            $modelM = M('product_price');
            $modelM->where('id = ' . $id . ' AND product_id = ' . $productId)->delete();
        }
    }

    public function del_product_gift(){
        $id = I('id', 0);
        $productId = I('pid', 0);
        if($id > 0 && $productId > 0){
            $modelM = M('product_gifts');
            $modelM->where('id = ' . $id . ' AND pid = ' . $productId)->delete();
            echo $modelM->getLastSql();
        }


    }

    public function get_product_price(){
        $productId = I("product_id", 0);
        $priceHtml = '';
        $supplyM = M('supply');
        $supplyList = $supplyM->where('status = 1')->select();
        $this->assign("supply_list", $supplyList);

        if($productId > 0){
            $productPriceM = M('product_price');
            $list = $productPriceM->where('product_id = ' . $productId)->select();
            $this->assign('product_price', $list);
            $priceHtml = $this->fetch('product_price');
        }

        echo $priceHtml;
    }

    public function get_product_gifts(){
        $productId = I("product_id", 0);
        $html = '';
        if($productId > 0){
            $productGiftsM = M('product_gifts');
            $list = $productGiftsM->where('pid = ' . $productId)->select();
            $this->assign('product_gifts', $list);
            $html = $this->fetch('product_gifts');
        }

        echo $html;
    }

    /**
     *  商品相册列表
     */
    public function photos(){
        $id = I('id', 0);
        $photosM = M('product_photo');
        $list = array();
        if($id> 0){
           $list = $photosM->where('product_id = ' . $id)->select();
        }

        $this->assign('product_id', $id);
        $this->assign('list', $list);
        $this->display();
    }

    /**
     *  保存商品相册图片
     */
    public function savePhotos(){
        $productId = I('product_id', 0);
        if($productId > 0 && !empty($_FILES['photo']['type'])){
            $modelM = M('product_photo');
            $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
            if(!is_dir($savePath)) {
                mkdir($savePath);
            }
            $data = array();
            if(count($_FILES['photo']['type']) > 1){
                foreach($_FILES['photo']['type'] as $key => $type){
                    if(empty($type)){
                        continue;
                    }
                    $fileFix = explode('/', $_FILES['photo']['type'][$key]);
                    $fileName = md5($_FILES['photo']['name'][$key] . time()) . '.' . $fileFix[1];
                    $uploadFile = $savePath . $fileName;
                    move_uploaded_file($_FILES['photo']['tmp_name'][$key], $uploadFile);
                    $dateArr = explode('-', date('Y-m-d', time()));
                    $upyunPath = '/product_photo/' . $dateArr[0] . '/' . $dateArr[1] . '/' . $dateArr[2] . '/'. $fileName;
                    uploadToUpYum($upyunPath, $uploadFile);

                    $dataItem = array();
                    $dataItem['product_id'] = $productId;
                    $dataItem['thum_photo'] = $upyunPath;
                    $dataItem['photo'] = $upyunPath;
                    $dataItem['bphoto'] = $upyunPath;
                    $dataItem['thum_min_photo'] = $upyunPath;
                    $dataItem['order_id'] = $_POST['order_id'][$key];

                    $data[] = $dataItem;
                }
            }

            $modelM->addAll($data);
        }

        redirect('/index.php?s=/Product/index');
    }



    public function getPhotos(){
        $productId = I("product_id", 0);
        $html = '';
        $this->assign('product_id', $productId);
        if($productId > 0){
            $productPhotoM = M('product_photo');
            $list = $productPhotoM->where('product_id = ' . $productId)->select();
            $this->assign('list', $list);
            $html = $this->fetch('product_photos');
        }

        echo $html;
    }

    public function updatePhoto(){
        $id = I('id', 0);
        $orderId = I('order_id', 0);
        if($id > 0 && $orderId > 0){
            $modelM = M('product_photo');
            $modelM->where('id = ' . $id)->save(array('order_id' => $orderId));
        }
    }

    public function delPhoto(){
        $id = I('id', 0);
        if($id > 0){
            $modelM = M('product_photo');
            $modelM->where('id = ' . $id)->delete();
        }
    }

    public function getProductInfo(){
        $productId = I('product_id', 0);
        $productM = D('Product');
        $productInfo = $productM->relation('product_price')->where('id = ' . $productId)->find();

        echo json_encode($productInfo);
    }

    public function selectJson(){
        $where = '';

        $productM = new ProductModel();
        $count = $productM->where($where)->count();
        $page = new Page($count, 10);
        $strPage = $page->show();
        $list = $productM->where($where)->relation(true)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();
        $result  = array('data' => $list, 'key' => array('id', 'product_name', 'product_number'), 'th'=>array('id', '名称', '编号'), 'page' => $strPage);
        echo json_encode($result);
    }

} 