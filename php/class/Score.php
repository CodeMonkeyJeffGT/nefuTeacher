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
			'college' => ele($_POST, 'college', ''),
		);
		$dataV = array(
			'grade' => ele($_POST, 'gradeV', ''),
			'major' => ele($_POST, 'majorV', ''),
			'class' => ele($_POST, 'classV', ''),
			'term' => ele($_POST, 'termV', ''),
			'type' => ele($_POST, 'typeV', ''),
			'lesson' => ele($_POST, 'lessonV', ''),
			'student' => ele($_POST, 'studentV', ''),
			'showWay' => ele($_POST, 'showWayV', ''),
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
		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/?c=score&f=operateAuto'; 
		$data = array(
			'xsyx' => $data['college'],
			'xsnj' => $data['grade'],
			'xszy' => $data['major'],
			'skbj' => $data['class'],
			'xqmc' => $data['term'],
			'kcxz' => $data['type'],
			'kcmc' => $data['lesson'],
			'xm' => $data['student'],
			'xsfs' => $data['showWay'],
			'account' => $_SESSION['teacher']['account'],
			'password' => $_SESSION['teacher']['password'],
			'cookie' => $_SESSION['teacher']['cookie'],
			'id' => $id,
		);
		$this->doRequest($url, $data);
		$this->success(array(
			'id' => $id,
			'url' => $url,
			'data' => $data,
		));
	}

	public function operateAuto(){
		ignore_user_abort(true);
		set_time_limit(0);
		file_put_contents(ROOT . '/store/teacher/' . $teacher . '/score/done' . $id, 'debug');
		$data = array(
			'xsyx' => ele($_POST, 'xsyx', ''),
			'xsnj' => ele($_POST, 'xsnj', ''),
			'xszy' => ele($_POST, 'xszy', ''),
			'skbj' => ele($_POST, 'skbj', ''),
			'xqmc' => ele($_POST, 'xqmc', ''),
			'kcxz' => ele($_POST, 'kcxz', ''),
			'kcmc' => ele($_POST, 'kcmc', ''),
			'xm' => ele($_POST, 'xm', ''),
			'xsfs' => ele($_POST, 'xsfs', ''),
		);
		$id = ele($_POST, 'id', false);
		$start = ele($_POST, 'autoStart', null);
		$end = ele($_POST, 'autoEnd', null);
		$account = ele($_POST, 'account', null);
		$password = ele($_POST, 'password', null);
		$cookie = ele($_POST, 'cookie', null);
		if (false === $id) {
			$this->error('非法访问');
		}
		$this->setNefuer(Nefu::getInstance($account, $password, $cookie));
		if (is_null($start)) { //未分配，首次查询并分配任务
			$startTime = microtime(true);
			$info = $this->nefuerDo('getScores', $data);
			$auto = $this->buildAuto($info['page'], microtime(true) - $startTime);

			$url = 'http://' . $_SERVER['SERVER_NAME'] . '/?c=score&f=operateAuto';
			$data['id'] = $id;
			$data['account'] = $account;
			$data['password'] = $password;
			$data['cookie'] = $_SESSION['teacher']['cookie'];
			for ($i = 0, $iLoop = count($auto); $i < $iLoop; $i++) {
				$data['start'] = $auto[$i]['start'];
				$data['end'] = $auto[$i]['end'];
				$this->doRequest($url, $data);
			}
		} else { //已分配，执行

			for ($pageIndex = $start; $pageIndex <= $end; $pageIndex++) {
				$data['pageIndex'] = $pageIndex;
			}
		}
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
