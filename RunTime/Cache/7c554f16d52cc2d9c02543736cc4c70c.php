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
                        <h4 class="modal-title">编辑商品</h4>
                    </div>
                    <form action="/index.php?m=Product&a=save" enctype="multipart/form-data" method="post" role="form" id="add_form" autocomplete="off">
                        <div class="modal-body">
                            <table style="table-layout: fixed; word-wrap:break-word;" class="goods_edit_tbl">
                                <tr>
                                    <td width="100">所属栏目：</td>
                                    <td width="">

                                        <a href="javascript:void(0);" id="select_permission" class="modals_checked_select md-trigger btn btn-primary"
                                           data-inputId="product_class" data-url="/ProductClass/selectJson"
                                           data-title="选择栏目" data-modal="modal_checked_select">选择栏目</a>
                                        <input type="text" name="product_class" class="form-control col-xs-6 modals_radio_select_input" id="product_class" value="<?php echo ($product["pro_class_ids"]); ?>"/>

                                    </td>
                                </tr>
                                <tr>
                                    <td>商品名称：</td>
                                    <td>
                                        <div class="form-group col-xs-8">
                                            <input type="text" name="product_name" id="product_name" class="form-control " value="<?php echo ($product["product_name"]); ?>" >
                                        </div>
                                        </td>
                                </tr>
                                <tr>
                                    <td>商品编号：</td>
                                    <td>
                                        <div class="form-group col-xs-3">
                                            <input type="text" name="product_number" id="product_number" class="form-control " value="<?php echo ($product["product_number"]); ?>">
                                        </div>
                                        </td>
                                </tr>

                                <tr>
                                    <td>上下架：</td>
                                    <td>
                                        <input name="online" id="online" value="0" type="checkbox"
                                            <?php if($product && $product["online"] == 0): ?>checked="checked"<?php endif; ?> />
                                        <label for="online">下架</label>
                                        <input name="mobile_online" id="mobile_online" value="0" type="checkbox"
                                        <?php if($product && $product["mobile_online"] == 0): ?>checked="checked"<?php endif; ?>    />
                                        <label for="mobile_online">手机下架</label>
                                        <input name="app_online" id="app_online" value="0"  type="checkbox"
                                        <?php if($product && $product["app_online"] == 0): ?>checked="checked"<?php endif; ?>   />
                                        <label for="app_online">app下架</label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>生产日期：</td>
                                    <td>
                                        <div class="form-group col-xs-3">
                                            <input type="text" name="production_date" id="production_date" value="<?php echo ($product["production_date"]); ?>" class="form-control" />
                                        </div>
                                        </td>
                                </tr>
                                <tr>
                                    <td>保质期：</td>
                                    <td>
                                        <div class="form-group col-xs-3">
                                            <input type="text" name="expiration_date" id="expiration_date" value="<?php echo ($product["expiration_date"]); ?>" class="form-control" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="form-group col-xs-6">
                                                <span class="label">发货仓（优先级为0，表示最优先</span>
                                                <div><span class="label">1次之，依此类推，中间不能有空的）</span></div>
                                                <button id="add_one_send_warehome" type="button" class="btn btn-primary" onclick="addLine()">增加一条发货仓数据</button>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div id="sendwarehome_data" class="row" add_line="<?php echo ($send_warehomecount - 1); ?>">
                                            <?php if(is_array($send_warehomes)): foreach($send_warehomes as $key=>$value): ?><div id="dev_sendwarehome_id_<?php echo ($key); ?>" class="row sendwarehome_line">
                                                    <div class="form-group col-xs-12">
                                                        <span class="">发货仓号：</span>
                                                        <a href="javascript:void(0);"class="modals_radio_select md-trigger btn btn-primary"
                                                           data-inputId="sendwarehome_id_<?php echo ($key); ?>" data-url="/Postage/selectJsonSendwarehome"
                                                           data-title="选择发货仓" data-modal="modal_radio_select">选择发货仓</a>
                                                        <input type="text" name="sendwarehome_id[]" class="form-control col-xs-1 modals_radio_select_input" id="sendwarehome_id_<?php echo ($key); ?>" value="<?php echo ($value['warehome_id']); ?>"/>
                                                        <span class="form-inline-label">仓名注释：</span>
                                                        <input type="text" name="sendwarehome_name[]" class="form-control col-xs-2 modals_radio_select_input" id="sendwarehome_name_<?php echo ($key); ?>" value="<?php echo ($value['name']); ?>"/>
                                                        <button id="del_one_send_warehome" type="button" class="btn btn-primary" onclick="delLine(<?php echo ($key); ?>)">移除</button>
                                                    </div>
                                                </div><?php endforeach; endif; ?>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>商品图片：</td>
                                    <td>
                                        <input name="upload_photo" id="upload_photo" type="file">
                                        上传的产品图片大小为：640x640<br>
                                        <input type="hidden" id="photo" name="photo" value="<?php echo ($product["photo"]); ?>">  <div id="photo_preview" style="display: inline-block;">
                                        <img src="<?php echo ($img_site); echo ($product["photo"]); ?>" alt="" width="60" />
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>参团页主图：</td>
                                    <td>
                                        <input name="join_photo" id="join_photo" type="file">
                                        上传的产品图片大小为：640x540<br>
                                        <input type="hidden" id="join_img" name="join_img" value="<?php echo ($product["join_img"]); ?>">  <div id="join_photo_preview" style="display: inline-block;"><img src="<?php echo ($img_site); echo ($product["join_img"]); ?>" alt="" width="60" /></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>规格：</td>
                                    <td>
                                        <table border="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td id="gg">
                                                    <table width="100%">
                                                        <tbody>

                                                        <?php if(is_array($product["product_price"])): foreach($product["product_price"] as $key=>$item): ?><tr>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="form-group col-xs-12">
                                                                            量:
                                                                            <input value="<?php echo ($item["volume"]); ?>" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'volume',this.value)" size="10" type="text" class="form-control mb5 col-xs-1" />
                                                                            单位:<input value="<?php echo ($item["unit"]); ?>" size="6" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'unit',this.value)" type="text" class="form-control mb5 col-xs-2" />
                                                                            编号:
                                                                            <input  value="<?php echo ($item["product_no"]); ?>" size="10" ppid="<?php echo ($item["id"]); ?>" pid="<?php echo ($item["product_id"]); ?>" type="text" class="form-control mb5 col-xs-2" />
                                                                            <!--编号(手机):-->
                                                                            <!--<input value="<?php echo ($item["mobile_product_no"]); ?>" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'mobile_product_no',this.value)" size="10" type="text" class="form-control mb5 col-xs-2" />-->
                                                                            价格:￥<input value="<?php echo ($item["price"]); ?>" size="6" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'price',this.value)" type="text" class="form-control mb5 col-xs-2" />
                                                                            <!--价格(手机):￥<input value="<?php echo ($item["mobile_price"]); ?>" size="6" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'mobile_price',this.value)" type="text" class="form-control mb5 col-xs-2" />-->


                                                                            原价:<input value="<?php echo ($item["old_price"]); ?>" size="6" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'old_price',this.value)" type="text" class="form-control mb5 col-xs-2" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        库存:<input value="<?php echo ($item["stock"]); ?>" size="6" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'stock',this.value)" type="text" class="form-control mb5 col-xs-2" />

                                                                        发货渠道：<select onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'send_channel',this.value)" class="form-control mb5 col-xs-2">
                                                                        <option value="">请选择发货渠道</option>
                                                                        <?php if(is_array($supply_list)): foreach($supply_list as $key=>$supply): ?><option value="<?php echo ($supply["name"]); ?>"
                                                                            <?php if(($item["send_channel"]) == $supply["name"]): ?>selected="selected"<?php endif; ?>
                                                                            ><?php echo ($supply["real_name"]); ?></option><?php endforeach; endif; ?>
                                                                    </select>
                                                                        重量:<input value="<?php echo ($item["weight"]); ?>" size="6" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'weight',this.value)" type="text"> kg

                                                                        排序:<input value="<?php echo ($item["order_id"]); ?>" size="6" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'order_id',this.value)" type="text" class="form-control mb5 col-xs-2" />
                                                                        <a href="javascript:del_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>)">删除</a>
                                                                    </div>

                                                                    <div style="">
                                                                        <!--勋章:<select onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'mem_lv',this.value)" class="form-control mb5 col-xs-2" />-->
                                                                            <!--<option value="">请选择勋章...</option>-->
                                                                            <!--<option label="普通会员" value="1" <?php if($item["mem_lv"] == 1): ?>selected="selected"<?php endif; ?>>普通会员</option>-->
                                                                            <!--<option label="鲜果达人" value="2" <?php if($item["mem_lv"] == 2): ?>selected="selected"<?php endif; ?>>鲜果达人</option>-->
                                                                            <!--<option label="水果王" value="3" <?php if($item["mem_lv"] == 3): ?>selected="selected"<?php endif; ?>>水果王</option>-->
                                                                        <!--</select>-->
                                                                        <!--勋章价:￥<input value="<?php echo ($item["mem_lv_price"]); ?>" size="6" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'mem_lv_price',this.value)" type="text" class="form-control mb5 col-xs-2" />-->
          <!--允许普通购买:<input <?php if($item["can_mem_buy"] == 1): ?>checked="checked"<?php endif; ?> value="<?php echo ($item["can_mem_buy"]); ?>"-->
                                           <!--onchange="update_product_gg_checkbox(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'can_mem_buy',this.value)" type="checkbox">-->
                                                                        <!-- update_product_gg(4506,37,'can_mem_buy',this.value) -->
                                                                        <!--开始时间:<input value="0000-00-00 00:00:00" size="22" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'start_time',this.value)"-->
                                                                                    <!--type="text">-->
                                                                        <!--结束时间:<input value="0000-00-00 00:00:00" size="22" onblur="update_product_gg(<?php echo ($item["product_id"]); ?>,<?php echo ($item["id"]); ?>,'over_time',this.value)"-->
                                                                                    <!--type="text">-->
                                                                    </div>
                                                                </td>
                                                            </tr><?php endforeach; endif; ?>

                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!--<span style="color:#FF0000">说明："原价" 和 "结束时间"只对限时特惠产品有效,"开始和结束时间"格式如:2010-08-09 21:02:09。 开启"是否启用库存"后，"库存"填写"-1"或不填表示库存不限制。</span>-->
                                        <table id="gallery-table" border="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" onclick="addImg(this)">[+]</a>
                                                    量:<input name="volume[]" id="volume[]" size="10" type="text" />
                                                    单位:<input name="unit[]" id="unit[]" size="6" type="text" />　
                                                    编号:<input name="product_no[]" id="product_no[]" size="10" type="text" />
                                                    <!--编号(手机):<input name="mobile_product_no[]" id="mobile_product_no[]" size="10" type="text">-->
                                                    价格:￥<input name="price[]" id="price[]" size="6" type="text" /> 元
                                                    <!--价格(手机):￥<input name="mobile_price[]" id="mobile_price[]" size="6" type="text"> 元-->
                                                    排序:<input name="price_order_id[]" id="price_order_id[]" value="0.00" size="4" type="text" /> <br/>
                                                    库存:<input name="stock[]" id="stock[]" value="" size="4" type="text" />
                                                    发货渠道：
                                                    <select name="send_channel[]" class="form-control mb5 col-xs-2">
                                                        <option value="">请选择发货渠道</option>
                                                        <?php if(is_array($supply_list)): foreach($supply_list as $key=>$supply): ?><option value="<?php echo ($supply["name"]); ?>"><?php echo ($supply["real_name"]); ?></option><?php endforeach; endif; ?>
                                                    </select>
                                                    重量:<input name="weight[]" id="weight[]" value="" size="4" type="text" /> kg
                                                    <!--勋章:<select name="mem_lv[]">-->
                                                    <!--<option value="">请选择勋章...</option>-->
                                                    <!--<option label="普通会员" value="0">普通会员</option>-->
                                                    <!--<option label="鲜果达人" value="1">鲜果达人</option>-->
                                                    <!--<option label="水果王" value="2">水果王</option>-->
                                                <!--</select>-->
                                                    <!--勋章价:￥<input name="mem_lv_price[]" id="mem_lv_price[]" value="" size="6" type="text"> 元-->
                                                    <!--允许普通购买:<input name="can_mem_buy[]" id="can_mem_buy[]" value="1" type="checkbox" checked="checked" />-->
						  <!--<span style="color:#FF0000">-->
						    <!--原价格:￥<input name="old_price[]" id="old_price[]" size="6" type="text"> 元-->
                            <!--开始时间:<input name="start_time[]" id="start_time[]" size="22" type="text">-->
						    <!--结束时间:<input name="over_time[]" id="over_time[]" size="22" type="text">-->
						  <!--</span>-->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>赠品：</td>
                                    <td>
                                        <table border="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td id="gift">
                                                    <table>
                                                        <?php if(is_array($product["product_gifts"])): foreach($product["product_gifts"] as $key=>$gifts): ?><tr>
                                                                <td>
 图片: <img src="<?php echo ($img_site); ?>/<?php echo ($gifts["gift_photo"]); ?>" alt="" width="60" />
 名称:<input   size="20" type="text" value="<?php echo ($gifts["gname"]); ?>" onblur="update_product_gift(<?php echo ($gifts["pid"]); ?>,<?php echo ($gifts["id"]); ?>,'gname',this.value)" />
