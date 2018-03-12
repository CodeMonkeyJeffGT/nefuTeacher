<?php

class Base{

	private $nefuer;
	protected $autoTime = 20;
	protected $autoMax = 200;
	
	//code
	//1 常规错误
	//2 未登录

	public function __construct(){
	}

	public function setNefuer($nefuer){
		$this->nefuer = $nefuer;
	}

	protected function nefuerDo($name, $params = null){
		$result = $this->nefuer->$name($params);
		$_SESSION['teacher']['cookie'] = $this->nefuer->getCookie();
		return $result;
 	}

	public function getDropdown(){
		$college = ele($_POST, 'college', '');
		$grade = ele($_POST, 'grade', '');
		$major = ele($_POST, 'major', '');
		$data = array(
			'xsyx' => $college,
			'xsnj' => $grade,
			'xszy' => $major,
		);
		$stepInfo = $this->nefuerDo('getStepInfo', $data);
		$stepInfo['college'] = $stepInfo['college'][$_SESSION['teacher']['college'] . '学院'];
		if (false === $stepInfo) {
			$this->goLogin();
		} else {
			if (count($stepInfo['class']) !== 0) {
				asort($stepInfo['class']);
			}
			$this->success($stepInfo);
		}
	}

	protected function success($data = array()){
		$this->apiReturn($data, '', 0);
	}

	protected function error($message){
		$this->apiReturn(array(), $message, 1);
	}

	protected function goLogin(){
		$this->apiReturn(array(), '请登录', 2);
	}

	protected function apiReturn($data, $message, $code){
		echo json_encode(array(
			'code' => $code,
			'data' => $data,
			'message' => $message,
		));
		die;
	}

	protected function buildAuto($page, $time){
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

	protected function doRequest($url, $param){
		$urlinfo = parse_url($url);
		$host = $urlinfo['host'];
		$path = $urlinfo['path'];
		var_dump($urlinfo);
		$query = http_build_query($param);
		var_dump($query);
		die;
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
}
