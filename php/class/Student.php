<?php

class Student extends Base{ 

	public function index(){
		view('student');
	}

	public function start(){
		$data = array(
			'grade' => ele($_POST, 'grade', ''),
			'major' => ele($_POST, 'major', ''),
			'class' => ele($_POST, 'class', ''),
			'zzmm' => ele($_POST, 'zzmm', ''),
			'sex' => ele($_POST, 'sex', ''),
			'number' => ele($_POST, 'number', ''),
			'name' => ele($_POST, 'name', ''),
			'id' => ele($_POST, 'id', ''),
			'college' => ele($_POST, 'college', ''),
		);
		$dataV = array(
			'grade' => ele($_POST, 'gradeV', ''),
			'major' => ele($_POST, 'majorV', ''),
			'class' => ele($_POST, 'classV', ''),
			'zzmm' => ele($_POST, 'zzmmV', ''),
			'sex' => ele($_POST, 'sexV', ''),
			'number' => ele($_POST, 'numberV', ''),
			'name' => ele($_POST, 'nameV', ''),
			'id' => ele($_POST, 'idV', ''),
		);
		$title = ele($_POST, 'title', '');
		$time = date('Y-m-d H:i', time());
		$teacher = $_SESSION['teacher']['account'];
		$history_dir = ROOT . '/store/teacher/' . $teacher . '/student/';
		$history = json_decode(file_get_contents($history_dir . 'history'), true);
		$id = count($history) == 0 ? 0 : $history[count($history) - 1]['id'] + 1;
		$info = array(
			'id' => $id,
			'title' => $title,
			'time' => $time,
			'status' => 1,
			'data' => $data,
			'dataV' => $dataV,
		);
		$history[] = $info;
		file_put_contents($history_dir . 'history', json_encode($history));
		file_put_contents($history_dir . $id,json_encode(array('info' => $info, 'detail' => [])));
		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/?c=student&f=operateAuto';
		$data['id'] = $id;
		$this->doRequest($url, $data);
		$this->success(array(
			'id' => $id,
		));
	}

	public function operateAuto(){
		ignore_user_abort(true);
		set_time_limit(0);
		$data = array(
			'' => ele($_POST, 'grade', ''),
			'' => ele($_POST, 'major', ''),
			'' => ele($_POST, 'class', ''),
			'' => ele($_POST, 'zzmm', ''),
			'' => ele($_POST, 'sex', ''),
			'' => ele($_POST, 'number', ''),
			'' => ele($_POST, 'name', ''),
			'' => ele($_POST, 'id', ''),
		);
		$id = ele($_POST, 'id', false);
		if (false === $id) {
			$this->error('非法访问');
		}
		$floor = ele($_POST, 'floor', 0);
		
	}

	public function info(){
		$id = ele($_POST, 'id');
		$teacher = $_SESSION['teacher']['account'];
		if ( ! is_file(ROOT . '/store/teacher/' . $teacher . '/student/' . $id)) {
			$this->error('记录不存在');
		}
		$info = file_get_contents(ROOT . '/store/teacher/' . $teacher . '/student/' . $id);
		$this->success(json_decode($info, true));
	}
}
