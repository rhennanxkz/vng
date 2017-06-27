<?php
$account = trim($this->get_account('geradorturbo.com'));


	for ($j=0; $j < 2; $j++){
		
		$cookie = "PHPSESSID=uedd42ii5uj2db3vp3ogf27s75;";
			$data = $this->curl("http://geradorturbo.com/login.php","","txtEmail=$user&txtSenha=$pass&btnSubmited=Log in");
		
		$this->cookie = $cookie;
		 $data = $this->curl('http://geradorturbo.com/gerador.php', $this->cookie,"urllist=$url&captcha=none&");
	
		preg_match("/ href='(.*)' style/", $data, $linkpre);
	       $link = $linkpre[1];
			if($link) {
			$size_name = Tools_get::size_name($link, $cookie);
			if($size_name[0] > 200 ){
				$filesize = $size_name[0];
				$filename = $size_name[1];
				break;
			}
			else die("<font color=red>Error: Download link not found.</font>");
		}
		else {
			$cookie = "";
			$this->save_cookies("geradorturbo.com","");
		}
	
}
/*
* Script Name: Vinaget 
* Version: 2.6.3
* Created: bywarrior ( 01/4/2014 )
*/
?>