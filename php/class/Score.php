<?php

class Score extends Base{ 

	public function index(){
		view('score');
	}

	public function start(){
		$data = array(
			'grade' => ele($_POST, 'grade', ''),
			'major' => ele($_POST, 'major', ''),
			'class' => ele($_POST, 'class', ''),
			'term' => ele($_POST, 'term', ''),
			'type' => ele($_POST, 'type', ''),
			'lesson' => ele($_POST, 'lesson', ''),
			'student' => ele($_POST, 'student', ''),
			'showWay' => ele($_POST, 'showWay', ''),
		);
		$dataV = array(
			'grade' => str_replace('<i></i>', '', ele($_POST, 'gradeV', '')),
			'major' => str_replace('<i></i>', '', ele($_POST, 'majorV', '')),
			'class' => str_replace('<i></i>', '', ele($_POST, 'classV', '')),
			'term' => str_replace('<i></i>', '', ele($_POST, 'termV', '')),
			'type' => str_replace('<i></i>', '', ele($_POST, 'typeV', '')),
			'lesson' => ele($_POST, 'lessonV', ''),
			'student' => ele($_POST, 'studentV', ''),
			'showWay' => str_replace('<i></i>', '', ele($_POST, 'showWayV', '')),
		);
		$title = ele($_POST, 'title', '');
		$time = date('Y-m-d H:i', time());
		$teacher = $_SESSION['teacher']['account'];
		$history_dir = ROOT . '/store/teacher/' . $teacher . '/score/';
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
		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/?c=score&f=operate_auto'; 
		$data['id'] = $id;
		$this->doRequest($url, $data);
		$this->success(array(
			'id' => $id,
			'url' => $url,
			'data' => $data,
		));
	}

	public function operate_auto(){
		ignore_user_abort(true);
		set_time_limit(0);
		$data = array(
			'' => ele($_POST, 'grade', ''),
			'' => ele($_POST, 'major', ''),
			'' => ele($_POST, 'class', ''),
			'' => ele($_POST, 'term', ''),
			'' => ele($_POST, 'type', ''),
			'' => ele($_POST, 'lesson', ''),
			'' => ele($_POST, 'student', ''),
			'' => ele($_POST, 'showWay', ''),
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
		if ( ! is_file(ROOT . '/store/teacher/' . $teacher . '/score/' . $id)) {
			$this->error('记录不存在');
		}
		$info = file_get_contents(ROOT . '/store/teacher/' . $teacher . '/score/' . $id);
		$this->success(json_decode($info, true));
	}
}
