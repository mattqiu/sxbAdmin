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
            <li><a href="#">Home</a></li>
            <li class="active"><span>Dashboard</span></li>
        </ol>
        <h1>Dashboard</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="main-box infographic-box">
            <i class="fa fa-user red-bg"></i>
            <span class="headline">Users</span>
<span class="value">
<span class="timer" data-from="120" data-to="2562" data-speed="1000" data-refresh-interval="50">
2562
</span>
</span>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="main-box infographic-box">
            <i class="fa fa-shopping-cart emerald-bg"></i>
            <span class="headline">Purchases</span>
<span class="value">
<span class="timer" data-from="30" data-to="658" data-speed="800" data-refresh-interval="30">
658
</span>
</span>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="main-box infographic-box">
            <i class="fa fa-money green-bg"></i>
            <span class="headline">Income</span>
<span class="value">
&#36;<span class="timer" data-from="83" data-to="8400" data-speed="900" data-refresh-interval="60">
8400
</span>
</span>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="main-box infographic-box">
            <i class="fa fa-eye yellow-bg"></i>
            <span class="headline">Monthly Visits</span>
<span class="value">
<span class="timer" data-from="539" data-to="12526" data-speed="1100">
12526
</span>
</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9 col-lg-10">
        <div class="main-box">
            <div class="row">
                <div class="col-md-9">
                    <div class="graph-box emerald-bg">
                        <h2>Sales &amp; Earnings</h2>

                        <div class="graph" id="graph-line" style="max-height: 335px;"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row graph-nice-legend">
                        <div class="graph-legend-row col-md-12 col-sm-4">
                            <div class="graph-legend-row-inner">
<span class="graph-legend-name">
Earnings
</span>
<span class="graph-legend-value">
&dollar;94.382
</span>
                            </div>
                        </div>
                        <div class="graph-legend-row col-md-12 col-sm-4">
                            <div class="graph-legend-row-inner">
<span class="graph-legend-name">
Orders
</span>
<span class="graph-legend-value">
3.930
</span>
                            </div>
                        </div>
                        <div class="graph-legend-row col-md-12 col-sm-4">
                            <div class="graph-legend-row-inner">
<span class="graph-legend-name">
New Clients
</span>
<span class="graph-legend-value">
894
</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-2">
        <div class="social-box-wrapper">
            <div class="social-box col-md-12 col-sm-4 facebook">
                <i class="fa fa-facebook"></i>

                <div class="clearfix">
                    <span class="social-count">184k</span>
                    <span class="social-action">likes</span>
                </div>
                <span class="social-name">facebook</span>
            </div>
            <div class="social-box col-md-12 col-sm-4 twitter">
                <i class="fa fa-twitter"></i>

                <div class="clearfix">
                    <span class="social-count">49k</span>
                    <span class="social-action">tweets</span>
                </div>
                <span class="social-name">twitter</span>
            </div>
            <div class="social-box col-md-12 col-sm-4 google">
                <i class="fa fa-google-plus"></i>

                <div class="clearfix">
                    <span class="social-count">204</span>
                    <span class="social-action">circles</span>
                </div>
                <span class="social-name">google+</span>
            </div>
        </div>
    </div>
</div>
<!--<div class="row">-->
    <!--<div class="col-lg-12">-->
        <!--<div class="main-box clearfix">-->
            <!--<header class="main-box-header clearfix">-->
                <!--<h2 class="pull-left">Last orders</h2>-->

                <!--<div class="filter-block pull-right">-->
                    <!--<div class="form-group pull-left">-->
                        <!--<input type="text" class="form-control" placeholder="Search...">-->
                        <!--<i class="fa fa-search search-icon"></i>-->
                    <!--</div>-->
                    <!--<a href="#" class="btn btn-primary pull-right">-->
                        <!--<i class="fa fa-eye fa-lg"></i> View all orders-->
                    <!--</a>-->
                <!--</div>-->
            <!--</header>-->
            <!--<div class="main-box-body clearfix">-->
                <!--<div class="table-responsive clearfix">-->
                    <!--<table class="table table-hover">-->
                        <!--<thead>-->
                        <!--<tr>-->
                            <!--<th><a href="#"><span>Order ID</span></a></th>-->
                            <!--<th><a href="#" class="desc"><span>Date</span></a></th>-->
                            <!--<th><a href="#" class="asc"><span>Customer</span></a></th>-->
                            <!--<th class="text-center"><span>Status</span></th>-->
                            <!--<th class="text-right"><span>Price</span></th>-->
                            <!--<th>&nbsp;</th>-->
                        <!--</tr>-->
                        <!--</thead>-->
                        <!--<tbody>-->
                        <!--<tr>-->
                            <!--<td>-->
                                <!--<a href="#">#8002</a>-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--2013/08/08-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--<a href="#">Robert De Niro</a>-->
                            <!--</td>-->
                            <!--<td class="text-center">-->
                                <!--<span class="label label-success">Completed</span>-->
                            <!--</td>-->
                            <!--<td class="text-right">-->
                                <!--&dollar; 825.50-->
                            <!--</td>-->
                            <!--<td class="text-center" style="width: 15%;">-->
                                <!--<a href="#" class="table-link">-->
