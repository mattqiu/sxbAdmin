<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>时品-管理后台</title>

    <script type="text/javascript">
        //<![CDATA[
        try {
            if (!window.CloudFlare) {
                var CloudFlare = [{
                    verbose: 0,
                    p: 1419364062,
                    byc: 0,
                    owlid: "cf",
                    bag2: 1,
                    mirage2: 0,
                    oracle: 0,
                    paths: {cloudflare: "/cdn-cgi/nexp/dok2v=1613a3a185/"},
                    atok: "1fca8a26fb9678bbb4b5c54c34e227b9",
                    petok: "4ca96b72a62631073dd6873922c67f1bf6e51b65-1420553914-1800",
                    zone: "adbee.technology",
                    rocket: "0",
                    apps: {"ga_key": {"ua": "UA-49262924-2", "ga_bs": "2"}}
                }];
//                !function (a, b) {
//                    a = document.createElement("script"), b = document.getElementsByTagName("script")[0], a.async = !0, a.src = "//ajax.cloudflare.com/cdn-cgi/nexp/dok2v=919620257c/cloudflare.min.js", b.parentNode.insertBefore(a, b)
//                }()
            }
        } catch (e) {
        }
        ;
        //]]>
    </script>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/v3/css/bootstrap/bootstrap.min.css"/>
    <script src="__PUBLIC__/admin/v3/js/demo-rtl.js"></script>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/v3/css/libs/font-awesome.css"/>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/v3/css/libs/nanoscroller.css"/>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/v3/css/compiled/theme_styles.css"/>
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/shipinmmm/main.css" type="text/css" />
    <link type="image/x-icon" href="favicon.png" rel="shortcut icon"/>
    <!--<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700,300|Titillium+Web:200,300,400' rel='stylesheet' type='text/css'>-->
    <!--[if lt IE 9]>
    <script src="__PUBLIC__/admin/v3/js/html5shiv.js"></script>
    <script src="__PUBLIC__/admin/v3/js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        /* <![CDATA[ */
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-49262924-2']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
//ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';"glyphicon  glyphicon-
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

        (function (b) {
            (function (a) {
                "__CF"in b && "DJS"in b.__CF ? b.__CF.DJS.push(a) : "addEventListener"in b ? b.addEventListener("load", a, !1) : b.attachEvent("onload", a)
            })(function () {
                "FB"in b && "Event"in FB && "subscribe"in FB.Event && (FB.Event.subscribe("edge.create", function (a) {
                    _gaq.push(["_trackSocial", "facebook", "like", a])
                }), FB.Event.subscribe("edge.remove", function (a) {
                    _gaq.push(["_trackSocial", "facebook", "unlike", a])
                }), FB.Event.subscribe("message.send", function (a) {
                    _gaq.push(["_trackSocial", "facebook", "send", a])
                }));
                "twttr"in b && "events"in twttr && "bind"in twttr.events && twttr.events.bind("tweet", function (a) {
                    if (a) {
                        var b;
                        if (a.target && a.target.nodeName == "IFRAME")a:{
                            if (a = a.target.src) {
                                a = a.split("#")[0].match(/[^?=&]+=([^&]*)?/g);
                                b = 0;
                                for (var c; c = a[b]; ++b)if (c.indexOf("url") === 0) {
                                    b = unescape(c.split("=")[1]);
                                    break a
                                }
                            }
                            b = void 0
                        }
                        _gaq.push(["_trackSocial", "twitter", "tweet", b])
                    }
                })
            })
        })(window);
        /* ]]> */
    </script>

    <!--首页独有的-->
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/libs/fullcalendar.css" type="text/css"/>
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/libs/fullcalendar.print.css" type="text/css" media="print"/>
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/compiled/calendar.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/libs/morris.css" type="text/css"/>
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/libs/daterangepicker.css" type="text/css"/>
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/libs/jquery-jvectormap-1.2.2.css" type="text/css"/>

    <!--表格-订单页的-->
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/v3/css/libs/dataTables.fixedHeader.css">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/v3/css/libs/dataTables.tableTools.css">

    <!--模态弹出框页的-->
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/v3/css/libs/nifty-component.css"/>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/main_v3.css"/>

    <!--时间日期选择器-->
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/libs/datepicker.css" type="text/css"/>
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/libs/daterangepicker.css" type="text/css"/>
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/libs/bootstrap-timepicker.css" type="text/css"/>
    <link rel="stylesheet" href="__PUBLIC__/admin/v3/css/libs/select2.css" type="text/css"/>
</head>
<body>

