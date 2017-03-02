<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/3/25
 * Time: 下午8:02
 */
class ProductSaleVolumeModel extends CommonModel{

    public function getSaleData($fromDate, $toDate){
        $where = array();
        $where['date'] = array(array('egt', $fromDate), array('elt', $toDate));
        $list = $this->where($where)->select();

        $dateKeyArr = array();
        $fromTime = strtotime($fromDate);
        $toTime = strtotime($toDate);

        for($fromTime; $fromTime < $toTime; $fromTime += 86400){
            $dateKeyArr[] = date('Y-m-d', $fromTime);
        }

        $dateKeyArr[] = date('Y-m-d', $fromTime);

        $dataList = array();
        if(!empty($list)){
            foreach ($list as $item) {
                $productKey = md5($item['product_id'] . $item['standard'] . $item['product_name']);
                $dataList[$productKey]['product_id'] = $item['product_id'];
                $dataList[$productKey]['product_name'] = $item['product_name'];
                $dataList[$productKey]['standard'] = $item['standard'];
                $dataList[$productKey][$item['date']] = intval($dataList[$productKey][$item['date']]) + $item['sale_volume'];
                $dataList[$productKey][$item['send_warehome_en_name']] = intval($dataList[$productKey][$item['send_warehome_en_name']]) +  $item['sale_volume'];
                $dataList[$productKey]['total'] = intval($dataList[$productKey]['total']) + $item['sale_volume'];
            }

            //在选中的时间段中的每一天都需要设置一个值, 否则可能会造成每一行的数据长度不一致
            foreach($dataList as $key => $dataItem){
                foreach($dateKeyArr as $date){
                    if(!isset($dataItem[$date])){
                        $dataItem[$date] = 0;
                    }
                }

                ksort($dataItem);
                $dataList[$key] = $dataItem;
            }
        }

        return $dataList;
    }

    public function getSaleDataXcel($fromDate, $toDate){
        $dataList = $this->getSaleData($fromDate, $toDate);

        if(empty($dataList)){
            return array();
        }

        $excelData = array();
        foreach($dataList as $data){
            $excelDataItem = array();
            $excelDataItem['product_name'] = $data['product_name'];
            $excelDataItem['standard'] = $data['standard'];
            $excelDataItem['shttgy'] = isset($data['shttgy']) ? $data['shttgy'] : 0;
            $excelDataItem['bjttgy'] = isset($data['bjttgy']) ? $data['bjttgy'] : 0;
            $excelDataItem['gzttgy'] = isset($data['gzttgy']) ? $data['gzttgy'] : 0;
            $excelDataItem['cdttgy'] = isset($data['cdttgy']) ? $data['cdttgy'] : 0;
            $excelDataItem['total'] = isset($data['total']) ? $data['total'] : 0;

            $excelData[] = $excelDataItem;
        }

        return $excelData;
    }
}