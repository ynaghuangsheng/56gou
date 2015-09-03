<?php
// 应用入口文件
header('Content-type:text/html;charset=utf-8');//设置编码字符集
if (version_compare(PHP_VERSION, '5.3.0','<'))
die('require PHP > 5.3.0 !'); //检测PHP环境
define('APP_DEBUG', TRUE);//false TRUE开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_PATH', './Admin/');// 定义应用目录
require 'System/System.php';//引入入口文件