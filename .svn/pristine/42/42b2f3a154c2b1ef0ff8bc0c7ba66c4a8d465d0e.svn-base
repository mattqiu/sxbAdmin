<?php
/**
 * 膹偶藵膹偶藵脻卤膹偶藵膹偶藵膹偶藵茅偶麓
 */
class DataReportAction extends CommonAction{
    const PAGE_NUM = 150;
    /*
     *膹偶藵膫禄膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶?
     * */
    public function index(){
        $site = I('site');
        $time = I('limit_date_From');
        if(!empty($time)){
            $time_From = I('limit_date_From').' '.I('limit_time_From');
            $time_To = I('limit_date_To').' '.I('limit_time_To');
        }

        $distributor = M('distributor');
        $did =$distributor->field('distributor_id')->where("name = 'jiashan'")->find();
//        echo $distributor->getLastSql();
        $wheres = "(o.uid = u.id) and (o.operation_id = 2 or o.operation_id = 3 or o.operation_id = 6 or o.operation_id = 9 or o.operation_id = 10)";
        if($site == '1'){
            $where= array();
            $where['fie_id'] = array('eq', '');
            $where['fie_id'] = array('in', '');
            $where = "distributor_id = '{$did['distributor_id']}'";
            $wheres= "(o.uid = u.id) and (o.distributor_id = '{$did['distributor_id']}') and (o.operation_id = 2 or o.operation_id = 3 or o.operation_id = 6 or o.operation_id = 9 or o.operation_id = 10)";
        }
        if($time_From && $time_To){
           $wheres = "(o.uid = u.id) and (o.time>='{$time_From}') and (o.time<='{$time_To}') and (o.operation_id = 2 or o.operation_id = 3 or o.operation_id = 6 or o.operation_id = 9 or o.operation_id = 10)";
        }
        if($time_From && $time_To && $site ){
            $where = "distributor_id = '{$did['distributor_id']}'";
            $wheres = "(o.uid = u.id) and (o.distributor_id = '{$did['distributor_id']}') and (o.time>='{$time_From}') and (o.time<='{$time_To}') and (o.operation_id = 2 or o.operation_id = 3 or o.operation_id = 6 or o.operation_id = 9 or o.operation_id = 10)";
        }


        $model = M('user');
        $count_user = $model->field('count(id) cid')->where($where)->find();

        $where['mobile_status'] = array('eq', 1);
        $countMobile = $model->where($where)->count();
//        echo $model->getLastSql();
        $user_mobile = round($countMobile/$count_user['cid']*100,2).'%';

        $m = M();
        $data = $m->table('ttgy_user u,ttgy_order o')->field('u.username,sum(o.money) sm,u.id')->where($wheres)->group('u.id')->select();
        $result = $m->table('ttgy_user u,ttgy_order o')->field('u.username,count(o.id) con,u.id')->where($wheres)->group('u.id')->select();
        $orders = array();
        foreach($result as $key=>$val){
           $orders[] = $result[$key]['id'];
        }
        $code = count($orders);
        $user_orders = round($code/$count_user['cid']*100,2).'%';

        $page = new Page(count($data),self::PAGE_NUM);
        $pages = new Page(count($result),self::PAGE_NUM);
        $show = $page->show();
        $shows = $pages->show();
        $money_list = $m->table('ttgy_user u,ttgy_order o')->field('u.username,sum(o.money) sm,u.id,u.mobile')->where($wheres)->group('u.id')->order('sm desc')->limit($page->firstRow, $page->listRows)->select();
//        echo $m->getLastSql().'<br>';
        $order_list = $m->table('ttgy_user u,ttgy_order o')->field('u.username,count(o.id) con,u.id,u.mobile')->where($wheres)->group('u.id')->order('con desc')->limit($page->firstRow, $page->listRows)->select();
//        echo $m->getLastSql();
        $this->assign('code',$code);
        $this->assign('cmb',$countMobile);
        $this->assign('user_orders',$user_orders);
        $this->assign('user_mobile',$user_mobile);
        $this->assign('count_user',$count_user);
        $this->assign('lists',$order_list);
        $this->assign('list',$money_list);
        $this->assign('pages',$shows);
        $this->assign('page',$show);
        $this->assign('post',$_POST);
        $this->display();
    }

    /*
     * 膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶?
     * **/
    public function order(){
        $time = I('limit_date_From');
        if(!empty($time)){
            $time_From = I('limit_date_From').' '.I('limit_time_From');
            $time_To = I('limit_date_To').' '.I('limit_time_To');
        }
        $prov = I('prov');
        $city = I('city');
        $area = I('area');
        $site = I('site');
        $distributor = M('distributor');
        $did = $distributor->field('distributor_id')->where("name = 'jiashan'")->find();
        if(empty($_POST) || $site == '1' ){
            $where = "(operation_id = 2 or operation_id = 3 or operation_id = 9) and (o.id = oa.order_id)";
        }
        if($site == '2'){
            $where = "(operation_id = 2 or operation_id = 3 or operation_id = 9) and (o.id = oa.order_id) and (distributor_id = '{$did['distributor_id']}')";
        }
        if($time_From && $time_To && $site == '1'){
            $where = "(operation_id = 2 or operation_id = 3 or operation_id = 9) and (o.id = oa.order_id) and ('$time_From' <= o.time )and('$time_To'>=o.time)";
        }
        if($time_To && $time_From && $site == '2'){
            $where = "(operation_id = 2 or operation_id = 3 or operation_id = 9) and (o.id = oa.order_id) and (distributor_id = '{$did['distributor_id']}') and('$time_From' <= o.time )and('$time_To'>=o.time)";
        }
        if($prov && $city && $area){
            $where = "(operation_id = 2 or operation_id = 3 or operation_id = 9) and (o.id = oa.order_id) and (oa.province = '$prov' and oa.area = '$area' and oa.city = '$city')";
        }

//dump($_POST);
        $m = M();
        $totle = $m->table('ttgy_order o,ttgy_order_address oa')->field('count(o.id) totle,sum(o.money) money')->where($where)->find();
//        echo $m->getLastSql();
        $avg = round($totle['money']/$totle['totle'],2);
        $this->assign('avg',$avg);
        $this->assign('totle',$totle);
        $this->assign('post',$_POST);
        $this->display();
    }

