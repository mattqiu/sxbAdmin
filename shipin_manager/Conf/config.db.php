<?php
$comm_config = array(
//    'DB_TYPE' => 'mysql', 'DB_HOST' => 'rds2698sy20670yn6u76o.mysql.rds.aliyuncs.com', //本地服务器
//    'DB_NAME' => 'test_v2_shuxiaobai', 'DB_USER' => 'test_db_user', 'DB_PWD' => 'qidk9dkdj_18T',

    'DB_TYPE' => 'mysql', 'DB_HOST' => '127.0.0.1', //本地服务器
    'DB_NAME' => 'test_v2_shuxiaobai', 'DB_USER' => 'root', 'DB_PWD' => '',
    'DB_PREFIX' => 'ttgy_',
    // 显示页面Trace信息
    //    'DEBUG_MODE' => false,
    'DEBUG_MODE' => false, 'TOKEN_ON' => true, // 是否开启令牌验证
    'TOKEN_NAME' => '__hash__', // 令牌验证的表单隐藏字段名称
    'TOKEN_TYPE' => 'md5', //令牌哈希验证规则 默认为MD5
    'TMPL_TEMPLATE_SUFFIX' => '.html', // 默认模板文件后缀
    'TOKEN_RESET' => true, //令牌验证出错后是否重置令牌 默认为true
    'URL_MODEL' => 3,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式，提供最好的用户体验和SEO支持

    //test  svn ps svn:ignore "config.db.php" .
);