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
                        updateOrderItem(orderId);
                    } else {
                        alert(result.msg);
                    }

                }, 'json');

                break;
        }
    });
}

function updateOrderItem(orderName){
    var _this = $('#tb_' + orderName);
    var url = '/Order/ajaxOrderItem';
    var data = {order_name:orderName};
    $.get(url, data, function(result){
        if(result.status == 1){
            _this.empty();
            _this.append(result.data);
            statusAct();
        }
    }, 'json');

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

function saveMergeDelivery(){
    $('#save_merge_delivery').on('click', function(){
        var checkedOrders = [];
        $('.checkOrder:checked').each(function(){
            checkedOrders.push($(this).val());
        });


        if(checkedOrders.length > 0){
            var url = '/Order/mergeDelivery';
            var deliveryCompany = $('#sel_delivery_company').val();
            var deliveryId = $('#used_delivery_id').val();

            if(deliveryCompany == 0 || deliveryId == ''){
                alert('快递公司和单号不完整');
                return;
            }

            var data = {order_names: checkedOrders.join(','), delivery_company: deliveryCompany, delivery_id: deliveryId};
            $.post(url, data, function(result){
                if(result.status == 1){
                    location.reload(true);
                }
            });
        } else {
            alert('请选择要合并的订单');
            return;
        }



    });
}

/**
 * 初始化操作事件
 */
function initOrder(){
    statusAct();
    saveMergeDelivery();
}

