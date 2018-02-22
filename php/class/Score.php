<?php

class Score extends Base{ 

	public function index(){
		view('score');
	}

	public function stepChoice(){

	}

	public function start(){
		$url = $_SERVER['SERVER_NAME'] . '?c=score&f=operate_auto'; 
		$param = array( 
		);
		$this->doRequest($url, $param);
	}

	public function info(){

	}

	public function operate_auto(){
		ignore_user_abort(true);
		set_time_limit(0);
	}

	private function doRequest($url, $param){
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