<div id="theme-wrapper" class="rushToPurchase">

    <header class="navbar" id="header-navbar">
    <div class="container">
        <a href="index.html" id="logo" class="navbar-brand">
            <img src="__PUBLIC__/admin/v3/img/logo.png" alt="" class="normal-logo logo-white"/>
            <img src="__PUBLIC__/admin/v3/img/logo-black.png" alt="" class="normal-logo logo-black"/>
            <img src="__PUBLIC__/admin/v3/img/logo-small.png" alt="" class="small-logo hidden-xs hidden-sm hidden"/>
        </a>

        <div class="clearfix">
            <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="fa fa-bars"></span>
            </button>
            <div class="nav-no-collapse navbar-left pull-left hidden-sm hidden-xs">
                <ul class="nav navbar-nav pull-left">
                    <li>
                        <a class="btn" id="make-small-nav">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="nav-no-collapse pull-right" id="header-nav">
                <ul class="nav navbar-nav pull-right">
                    <li class="mobile-search">
                        <a class="btn">
                            <i class="fa fa-search"></i>
                        </a>

                        <div class="drowdown-search">
                            <form role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <i class="fa fa-search nav-search-icon"></i>
                                </div>
                            </form>
                        </div>
                    </li>
                    <!--<li class="dropdown hidden-xs">-->
                        <!--<a class="btn dropdown-toggle" data-toggle="dropdown">-->
                            <!--<i class="fa fa-warning"></i>-->
                            <!--<span class="count">8</span>-->
                        <!--</a>-->
                        <!--<ul class="dropdown-menu notifications-list">-->
                            <!--<li class="pointer">-->
                                <!--<div class="pointer-inner">-->
                                    <!--<div class="arrow"></div>-->
                                <!--</div>-->
                            <!--</li>-->
                            <!--<li class="item-header">You have 6 new notifications</li>-->
                            <!--<li class="item">-->
                                <!--<a href="#">-->
                                    <!--<i class="fa fa-comment"></i>-->
                                    <!--<span class="content">New comment on ‘Awesome P...</span>-->
                                    <!--<span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
                                <!--</a>-->
                            <!--</li>-->
                            <!--<li class="item">-->
                                <!--<a href="#">-->
                                    <!--<i class="fa fa-plus"></i>-->
                                    <!--<span class="content">New user registration</span>-->
                                    <!--<span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
                                <!--</a>-->
                            <!--</li>-->
                            <!--<li class="item">-->
                                <!--<a href="#">-->
                                    <!--<i class="fa fa-envelope"></i>-->
                                    <!--<span class="content">New Message from George</span>-->
                                    <!--<span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
                                <!--</a>-->
                            <!--</li>-->
                            <!--<li class="item">-->
                                <!--<a href="#">-->
                                    <!--<i class="fa fa-shopping-cart"></i>-->
                                    <!--<span class="content">New purchase</span>-->
                                    <!--<span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
                                <!--</a>-->
                            <!--</li>-->
                            <!--<li class="item">-->
                                <!--<a href="#">-->
                                    <!--<i class="fa fa-eye"></i>-->
                                    <!--<span class="content">New order</span>-->
                                    <!--<span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
                                <!--</a>-->
                            <!--</li>-->
                            <!--<li class="item-footer">-->
                                <!--<a href="#">-->
                                    <!--View all notifications-->
                                <!--</a>-->
                            <!--</li>-->
                        <!--</ul>-->
                    <!--</li>-->
                    <!--<li class="dropdown hidden-xs">-->
                        <!--<a class="btn dropdown-toggle" data-toggle="dropdown">-->
                            <!--<i class="fa fa-envelope-o"></i>-->
                            <!--<span class="count">16</span>-->
                        <!--</a>-->
                        <!--<ul class="dropdown-menu notifications-list messages-list">-->
                            <!--<li class="pointer">-->
                                <!--<div class="pointer-inner">-->
                                    <!--<div class="arrow"></div>-->
                                <!--</div>-->
                            <!--</li>-->
                            <!--<li class="item first-item">-->
                                <!--<a href="#">-->
                                    <!--<img src="__PUBLIC__/admin/v3/img/samples/messages-photo-1.png" alt=""/>-->
<!--<span class="content">-->
<!--<span class="content-headline">-->
<!--George Clooney-->
<!--</span>-->
<!--<span class="content-text">-->
<!--Look, just because I don't be givin' no man a foot massage don't make it-->
<!--right for Marsellus to throw...-->
<!--</span>-->
<!--</span>-->
                                    <!--<span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
                                <!--</a>-->
                            <!--</li>-->
                            <!--<li class="item">-->
                                <!--<a href="#">-->
                                    <!--<img src="__PUBLIC__/admin/v3/img/samples/messages-photo-2.png" alt=""/>-->
<!--<span class="content">-->
<!--<span class="content-headline">-->
<!--Emma Watson-->
<!--</span>-->
<!--<span class="content-text">-->
<!--Look, just because I don't be givin' no man a foot massage don't make it-->
<!--right for Marsellus to throw...-->
<!--</span>-->
<!--</span>-->
                                    <!--<span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
                                <!--</a>-->
                            <!--</li>-->
                            <!--<li class="item">-->
                                <!--<a href="#">-->
                                    <!--<img src="__PUBLIC__/admin/v3/img/samples/messages-photo-3.png" alt=""/>-->
