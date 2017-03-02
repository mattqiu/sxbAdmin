/**
 * Created by chrisying on 15/11/6.
 */

$(function($){
    modals_select_datalink();
});

function modals_select_datalink() {
    $('.modals_radio_select').on('click', function(){
        //initModalHtml();
        var _this = $(this);
        var modalId = $(this).attr('data-modal');
        var modalTitle = $(this).attr('data-title');
        var url = $(this).attr('data-url');
        var _modal = $('#' + modalId);
        //$('#modal_radio_select').modal('toggle');
        //_modal.modal('show');
        //if(_modal.hasClass('in')){
        //    //_modal.modal('hide');
        //} else {
        //    _modal.modal('show');
        //}
        $('#' + modalId + ' .modal-title').text(modalTitle);
        $('#modal_radio_select_confirm').attr('data-inputId', _this.attr('data-inputId'));
        var data = {attach:1};
        getModalRadioData(url, data, _modal, _this);
    });

    $('.modals_checked_select').on('click', function(){
        var _this = $(this);
        var modalId = $(this).attr('data-modal');
        var modalTitle = $(this).attr('data-title');
        var url = $(this).attr('data-url');
        var _modal = $('#' + modalId);
        $('#' + modalId + ' .modal-title').text(modalTitle);
        $('#modal_checked_select_confirm').attr('data-inputId', _this.attr('data-inputId'));
        var data = {attach:1};
        getModalCheckedData(url, data, _modal, _this);
    });
}

function initModalHtml(){
    var modalWrap = $('#modal_radio_select');
    var modalOverlay = $('#md-overlay');

    var html = ' <div id="modal_radio_select" class="md-modal md-effect-1">' +
        '<div class="md-content">' +
        '<div class="modal-header">' +
        '<button class="md-close close">×</button>' +
    '<h4 class="modal-title">弹出框标题</h4>' +
        '</div>' +
        '<div class="modal-body">' +
        '</div>' +
        '<div class="modal-footer">' +
        '<button class="btn btn-default" type="button" id="modal_radio_select_cancel">取消</button>' +
        '<button class="btn btn-primary" type="button" id="modal_radio_select_confirm">确定</button>' +
        '</div>'+
        '</div>'+
        '</div>'+
        '<div class="md-overlay" id="md-overlay"></div>';

    if(typeof  modalWrap == 'undefined' || modalWrap == null || !(modalWrap.length > 0)){
        $('#page-wrapper').append(html)
    }
}


function getModalRadioData(url, data,_modal, _this){
    _modal.find('.modal-body').html("");//清空数据

    $.post(url, data, function(result){
        if(typeof  result != 'undefined' && result != null && result.data != null){
            var bodyHtml = '<table class="table table-hover">';
            $.each(result.th, function(thKey, thItem){
                bodyHtml = bodyHtml + '<th>' + thItem + '</th>';
            });
            bodyHtml = bodyHtml + '</tr>';

            $.each(result.data, function(key, item){
                bodyHtml = bodyHtml + '<tr class="data-item"> ';
                $.each(result.key, function(keyKey, keyItem){
                    if(0 == keyKey){
                        bodyHtml = bodyHtml + '<td><input type="radio" class="data-item-radio" name="data-item-radio" value="' + item[keyItem] + '" />' + item[keyItem] + '</td>';
                    } else {
                        bodyHtml = bodyHtml + '<td>' + item[keyItem] + '</td>';
                    }

                });
                bodyHtml = bodyHtml + '</tr>';

            });

            bodyHtml = bodyHtml + '</table>';
            bodyHtml = bodyHtml + result.page;
            _modal.find('.modal-body').html(bodyHtml);
            _modal.find('.modal-body .data-item').on('click', function(){
                $('.modal-body .data-item .data-item-radio').prop("checked", false);
                $(this).find('.data-item-radio').prop("checked", true);
            });

            $('#modal_radio_select_confirm').on('click', function(){
                var selInputId = $(this).attr('data-inputId');
                $('#' + selInputId).val(_modal.find('.modal-body .data-item .data-item-radio:checked').val());
                _modal.removeClass('md-show').modal("hide");
            });

            $('#modal_radio_select_cancel').on('click', function(){
                _modal.removeClass('md-show').modal("hide");
            });

            //翻页
            _modal.find('.page_link').on('click', function(){
                var _thisLink = $(this);
                var pageUrl = _thisLink.attr('href');
                getModalRadioData(pageUrl, {}, _modal, _this);

                console.log('test page link');
                return false;
            });

        }
    }, 'json');
}

function getModalCheckedData(url, data,_modal, _this){
    $.post(url, data, function(result){
        if(typeof  result != 'undefined' && result != null && result.data != null){
            var bodyHtml = '<table class="table table-hover">';
            $.each(result.th, function(thKey, thItem){
                if(thKey == 0){
                    bodyHtml = bodyHtml + '<th><input type="checkbox" id="modal_check_all">' + thItem + '</th>';
                } else {
                    bodyHtml = bodyHtml + '<th>' + thItem + '</th>';
                }

            });
            bodyHtml = bodyHtml + '</tr>';

            $.each(result.data, function(key, item){
                bodyHtml = bodyHtml + '<tr class="data-item"> ';
                $.each(result.key, function(keyKey, keyItem){
                    if(0 == keyKey){
                        bodyHtml = bodyHtml + '<td><input type="checkbox" class="data-item-checkbox" name="data-item-checkbox" value="' + item[keyItem] + '" />' + item[keyItem] + '</td>';
                    } else {
                        bodyHtml = bodyHtml + '<td>' + item[keyItem] + '</td>';
                    }

                });
                bodyHtml = bodyHtml + '</tr>';

            });

            bodyHtml = bodyHtml + '</table>';
            bodyHtml = bodyHtml + result.page;
            _modal.find('.modal-body').html(bodyHtml);

            _modal.find('.modal-body .data-item').on('click', function(){
                if($(this).find('input:checked').length > 0){
                    $(this).find('.data-item-checkbox').prop("checked", false);
                } else {
                    $(this).find('.data-item-checkbox').prop("checked", true);
                }

            });

            //批量选择表单
            _modal.find('#modal_check_all').on('change', function(){
                var is_checked = document.getElementById("modal_check_all").checked;
                if(is_checked){
                    $('.data-item .data-item-checkbox').prop('checked', true);
                } else {
                    $('.data-item .data-item-checkbox').prop('checked', false);
                }
            });

            $('#modal_checked_select_confirm').on('click', function(){
                var selInputId = $(this).attr('data-inputId');
                var selectedIdArr = [];
                $.each(_modal.find('.modal-body .data-item input:checked'), function(key, item){
                    selectedIdArr.push($(item).val());
                })
                $('#' + selInputId).val(selectedIdArr.join(',')).trigger('change');
                _modal.removeClass('md-show').modal("hide");
            });

            $('#modal_checked_select_cancel').on('click', function(){
                _modal.removeClass('md-show').modal("hide");
            });

            //翻页
            _modal.find('.page_link').on('click', function(){
                var _thisLink = $(this);
                var pageUrl = _thisLink.attr('href');
                getModalRadioData(pageUrl, {}, _modal, _this);

                console.log('test page link');
                return false;
            });

        }
    }, 'json');
}