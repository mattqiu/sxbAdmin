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
 * Class CouponTemplAction
 *  优惠券模板管理
 */
class AppbannerAction extends CommonAction{

    public $model;

    public function _init(){
        $this->model = M('appbanner');
    }
    public function index(){
        $where = array();

        $where['distributor_id'] = array('eq', '0');
        $appbannerM = M('appbanner');
        $count = $appbannerM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $appbannerM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        $positionConf = array();
        $positionConf[] = array('id' => 0, 'name' => '首页轮播广告');
        $positionConf[] = array('id' => 1, 'name' => '首页普通广告');
        $positionConf[] = array('id' => 11, 'name' => '新品尝鲜');
        $positionConf[] = array('id' => 12, 'name' => '每日特惠');
        $positionConf[] = array('id' => 14, 'name' => '热门推荐');
        $positionConf[] = array('id' => 15, 'name' => '每日抢鲜');
        $positionConf[] = array('id' => 16, 'name' => '复合广告');
        $positionConf[] = array('id' => 17, 'name' => '搜索页广告');

        if(!empty($list)){
            foreach($list as $key => $item){
                foreach($positionConf as $positionItem){
                    if($positionItem['id'] == $item['position']){
                        $list[$key]['position'] = $positionItem['name'];
                    }
                }
                $list[$key]['is_show'] = 1 == $item['is_show'] ? '<span class="red">是</span>' : '<span class="green">否</span>';
            }
        }

        $this->assign('list', $list);
        $this->assign('page', $strPage);
        $this->display();
    }

    public function create(){
        $positionConf = array();
        $positionConf[] = array('id' => 0, 'name' => '首页轮播广告');
        $positionConf[] = array('id' => 1, 'name' => '首页普通广告');
        $positionConf[] = array('id' => 11, 'name' => '新品尝鲜');
        $positionConf[] = array('id' => 12, 'name' => '每日特惠');
        $positionConf[] = array('id' => 14, 'name' => '热门推荐');
        $positionConf[] = array('id' => 15, 'name' => '每日抢鲜');
        $positionConf[] = array('id' => 16, 'name' => '复合广告');
        $positionConf[] = array('id' => 17, 'name' => '搜索页广告');

        $typeConf = array();
        $typeConf[] = array('id' => 1, 'name' => '专题');
        $typeConf[] = array('id' => 2, 'name' => '详情');
        $typeConf[] = array('id' => 4, 'name' => '抢购');
        $typeConf[] = array('id' => 5, 'name' => '广告单页');
        $typeConf[] = array('id' => 6, 'name' => '链接');
        $typeConf[] = array('id' => 7, 'name' => '抢购列表');
        $typeConf[] = array('id' => 9, 'name' => '线下入口');
        $typeConf[] = array('id' => 20, 'name' => '团购');

        $this->assign('position_conf', $positionConf);
        $this->assign('type_conf', $typeConf);
        $this->display();
    }

    public function edit(){
        $id = I('id', 0);
        $item = array();
        if($id > 0){
            $appbannerM = M('appbanner');
            $item = $appbannerM->where('id = ' . $id)->find();
            $item['send_region'] = implode(',', unserialize($item['send_region']));
        }
        $this->assign('banner', $item);
        $positionConf = array();
        $positionConf[] = array('id' => 0, 'name' => '首页轮播广告');
        $positionConf[] = array('id' => 1, 'name' => '首页普通广告');
        $positionConf[] = array('id' => 11, 'name' => '新品尝鲜');
        $positionConf[] = array('id' => 12, 'name' => '每日特惠');
        $positionConf[] = array('id' => 14, 'name' => '热门推荐');
        $positionConf[] = array('id' => 15, 'name' => '每日抢鲜');
        $positionConf[] = array('id' => 16, 'name' => '复合广告');
        $positionConf[] = array('id' => 17, 'name' => '搜索页广告');

        $typeConf = array();
        $typeConf[] = array('id' => 1, 'name' => '专题');
        $typeConf[] = array('id' => 2, 'name' => '详情');
        $typeConf[] = array('id' => 4, 'name' => '抢购');
        $typeConf[] = array('id' => 5, 'name' => '广告单页');
        $typeConf[] = array('id' => 6, 'name' => '链接');
        $typeConf[] = array('id' => 7, 'name' => '抢购列表');
        $typeConf[] = array('id' => 9, 'name' => '线下入口');
        $typeConf[] = array('id' => 20, 'name' => '团购');

        $this->assign('position_conf', $positionConf);
        $this->assign('type_conf', $typeConf);

        $this->display();
    }