编号:<input  size="10" type="text" value="<?php echo ($gifts["gno"]); ?>"  onblur="update_product_gift(<?php echo ($gifts["pid"]); ?>,<?php echo ($gifts["id"]); ?>,'gno',this.value)"/>
数量:<input  size="5" type="text" value="<?php echo ($gifts["gnum"]); ?>"  onblur="update_product_gift(<?php echo ($gifts["pid"]); ?>,<?php echo ($gifts["id"]); ?>,'gnum',this.value)"/>
价值:￥<input  size="5" type="text" value="<?php echo ($gifts["gprice"]); ?>"  onblur="update_product_gift(<?php echo ($gifts["pid"]); ?>,<?php echo ($gifts["id"]); ?>,'gprice',this.value)"/>元&nbsp;
<br/>
重量:<input  size="5" type="text" value="<?php echo ($gifts["gift_weight"]); ?>" onblur="update_product_gift(<?php echo ($gifts["pid"]); ?>,<?php echo ($gifts["id"]); ?>,'gift_weight',this.value)" />kg
排序：<input  value="<?php echo ($gifts["order_id"]); ?>" size="2" type="text"  onblur="update_product_gift(<?php echo ($gifts["pid"]); ?>,<?php echo ($gifts["id"]); ?>,'order_id',this.value)" />
                                                                    <a href="javascript:del_product_gift(<?php echo ($gifts["pid"]); ?>,<?php echo ($gifts["id"]); ?>)">删除</a>
                                                                </td>
                                                            </tr><?php endforeach; endif; ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table id="gallery-table3" border="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" onclick="addImg2(this,'gallery-table3')">[+]</a>
                                                    图片:
                                                    <input name="gift_photo[]" size="10" id="gift_photo[]" type="file" />
                                                    名称:<input name="gname[]" id="gname[]" size="20" type="text">
                                                    编号:<input name="gno[]" id="gno[]" size="10" type="text">
                                                    数量:<input name="gnum[]" id="gnum[]" size="5" type="text">
                                                    价值:￥<input name="gprice[]" id="gprice[]" size="5" type="text">元&nbsp;
                                                    <br/>
                                                    重量:<input name="gift_weight[]" id="gift_weight[]" size="5" type="text">kg
                                                    排序：<input name="gift_order_id[]" id="gift_order_id[]" value="0" size="2" type="text">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>上传的产品图片大小为：110x110 如果需要修改图片请删除该赠品后重新添加</td>
                                            </tr>
                                            <tr>
                                                <td>最多可选数量:<input name="maxgifts" size="4" value="0" type="text"></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>是否在买赠专区显示：</span>
                                                    <input name="display_in_promotion" value="1" type="checkbox">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!--<tr>-->
                                    <!--<td>优惠码：</td>-->
                                    <!--<td>-->
                                        <!--<input name="promo_code" id="promo_code" value="<?php echo ($product["promo_code"]); ?>" size="6" type="text">-->
                                        <!--　折扣:-->
                                        <!--<select name="discount">-->
                                            <!--<option label="1" value="1" selected="selected">1</option>-->
                                            <!--<option label="2" value="2">2</option>-->
                                            <!--<option label="3" value="3">3</option>-->
                                            <!--<option label="4" value="4">4</option>-->
                                            <!--<option label="5" value="5">5</option>-->
                                            <!--<option label="6" value="6">6</option>-->
                                            <!--<option label="7" value="7">7</option>-->
                                            <!--<option label="8" value="8">8</option>-->
                                            <!--<option label="9" value="9">9</option>-->
                                        <!--</select>-->
                                        <!--　有效期至:-->
                                        <!--<input class="hasDatepicker" name="period" id="period" value="<?php echo ($product["period"]); ?>" size="10" type="text">-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <tr>
                                    <td>微博分享：</td>
                                    <td>
