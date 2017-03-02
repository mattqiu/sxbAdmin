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

/**
 * 后台退货相关js操作
 */

$('.refundAction a').on('click', function(){
    var _this = $(this);
    var id =  _this.attr('data-id');
    var actionId = _this.attr('data-action');

    switch(actionId){
        case 'check' :
            //退货客服审核
            createAjaxWin();
            var url = '/admin.php/returnOrder/checkReturn?id=' + id;
            var ajaxWin = $('#ajaxWin');
            ajaxWin.window({width:400, height:300, modal:true, title:'退货审核'  });
            ajaxWin.window('open');
            ajaxWin.window('refresh', url);


            //$.messager.confirm('退货客服审核', '确认通过审核吗？', function(r){
            //    var url = '/admin.php/returnOrder/check?id=' + id;
            //    if(r){
            //        doReturnAction(id,  url, 1);
            //    } else {
            //        notPassCheck(id, url, 0);
            //    }
            //});
            break;

        case 'take':
            //退货入库审核
            $.messager.confirm('退货入库审核', '确认符合退货入库条件吗？', function(r){
                var url = '/admin.php/returnOrder/take?id=' + id;
                if(r){
                    doReturnAction( id, url, 1);
                } else {
                    noPassTake();
                }
            });

            break;

        case 'refund':
            //退款操作
            createAjaxWin();
            var url = '/admin.php/returnOrder/refund?id=' + id;
            var ajaxWin = $('#ajaxWin');
            ajaxWin.window({width:400, height:300, modal:true, title:'订单退款'  });
            ajaxWin.window('open');
            ajaxWin.window('refresh', url);

            break;
    }
});

$('input[name=isPass]').on('change', function(){
    var _this = $('this');
    var notPassSeason = $('#notPassSeason');
    if(_this.val() > 0){
        notPassSeason.css('display', 'none');
    } else {
        notPassSeason.css('display', 'block');
    }
});


function doReturnAction(id,  url, status){
    var data = {'id': id, 'status' : status};
    //更新单条订单信息
    $.post(url, data, function(res){
        var res = $.parseJSON(res);
        if(res.status > 0){
            var id = res.data['id'];
            var html = res.data['html'];
            var thisTbody = $('tbody_'. id);
            thisTbody.empty();
            thisTbody.append(html);
        }
    });
}

//未通过退货申请
function notPassCheck(id, url, status){
    var url = '/admin.php/returnOrder/checkNoPass?id=' + id;
    var ajaxWin = $('#ajaxWin');
    ajaxWin.window({width:400, height:300, modal:true, title:'审核不通过原因'  });
    ajaxWin.window('open');
    ajaxWin.window('refresh', url);
}

//未通过入库审核
function noPassTake(){
    var url = '/admin.php/returnOrder/takeNoPass?id=' + id;
    var ajaxWin = $('#ajaxWin');
    ajaxWin.window({width:400, height:300, modal:true, title:'审核不通过原因'  });
    ajaxWin.window('open');
    ajaxWin.window('refresh', url);

}

function doAct(pTbody, url, id, status){
//    var data = {'id': id,  'status' : status};
//    //更新单条订单信息
//    $.post(url, data, function(res){
//        var result = $.parseJSON(res);
//        if(result.status > 0){
//            pTbody.html(result['data']);
//        } else {
//
//        }
//
//    });
}

