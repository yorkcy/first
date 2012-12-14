<?php
require('inc/c/init.class.php'); //加载初始化类
$init=new Init(require('config/path.config.php')); //生成初始化类并调入路径配置文件
$route = $init -> getRoute ();
$module = isset($_GET['module']) ? $_GET['module'] :'';
$action = isset($_GET['action']) ? $_GET['action'] :'';
$route->deal($module,$action);  //调用路由类的处理函数
?>
