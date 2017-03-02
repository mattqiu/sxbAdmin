// +----------------------------------------------------------------------
// | 上海时品信息科技有限公司
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id: common.js 976 2014-09-15 08:34:34Z meihui_wap $

/**
 * 品牌选择窗口
 * @param el
 */
function selectBrand(el, url){
    $("body").append('<div id="brandWin"></div>');
    var brandWin = $('#brandWin');
    brandWin.window({width:650, height:500, modal:true, title:'品牌选择',  });
    brandWin.window('open');
    brandWin.window('refresh', url);

    //确定选择的品牌后,写入品牌表单,关闭弹窗
    $('#selectBrandBtn').on('click', function(){
        var checkedBrand = $('input[name="brand_id"]:checked');
        $('#selectedBrandId').val(checkedBrand.val());
        $('.brandBox').text(checkedBrand.attr('data-name'));
        brandWin.window('close');
    });
}

/**
 * 后台编辑，多标签切换
 * @param obj
 */
function tarChange(obj)
{
    var  arr = $("#tabbar-div span");
    obj.className = "tab-front";
    for(var i=0;i<arr.length;i++)
    {
        if(arr[i] != obj)
        {
            arr[i].className = "tab-back";
            tabname = arr[i].id+'le';
            $("#"+tabname).css("display", "none");
        }

    }
    var thTab = obj.id +'le';
    $("#"+thTab).css("display", "block");
}

/**
 * 图片上传
 * @param elem
 */
//    var isUpload = false;
function uploadImage(elem) {
    var _this = $(elem);
    var fileID = _this.attr('id');
//        if(isUpload) return; else isUpload = true;
    var tips = _this.next('span.tips');
    var img = _this.siblings('img');
    var imgInput = _this.siblings('input[type="hidden"]');
    tips.html('正在上传，请耐心等待……');

    var policy = _this.attr('data-policy');
    var sign = _this.attr('data-sign');

    $.ajaxFileUpload({
        url:"http://v0.api.upyun.com/mh-images",
        secureuri:false,
        fileElementId:fileID,
        dataType:'json',
        //增加其它参数
        data:{'policy' : policy, 'signature':sign},
        success:function(result) {
            var data = result.data;
            tips.html('上传成功');
            console.log(data.imgUrl);
            img.attr('src', data.fullImgUrl + '!gpreview');
            imgInput.val(data.imgUrl);
        },
        error:function (result, status, e) {
//                isUpload = false;
            tips.html('上传失败，请重试');
        }
    });
}

function createAjaxWin(){
    if(!($('#ajaxWin').length > 0)){
        var ajaxWin = $('#ajaxWin');
        ajaxWin.window('close');
        //如果不删除此元素，多次支付后，单击确定的时候,会存在多次触发的情况
        ajaxWin.remove();
        $("body").append('<div id="ajaxWin"></div>');
    }
}