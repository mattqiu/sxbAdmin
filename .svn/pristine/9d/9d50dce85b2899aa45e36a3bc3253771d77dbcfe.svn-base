<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 15/9/16
 * Time: 下午7:58
 */
Vendor('upyun');
class UpyunAction extends Action{

    /**
     *  上传图片
     */
    public function uploadimg(){

        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        if(!is_dir($savePath)) {
            mkdir($savePath);
        }

        $imgDir = I('image_dir', 'product');

        foreach($_FILES as $key => $value){
            $fileFix = explode('/', $value['type']);
            $fileName = md5($value['name'] . time()) . '.' . $fileFix[1];
            $uploadFile = $savePath . $fileName;
            move_uploaded_file($value['tmp_name'], $uploadFile);
            $upyun = new UpYun('shipinmmm-img', 'spchris', 'sp&98chris123');

            $fh = fopen($uploadFile, 'rb');
            $dateArr = explode('-', date('Y-m-d', time()));
            $upyunPath = '/' . $imgDir . '/' . $dateArr[0] . '/' . $dateArr[1] . '/' . $dateArr[2] . '/'. $fileName;
            $rsp = $upyun->writeFile($upyunPath, $fh, True);   // 上传图片，自动创建目录
            fclose($fh);
        }

        $result['full_url'] = 'http://img0.shipinmmm.com/' . $upyunPath;
        $result['img_url'] = $upyunPath;

        echo json_encode($result);
    }
}