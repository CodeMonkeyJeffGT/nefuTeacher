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

	public function remove(){
		$id = ele($_POST, 'id');
		$type = ele('$_POST', 'type', 'score');
		if(is_null($id))
			$this->error('请指定id');
		$teacher = $_SESSION['teacher']['account'];
		$file = ROOT . '/store/teacher/' . $teacher . '/' . $type . '/' . $id;
		unset($file);
		$history = json_decode(file_get_contents(ROOT . '/store/teacher/' . $teacher . '/' . $type . '/history'), true);
		foreach ($history as $key => $value) {
			if($value['id'] == $id)
			{
				unset($history[$key]);
				break;
			}
		}
		file_put_contents(ROOT . '/store/teacher/' . $teacher . '/' . $type . '/history', json_encode($history));
	} 
}