<!--<span class="fa-stack">-->
<!--<i class="fa fa-square fa-stack-2x"></i>-->
<!--<i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>-->
<!--</span>-->
                                <!--</a>-->
                            <!--</td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<td>-->
                                <!--<a href="#">#5832</a>-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--2013/08/08-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--<a href="#">John Wayne</a>-->
                            <!--</td>-->
                            <!--<td class="text-center">-->
                                <!--<span class="label label-warning">On hold</span>-->
                            <!--</td>-->
                            <!--<td class="text-right">-->
                                <!--&dollar; 923.93-->
                            <!--</td>-->
                            <!--<td class="text-center" style="width: 15%;">-->
                                <!--<a href="#" class="table-link">-->
<!--<span class="fa-stack">-->
<!--<i class="fa fa-square fa-stack-2x"></i>-->
<!--<i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>-->
<!--</span>-->
                                <!--</a>-->
                            <!--</td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<td>-->
                                <!--<a href="#">#2547</a>-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--2013/08/08-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--<a href="#">Anthony Hopkins</a>-->
                            <!--</td>-->
                            <!--<td class="text-center">-->
                                <!--<span class="label label-info">Pending</span>-->
                            <!--</td>-->
                            <!--<td class="text-right">-->
                                <!--&dollar; 1.625.50-->
                            <!--</td>-->
                            <!--<td class="text-center" style="width: 15%;">-->
                                <!--<a href="#" class="table-link">-->
<!--<span class="fa-stack">-->
<!--<i class="fa fa-square fa-stack-2x"></i>-->
<!--<i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>-->
<!--</span>-->
                                <!--</a>-->
                            <!--</td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<td>-->
                                <!--<a href="#">#9274</a>-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--2013/08/08-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--<a href="#">Charles Chaplin</a>-->
                            <!--</td>-->
                            <!--<td class="text-center">-->
                                <!--<span class="label label-danger">Cancelled</span>-->
                            <!--</td>-->
                            <!--<td class="text-right">-->
                                <!--&dollar; 35.34-->
                            <!--</td>-->
                            <!--<td class="text-center" style="width: 15%;">-->
                                <!--<a href="#" class="table-link">-->
<!--<span class="fa-stack">-->
<!--<i class="fa fa-square fa-stack-2x"></i>-->
<!--<i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>-->
<!--</span>-->
                                <!--</a>-->
                            <!--</td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<td>-->
                                <!--<a href="#">#8463</a>-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--2013/08/08-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--<a href="#">Gary Cooper</a>-->
                            <!--</td>-->
                            <!--<td class="text-center">-->
                                <!--<span class="label label-success">Completed</span>-->
                            <!--</td>-->
                            <!--<td class="text-right">-->
                                <!--&dollar; 34.199.99-->
                            <!--</td>-->
                            <!--<td class="text-center" style="width: 15%;">-->
                                <!--<a href="#" class="table-link">-->
<!--<span class="fa-stack">-->
<!--<i class="fa fa-square fa-stack-2x"></i>-->
<!--<i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>-->
<!--</span>-->
                                <!--</a>-->
                            <!--</td>-->
                        <!--</tr>-->
                        <!--</tbody>-->
                    <!--</table>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
<!--</div>-->
<!--<div class="row">-->
    <!--<div class="col-md-4 col-sm-6 col-xs-12">-->
        <!--<div class="main-box small-graph-box red-bg">-->
            <!--<span class="value">2.562</span>-->
            <!--<span class="headline">Users</span>-->

            <!--<div class="progress">-->
                <!--<div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar">-->
                    <!--<span class="sr-only">60% Complete</span>-->
                <!--</div>-->
            <!--</div>-->