    /*
     * 商品销量
     * */
    public function volume(){
        $sendWarehomeM = M('send_warehome');
        $sendList = $sendWarehomeM->select();
        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));        //今天的开始时间
        $nowToday = date('Y-m-d H:i:s',$beginToday);

        $tmpJdOrderM = M('tmp_jd_order');
        $send = I('send');
        $time = I('limit_date_From');
        if($time){
            $y = substr($time,0,4);
            $m = substr($time,5,2);
            $d = substr($time,8,2);
        }else{
            $y = 'y';
            $m = 'm';
            $d = 'd';
        }
        if($send == '1'){
            unset($send);
        }
        //前15天的 开始时间与结束时间
        $oneb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-1,date($y)));
        $onee = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d),date($y))-1);
        $twob = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-2,date($y)));
        $twoe = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-1,date($y))-2);
        $threeb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-3,date($y)));
        $threee = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-2,date($y))-3);
        $fourb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-4,date($y)));
        $foure = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-3,date($y))-4);
        $fiveb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-5,date($y)));
        $fivee = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-4,date($y))-5);
        $sixb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-6,date($y)));
        $sixe = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-5,date($y))-6);
        $sevenb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-15,date($y)));
        $eightb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-7,date($y)));
        $eighte = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-6,date($y))-7);
        $nineb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-8,date($y)));
        $ninee = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-7,date($y))-8);
        $tenb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-9,date($y)));
        $tene = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-8,date($y))-9);
        $elevenb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-10,date($y)));
        $elevene = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-9,date($y))-10);
        $twelveb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-11,date($y)));
        $twelvee = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-10,date($y))-11);
        $thirteenb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-12,date($y)));
        $thirteene = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-11,date($y))-12);
        $fourteenb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-13,date($y)));
        $fourteene = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-12,date($y))-13);
        $fifteenb = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-14,date($y)));
        $fifteene = date('Y-m-d H:i:s',mktime(0,0,0,date($m),date($d)-13,date($y))-14);
        $nowTime = date('Y-m-d H:i:s');
        //时间数组
        $week = array($nowToday,$oneb,$twob,$threeb,$fourb,$fiveb,$sixb,$eightb,$nineb,$tenb,$elevenb,$twelveb,$thirteenb,$fourteenb,$fifteenb,$sevenb,);

        //默认的15天时间的 where条件
        $whereOne['add_time'] = array( array('egt',$oneb) , array('elt',$onee) );
        $whereTwo['add_time'] = array( array('egt',$twob) , array('elt',$twoe) );
        $whereThree['add_time'] = array( array('egt',$threeb) , array('elt',$threee) );
        $whereFour['add_time'] = array( array('egt',$fourb) , array('elt',$foure) );
        $whereFive['add_time'] = array( array('egt',$fiveb) , array('elt',$fivee) );
        $whereSix['add_time'] = array( array('egt',$sixb) , array('elt',$sixe) );
        $whereEight['add_time'] = array( array('egt',$eightb) , array('elt',$eighte) );
        $whereNine['add_time'] = array( array('egt',$nineb) , array('elt',$ninee) );
        $whereTen['add_time'] = array( array('egt',$tenb) , array('elt',$tene) );
        $whereEleven['add_time'] = array( array('egt',$elevenb) , array('elt',$elevene) );
        $whereTwelve['add_time'] = array( array('egt',$twelveb) , array('elt',$twelvee) );
        $whereThirteen['add_time'] = array( array('egt',$thirteenb) , array('elt',$thirteene) );
        $whereFourteen['add_time'] = array( array('egt',$fourteenb) , array('elt',$fourteene) );
        $whereFifteen['add_time'] = array( array('egt',$fifteenb) , array('elt',$fifteene) );

        $whereNow['add_time'] = array( array('egt',$nowToday) , array('elt',$nowTime) );
        if( empty($send) && empty($time)){
            $whereSeven['add_time'] = array( array('egt',$sevenb) , array('elt',$nowTime) );
        }

        if($send && $send != 1){
            $whereOne['send_warehome_id'] = array('eq',$send);
            $whereTwo['send_warehome_id'] = array('eq',$send);
            $whereThree['send_warehome_id'] = array('eq',$send);
            $whereFour['send_warehome_id'] = array('eq',$send);
            $whereFive['send_warehome_id'] = array('eq',$send);
            $whereSix['send_warehome_id'] = array('eq',$send);
            $whereSeven['send_warehome_id'] = array('eq',$send);
            $whereEight['send_warehome_id'] = array('eq',$send);
            $whereNine['send_warehome_id'] = array('eq',$send);
            $whereTen['send_warehome_id'] = array('eq',$send);
            $whereEleven['send_warehome_id'] = array('eq',$send);
            $whereTwelve['send_warehome_id'] = array('eq',$send);
            $whereThirteen['send_warehome_id'] = array('eq',$send);
            $whereFourteen['send_warehome_id'] = array('eq',$send);
            $whereFifteen['send_warehome_id'] = array('eq',$send);
            $whereNow['send_warehome_id'] = array('eq',$send);
            $whereSeven['add_time'] = array( array('egt',$sevenb) , array('elt',$nowTime) );
        }

        $result1 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereNow)->order('total desc')->group('product_id')->select();     //今天的
        $result7 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereOne)->order('total desc')->group('product_id')->select();     //昨天的
        $result2 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereTwo)->order('total desc')->group('product_id')->select();     //前天的
        $result3 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereThree)->order('total desc')->group('product_id')->select();   //前3天
        $result4 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereFour)->order('total desc')->group('product_id')->select();    //前4天
        $result5 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereFive)->order('total desc')->group('product_id')->select();    //前5天
        $result6 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereSix)->order('total desc')->group('product_id')->select();     //前6天
        $result8 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereSeven)->order('total desc')->group('product_id')->select();     //前15天一共的
        $result9 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereEight)->order('total desc')->group('product_id')->select();     //前8天
        $result10 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereNine)->order('total desc')->group('product_id')->select();     //前9天
        $result11 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereTen)->order('total desc')->group('product_id')->select();     //前10天
        $result12 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereEleven)->order('total desc')->group('product_id')->select();     //前11天
        $result13 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereTwelve)->order('total desc')->group('product_id')->select();     //前12天
        $result14 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereThirteen)->order('total desc')->group('product_id')->select();     //前13天
        $result15 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereFourteen)->order('total desc')->group('product_id')->select();     //前14天
        $result16 = $tmpJdOrderM->field('product_id,product_name,count(id) as total')->where($whereFifteen)->order('total desc')->group('product_id')->select();     //前15天

        foreach($result8 as $k=>$v){
            $list[md5($result8[$k]['product_id'])] = array(
                    'product_id' => $result8[$k]['product_id'],
                    'product_name' => $result8[$k]['product_name'],
                    'total' => $result8[$k]['total'],
                );
        }
        foreach($result1 as $key=>$val){
            $list[md5($result1[$key]['product_id'])]['one'] = $result1[$key]['total'];
        }
        foreach($result2 as $key=>$val){
            $list[md5($result2[$key]['product_id'])]['two'] = $result2[$key]['total'];
        }
        foreach($result3 as $key=>$val){
            $list[md5($result3[$key]['product_id'])]['three'] = $result3[$key]['total'];
        }
        foreach($result4 as $key=>$val){
            $list[md5($result4[$key]['product_id'])]['four'] = $result4[$key]['total'];
        }
        foreach($result5 as $key=>$val){
            $list[md5($result5[$key]['product_id'])]['five'] = $result5[$key]['total'];
        }
        foreach($result6 as $key=>$val){
            $list[md5($result6[$key]['product_id'])]['six'] = $result6[$key]['total'];
        }
        foreach($result7 as $key=>$val){
            $list[md5($result7[$key]['product_id'])]['seven'] = $result7[$key]['total'];
        }
        foreach($result9 as $key=>$val){
            $list[md5($result9[$key]['product_id'])]['eight'] = $result9[$key]['total'];
        }
        foreach($result10 as $key=>$val){
            $list[md5($result10[$key]['product_id'])]['nine'] = $result10[$key]['total'];
        }
        foreach($result11 as $key=>$val){
            $list[md5($result11[$key]['product_id'])]['ten'] = $result11[$key]['total'];
        }
        foreach($result12 as $key=>$val){
            $list[md5($result12[$key]['product_id'])]['eleven'] = $result12[$key]['total'];
        }
        foreach($result13 as $key=>$val){
            $list[md5($result13[$key]['product_id'])]['twelve'] = $result13[$key]['total'];
        }
        foreach($result14 as $key=>$val){
            $list[md5($result14[$key]['product_id'])]['thirteen'] = $result14[$key]['total'];
        }
        foreach($result15 as $key=>$val){
            $list[md5($result15[$key]['product_id'])]['fourteen'] = $result15[$key]['total'];
        }
        foreach($result16 as $key=>$val){
            $list[md5($result16[$key]['product_id'])]['fifteen'] = $result16[$key]['total'];
        }

        //计算每天的商品销量
        foreach($list as $k=>$v){
            $total[] = $list[$k]['total'];
            $one[] = $list[$k]['one'];
            $two[] = $list[$k]['two'];
            $three[] = $list[$k]['three'];
            $four[] = $list[$k]['four'];
            $five[] = $list[$k]['five'];
            $six[] = $list[$k]['six'];
            $seven[] = $list[$k]['seven'];
            $eight[] = $list[$k]['eight'];
            $nine[] = $list[$k]['nine'];
            $ten[] = $list[$k]['ten'];
            $eleven[] = $list[$k]['eleven'];
            $twelve[] = $list[$k]['twelve'];
            $thirteen[] = $list[$k]['thirteen'];
            $fourteen[] = $list[$k]['fourteen'];
            $fifteen[] = $list[$k]['fifteen'];
        }
        $dayVolume = array(
            'total' => array_sum($total),
            'one' => array_sum($one),
            'two' => array_sum($two),
            'three' => array_sum($three),
            'four' => array_sum($four),
            'five' => array_sum($five),
            'six' => array_sum($six),
            'seven' => array_sum($seven),
            'eight' => array_sum($eight),
            'nine' => array_sum($nine),
            'ten' => array_sum($ten),
            'eleven' => array_sum($eleven),
            'twelve' => array_sum($twelve),
            'thirteen' => array_sum($thirteen),
            'fourteen' => array_sum($fourteen),
            'fifteen' => array_sum($fifteen),
        );
        $this->assign('week',$week);
        $this->assign('post',$_POST);
        $this->assign('send',$sendList);
        $this->assign('result',$list);
        $this->assign('dayVolume',$dayVolume);
        $this->display();
    }

    /*
     * 微信分享日志
     * */

    public function wxShareLog(){
        $groupbuyingTmlM = M('groupbuying_tml');
        $groupList = $groupbuyingTmlM->field('id,groupbuying_name')->order('id desc')->select();    //查询模板ID 名称

        $uid_nums = I('uid_nums');
        $groupId = I('groupId');
        $time = I('limit_date_From');
//        var_dump($_POST);
        if(!empty($time)){
            $time_From = I('limit_date_From').' '.I('limit_time_From');
            $time_To = I('limit_date_To').' '.I('limit_time_To');
        }
        if(!$uid_nums){
            $uid_nums = 4;
            $_POST['uid_nums'] = 4;
        }
        if($groupId == 'no'){
            unset($groupId);
        }

        $wxshareLogM = M('wxshare_log');

        $where['first_uid'] = array('neq',0);
        $group = 'first_uid';           //默认以第一次分享的用户ID为主 后每次分享它都累加
        $field = 'id,groupbuy_tml_id,order_name,first_uid,count(id) cuid,relay_num,first_uname';        //默认查询数据

        if($groupId){
            $where['groupbuy_tml_id'] = array('eq',$groupId);
        }
        if($time){
            $where['add_time'] = array( array('egt',$time_From) , array('elt',$time_To) );
        }
        if($uid_nums){
            switch($uid_nums){
                case 1:     //第一次
                    $where['relay_num'] = array('eq',1);
                    $group = 'first_uid';
                    $field = 'id,groupbuy_tml_id,order_name,first_uid,count(id) cuid,relay_num,first_uname';
                break;
                case 2:     //第二次
                    $where['relay_num'] = array('eq',2);
                    $group = 'sec_uid';
                    $field = 'id,groupbuy_tml_id,order_name,sec_uid,count(id) cuid,relay_num,sec_uname';
                    break;
                case 3:     //第三次
                    $where['relay_num'] = array('eq',3);
                    $group = 'third_uid';
                    $field = 'id,groupbuy_tml_id,order_name,third_uid,count(id) cuid,relay_num,third_uname';
                break;
                case 4:     //全部
                    $group = 'first_uid';
                    $field = 'id,groupbuy_tml_id,order_name,first_uid,count(id) cuid,relay_num,first_uname';
                break;
            }
        }
        $data = $wxshareLogM->field('id,groupbuy_tml_id,order_name,first_uid')->where($where)->group('first_uid')->select();
        $page = new Page(count($data),30);
        $show = $page->show();
        $result = $wxshareLogM->field($field)
                    ->where($where)->order('cuid desc')->group($group)
                    ->limit($page->firstRow, $page->listRows)->select();        //查询一级分享用户 并排序
//   echo $wxshareLogM->getLastSql();
        $this->assign('result',$result);
        $this->assign('page',$show);
        $this->assign('groupList',$groupList);
        $this->assign('post',$_POST);
        $this->display();
    }

    /*
     *  导出中奖用户
     * */
    public function outLuck(){
        $wxshareLuckUserM = M('wxshare_luck_user');
        $where['groupbuying_id'] = array('neq',0);
        $result = $wxshareLuckUserM->field('groupbuying_id,luck_key')->where($where)->select();
        $xlsName = date('y-m-d-His'). '_'. "中奖用户";
        $xls_cell = array(array('groupbuying_id', '团实例ID'), array('luck_key', '中奖用户'));
        $this->exportExcel($xlsName, $xls_cell, $result, '', true);
    }
    /*
     * 导入中奖用户UID至临时表
     * */
    public function addLuck(){
        $savePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        $fileFix = explode('.', $_FILES['import_file']['name']);
        $fileName = md5($_FILES['import_file']['name'] . time()) . '.' . $fileFix[1];
        $uploadFile = $savePath . $fileName;
        move_uploaded_file($_FILES['import_file']['tmp_name'], $uploadFile);
        $result = $this->importExecl($uploadFile);
        if(!empty($result['data'])){
            $wxshareLuckUserM = M('wxshare_luck_user');
            $list = 0;
            foreach($result['data'] as $key=>$val){
                if($key > 1){
                    $data = array();
                    $data['uid'] = $val['A'];
                    $list += $wxshareLuckUserM->add($data);
                }
            }
            if($list){
                echo '文件上传成功';
            }
        }
    }

    /*
     * 订单发货报表
     * */
    public function orderDeliver(){
        $distributorM = M('distributor');
        $sendM = M('send_warehome');
        $tmpJdOrderM = M('tmp_jd_order');

        $site = $distributorM->field('distributor_id,short_name')->select();
        $send = $sendM->field('id,name')->select();

        $siteId = I('site');
        $sendId = I('send');
        $time = I('limit_date_From');
        if(!empty($time)){
            $time_From = I('limit_date_From').' '.I('limit_time_From');
            $time_To = I('limit_date_To').' '.I('limit_time_To');
        }

        if($siteId){
            $where['distributor_id'] = array('eq',$siteId);
        }
        if($sendId){
            $where['send_warehome_id'] = array('eq',$sendId);
        }
        if($time_From && $time_To){
            $where['last_send_mail_time'] = array( array('egt',$time_From) , array('elt',$time_To) );
        }


        $data = $tmpJdOrderM->field('product_id,product_name,count(id) total')->where($where)->group('product_id')->select();
        $page = new Page(count($data),self::PAGE_NUM);
        $show = $page->show();
        $result = $tmpJdOrderM->field('product_id,product_name,count(id) total')->where($where)->order('total desc')->group('product_id')->select();

        $this->assign('list',$result);
        $this->assign('site',$site);
        $this->assign('send',$send);
        $this->assign('page',$show);
        $this->assign('post',$_POST);
        $this->display();
    }

    /*
     * 膹偶藵膹偶藵膯路膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶藵膹偶?
     * */
    public function goods(){
        $site = I('site');
        $sort = I('sort');
        $distributor = M('distributor');
        $did = $distributor->field('distributor_id')->where("name = 'jiashan'")->find();
        if(empty($_POST) || $site == '1' ){
            $where = "op.product_id = t.product_id and t.status not in(10,15,20)";
        }
        if($site == '2'){
            $where = "(op.product_id = t.product_id) and (distributor_id = '{$did['distributor_id']}') and t.status not in(10,15,20)";
        }
        $order = "sqty desc";
        switch($sort){
            case '1':
                $order = "op.product_id desc";
            break;
            case '2':
                $order = "op.product_id asc";
            break;
            case '3':
                $order = "sqty asc";
            break;
            case '4':
                $order = "sqty desc";
            break;
            case '5':
                $order = "stm asc";
            break;
            case '6':
                $order = "stm desc";
            break;
        }
        $m = M();
        $result = $m->table('ttgy_order_product op,ttgy_tmp_jd_order t')->field('t.product_id, t.remark,count(t.id) sqty,sum(op.total_money) stm')->where($where)->group('t.product_id')->order($order)->select();
//        echo $m->getLastSql();
        foreach($result as $key=>$val){
            $result[$key]['avg'] = round($result[$key]['stm']/ $result[$key]['sqty'],2);        //平均每单的价格
        }
        $this->assign('result',$result);
        $this->assign('post',$_POST);
        $this->display();
    }

    /*
     *团购数据报表
     *  */

    public function group(){
        $distributorM = M('distributor');
        $distributorList = $distributorM->field('short_name,distributor_id')->where('status = 1')->select();        //查询分站站点
        $sort = I('sort');
        $site = I('site');
        $groupType = I('group_type');
        $time = I('limit_date_From');

        $week = strtotime(date('Y-m-d H:i:s',strtotime('-1 week')));            //默认显示一周时间的数据
        $nowTime = time();
        if(!empty($time)){
            $time_From = strtotime(I('limit_date_From').' '.I('limit_time_From'));
            $time_To = strtotime(I('limit_date_To').' '.I('limit_time_To'));
        }
        if(empty($site)|| empty($sort) || empty($time)){
            $whereAll['state'] = array('neq',0);
            $whereOk['state'] = array('eq',2);
            $whereNo['state'] = array('in','1,3');
            $whereAll['groupbuying_begintime'] = array(array('egt',$week),array('elt',$nowTime));
            $whereOk['groupbuying_begintime'] = array(array('egt',$week),array('elt',$nowTime));
            $whereNo['groupbuying_begintime'] = array(array('egt',$week),array('elt',$nowTime));
        }
        if($site){
            $whereAll['distributor_id'] = array('eq',$site);
            $whereOk['distributor_id'] = array('eq',$site);
            $whereNo['distributor_id'] = array('eq',$site);
        }
        if($time_From && $time_To){
            $whereAll['groupbuying_begintime'] = array(array('egt',$time_From),array('elt',$time_To));
            $whereOk['groupbuying_begintime'] = array(array('egt',$time_From),array('elt',$time_To));
            $whereNo['groupbuying_begintime'] = array(array('egt',$time_From),array('elt',$time_To));
        }

        if($groupType){
            $whereAll['product_id'] = array('eq',$groupType);
            $whereOk['product_id'] = array('eq',$groupType);
            $whereNo['product_id'] = array('eq',$groupType);
        }

        $groupBuyingM = M('groupbuying');
        $groupAll = $groupBuyingM->field('count(id) total')->where($whereAll)->find();        //查询开团的数量
        $groupOk = $groupBuyingM->field('count(id) okTotal')->where($whereOk)->find();        //查询成团的数量
        $groupNo = $groupBuyingM->field('count(id) noTotal,sum(groupbuying_nownums) noPeople')->where($whereNo)->find();        //查询未成团的数量以及参与
        $peopleNo = $groupBuyingM->field('count(id) noGroupTotal,sum(groupbuying_nownums) noGroupPeople,groupbuying_name')->where($whereNo)->group('groupbuying_name')->select(); //查询未成团人数 分组
//        dump($peopleNo);echo $groupBuyingM->getLastSql();
        $groupNo['avgNoPeople'] = ceil($groupNo['noPeople'] / $groupNo['noTotal']);             //平均每团人数

        $data = $groupBuyingM->field('count(id) aid,groupbuying_name,groupbuying_reqnums')->where($whereAll)->group('groupbuying_name')->select();
        $page = new Page(count($data),self::PAGE_NUM);
        $show = $page->show();
        $list = $groupBuyingM->field('groupbuying_name,product_id,groupbuying_reqnums,count(id) total')->where($whereAll)->group('groupbuying_name')->limit($page->firstRow, $page->listRows)->select();          //查询一共开了多少团
//        echo $groupBuyingM->getLastSql().'<br/>';
        $okList = $groupBuyingM->field('groupbuying_name,product_id,groupbuying_reqnums,count(id) okTotal')->where($whereOk)->group('groupbuying_name')->limit($page->firstRow, $page->listRows)->select();   //查询以成团订单
//                echo $groupBuyingM->getLastSql().'<br/>';

        $groupList = array();
        foreach($list as $key=>$val){
            $groupList[md5($val['groupbuying_name'])] = array('groupbuying_name' => $val['groupbuying_name'] , 'product_id' => $val['product_id'],'group' => $val['total'] , 'groupbuying_reqnums' => $val['groupbuying_reqnums']);
        }
        foreach($okList as $key=>$val){
           $groupList[md5($val['groupbuying_name'])]['groupOk'] = $val['okTotal'];
           $groupList[md5($val['groupbuying_name'])]['ratio'] = round( $groupList[md5($val['groupbuying_name'])]['groupOk'] / $groupList[md5($val['groupbuying_name'])]['group'] * 100 , 2 );
        }
        foreach($peopleNo as $key=>$val){
            $groupList[md5($val['groupbuying_name'])]['noGroupPeople'] = $val['noGroupPeople'];
            $noGroupNum = $groupList[md5($val['groupbuying_name'])]['group'] - $groupList[md5($val['groupbuying_name'])]['groupOk'];
            $groupList[md5($val['groupbuying_name'])]['avgNoGroupPeople'] = ceil($groupList[md5($val['groupbuying_name'])]['noGroupPeople'] / $noGroupNum);
        }

//        dump($groupList);
        foreach($groupList as $key=>$val){
            $groupList[$key]['okPeople'] = $groupList[$key]['groupbuying_reqnums'] * $groupList[$key]['groupOk'];       //每团成团人数
            $groupList[$key]['requirePeople'] = $groupList[$key]['groupbuying_reqnums'] * $groupList[$key]['group'];        //需要人数
            $groupList[$key]['group'] = intval($groupList[$key]['group']);
            $groupList[$key]['groupbuying_reqnums'] = intval($groupList[$key]['groupbuying_reqnums']);
            $groupList[$key]['groupOk'] = empty($groupList[$key]['groupOk']) ? 0 : intval($groupList[$key]['groupOk']);
            $ratio[$key] = $val['ratio'];
            $group[$key] = $val['group'];
            $groupbuying_reqnums[$key] = $val['groupbuying_reqnums'];
        }

        foreach($groupList as $key=>$val){
            $ctsl[$key] = $val['groupOk'];
            $okPeople[$key] = $val['okPeople'];
            $angp[$key] = $val['avgNoGroupPeople'];
            $ngp[$key] = $val['noGroupPeople'];
        }
        switch($sort){
            case '':
                array_multisort($ratio,SORT_DESC,$groupList);
            break;
            case '1':
                array_multisort($groupbuying_reqnums,SORT_ASC,$groupList);
            break;
            case '2':
                array_multisort($groupbuying_reqnums,SORT_DESC,$groupList);
            break;
            case '3':
                array_multisort($group,SORT_ASC,$groupList);
            break;
            case '4':
                array_multisort($group,SORT_DESC,$groupList);
            break;
            case '5':
                array_multisort($ctsl,SORT_ASC,$groupList);
            break;
            case '6':
                array_multisort($ctsl,SORT_DESC,$groupList);
            break;
            case '7':
                array_multisort($okPeople,SORT_ASC,$groupList);
            break;
            case '8':
                array_multisort($okPeople,SORT_DESC,$groupList);
            break;
            case '9':
                array_multisort($ratio,SORT_ASC,$groupList);
            break;
            case '10':
                array_multisort($ratio,SORT_DESC,$groupList);
            break;
        }

        $okPeopleAll = array();
        $requirePeopleAll = array();
        foreach($groupList as $key=>$val) {
            $okPeopleAll[] = $groupList[$key]['okPeople'];              //把每个商品成团人数处理称 数组 后面相加
            $requirePeopleAll[] = $groupList[$key]['requirePeople'];    //需要的总人数
        }

        $people['partake'] = intval($groupNo['noPeople']) + array_sum($okPeopleAll);   //参与总人数
        $people['require'] = array_sum($requirePeopleAll);                             //要求总人数
        $people['ratio'] = round($people['partake'] / $people['require'] *100 ,2).'%';


        import('@.ORG.RedisObj');
        $redis = new RedisObj();
        $zhuliNewUserNum = $redis->sCard('new_subscribe_user_key_2_qrscene_11');
//        dump($groupList);
        $this->assign('zhuli_new_user_num', $zhuliNewUserNum);
        $this->assign('page',$show);
        $this->assign('groupOk',$groupOk);
        $this->assign('groupAll',$groupAll);
        $this->assign('groupNo',$groupNo);                  //未成团
        $this->assign('people',$people);                    //参与总人数
        $this->assign('groupList',$groupList);              //列表数据
        $this->assign('list',$distributorList);             //分站
        $this->assign('post',$_POST);
        $this->display();
    }


    /*
     * 脫墓禄脻膶呕臉媒木脻
     * */
    public function coupon(){
        $coupon_tmlM = M('coupon_tml');
        $coupon_List = $coupon_tmlM->field('sms_send_showtext')->select();              //藳茅艃呕膶呕艛艜膼脥
        foreach($coupon_List as $val){
            $val=join(',',$val);
            $temp[]=$val;
        }
        $temp=array_unique($temp);
        foreach ($temp as $k => $v){
            $temp[$k]=explode(',',$v);
        }

//dump($_POST);
        $sms_send_showtext = I('sms_send_showtext');
        $time_From = I('limit_date_From');
        $time_To = I('limit_date_To');
        if(empty($_POST) || $sms_send_showtext =='11'){
            $where_used['is_used'] = array('eq',1);
        }
        if($sms_send_showtext && $sms_send_showtext != 11 ){
            $where_all['sms_send_showtext'] = array('eq',$sms_send_showtext);
            $where_used['sms_send_showtext'] = array('eq',$sms_send_showtext);
            $where_used['is_used'] = array('eq',1);
        }
        if($time_From && $time_To){
            $where_used['time'] = array(array('egt',$time_From),array('elt',$time_To));
            $where_used['is_used'] = array('eq',1);
            $where_all['time'] = array(array('egt',$time_From),array('elt',$time_To));
        }

        $cardM = M('card');
        $couponAll = $cardM->field('count(id) cid')->where($where_all)->find();        //藳茅艃呕艊艃路藰路墓碌脛膶呕
        $couponUsed = $cardM->field('count(id) cid')->where($where_used)->find();    //藳茅艃呕艊艃臉膮脫膫碌脛膶呕
        $data = $cardM->field('time,count(id) aid')->where($where_all)->group('time')->select();
        $page = new Page(count($data),self::PAGE_NUM);
        $show = $page->show();
        $cardList = $cardM->field('time,count(id) aid')->where($where_all)->order('time desc')->group('time')->limit($page->firstRow, $page->listRows)->select();  //藳茅艃呕艊艃路藰路墓
        $cardUsed = $cardM->field('count(id) usid,time')->where($where_used)->order('time desc')->group('time')->limit($page->firstRow, $page->listRows)->select();  //藳茅艃呕艊艃臉膮脫膫

        $cardResult = array();
        foreach($cardList as $key=>$val){
            $cardResult[md5($val['time'])] = array('total'=>$val['aid'], 'time'=>$val['time']);
        }

        foreach($cardUsed as $key=>$val){
           $cardResult[md5($val['time'])]['used_total'] = $val['usid'];
           $cardResult[md5($val['time'])]['ratio'] = round($cardResult[md5($val['time'])]['used_total'] / $cardResult[md5($val['time'])]['total'] * 100,2) . '%';
        }

//        dump($_POST);
//        dump($cardResult);
//        echo$cardM->getLastSql();
        $this->assign('page',$show);
        $this->assign('coupon_All',$couponAll);
        $this->assign('coupon_Used',$couponUsed);
        $this->assign('type',$temp);
        $this->assign('list',$cardResult);
        $this->assign('post',$_POST);
        $this->display();
    }

    /*
     * 三级联动 省市区
     * **/
    public function areaList(){
        $areaM = M('area');
        $pid = I('pid');
        $where['pid'] = array('eq',$pid);
        $provList = $areaM->field('id,name')->where($where)->select();
//        echo $areaM->getLastSql();
        echo json_encode($provList);
    }

    /**
     *  用户订单统计
     */
    public function userOrders(){
        $startTime = I('start_time', date('Y-m-d', time()) . ' 00:00:00');
        $endTime = I('end_time', date('Y-m-d', time()) . ' 23:59:59');

        $tmpJdOrder = M('tmp_jd_order');
        $orderM = new OrderModel();
        $where = array();
        $where['last_send_mail_time'] = array(array('egt', $startTime), array('elt', $endTime));

        $orderList = $tmpJdOrder->field('order_name')->where($where)->group('rec_key')->select();
        $orderNameArr = array();
        foreach($orderList as $order){
            $orderNameArr[] = $order['order_name'];
        }

        $orderUidWhere = array();
        $orderUidWhere['order_name'] = array('in', $orderNameArr);
        $orderUidList = $orderM->field('uid')->where($orderUidWhere)->select();

        $userOrdersInfo = array();
        //`operation_id` int(2) NOT NULL DEFAULT '0' COMMENT '0=>''待审核'',1=>''已审核'',2=>''已发货'',3=>''已完成'',4=>''未完成'',5=>''已取消'',6=>''等待完成'',7=>''退货中'',8=>''换货中'',9=>''已收货'',10=>''待发货''',
        $uidArr = array();
        foreach($orderUidList as $uid){
            $uidArr[] = $uid['uid'];

//            $userOrdersInfo[$uid['uid']] = '';
        }

        $userOrderWhere = array();
        $userOrderWhere['operation_id'] = array('in', array(2,3,6,9,10));
        $userOrderWhere['uid'] = array('in', $uidArr);

        $userOrdersList = $orderM->field('count(*) as onum, uid')->where($userOrderWhere)->relation('User')->group('uid')->limit(0, 10000)->select();

        $userOrderReportM = M('user_order_report');
        foreach($userOrdersList as $item){
            $data = array();
            $data['onum'] = $item['onum'];
            $data['uid'] = $item['uid'];
            $data['username'] = $item['username'];
            $data['add_time'] = date('Y-m-d H:i:s', time());
            $userOrderReportM->add($data);
        }

//        echo '<br/>总用户数'  . count($uidArr) . '<br/>';
//        echo $orderM->getLastSql();
//        var_dump($userOrdersList);
    }

    /**
     *  微信红包发送数据报表
     */
    public function redpackSendData(){
        $redpackResultM = M('redpack_result');
        $where = array();
        $where['id'] = array('gt', 36);
        $where['luck_uids'] = array('neq', '');
        $count = $redpackResultM->where($where)->count();
        $page = new Page($count, 20);
        $redpackList = $redpackResultM->where($where)->order('id desc')->limit($page->firstRow, $page->listRows)->select();

        $statusArr = array();
        //默认为1， 2为 已开奖，3为异常如无额度等',
        $statusArr[1] = '未开奖';
        $statusArr[2] = '已开奖';
        $statusArr[3] = '异常(如无额度)';
        $statusArr[4] = '已检查';
        foreach($redpackList as $key => $item){
            $redpackList[$key]['status'] = $statusArr[$item['status']];
            $redpackList[$key]['log'] = mb_substr($item['log'], 0, 30);

            $redpackMoney = 0;
            $luckUserArr = json_decode($item['luck_uids'], true);
            if(empty($luckUserArr)){
                $redpackList[$key]['total_money'] = $redpackMoney;
                continue;
            }

            foreach($luckUserArr as $luckItem){
                $redpackMoney = $redpackMoney + $luckItem['money'];
            }

            $redpackList[$key]['total_money'] = $redpackMoney / 100;

            $redpackList[$key]['real_one_money'] = number_format($redpackList[$key]['total_money'] / $redpackList[$key]['real_group_new_user_num'], 2);
        }

        $this->assign('page',$page->show());
        $this->assign('list',$redpackList);              //列表数据
        $this->display('redpack');

    }

    public function exportData(){
        $dataType = I('data_type', 'redpack');


        switch($dataType){
            case 'redpack':
                $xlsName = '微信红包发放数据报表';
                $xls_cell = array();
                $xls_data = array();
                $this->exportExcel($xlsName, $xls_cell, $xls_data, '', true);
                break;

            case 'dynamic_user':
                $xlsName = '最近两周活跃用户数据报表';
//                uid,order_name,groupbuying_name,recv_address,first_order_time,order_num
                $xls_cell = array(array('uid', '用户ID'), array('order_name', '订单号'), array('groupbuying_name', '团购名'), array('recv_address', '收货地址'), array('order_num', '订单数'),array('first_order_time', '初次下单时间'), array('last_order_time', '最后下单时间'));
                $xls_data = $this->getDynamicUser();
                $this->exportExcel($xlsName, $xls_cell, $xls_data, '', true);
                break;

            default:

                break;
        }

    }

    /**
     *  用户亲密度报表
     */
    public function userIntimate(){
        $uid = I('uid', 0);
        $username = I('username', '');
        $userFriendIntimateM = M('user_friend_intimate');
        $where = array();
        if($uid > 0){
            $where['uid'] = $uid;
        }

        if(!empty($username)){
            $where['nickname'] = array('like', '%' . $username . '%');
        }
        $where['friend_num'] = array('gt', 0);
        $count = $userFriendIntimateM->where($where)->count();
        $page = new Page($count, 50);
        $list = $userFriendIntimateM->where($where)->order('succ_order_num desc, sponsor_succ_num desc, friend_num  desc')->limit($page->firstRow, $page->listRows)->select();

        $this->assign('page',$page->show());
        $this->assign('list',$list);              //列表数据
        $this->display('user_intimate');
    }

    /**
     *  查看某个用户的好友亲密度
     */
    public function userIntimateFriendList(){
        $uid = I('uid', 0);
        $userFriendIntimateM = M('user_friend_intimate');
        $item = $userFriendIntimateM->where(array('uid'=>$uid))->find();
        $list = array();
        if(!empty($item['friend_intimate'])){
            $userM = M('user');
            $intimateArr = json_decode($item['friend_intimate'], true);
            foreach($intimateArr as $key =>$val){
                $user = $userM->field('username')->where(array('id' => $key))->find();
                $user['uid'] = $key;
                $user['intimate'] = $val;
                $list[] = $user;
            }
        }
        $this->assign('user', $item);
        $this->assign('list',$list);              //列表数据
        $this->display('user_intimate_list');
    }

    public function zhuli(){
//        $groupbuyingTmlM = M('groupbuying_tml');
//        $groupbuyingM = M('groupbuying');
//        $groupbuyingTmlWhere = array();
//        $groupbuyingTmlWhere['groupbuy_type'] = 1;
//        $tmlList = $groupbuyingTmlM->where($groupbuyingTmlWhere)->select();
//
//        $tmlId = I('tml_id', 0);
//        $groupbuyingWhere = array();
//        $groupbuyingWhere['groupbuying_tmlid'] = $tmlId;
//        $count = $groupbuyingM->where($groupbuyingWhere)->count();
//        $page = new page($count, 50);
//        $groupbuyingList = $groupbuyingM->where($groupbuyingWhere)->limit($page->firstRow, $page->listRows)->select();
//
//
//        $this->assign('tml_list', $tmlList);
//        $this->assign('groupbuying_list', $groupbuyingList);
//        $this->display('zhuli');
    }

    /**
     *  活跃用户报表
     */
    public function dynamicUser(){
        $uid = I('uid', 0);
        $where = array();
        if($uid > 0){
            $where['uid'] = $uid;
        }

        $data = $this->getDynamicUser($where, 14);

        $this->assign('page', $data['page_str']);
        $this->assign('list',$data['list']);              //列表数据
        $this->display('dynamic_user');
    }

    /**
     *  取最近2周的活跃用户
     */
    private function getDynamicUser($where = array(), $daysAgo = 14){
        $groupbuyingOrderM = M('groupbuying_order');

        $where['create_time'] = array('gt', time() - (86400 * $daysAgo));
        $where['state'] = array('in', array(2,5,6));
        $where['groupbuyingtml_id'] = array('not in', array(88));

        $count = $groupbuyingOrderM->field('count(distinct(uid)) as count')->where($where)->find();
        $page = new Page($count['count'], 50);

        $orderList = $groupbuyingOrderM->field('uid,order_name,groupbuying_name,recv_address,count(*) as order_num')->where($where)->group('uid')->order('order_num desc')->limit($page->firstRow, $page->listRows)->select();

        $orderM = M('groupbuying_order');
        foreach($orderList as $key => $order){
            //2,3,6,9.10
            $where = array();
            $where['uid'] = $order['uid'];
            $where['state'] = array('in', array(2,5,6));
            $orderItem = $orderM->field('create_time')->where($where)->order('create_time asc')->find();
            $lastOrder = $orderM->field('create_time')->where($where)->order('create_time desc')->find();
            $orderList[$key]['first_order_time'] = date('Y-m-d H:i:s',$orderItem['create_time']);
            $orderList[$key]['last_order_time'] = date('Y-m-d H:i:s',$lastOrder['create_time']);
        }

        return array('list' => $orderList, 'count' => $count, 'page_str' => $page->show());
    }

    /**
     *  导出参加火龙果活动的
     */
    public function exportUserShareNum(){
        $groupbuyingOrderM = M('groupbuying_order');
        $where = array();
        $where['state'] = 2;
        $where['pay_money'] = array('gt', 1);
        $where['groupbuyingtml_id'] = 136;
        $orderList = $groupbuyingOrderM->field('uid, count(*) as order_num')->where($where)->group('uid')->order('order_num desc')->limit(100)->select();

        //        echo 'sql==' . $groupbuyingOrderM->getLastSql();
        //        var_dump($orderList);
        //        exit;
        //        $orderList = array();
        //        $orderList[] = array('uid' => 703865, 'order_num' => 3);

        //        echo '<table>';
        foreach($orderList as $key => $order){
            $sql = "select count(*) as share_count from ttgy_wxshare_log where (first_uid=" . $order['uid'] . " and relay_num=1) or (sec_uid=" . $order['uid'] .  " and relay_num=2) or (third_uid=". $order['uid'] . " and relay_num=3)";
            $count = M()->query($sql);

            $orderList[$key]['share_count'] = $count[0]['share_count'];

            $whereOrder = array();
            $whereOrder['state'] = array('in', array(2,5,6));
            $whereOrder['uid'] = $order['uid'];

            $countOrder = $groupbuyingOrderM->field('count(*) as order_num')->where($whereOrder)->select();

            $orderList[$key]['all_order_num'] = $countOrder[0]['order_num'];

            //            echo '<tr><td>' .   $orderList[$key]['uid'] . '</td><td>     ' .$orderList[$key]['order_num'] . ' </td> <td>   ' . $orderList[$key]['share_count'] . '   </td> <td>   ' . $orderList[$key]['all_order_num']  . '</td><tr/>';

        }

        //        echo '</table>';

        exportExcel('火龙果活动用户订单与分享表', array(array('uid','用户id'), array('order_num' ,'订单数'), array('share_count', '分享次数'), array('all_order_num', '总成团订单数')), $orderList, '', true);
    }

    public function test(){
        echo strtotime('2016-01-12 00:00');
    }
}
