<?php
return array(
    // 配置文件
    'config'    =>  array(
        SYSTEM_PATH.'Conf/Convention.php',   // 系统惯例配置
    ),
	
	//别名设置
	'alias'    =>  array(
	    'App'        => LIB_PATH.'App'.EXT,
	    'Storage'        => LIB_PATH.'Storage'.EXT,
		'Route'        => LIB_PATH.'Route'.EXT,
		'Templates'        => LIB_PATH.'Templates'.EXT,
	
	),

    // 函数文件
    'core'      =>  array(
	    SYSTEM_PATH.'Commcon/Functions.php',
		LIB_PATH.'Db'.EXT,
		LIB_PATH.'Controller'.EXT,
		LIB_PATH.'Model'.EXT,
    ),
    
);