<!--<span class="subinfo">-->
<!--<i class="fa fa-arrow-circle-o-up"></i> 10% higher than last week-->
<!--</span>-->
<!--<span class="subinfo">-->
<!--<i class="fa fa-users"></i> 29 new users-->
<!--</span>-->
        <!--</div>-->
    <!--</div>-->
    <!--<div class="col-md-4 col-sm-6 col-xs-12">-->
        <!--<div class="main-box small-graph-box emerald-bg">-->
            <!--<span class="value">69.600</span>-->
            <!--<span class="headline">Visits</span>-->

            <!--<div class="progress">-->
                <!--<div style="width: 84%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="84" role="progressbar" class="progress-bar">-->
                    <!--<span class="sr-only">84% Complete</span>-->
                <!--</div>-->
            <!--</div>-->
<!--<span class="subinfo">-->
<!--<i class="fa fa-arrow-circle-o-down"></i> 22% less than last week-->
<!--</span>-->
<!--<span class="subinfo">-->
<!--<i class="fa fa-globe"></i> 84.912 last week-->
<!--</span>-->
        <!--</div>-->
    <!--</div>-->
    <!--<div class="col-md-4 col-sm-6 col-xs-12 hidden-sm">-->
        <!--<div class="main-box small-graph-box green-bg">-->
            <!--<span class="value">923</span>-->
            <!--<span class="headline">Orders</span>-->

            <!--<div class="progress">-->
                <!--<div style="width: 42%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="42" role="progressbar" class="progress-bar">-->
                    <!--<span class="sr-only">42% Complete</span>-->
                <!--</div>-->
            <!--</div>-->
<!--<span class="subinfo">-->
<!--<i class="fa fa-arrow-circle-o-up"></i> 15% higher than last week-->
<!--</span>-->
<!--<span class="subinfo">-->
<!--<i class="fa fa-shopping-cart"></i> 8 new orders-->
<!--</span>-->
        <!--</div>-->
    <!--</div>-->
