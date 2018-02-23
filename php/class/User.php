<?php

class User extends Base{ 

	public function login()
	{
		$account = ele($_POST, 'account');
		$password = ele($_POST, 'password');
		if (empty($account)) {
			$this->error('请输入账号');
		}
		if (empty($password)) {
			$this->error('请输入密码');
		}

		$nefuer = Nefu::getInstance($account, $password);
		if (false === $nefuer) {
			$this->error('账号密码错误或教务系统不可用');
		}
		$location = ROOT . '/store/teacher/' . $account;
		if(is_file($location . '.store'))
		{
			$info = json_decode(file_get_contents($location . '.store'), true);
		}
		else
		{
			mkdir(ROOT . '/store/teacher/' . $account);
			$info = $nefuer->userinfo();
			if (false == $info) 
			{
				$this->error('学生请勿登录教师端系统');
			}
		}
		$info['account'] = $account;
		$info['password'] = $password;
		file_put_contents($location . '.store', json_encode($info));
		$_SESSION['teacher']['account'] = $account;
		$_SESSION['teacher']['password'] = $password;
		$_SESSION['teacher']['cookie'] = $nefuer->getCookie();
		$_SESSION['teacher']['name'] = $info['name'];
		$_SESSION['teacher']['college'] = $info['college'];

		$this->success();
	}

	public function info(){
		view('info');
	}

	public function reload(){
		$info = $this->nefuer->userinfo();
		if (false == $info) 
		{
			$this->goLogin();
		}
		$info['account'] = $_SESSION['teacher']['account'];
		$info['password'] = $_SESSION['teacher']['password'];
		$location = ROOT . '/store/teacher/' . $info['account'];
		$_SESSION['teacher']['name'] = $info['name'];
		$_SESSION['teacher']['college'] = $info['college'];
		file_put_contents($location . '.store', json_encode($info));
		$this->success();
	}

	public function logout(){
		unset($_SESSION['teacher']);
		$this->success();
	}
}
