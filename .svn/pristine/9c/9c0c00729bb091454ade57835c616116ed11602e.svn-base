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
 *  抢购管理
 * Class GroupBuyingAction
 */
class PanicBuyingAction extends CommonAction{

    /**
     *  所有抢购
     */
    public function index(){
        $panicBuyingM = M('panicbuying');

        $channel = C('CHANNEL');

        $where = '';
        $count = $panicBuyingM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $panicBuyingM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();
        if(!empty($list)){
            foreach ($list as  $key => $item) {
                $list[$key]['channel'] = $channel[$item['channel']];
                $list[$key]['pricechange_type'] = $item['pricechange_type'] > 0 ? '线性降价' : '阶梯降价';
                $list[$key]['auction_begintime'] = date('y-m-d H:i:s', $item['auction_begintime']);
                $list[$key]['auction_endtime'] = date('y-m-d H:i:s', $item['auction_endtime']);
                if(intval($item['pricechange_type']) === 1){
                    $list[$key]['now_price'] = $this->calPriceCountDown($item['auction_begintime'], $item['auction_endtime']
                        ,$item['pricechange_interval'], $item['pricechange_money'], $item['auction_pricebegin'], $item['auction_priceend'] );
                } else {
                    $nowTime = time();
                    $offTimeData = json_decode($item['pricechange_nolinear_data']);
                    $list[$key]['now_price'] = $item['auction_pricebegin'];
                    if(!empty($offTimeData)){
                        foreach($offTimeData as $offTimePrice){
                            if($nowTime > $offTimePrice['time'] && $$list[$key]['now_price'] > $offTimePrice['price']){
                                $list[$key]['now_price'] = $offTimePrice['price'];
                            }
                        }
                    }
                }
            }
        }

        $this->assign('list', $list);
        $this->assign('page', $strPage);

        $this->display();
    }

    /**
     *  新建一个抢购
     */
    public function add(){
        $goodsId = intval(I('goods_id', 0));
        $beginTime = trim(I('begin_time', ''));
        $endTime = trim(I('end_time', ''));
        $beginPrice = floatval(I('begin_price', 0));
        $endPrice = floatval(I('end_price', 0));
        $limitNum = intval(I('limit_num', 0));
        $timeCell = intval(I('time_cell', 0));
        $offPrice = floatval(I('off_price', 0));
        $offType = trim(I('off_type', ''));
        $store = intval(I('store', 0));
        $offTime = $_POST['off_time'];
        $offTimePrice = $_POST['off_time_price'];


        $pricechangeType = 1;

        if($goodsId > 0 && !empty($offType) && !empty($beginTime) && !empty($endTime) && $store > 0){

            $panicBuyingM = M('panicbuying');
            $productM = M('product');
            $productPriceM = M('product_price');
            $product = $productM->where('id = ' . $goodsId)->find();
            $productPrice = $productPriceM->where('product_id = ' . $goodsId)->find();
            $data = array();

            $data['product_id'] = $goodsId;
            $data['product_name'] = $product['product_name'];
            $data['product_oriprice'] = $productPrice['old_price'];
            $data['product_stock'] = $store;
            $data['auction_begintime'] = strtotime($beginTime);
            $data['auction_endtime'] = strtotime($endTime);
            $data['auction_pricebegin'] = $beginPrice;
            $data['auction_priceend'] = $endPrice;
            $data['limitpurchase'] = $limitNum;
            $data['channel'] = I('channel', 'portal');
            $data['send_region'] = I('send_region', '');

            switch($offType){
                case 'linear_off':
                    $pricechangeType = 1;
                    if($timeCell > 0 && $offPrice > 0){

                        $data['pricechange_interval'] = $timeCell;  //时间间隔
                        $data['pricechange_money'] = $offPrice;  //降价幅度
                    }
                    break;
                case 'ladder_off':
                    $pricechangeType = 0;
                    if(!empty($offTime)){
                        $ladderOffData = array();
                        foreach($offTime as $k=>$v){
                            $ladderOffData[] = array('time' => strtotime($v), 'price' => $offTimePrice[$k]);
                        }

                        //阶梯式降价json数据 时间点， 价格
                        $data['pricechange_nonlinear_data'] = json_encode($ladderOffData);
                    }
                    break;
            }
            $data['pricechange_type'] = $pricechangeType;         //价格变动类型
            $data['send_region'] = 'a:28:{i:0;s:1:"1";i:1;s:5:"54351";i:2;s:6:"106092";i:3;s:6:"106340";i:4;s:6:"143949";i:5;s:6:"143967";i:6;s:6:"143983";i:7;s:6:"143996";i:8;s:6:"144005";i:9;s:6:"144035";i:10;s:6:"144039";i:11;s:6:"144045";i:12;s:6:"144051";i:13;s:6:"144224";i:14;s:6:"144252";i:15;s:6:"144370";i:16;s:6:"144379";i:17;s:6:"144387";i:18;s:6:"144412";i:19;s:6:"144443";i:20;s:6:"144522";i:21;s:6:"144551";i:22;s:6:"144595";i:23;s:6:"144627";i:24;s:6:"144643";i:25;s:6:"144795";i:26;s:6:"145843";i:27;s:6:"145855";}';

            $panicBuyingM->add($data);
            redirect(U('PanicBuying/index'));
        }

        $this->display();
    }

    private function calPriceCountDown($begin_timestamp,$end_timestamp,$changeinterval,$changeprice,$oriprice,$priceend)
    {
        $now = time();
        if($now > $end_timestamp)
            return $priceend;

        $timediff = $now - $begin_timestamp;
        $nowprice = $oriprice - $changeprice*intval($timediff/(1000*60*$changeinterval)) ;
        if($nowprice < intval($priceend))
            $nowprice = intval($priceend);
        if($nowprice<0)
            $nowprice = 0;

        return $nowprice;
    }
}