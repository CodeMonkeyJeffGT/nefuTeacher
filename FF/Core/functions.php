<?php

function ele(array $array, $element, $default = null, $hard = true) {
	if ($hard) {
		if (isset($array[$element])) {
			return $array[$element];
		} elseif (isset($array->$element)) {
			return $array->$element;
		} else {
			return $default;
		}
	} else {
		if ( ! empty($array[$element])) {
			return $array[$element];
		} elseif ( ! empty($array->$element)) {
			return $array->$element;
		} else {
			return $default;
		}
	}
}

function model($name) {
	$name = '\\App\\Model\\' . ucfirst($name) . 'Model';
	return new $name();
}

function config($name = '.', $value = null, $get = true) {
	if ($get) {
		return \FF\Core\Config::get($name, $value);
	} else {
		if ($name === '.') {
			return false;
		}
		\FF\Core\Config::set($name, $value);
	}
}

function p($value, $var = true) {
	echo '<pre>';
	if($var) {
		var_dump($value);
	} else {
		print_r($value);
	}
	echo '</pre>';
}

function input($name = null, $default = null) {
	$input = array();
	$name = explode('.', $name);
	switch (strtolower($name[0])) {
		case 'get':
			$input = $_GET;
			break;

		case 'post':
			$input = $_POST;
			break;

		case 'json':
			$input = json_decode(file_get_contents('php://input'), true);
			break;

		case 'php':
			$input = parse_str(file_get_contents('php://input'));
			break;

		case 'header':
			$input = $_SERVER;
			break;

		case 'session':
			$input = $_SESSION;
			break;

		case 'cookie':
			$input = $_COOKIE;
			break;
		default:
			$input = $_REQUEST;
			break;
	}
	if ( ! empty($name[1])) {
		return ele($input, $name[1], $default);
	} else {
		return $input;
	}
}

function session($name = null, $value = null) {
	if ($name === '.') {
		return $_SESSION;
	} else {
		$name = explode('.', $name);
		if(is_null($value)) {
			if(count($name) == 1) {
				if (isset($_SESSION[$name[0]])) {
					return $_SESSION[$name[0]];
				} else {
					return null;
				}
			} else {
				if (isset($_SESSION[$name[0]][$name[1]])) {
					return $_SESSION[$name[0]][$name[1]];
				} else {
					return null;
				}
			}
		} else {
			if(count($name) == 1) {
				$_SESSION[$name[0]] = $value;
			} else {
				$_SESSION[$name[0]][$name[1]] = $value;
			}
		}
	}
}

function cookie($name, $value = null, $config = array()) {
	if ($name === '.') {
		return $_COOKIE;
	} else {
		$name = explode('.', $name);
		if(is_null($value)) {
			if(count($name) == 1) {
				if (isset($_COOKIE[$name[0]])) {
					return $_COOKIE[$name[0]];
				} else {
					return null;
				}
			} else {
				if (isset($_COOKIE[$name[0]][$name[1]])) {
					return $_COOKIE[$name[0]][$name[1]];
				} else {
					return null;
				}
			}
		} else {
			setcookie($name[0] , $value, ele($config, 'expire', 0), ele($config, 'path', ""), ele($config, 'domain', ""),ele($config, 'secure', false), ele($config, 'httponly', false));
		}
	}
}

function rfile($filename) {
	if (is_file($filename)) {
		return file_get_contents($filename);
	} else {
		return null;
	}
}

function ifile($filename, $once = false) {
	if (is_file($filename)) {
		return $once ? include_once($filename) : include($filename);
	} else {
		return null;
	}
}
