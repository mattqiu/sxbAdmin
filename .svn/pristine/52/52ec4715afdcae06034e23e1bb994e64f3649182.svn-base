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
 *  减价管理
 * Class BargainActivityTmlAction
 */
class BargainActivityTmlAction extends CommonAction{

    /**
     *  所有模板
     */
    public function index(){

        $where = array();
        $where['distributor_id'] = array('eq', '0');

        $BActivityTmlM = M('bargain_activity_tml');
        $count = $BActivityTmlM->where($where)->count();
        $page = new Page($count);
        $strPage = $page->show();
        $list = $BActivityTmlM->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();

        if(!empty($list))
        {
            $array_tml_ids = array_column($list,"groupbuy_tml_id");

            $where_groupbuy = array();
            $where_groupbuy['id'] = array('in',$array_tml_ids);

            $groupBuyingTmlM = new GroupbuyingTmlModel();
            $groupbuytml_list = $groupBuyingTmlM->where($where_groupbuy)->relation(true)
                ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();

            $groupbuytml_map = array();
            foreach($groupbuytml_list as $groupbuyTmlkey => $groupbuyTmlitem){
                $groupbuytml_map[$groupbuyTmlitem['id']] = $groupbuyTmlitem;
            }

            foreach($list as $key => $item){
                $item['groupbuy_tml'] = $groupbuytml_map[$item['groupbuy_tml_id']];
                $list[$key] = $item;
            }
        }

        $this->assign('list',  $list);

        $this->assign('page', $strPage);
        $this->display();
    }

    /**
     *  新建一个团购模板
     */
    public function add(){
        $this->display('add');
    }