    public function save(){
        $position = I('position', 0);
        $type = I('type', 0);
        $groupbuyingtml_id = I('groupbuyingtml_id', 0);
        $panicbuying_id = I('panicbuying_id', 0);
        $target_id = I('target_id', 0);
        $title = I('title', '');
        $page_url = I('page_url', '');
        $photo = I('photo', '');
        $sort = I('sort', 0);
        $is_top = I('is_top', 0);
        $is_show = I('is_show', 0);
        $send_region = I('send_region', '');
        $description = I('description', '');

        $id = I('id', 0);

        $appbannerM = M('appbanner');
        $data = array();
        $data['position'] = $position;
        $data['title'] = $title;
        $data['type'] = $type;
        $data['target_id'] = $target_id;
        $data['photo'] = $photo;
        $data['sort'] = $sort;
        $data['time'] = date('Y-m-d H:i:s', time());
        $data['is_show'] = $is_show;
        $data['send_region'] = serialize(explode(',', $send_region));
        $data['page_url'] = $page_url;
        $data['is_top'] = $is_top;
        $data['panicbuying_id'] = $panicbuying_id;
        $data['groupbuyingtml_id'] = $groupbuyingtml_id;
        $data['description'] =$description;

        if($this->checkBannerType($data)){
            if($id > 0){
                $appbannerM->where('id = ' . $id)->save($data);
            } else {
                $appbannerM->add($data);
            }

        }

        redirect('/index.php?s=/Appbanner/index');
    }

    public function del(){
        $id = I('id', 0);
        if($id > 0){
            $appbannerM = M('appbanner');
            $appbannerM->where('id = ' . $id)->delete();
        }

        redirect('/index.php?s=/Appbanner/index');
    }

    private function checkBannerType(&$data){
        switch(intval($data['type'])){
            case 4:
                //抢购
                if(!($data['panicbuying_id'] > 0)){
                    $data['groupbuyingtml_id'] = 0;
                    $data['target_id'] = 0;
                    return false;
                }
                break;

            case 20:
                //团购
                if(!($data['groupbuyingtml_id'] > 0)){
                    $data['panicbuying_id'] = 0;
                    $data['target_id'] = 0;
                    return false;
                }
                break;

            default:
                $data['panicbuying_id'] = 0;
                $data['groupbuyingtml_id'] = 0;
                break;
        }

        return  true;
    }

    /**
     *  选择关联的优惠券模板
     */
    public function selectJson(){
        $where = array();

        $couponTmlM = M('coupon_tml');
        $count = $couponTmlM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $couponTmlM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        if(!empty($list)){
            foreach($list as $key => $item){
                $list[$key]['isgroupbuy_only'] = 1 == $item['isgroupbuy_only'] ? '<span class="red">是</span>' : '<span class="green">否</span>';
                $list[$key]['coupon_type'] = 1 == $item['coupon_type'] ? '<span class="red">团购</span>' : '<span class="green">普通</span>';
                $list[$key]['use_target'] = 1 == $item['use_target'] ? '<span class="red">团长</span>' : '<span class="green">不限</span>';

            }
        }

        $result  = array('data' => $list, 'key' => array('id', 'money', 'description', 'lifetime'), 'th'=>array('id', '金额(元)', '描述', '有效期(天)'), 'page' => $strPage);
        echo json_encode($result);
    }

    /**
     *  更新某些字段信息
     */
    public function upInfo(){
        $id = I('id', 0);
        $key = I('key', '');
        $value = I('value', '');
        if($id > 0 && !empty($key)){
            $returnData = '';
            $where['id'] = array('eq', $id);
            $data = array();

            if((strlen($value) > 0)){
                $data[$key] = $value;
                $returnData = $value;
            } else {
                $item = $this->model->where($where)->find();
                if(!empty($item)){
                    $data[$key] = $item[$key] == 0 ? 1 : 0;
                    $returnData = $item[$key] == 0 ? '<span class="red">是</span>' : '<span class="green">否</span>';
                }
            }

            $saveResult = $this->model->where($where)->save($data);
            if($saveResult != false && $saveResult > 0){
                $this->result['status'] = 1;
                $this->result['data'] = $returnData;
                $this->result['msg'] = '更新成功';
            }
        }

        if(!(isset($this->result['status']) && $this->result['status']  == 1)){
            $this->result['status'] = 0;
            $this->result['msg'] = '更新失败';
        }

        echo json_encode($this->result);
    }
} 