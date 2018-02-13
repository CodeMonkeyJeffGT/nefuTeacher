<?php

define('ROOT', __dir__);
include ROOT . '/php/functions.php';
include ROOT . '/php/config.php';

$class = ele($_GET, 'c', DEFAULT_CLASS);
$class = ucfirst(strtolower($class));
$function = ele($_GET, 'f', DEFAULT_FUNC);

date_default_timezone_set('PRC');
if($class == 'V')
{
	view($function);
	die;
}

session_start();
//如果 未登录 且 不是登录操作 且 不是自身异步调用
if(empty($_SESSION['teacher']) && ($class != 'User' || $function != 'login') && $function != 'operate_auto')
{
	if(empty($_POST))
	{
		view('login');
	}
	else
	{
		echo json_encode(array('code' => 2, 'message' => '请登录'));
	}
	die;
}

include(ROOT . '/php/class/Base.php');
include(ROOT . '/php/class/' . $class . '.php');
$class = new $class();
$class->$function();