<textarea name="share_content" class="form-control" style="width: 650px;" id="share_content" cols="30" rows="2"><?php echo ($product["share_content"]); ?></textarea> <br/>
                                        微博分享内容字数控制在120字以内。
                                    </td>
                                </tr>
                                <tr>
                                    <td>移动端详情：</td>
                                    <td>
                                        <!-- 加载编辑器的容器 -->
                                        <script id="consumer_tips" name="consumer_tips" type="text/plain"><?php echo ($product["consumer_tips"]); ?></script>
                                    </td>
                                </tr>
                                <!--<tr>-->
                                    <!--<td>摘要：</td>-->
                                    <!--<td>-->
                                        <!--<script id="summary" name="summary" type="text/plain"><?php echo ($product["summary"]); ?></script>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td>温馨提示：</td>-->
                                    <!--<td>-->
                                        <!--<script id="tips" name="tips" type="text/plain"><?php echo ($product["tips"]); ?></script>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                    <!--<td>详细信息：</td>-->
                                    <!--<td>-->
<!--<script id="discription" name="discription" type="text/plain"><?php echo ($product["discription"]); ?></script>-->
                                    <!--</td>-->
                                <!--</tr>-->
                                <tr>
                                    <td>可配送地区：</td>
                                    <td>
                                        <a href="javascript:void(0);" id="select_send_region" class="modals_checked_select md-trigger btn btn-primary"
                                           data-inputId="send_region" data-url="/Area/selectJson"
                                           data-title="选择可配送地区" data-modal="modal_checked_select">选择可配送地区</a>
                                        <input type="text" name="send_region" class="form-control col-xs-6 modals_radio_select_input" id="send_region" value="<?php echo ($product["send_region_ids"]); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>排序：</td>
                                    <td><input type="text" value="<?php echo ($product["order_id"]); ?>" size="4" id="order_id" name="order_id"> 数值大的排前面</td>
                                </tr>
                                <tr>
                                    <td>江浙皖排序：</td>
                                    <td><input type="text" value="<?php echo ($product["jzw_order_id"]); ?>" size="4" id="jzw_order_id" name="jzw_order_id"></td>
                                </tr>
                            </table>
                            <input type="hidden" value="<?php echo ($product["id"]); ?>" size="4" id="id" name="id">
                        </div>

                        <div class="modal-footer">
                            <button id="form_save" class="btn btn-primary">保存</button>
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

