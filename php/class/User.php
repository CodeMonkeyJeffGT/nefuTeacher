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

		$_SESSION['nefuteacher']['account'] = $account;
		$_SESSION['nefuteacher']['password'] = $password;
		$_SESSION['nefuteacher']['cookie'] = $nefuer->getCookie();
		$this->success();
	}
}
