<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<title>操作成功</title>
    <link  rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/base.css"/>
    <link  rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/comm.css"/>
    <link  rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/default.css"/>
    <script type="text/javascript" src="__PUBLIC__/admin/js/jquery-1.7.2.min.js"></script>
</head>
<body>
<div class="header_1">时品网管理中心-<?php echo ($nav); ?></div>
<style>
.emain{border: 1px solid #f1f1f1;height: 290px;}
.error{margin:  auto;width: 400px;height: 50px;margin-top: 100px;}
</style>
<div class="width emain">
   <div class="error">
    
        <img  src="__PUBLIC__/admin/images/success.jpg" width="50" height="50" class="vm" />
        <span style="font-size: 16px;"><?php echo ($info["msg"]); ?>，</span>
        <span id="second"><?php echo ($info["second"]); ?></span>秒后跳转，
        <a href="<?php if(empty($info["url"])): ?>javascript:history.go(-1);<?php else: echo ($info["url"]); endif; ?>" id="url">如长时间不跳转，请点我跳转</a>
   </div>     
</div>
</body>
</html>
<script type="text/javascript">

var sec    = $("#second");
var second = parseInt(sec.html()); 
var url    = $("#url").attr("href");
function aa()
{
    if( second == 0 )
    {
        location.href = url;
    }        
    else
    {
      second--;
      sec.html(second);
      return second;
    }
}
setInterval("aa()", 1000);

</script>