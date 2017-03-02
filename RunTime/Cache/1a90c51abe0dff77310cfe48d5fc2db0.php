<?php if (!defined('THINK_PATH')) exit();?><style>
    #order_time_type{width:150px;text-align:center;position:absolute;top:-8px;left:84px;}
    #order_status_sel,#send_channel{width:150px;text-align:center;}
    .order_status{color:#fff;width:100%;height:30px;line-height:30px;font-weight:bold;border-radius:3px;display:block;}
    .from{width:330px;position:absolute;top:-10px;left:-10px;}
    .to{width:330px;position:absolute;top:-10px;left:345px;}
    .time_to{width:150px !important; }
    .status_order_name{position:absolute;}
    .short_name{height:22px;min-width:60px;text-align:center;border-radius:3px;background-color:#e74c3c;color:#fff;line-height:22px;display:inline-block;}
</style>
<!DOCTYPE html>
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
<div id="theme-wrapper">

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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <ol class="breadcrumb">
                                    <li><a href="#">首页</a></li>
                                    <li class="active"><span>订单管理</span></li>
                                </ol>
                                <h1>Advanced tables</h1>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-box clearfix">
                                    <header class="main-box-header clearfix">
                                        <h2>订单列表</h2>
                                        <div class="main-box-header-act">
                                            <button class="md-trigger btn btn-primary mrg-b-lg" data-modal="export_order_dialog"
                                                    id="export_order_btn">导出订单
                                            </button>
                                            <button class="md-trigger btn btn-primary mrg-b-lg" data-modal="create_out_storage_dialog"
                                                    id="create_out_storage_btn">生成出库单
                                            </button>
                                            <button class="md-trigger btn btn-primary mrg-b-lg" data-modal="create_pick_up_goods_dialog"
                                                    id="create_pick_up_goods_btn">生成捡货单
                                            </button>
                                            <button class=" btn btn-primary mrg-b-lg" id="order_refund_btn">退款</button>

                                            <a href="http://v1manage.shipinmmm.com/Jd/sendWayBill" class="btn btn-primary mrg-b-lg" target="_blank">生成京东快递单</a>

                                            <button class="md-trigger btn btn-primary mrg-b-lg" data-modal="merge_delivery_dialog"
                                                    id="merge_delivery">合并发货
                                            </button>
                                        </div>

                                        <form action="/index.php?m=Order&a=index" method="post" target="_self" role="form">
                                        <div class="row" style="margin-bottom:60px;">

                                            <div class="form-group col-md-3" style="width:300px;">
                                                <label for="order_time_type" style="font-size:13px;display:block;width:100px;margin-left:10px;">查询时间：</label>
                                                <select  id="order_time_type" class="form-control" name="order_time_type" style="margin-bottom:5px;">
                                                    <option value="0" <?php if($timetype == 0): ?>selected<?php endif; ?> >按下单时间查询</option>
                                                    <option value="1" <?php if($timetype == 1): ?>selected<?php endif; ?> >按最后修改时间查询</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2" >
                                                <div class="row from">
                                                    <div class="form-group col-md-5">
                                                        <label for="datepickerDateFrom" class="form-inline-label" style="float:left;line-height:30px;">从：</label>
                                                        <div class="input-group form-inline-input-group w150" style="margin-bottom:5px;float:left;">
                                                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                                            <input type="text" id="datepickerDateFrom" class="form-control" name="limit_date_From" value="<?php echo ($limit_date_From); ?>">
                                                        </div>

                                                        <div class="input-group input-append bootstrap-timepicker w150 time_to" style="float:right;margin-right:-28px;">
                                                            <input type="text" class="form-control timepicker" id="timepicker_From" name="limit_time_From"
                                                                   value="<?php echo ($limit_time_From); ?>" />
                                                            <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row to">
                                                   <div class="form-group col-md-5">
                                                        <label for="datepickerDateTo" class="form-inline-label" style="float:left;line-height:30px;">到：</label>
                                                        <div class="input-group form-inline-input-group w150" style="margin-bottom:5px;float:left;">
                                                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                                            <input type="text" id="datepickerDateTo" class="form-control" name="limit_date_To" value="<?php echo ($limit_date_To); ?>">
                                                        </div>

                                                        <div class="input-group input-append bootstrap-timepicker w150 time_to" style="float:right;margin-right:-28px;">
                                                            <input type="text" class="form-control timepicker" id="timepicker_To" name="limit_time_To"
                                                                   value="<?php echo ($limit_time_To); ?>" />
                                                            <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <!--<div class="form-group col-md-3 w370">-->
                                                <!--<label for="rec_phone" class="form-inline-label">手机号码：</label>-->
                                                <!--<input type="text" id="rec_phone" name="rec_phone" class="form-control w150 form-inline-input-group" value="<?php echo ($rec_phone); ?>" />-->
                                            <!--</div>-->


                                            <div class="form-group col-md-3 w370">
                                                <label for="delivery_id" class="form-inline-label">运单号码：</label>
                                                <input type="text" id="delivery_id" name="delivery_id" class="form-control w150 form-inline-input-group" value="<?php echo ($delivery_id); ?>" />

                                            </div>

                                            <div class="form-group col-md-3 w370">
                                                <label for="groupbuy_order_name" class="form-inline-label">团单号码：</label>
                                                <input type="text" id="groupbuy_order_name" name="groupbuy_order_name" class="form-control w150 form-inline-input-group" value="<?php echo ($groupbuy_order_name); ?>" />

                                            </div>
                                            <!--<div class="form-group col-md-3 w370">-->
                                                <!--<label for="out_bill_id" class="form-inline-label">外部支付：</label>-->
                                                <!--<input type="text" id="out_bill_id" name="out_bill_id" class="form-control w150 form-inline-input-group" value="<?php echo ($out_bill_id); ?>" />-->

                                            <!--</div>-->


                                            </div>
                                            <div class="row">

                                            <div class="form-group col-md-3 w370">
                                                <label for="order_name" class="form-inline-label">订单号码：</label>
                                                <input type="text" id="order_name" name="order_name" class="form-control w150 form-inline-input-group" value="<?php echo ($order_name); ?>" />
                                            </div>

                                            <div class="form-group col-md-3 w370">
                                                <label for="money" class="form-inline-label">订单金额：</label>
                                                <input type="text" id="money" name="money" class="form-control w150 form-inline-input-group" value="<?php echo ($request["money"]); ?>" />
                                            </div>

                                            <div class="form-group col-md-3 w370">
                                                <label for="pay_status" class="form-inline-label">支付状态：</label>
                                                <select name="pay_status" id="pay_status">
                                                    <option value="1" <?php if($request["pay_status"] == 1): ?>selected<?php endif; ?>>已支付</option>
                                                    <option value="0">未支付</option>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <div class="form-group col-md-3 w370">
                                                <label for="order_status_sel" class="form-inline-label">订单状态：</label>
                                                <select  id="order_status_sel" class="form-control w100 form-inline-input-group" name="order_status_sel">
                                                    <?php if(is_array($manage_order_status)): foreach($manage_order_status as $key=>$item): ?><option value="<?php echo ($key); ?>" <?php if($key == $order_status_sel): ?>selected<?php endif; ?>>------<?php echo ($item); ?>------</option><?php endforeach; endif; ?>
                                                </select>
                                            </div>
                                                <div class="form-group col-md-3 w370">
                                                    <label for="short_name" class="form-inline-label">选择分站：</label>
                                                    <select  id="short_name" class="form-control w150 form-inline-input-group text-center" name="short_name">
                                                        <option value="">---请选择分站---</option>
                                                        <?php if(is_array($distributor_list)): foreach($distributor_list as $key=>$distributor): ?><option value="<?php echo ($distributor["name"]); ?>" <?php if(($short_name) == $distributor["name"]): ?>selected="selected"<?php endif; ?> >------<?php echo ($distributor["short_name"]); ?>------</option><?php endforeach; endif; ?>
                                                    </select>
                                                </div>

                                                <!--<div class="form-group col-md-3 w370">-->
                                                    <!--<label for="send_channel" class="form-inline-label">发货渠道：</label>-->
                                                    <!--<select  id="send_channel" class="form-control w150 form-inline-input-group" name="send_channel">-->
                                                        <!--<option value="">-请选择发货渠道-</option>-->

                                                        <!--<?php if(is_array($supply_list)): foreach($supply_list as $key=>$supply): ?>-->
                                                            <!--<option value="<?php echo ($supply["name"]); ?>" <?php if(($send_channel) == $supply["name"]): ?>selected="selected"<?php endif; ?> >-&#45;&#45;&#45;&#45;<?php echo ($supply["real_name"]); ?>-&#45;&#45;&#45;&#45;</option>-->
                                                        <!--<?php endforeach; endif; ?>-->
                                                    <!--</select>-->
                                                <!--</div>-->



                                            <div class="form-group col-md-2">
                                                <button id="sift_orders" type="submit"  class=" btn btn-primary mrg-b-lg">搜索</button>
                                            </div>
                                        </div>
                                        </form>

                                    </header>

                                    <div class="main-box-body clearfix">
                                        <div class="table-responsive">
                                            <table id="table-example-fixed" class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="check_all"/>选择</th>
                                                    <th>商品</th>
                                                    <th>单价/数量</th>
                                                    <th>导出状态</th>
                                                    <th>售后</th>
                                                    <th>买家</th>
                                                    <th>下单时间</th>
                                                    <th>订单状态</th>
                                                    <th>实付金额</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(is_array($ordersInfo)): foreach($ordersInfo as $key=>$order): $key = $key+1; ?>
                                                    <tbody id="tb_<?php echo ($order["order_name"]); ?>" data-id="<?php echo ($order["order_name"]); ?>" class="orderItem">
<tr>
    <td colspan="9">
        <table width="100%">
            <tr>
                <td colspan="7">
                    <input type="checkbox" name="check_order[]" value="<?php echo ($order["order_name"]); ?>" class="checkOrder" />
                    订单号:     <?php echo ($order["order_name"]); ?>
                    <?php if(($order["groupbuy_order_name"]) != ""): ?><span>团单号：<a href="<?php echo U('GroupBuyingOrder/groupSearch');?>&groupbuy_order_name=<?php echo ($order["groupbuy_order_name"]); ?>"><?php echo ($order["groupbuy_order_name"]); ?></a></span><?php endif; ?>

                    <span><?php echo ($order["pay_name"]); ?>&nbsp;&nbsp;<?php echo ($order["pay_status_name"]); ?></span>&nbsp;&nbsp;<?php echo ($order["shipping_name"]); ?>&nbsp;&nbsp;<?php echo ($order["delivery_id"]); ?>&nbsp;&nbsp;<?php if($order["short_name"] != '' ): ?>分站: <span class="short_name"><?php echo ($order["short_name"]); ?></span><?php endif; ?></td>
                <td colspan="2"><a href="<?php echo U('Order/detail');?>&order_name=<?php echo ($order["order_name"]); ?>" target="_blank">查看详情</a> <a href="">备注</a></td>
            </tr>
            <?php if(is_array($order["order_product"])): foreach($order["order_product"] as $productKey=>$product): ?><tr>
                    <td></td>
                    <td><img src="<?php echo ($product["thum_min_photo"]); ?>" alt="<?php echo ($product["product_name"]); ?>" width="45"></td>
                    <td><?php echo ($product["price"]); ?> x <?php echo ($product["qty"]); ?></td>
                    <?php if($productKey == 0): ?><td rowspan="<?php echo ($order["order_product_num"]); ?>">
                            <?php if(($order["has_export"] == 1) ): ?><span class="f_gre">已导出</span>
                                <?php else: ?>
                                <span class="f_red">未导出</span><?php endif; ?>
                        </td>
                        <td rowspan="<?php echo ($order["order_product_num"]); ?>">用户id: <?php echo ($order["uid"]); ?></td>
                        <td rowspan="<?php echo ($order["order_product_num"]); ?>"><?php echo ($order["username"]); ?></td>
                        <td rowspan="<?php echo ($order["order_product_num"]); ?>"><?php echo ($order["time"]); ?> <br/> 最后更新: <span class="green"><?php echo ($order["last_modify_time"]); ?></span></td>
                        <td rowspan="<?php echo ($order["order_product_num"]); ?>">
                            <?php echo ($order["order_status_name"]); ?>

                            <div  class="orderStatus">订单操作
                                <ul class="actionStatus" style="display: none;">
                                    <?php if(is_array($order["action_button"])): foreach($order["action_button"] as $key=>$act): ?><li><a href="javascript:void(0);" data-id="<?php echo ($act["act"]); ?>"><?php echo ($act["label"]); ?></a></li><?php endforeach; endif; ?>
                                </ul>
                            </div>
                        </td>
                        <td><?php echo ($order["money"]); ?></td><?php endif; ?>
                </tr><?php endforeach; endif; ?>

            <tr>
                <td colspan="9">收件人： <?php echo ($order["name"]); ?>  <?php echo ($order["mobile"]); ?>  送货时间：<?php echo ($order["shtime"]); ?><br/>收货地址：<?php echo ($order["address"]); ?></td>
            </tr>

        </table>



    </td>
</tr>
<td>
    <a href="/index.php?m=Order&a=editOrderInfo&id=<?php echo ($order["id"]); ?>"> 修改收件人信息</a>
</td>
</tbody><?php endforeach; endif; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="page">
                                        <?php echo ($page); ?>
                                    </div> 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <footer id="footer-bar" class="row">
                    <p id="footer-copyright" class="col-xs-12">
                        &copy; 2014 <a href="http://www.adbee.sk/" target="_blank">Adbee digital</a>. Powered by Centaurus Theme.
                    </p>
                </footer>
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

<div class="md-modal md-effect-1" id="export_order_dialog">
    <div class="md-content">
        <div class="modal-header">
            <button class="md-close close">&times;</button>
            <h4 class="modal-title">导出订单</h4>
        </div>
        <form action="/index.php?m=order&a=exportOrder" method="post" role="form">
            <div class="modal-body">
                <!--<select name="export_type" id="export_order_type">-->
                    <!--<option value="1">未导出过的新订单</option>-->
                    <!--<option value="2">选中的订单</option>-->
                <!--</select>-->
                <div class="row">

                    <div class="form-group col-md-3">
                        <label for="order_export_time_type">查询时间</label>
                        <select  id="order_export_time_type" class="form-control" name="order_export_time_type">
                            <option value="0" <?php if($order_export_time_type == 0): ?>selected<?php endif; ?> >按下单时间查询</option>
                            <option value="1" <?php if($order_export_time_type == 1): ?>selected<?php endif; ?> >按最后修改时间查询</option>
                        </select>
                    </div>

                    <div class="form-group col-md-7">
                        <label for="datepickerDate_export_From" class="form-inline-label">从：</label>
                        <div class="input-group form-inline-input-group w150">
                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                            <input type="text" id="datepickerDate_export_From" class="form-control" name="limit_date_export_From" value="">
                        </div>

                        <div class="input-group input-append bootstrap-timepicker" style="width: 150px; float: right;">
                            <input type="text" class="form-control timepicker" id="timepicker_export_From" name="limit_time_export_From"
                                   value="" />
                            <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="form-group col-md-7">
                        <label for="datepickerDate_export_To" class="form-inline-label">到：</label>
                        <div class="input-group form-inline-input-group w150">
                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                            <input type="text" id="datepickerDate_export_To" class="form-control" name="limit_date_export_To" value="">
                        </div>

                        <div class="input-group input-append bootstrap-timepicker" style="width: 150px; float: right;">
                            <input type="text" class="form-control timepicker" id="timepicker_export_To" name="limit_time_export_To"
                                   value="" />
                            <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                        </div>
                </div>
                </div>
                <div class="row">

                <div class="form-group col-md-2">
                    <label for="order_status_sel_export" class="form-inline-label">订单状态：</label>
                    <select  id="order_status_sel_export" class="form-control w100 form-inline-input-group" name="order_status_sel">
                        <?php if(is_array($manage_order_status)): foreach($manage_order_status as $key=>$item): ?><option value="<?php echo ($key); ?>" ><?php echo ($item); ?></option><?php endforeach; endif; ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="send_channel_export" class="form-inline-label">发货渠道：</label>
                    <select  id="send_channel_export" class="form-control w100 form-inline-input-group" name="send_channel">
                        <option value="">请选择</option>
                        <?php if(is_array($supply_list)): foreach($supply_list as $key=>$supply): ?><option value="<?php echo ($supply["name"]); ?>"
                            <?php if(($send_channel) == $supply["name"]): ?>selected="selected"<?php endif; ?>
                            ><?php echo ($supply["real_name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="export_type" class="form-inline-label">导出类型：</label>
                    <select  id="export_type" class="form-control w100 form-inline-input-group" name="export_type">
                        <option value="">请选择</option>
                        <option value="1">快递格式</option>
                        <option value="2">生产出库单</option>
                    </select>
                </div>

            </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="do_export_order_btn">导出</button>
            </div>

        </form>
    </div>
</div>


<div class="md-modal md-effect-1" id="create_out_storage_dialog">
    <div class="md-content">
        <div class="modal-header">
            <button class="md-close close">&times;</button>
            <h4 class="modal-title">生成出库单</h4>
        </div>
        <form action="/index.php?m=OutStorage&a=createOutStorageBill" method="post" target="_blank" role="form">
            <div class="modal-body">

                <select name="create_out_storage_order" id="create_out_storage_order">
                    <option value="1">未生成过的新订单</option>
                    <option value="2">选中的订单</option>
                    <option value="3">部分发货的订单</option>
                </select>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">生成出库单</button>
            </div>
        </form>
    </div>
</div>

<div class="md-modal md-effect-1" id="create_pick_up_goods_dialog">
    <div class="md-content">
        <div class="modal-header">
            <button class="md-close close">&times;</button>
            <h4 class="modal-title">生成捡货单</h4>
        </div>
        <form action="/index.php?m=OutStorage&a=createPickUpGoodsBill" method="post" target="_blank" role="form">
            <div class="modal-body">

                <select name="create_pick_up_goods_order" id="create_pick_up_goods_order">
                    <option value="1">未生成过的新订单</option>
                    <option value="2">选中的订单</option>
                    <option value="3">部分发货的订单</option>
                </select>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">生成捡货单</button>
            </div>
        </form>
    </div>
</div>

<!--合并发货-->
<div class="md-modal md-effect-3" id="merge_delivery_dialog">
    <div class="md-content">
        <div class="modal-header">
            <button class="md-close close">&times;</button>
            <h4 class="modal-title">合并发货</h4>
        </div>
        <div class="modal-body">
            <form role="form">
                <div class="form-group">
                    <label for="sel_delivery_company">选择快递公司</label>
                    <select name="sel_delivery_company" id="sel_delivery_company">
                        <option value="0">请选择</option>
                        <option value="jd_delivery">京东快递</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="used_delivery_id">快递单号</label>
                    <input type="text" class="form-control" id="used_delivery_id" >
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save_merge_delivery">确定</button>
        </div>
    </div>
</div>




<div id="sendGoodsWin" style="display: none;">
</div>


<div class="md-overlay">
</div>


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
<script src="__PUBLIC__/admin/v3/js/shipinmmm/orders.js"></script>

<!--时期时间选择器-->
<script src="__PUBLIC__/admin/v3/js/bootstrap-datepicker.js"></script>
<script src="__PUBLIC__/admin/v3/js/moment.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/daterangepicker.js" type="text/javascript"></script>
<script src="__PUBLIC__/admin/v3/js/bootstrap-timepicker.min.js" type="text/javascript"></script>


<script>
    $(function($){
        initOrder();

        //批量选择表单
        $('#check_all').on('change', function(){
            var is_checked = document.getElementById("check_all").checked;
            if(is_checked){
                $('.checkOrder').prop('checked', true);
            } else {
                $('.checkOrder').prop('checked', false);
            }
        });

        $('#order_refund_btn').on('click', function(){

            if(confirm('您确定要退款吗？')){
                var checkedOrders = [];
                $('.checkOrder:checked').each(function(){
                    checkedOrders.push($(this).val());
                });
                if(checkedOrders.length > 0){
                    var data = {order_names: checkedOrders.join(',')};
                    var url = '/Order/orderRefund';
                    $.get(url, data, function(result){
                        var msg = '';
                        for(var i=0; i < result.length; i++){
                            msg += result[i]['order_name'] + '=' + result[i]['msg'] + ' ';
                        }

                        alert(msg);
                    }, 'json');
                }
            }else{
                return false;
            }
        });

        //picker
        $('#datepickerDateFrom').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            autoclose: true,
            todayBtn: 'linked',
            language: 'zh-CN'
        });

        //timepicker
        $('#timepicker_From').timepicker({
            minuteStep: 5,
            showSeconds: true,
            showMeridian: false,
            disableFocus: false,
            showWidget: true
        }).focus(function() {
            $(this).next().trigger('click');
        });

        //picker
        $('#datepickerDateTo').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            autoclose: true,
            todayBtn: 'linked',
            language: 'zh-CN'
        });

        //timepicker
        $('#timepicker_To').timepicker({
            minuteStep: 5,
            showSeconds: true,
            showMeridian: false,
            disableFocus: false,
            showWidget: true
        }).focus(function() {
            $(this).next().trigger('click');
        });


        //picker
        $('#datepickerDate_export_From').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            autoclose: true,
            todayBtn: 'linked',
            language: 'zh-CN'
        });

        //timepicker
        $('#timepicker_export_From').timepicker({
            minuteStep: 5,
            showSeconds: true,
            showMeridian: false,
            disableFocus: false,
            showWidget: true
        }).focus(function() {
            $(this).next().trigger('click');
        });
        //picker
        $('#datepickerDate_export_To').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            autoclose: true,
            todayBtn: 'linked',
            language: 'zh-CN'
        });

        //timepicker
        $('#timepicker_export_To').timepicker({
            minuteStep: 5,
            showSeconds: true,
            showMeridian: false,
            disableFocus: false,
            showWidget: true
        }).focus(function() {
            $(this).next().trigger('click');
        });

        $("#page :last").addClass("last_page");

    });
//    $(document).ready(function () {
//        var table = $('#table-example').dataTable({
//            'info': false,
//            'sDom': 'lTfr<"clearfix">tip',
//            'oTableTools': {
//                'aButtons': [
//                    {
//                        'sExtends': 'collection',
//                        'sButtonText': '<i class="fa fa-cloud-download"></i>&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i>',
//                        'aButtons': ['csv', 'xls', 'pdf', 'copy', 'print']
//                    }
//                ]
//            }
//        });
//
//        //var tt = new $.fn.dataTable.TableTools( table );
//        //$( tt.fnContainer() ).insertBefore('div.dataTables_wrapper');
//
//        var tableFixed = $('#table-example-fixed').dataTable({
//            'info': false,
//            'pageLength': 50
//        });
//
//        new $.fn.dataTable.FixedHeader(tableFixed);
//    });
</script>
</body>
</html>