    /**
     *  保存模板
     */
    public function save(){
        $id = I('id', 0);
        $groupbuy_tml_id = I('groupbuytml_id', 0);
        $dec_sale_type = I('dec_sale_type', 0);
        $sale_min = I('sale_min', 0);
        $sale_max = I('sale_max', 0);
        $begin_price = I('begin_price', 0);
        $min_price = I('min_price', 0);
        $req_min_partake_num = I('req_min_partake_num', 0);
        $special_mission_tml_data = I('special_mission_tml_data', '');//json
        $activity_title = I('activity_title', '');
        $activity_can_choose_share_title = I('activity_can_choose_share_title', '');//json
        $activity_can_choose_share_icon = I('activity_can_choose_share_icon', '');//json

        $activity_bg_url = I('activity_bg_url', '');
        $first_people_left_icon_url = I('first_people_left_icon_url', '');
        $first_people_right_icon_url = I('first_people_right_icon_url', '');
        $second_people_left_icon_url = I('second_people_left_icon_url', '');
        $second_people_right_icon_url = I('second_people_right_icon_url', '');
        $third_people_left_icon_url = I('third_people_left_icon_url', '');
        $third_people_right_icon_url = I('third_people_right_icon_url','');

        //前几位背景色
        $front_background_color = array();

        $first_people_r = I('first_people_r','');
        $first_people_g = I('first_people_g','');
        $first_people_b = I('first_people_b','');
        $first_color_data = array();
        $first_color_data[] = $first_people_r;
        $first_color_data[] = $first_people_g;
        $first_color_data[] = $first_people_b;
        $front_background_color[] = $first_color_data;

        $second_people_r = I('second_people_r','');
        $second_people_g = I('second_people_g','');
        $second_people_b = I('second_people_b','');
        $second_color_data = array();
        $second_color_data[] = $second_people_r;
        $second_color_data[] = $second_people_g;
        $second_color_data[] = $second_people_b;
        $front_background_color[] = $second_color_data;

        $third_people_r = I('third_people_r','');
        $third_people_g = I('third_people_g','');
        $third_people_b = I('third_people_b','');
        $third_color_data = array();
        $third_color_data[] = $third_people_r;
        $third_color_data[] = $third_people_g;
        $third_color_data[] = $third_people_b;
        $front_background_color[] = $third_color_data;

        $other_people_r = I('other_people_r','');
        $other_people_g = I('other_people_g','');
        $other_people_b = I('other_people_b','');
        $other_color_data = array();
        $other_color_data[] = $other_people_r;
        $other_color_data[] = $other_people_g;
        $other_color_data[] = $other_people_b;
        $front_background_color[] = $other_color_data;

        $list_people_r = I('list_people_r','');
        $list_people_g = I('list_people_g','');
        $list_people_b = I('list_people_b','');
        $list_color_data = array();
        $list_color_data[] = $list_people_r;
        $list_color_data[] = $list_people_g;
        $list_color_data[] = $list_people_b;
        $front_background_color[] = $list_color_data;

        //-----------
        $advert_img_url = I('advert_img_url','');
        $leader_title = I('leader_title','');

        $pruduct_desc_text = I('pruduct_desc_text','');
        $rgb_pruduct_desc_text_bg = array();
        $rgb_pruduct_desc_text_bg[] = I('pruduct_desc_text_bg_r','');
        $rgb_pruduct_desc_text_bg[] = I('pruduct_desc_text_bg_g','');
        $rgb_pruduct_desc_text_bg[] = I('pruduct_desc_text_bg_b','');
        $rgb_pruduct_desc_text = array();
        $rgb_pruduct_desc_text[] = I('pruduct_desc_text_r','');
        $rgb_pruduct_desc_text[] = I('pruduct_desc_text_g','');
        $rgb_pruduct_desc_text[] = I('pruduct_desc_text_b','');

        $front_p_list_bg_url = I('front_p_list_bg_url','');
        $front_p_list_text = I('front_p_list_text','');


        $front_rule_bg_url = I('front_rule_bg_url','');
        $front_rule_text = I('front_rule_text','');

        $mid_price = I('mid_price',0);
        $unit_type = I('unit_type',0);
        $sale_min1 = I('sale_min1',0);
        $sale_max1 = I('sale_max1',0);
        $unit_price = I('unit_price',0);

        $rgb_rule_text_bg = array();
        $rgb_rule_text_bg[] = I('rule_text_bg_r','');
        $rgb_rule_text_bg[] = I('rule_text_bg_g','');
        $rgb_rule_text_bg[] = I('rule_text_bg_b','');

        //$rule_text = I('rule_text','');
        $rule_text_array = $_REQUEST['rule_text_array'];

        $rgb_rule_text = array();
        $rgb_rule_text[] = I('rule_text_r','');
        $rgb_rule_text[] = I('rule_text_g','');
        $rgb_rule_text[] = I('rule_text_b','');

        $is_have_special_mission = I('is_have_special_mission', 0);
        $mission_tml_data = array();
        if($is_have_special_mission != 0)
        {
            $mission_type_array = $_REQUEST['mission_type_array'];
            $mission_value_array = $_REQUEST['mission_value_array'];
            $mission_limit_time_array = $_REQUEST['mission_limit_time_array'];
            $mission_dec_money_array = $_REQUEST['mission_dec_money_array'];
            $mission_trigger_array = $_REQUEST['mission_trigger_array'];

            foreach($mission_type_array as $key => $item){
                if(empty($item))
                    continue;
                $one_line_mission_tml_data = array();
                $one_line_mission_tml_data['type'] = $item;
                $one_line_mission_tml_data['value'] = $mission_value_array[$key];
                $one_line_mission_tml_data['limit_time'] = $mission_limit_time_array[$key];
                $one_line_mission_tml_data['dec_money'] = $mission_dec_money_array[$key];
                $one_line_mission_tml_data['trigger'] = $mission_trigger_array[$key];

                $mission_tml_data[] = $one_line_mission_tml_data;
            }
        }


        if($groupbuy_tml_id > 0 && !empty($activity_title)){

            $data = array();
            $data['groupbuy_tml_id'] = $groupbuy_tml_id;
            $data['dec_sale_type'] = $dec_sale_type;
            $data['sale_min'] = $sale_min;
            $data['sale_max'] = $sale_max;
            $data['begin_price'] = $begin_price;
            $data['min_price'] = $min_price;
            $data['req_min_partake_num'] = $req_min_partake_num;
            $data['special_mission_tml_data'] = $special_mission_tml_data;//json
            $data['activity_title'] = $activity_title;
            $data['activity_can_choose_share_title'] = $activity_can_choose_share_title;//json
            $data['activity_can_choose_share_icon'] = $activity_can_choose_share_icon;//json

            $data['activity_bg_url'] = $activity_bg_url;
            $data['first_people_left_icon_url'] = $first_people_left_icon_url;
            $data['first_people_right_icon_url'] = $first_people_right_icon_url;
            $data['second_people_left_icon_url'] = $second_people_left_icon_url;
            $data['second_people_right_icon_url'] = $second_people_right_icon_url;
            $data['third_people_left_icon_url'] = $third_people_left_icon_url;
            $data['third_people_right_icon_url'] = $third_people_right_icon_url;

            $data['front_background_color'] = json_encode($front_background_color);

            $data['advert_img_url'] = $advert_img_url;
            $data['leader_title'] = $leader_title;
            $data['pruduct_desc_text'] = $pruduct_desc_text;
            $data['rgb_pruduct_desc_text_bg'] = json_encode($rgb_pruduct_desc_text_bg);
            $data['rgb_pruduct_desc_text'] = json_encode($rgb_pruduct_desc_text);
            $data['front_p_list_bg_url'] = $front_p_list_bg_url;
            $data['front_p_list_text'] = $front_p_list_text;
            $data['front_rule_bg_url'] = $front_rule_bg_url;
            $data['front_rule_text'] = $front_rule_text;
            $data['rgb_rule_text_bg'] = json_encode($rgb_rule_text_bg);
            $data['rule_text'] = json_encode($rule_text_array);
            $data['rgb_rule_text'] = json_encode($rgb_rule_text);

            $data['mid_price'] = $mid_price;
            $data['unit_type'] = $unit_type;
            $data['sale_min1'] = $sale_min1;
            $data['sale_max1'] = $sale_max1;
            $data['unit_price'] = $unit_price;

            $data['is_have_special_mission'] = $is_have_special_mission;
            if($is_have_special_mission != 0)
            {
                $data['special_mission_tml_data'] = json_encode($mission_tml_data);
            }

            $bargain_activity_TmlM = M('bargain_activity_tml');
            if($id> 0){
                $bargain_activity_TmlM->where('id = ' . $id)->save($data);
            } else {
                $bargain_activity_TmlM->add($data);
            }

            $this->success('操作成功', U('BargainActivityTml/index'));
        } else {
            $this->error('参数出错请重试', U('BargainActivityTml/index'));
        }
//        redirect(U('GroupBuyingTml/index'));
    }

