<?php

/**
 * Created by PhpStorm.
 * User: chrisying
 * Date: 16/3/25
 * Time: 下午5:09
 */
class ProductSaleDataAction extends CommonAction{

    /**
     *  默认显示最近7天的销量数据
     */
    public function index(){

        $fromDate = I('from_date', date('Y-m-d', time() - 86400 * 8));
        $toDate = I('to_date', date('Y-m-d', time() - 86400));

        $productSaleVolumeM = new ProductSaleVolumeModel();

        $keyArr = array('shttgy02', 'shttgy', 'bjttgy', 'gzttgy', 'cdttgy', 'total');
        $allKey = array('shttgy02'=>'上海仓2神猴', 'shttgy' => '上海仓', 'bjttgy' => '北京仓', 'gzttgy' => '广州仓', 'cdttgy' => '成都仓'
         , 'total' => '总计');
        $listKey = array();
        $dataList = $productSaleVolumeM->getSaleData($fromDate, $toDate);
        if(!empty($dataList)){
            foreach($dataList as $key => $item){
                $tmpArr = array();
                foreach($keyArr as $kv){
                    $tmpArr[$kv] = isset($item[$kv]) ? $item[$kv] : 0;
                    unset($dataList[$key][$kv]);

                    $dataList[$key][$kv] = $tmpArr[$kv];
                }
            }

            foreach($dataList as $item){
                foreach($item as $key => $value){
                    if(in_array($key, array('product_name', 'standard', 'product_id'))){
                        continue;
                    }
                    $listKey[$key] = in_array($key, array('shttgy02', 'shttgy', 'bjttgy', 'gzttgy', 'cdttgy', 'total', 'product_name', 'standard', 'product_id'))
                        ? $allKey[$key] : substr($key, 5);
                }

                break;
            }
        }

        $this->assign('list_key', $listKey);
        $this->assign('list', $dataList);
        $this->display();
    }

    /**
     *  导出数据报表
     */
    public function export(){
        $fromDate = I('from_date', '2016-02-01');
        $toDate = I('to_date', '2016-03-20');

        $productSaleVolumeM = new ProductSaleVolumeModel();
        $excelData = $productSaleVolumeM->getSaleDataXcel($fromDate, $toDate);
        $excelTitle = array(array('product_id', '商品id'), array('product_name', '商品名称'), array('standard', '规格'), array('shttgy', '上海仓销量')
        , array('bjttgy', '北京仓销量'), array('gzttgy', '广州仓销量'), array('cdttgy', '成都仓销量'), array('total', '总销量'));

        exportExcel('商品销量表' . $fromDate . '-' . $toDate, $excelTitle, $excelData, '', true);
    }



}