<!--</div>-->
<!--<div class="row">-->
<!--<div class="col-lg-6">-->
    <!--<div class="main-box clearfix">-->
        <!--<header class="main-box-header clearfix">-->
            <!--<h2>Conversation</h2>-->
        <!--</header>-->
        <!--<div class="main-box-body clearfix">-->
            <!--<div class="conversation-wrapper">-->
                <!--<div class="conversation-content">-->
                    <!--<div class="conversation-inner">-->
                        <!--<div class="conversation-item item-left clearfix">-->
                            <!--<div class="conversation-user">-->
                                <!--<img src="__PUBLIC__/admin/v3/img/samples/ryan.png" alt=""/>-->
                            <!--</div>-->
                            <!--<div class="conversation-body">-->
                                <!--<div class="name">-->
                                    <!--Ryan Gossling-->
                                <!--</div>-->
                                <!--<div class="time hidden-xs">-->
                                    <!--September 21, 2013 18:28-->
                                <!--</div>-->
                                <!--<div class="text">-->
                                    <!--I don't think they tried to market it to the billionaire, spelunking,-->
                                    <!--base-jumping crowd.-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="conversation-item item-right clearfix">-->
                            <!--<div class="conversation-user">-->
                                <!--<img src="__PUBLIC__/admin/v3/img/samples/kunis.png" alt=""/>-->
                            <!--</div>-->
                            <!--<div class="conversation-body">-->
                                <!--<div class="name">-->
                                    <!--Mila Kunis-->
                                <!--</div>-->
                                <!--<div class="time hidden-xs">-->
                                    <!--September 21, 2013 12:45-->
                                <!--</div>-->
                                <!--<div class="text">-->
                                    <!--The path of the righteous man is beset on all sides by the iniquities of the-->
                                    <!--selfish and the tyranny of evil men. Blessed is he who, in the name of charity and-->
                                    <!--good will.-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="conversation-item item-right clearfix">-->
                            <!--<div class="conversation-user">-->
                                <!--<img src="__PUBLIC__/admin/v3/img/samples/kunis.png" alt=""/>-->
                            <!--</div>-->
                            <!--<div class="conversation-body">-->
                                <!--<div class="name">-->
                                    <!--Mila Kunis-->
                                <!--</div>-->
                                <!--<div class="time hidden-xs">-->
                                    <!--September 21, 2013 12:45-->
                                <!--</div>-->
                                <!--<div class="text">-->
                                    <!--The path of the righteous man is beset on all sides by the iniquities of the-->
                                    <!--selfish and the tyranny of evil men. Blessed is he who, in the name of charity and-->
                                    <!--good will.-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="conversation-item item-left clearfix">-->
                            <!--<div class="conversation-user">-->
                                <!--<img src="__PUBLIC__/admin/v3/img/samples/ryan.png" alt=""/>-->
                            <!--</div>-->
                            <!--<div class="conversation-body">-->
                                <!--<div class="name">-->
                                    <!--Ryan Gossling-->
                                <!--</div>-->
                                <!--<div class="time hidden-xs">-->
                                    <!--September 21, 2013 18:28-->
                                <!--</div>-->
                                <!--<div class="text">-->
                                    <!--I don't think they tried to market it to the billionaire, spelunking,-->
                                    <!--base-jumping crowd.-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="conversation-item item-right clearfix">-->
                            <!--<div class="conversation-user">-->
                                <!--<img src="__PUBLIC__/admin/v3/img/samples/kunis.png" alt=""/>-->
                            <!--</div>-->
                            <!--<div class="conversation-body">-->
                                <!--<div class="name">-->
                                    <!--Mila Kunis-->
                                <!--</div>-->
                                <!--<div class="time hidden-xs">-->
                                    <!--September 21, 2013 12:45-->
                                <!--</div>-->
                                <!--<div class="text">-->
                                    <!--The path of the righteous man is beset on all sides by the iniquities of the-->
                                    <!--selfish and the tyranny of evil men. Blessed is he who, in the name of charity and-->
                                    <!--good will.-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="conversation-item item-right clearfix">-->
                            <!--<div class="conversation-user">-->
                                <!--<img src="__PUBLIC__/admin/v3/img/samples/kunis.png" alt=""/>-->
                            <!--</div>-->
                            <!--<div class="conversation-body">-->
                                <!--<div class="name">-->
                                    <!--Mila Kunis-->
                                <!--</div>-->
                                <!--<div class="time hidden-xs">-->
                                    <!--September 21, 2013 12:45-->
                                <!--</div>-->
                                <!--<div class="text">-->
                                    <!--The path of the righteous man is beset on all sides by the iniquities of the-->
                                    <!--selfish and the tyranny of evil men. Blessed is he who, in the name of charity and-->
                                    <!--good will.-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="conversation-item item-left clearfix">-->
                            <!--<div class="conversation-user">-->
                                <!--<img src="__PUBLIC__/admin/v3/img/samples/ryan.png" alt=""/>-->
                            <!--</div>-->
                            <!--<div class="conversation-body">-->
                                <!--<div class="name">-->
                                    <!--Ryan Gossling-->
                                <!--</div>-->
                                <!--<div class="time hidden-xs">-->
                                    <!--September 21, 2013 18:28-->
                                <!--</div>-->
                                <!--<div class="text">-->
                                    <!--I don't think they tried to market it to the billionaire, spelunking,-->
                                    <!--base-jumping crowd.-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="conversation-item item-right clearfix">-->
                            <!--<div class="conversation-user">-->
                                <!--<img src="__PUBLIC__/admin/v3/img/samples/kunis.png" alt=""/>-->
                            <!--</div>-->
                            <!--<div class="conversation-body">-->
                                <!--<div class="name">-->
                                    <!--Mila Kunis-->
                                <!--</div>-->
                                <!--<div class="time hidden-xs">-->
                                    <!--September 21, 2013 12:45-->
                                <!--</div>-->
                                <!--<div class="text">-->
                                    <!--The path of the righteous man is beset on all sides by the iniquities of the-->
                                    <!--selfish and the tyranny of evil men. Blessed is he who, in the name of charity and-->
                                    <!--good will.-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="conversation-new-message">-->
                    <!--<form>-->
                        <!--<div class="form-group">-->
                            <!--<textarea class="form-control" rows="2" placeholder="Enter your message..."></textarea>-->
                        <!--</div>-->
                        <!--<div class="clearfix">-->
                            <!--<button type="submit" class="btn btn-success pull-right">Send message</button>-->
                        <!--</div>-->
                    <!--</form>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
<!--</div>-->
<!--<div class="col-lg-6">-->
<!--<div class="main-box clearfix">-->
<!--<div class="tabs-wrapper tabs-no-header">-->
<!--<ul class="nav nav-tabs">-->
    <!--<li class="active"><a href="#tab-users" data-toggle="tab">Users</a></li>-->
    <!--<li><a href="#tab-products" data-toggle="tab">Products</a></li>-->
    <!--<li><a href="#tab-todo" data-toggle="tab">Todo</a></li>-->
