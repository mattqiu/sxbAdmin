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
                                        <h2>订单发货列表</h2>
                                        <div class="main-box-header-act">
                                            <button class="md-trigger btn btn-primary mrg-b-lg" data-modal="import_send_order_dialog"
                                                    id="import_send_order_btn">导入发货单的订单
                                            </button>

                                            <a href="/<?php echo (MODULE_NAME); ?>/sysSendOrder" class=" btn btn-primary mrg-b-lg" target="_blank">取系统内的发货单</a>
                                            <button class="md-trigger btn btn-primary mrg-b-lg" data-modal="confirm_send_dialog"
                                                    id="do_send_order_btn">发货
                                            </button>
                                        </div>

                                        <form action="/<?php echo (MODULE_NAME); ?>/index" method="post" target="_self" role="form">
                                        <div class="row">
                                            <div class="form-group col-md-5">
                                                <label for="datepickerDateFrom" class="form-inline-label">从：</label>
                                                <div class="input-group form-inline-input-group w150">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                                    <input type="text" id="datepickerDateFrom" class="form-control" name="limit_date_From" value="<?php echo ($limit_date_From); ?>">
                                                </div>

                                                <div class="input-group input-append bootstrap-timepicker" style="width: 150px; float: right;">
                                                    <input type="text" class="form-control timepicker" id="timepicker_From" name="limit_time_From"
                                                           value="<?php echo ($limit_time_From); ?>" />
                                                    <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-5">
                                                <label for="datepickerDateTo" class="form-inline-label">到：</label>
                                                <div class="input-group form-inline-input-group w150">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                                    <input type="text" id="datepickerDateTo" class="form-control" name="limit_date_To" value="<?php echo ($limit_date_To); ?>">
                                                </div>

                                                <div class="input-group input-append bootstrap-timepicker" style="width: 150px; float: right;">
                                                    <input type="text" class="form-control timepicker" id="timepicker_To" name="limit_time_To"
                                                           value="<?php echo ($limit_time_To); ?>" />
                                                    <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="order_status_sel" class="form-inline-label">订单状态：</label>
                                                <select  id="order_status_sel" class="form-control w100 form-inline-input-group" name="order_status_sel">
                                                    <?php if(is_array($manage_order_status)): foreach($manage_order_status as $key=>$item): ?><option value="<?php echo ($key); ?>" <?php if($key == $order_status_sel): ?>selected<?php endif; ?>><?php echo ($item); ?></option><?php endforeach; endif; ?>
                                                </select>
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label for="order_status_sel" class="form-inline-label">运单号：</label>
                                                <input type="text" name="delivery_id" class="form-control w150 form-inline-input-group" value="<?php echo ($delivery_id); ?>" />

                                            </div>

                                            </div>
                                            <div class="row">

                                            <div class="form-group col-md-4">
                                                <label for="order_status_sel" class="form-inline-label">订单号：</label>
                                                <input type="text" name="order_name" class="form-control w150 form-inline-input-group" value="<?php echo ($order_name); ?>" />
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="order_status_sel" class="form-inline-label">物品名：</label>
                                                <input type="text" name="product_name" class="form-control w150 form-inline-input-group" value="<?php echo ($product_name); ?>" />
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="order_status_sel" class="form-inline-label">收件人：</label>
                                                <input type="text" name="rec_name" class="form-control w150 form-inline-input-group" value="<?php echo ($rec_name); ?>" />
                                            </div>
                                            </div>
                                            <div class="row">

                                            <div class="form-group col-md-4">
                                                <label for="order_status_sel" class="form-inline-label">收件人电话：</label>
                                                <input type="text" name="rec_phone" class="form-control w150 form-inline-input-group" value="<?php echo ($rec_phone); ?>" />
                                            </div>

                                                <div class="form-group col-md-4">
                                                    <label for="order_status_sel" class="form-inline-label">外部支付单号：</label>
                                                    <input type="text" name="trade_no" class="form-control w150 form-inline-input-group" value="<?php echo ($trade_no); ?>" />
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="send_channel" class="form-inline-label">发货渠道：</label>
                                                    <select  id="send_channel" class="form-control w100 form-inline-input-group" name="send_channel">
                                                        <option value="">请选择发货渠道</option>

                                                        <?php if(is_array($supply_list)): foreach($supply_list as $key=>$supply): ?><option value="<?php echo ($supply["name"]); ?>"
                                                            <?php if(($send_channel) == $supply["name"]): ?>selected="selected"<?php endif; ?>
                                                            ><?php echo ($supply["real_name"]); ?></option><?php endforeach; endif; ?>
                                                    </select>
                                                </div>



                                            <div class="form-group col-md-2">
                                                <button id="sift_orders" type="submit"  class=" btn btn-primary mrg-b-lg">确定</button>
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
                                                    <th>订单号</th>
                                                    <th>收件人</th>
                                                    <th>手机</th>
                                                    <th>地址</th>
                                                    <th>商品</th>
                                                    <th>备注</th>
                                                    <th>快递名</th>
                                                    <th>快递单号</th>
                                                    <th>状态</th>
                                                    <th>发货时间</th>
                                                    <th>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(is_array($list)): foreach($list as $key=>$item): $key = $key+1; ?>
                                                    <tbody >
<tr>
    <td><input type="checkbox" id="check_all"/><?php echo ($item["id"]); ?></td>
    <td><?php echo ($item["order_name"]); ?></td>
    <td><?php echo ($item["rec_name"]); ?></td>
    <td><?php echo ($item["rec_mobile"]); ?></td>
    <td><?php echo ($item["rec_address"]); ?></td>
    <td><?php echo ($item["product_name"]); ?></td>
    <td><?php echo ($item["remark"]); ?></td>
    <td><?php echo ($item["shipping_name"]); ?></td>
    <td><?php echo ($item["delivery_id"]); ?></td>
    <td><?php echo ($item["status"]); ?></td>
    <td><?php echo ($item["send_time"]); ?></td>
    <td><a href="/<?php echo (MODULE_NAME); ?>/del/id/<?php echo ($item["id"]); ?>">删除</a></td>
</tr>
</tbody><?php endforeach; endif; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php echo ($page); ?>
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
        <form action="/<?php echo (MODULE_NAME); ?>/importSendOrder" enctype="multipart/form-data" method="post" role="form">
            <div class="modal-body">
                <div class="row">
                <div class="form-group col-md-12">
                    <label  class="form-inline-label">选择excel文件：</label>
                    <input type="file" name="import_file"> <br/>
                    <span>请使用京东青龙后台导出的格式</span>

                </div>
            </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="">导入</button>
            </div>
        </form>
    </div>
</div>

<div class="md-modal md-effect-1" id="confirm_send_dialog">
    <div class="md-content">
        <div class="modal-header">
            <button class="md-close close">&times;</button>
            <h4 class="modal-title">去发货</h4>
        </div>
        <form action="/<?php echo (MODULE_NAME); ?>/doSendOrder"  method="post" role="form">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-10">
                    <span>确认要进行发货吗</span>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">确认</button>
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
            var checkedOrders = [];
            $('.checkOrder:checked').each(function(){
                checkedOrders.push($(this).val());
            });
            if(checkedOrders.length > 0){
                var data = {order_names: checkedOrders.join(',')};
                var url = '/Order/orderRefund';
                $.get(url, data, function(result){

                });
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



    });
</script>
</body>
</html>