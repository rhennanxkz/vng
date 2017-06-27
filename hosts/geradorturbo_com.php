<?php
$account = trim($this->get_account('geradorturbo.com'));
if (stristr($account,':')) list($user, $pass) = explode(':',$account);
else $cookie = $account;
if(empty($cookie)==false || ($user && $pass)){
	for ($j=0; $j < 2; $j++){
	    if(!$cookie) $cookie = $this->get_cookie("geradorturbo.com");
		if(!$cookie){
			$data = $this->curl("http://geradorturbo.com/login.php","","txtEmail=$user&txtSenha=$pass&btnSubmited=Log in");
			$cookie = $this->GetCookies($data);
			$this->save_cookies("geradorturbo.com",$cookie);
		}
		$this->cookie = $cookie;
		 $data = $this->curl('http://geradorturbo.com/gerador.php', $this->cookie,"urllist=$url&captcha=none&");
	if (preg_match("/ href='(.*)' style/", $data, $linkpre)){
		
	       $link = $linkpre[1];
			$size_name = Tools_get::size_name($link, $this->cookie);
			$filesize = $size_name[0];
			$filename = $size_name[1];
                        break;
						}else{
		$cookie ='';
		$this->save_cookies("geradorturbo.com","");
	 }
  }
}

/*
* Script Name: Vinaget 
* Version: 2.6.3
* Created: bywarrior ( 01/4/2014 )
*/
?>