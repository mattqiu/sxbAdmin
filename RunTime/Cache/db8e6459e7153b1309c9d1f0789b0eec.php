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
<style>
    .order_status{color:#fff;width:100%;height:22px;line-height:20px;border-radius:3px;display:block;}
    .tack{background-color:#3498DB;}
    .sync{background-color:#f1c40f;}
    .print{background-color:#9b59b6;}
    .deliver{background-color:#2ecc71;}
    .abnormal{background-color:#e74c3c;cursor:pointer}
    .merger{background-color:#3b2ee7;}
    .click_abnormal .delete{color:#fff !important; display:inline-block;font-weight:bold;font-size:12px;}
    .delete:hover{color:#0000ff !important;text-decoration:none !important;}
    #page a{text-decoration:none;}    
    #page{text-align: center;position:relative;background-color:#fff;}
    #page .page_link,.current{width:50px;height:30px;font-size:16px;border-radius:3px;line-height:30px;color:#3498db;margin-right:10px;background-color:#f2f2f2;display:inline-block;}
    #page .page_link:hover{background-color:#3498db;color:#fff;}
    #page .current{color:#fff;background-color:#3498db;margin-bottom:30px;}
    #page .one{color:#fff;font-size:14px;margin-right:10px;margin-left:5px;background-color:#3498db;}
    #page .last_page{width:70px;}
</style>
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
                                <h1>订单列表</h1>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-box clearfix">
                                    <header class="main-box-header clearfix">
                                        <!--<h2>订单列表</h2>-->
                                        <div class="main-box-header-act">
                                            <p>
                                                <!--操作流程: 取出要发货定单 -> 检查地址 -> 导入京东(导出订单表给仓库) -> 打印 -> 发货-->
                                            </p>
                                        </div>

                                        <form action="/<?php echo (MODULE_NAME); ?>/<?php echo ($act_name); ?>" method="post" target="_self" role="form" id="order_search_form">
                                            <div class="row">
                                            <select  id="time_sel" class="form-control w100 form-inline-input-group" name="time" style="width:150px;text-align:center;float:left;">
                                                            <option value="11" <?php if($post["time"] == 11): ?>selected<?php endif; ?>>---请选择时间---</option>
                                                            <option value="1" <?php if($post["time"] == 1): ?>selected<?php endif; ?>>----取出时间----</option>
                                                            <option value="2" <?php if($post["time"] == 2): ?>selected<?php endif; ?>>----导入时间----</option>
                                                            <option value="3" <?php if($post["time"] == 3): ?>selected<?php endif; ?>>----打印时间----</option>
                                                <option value="4" <?php if($post["time"] == 4): ?>selected<?php endif; ?>>----发邮件时间----</option>
                                                    </select>
                                                <div class="form-group col-md-5" style="width:360px;margin-left:5px;margin-right:8px;">
                                                    <label for="datepickerDateFrom" class="form-inline-label" style="float:left;line-height:35px;">从：</label>
                                                    <div class="input-group form-inline-input-group w150" style="width:150px;float:left;margin-right:15px;">
                                                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                                        <input type="text" id="datepickerDateFrom" class="form-control" name="limit_date_From" value="<?php echo ($post["limit_date_From"]); ?>">
                                                    </div>

                                                    <div class="input-group input-append bootstrap-timepicker" style="width: 150px; float: left;">
                                                        <input type="text" class="form-control timepicker" id="timepicker_From" name="limit_time_From"
                                                               value="<?php echo ($post["limit_time_From"]); ?>" />
                                                        <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-5" style="width:370px;">
                                                    <label for="datepickerDateTo" class="form-inline-label" style="float:left;line-height:35px;">到：</label>
                                                    <div class="input-group form-inline-input-group w150" style="width:150px;float:left;margin-right:15px;">
                                                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                                        <input type="text" id="datepickerDateTo" class="form-control" name="limit_date_To" value="<?php echo ($post["limit_date_To"]); ?>">
                                                    </div>

                                                    <div class="input-group input-append bootstrap-timepicker" style="width: 150px; float: left;">
                                                        <input type="text" class="form-control timepicker" id="timepicker_To" name="limit_time_To"
                                                               value="<?php echo ($post["limit_time_To"]); ?>" />
                                                        <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3" style="width:280px;">
                                                    <label for="order_status_sel" class="form-inline-label">订单状态：</label>
                                                    <select  id="order_status_sel" class="form-control w100 form-inline-input-group" name="status" style="width:150px;text-align:center;">
                                                        <option value="2" >----已同步----</option>
                                                        <option value="4" >----已发货----</option>
                                                        <option value="11" >----请选择----</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-3" style="width:280px;">
                                                    <label for="print_num" class="form-inline-label">是否打印：</label>
                                                    <select  id="print_num" class="form-control w100 form-inline-input-group" name="print_num" style="width:150px;text-align:center;" >
                                                            <option value="11" <?php if($post["print_num"] == 11): ?>selected<?php endif; ?>>------请选择-----</option>
                                                            <option value="1" <?php if($post["print_num"] == 1): ?>selected<?php endif; ?>>-----已打印-----</option>
                                                            <option value="2" <?php if($post["print_num"] == 2): ?>selected<?php endif; ?>>-----未打印-----</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-3" style="width:280px;">
                                                    <label for="delivery_id" class="form-inline-label">快递单号：</label>
                                                    <input type="text" name="delivery_id" class="form-control w150 form-inline-input-group" value="<?php echo ($post["delivery_id"]); ?>" id="delivery_id" />

                                                </div>
                                                
                                                </div>
                                                <div class="row">
                                                <div class="form-group col-md-4" style="width:280px;">
                                                    <label for="order_name" class="form-inline-label">订单号码：</label>
                                                    <input type="text" name="order_name" class="form-control w150 form-inline-input-group" value="<?php echo ($post["order_name"]); ?>" id="order_name" />
                                                </div>

                                                <div class="form-group col-md-4" style="width:280px;">
                                                    <label for="product_name" class="form-inline-label">商品名称：</label>
                                                    <input type="text" name="product_name" class="form-control w150 form-inline-input-group" value="<?php echo ($post["product_name"]); ?>" id="product_name" />
                                                </div>

                                                <div class="form-group col-md-4" style="width:280px;">
                                                    <label for="rec_name" class="form-inline-label">收件人名：</label>
                                                    <input type="text" name="rec_name" id="rec_name" class="form-control w150 form-inline-input-group" value="<?php echo ($post["rec_name"]); ?>" />
                                                </div>
                                                </div>
                                                <div class="row">
                                                    <input type="hidden" name="send_warehome_name" value="<?php echo ($send_warehome_name); ?>" />

                                                    <input type="hidden" name="is_export_to_warehome" value="<?php echo ($is_export_to_warehome); ?>" />
                                                <div class="form-group col-md-4" style="width:280px;">
                                                    <label for="rec_mobile" class="form-inline-label">收件电话：</label>
                                                    <input type="text" name="rec_mobile" class="form-control w150 form-inline-input-group" value="<?php echo ($post["rec_mobile"]); ?>" id="rec_mobile" />
                                                </div>
                                                <div class="form-group col-md-4 w370">
                                                    <label for="rec_address" class="form-inline-label">收件地址：</label>
                                                    <input type="text" name="rec_address" id="rec_address" class="form-control w150 form-inline-input-group" value="<?php echo ($post["rec_address"]); ?>" />
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <button id="sift_orders" type="submit"  class=" btn btn-primary mrg-b-lg">搜索</button>
                                                </div>
                                                    <div class="form-group col-md-1">
                                                        <button class=" btn btn-primary mrg-b-lg" type="button"
                                                                id="print_order_btn">打印
                                                        </button>
                                                    </div>

                                                    <div class="form-group col-md-1">
                                                        <button class="md-trigger btn btn-primary mrg-b-lg" type="button"  data-modal="import_send_order_dialog"
                                                                id="import_send_goods_btn">导入发货表
                                                        </button>
                                                    </div>

                                            </div>
                                        </form>

                                    </header>

                                    <div id="page">
                                        <?php echo ($page); ?>
                                    </div>
                                    <div class="main-box-body clearfix" style="margin-top:30px;">
                                        <div class="table-responsive">
                                            <table id="table-example-fixed" class="table table-hover" style="text-align:center;">
                                                <thead>
                                                <tr>
                                                    <th style="text-align:left;"><input type="checkbox" id="check_all"/>全选本页</th>
                                                    <th style="text-align:center;">订单号</th>
                                                    <th style="text-align:center;">收件人</th>
                                                    <th style="text-align:center;">地址</th>
                                                    <th style="text-align:center;">商品</th>
                                                    <th style="text-align:center;">快递单号</th>
                                                    <th style="text-align:center;">打印</th>
                                                    <th style="text-align:center;">包裹数</th>
                                                    <th style="text-align:center;">发货仓</th>
                                                    <th style="text-align:center;">状态</th>
                                                    <th style="text-align:center;">
                                                        <?php if($type == 3): ?>打印时间
                                                            <?php elseif($type == 2): ?>导入时间
                                                            <?php elseif($type == 4): ?>发邮件时间
                                                            <?php else: ?>取出时间<?php endif; ?>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="list_order_tby">
                                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr class="select_all">
    <td class="id_order_name" style="text-align:left;text-indent:3px;">
        <input type="checkbox" class="checkOrder" value="<?php echo ($item["id"]); ?>"
                <?php if($item["jd_can_shipping"] != 2): ?>disabled<?php endif; ?>
                />&nbsp;<?php echo ($item["id"]); ?></td>
    <td>订:<?php echo ($item["order_name"]); ?> <br/>团:<?php echo ($item["groupbuy_order_name"]); ?></td>
    <td><?php echo ($item["rec_name"]); ?> <br/> <?php echo ($item["rec_mobile"]); ?></td>
    <td><?php echo ($item["rec_address"]); ?></td>
    <td><?php echo ($item["product_name"]); ?></td>
    <td><?php echo ($item["delivery_id"]); ?></td>
    <td><?php echo ($item["print_num"]); ?></td>
    <td><?php echo ($item["package_num"]); ?></td>
    <td><?php echo ($item["send_warehome_name"]); ?></td>
    <td style="padding:0;">
        <?php if($item["status"] == 1): ?><span class="order_status tack">取出</span>
            <?php elseif($item["status"] == 2): ?><span class="order_status sync">同步</span>
            <?php elseif($item["status"] == 4): ?><span class="order_status deliver">发货</span>
            <?php elseif($nums == 1): ?><span class="order_status print">已打印</span>
            <?php elseif($nums == 2): ?><span class="order_status print">未打印</span>
            <?php elseif($item["status"] == 10): ?><span class="order_status abnormal click_abnormal">异常&nbsp;
                <a class="delete" oid="<?php echo ($item["id"]); ?>" href="javascript:;" >删除</a></span><?php endif; ?>
    </td>
    <td>
        <?php if($type == 3): echo ($item["last_print_time"]); ?>
            <?php elseif($type == 2): echo ($item["last_import_jd_time"]); ?>
            <?php elseif($type == 4): echo ($item["last_send_mail_time"]); ?>
            <?php else: echo ($item["add_time"]); endif; ?>
    </td>
</tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
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



<div class="md-modal md-effect-1" id="import_send_order_dialog">
    <div class="md-content">
        <div class="modal-header">
            <button class="md-close close">&times;</button>
            <h4 class="modal-title">导入要发货的订单</h4>
        </div>
        <form action="/<?php echo (MODULE_NAME); ?>/importWarehouseSendOrder" enctype="multipart/form-data" method="post" role="form" target="_blank">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label  class="form-inline-label">选择excel文件：</label>
                        <input type="file" name="import_file"> <br/>
                        <span>请使用订单邮件附件中(订单列表)的格式</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="import_warehouse_send_order_btn">导入</button>
            </div>
        </form>
    </div>
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
<script src="__PUBLIC__/admin/v3/js/shipinmmm/MessageBox.js"></script>


<script src="__PUBLIC__/admin/v3/js/shipinmmm/orders.js"></script>

<!--时期时间选择器-->
<script src="__PUBLIC__/admin/v3/js/bootstrap-datepicker.js"></script>
<script src="__PUBLIC__/admin/v3/js/moment.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/daterangepicker.js" type="text/javascript"></script>
<script src="__PUBLIC__/admin/v3/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="__PUBLIC__/admin/js/plugins/base64.min.js"></script>

<script>
    $(function($){
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

        //取出要发货的订单 年月日 开始
        $('#datepickerDate_fetch_From').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            autoclose: true,
            todayBtn: 'linked',
            language: 'zh-CN'
        });

        //取出要发货的订单 时分秒 开始
        $('#timepicker_fetch_From').timepicker({
            minuteStep: 5,
            showSeconds: true,
            showMeridian: false,
            disableFocus: false,
            showWidget: true
        }).focus(function() {
            $(this).next().trigger('click');
        });

        //取出要发货的订单 年月日 截止
        $('#datepickerDate_fetch_To').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            autoclose: true,
            todayBtn: 'linked',
            language: 'zh-CN'
        });

        //取出要发货的订单 时分秒 截止
        $('#timepicker_fetch_To').timepicker({
            minuteStep: 5,
            showSeconds: true,
            showMeridian: false,
            disableFocus: false,
            showWidget: true
        }).focus(function() {
            $(this).next().trigger('click');
        });

        $("#page :last").addClass("last_page");

        //删除订单
        $(".delete").click(function(){
            var _this = $(this);
            var oid = _this.attr("oid");
            var url = "<?php echo U('JdOrder/delOrder');?>";
            var data = {'oid':oid};
            $.post(url,data,function(result){
                if(result = 1){
                    _this.parent().parent().parent().remove();
                }else{
                    alert("删除订单失败");
                }
            },'json')

        })

        //批量选择表单
        $('#check_all').on('change', function(){
            var is_checked = document.getElementById("check_all").checked;
            if(is_checked){
                $('.checkOrder').prop('checked', true);
            } else {
                $('.checkOrder').prop('checked', false);
            }
        });

        $('#print_order_btn').on('click', function(){
            var _this = $(this);
            _this.append('<span class="btn_doing">ing...请稍候</span>');
            _this.prop('disabled', true);
            var checkedOrders = [];
            $('.checkOrder:checked').each(function(){
                checkedOrders.push($(this).val());
            });
            if(checkedOrders.length > 0){
                var orderNamesBase = btoa(checkedOrders.join(',')); //返回base64编码后的字符
                var productName = $('#product_name').val();
                var data = {order_names: orderNamesBase, product_name:productName};

                var addPrintedUrl='/<?php echo (MODULE_NAME); ?>/addIsPrinted';
                var createPrintUrl='/<?php echo (MODULE_NAME); ?>/createJdPrintPdf/order_names/' + orderNamesBase;

                window.open(createPrintUrl);
                MessageBox.confirm('已经打印完成?', function(){
                    //ajax更新已经打印的数据
                    data = getFormParams('order_search_form', data);
                    $.post(addPrintedUrl, data, function(result){
                        if(result.status > 0){
                            $('#list_order_tby').html(result.data.html);
                            $('#page').html(result.data.page_str);
                        } else {
                            alert(result.msg);
                        }

                        _this.prop('disabled', false).removeAttr('disabled');
                        _this.children('span.btn_doing').remove();
                    }, 'json');
                },
                function(){
                    _this.prop('disabled', false).removeAttr('disabled');
                    _this.children('span.btn_doing').remove();
                });
            } else {
                _this.prop('disabled', false).removeAttr('disabled');
                _this.children('span.btn_doing').remove();
                alert('请选择要打印的订单!');
            }
        });
    });

    function getFormParams(formId, data){
        var _form = $('#' + formId);
        _form.find('input').each(function(){
            var value = $(this).val();
            if(typeof value !='undefind' && value.length > 0){
                data[$(this).attr('name')] = value;
            }
        });

        _form.find('select').each(function(){
            var value = $(this).val();
            if(typeof value !='undefind'){
                data[$(this).attr('name')] = value;
            }
        });

        return data;
    }
</script>
</body>
</html>