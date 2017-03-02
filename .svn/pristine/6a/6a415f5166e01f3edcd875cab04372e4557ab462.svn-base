function searchGoods(url) {
    var val = getElementValue('keyword');    
    if(Utils.trim(val) == '') { 
        alert(inputContent);
        return;
    }
    $.post(url, {key:val}, function(result){
        var html = '';
        $.each(result.data, function(key,value){
            html += '<option value="'+value.goods_id+'">'+value.name+'</option>'; 
        });
        $('#goods_id').html(html);    
    },'json');
}