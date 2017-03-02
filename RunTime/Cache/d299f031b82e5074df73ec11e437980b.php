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
                        <h4 class="modal-title">添加广告</h4>
                    </div>
                    <form action="/<?php echo (MODULE_NAME); ?>/save"  method="post" role="form" id="add_form" autocomplete="off">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <span class="label col-xs-2">位置</span>
                                    <select name="position" id="position" class="form-control col-xs-2" >
                                        <option value="" selected="selected">请选择</option>
                                        <?php if(is_array($position_conf)): foreach($position_conf as $key=>$item): ?><option value="<?php echo ($item["id"]); ?>"
                                            <?php if(($item["id"]) == $banner["position"]): ?>selected="selected"<?php endif; ?>
                                                    ><?php echo ($item["name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <span class="label col-xs-2">类型</span>
                                    <select name="type" id="type" class="form-control col-xs-2" autocomplete="off">
                                        <option value="" selected="selected">请选择</option>
                                        <?php if(is_array($type_conf)): foreach($type_conf as $key=>$item): ?><option value="<?php echo ($item["id"]); ?>"
                                                    <?php if(($item["id"]) == $banner["type"]): ?>selected="selected"<?php endif; ?>
                                                    ><?php echo ($item["name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-12 type_link_id" id="target_id_wrap">
                                    <span class="label col-xs-2">目标页id(商品id)</span>
                                    <a href="javascript:void(0);" id="select_target_id" class="modals_radio_select md-trigger btn btn-primary"
                                       data-inputId="target_id" data-url="/Product/selectJson"
                                       data-title="选择商品" data-modal="modal_radio_select">选择商品</a>
                                    <input type="text" name="target_id" class="form-control col-xs-2 modals_radio_select_input" id="target_id" value="<?php echo ($banner["target_id"]); ?>"/>
                                </div>

                                <div class="form-group col-xs-12 type_link_id" id="panicbuying_id_wrap">
                                    <span class="label col-xs-2">抢购id</span>
                                    <a href="javascript:void(0);" id="select_panicbuying_id" class="modals_radio_select md-trigger btn btn-primary"
                                       data-inputId="panicbuying_id" data-url="/PanicBuying/selectJson"
                                       data-title="选择抢购id" data-modal="modal_radio_select">选择抢购id</a>
                                    <input type="text" name="panicbuying_id" class="form-control col-xs-2 modals_radio_select_input" id="panicbuying_id" value="<?php echo ($banner["panicbuying_id"]); ?>"/>

                                </div>

                                <div class="form-group col-xs-12 type_link_id" id="groupbuyingtml_id_wrap">
                                    <span class="label col-xs-2">团购模板id</span>
                                    <a href="javascript:void(0);" id="select_groupbuyingtml_id" class="modals_radio_select md-trigger btn btn-primary"
                                       data-inputId="groupbuyingtml_id" data-url="/GroupBuyingTml/selectJson"
                                       data-title="选择团购模板id" data-modal="modal_radio_select">选择团购模板id</a>
                                    <input type="text" name="groupbuyingtml_id" class="form-control col-xs-2 modals_radio_select_input" id="groupbuyingtml_id" value="<?php echo ($banner["groupbuyingtml_id"]); ?>"/>

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <span class="label col-xs-2">标题</span>
                                    <input type="text" name="title" id="title" class="col-xs-8 form-control" value="<?php echo ($banner["title"]); ?>" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <span class="label col-xs-2">描述</span>
                                    <textarea name="description" id="description" cols="30" rows="3" class="col-xs-8 form-control"><?php echo ($banner["description"]); ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <span class="label col-xs-2">链接(以?结尾)</span>
                                    <input type="text" name="page_url" id="page_url" value="<?php echo ($banner["page_url"]); ?>" class="form-control col-xs-8" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <span class="label col-xs-2">上传图片</span>
                                    <input name="upload_photo" id="upload_photo" type="file"><br>
                                    <input type="hidden" id="photo" name="photo" value="<?php echo ($banner["photo"]); ?>">  <div id="photo_preview" style="display: inline-block;">
                                    <img src="<?php echo ($img_site); ?>/<?php echo ($banner["photo"]); ?>" alt="" width="80">

                                </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-4">
                                    <span class="label col-xs-6">排序</span>
                                    <input type="text" name="sort" id="sort" value="<?php echo ($banner["sort"]); ?>" class="form-control col-xs-4" />  数值大的排前面
                                </div>

                                <div class="form-group col-xs-6">
                                    <span class="label col-xs-4">是否置顶</span>
                                    <input type="radio" name="is_top" id="is_top_yes" value="1"  autocomplete="off"
                                    <?php if(($banner["is_top"]) == "1"): ?>checked="checked"<?php endif; ?>
                                            />
                                    <label for="is_top_yes">是</label>
                                    <input type="radio" name="is_top" id="is_top_no" value="0" autocomplete="off"
                                    <?php if(($banner["is_top"]) == "0"): ?>checked="checked"<?php endif; ?>
                                            />
                                    <label for="is_top_no">否</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <span class="label col-xs-2">是否展示</span>
                                    <input type="radio" name="is_show" id="is_show_yes" value="1"  autocomplete="off"
                                            <?php if(($banner["is_show"]) == "1"): ?>checked="checked"<?php endif; ?>
                                            />
                                    <label for="is_show_yes">是</label>
                                    <input type="radio" name="is_show" id="is_show_no" value="0" autocomplete="off"
                                    <?php if(($banner["is_show"]) == "0"): ?>checked="checked"<?php endif; ?>
                                            />
                                    <label for="is_show_no">否</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <span class="label col-xs-2">展示地区</span>
                                    <a href="javascript:void(0);" id="select_send_region" class="modals_checked_select md-trigger btn btn-primary"
                                       data-inputId="send_region" data-url="/Area/selectJson"
                                       data-title="选择展示地区" data-modal="modal_checked_select">选择展示地区</a>
                                    <input type="text" name="send_region" class="form-control col-xs-8 modals_radio_select_input" id="send_region" value="<?php echo ($banner["send_region"]); ?>"/>


                                </div>
                            </div>

                            <input type="hidden" name="id" value="<?php echo ($banner["id"]); ?>">

                            <div class="modal-footer">
                                <button id="form_save" class="btn btn-primary" >保存</button>
                            </div>
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

<div class="md-overlay" id="md-overlay"></div>

<script src="__PUBLIC__/admin/v3/js/demo-skin-changer.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery.js"></script>
<script src="__PUBLIC__/admin/v3/js/bootstrap.js"></script>
<script src="__PUBLIC__/admin/v3/js/jquery.nanoscroller.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/demo.js"></script>

<!--模态弹出框专属-->
<script src="__PUBLIC__/admin/v3/js/modernizr.custom.js"></script>
<script src="__PUBLIC__/admin/v3/js/classie.js"></script>
<script src="__PUBLIC__/admin/v3/js/modalEffects.js"></script>

<script src="__PUBLIC__/admin/v3/js/scripts.js"></script>
<script src="__PUBLIC__/admin/v3/js/pace.min.js"></script>

<!--时期时间选择器-->
<script src="__PUBLIC__/admin/v3/js/bootstrap-datepicker.js"></script>
<script src="__PUBLIC__/admin/v3/js/moment.min.js"></script>
<script src="__PUBLIC__/admin/v3/js/daterangepicker.js" type="text/javascript"></script>
<script src="__PUBLIC__/admin/v3/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

<script src="__PUBLIC__/admin/v3/js/shipinmmm/modals-select.js" type="text/javascript"></script>

<script src="__PUBLIC__/admin/js/ajaxfileupload.js" ype="text/javascript"></script>
<script type="text/javascript">
    $(function($){

        if($('#form_save').length>0) {
            $('#form_save').on('click', function () {
                var _this = $(this);
                //_this.attr('disabled','disabled');
                var parentForm = _this.parents('form');
                parentForm.submit();
            })
        }


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
        $('#to_date').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            startDate:new Date(),
            autoclose: true,
            todayBtn: 'linked',
            language: 'zh-CN'
        });

        $('#begin_time').datepicker({
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

        $('#type').on('change', function(){
            var _this = $(this);
            var selValue = _this.val();
            $('.type_link_id').css('display', 'none');
            switch(selValue){
                case "4":
                    //抢购
                    $('#panicbuying_id_wrap').css('display', 'block');

                    break;

                case  "20":
                    //团购
                    $('#groupbuyingtml_id_wrap').css('display', 'block');
                    break;

                default :
                    //默认是商品id
                    $('#target_id_wrap').css('display', 'block');
                    break;
            }

        });

        $("#upload_photo").on("change", function () {
            ajaxFileUpload('upload_photo', 'photo');
            $('#upload_photo').val('');
            $("#upload_photo").replaceWith($("#upload_photo").clone(true));
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

                            }

                        },
                        error: function (data, status, e)//服务器响应失败处理函数
                        {
                            alert('服务器响应失败');

                        }
                    }
            )
        }
    });
</script>
</body>
</html>