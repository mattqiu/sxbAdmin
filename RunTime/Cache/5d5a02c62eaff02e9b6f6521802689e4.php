<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>时品网管理中心</title>
    <link href="__PUBLIC__/admin/css/base.css" rel="stylesheet" type="text/css" />
    <link href="__PUBLIC__/admin/css/comm.css" rel="stylesheet" type="text/css" />
    <link href="__PUBLIC__/admin/css/default.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/js/jquery-easyui-1.4/themes/bootstrap/easyui.css">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/js/jquery-easyui-1.4/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/main.css" />
    <script type="text/javascript" src="__PUBLIC__/admin/js/jquery-easyui-1.4/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/admin/js/jquery-easyui-1.4/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/admin/js/base.js"></script>
    <script type="text/javascript" src="__PUBLIC__/admin/js/action.js"></script>
</head>
<body>

<link rel="stylesheet" href="__PUBLIC__/admin/css/comm.css"/>
<link rel="stylesheet" href="__PUBLIC__/admin/css/main.css"/>
    <h2>出库单号：<?php echo ($out_storage_no); ?></h2>
    <table width="100%" style="margin:5px 10px 0;">
        <thead id="m-theader">
        <tr>
            <th width="55%">品名</th>
            <th width="15%">货号</th>
            <th width="15%">数量</th>
            <th width="15%">发货数量</th>
        </tr>
        </thead>
        <tbody id="m-order">
        <?php if(is_array($list)): foreach($list as $key=>$item): ?><tr>
                <td><?php echo ($item["product_name"]); ?></td>
                <td><?php echo ($item["product_no"]); ?></td>
                <td><?php echo ($item["pnum"]); ?></td>
                <td></td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>




<script type="text/javascript" src="__PUBLIC__/admin/js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/admin/js/orders.js"></script>
<script type="text/javascript">
    $(function ($) {
        //初始化事件
        initOrder();
    });

    // input全选反选联动
    var oBtn=document.getElementById("check_all");
    var oBox=document.getElementById("m-order");
    var aInput=oBox.getElementsByTagName("input");
    oBtn.onclick=function(){
        for(var i=0; i<aInput.length;i++){
            aInput[i].checked=this.checked;
        }
    }
    for(var i=0;i<aInput.length;i++){
        aInput[i].onclick=function(){
            var count=0;
            for(var i=0;i<aInput.length;i++){
                if(aInput[i].checked){
                    count++;
                }
            }
            if(count==aInput.length){
                oBtn.checked=true;
            }else{
                oBtn.checked=false;
            }
        }
    }

</script>