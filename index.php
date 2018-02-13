<?php

define('ROOT', __dir__);
include ROOT . '/php/functions.php';
include ROOT . '/php/config.php';

$class = ele($_GET, 'c', DEFAULT_CLASS);
$class = ucfirst(strtolower($class));
$function = ele($_GET, 'f', DEFAULT_FUNC);

if($class == 'V')
{
	view($function);
	die;
}

session_start();
if(empty($_SESSION['u_id']) && ($class != 'User' || $function != 'login'))
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
