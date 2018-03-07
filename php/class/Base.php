<?php

class Base{

	protected $nefuer;
	
	//code
	//1 常规错误
	//2 未登录

	public function __construct()
	{
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

	public function setNefuer($nefuer){
		$this->nefuer = $nefuer;
	}

}
