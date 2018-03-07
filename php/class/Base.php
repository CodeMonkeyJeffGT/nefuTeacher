<?php

class Base{

	protected $nefuer;
	
	//code
	//1 常规错误
	//2 未登录

	public function __construct(){
	}

	public function setNefuer($nefuer){
		$this->nefuer = $nefuer;
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
		$stepInfo = $this->nefuer->getStepInfo($data);
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

	protected function doRequest($url, $param){
		$urlinfo = parse_url($url);
		$host = $urlinfo['host'];
		$path = $urlinfo['path'];
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
}
