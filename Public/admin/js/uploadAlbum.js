// +----------------------------------------------------------------------
// | 上海时品信息科技有限公司
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id: uploadAlbum.js 976 2014-09-15 08:34:34Z meihui_wap $

function testaa(){
    alert('testaa');
}


//    var isUpload = false;
function uploadAlbumImg(elem) {
    var _this = $(elem);
    var fileID = _this.attr('id');
//        if(isUpload) return; else isUpload = true;
    var tips = _this.next('span.tips');
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
            var item = '<li><img src="' + data.fullImgUrl + '!gpreview' + '" alt=""/>'
                + '<input name="goodsAlbum[]" value="' + data.imgUrl + '" />'
                + '</li>'
            $('#goodsAlbumList').append(item);
        },
        error:function (result, status, e) {
//                isUpload = false;
            tips.html('上传失败，请重试');
        }
    });
}