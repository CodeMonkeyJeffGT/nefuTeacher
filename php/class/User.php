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

		verdor('Nefu');
		$nefuer = Nefu::getInstance($account, $password);
		if (false === $nefuer) {
			$this->error('账号密码错误或教务系统不可用');
		}
		$info = $nefuer->userinfo();
		if (false == $info) 
		{
			$this->error('学生请勿登录教师端系统');
		}
		$_SESSION['teacher']['account'] = $account;
		$_SESSION['teacher']['password'] = $password;
		$_SESSION['teacher']['cookie'] = $nefuer->getCookie();
		$_SESSION['teacher']['name'] = $info['name'];
		$_SESSION['teacher']['college'] = $info['college'];

		$this->success();
	}
}
