<?php
/**
 *  外网主站后台配置文件
 */
if(!defined('THINK_PATH')) {
    exit();
}

include_once('config.db.php');

$config = array(
    'DEFAULT_THEME' => 'default', // 默认模板主题名称
    'TMPL_CACHE_ON' => false, //配置
    'DEFAULT_MODULE' => 'Public', // 默认模块名称
    'DEFAULT_ACTION' => 'index', // 默认操作名称
    //    'SHOW_PAGE_TRACE' => true,
    'SHOW_PAGE_TRACE' => false,

    'FRONT_SITE_URL' => 'http://m.shuxiaobai.com/', 'IMG_SITE_URL' => 'http://img0.shipinmmm.com/', 'PUBLIC_SITE_URL' => 'http://m.shuxiaobai.com/', 'DB_FIELDS_CACHE' => false,

    //    "ORDER_STATUS" => array(1 => "待付款", 2 => "已付款", 3 => "待发货", 4 => "待收货", 5 => "已收货", 6 => "已完成", 7 => "退货中", 8 => "退货完成", 9 => "关闭"),


    'APP_AUTOLOAD_PATH' => '@.TagLib',
    'SESSION_AUTO_START' => true, 'USER_AUTH_ON' => true, 'USER_AUTH_TYPE' => 1, // 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY' => 'admin_id', // 用户认证SESSION标记
    'ADMIN_AUTH_KEY' => 'administrator', 'USER_AUTH_MODEL' => 'Admin', // 默认验证数据表模型
    'AUTH_PWD_ENCODER' => 'md5', // 用户认证密码加密方式
    'USER_AUTH_GATEWAY' => '/Public/index', // 默认认证网关
    'NOT_AUTH_MODULE' => 'Public', // 默认无需认证模块
    'REQUIRE_AUTH_MODULE' => 'Category,Brand,Business', // 默认需要认证模块
    'NOT_AUTH_ACTION' => '', // 默认无需认证操作
    'REQUIRE_AUTH_ACTION' => '', // 默认需要认证操作
    'GUEST_AUTH_ON' => false, // 是否开启游客授权访问
    'GUEST_AUTH_ID' => 0, // 游客的用户ID
    'DB_LIKE_FIELDS' => 'title|remark',
    //RBAC 相关表配置
    'RBAC_ROLE_TABLE' => 'ttgy_role', 'RBAC_USER_TABLE' => 'ttgy_role_user', 'RBAC_ACCESS_TABLE' => 'ttgy_access', 'RBAC_NODE_TABLE' => 'ttgy_node',

    'VAR_FILTERS' => 'filter_exp,RemoveXSS',     // 全局系统变量的默认过滤方法 多个用逗号分割

);

