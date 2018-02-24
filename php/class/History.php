<?php

class History extends Base{

	public function __construct(){}

	public function index()
	{
		$type = ele($_POST, 'type', 'score');
		$teacher = $_SESSION['teacher']['account'];
		if(is_file(ROOT . '/store/teacher/' . $teacher . '/' . $type . '/history'))
		{
			$this->success(json_decode(file_get_contents(ROOT . '/store/teacher/' . $teacher . '/' . $type . '/history'), true));
		}
		else
		{
			$this->error('系统错误，请联系管理员。' . "\n" . 'qq:3194215635');
		}
	}
}