<div id="modal_checked_select" class="md-modal md-effect-1">
    <div class="md-content">
        <div class="modal-header">
            <button class="md-close close">×</button>
            <h4 class="modal-title">弹出框标题</h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <button class="btn btn-default" type="button" id="modal_checked_select_cancel">取消</button>
            <button class="btn btn-primary" type="button" id="modal_checked_select_confirm" data-inputId="">确定</button>
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

<!-- 配置文件 -->
<script src="__PUBLIC__/admin/js/ueditor143/ueditor.config.js" ype="text/javascript"></script>
<!-- 编辑器源码文件 -->
<script src="__PUBLIC__/admin/js/ueditor143/ueditor.all.js" ype="text/javascript"></script>
<script src="__PUBLIC__/admin/js/ajaxfileupload.js" ype="text/javascript"></script>
<script src="__PUBLIC__/admin/js/table_tr_add_remove.js" ype="text/javascript"></script>

<!--时期时间选择器-->
<script src="__PUBLIC__/admin/v3/js/bootstrap-datepicker.js"></script>
<script src="__PUBLIC__/admin/v3/js/moment.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/daterangepicker.js" type="text/javascript"></script>

<!--模态弹出框专属-->
<script src="__PUBLIC__/admin/v3/js/modernizr.custom.js"></script>
<script src="__PUBLIC__/admin/v3/js/classie.js"></script>
<script src="__PUBLIC__/admin/v3/js/modalEffects.js"></script>
<script src="__PUBLIC__/admin/v3/js/shipinmmm/modals-select.js" type="text/javascript"></script>

