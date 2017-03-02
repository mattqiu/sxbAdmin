<?php

/**
 * 阿里云rds 二进制日志
 * Class RdsBinlogAction
 */
Vendor('aliyun/AcsRequest');
Vendor('aliyun/RpcAcsRequest');
Vendor('aliyun/DescribeBinlogFilesRequest');
Vendor('aliyun/DefaultAcsClient');
Vendor('aliyun/Auth/Credential');
Vendor('aliyun/Auth/ISigner');
Vendor('aliyun/Auth/ShaHmac1Signer');
Vendor('aliyun/Auth/ShaHmac256Signer');
Vendor('aliyun/Profile/DefaultProfile');
class RdsBinlogAction extends CommonAction {

    public function _init(){
        set_time_limit(0);
        header('"text/html; charset=UTF-8"');
    }

    public function index() {
//        $accessKey = 'P9n3Fv2K437YKLgP';
//        $accessSercetKey = 'FwE7zpVtLgCQyqKWJ7ppg6GHmLJ1RY';
//        $instanceId = 'rds2698sy20670yn6u76';

        $accessKey = 'P9n3Fv2K437YKLgP';
        $accessSercetKey = 'FwE7zpVtLgCQyqKWJ7ppg6GHmLJ1RY';
        $instanceId = 'rds2698sy20670yn6u76';
        $url ='rds.aliyuncs.com';

        $iClientProfile = DefaultProfile::getProfile("cn-hangzhou", $accessKey, $accessSercetKey);
        $client = new DefaultAcsClient($iClientProfile);

        $startTime = I('start_time', date('Y-m-d', time() - 86400 * 7));
        $endTime = I('end_time', date('Y-m-d', time()));
        $pageSize = I('page_size', 100);
        $pageNumber = I('page_number', 1);

        $request = new DescribeBinlogFilesRequest();
        $request->setMethod("GET");
        $request->setDBInstanceId($instanceId);
        $request->setStartTime($startTime . 'T00:00:00Z');
        $request->setEndTime($endTime . 'T23:59:59Z');
        $request->setPageSize($pageSize);
        $request->setPageNumber($pageNumber);
        $response = $client->getAcsResponse($request);
        print_r($response);
    }
}