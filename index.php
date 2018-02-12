<?php

define('ROOT', __dir__);
include ROOT . '/php/functions.php';
include ROOT . '/php/config.php';

$class = ele($_REQUEST, 'c', DEFAULT_CLASS);
$class = ucfirst(strtolower($class));
$function = ele($_REQUEST, 'f', DEFAULT_FUNC);

include(ROOT . '/php/class/' . $class . '.php');
$class = new $class();
$class->$function();