    public function edit(){
        $id = I('id', 0);
        $bargain_activity_tmlM = M('bargain_activity_tml');
        $item = $bargain_activity_tmlM->where('id =' . $id)->find();

        $rgb_pruduct_desc_text_bg = json_decode($item['rgb_pruduct_desc_text_bg'],true);
        $item['pruduct_desc_text_bg_r'] = $rgb_pruduct_desc_text_bg[0];
        $item['pruduct_desc_text_bg_g'] = $rgb_pruduct_desc_text_bg[1];
        $item['pruduct_desc_text_bg_b'] = $rgb_pruduct_desc_text_bg[2];

        $rgb_pruduct_desc_text = json_decode($item['rgb_pruduct_desc_text'],true);
        $item['pruduct_desc_text_r'] = $rgb_pruduct_desc_text[0];
        $item['pruduct_desc_text_g'] = $rgb_pruduct_desc_text[1];
        $item['pruduct_desc_text_b'] = $rgb_pruduct_desc_text[2];

        $rgb_rule_text_bg = json_decode($item['rgb_rule_text_bg'],true);
        $item['rule_text_bg_r'] = $rgb_rule_text_bg[0];
        $item['rule_text_bg_g'] = $rgb_rule_text_bg[1];
        $item['rule_text_bg_b'] = $rgb_rule_text_bg[2];
        $rgb_rule_text = json_decode($item['rgb_rule_text'],true);
        $item['rule_text_r'] = $rgb_rule_text[0];
        $item['rule_text_g'] = $rgb_rule_text[1];
        $item['rule_text_b'] = $rgb_rule_text[2];

        $front_background_color = json_decode($item['front_background_color'],true);

        $this->assign('first_people_r',$front_background_color[0][0]);
        $this->assign('first_people_g',$front_background_color[0][1]);
        $this->assign('first_people_b',$front_background_color[0][2]);

        $this->assign('second_people_r',$front_background_color[1][0]);
        $this->assign('second_people_g',$front_background_color[1][1]);
        $this->assign('second_people_b',$front_background_color[1][2]);

        $this->assign('third_people_r',$front_background_color[2][0]);
        $this->assign('third_people_g',$front_background_color[2][1]);
        $this->assign('third_people_b',$front_background_color[2][2]);

        $this->assign('other_people_r',$front_background_color[3][0]);
        $this->assign('other_people_g',$front_background_color[3][1]);
        $this->assign('other_people_b',$front_background_color[3][2]);

        $this->assign('list_people_r',$front_background_color[4][0]);
        $this->assign('list_people_g',$front_background_color[4][1]);
        $this->assign('list_people_b',$front_background_color[4][2]);

        $item['rule_text'] = json_decode($item['rule_text'],true);
        $item['special_mission_tml_data'] = json_decode($item['special_mission_tml_data'],true);

        $this->assign('rule_text_count', count($item['rule_text']));
        $this->assign('mission_count', count($item['special_mission_tml_data']));
        $this->assign('item', $item);
        $this->display();
    }

