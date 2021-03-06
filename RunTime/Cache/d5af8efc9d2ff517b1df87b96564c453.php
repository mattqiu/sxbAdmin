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

<script src="/Public/admin/js/groupbuy.js"></script>

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
                                    <li class="active"><span>团购管理</span></li>
                                </ol>
                                <h1>Advanced tables</h1>
                            </div>
                        </div>

                        <form action="/index.php?m=GroupBuyingOrder&a=index" method="post" target="_self" role="form">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="groupbuy_time_type">查询时间</label>
                                <select  id="groupbuy_time_type" class="form-control" name="groupbuy_time_type">
                                    <option value="0" <?php if($post["groupbuy_time_type"] == 0): ?>selected<?php endif; ?> >按下单时间查询</option>
                                    <option value="1" <?php if($post["groupbuy_time_type"] == 1): ?>selected<?php endif; ?> >按最近更新时间查询</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="datepickerDateFrom" class="form-inline-label">从：</label>
                                        <div class="input-group form-inline-input-group w150">
                                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                            <input type="text" id="datepickerDateFrom" class="form-control" name="limit_date_From" value="<?php echo ($post["limit_date_From"]); ?>">
                                        </div>

                                        <div class="input-group input-append bootstrap-timepicker" style="width: 150px; float: right;">
                                            <input type="text" class="form-control timepicker" id="timepicker_From" name="limit_time_From"
                                                   value="<?php echo ($post["limit_time_From"]); ?>" />
                                            <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="datepickerDateTo" class="form-inline-label">到：</label>
                                        <div class="input-group form-inline-input-group w150">
                                            <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                            <input type="text" id="datepickerDateTo" class="form-control" name="limit_date_To" value="<?php echo ($post["limit_date_To"]); ?>">
                                        </div>

                                        <div class="input-group input-append bootstrap-timepicker" style="width: 150px; float: right;">
                                            <input type="text" class="form-control timepicker" id="timepicker_To" name="limit_time_To"
                                                   value="<?php echo ($post["limit_time_To"]); ?>" />
                                            <span class="add-on input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="groupbuy_order_name" class="form-inline-label">根据团单号查询：</label>
                                <input type="text" class="form-control" value="<?php echo ($post["groupbuy_order_name"]); ?>" id="groupbuy_order_name" name="groupbuy_order_name"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="order_name" class="form-inline-label">根据订单号查询：</label>
                                <input type="text" class="form-control" value="<?php echo ($post["order_name"]); ?>" id="order_name" name="order_name"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="groupbuy_order_name" class="form-inline-label">根据手机号查询：</label>
                                <input type="text" class="form-control" value="<?php echo ($post["recv_phone"]); ?>" id="recv_phone" name="recv_phone"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="order_name" class="form-inline-label">根据用户名查询：</label>
                                <input type="text" class="form-control" value="<?php echo ($post["recv_name"]); ?>" id="recv_name" name="recv_name"/>
                            </div>
                        </div>
                            <div class="row">
                            <div class="form-group col-md-4">
                                <label for="uid" class="form-inline-label">根据用户ID查询：</label>
                                <input type="text" class="form-control" value="<?php echo ($post["uid"]); ?>" id="uid" name="uid"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <button id="group_orders" type="submit"  class=" btn btn-primary mrg-b-lg">确定</button>
                            </div>
                        </div>


                        </form>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-box clearfix">
                                    <header class="main-box-header clearfix">
                                        <h2>团购订单列表</h2>
                                        <div class="main-box-header-act">
                                        </div>
                                    </header>

                                    <div class="main-box-body clearfix">
                                        <div class="table-responsive">
                                            <table id="table-example-fixed" class="table table-hover text-center">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="check_all"/>&nbsp;团ID</th>
                                                    <th class="text-center">团单号</th>
                                                    <th class="text-center">关联订单号</th>
                                                    <th class="text-center">用户ID</th>
                                                    <th class="text-center">用户昵称</th>
                                                    <th class="text-center">收件人&电话</th>
                                                    <th class="text-center">收件人地址</th>
                                                    <th class="text-center">团购名</th>
                                                    <th class="text-center">支付金额</th>
                                                    <th class="text-center">支付渠道</th>
                                                    <th class="text-center">订单状态</th>
                                                    <th class="text-center">订单创建时间</th>
                                                    <th class="text-center">最近更新时间</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(is_array($list)): foreach($list as $key=>$item): $key = $key+1; ?>
                                                    <tr>
    <td ><input type="checkbox" />&nbsp;
        <a href="<?php echo U('GroupBuying/index');?>&id=<?php echo ($item["groupbuying_id"]); ?>" target="_blank"><?php echo ($item["groupbuying_id"]); ?></a>
    </td>
    <td><?php echo ($item["groupbuy_order_name"]); ?></td>
    <td ><?php echo ($item["order_name"]); ?></td>
    <td><?php echo ($item["uid"]); ?></td>
    <td><?php echo ($item["nickname"]); ?></td>
    <td ><?php echo ($item["recv_name"]); ?><br><?php echo ($item["recv_phone"]); ?></td>
    <td><?php echo ($item["recv_address"]); ?></td>
    <td><?php echo ($item["groupbuying_name"]); ?></td>
    <td><?php echo ($item["pay_money"]); ?></td>
    <td><?php echo ($item["pay_name"]); ?></td>
    <td><?php echo ($item["state"]); ?></td>
    <td><?php echo ($item["create_time"]); ?></td>
    <td><?php echo ($item["last_update_time"]); ?></td>

    <td></td>