<!--<span class="content">-->
<!--<span class="content-headline">-->
<!--Robert Downey Jr.-->
<!--</span>-->
<!--<span class="content-text">-->
<!--Look, just because I don't be givin' no man a foot massage don't make it-->
<!--right for Marsellus to throw...-->
<!--</span>-->
<!--</span>-->
                                    <!--<span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
                                <!--</a>-->
                            <!--</li>-->
                            <!--<li class="item-footer">-->
                                <!--<a href="#">-->
                                    <!--View all messages-->
                                <!--</a>-->
                            <!--</li>-->
                        <!--</ul>-->
                    <!--</li>-->
                    <li class="hidden-xs">
                        <a class="btn">
                            <i class="fa fa-cog"></i>
                        </a>
                    </li>
                    <li class="dropdown profile-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="__PUBLIC__/admin/v3/img/samples/scarlet-159.png" alt=""/>
                            <span class="hidden-xs"><?php echo ($_SESSION['user_name']); ?></span> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="user-profile.html"><i class="fa fa-user"></i>Profile</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i>Settings</a></li>
                            <li><a href="#"><i class="fa fa-envelope-o"></i>Messages</a></li>
                            <li><a href="/Public/toLogout"><i class="fa fa-power-off"></i>Logout</a></li>
                        </ul>
                    </li>
                    <li class="hidden-xxs">
                        <a class="btn" href="/Public/toLogout">
                            <i class="fa fa-power-off"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
    <div id="page-wrapper" class="container">
        <div class="row">
            
<div id="nav-col">
    <section id="col-left" class="col-left-nano">
        <div id="col-left-inner" class="col-left-nano-content">

            <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
            <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="index.html">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                        <span class="label label-info label-circle pull-right">28</span>
                    </a>
                </li>


                <?php if(is_array($menus)): foreach($menus as $key=>$menu_son): ?><li>
                        <a href="#" class="dropdown-toggle">
                            <i class="fa fa-table"></i>
                            <span><?php echo ($menu_son["title"]); ?></span>
                            <i class="fa fa-chevron-circle-right drop-icon"></i>
                        </a>
                        <ul class="submenu">
                            <?php if(is_array($menu_son["son"])): foreach($menu_son["son"] as $key=>$menu): ?><li class="  <?php if($menu["is_active"] == 1): ?>active<?php endif; ?>">
                                <a href="<?php echo ($menu["link"]); ?>"><?php echo ($menu["name"]); ?></a>
                    </li><?php endforeach; endif; ?>
            </ul>
                </li><?php endforeach; endif; ?>
            </ul>
            </div>

        </div>
    </section>
