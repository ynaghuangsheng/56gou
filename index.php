﻿<?php
// 应用入口文件
// 这是我加的一行代码
//wqwqwqqwqw88888888888888888888888888888888888888888888888888888888888888888888
if (version_compare(PHP_VERSION, '5.3.0','<'))
die('require PHP > 5.3.0 !'); //检测PHP环境
define('APP_DEBUG', TRUE);//false TRUE开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_PATH', './Home/');// 定义应用目录
require 'System/System.php';//引入入口文件                556                我在这行加了这几个字



// 我在后面加了一行