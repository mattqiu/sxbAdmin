$(function(){
    $("#y").change(function(){
        dateChange();
    }); 
    $("#m").change(function(){
        dateChange();
    }); 
    $("#d").change(function(){
        dateChange();
    });     
});
function dateChange(){
    var a = new GetDate();
    var str = a.show();
    $("#birthday").val(str);
    $("#birt").val(str);   
}
function GetDate() {
    this.show =function(){
      return this.getY()+'-'+this.getM()+'-'+this.getD();  
    };
    this.getY=function(){
       var y = $("#y option:selected").val();
       return y;
    };
     this.getM=function(){
       var y = $("#m option:selected").val();
       return y;
    };    
    this.getD=function(){
       var y = $("#d option:selected").val();
       return y;
    };   
}

function validate(){
   var frm = document.forms['theForm']; 
   var msg ='';
    if(frm.elements['username'].value == '')
       msg += "用户名不能为空 \n";
    else if( frm.elements['email'].value == '')
      msg += "邮箱不能为空 \n";
    else if( frm.elements['password'].value =='')
      msg += "密码不能为空 \n";
    else if( frm.elements['password'].value != frm.elements['repassword'].value )
      msg += "两次密码不一样";    
    if(msg){
        alert(msg);
        return false;
    }
}
function validateEdit(){
   var frm = document.forms['theForm']; 
   var msg ='';
    if(frm.elements['username'].value == '')
       msg += "用户名不能为空 \n";
    else if( frm.elements['email'].value == '')
      msg += "邮箱不能为空 \n";  
    if(msg){
        alert(msg);
        return false;
    }
}