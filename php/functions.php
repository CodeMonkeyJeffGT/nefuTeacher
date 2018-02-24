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
	echo '
		<link rel="shortcut icon" href="src/img/favicon.png" />
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="src/css/common.css" />
		<link rel="stylesheet" type="text/css" href="src/css/' . $file . '.css" />
		<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
	';
	include(ROOT . '/view/' . $file . '.php');
	echo '
		<script src="src/js/common.js"></script>
		<script src="src/js/' . $file . '.js"></script>
	';
}

function verdor($file)
{
	include(ROOT . '/php/vendor/' . $file . '.php');
}
