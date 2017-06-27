<?php
if (preg_match('#^(http|https)\:\/\/(www\.)?depositfiles\.com/#', $url)){
	$password = "";
	if(strpos($url,"|")) {
		$linkpass = explode('|', $url); 
		$url = $linkpass[0]; $password = $linkpass[1];
	}
	if (isset($_POST['password'])) $password = $_POST['password'];
	if($password) $post = "file_password=".$password;
	else $post = "";


	$account = trim($this->get_account('depositfiles.com'));
	if (stristr($account,':')) list($user, $pass) = explode(':',$account);
	else $cookie = $account;
	if(empty($cookie)==false || ($user && $pass)){
		$url=str_replace("depositfiles.com/files","depositfiles.com/en/files",$url);
		for ($j=0; $j < 2; $j++){
			if(!$cookie) $cookie = $this->get_cookie("depositfiles.com");
			if(!$cookie){
				$page=$this->curl("http://depositfiles.com/api/user/login","lang_current=en","login=$user&password=$pass&recaptcha_challenge_field=&recaptcha_response_field=");
				if(stristr($page,'"error":"InvalidLogIn"')) die('<font color=red>Invalid LogIn</font>');
				$cookie = $this->GetCookies($page);
				$this->save_cookies("depositfiles.com",$cookie);
			}
			$page=$this->curl($url,$cookie.';lang_current=en;',$post);

			if (preg_match('/ocation: *(.*)/i', $page, $redir))$link = trim($redir[1]);
			elseif (preg_match('%"(http:\/\/.+depositfiles\.com/auth.+)" onClick="%U', $page, $redir2))
				$link = trim($redir2[1]);
			elseif(stristr($page, "Such file does not exist or it has been removed for infringement of copyrights")){
				$report = Tools_get::report($Original,"dead");
				break;
			}
			elseif(stristr($page, "You have exceeded the")){
				die("<font color=red>Account out of bandwidth</font>");
			}
			
			if($link){
				$size_name = Tools_get::size_name($link, $this->cookie);
				$filesize = $size_name[0];
				$filename = $size_name[1];
				break;
			}
			else {
				$cookie = ""; 
				$this->save_cookies("depositfiles.com","");
			}
		}
	}
}
/*
* Home page: http://vinaget.us
* Blog:	http://blog.vinaget.us
* Script Name: Vinaget 
* Version: 2.6.3
* Created: ..:: [H] ::..
*/
?>