</tr><?php endforeach; endif; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page">
                            <?php echo ($page); ?>
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

<div class="md-modal md-effect-1 rushToPurchase" id="export_order_dialog">
    <div class="md-content">
        <div class="modal-header">
            <button class="md-close close">&times;</button>
            <h4 class="modal-title">新建团购</h4>
        </div>
        <form action="/index.php?m=GroupBuying&a=add"  method="post" role="form" id="add_form">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-xs-3">
                        <span class="label">商品id</span><input type="text" name="product_id" class="form-control col-xs-6"/>
                    </div>

                    <div class="form-group col-xs-8">
                        <span class="label">商品名称:</span>  <span id="goods_name"></span>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-xs-5">
                        <span class="label">原价:</span>  <span id="old_price"></span>
                    </div>

                    <div class="form-group col-xs-5">
                        <span class="label">单独购买价格:</span><input type="text" name="separatebuy_price" id="separatebuy_price" class="form-control col-xs-6"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-5">
                        <span class="label">团购名:</span><input type="text" name="groupbuying_name" id="groupbuying_name" class="form-control col-xs-8"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-10">
                        <span class="label">描述:</span>
                        <textarea name="groupbuying_des" id="groupbuying_des" cols="40" rows="2"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-5">
                        <span class="label">团购价格:</span><input type="text" name="groupbuying_price" id="groupbuying_price" class="form-control col-xs-8"/>
                    </div>

                    <div class="form-group col-xs-5">
                        <span class="label">成团人数:</span><input type="text" name="groupbuying_reqnums" id="groupbuying_reqnums" class="form-control col-xs-8"/>
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
                            <option value="0">准备上架</option>
                            <option value="1">上架</option>
                            <option value="2">下架</option>
                        </select>
                    </div>

                    <div class="form-group col-xs-5">
                        <span class="label">已售出数量:</span>
                        <input type="text" name="salenum" id="salenum" class="form-control col-xs-6"/>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-5">
                        <span class="label">邮费:</span>
                        <input type="text" name="postage" id="postage" class="form-control col-xs-6"/>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="form_save" class="btn btn-primary" >保存</button>
                </div>
        </form>
    </div>
</div>
</div>

<div class="md-overlay"></div>

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

<script type="text/javascript">
$(function($){
    $('.off_type').on('change', function(){
        var _this = $(this);
        var wrapId = _this.attr('data-id');
        $('.offType-wrap').css('display', 'none');
        $('#' + wrapId).css('display', 'block');
    });

    $('#form_save').on('click', function(){
        var _this = $(this);
        _this.attr('disabled', 'disabled');
        $('#add_form').submit();
    })
});


</script>

<!--时期时间选择器-->
<script src="__PUBLIC__/admin/v3/js/bootstrap-datepicker.js"></script>
<script src="__PUBLIC__/admin/v3/js/moment.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/daterangepicker.js" type="text/javascript"></script>
<script src="__PUBLIC__/admin/v3/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

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
    });
</script>

</body>
</html>