</div>







            <div id="content-wrapper">

                <div class="md-content">
                    <div class="modal-header">
                        <button class="md-close close">&times;</button>
                        <h4 class="modal-title">编辑团购模板</h4>
                    </div>
                    <form action="/index.php?m=GroupBuyingTml&a=save"  method="post" role="form" id="add_form">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-xs-4">
                                    <span class="label">商品id</span>
                                    <a href="javascript:void(0);" id="select_group_tml_id" class="modals_radio_select md-trigger btn btn-primary"
                                       data-inputId="goods_id" data-url="/Product/selectJson"
                                       data-title="选择商品" data-modal="modal_radio_select">选择商品</a>

                                    <input type="text" name="product_id" class="form-control col-xs-3 modals_radio_select_input" id="goods_id" value="<?php echo ($item["product_id"]); ?>"/>

                                </div>

                                <div class="form-group col-xs-8">
                                    <span class="label">商品名称:</span>  <span id="goods_name" class="label"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">原价:</span>  <span id="old_price" class="label"></span>
                                    <input type="text" name="original_price" id="original_price" value="<?php echo ($item["original_price"]); ?>"
                                            class="form-control col-xs-6" />
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">单独购买价格:</span>
                                    <input type="text" name="separatebuy_price" id="separatebuy_price" value="<?php echo ($item["separatebuy_price"]); ?>" class="form-control col-xs-6"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <span class="label">团购名:</span><input type="text" name="groupbuying_name" id="groupbuying_name" class="form-control col-xs-8" value="<?php echo ($item["groupbuying_name"]); ?>"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-10">
                                    <span class="label">描述:</span>
                                    <textarea name="groupbuying_des" id="groupbuying_des" cols="40" rows="2"><?php echo ($item["groupbuying_des"]); ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-3">
                                    <span class="label">团购价格:</span>
                                    <input type="text" name="groupbuying_price" id="groupbuying_price" class="form-control col-xs-3" value="<?php echo ($item["groupbuying_price"]); ?>"/>
                                </div>

                                <div class="form-group col-xs-3">
                                    <span class="label">身边拼价格:</span>
                                    <input type="text" name="sidesplicing_price" id="sidesplicing_price" class="form-control col-xs-3" value="<?php echo ($item["sidesplicing_price"]); ?>"/>
                                </div>

                                <div class="form-group col-xs-3">
                                    <span class="label">成团人数:</span>
                                    <input type="text" name="groupbuying_reqnums" id="groupbuying_reqnums" class="form-control col-xs-3" value="<?php echo ($item["groupbuying_reqnums"]); ?>"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">限制类型:</span>
                                    <!--0无其它条件，1分享到朋友圈，2会员等级-->
                                    <select name="condition_type" id="condition_type">
                                        <option value="0">无其它条件</option>
                                        <option value="1">分享到朋友圈</option>
                                        <option value="2">会员等级</option>
                                    </select>
                                </div>

                                <div class="form-group col-xs-5">
                                    <!--条件参数（默认0，没有。例如：condition_type为2时，这个数字表示要求的会员等级）-->
                                    <span class="label">限制条件:</span>
                                    <input type="text" name="condition_num" id="condition_num" class="form-control col-xs-8"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <!--上架状态(0准备上架，1上架，2下架)-->
                                    <span class="label">状态:</span>
                                    <select name="state" id="state">
                                        <option value="0" <?php if($item["state"] == 0): ?>selected="selected"<?php endif; ?> >准备上架</option>
                                        <option value="1" <?php if($item["state"] == 1): ?>selected="selected"<?php endif; ?>
                                        >上架</option>
                                        <option value="2"
                                        <?php if($item["state"] == 2): ?>selected="selected"<?php endif; ?>
                                        >下架</option>
                                    </select>
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">上架时间:</span>

                                    <div class="input-group" style="width: 150px; float: left;">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" name="begin_selltime_date" id="begin_selltime_date" class="form-control" value="<?php echo ($item["begin_selltime_date"]); ?>"  />
                                    </div>

                                    <div class="input-group input-append bootstrap-timepicker" style="width: 150px; float: right;">
                                        <input type="text" class="form-control timepicker" id="" name="begin_selltime_time"
                                              value="<?php echo ($item["begin_selltime_time"]); ?>"  />
                                        <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">邮费:</span>
                                    <input type="text" name="postage" id="postage" class="form-control col-xs-6"
                                            value="<?php echo ($item["postage"]); ?>"/>
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">已售出数量:</span>
                                    <input type="text" name="salenum" id="salenum" class="form-control col-xs-6"
                                           value="<?php echo ($item["salenum"]); ?>"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">成团时限:</span>
                                    <input type="text" name="lifetime" id="lifetime" class="form-control col-xs-6"
                                           value="<?php echo ($item["lifetime"]); ?>"/> 小时
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">是否可用团长权限:</span>
                                    <input type="radio" value="1" id="canuse_groupbuy_permission_yes" name="canuse_groupbuy_permission"
                                    <?php if(($item["canuse_groupbuy_permission"]) == "1"): ?>checked="checked"<?php endif; ?>
                                            />
                                    <label for="canuse_groupbuy_permission_yes">可用</label>

                                    <input type="radio" value="0" id="canuse_groupbuy_permission_no" name="canuse_groupbuy_permission"
                                    <?php if(($item["canuse_groupbuy_permission"]) == "0"): ?>checked="checked"<?php endif; ?>
                                            />
                                    <label for="canuse_groupbuy_permission_no">不可用</label>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">是否可用优惠券:</span>
                                    <input type="radio" value="1" id="canuse_groupbuy_coupon_yes" name="canuse_groupbuy_coupon"
                                    <?php if(($item["canuse_groupbuy_coupon"]) == "1"): ?>checked="checked"<?php endif; ?>
                                            />
                                    <label for="canuse_groupbuy_coupon_yes">可用</label>

                                    <input type="radio" value="0" id="canuse_groupbuy_coupon_no" name="canuse_groupbuy_coupon"
                                    <?php if(($item["canuse_groupbuy_coupon"]) == "0"): ?>checked="checked"<?php endif; ?>
                                            />
                                    <label for="canuse_groupbuy_coupon_no">不可用</label>

                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">成团限制购买次数(0表示不限):</span>
                                    <input type="text" name="canbuy_times" id="canbuy_times" class="form-control col-xs-6"
                                           value="<?php echo ($item["canbuy_times"]); ?>"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">开(参)团掉落组:</span>

                                    <a href="javascript:void(0);" id="b_select_droplist_group_id" class="modals_radio_select md-trigger btn btn-primary"
                                    data-inputId="b_drop_group_id" data-url="/Droplist/selectDroplistGroupJson"
                                    data-title="选择掉落组" data-modal="modal_radio_select">选择掉落组</a>
                                    <input type="text" name="b_drop_group_id" id="b_drop_group_id" class="form-control col-xs-2 modals_radio_select_input"
                                       value="<?php echo ($item["begin_drop_group_id"]); ?>"/>
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">团长是否给开团掉落物品:</span>
                                    <select name="is_begin_give_leader" id="is_begin_give_leader">
                                        <option value="0" <?php if($item["is_begin_give_leader"] == 0): ?>selected="selected"<?php endif; ?> >不给团长</option>
                                        <option value="1" <?php if($item["is_begin_give_leader"] == 1): ?>selected="selected"<?php endif; ?> >不限</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">限制开团次数(0表示不限):</span>
                                    <input type="text" name="canbuy_open_times" id="canbuy_open_times" class="form-control col-xs-1"
                                           value="<?php echo ($item["canbuy_open_times"]); ?>"/>
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">限制参团次数(0表示不限):</span>
                                    <input type="text" name="canbuy_partake_times" id="canbuy_partake_times" class="form-control col-xs-1"
                                       value="<?php echo ($item["canbuy_partake_times"]); ?>"/>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-xs-5">
                                    <span class="label">成团掉落组:</span>

                                    <a href="javascript:void(0);" id="select_droplist_group_id" class="modals_radio_select md-trigger btn btn-primary"
                                       data-inputId="drop_group_id" data-url="/Droplist/selectDroplistGroupJson"
                                       data-title="选择掉落组" data-modal="modal_radio_select">选择掉落组</a>
                                    <input type="text" name="drop_group_id" id="drop_group_id" class="form-control col-xs-3 modals_radio_select_input"
                                           value="<?php echo ($item["drop_group_id"]); ?>"/>
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">成团后领奖掉落组:</span>

                                    <a href="javascript:void(0);" id="after_select_droplist_group_id" class="modals_radio_select md-trigger btn btn-primary"
                                       data-inputId="after_drop_group_id" data-url="/Droplist/selectDroplistGroupJson"
                                       data-title="选择掉落组" data-modal="modal_radio_select">选择掉落组</a>
                                    <input type="text" name="after_drop_group_id" id="after_drop_group_id" class="form-control col-xs-3 modals_radio_select_input"
                                           value="<?php echo ($item["after_drop_group_id"]); ?>"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-12">
                                    优惠券买优惠券-----------------------------------------------------------------------------------
                                    -------------------------------------------------------------------------------------------
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">不成团是否退还优惠券:</span>
                                    <select name="req_return_coupons" id="req_return_coupons">
                                        <option value="0" <?php if($item["req_return_coupons"] == 0): ?>selected="selected"<?php endif; ?> >不退</option>
                                        <option value="1" <?php if($item["req_return_coupons"] == 1): ?>selected="selected"<?php endif; ?> >退</option>
                                    </select>
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">本团是否只能使用优惠券支付:</span>
                                    <select name="only_coupon_pay" id="only_coupon_pay">
                                        <option value="0" <?php if($item["only_coupon_pay"] == 0): ?>selected="selected"<?php endif; ?> >正常支付</option>
                                        <option value="1" <?php if($item["only_coupon_pay"] == 1): ?>selected="selected"<?php endif; ?> >只能使用优惠券支付</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">是否优惠券指定掉落优惠券:</span>
                                    <select name="is_coupons_drop_coupons" id="is_coupons_drop_coupons">
                                        <option value="0" <?php if($item['is_coupons_drop_coupons'] == 0): ?>selected="selected"<?php endif; ?> >否</option>
                                        <option value="1" <?php if($item['is_coupons_drop_coupons'] == 1): ?>selected="selected"<?php endif; ?> >是</option>
                                    </select>
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">指定什么券买，可以产生掉落组是什么</span>
                                    <button id="add_one_c2c_data" type="button" class="btn btn-primary" onclick="addc2cLine()">增加一条券买券数据</button>
                                </div>

                            </div>


                            <div class="row" id="use_coupon_2_coupon" add_line="<?php echo ($c2c_count - 1); ?>">
                                <?php if(is_array($c2c_data)): foreach($c2c_data as $key=>$c2c_item): ?><div class="row coupon2coupon_line">
                                    <div class="form-group col-xs-10">
                                        <span class="">优惠券模板id</span>
                                        <a href="javascript:void(0);"class="modals_radio_select md-trigger btn btn-primary"
                                           data-inputId="use_coupon_tml_id_<?php echo ($key); ?>" data-url="/Droplist/selectJson"
                                           data-title="选择优惠券模板" data-modal="modal_radio_select">选择优惠券模板</a>
                                        <input type="text" name="use_coupon_tml_id[]" class="form-control col-xs-1 modals_radio_select_input" id="use_coupon_tml_id_<?php echo ($key); ?>" value="<?php echo ($c2c_item['coupon_tml_id']); ?>"/>

                                        <span class="label">券买券掉落组:</span>
                                        <a href="javascript:void(0);" class="modals_radio_select md-trigger btn btn-primary"
                                           data-inputId="c2c_drop_group_id_<?php echo ($key); ?>" data-url="/Droplist/selectDroplistGroupJson"
                                           data-title="选择掉落组" data-modal="modal_radio_select">选择掉落组</a>
                                        <input type="text" name="c2c_drop_group_id[]" id="c2c_drop_group_id_<?php echo ($key); ?>" class="form-control col-xs-1 modals_radio_select_input"
                                               value="<?php echo ($c2c_item['drop_group_id']); ?>"/>
                                    </div>
                                </div><?php endforeach; endif; ?>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-12">
                                    抽奖及助力参数-----------------------------------------------------------------------------------
                                    -------------------------------------------------------------------------------------------
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-3">
                                    <span class="label">从团中抽取几人发货:</span>
                                    <input type="text" name="systemauto_choose_num" id="systemauto_choose_num" class="form-control col-xs-2"
                                           value="<?php echo ($item["systemauto_choose_num"]); ?>"/>
                                </div>
                                <div class="form-group col-xs-3">
                                    <span class="label">是否团长必中:</span>
                                    <input type="text" name="systemauto_choose_leader_must" id="systemauto_choose_leader_must" class="form-control col-xs-2"
                                           value="<?php echo ($item["systemauto_choose_leader_must"]); ?>"/>
                                </div>
                                <div class="form-group col-xs-4">
                                    <span class="label">成团不中奖是否退款（0不退，1退）:</span>
                                    <input type="text" name="systemauto_is_succ_nowin_refund" id="systemauto_is_succ_nowin_refund" class="form-control col-xs-2"
                                           value="<?php echo ($item["systemauto_is_succ_nowin_refund"]); ?>"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">成团后多久结算（秒：0表示立即）:</span>
                                    <input type="text" name="systemauto_opentime_after_succ" id="systemauto_opentime_after_succ" class="form-control col-xs-2"
                                           value="<?php echo ($item["systemauto_opentime_after_succ"]); ?>"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">团员价格是否和团长一致:</span>
                                    <select name="ismemberprice_diff" id="ismemberprice_diff">
                                        <option value="0" <?php if($item["ismemberprice_diff"] == 0): ?>selected="selected"<?php endif; ?> >不一致</option>
                                        <option value="1" <?php if($item["ismemberprice_diff"] == 1): ?>selected="selected"<?php endif; ?> >一致</option>
                                    </select>
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">不一致时价格是多少:</span>
                                    <input type="text" name="member_price" id="member_price" class="form-control col-xs-2"
                                           value="<?php echo ($item["member_price"]); ?>"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">参团是否需要生成订单:</span>
                                    <select name="is_join_create_order" id="is_join_create_order">
                                        <option value="0" <?php if($item["is_join_create_order"] == 0): ?>selected="selected"<?php endif; ?> >不生成</option>
                                        <option value="1" <?php if($item["is_join_create_order"] == 1): ?>selected="selected"<?php endif; ?> >生成</option>
                                    </select>
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">团类型:</span>
                                    <select name="groupbuy_type" id="groupbuy_type">
                                        <option value="0" <?php if($item["groupbuy_type"] == 0): ?>selected="selected"<?php endif; ?> >普通拼团</option>
                                        <option value="1" <?php if($item["groupbuy_type"] == 1): ?>selected="selected"<?php endif; ?> >助力团</option>
                                        <option value="2" <?php if($item["groupbuy_type"] == 2): ?>selected="selected"<?php endif; ?> >集中抽奖团</option>
                                        <option value="3" <?php if($item["groupbuy_type"] == 3): ?>selected="selected"<?php endif; ?> >掉落抽奖团</option>
                                        <option value="4" <?php if($item["groupbuy_type"] == 4): ?>selected="selected"<?php endif; ?> >拼星星团</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-xs-12">
                                    微信二维码参数-------------------------------------------------------------------------------
                                    -------------------------------------------------------------------------------------------
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-4">
                                    <span class="label">二维码开始id:</span>
                                    <input type="text" name="wx_erweima_id_start" id="wx_erweima_id_start" class="form-control col-xs-2"
                                           value="<?php echo ($item["wx_erweima_id_start"]); ?>"/>
                                </div>
                                <div class="form-group col-xs-4">
                                    <span class="label">二维码结束id:</span>
                                    <input type="text" name="wx_erweima_id_end" id="wx_erweima_id_end" class="form-control col-xs-2"
                                           value="<?php echo ($item["wx_erweima_id_end"]); ?>"/>
                                </div>
                                <div class="form-group col-xs-4">
                                    <span class="label">二维码现在id:</span>
                                    <input type="text" name="wx_erweima_id_now" id="wx_erweima_id_now" class="form-control col-xs-2"
                                           value="<?php echo ($item["wx_erweima_id_now"]); ?>"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    系统开团参数-------------------------------------------------------------------------------
                                    -------------------------------------------------------------------------------------------
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">开团类型:</span>
                                    <!--0无其它条件，1分享到朋友圈，2会员等级-->
                                    <select name="groupbuyopen_type" id="groupbuyopen_type">
                                        <option value="0" <?php if($item["opentype"] == 0): ?>selected<?php endif; ?> >用户开团(系统开团的内容都不用填)</option>
                                        <option value="1" <?php if($item["opentype"] == 1): ?>selected<?php endif; ?> >系统开团</option>
                                    </select>
                                </div>

                                <div class="form-group col-xs-5">
                                    <span class="label">系统开团类型:</span>
                                    <!--0一次性开团，1每天开团，2每周开团，3每月开团，4系统开团直到团结束才继续开下一团-->
                                    <select name="systemauto_opentype" id="systemauto_opentype">
                                        <option value="0" <?php if($item["systemauto_opentype"] == 0): ?>selected<?php endif; ?> >一次性开团（适用于定时活动）</option>
                                        <option value="1" <?php if($item["systemauto_opentype"] == 1): ?>selected<?php endif; ?> >每天开团（适用于每天的系统团）</option>
                                        <option value="2" <?php if($item["systemauto_opentype"] == 2): ?>selected<?php endif; ?> >每周开团</option>
                                        <option value="3" <?php if($item["systemauto_opentype"] == 3): ?>selected<?php endif; ?> >每月开团</option>
                                        <option value="4" <?php if($item["systemauto_opentype"] == 4): ?>selected<?php endif; ?> >系统开团，直到团结束才继续开下一团</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-3">
                                    <span class="label">系统开团-每天几点开团:</span>
                                    <input type="text" name="systemauto_day_time" id="systemauto_day_time" class="form-control col-xs-2"
                                           value="<?php echo ($item["systemauto_day_time"]); ?>"/>
                                </div>
                                <div class="form-group col-xs-3">
                                    <span class="label">系统开团-每周开团是周几:</span>
                                    <input type="text" name="systemauto_week_time" id="systemauto_week_time" class="form-control col-xs-2"
                                           value="<?php echo ($item["systemauto_week_time"]); ?>"/>
                                </div>

                                <div class="form-group col-xs-3">
                                    <span class="label">系统开团-每月开团是几号:</span>
                                    <input type="text" name="systemauto_mouth_time" id="systemauto_mouth_time" class="form-control col-xs-2"
                                           value="<?php echo ($item["systemauto_mouth_time"]); ?>"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-12">
                                    老带新参数---------------------------------------------------------------------------------
                                    -------------------------------------------------------------------------------------------
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-3">
                                    <span class="label">是否老带新团:</span>
                                    <!--0无其它条件，1分享到朋友圈，2会员等级-->
                                    <select name="is_olduser_bring_new" id="is_olduser_bring_new">
                                        <option value="0" <?php if($item["is_olduser_bring_new"] == 0): ?>selected<?php endif; ?> >否</option>
                                        <option value="1" <?php if($item["is_olduser_bring_new"] == 1): ?>selected<?php endif; ?> >是</option>
                                    </select>
                                </div>

                                <div class="form-group col-xs-3">
                                    <span class="label">允许几名老用户:</span>
                                    <input type="text" name="old_user_num" id="old_user_num" class="form-control col-xs-2"
                                           value="<?php echo ($item["old_user_num"]); ?>"/>
                                </div>
                                <div class="form-group col-xs-3">
                                    <span class="label">允许几名新用户:</span>
                                    <input type="text" name="new_user_num" id="new_user_num" class="form-control col-xs-2"
                                           value="<?php echo ($item["new_user_num"]); ?>"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <span class="label">老用户类型:</span>
                                    <!--0无其它条件，1分享到朋友圈，2会员等级-->
                                    <select name="old_user_type" id="old_user_type">
                                        <option value="0" <?php if($item["old_user_type"] == 0): ?>selected<?php endif; ?> >购买过任意一款商品</option>
                                        <option value="1" <?php if($item["old_user_type"] == 1): ?>selected<?php endif; ?> >购买用受限商品</option>
                                        <option value="2" <?php if($item["old_user_type"] == 2): ?>selected<?php endif; ?> >购买过指定tmlid的</option>
                                    </select>
                                </div>

                                <div class="form-group col-xs-10">
                                    <span class="label">指定tmlid为老用户（英文“,”分隔）:</span>
                                    <input type="text" name="old_user_tmlids" id="old_user_tmlids" class="form-control col-xs-6"
                                           value="<?php echo ($item["old_user_tmlids"]); ?>"/>
                                </div>
                            </div>


                            <input type="hidden" value="<?php echo ($item["id"]); ?>" name="id" />

                            <div class="modal-footer">
                                <button id="form_save" class="btn btn-primary" >保存</button>
                            </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<div id="config-tool" class="closed">
    <a id="config-tool-cog">
        <i class="fa fa-cog"></i>
    </a>

    <div id="config-tool-options">
        <h4>Layout Options</h4>
        <ul>
            <li>
                <div class="checkbox-nice">
                    <input type="checkbox" id="config-fixed-header"/>
                    <label for="config-fixed-header">
                        Fixed Header
                    </label>
                </div>
            </li>
            <li>
                <div class="checkbox-nice">
                    <input type="checkbox" id="config-fixed-sidebar"/>
                    <label for="config-fixed-sidebar">
                        Fixed Left Menu
                    </label>
                </div>
            </li>
            <li>
                <div class="checkbox-nice">
                    <input type="checkbox" id="config-fixed-footer"/>
                    <label for="config-fixed-footer">
                        Fixed Footer
                    </label>
                </div>
            </li>
            <li>
                <div class="checkbox-nice">
                    <input type="checkbox" id="config-boxed-layout"/>
                    <label for="config-boxed-layout">
                        Boxed Layout
                    </label>
                </div>
            </li>
            <li>
                <div class="checkbox-nice">
                    <input type="checkbox" id="config-rtl-layout"/>
                    <label for="config-rtl-layout">
                        Right-to-Left
                    </label>
                </div>
            </li>
        </ul>
        <br/>
        <h4>Skin Color</h4>
        <ul id="skin-colors" class="clearfix">
            <li>
                <a class="skin-changer" data-skin="" data-toggle="tooltip" title="Default" style="background-color: #34495e;">
                </a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-white" data-toggle="tooltip" title="White/Green" style="background-color: #2ecc71;">
                </a>
            </li>
            <li>
                <a class="skin-changer blue-gradient" data-skin="theme-blue-gradient" data-toggle="tooltip" title="Gradient">
                </a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-turquoise" data-toggle="tooltip" title="Green Sea" style="background-color: #1abc9c;">
                </a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-amethyst" data-toggle="tooltip" title="Amethyst" style="background-color: #9b59b6;">
                </a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-blue" data-toggle="tooltip" title="Blue" style="background-color: #2980b9;">
                </a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-red" data-toggle="tooltip" title="Red" style="background-color: #e74c3c;">
                </a>
            </li>
            <li>
                <a class="skin-changer" data-skin="theme-whbl" data-toggle="tooltip" title="White/Blue" style="background-color: #3498db;">
                </a>
            </li>
        </ul>
    </div>
