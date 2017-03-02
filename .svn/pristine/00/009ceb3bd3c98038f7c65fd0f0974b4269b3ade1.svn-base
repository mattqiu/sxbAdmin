// +----------------------------------------------------------------------
// | 上海时品信息科技有限公司
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id$

function statusAct(){
    //订单状态操作
    $('.orderStatus').on('mouseover', function(){
        var _this = $(this);
        _this.find('.actionStatus').css('display', 'block');
    }).on('mouseout', function(){
            $(this).find('.actionStatus').css('display', 'none');
        });

    $('.actionStatus a').on('click', function(){
        var _this = $(this);
        var pTr = _this.parents('.orderItem');
        var orderId = pTr.attr('data-id');
        var actionId = _this.attr('data-id');

        switch(actionId){
            case 'delivery':
                var url = '/Order/doSendGoods';
                var data = {order_name:orderId};
                $.get(url, data, function(result){
                    if(result.status == 1){

                    }

                }, 'json');


                break;
        }
    });
}

function doOrderAction(pTr, oId, actionId, url, status){
    var data = {'oId': oId, 'actionId' : actionId, 'status' : status};
    //更新单条订单信息
    $.post(url, data, function(res){
        var result = $.parseJSON(res);
        var prevTr = pTr.prev('.orderItem');
        pTr.remove();
        prevTr.after(result['data']);
    });
}

/**
 * 展开订单详情
 */
function expandDetail(){
    //显示订单详情
    $('.expandDetail').on('click', function(){
        var _this = $(this);
        var pTr = _this.parents('.orderTr');
        var detailTr = pTr.next('tr.ordersDetail');
        var closeDetail = _this.next('.closeDetail');
        var orderId = pTr.attr('data-id');
        if(_this.hasClass('isShow')){
            //当前是展开状态,单击后变关闭状态
            _this.removeClass('isShow');
            detailTr.css('display', 'none');
            _this.html('+');
        } else{
            _this.addClass('isShow');
            _this.html('-');

            if(parseInt(_this.attr('data-isLoad')) > 0){
                detailTr.css('display', 'block');
            } else {
                //请求订单详情信息 TODO 权限验证
                var url = '/admin.php/orders/getDetail';
                var data = {'o_id' : orderId};
                $.get(url, data, function(res){
                    pTr.after(res);
                    _this.attr('data-isLoad', '1');
                });
            }
        }
    });
}

/**
 * 初始化操作事件
 */
function initOrder(){
    statusAct();
    expandDetail();

    //显示导出订单窗口
    $('#export_order_btn').on('click', function(){
        $('#export_order_dialog').css('display', 'block').dialog();
    });

    $('#create_out_storage_btn').on('click', function(){
        $('#create_out_storage_dialog').css('display', 'block').dialog();
    });

    $('#create_pick_up_goods_btn').on('click', function(){
        $('#create_pick_up_goods_dialog').css('display', 'block').dialog();
    });

    //向服务器端发送导出订单请求
    $('#do_export_order_btn').on('click', function(){
        //var exportType = $('#export_order_type').val();
        //var url = '/index.php?m=order&a=exportOrder';
        //var data = {'export_type' : exportType};
        //$.post(url, data, function (){
        //
        //}, 'json')
    });

    //查看订单详情
    $('.showOrderDetail').on('click', function(){
        var orderName = $(this).attr('data-id');
        var url = '/index.php?m=order&a=orderDetail';
        var data = {order_name : orderName};
        $.get(url, data, function(data){

            var orderDetailWin = $('#order_detail_win');
            orderDetailWin.html(data);
            orderDetailWin.center({
                width:'100%',
                height:'450',
                modal:true
            });

        }, 'html');
    });
}