<script src="__PUBLIC__/admin/v3/js/scripts.js"></script>
<script src="__PUBLIC__/admin/v3/js/pace.min.js"></script>

<script src="__PUBLIC__/admin/v3/js/shipinmmm/modals-select.js" type="text/javascript"></script>

<script type="text/javascript">

    function addLine()
    {
        var parentNode = $('#sendwarehome_data');
        var vline_num = parseInt(parentNode.attr("add_line"))+1;
        parentNode.attr("add_line",vline_num);
        var src  = '<div id="dev_sendwarehome_id_'+vline_num+'" class="row sendwarehome_line">' +
                '<div class="form-group col-xs-12">' +
                '<span class="">发货仓号：</span>' +
                '<a href="javascript:void(0);" class="modals_radio_select md-trigger btn btn-primary" ' +
                'data-inputId="sendwarehome_id_'+vline_num+'" data-url="/Postage/selectJsonSendwarehome" ' +
                'data-title="选择发货仓" data-modal="modal_radio_select">选择发货仓</a>' +
                '<input type="text" name="sendwarehome_id[]" class="form-control col-xs-1 modals_radio_select_input" id="sendwarehome_id_'+vline_num+'"/>'+
                '<span class="">仓名注释</span>' +
                '<input type="text" name="sendwarehome_name[]" class="form-control col-xs-2 modals_radio_select_input"/>'+
                '<button id="del_one_send_warehome" type="button" class="btn btn-primary" onclick="delLine('+vline_num+')">移除</button>' +
                '</div>'+
                '</div>';
        parentNode.append(src);

        mModalEffect();
        modals_select_datalink();
    }

    function delLine(line_id)
    {
        var id = "dev_sendwarehome_id_"+line_id;
        var divid = '#'+id;
        var devNode = $(divid);
        devNode.remove();
    }

    $(function($){

        $('#production_date').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            autoclose: true,
            todayBtn: 'linked',
            language: 'zh-CN'
        });

        $('#expiration_date').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            autoclose: true,
            todayBtn: 'linked',
            language: 'zh-CN'
        });



        <!-- 实例化编辑器 -->
        var ue = UE.getEditor('summary');
        var ue = UE.getEditor('tips');
        var ue = UE.getEditor('discription');
        var ue = UE.getEditor('consumer_tips');

        $("#upload_photo").on("change", function () {
            ajaxFileUpload('upload_photo', 'photo');
            $('#upload_photo').val('');
            $("#upload_photo").replaceWith($("#upload_photo").clone(true));
        });

        $("#join_photo").on("change", function () {
            ajaxFileUpload('join_photo', 'join_img');
            $('#join_photo').val('');
            $("#join_photo").replaceWith($("#join_photo").clone(true));
        });

        function ajaxFileUpload(id, type){
            $.ajaxFileUpload(
                    {
                        url: '/Upyun/uploadimg', //用于文件上传的服务器端请求地址
                        secureuri: false, //是否需要安全协议，一般设置为false
                        fileElementId: id, //文件上传域的ID
                        dataType: 'json', //返回值类型 一般设置为json
                        type: 'post',
                        success: function (data, status)  //服务器成功响应处理函数
                        {
                            switch (type){
                                case 'photo':
                                    var imgUrl = data.full_url + '!thumbs';
                                    $('#photo_preview').html('<img src="' + imgUrl + '" width="60"  />');
                                    $('#photo').val(data.img_url);
                                    console.log('data==' + data.url, 'status==' + status);
                                    break;

                                case 'join_img':
                                    var imgUrl = data.full_url + '!thumbs';
                                    $('#join_photo_preview').html('<img src="' + imgUrl + '" width="60"  />');
                                    $('#join_img').val(data.img_url);
                                    console.log('data==' + data.url, 'status==' + status);
                                    break;

                            }

                        },
                        error: function (data, status, e)//服务器响应失败处理函数
                        {

                        }
                    }
            )
        }
    });
</script>
</body>
</html>