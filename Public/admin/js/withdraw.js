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

//提现申请后台相关操作
//1.提现申请审核
$('#withdrawCheck').on('click', function(){
    $.messager.confirm('审核确认', '确定要通过审核吗?', function(r){
        var url = "/admin.php/orders/actStatus";
        if(r){
            doActStatus(pTr, orderId, actionId, url, 1);
        } else {
            //审核不通过要选择/填写原因
            doActStatus(pTr, orderId, actionId, url, 0);
        }
    });
});



//2.提现申请付款
$('#withdrawPay').on('click', function(){

});


function doActStatus(pTr, oId, actionId, url, status){
    var data = {'oId': oId, 'actionId' : actionId, 'status' : status};
    //更新单条订单信息
    $.post(url, data, function(res){
        var result = $.parseJSON(res);
        var prevTr = pTr.prev('tr');
        pTr.remove();
        prevTr.after(result['data']);
    });
}