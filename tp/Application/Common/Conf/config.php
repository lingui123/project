<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'itcast_shop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'shop_',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数    
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
   //模块
    'MODULE_ALLOW_LIST' => array('Home', 'Admin'),
    'DEFAULT_MODULE' => 'Home',
    //布局
    'LAYOUT_ON' => true,
    'LAYOUT_NAME' => 'layout',
    //输入过滤
    'DEFAULT_FILTER' =>  'htmlspecialchars,trim', //默认过滤函数
    'VAR_AUTO_STRING' => true,  //默认强制转换为字符串类型
    //其它配置
    'URL_MODEL' => 2,   //URL模式：Rewrite
    'TOKEN_ON' => true, //开启表单令牌
    'SHOW_PAGE_TRACE' => APP_DEBUG, //显示调试信息
);