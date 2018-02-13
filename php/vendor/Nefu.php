<?php 

class Nefu
{
	private $cookie;
	private $username;
	private $password;

	private function __construct($cookie, $username, $password)
	{
		$this->cookie   = $cookie;
		$this->username = $username;
		$this->password = $password;
	}

	public static function getInstance($username, $password, $cookie = '')
	{
		if( ! empty($cookie))
		{
			return new self($cookie, $username, $password);
		}
		$loginResult = self::login($username, $password);
		if(FALSE !== $loginResult)
		{
			$cookie = $loginResult;
			return new self($cookie, $username, $password);
		}
		else
			return FALSE;
	}

	public function userinfo()
	{
        $url = 'http://jwcnew.nefu.edu.cn/dblydx_jsxsd/jsxx/queryjsxxjb.do';
        $userinfo = $this->curl_safe($url);
        if(FALSE === $userinfo)
        	return FALSE;
        else
        	return $this->html_escape($this->toInfo($userinfo));
	}

	public function getCookie()
	{
		return $this->cookie;
	}

	private function toInfo($page){
		$preg = '/<tr[^>]*?>([\s\S]*?)<\/tr>/i';
		if(preg_match_all($preg, $page, $page) == 0){
			return false;
		}
		$page = array($page[1][3], $page[1][17]);
		$preg = '/<TD[^>]*?>([\s\S]*?)<\/td>/i';
		preg_match_all($preg, $page[0], $page[0]);
		preg_match_all($preg, $page[1], $page[1]);
		$preg = '/value=\"(.*?)\"/i';
		preg_match_all($preg, $page[0][1][5], $page[0]);
		preg_match_all($preg, $page[1][1][2], $page[1]);
		$page = array(
			'name' => $page[0][1][0],
			'college' => str_replace('学院', '', $page[1][1][0]),
		);

		return $page;
	}

	private function curl_safe($url, $data = FALSE)
	{
		$result = $this->curl($url, $this->cookie, $data);
		if(empty(htmlspecialchars($result)))
		{
			$try_login = $this->login($this->username, $this->password);
			if(empty($try_login))
			{
				return FALSE;
			}
			else
			{
				$this->cookie = $try_login;
				$result = $this->curl($url, $this->cookie, $data);
				if(empty(htmlspecialchars($result)))
					return FALSE;
				else
					return $result;
			}
		}
		else
			return $result;
	}

	private function html_escape($data)
	{
		if (is_array($data))
		{
			foreach ($data as $key => $value) {
				$data[$key] = $this->html_escape($value);
			}
			return $data;
		}
		else
			return htmlspecialchars($data);
	}

	private static function login($username, $password)
	{
		$url = 'http://jwcnew.nefu.edu.cn/dblydx_jsxsd/xk/LoginToXk?method=skybinfw&USERNAME=' . $username . '&PASSWORD=' . $password;
		$cookie = '';
		$loginResult = self::curl($url, $cookie);
		if(empty(htmlspecialchars($loginResult)) || empty($cookie))
			return FALSE;
		else
			return $cookie;
	}

	private static function curl($url, &$cookie, $data = FALSE)
	{
	    $ch = curl_init();
		$curl_opt = array(
			CURLOPT_URL            => $url,
			CURLOPT_HEADER         => 1,//设置不返回header
			CURLOPT_RETURNTRANSFER => 1,//设置不显示页面
			CURLOPT_TIMEOUT        => 10, //防止超时
			CURLOPT_COOKIE         => $cookie,
		);
		if(FALSE !== $data)
		{
	    	//post方式提交
		    $curl_opt[CURLOPT_POST] = 1;
		    //要提交的信息
	    	$data = http_build_query($data);
	    	$curl_opt[CURLOPT_POSTFIELDS] = $data;
		}
		curl_setopt_array($ch, $curl_opt);
	    $result = curl_exec($ch);
		preg_match_all('/Set-Cookie: (.*);/iU', $result, $str); //正则匹配
	    if( ! empty($str))
			$cookie = self::comb_cookie($cookie, $str[1]);
	    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	    $result = substr($result, $headerSize);
	    curl_close($ch);
	    return $result;
	}

	private static function comb_cookie($str, $arr)
	{
		$cookie = array();
		$str = explode('; ', $str);
		if( ! empty($str[0]))
		{
			for($i = 0, $len = count($str); $i < $len; $i++)
			{
				$row = explode('=', $str[$i]);
				$cookie[$row[0]] = $row[1];
			}
		}
		for($i = 0, $len = count($arr); $i < $len; $i++)
		{
			$row = explode('=', $arr[$i]);
			$cookie[$row[0]] = $row[1];
		}
		if(empty($cookie))
			return '';
		$str = '';
		foreach ($cookie as $key => $value)
		{
			$str .= $key . '=' . $value . '; ';
		}
		$str = substr($str, 0, strlen($str) - 2);
		return $str;
	}
}