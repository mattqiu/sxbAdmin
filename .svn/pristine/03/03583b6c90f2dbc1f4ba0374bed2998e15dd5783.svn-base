// +----------------------------------------------------------------------
// | 上海时品信息科技有限公司
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.shipinmmm.com/ All rights reserved.
// +----------------------------------------------------------------------
// | 这不是一个自由软件，未经授权，不允许任何个人或组织传播和使用。
// +----------------------------------------------------------------------
// | Author: Chris.Ying <christhink@qq.com>
// +----------------------------------------------------------------------
// | @version: $Id: validate.js 976 2014-09-15 08:34:34Z meihui_wap $

var submit = $('input[type="submit"]');
submit.bind('click', function(){
    validate();
    $("form:first").trigger("submit")
});

/**
 * 表单验证, 提交表单前要删除ajax图片上传表单，避免重复向服务器上传图片
 */
function validate(){

    //表单提交前删除file标签，避免向服务器重复上传文件
    var ajaxImg = $('.ajaxUploadImg');
    if(ajaxImg.length > 0){
        ajaxImg.remove();
    }

    return true;
}