$config['PAY_ARRAY']  =  array(
    1=>array('name'=>'支付宝','son'=>array()),
    // 2=>array('name'=>'联华OK会员卡在线支付','son'=>array()),
    //      3=>array('name'=>'网上银行支付','son'=>array(
    //           // "00021"=>"招商银行(银行卡支付（全国范围）)",
    //           // "00004"=>"中国工商银行(网上签约注册用户（全国范围）)",
    //	         "00102"=>"浦发银行信用卡(活动中)",
    //           "00003"=>"中国建设银行",
    //           // "00017"=>"中国农业银行(网上银行签约客户（全国范围）)",
    //           // "00083"=>"中国银行(银行卡支付（全国范围）)",
    //           // "00005"=>"交通银行(太平洋卡（全国范围）)",
    //           // "00032"=>"浦东发展银行(东方卡（全国范围）)",
    //           // "00084"=>"上海银行(银行卡支付（全国范围）)",
    //           // "00052"=>"广东发展银行(银行卡支付（全国范围）)",
    //           // "00051"=>"邮政储蓄(银联网上支付签约客户（全国范围）)",
    //           // "00023"=>"深圳发展银行(发展卡支付（全国范围）)",
    //           // "00054"=>"中信银行(银行卡支付（全国范围）)",
    //           // "00087"=>"平安银行(平安借记卡（全国范围）)",
    //           // "00096"=>"东亚银行(银行卡支付（全国范围）)",
    //           // "00057"=>"光大银行(银行卡支付（全国范围）)",
    //           // "00041"=>"华夏银行(华夏借记卡（全国范围）)",
    //           // "00013"=>"民生银行(民生卡（全国范围）)",
    //           // "00055"=>"南京银行(银行卡支付（全国范围）)",
    //           // "00016"=>"兴业银行(在线兴业（全国范围）)",
    //           // "00081"=>"杭州银行(银行卡支付（全国范围）)",
    //           // "00086"=>"浙商银行(银行卡支付（全国范围）)",
    //           //"00030"=>"上海农村商业银行(如意借记卡（上海地区）)"
    //           "00100"=>"民生银行家园卡",
    //     )),
    7=>array('name'=>'微信支付','son'=>array()),
    // 8=>array('name'=>'银联支付','son'=>array()),
    9=>array('name'=>'微信支付','son'=>array()),
    //      5=>array('name'=>'账户余额支付','son'=>array()),
    4=>array('name'=>'线下支付','son'=>array(
        1=>'货到付现金',
        2=>'货到刷银行卡',
        // 3=>'货到刷联华OK卡',
        //            7=>'红色储值卡支付',
        //            8=>'金色储值卡支付',
        //            9=>'果实卡支付',
        //            10=>'提货券支付',//key=10的提货券支付在购买流程会作为判断条件不赠送满赠赠品，不要修改key=10
        //            11=>'通用券/代金券支付'
    )),
    //      6=>array('name'=>'券卡支付','son'=>array(1=>'在线提货券支付')),
);


$config['ORDER_STATUS'] = array(
    0=>'待审核',
    1=>'已审核',
    2=>'已发货',
    3=>'已完成',
    4=>'未完成',
    5=>'已取消',
    6=>'等待完成',
    7=>'退货中',
    8=>'换货中',
    9=>'已收货'
);
$config['PAY_STATUS'] = array(
    0=>'还未付款',
    1=>'已经付款',
    2=>'到帐确认中',
);

//订单终极状态，正常收货和换货进已完成，   退货进已退货，未付款进已取消
// 待付款，已付款，待发货，已发货，已完成，已取消，退货中，换货中，已退货
$config['MANAGE_ORDER_STATUS'] = array(
    0=>'全部',
    1=>'待审核',
    2=>'待付款',
    3=>'已付款',
    4=>'待发货',
    5=>'已发货',
    6=>'已完成',
    7=>'已取消',
    8=>'退货中',
    9=>'换货中',
    10=>'已退货'
);

$config['JD_APP'] = array(
    'APP_KEY' => 'CE47EFEEEC014076C95527A394AE05CE',
    'APP_SECRET' => '2f712524b7d84676b476e1d2e70b2707',
    'CUSTOMER_CODE' => '021K23664',
    //接口调用时自定义的加密串
    'PASS_KEY' => md5('abc12376446'),
);

$config['CHANNEL'] = array(
    'portal' => '官网',
);

$config['GROUP_BUYING'] = array(
    'condition_type' => array(0 => '无其它条件', 1=>'分享到朋友圈', 2=>'会员等级'),
    'groupbuying_tml_state' => array(0 => '准备上架', 1=> '上架', 2=>'下架'),
    'groupbuying_state' => array(0 => '未开团', 1=> '已开团未完成', 2=>'完成团购'),
);

//后台运行的定时任务加密串
$config['AUTO_TASK_KEY'] = md5('abc12376446');

//微信开放平台接口
$config['WX_APP_ID'] = 'wxef0b5e777098cfa5';
$config['WX_SECRET'] = 'd9b780ecac4f1beba0f1342dfdc7ddf6';
$config['WX_ACCESS_TOKEN_KEY'] = 'wx_api_access_token';
$config['WX_JSAPI_TICKET_KEY'] = 'wx_jsapi_ticket';
$config['WX_JSSDK_NONCESTR'] = 'spai689898djjduejdud';
$config['WX_PAY_MCHID'] = '1290064401';
$config['WX_PAY_KEY'] = '6a50ea01b41e4239a991f6419d19c0b3';

