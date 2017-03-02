<?php
define("APP_NAME",'shipin_manager');
define('APP_PATH', './shipin_manager/');
define('THINK_PATH', './thinkphp/');
define('PUBLIC_PATH', APP_PATH . 'Public/');
define('RUNTIME_PATH','./RunTime/');
//    分页时每页显示行数
define('LIST_ROW', 50);
//define('APP_DEBUG',false);
define('APP_DEBUG',true);
define ('BASE_PATH', dirname( __FILE__ ));
define('WEBSITE','http://m.sp.com/');
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); //将出错信息输出到一个文本文件
require_once(THINK_PATH.'ThinkPHP.php');
?>
