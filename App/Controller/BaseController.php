<?php
namespace App\Controller;
use FF\Core\Controller;
use FF\Core\Config;
use App\Vendor\Nefu;

class BaseController extends Controller{

	private $nefuer;
	protected $autoTime = 20;
	protected $autoMax = 200;
	
	//code
	//1 常规错误
	//2 未登录

	public function __construct() {
		date_default_timezone_set('PRC');
		if (empty($_SESSION['teacher']) && (Config::get('CONTROLLER') != 'User' || Config::get('ACTION') != 'login') && Config::get('ACTION') != 'operateAuto') {
			if (empty($_POST)) {
				$this->display('login');
				die;
			} else {
				$this->goLogin();
			}
		}
		$teacher = session('teacher');
		if ( ! is_null($teacher)) {
			$this->setNefuer(Nefu::getInstance($teacher['account'], $teacher['password'], $teacher['cookie']));
		}
	}

	public function setNefuer($nefuer) {
		$this->nefuer = $nefuer;
	}

	public function getDropdown() {
		$college = session('teacher.collegeValue');
		$grade = input('post.grade', '');
		$major = input('post.major', '');
		$data = array(
			'xsyx' => $college,
			'xsnj' => $grade,
			'xszy' => $major,
		);
		$stepInfo = $this->nefuerDo('getStepInfo', $data);
		if($college === '')
		{
			$college = $stepInfo['college'][session('teacher.college') . '学院'];
			model('college')->update(session('teacher.collegeId'), $college);
			session('teacher.collegeValue', $college);
		}
		if (false === $stepInfo) {
			$this->goLogin();
		} else {
			if (count($stepInfo['class']) !== 0) {
				asort($stepInfo['class']);
			}
			$this->success($stepInfo);
		}
	}

	protected function buildInfo() {
		$now = date('H');
		if($now > 4 && $now < 8){
			$now = '0';
		}elseif($now < 11){
			$now = '1';
		}elseif($now < 13){
			$now = '2';
		}elseif($now < 18){
			$now = '3';
		}elseif($now < 23){
			$now = '4';
		}else{
			$now = '5';
		}
		$sentences = array('早上好','上午好','中午好','下午好','晚上好','夜深了');
		$css = array('sunrise','sun','noon','tea','moon','sleep');
		$menulist = array(
			array(
				'name' => '学生成绩',
				'url' => '/score',
			),
			array(
				'name' => '学生列表',
				'url' => '/student',
			),
			array(
				'name' => '个人信息',
				'url' => '/user/info',
			),
		);
		$data = array(
			'name' => mb_substr(session('teacher.name'), 0, 1),
			'college' => session('teacher.college'),
			'sentence' => $sentences[$now],
			'css' => $css[$now],
			'menulist' => $menulist,
		);
		$this->assign($data);
	}

	protected function nefuerDo($name, $params = null) {
		$result = $this->nefuer->$name($params);
		$_SESSION['teacher']['cookie'] = $this->nefuer->getCookie();
		return $result;
 	}

	protected function success($data = array()) {
		$this->apiReturn($data, '', 0);
	}

	protected function error($message) {
		$this->apiReturn(array(), $message, 1);
	}

	protected function goLogin() {
		$this->apiReturn(array(), '请登录', 2);
	}

	private function apiReturn($data, $message, $code) {
		echo json_encode(array(
			'code' => $code,
			'data' => $data,
			'message' => $message,
		));
		die;
	}

	protected function buildAuto($page, $time) {
		$num = ($page - 1) / ($this->autoTime / $time);
		if ($num > $this->autoMax) {
			$num = $this->autoMax;
		}
		$num = (int)(($page - 1) / $num);
		$result = array();
		for ($i = 2; $i + $num < $page; $i += $num) {
			$result[] = array(
				'start' => $i,
				'end' => $i + $num - 1,
			);
		}
		$result[] = array(
			'start' => $i,
			'end' => $page,
		);
		return $result;
	}

	protected function doRequest($url, $param) {
		$urlinfo = parse_url($url);
		$host = $urlinfo['host'];
		$path = '/?' . $urlinfo['query'];
		$query = http_build_query($param);
		$port = 80;
		$errno = 0;
		$errstr = '';
		$timeout = 10;

		$fp = fsockopen($host, $port, $errno, $errstr, $timeout);

		$out = "POST ".$path." HTTP/1.1\r\n";
		$out .= "host:".$host."\r\n"; 
		$out .= "content-length:".strlen($query)."\r\n"; 
		$out .= "content-type:application/x-www-form-urlencoded\r\n"; 
		$out .= "connection:close\r\n\r\n"; 
		$out .= $query;

		fputs($fp, $out); 
		fclose($fp);
	}

	protected function display($file) {
		echo '
			<link rel="shortcut icon" href="/src/img/favicon.png" />
			<meta charset="utf-8">
			<link rel="stylesheet" type="text/css" href="/src/css/common.css" />
			<link rel="stylesheet" type="text/css" href="/src/css/' . $file . '.css" />
			<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
		';
		parent::display($file);
		echo '
			<script src="/src/js/common.js"></script>
			<script src="/src/js/' . $file . '.js"></script>
		';
	}

}
