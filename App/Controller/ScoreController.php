<?php
namespace App\Controller;
use App\Controller\BaseController;
use FF\Vendor\Nefu;

class ScoreController extends BaseController{ 

	public function index(){
		$this->buildInfo();
		$this->display('score');
	}

	public function start(){
		$data = array(
			'grade' => input('post.grade', ''),
			'major' => input('post.major', ''),
			'class' => input('post.class', ''),
			'term' => input('post.term', ''),
			'type' => input('post.type', ''),
			'lesson' => input('post.lesson', ''),
			'student' => input('post.student', ''),
			'showWay' => input('post.showWay', ''),
			'college' => input('post.college', ''),
		);
		$dataV = array(
			'major' => input('post.majorV', ''),
			'class' => input('post.classV', ''),
			'term' => input('post.termV', ''),
			'type' => input('post.typeV', ''),
		);
		$title = input('post.title', '');
		$time = time();
		$info = array(
			'id' => $id,
			'title' => $title,
			'time' => $time,
			'status' => 1,
			'data' => $data,
			'dataV' => $dataV,
		);
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
			'account' => session('teacher.account'),
			'password' => session('teacher.password'),
			'cookie' => session('teacher.cookie'),
			'id' => $id,
		);
		$this->doRequest($url, $data);
		$this->success();
	}

	public function operateAuto(){
		ignore_user_abort(true);
		set_time_limit(0);
		$data = array(
			'xsyx' => input('post.xsyx', ''),
			'xsnj' => input('post.xsnj', ''),
			'xszy' => input('post.xszy', ''),
			'skbj' => input('post.skbj', ''),
			'xqmc' => input('post.xqmc', ''),
			'kcxz' => input('post.kcxz', ''),
			'kcmc' => input('post.kcmc', ''),
			'xm' => input('post.xm', ''),
			'xsfs' => input('post.xsfs', ''),
		);
		$id = input('post.id', false);
		$start = input('post.autoStart', null);
		$end = input('post.autoEnd', null);
		$account = input('post.account', null);
		$password = input('post.password', null);
		$cookie = input('post.cookie', null);
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
				$data['autoStart'] = $auto[$i]['start'];
				$data['autoEnd'] = $auto[$i]['end'];
				$this->doRequest($url, $data);
			}
		} else { //已分配，执行

			for ($pageIndex = $start; $pageIndex <= $end; $pageIndex++) {
				$data['pageIndex'] = $pageIndex;
			}
		}
	}

	public function info(){
		$id = input('post.id');
		$teacher = $_SESSION['teacher']['account'];
		if ( ! is_file(ROOT . '/store/teacher/' . $teacher . '/score/' . $id)) {
			$this->error('记录不存在');
		}
		$info = file_get_contents(ROOT . '/store/teacher/' . $teacher . '/score/' . $id);
		$this->success(json_decode($info, true));
	}
}