<!--</ul>-->
<!--<div class="tab-content tab-content-body clearfix">-->
<!--<div class="tab-pane fade in active" id="tab-users">-->
    <!--<ul class="widget-users row">-->
        <!--<li class="col-md-6">-->
            <!--<div class="img">-->
                <!--<img src="__PUBLIC__/admin/v3/img/samples/scarlet.png" alt=""/>-->
            <!--</div>-->
            <!--<div class="details">-->
                <!--<div class="name">-->
                    <!--<a href="#">Scarlett Johansson</a>-->
                <!--</div>-->
                <!--<div class="time">-->
                    <!--<i class="fa fa-clock-o"></i> Last online: 5 minutes ago-->
                <!--</div>-->
                <!--<div class="type">-->
                    <!--<span class="label label-danger">Admin</span>-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="col-md-6">-->
            <!--<div class="img">-->
                <!--<img src="__PUBLIC__/admin/v3/img/samples/kunis.png" alt=""/>-->
            <!--</div>-->
            <!--<div class="details">-->
                <!--<div class="name">-->
                    <!--<a href="#">Mila Kunis</a>-->
                <!--</div>-->
                <!--<div class="time online">-->
                    <!--<i class="fa fa-check-circle"></i> Online-->
                <!--</div>-->
                <!--<div class="type">-->
                    <!--<span class="label label-warning">Pending</span>-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="col-md-6">-->
            <!--<div class="img">-->
                <!--<img src="__PUBLIC__/admin/v3/img/samples/ryan.png" alt=""/>-->
            <!--</div>-->
            <!--<div class="details">-->
                <!--<div class="name">-->
                    <!--<a href="#">Ryan Gossling</a>-->
                <!--</div>-->
                <!--<div class="time online">-->
                    <!--<i class="fa fa-check-circle"></i> Online-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="col-md-6">-->
            <!--<div class="img">-->
                <!--<img src="__PUBLIC__/admin/v3/img/samples/robert.png" alt=""/>-->
            <!--</div>-->
            <!--<div class="details">-->
                <!--<div class="name">-->
                    <!--<a href="#">Robert Downey Jr.</a>-->
                <!--</div>-->
                <!--<div class="time">-->
                    <!--<i class="fa fa-clock-o"></i> Last online: Thursday-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="col-md-6">-->
            <!--<div class="img">-->
                <!--<img src="__PUBLIC__/admin/v3/img/samples/emma.png" alt=""/>-->
            <!--</div>-->
            <!--<div class="details">-->
                <!--<div class="name">-->
                    <!--<a href="#">Emma Watson</a>-->
                <!--</div>-->
                <!--<div class="time">-->
                    <!--<i class="fa fa-clock-o"></i> Last online: 1 week ago-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="col-md-6">-->
            <!--<div class="img">-->
                <!--<img src="__PUBLIC__/admin/v3/img/samples/george.png" alt=""/>-->
            <!--</div>-->
            <!--<div class="details">-->
                <!--<div class="name">-->
                    <!--<a href="#">George Clooney</a>-->
                <!--</div>-->
                <!--<div class="time">-->
                    <!--<i class="fa fa-clock-o"></i> Last online: 1 month ago-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="col-md-6">-->
            <!--<div class="img">-->
                <!--<img src="__PUBLIC__/admin/v3/img/samples/kunis.png" alt=""/>-->
            <!--</div>-->
            <!--<div class="details">-->
                <!--<div class="name">-->
                    <!--<a href="#">Mila Kunis</a>-->
                <!--</div>-->
                <!--<div class="time online">-->
                    <!--<i class="fa fa-check-circle"></i> Online-->
                <!--</div>-->
                <!--<div class="type">-->
                    <!--<span class="label label-warning">Pending</span>-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="col-md-6">-->
            <!--<div class="img">-->
                <!--<img src="__PUBLIC__/admin/v3/img/samples/ryan.png" alt=""/>-->
            <!--</div>-->
            <!--<div class="details">-->
                <!--<div class="name">-->
                    <!--<a href="#">Ryan Gossling</a>-->
                <!--</div>-->
                <!--<div class="time online">-->
                    <!--<i class="fa fa-check-circle"></i> Online-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
    <!--</ul>-->
    <!--<br/>-->
    <!--<a href="#" class="btn btn-success pull-right">View all users</a>-->
