<?php

define('ROOT', __dir__);
include ROOT . '/php/functions.php';
include ROOT . '/php/config.php';

$class = ele($_GET, 'c', DEFAULT_CLASS);
$class = ucfirst(strtolower($class));
$function = ele($_GET, 'f', DEFAULT_FUNC);
if ( ! is_file('log')) {
	file_put_contents('log', '[]');
}
if ($class !== 'History') {
	$log = json_decode(file_get_contents('log'), true);
	$log[] = array(
		'class' => $class,
		'function' => $function,
		'uri' => $_SERVER['REQUEST_URI'],
		'time' => time(),
		'data' => $_POST,
	);
	file_put_contents('log', json_encode($log));
}

date_default_timezone_set('PRC');
if($class == 'V')
{
	view($function);
	die;
}

session_start();
//如果 未登录 且 不是登录操作 且 不是自身异步调用
if(empty($_SESSION['teacher']) && ($class != 'User' || $function != 'login') && $function != 'operateAuto')
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
verdor('Nefu');
$class = new $class();
if( ! empty($_SESSION['teacher']))
{
	$class->setNefuer(Nefu::getInstance($_SESSION['teacher']['account'], $_SESSION['teacher']['password'], $_SESSION['teacher']['cookie']));
}
$class->$function();
