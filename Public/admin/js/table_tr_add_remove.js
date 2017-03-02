/**
 * Created by chrisying on 15/9/17.
 */
var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

var Utils = new Object();

Utils.htmlEncode = function(text)
{
    return text.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

Utils.trim = function( text )
{
    if (typeof(text) == "string")
    {
        return text.replace(/^\s*|\s*$/g, "");
    }
    else
    {
        return text;
    }
}

Utils.isEmpty = function( val )
{
    switch (typeof(val))
    {
        case 'string':
            return Utils.trim(val).length == 0 ? true : false;
            break;
        case 'number':
            return val == 0;
            break;
        case 'object':
            return val == null;
            break;
        case 'array':
            return val.length == 0;
            break;
        default:
            return true;
    }
}

Utils.isNumber = function(val)
{
    var reg = /^[\d|\.|,]+$/;
    return reg.test(val);
}

Utils.isInt = function(val)
{
    if (val == "")
    {
        return false;
    }
    var reg = /\D+/;
    return !reg.test(val);
}

Utils.isEmail = function( email )
{
    var reg1 = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;

    return reg1.test( email );
}

Utils.isTel = function ( tel )
{
    var reg = /^[\d|\-|\s|\_]+$/; //只允许使用数字-空格等

    return reg.test( tel );
}

Utils.fixEvent = function(e)
{
    var evt = (typeof e == "undefined") ? window.event : e;
    return evt;
}

Utils.srcElement = function(e)
{
    if (typeof e == "undefined") e = window.event;
    var src = document.all ? e.srcElement : e.target;

    return src;
}

Utils.isTime = function(val)
{
    var reg = /^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}$/;

    return reg.test(val);
}

Utils.x = function(e)
{ //当前鼠标X坐标
    return Browser.isIE?event.x + document.documentElement.scrollLeft - 2:e.pageX;
}

Utils.y = function(e)
{ //当前鼠标Y坐标
    return Browser.isIE?event.y + document.documentElement.scrollTop - 2:e.pageY;
}

Utils.request = function(url, item)
{
    var sValue=url.match(new RegExp("[\?\&]"+item+"=([^\&]*)(\&?)","i"));
    return sValue?sValue[1]:sValue;
}

Utils.$ = function(name)
{
    return document.getElementById(name);
}

function rowindex(tr)
{
    if (Browser.isIE)
    {
        return tr.rowIndex;
    }
    else
    {
        table = tr.parentNode.parentNode;
        for (i = 0; i < table.rows.length; i ++ )
        {
            if (table.rows[i] == tr)
            {
                return i;
            }
        }
    }
}

document.getCookie = function(sName)
{
    // cookies are separated by semicolons
    var aCookie = document.cookie.split("; ");
    for (var i=0; i < aCookie.length; i++)
    {
        // a name/value pair (a crumb) is separated by an equal sign
        var aCrumb = aCookie[i].split("=");
        if (sName == aCrumb[0])
            return decodeURIComponent(aCrumb[1]);
    }

    // a cookie with the requested name does not exist
    return null;
}

document.setCookie = function(sName, sValue, sExpires)
{
    var sCookie = sName + "=" + encodeURIComponent(sValue);
    if (sExpires != null)
    {
        sCookie += "; expires=" + sExpires;
    }

    document.cookie = sCookie;
}

document.removeCookie = function(sName,sValue)
{
    document.cookie = sName + "=; expires=Fri, 31 Dec 1999 23:59:59 GMT;";
}

function getPosition(o)
{
    var t = o.offsetTop;
    var l = o.offsetLeft;
    while(o = o.offsetParent)
    {
        t += o.offsetTop;
        l += o.offsetLeft;
    }
    var pos = {top:t,left:l};
    return pos;
}

function cleanWhitespace(element)
{
    var element = element;
    for (var i = 0; i < element.childNodes.length; i++) {
        var node = element.childNodes[i];
        if (node.nodeType == 3 && !/\S/.test(node.nodeValue))
            element.removeChild(node);
    }
}
function removeImg(obj)
{
    var row = rowindex(obj.parentNode.parentNode);
    var tbl = document.getElementById('gallery-table');

    tbl.deleteRow(row);
}
function removeImg2(obj,pid)
{
    var row = rowindex(obj.parentNode.parentNode);
    var tbl = document.getElementById(pid);

    tbl.deleteRow(row);
}
function addImg(obj)
{
    var src  = obj.parentNode.parentNode;
    var idx  = rowindex(src);
    var tbl  = document.getElementById('gallery-table');
    var row  = tbl.insertRow(idx + 1);
    var cell = row.insertCell(-1);
    cell.innerHTML = src.cells[0].innerHTML.replace(/(.*)(addImg)(.*)(\[)(\+)/i, "$1removeImg$3$4-");
}
function addImg2(obj,pid)
{
    var src  = obj.parentNode.parentNode;
    var idx  = rowindex(src);
    var tbl  = document.getElementById(pid);
    var row  = tbl.insertRow(idx + 1);
    var cell = row.insertCell(-1);
    cell.innerHTML = src.cells[0].innerHTML.replace(/(.*)(addImg)(.*)(\[)(\+)/i, "$1removeImg$3$4-");
}

function update_product_gg($product_id,$id,$field,$val){
    if (confirm('确定修改吗?')){
        $.post('/Product/update_product_price',{product_id:$product_id,id:$id,field:$field,val:$val},function(data){
            product_gg($product_id);
        });
    }
    else{
        product_gg($product_id);
    }
}
function update_product_gift($product_id,$id,$field,$val){
    if (confirm('确定修改吗?')){
        $.post('/Product/update_product_gifts',{product_id:$product_id,id:$id,field:$field,val:$val},function(data){
            product_gift($product_id);
        });
    }
    else{
        product_gift($product_id);
    }
}
function del_product_gg($product_id,$id){
    if (confirm('确定删除吗?')){
        $.post('/Product/del_product_price',{product_id:$product_id,id:$id},function(data){
            product_gg($product_id);
        });
    }else{
    }
}
function del_product_gift($pid,$id){
    if (confirm('确定删除吗?')){
        $.post('/Product/del_product_gift',{pid:$pid,id:$id},function(data){
            product_gift($pid);
        });
    }else{
    }
}

function product_gg($product_id){
    $.post('/Product/get_product_price',{product_id:$product_id},function(data){
        $("#gg").html(data);
    });
}
function product_gift($product_id){
    $.post('/Product/get_product_gifts',{product_id:$product_id},function(data){
        $("#gift").html(data);
    });
}

function update_product_gg_checkbox($product_id,$id,$field,$val){
    if($val==0){
        $val=1;
    }else{
        $val=0;
    }
    if (confirm('确定修改吗?')){
        $.post('/Product/update_product_price',{product_id:$product_id,id:$id,field:$field,val:$val},function(data){
            product_gg($product_id);
        });
    }
    else{
        product_gg($product_id);
    }
}

/**
 *  商品相册
 * @param $product_id
 */
function jquery_photo_list($product_id){
    $.post('/Product/getPhotos',{product_id:$product_id},function(data){
        $("#jquery_photo_list").html(data);
    });
}
function jquery_photo_list_update($product_id,$id,$order_id){
    $.post('/Product/updatePhoto',{id:$id,order_id:$order_id},function(data){
        jquery_photo_list($product_id);
    });
}
function jquery_photo_list_del($product_id,$id){
    if (confirm('确定删除吗?')){
        $.post('/Product/delPhoto',{id:$id},function(data){
            jquery_photo_list($product_id);
        });
    }
    else{
    }
}