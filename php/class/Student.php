<?php

class Student extends Base{ 

	public function index()
	{
		view('student');
	}

	public function start(){
		$grade = ele($_POST, 'grade', '');
		$major = ele($_POST, 'major', '');
		$class = ele($_POST, 'class', '');
		$zzmm = ele($_POST, 'zzmm', '');
		$sex = ele($_POST, 'sex', '');
		$number = ele($_POST, 'number', '');
		$name = ele($_POST, 'name', '');
		$id = ele($_POST, 'id', '');
		$title = ele($_POST, 'title', '');
		$time = date('Y-m-d H:i', time());
		$teacher = $_SESSION['teacher']['account'];
		$history_dir = ROOT . '/store/teacher/' . $teacher . '/student/';
		$history = json_decode(file_get_contents($history_dir . 'history'), true);
		$id = count($history) == 0 ? 0 : $history[count($history) - 1]['id'] + 1;
		$history[] = array(
			'id' => $id,
			'title' => $title,
			'time' => $time,
			'status' => 1,
		);
		file_put_contents($history_dir . 'history', json_encode($history));
		file_put_contents($history_dir . $id, '');
		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/?c=student&f=operate_auto'; 
		$param = array(
		);
		$this->doRequest($url, $param);
		$this->success(array(
			'id' => $id,
			'title' => $title,
			'time' => $time,
			'status' => 1,
		));
	}

	public function info(){
		$this->success($_POST);
	}

	public function operate_auto(){
		ignore_user_abort(true);
		set_time_limit(0);
	}

	public function remove(){
		$id = ele($_POST, 'id');
		if(is_null($id))
			$this->error('请指定id');
		$file = ROOT . '/store/teacher/' . $teacher . '/student/' . $id;
		unset($file);
		$history = json_decode(file_get_contents(ROOT . '/store/teacher/' . $teacher . '/student/history'), true);
		foreach ($history as $key => $value) {
			if($value['id'] == $id)
			{
				unset($history[$key]);
				break;
			}
		}
		file_put_contents(ROOT . '/store/teacher/' . $teacher . '/student/history', json_encode($history));
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
		if(false === $stepInfo)
			$this->goLogin();
		else
			$this->success($stepInfo);
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

