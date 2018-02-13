<?php

function ele($param, $name, $default = null)
{
	if(isset($param[$name])) {
		return $param[$name];
	} else {
		return $default;
	}
}

function view($file = '')
{
	$file = $file == '' ? ele($_REQUEST, 'f', DEFAULT_FUNC) : $file;
	$file = strtolower($file);
	echo '<link rel="stylesheet" type="text/css" href="src/css/common.css">';
	include(ROOT . '/view/' . $file . '.php');
}

function verdor($file = '')
{
	include(ROOT . '/php/vendor/' . $file . '.php');
}
