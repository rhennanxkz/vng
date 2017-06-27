<?php
$account = trim($this->get_account('multi-debrid.com'));
if (stristr($account,':')) list($user, $pass) = explode(':',$account);
else $cookie = $account;
if(empty($cookie)==false || ($user && $pass)){
	for ($j=0; $j < 2; $j++){
		if(!$cookie) $cookie = $this->get_cookie("multi-debrid.com");
		if(!$cookie) {
			if (isset($_POST['captcha']) && $_POST['captcha'] == "reload")
				$data = $this->curl("http://www.multi-debrid.com/login", "lang=en", "");
			elseif (empty($_POST['captch'])==false && empty($_POST['cooki'])==false) {
				$captch = $_POST['captch'];
				$cooki = $_POST['cooki'];
				$data = $this->curl("http://www.multi-debrid.com/login", $cooki."; lang=en", "user[identity]=".$user."&user[pass]=".$pass."&captcha=".$captch."&action=login");
			}
			else $data = $this->curl("http://www.multi-debrid.com/login", "lang=en", "");
			if (stristr($data, "simple-php-captcha.php")) {
				if(preg_match('%img src="(.*)"%U', $data, $matches)) {
					$page = $this->curl("http://www.multi-debrid.com".trim($matches[1]), $this->GetCookies($data), "");
					$captcha_img = substr($page, strpos($page, "\r\n\r\n") + 4);
					if (file_exists($captcha_img)) unlink($captcha_img);
					if (!$this->write_file("captcha.png", $captcha_img)) die("<font color=blue>".$url."</font> <font color=red>==&#9658; Authentication Required, please contact admin@france10s.com</font>");
					die("cookie code '".$this->GetCookies($data)."'");
				}
				else die("<font color=blue>".$url."</font> <font color=red>==&#9658; Authentication Required, please contact admin@france10s.com</font>");
			}
			$cookie = $this->GetCookies($data);
			$this->save_cookies("multi-debrid.com", $cookie);
		}
		$this->cookie = $cookie;
		if(strpos($url,"|")) {
			$linkpass = explode('|', $url); 
			$url = $linkpass[0];
			$pass = $linkpass[1];
		}
		$url = str_replace("https", "http", $url);
		$data = $this->curl("http://www.multi-debrid.com/ajaxdownloader?link=".$url, $cookie, "", 0);
		$page = @json_decode($data, true);
		if (stristr($data, "no vip")) $report = Tools_get::report($url,"disabletrial");
		elseif (isset($page['link']) && $page['status'] == 200) {
			$link = trim($page['link']);
			$size_name = Tools_get::size_name($link, $this->cookie);
			if($size_name[0] > 200) {
				$filesize = $size_name[0];
				$filename = $size_name[1];
				break;
			}
			else $link = "";
		}
		elseif (empty($page['html']) == false) {
			if (preg_match_all("/<td>(.*)<\/td>/", $page['html'], $match))
				die("<font color=red><b>".$match[1][2]."</b></font>");
		}
		else {
			$cookie = ""; 
			$this->save_cookies("multi-debrid.com", "");
		}
	}
}
/*
* Home page: http://vinaget.us
* Blog:	http://blog.vinaget.us
* Script Name: Vinaget 
* Version: 2.6.3
* Created: France
*/
?>