$config['WX_PAY_SSL_CERT'] = BASE_PATH . '/shipin_manager/Conf/weixinpay/cert/shipin/apiclient_cert.pem';
$config['WX_PAY_SSL_KEY'] = BASE_PATH . '/shipin_manager/Conf/weixinpay/cert/shipin/apiclient_key.pem';

//支付宝
$config['ALIPAY_CONF'] = array(
    'partner' => '2088021131600925',
    'seller_id' => '511137694@qq.com',
    'private_key_path' => BASE_PATH . trim(THINK_PATH, '.') . '/Extend/Vendor/alipay/key/rsa_private_key.pem',
    'public_key_path' => BASE_PATH . trim(THINK_PATH, '.') . '/Extend/Vendor/alipay/key/alipay_public_key.pem',
    'sign_type' => strtoupper('MD5'),
    'key' => 'qadmx7i77ap9qvsp3pnq6xt5emjksqhi',
    'input_charset' => strtolower('utf-8'),
    'cacert' => BASE_PATH . trim(THINK_PATH, '.') . '/Extend/Vendor/alipay/cacert.pem',
    'transport' => 'http',
);

$config['SMS_URL'] = 'http://139.129.128.71:8086/msgHttp/json/mt';
$config['SMS_ACCOUNT'] = 'shiping106';
$config['SMS_PASSWD'] = '123456';
$config['SMS_USERID'] = '582';

$config['DATA_CACHE_TYPE'] = 'Redis';
//Redis配置
$config['REDIS_AUTH'] = 'shi*818$9pindie83kd1LAJDidk';
$config['REDIS_HOST'] = '121.43.225.46';
$config['DATA_CACHE_PREFIX'] = 'testmv2.shuxiaobai.com_';
//$config['DATA_CACHE_PREFIX'] = 'm.shuxiaobai.com_';

//主站后台默认只显示时品和天天果园发货渠道的订单和商品
$config['MAIN_CHANNEL'] = array('fruitday', 'shipin');

//是否可以发京东快递, 默认为1未检查，2已检查可以发, 3已检查不能发,4已检查需要人工确认
$config['JD_CAN_SHIPPING'] = array(1=>'未检查', 2=>'已通过', 3=>'未通过', 4=>'人工分捡');

//抽奖送红包的配置文件
$config['INIT_CHANCE'] = 10;  //初始中奖概率,百分点   代表10%
$config['RECUR_LUCK_RATIO'] = 1;  //重复中奖概率的百分数  代表1%
$config['MOST_LUCK_NUM'] = 5;  //最多重复中奖次数
$config['TODAY_MAX_MONEY'] = 10000;  //当天最多发放的现金红包金额,单位分

//微信消息模板id
$config['GROUPBUY_SUCC_MSG_TML_ID'] = 'GIkshKOHHoVdIVDB33vX8VyIbriBy91WBB7ImvbX-7M'; //组团成功
$config['COUPON_GET_MSG_TML_ID'] = '-07iFldOHbdNL2r7WpKOj5d0gn_P0uRDG9y1p8DqWVc'; //得到优惠券
$config['WX_SUBSCRIBE_MSG'] = '叔小白，拼起来！因咨询接待爆棚，小白可能无法及时回复，请您见谅；如您有问题咨询可以回复以下数字自助查看回复，若以下列表无法解决您的问题请留言叔小白，小白看到会第一时间回复您，给您造成不便敬请谅解！
回复1   关于叔小白
回复2   关于拼团与参团
回复3   关于发货
回复4   关于快递查询
回复5   关于商品签收
回复6   关于X元开团券
回复7   关于团长特权
回复8   关于提交订单
回复9   关于坏果包赔
回复10    关于售后服务';

//是否在假期，如春节等特殊情况
$config['IS_HOLIDAY'] = false;
return array_merge($comm_config, $config);