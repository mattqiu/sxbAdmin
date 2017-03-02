<?php

/**
 * Class SendWarehomeModel
 *  发货仓
 */
class SendWarehomeModel extends CommonModel {
    private $areaM;
    private $map_warehome;

    public function _initialize() {
        $this->areaM = M('area');
        $send_warehomeM = M('send_warehome');
        //取出所有的发货仓信息（最多100来条）
        $this->map_warehome = array();
        $warehomewhere = array();
        $listSendwarehome = $send_warehomeM->where($warehomewhere)->select();
        if(!empty($listSendwarehome)) {
            //做好映射
            foreach ($listSendwarehome as $value) {
                $this->map_warehome[$value['id']] = $value;
            }
        }
    }


    /**
     *  计算订单对应的发货仓
     */
    public function getOrderWareHome($provinceCode, $productWareHome) {
        $data = array();
        $data['send_warehome_id'] = 0;
        $data['send_warehome_name'] = '';
        $data['send_warehome_en_name'] = '';
        $data['source_city'] = '';

        $productItem['send_warehome'] = $productWareHome;
        //        $province_code = $item['province'];//省份代号
        //取省份地址对应的最优发货仓,然后查看最佳仓是否有货，没有就找到最后。
        $where_area = 'id=' . $provinceCode;
        $province_area = $this->areaM->where($where_area)->find();
        $countWarehome = 0;
        if(!empty($province_area['send_warehome'])) {
            $province_area['send_warehome'] = json_decode($province_area['send_warehome'], true);
            $countWarehome = count($province_area['send_warehome']);
        }

        //取出商品的仓库信息
        $array_product_warehome_ids = array();
        $map_product_warehome_ids = array();//映射

        $get_sendwarehome = 0;
        if(!empty($productItem['send_warehome'])) {
            $productItem['send_warehome'] = json_decode($productItem['send_warehome'], true);
            $array_product_warehome_ids = array_column($productItem['send_warehome'], 'warehome_id');
            foreach ($array_product_warehome_ids as $valueid) {
                $map_product_warehome_ids[$valueid] = $valueid;
            }
        } else {
            $data['send_warehome_id'] = 0;
            $data['send_warehome_name'] = "没有库存的仓";
            $data['send_warehome_en_name'] = "noWareHome";
            $data['source_city'] = "";
            $get_sendwarehome = 1;
        }


        /**
         *  循环这个省支持的每个发货仓, 以下标升序，直到取到可以发此商品的仓为止
         */
        for ($i = 0; $i < $countWarehome; $i++)//下标越小为越优先的发货仓
        {
            $first_warehome = $province_area['send_warehome'][$i];
            if(!empty($first_warehome)) {
                if(isset($map_product_warehome_ids[$first_warehome['warehome_id']])) {
                    //如果这个商品在这个仓库有库存，可以从这里发货
                    $wd = $this->map_warehome[$first_warehome['warehome_id']];
                    $data['send_warehome_id'] = $first_warehome['warehome_id'];
                    $data['send_warehome_name'] = $wd['name'];
                    $data['send_warehome_en_name'] = $wd['en_name'];
                    $data['source_city'] = $wd['source_city'];

                    $get_sendwarehome = 1;
                    break;
                }
            }
        }

        if($get_sendwarehome == 0) {
            if(!empty($array_product_warehome_ids)) {
                $wd = $this->map_warehome[$array_product_warehome_ids[0]];
                $data['send_warehome_id'] = $wd['id'];
                $data['send_warehome_name'] = $wd['name'];
                $data['send_warehome_en_name'] = $wd['en_name'];
                $data['source_city'] = $wd['source_city'];
                $get_sendwarehome = 1;
            }
        }

        return $data;
    }

}