</div>


</div>

<div id="modal_radio_select" class="md-modal md-effect-1">
    <div class="md-content">
        <div class="modal-header">
            <button class="md-close close">×</button>
            <h4 class="modal-title">弹出框标题</h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <button class="btn btn-default" type="button" id="modal_radio_select_cancel">取消</button>
            <button class="btn btn-primary" type="button" id="modal_radio_select_confirm" data-inputId="">确定</button>
        </div>
    </div>
</div>
<div class="md-overlay" id="md-overlay"></div>

<script src="__PUBLIC__/admin/v3/js/demo-skin-changer.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery.js"></script>
<script src="__PUBLIC__/admin/v3/js/bootstrap.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery.nanoscroller.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/demo.js"></script>

<script src="__PUBLIC__/admin/v3/js/jquery.dataTables.js"></script>
<script src="__PUBLIC__/admin/v3/js/dataTables.fixedHeader.js"></script>
<script src="__PUBLIC__/admin/v3/js/dataTables.tableTools.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery.dataTables.bootstrap.js"></script>

<script src="__PUBLIC__/admin/v3/js/scripts.js"></script>
<script src="__PUBLIC__/admin/v3/js/pace.min.js"></script>


<!--模态弹出框专属-->
<script src="__PUBLIC__/admin/v3/js/modernizr.custom.js"></script>
<script src="__PUBLIC__/admin/v3/js/classie.js"></script>
<script src="__PUBLIC__/admin/v3/js/modalEffects.js"></script>