<!--</div>-->
<!--<div class="tab-pane fade" id="tab-products">-->
    <!--<ul class="widget-products">-->
        <!--<li>-->
            <!--<a href="#">-->
<!--<span class="img">-->
<!--<img src="__PUBLIC__/admin/v3/img/samples/ipad.png" alt=""/>-->
<!--</span>-->
<!--<span class="product clearfix">-->
<!--<span class="name">-->
<!--iPad mini 32GB WiFi Black&Slate-->
<!--</span>-->
<!--<span class="price">-->
<!--<i class="fa fa-money"></i> &dollar;320,00-->
<!--</span>-->
<!--<span class="warranty">-->
<!--<i class="fa fa-certificate"></i> Warranty: 2 years-->
<!--</span>-->
<!--</span>-->
            <!--</a>-->
        <!--</li>-->
        <!--<li>-->
            <!--<a href="#">-->
<!--<span class="img">-->
<!--<img src="__PUBLIC__/admin/v3/img/samples/ipad.png" alt=""/>-->
<!--</span>-->
<!--<span class="product clearfix">-->
<!--<span class="name">-->
<!--iPad mini 16GB WiFi Black&Slate-->
<!--</span>-->
<!--<span class="price">-->
<!--<i class="fa fa-money"></i> &dollar;273,68-->
<!--</span>-->
<!--<span class="warranty">-->
<!--<i class="fa fa-certificate"></i> Warranty: 2 years-->
<!--</span>-->
<!--</span>-->
            <!--</a>-->
        <!--</li>-->
        <!--<li>-->
            <!--<a href="#">-->
<!--<span class="img">-->
<!--<img src="__PUBLIC__/admin/v3/img/samples/ipad.png" alt=""/>-->
<!--</span>-->
<!--<span class="product clearfix">-->
<!--<span class="name">-->
<!--iPad mini 32GB WiFi Cellular Black&Slate-->
<!--</span>-->
<!--<span class="price">-->
<!--<i class="fa fa-money"></i> &dollar;447,29-->
<!--</span>-->
<!--<span class="warranty">-->
<!--<i class="fa fa-certificate"></i> Warranty: 4 years-->
<!--</span>-->
<!--</span>-->
            <!--</a>-->
        <!--</li>-->
        <!--<li>-->
            <!--<a href="#">-->
<!--<span class="img">-->
<!--<img src="__PUBLIC__/admin/v3/img/samples/ipad.png" alt=""/>-->
<!--</span>-->
<!--<span class="product clearfix">-->
<!--<span class="name">-->
<!--iPad mini 32GB WiFi Cellular Black&Slate-->
<!--</span>-->
<!--<span class="price">-->
<!--<i class="fa fa-money"></i> &dollar;447,29-->
<!--</span>-->
<!--<span class="warranty">-->
<!--<i class="fa fa-certificate"></i> Warranty: 4 years-->
<!--</span>-->
<!--</span>-->
            <!--</a>-->
        <!--</li>-->
    <!--</ul>-->
    <!--<br/>-->
    <!--<a href="#" class="btn btn-success pull-right">View all users</a>-->