    public function del(){
        $id = I('id', 0);
        if($id > 0){
            $groupbuyingTmlM = M('groupbuying_tml');
            $groupbuyingTmlM->where('id = ' . $id)->delete();
        }
        redirect(U('GroupBuyingTml/index'));
    }

    public function selectJson(){
        $where = '';
        $groupBuyingTmlM = new GroupbuyingTmlModel();
        $count = $groupBuyingTmlM->where($where)->count();
        $page = new Page($count, 10);
        $strPage = $page->show();
        $list = $groupBuyingTmlM->where($where)->relation(true)
            ->limit($page->firstRow . ',' . $page->listRows)->order('id DESC')->select();

        if(!empty($list)){
            $groupBuyingConf = C('GROUP_BUYING');
            foreach($list as $key => $item){
                $list[$key]['condition_type'] = $groupBuyingConf['condition_type'][$item['condition_type']];
                $list[$key]['state'] = $groupBuyingConf['groupbuying_tml_state'][$item['state']];
            }
        }

        $result  = array('data' => $list, 'key' => array('id', 'groupbuying_name'), 'th'=>array('id', '团购名'), 'page' => $strPage);
        echo json_encode($result);
    }

    /*public function clear_userlimit()
    {
        $id = I('id', 0);
        if($id == 0)
        {
            echo '错误的操作';
            return;
        }

        $action_limitM = M('user_action_limit_record');

        $where = 'type like "partake_groupbuy" and value like "'.$id.'"';
        $res = $action_limitM->where($where)->delete();
        if($res>0)
        {
            echo '清除成功';
        }
        else
        {
            echo '没有可清除的数据';
        }

    }

    public function clear_succ_userlimit()
    {
        $id = I('id', 0);
        if($id == 0)
        {
            echo '错误的操作';
            return;
        }

        $groupbuy_limitM = M('user_groupbuy_limit_buy_record');

        $where = 'groupbuy_tml_id = '.$id;
        $res = $groupbuy_limitM->where($where)->delete();
        if($res>0)
        {
            echo '清除成功';
        }
        else
        {
            echo '没有可清除的数据';
        }


    }*/
} 