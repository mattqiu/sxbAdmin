$(document).ready(function(){


});
//checkbox全�?或不�?
function selAll(obj)
{ 
  var chk = document.getElementsByTagName("input");
  var aa=[];
  if(obj.className == 1)
  {
      for(var i=0; i< chk.length; i++)
      {
        if(chk[i].type == 'checkbox')
        {   
            chk[i].checked = 'checked';
        }
      }
      obj.className = 2;
  }
  else if(obj.className == 2)
  {
      for(var i=0; i< chk.length; i++)
      {
        if(chk[i].type == 'checkbox')
        {   
            chk[i].checked = '';
            
        }
      }
      obj.className = 1;
  }
}
//获取已选中的checkbox的�?
function getChkvalue()
{     
   var chk = document.getElementsByTagName("input");
   var getValue =[];
   for(var i=0; i< chk.length; i++)
   {
        if(chk[i].type == 'checkbox')
        {  
           if(chk[i].checked == true)
           {
             if(!isNaN(chk[i].value))
            {
                getValue.push(chk[i].value);
            }
           }
        }
   } 
   return getValue;
}
function batchDone(obj)
{
  var nowAct = obj.options[obj.selectedIndex].value;
  var chkvalue = getChkvalue();

  if(chkvalue == '')
  {
    alert("请选择要操作的商品!");
    return false;
  }
  else
  {
    $("#sub").attr("disabled", '');
  }
  
  if( nowAct == 'category')
  {  
    $("#category").css("display", 'inline');
    $("#shop").css("display", 'none');
  }
  else if( nowAct == 'shop')
  {
    $("#shop").css("display", 'inline');
    $("#category").css("display", 'none');   
  }
  else
  {
    $("#shop").css("display", 'none');
    $("#category").css("display", 'none');    
  }  
}
/*
*  获取 select元素的�?
*/
function get_select(id)
{
    var aa = document.getElementById(id);

   var val = aa.options[aa.selectedIndex].value;
    return val;
}

function showRows(obj)
{
    var size = obj.options[obj.selectedIndex].value; 
    var url  = $("#url").val();
    var aa = $("#numpage").html();
    var bb = aa.split("/");
    var p   = parseInt(bb[1]); 
    $.post(url, {p: p, row: size, is_ajax: 'yes'}, function(result){
            var hh = JSON.parse(result);
            $("#listdiv").html(hh.data.content);
            
    });     
}

function ajax_query(obj)
{
        var url  = $("#url").val();
        var size = get_select('size');
        var aa = $("#numpage").html();
        var bb = aa.split("/");
        var countpage = parseInt(bb[0]);
        var nowpage   = parseInt(bb[1]);
        var nowAct = obj.innerHTML;        
        var p = nowpage;
        if(nowAct == '首页')
        {
          p = 1;  
        }
        else if(nowAct == '上一�?)
        {
            if(nowpage > 1)
            {
                p --;
            }
            else
            {
                p = 1;
            }
        }
        else if(nowAct == '下一�?)
        {
            if(nowpage < countpage)
            {
                p ++;
            }
            else
            {
                p = countpage;
            }
        }
        else if(nowAct == '尾页')
        {
            p = countpage;
        }
        else if(nowAct == '我跳')
        {
            var jump1 = $("#jump").val();
            var jump  = parseInt(jump1);
            if(( isNaN(jump)) || (jump == ''))
            {
                alert("请输入数�?);
                return false;
            }
            p = jump;
        }
        $.post(url, {p: p, row: size, is_ajax: 'yes'}, function(result){
            var hh = JSON.parse(result);
            //alert(hh.data.content); 
            $("#listdiv").html(hh.data.content);
            
        });
    
}