<!--</div>-->
<!--<div class="tab-pane fade" id="tab-todo">-->
    <!--<ul class="widget-todo">-->
        <!--<li class="clearfix">-->
            <!--<div class="name">-->
                <!--<div class="checkbox-nice">-->
                    <!--<input type="checkbox" id="todo-1"/>-->
                    <!--<label for="todo-1">-->
                        <!--New products introduction <span class="label label-danger">High Priority</span>-->
                    <!--</label>-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="clearfix">-->
            <!--<div class="name">-->
                <!--<div class="checkbox-nice">-->
                    <!--<input type="checkbox" id="todo-2"/>-->
                    <!--<label for="todo-2">-->
                        <!--Checking the stock <span class="label label-success">Low Priority</span>-->
                    <!--</label>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="actions">-->
                <!--<a href="#" class="table-link">-->
                    <!--<i class="fa fa-pencil"></i>-->
                <!--</a>-->
                <!--<a href="#" class="table-link danger">-->
                    <!--<i class="fa fa-trash-o"></i>-->
                <!--</a>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="clearfix">-->
            <!--<div class="name">-->
                <!--<div class="checkbox-nice">-->
                    <!--<input type="checkbox" id="todo-3" checked="checked"/>-->
                    <!--<label for="todo-3">-->
                        <!--Buying coffee <span class="label label-warning">Medium Priority</span>-->
                    <!--</label>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="actions">-->
                <!--<a href="#" class="table-link">-->
                    <!--<i class="fa fa-pencil"></i>-->
                <!--</a>-->
                <!--<a href="#" class="table-link danger">-->
                    <!--<i class="fa fa-trash-o"></i>-->
                <!--</a>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="clearfix">-->
            <!--<div class="name">-->
                <!--<div class="checkbox-nice">-->
                    <!--<input type="checkbox" id="todo-4"/>-->
                    <!--<label for="todo-4">-->
                        <!--New marketing campaign <span class="label label-success">Low Priority</span>-->
                    <!--</label>-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="clearfix">-->
            <!--<div class="name">-->
                <!--<div class="checkbox-nice">-->
                    <!--<input type="checkbox" id="todo-5"/>-->
                    <!--<label for="todo-5">-->
                        <!--Calling Mom <span class="label label-warning">Medium Priority</span>-->
                    <!--</label>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="actions">-->
                <!--<a href="#" class="table-link badge">-->
                    <!--<i class="fa fa-cog"></i>-->
                <!--</a>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="clearfix">-->
            <!--<div class="name">-->
                <!--<div class="checkbox-nice">-->
                    <!--<input type="checkbox" id="todo-6"/>-->
                    <!--<label for="todo-6">-->
                        <!--Ryan's birthday <span class="label label-danger">High Priority</span>-->
                    <!--</label>-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="clearfix">-->
            <!--<div class="name">-->
                <!--<div class="checkbox-nice">-->
                    <!--<input type="checkbox" id="todo-7"/>-->
                    <!--<label for="todo-7">-->
                        <!--Printing new flyer <span class="label label-success">Low Priority</span>-->
                    <!--</label>-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="clearfix">-->
            <!--<div class="name">-->
                <!--<div class="checkbox-nice">-->
                    <!--<input type="checkbox" id="todo-8"/>-->
                    <!--<label for="todo-8">-->
                        <!--Mila and Ryan wedding <span class="label label-danger">High Priority</span>-->
                    <!--</label>-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
        <!--<li class="clearfix">-->
            <!--<div class="name">-->
                <!--<div class="checkbox-nice">-->
                    <!--<input type="checkbox" id="todo-9"/>-->
                    <!--<label for="todo-9">-->
                        <!--Checking the stock <span class="label label-success">Low Priority</span>-->
                    <!--</label>-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->
    <!--</ul>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->
<!--<div class="row">-->
    <!--<div class="col-md-6">-->
        <!--<div class="main-box">-->
            <!--<div class="main-box-body clearfix">-->
                <!--<div id="calendar"></div>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
    <!--<div class="col-md-6">-->
        <!--<div class="main-box">-->
            <!--<header class="main-box-header clearfix">-->
                <!--<h2 class="pull-left">Visitors location</h2>-->

                <!--<div class="icon-box pull-right">-->
                    <!--<a href="#" class="btn pull-left">-->
                        <!--<i class="fa fa-refresh"></i>-->
                    <!--</a>-->
                    <!--<a href="#" class="btn pull-left">-->
                        <!--<i class="fa fa-cog"></i>-->
                    <!--</a>-->
                <!--</div>-->
            <!--</header>-->
            <!--<div class="main-box-body clearfix">-->
                <!--<div id="world-map" style="width: 100%; height: 400px"></div>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
<!--</div>-->
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

<script src="__PUBLIC__/admin/v3/js/demo-skin-changer.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery.js"></script>
<script src="__PUBLIC__/admin/v3/js/bootstrap.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery.nanoscroller.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/demo.js"></script>

<script src="__PUBLIC__/admin/v3/js/jquery-ui.custom.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/fullcalendar.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery.slimscroll.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/raphael-min.js"></script>
<script src="__PUBLIC__/admin/v3/js/morris.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/moment.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/daterangepicker.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery-jvectormap-world-merc-en.js"></script>
<script src="__PUBLIC__/admin/v3/js/gdp-data.js"></script>
<script src="__PUBLIC__/admin/v3/js/flot/jquery.flot.js"></script>
<script src="__PUBLIC__/admin/v3/js/flot/jquery.flot.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/flot/jquery.flot.pie.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/flot/jquery.flot.stack.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/flot/jquery.flot.resize.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/flot/jquery.flot.time.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/flot/jquery.flot.threshold.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery.countTo.js"></script>