<script src="__PUBLIC__/admin/v3/js/shipinmmm/modals-select.js" type="text/javascript"></script>

<!--时期时间选择器-->
<script src="__PUBLIC__/admin/v3/js/bootstrap-datepicker.js"></script>
<script src="__PUBLIC__/admin/v3/js/moment.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/daterangepicker.js" type="text/javascript"></script>
<script src="__PUBLIC__/admin/v3/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

<script type="text/javascript">

    function addc2cLine()
    {
        var parentNode = $('#use_coupon_2_coupon');
        var vline_num = parseInt(parentNode.attr("add_line"))+1;
        parentNode.attr("add_line",vline_num);
        var src  = '<div class="row coupon2coupon_line">'+
                '<div class="form-group col-xs-10">'+
                '<span class="">优惠券模板id</span>'+
                '<a href="javascript:void(0);"class="modals_radio_select md-trigger btn btn-primary" '+
                'data-inputId="use_coupon_tml_id_'+vline_num+'" data-url="/Droplist/selectJson" '+
                'data-title="选择优惠券模板" data-modal="modal_radio_select">选择优惠券模板</a>'+
                '<input type="text" name="use_coupon_tml_id[]" class="form-control col-xs-1 modals_radio_select_input" id="use_coupon_tml_id_'+vline_num+'"/>'+

                '<span class="label">券买券掉落组:</span>'+
                '<a href="javascript:void(0);" class="modals_radio_select md-trigger btn btn-primary" '+
                'data-inputId="c2c_drop_group_id_'+vline_num+'" data-url="/Droplist/selectDroplistGroupJson" '+
                'data-title="选择掉落组" data-modal="modal_radio_select">选择掉落组</a>'+
                '<input type="text" name="c2c_drop_group_id[]" id="c2c_drop_group_id_'+vline_num+'" class="form-control col-xs-1 modals_radio_select_input" value=""/>'+
                '</div>'+
                '</div>';
        parentNode.append(src);

        mModalEffect();
        modals_select_datalink();
    }

$(function($){
    $('#goods_id').on('blur', function(){
        var _this = $(this);
        var url = "<?php echo U('Product/getProductInfo');?>";
        var data = {product_id : _this.val()};
        $.get(url, data, function(data){
            $('#goods_name').html(data.product_name);
            $('#old_price').html(data.product_price[0].old_price);
        }, 'json');
    });

    //日期选择器
//datepicker
    $('#begin_selltime_date').datepicker({
        format: 'yyyy-mm-dd',
        weekStart: 1,
        startDate:new Date(), //开始时间，在这时间之前都不可选
        autoclose: true,
        todayBtn: 'linked',
        language: 'zh-CN'
    });

//daterange picker
    $('#datepickerDateRange').daterangepicker();

//timepicker
    $('.timepicker').timepicker({
        minuteStep: 5,
        showSeconds: true,
        showMeridian: false,
        disableFocus: false,
        showWidget: true
    }).focus(function() {
        $(this).next().trigger('click');
    });

});
</script>
</body>
</html>