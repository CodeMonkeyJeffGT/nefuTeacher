<?php

class Index{

	public function __construct()
	{

	}

	public function index()
	{
		if( ! empty($_SESSION['u_id']))
		{
			view('index');
		} else {
			$this->login();
		}
	}

	public function login()
	{
		view('login');
	}
}