<script src="__PUBLIC__/admin/v3/js/scripts.js"></script>
<script src="__PUBLIC__/admin/v3/js/pace.min.js"></script>

<script>
$(document).ready(function () {






    /* initialize the external events
     -----------------------------------------------------------------*/

    $('#external-events div.external-event').each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });


    /* initialize the calendar
     -----------------------------------------------------------------*/

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var calendar = $('#calendar').fullCalendar({
        header: {
            left: '',
            center: 'title',
            right: 'prev,next'
        },
        isRTL: $('body').hasClass('rtl'), //rtl support for calendar
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
                calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                        true // make the event "stick"
                );
            }
            calendar.fullCalendar('unselect');
        },
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        drop: function (date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;

            // copy label class from the event object
            var labelClass = $(this).data('eventclass');

            if (labelClass) {
                copiedEventObject.className = labelClass;
            }

            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }

        },
        buttonText: {
            prev: '<i class="fa fa-chevron-left"></i>',
            next: '<i class="fa fa-chevron-right"></i>'
        },
        events: [
            {
                title: 'All Day Event',
                start: new Date(y, m, 1),
                className: 'label-success'
            },
            {
                title: 'Long Event',
                start: new Date(y, m, d - 5),
                end: new Date(y, m, d - 2)
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d - 3, 16, 0),
                allDay: false,
                className: 'label-danger'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d + 4, 16, 0),
                allDay: false
            },
            {
                title: 'Meeting',
                start: new Date(y, m, d, 10, 30),
                allDay: false,
                className: 'label-info'
            },
            {
                title: 'Lunch',
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d, 14, 0),
                allDay: false,
                className: 'label-success'
            },
            {
                title: 'Birthday Party',
                start: new Date(y, m, d + 1, 19, 0),
                end: new Date(y, m, d + 1, 22, 30),
                allDay: false,
                className: 'label-info'
            },
            {
                title: 'Click for Google',
                start: new Date(y, m, 28),
                end: new Date(y, m, 29),
                url: 'http://google.com/',
                className: 'label-danger'
            }
        ]
    });

    $('.conversation-inner').slimScroll({
        height: '332px',
        alwaysVisible: false,
        railVisible: true,
        wheelStep: 5,
        allowPageScroll: false
    });

    //CHARTS
    graphLine = Morris.Line({
        element: 'graph-line',
        data: [
            {period: '2014-01-01', iphone: 2666, ipad: null, itouch: 2647},
            {period: '2014-01-02', iphone: 9778, ipad: 2294, itouch: 2441},
            {period: '2014-01-03', iphone: 4912, ipad: 1969, itouch: 2501},
            {period: '2014-01-04', iphone: 3767, ipad: 3597, itouch: 5689},
            {period: '2014-01-05', iphone: 6810, ipad: 1914, itouch: 2293},
            {period: '2014-01-06', iphone: 5670, ipad: 4293, itouch: 1881},
            {period: '2014-01-07', iphone: 4820, ipad: 3795, itouch: 1588},
            {period: '2014-01-08', iphone: 15073, ipad: 5967, itouch: 5175},
            {period: '2014-01-09', iphone: 10687, ipad: 4460, itouch: 2028},
            {period: '2014-01-10', iphone: 8432, ipad: 5713, itouch: 1791}
        ],
        lineColors: ['#ffffff'],
        xkey: 'period',
        ykeys: ['iphone'],
        labels: ['iPhone'],
        pointSize: 3,
        hideHover: 'auto',
        gridTextColor: '#ffffff',
        gridLineColor: 'rgba(255, 255, 255, 0.3)',
        resize: true
    });

    //WORLD MAP
    $('#world-map').vectorMap({
        map: 'world_merc_en',
        backgroundColor: '#ffffff',
        zoomOnScroll: false,
        regionStyle: {
            initial: {
                fill: '#e1e1e1',
                stroke: 'none',
                "stroke-width": 0,
                "stroke-opacity": 1
            },
            hover: {
                "fill-opacity": 0.8
            },
            selected: {
                fill: '#8dc859'
            },
            selectedHover: {}
        },
        series: {
            regions: [{
                values: gdpData,
                scale: ['#6fc4fe', '#2980b9'],
                normalizeFunction: 'polynomial'
            }]
        },
        onRegionLabelShow: function (e, el, code) {
            el.html(el.html() + ' (' + gdpData[code] + ')');
        }
    });

    $('.infographic-box .value .timer').countTo({});

});
</script>
</body>
</html>