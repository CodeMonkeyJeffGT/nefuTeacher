<?php

class Base{
	
	//code
	//1 常规错误
	//2 未登录

	public function __construct()
	{

	}

	protected function success($data = array()){
		$this->return($data, '', 0);
	}

	protected function error($message){
		$this->return(array(), $message, 1);
	}

	protected function goLogin(){
		$this->return(array(), '请登录', 2);
	}

	protected function return($data, $message, $code){
		echo json_encode(array(
			'code' => $code,
			'data' => $data,
			'message' => $message,
		));
		die;
	}

}