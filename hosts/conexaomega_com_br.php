<?php
$account = trim($this->get_account('conexaomega.com.br'));
if (stristr($account,':')) list($user, $pass) = explode(':',$account);
else $cookie = $account;
if(empty($cookie)==false || ($user && $pass)){
	for ($j=0; $j < 2; $j++){
		if(!$cookie) $cookie = $this->get_cookie("conexaomega.com.br");
		if(!$cookie){
			$data = $this->curl("http://www.conexaomega.com.br/login","","email=$user&senha=$pass&lembrar=on&x=".rand(1,80)."&y=".rand(1,20));
			$cookie = $this->GetCookies($data);
			$this->save_cookies("conexaomega.com.br",$cookie);
			$data = $this->curl("http://www.conexaomega.com.br/gerador-premium",$cookie,"");
		}
		$data = $this->curl("http://www.conexaomega.com.br/_gerar?link=$url&rnd=",$cookie,"",00);
		if(stristr($data,'conexaomega.com.br')) $link = trim($data);
		$data = $this->curl($link,$cookie,"",1);
		if(preg_match('/ocation: (.*)/', $data, $match)){
			$link = trim($match[1]);
			$size_name = Tools_get::size_name($link, $this->cookie);
			if($size_name[0] > 1024 ){
				$filesize =  $size_name[0];
				$filename = $size_name[1];
				break;
			}
			else {
				$link='';
				$this->save_cookies("conexaomega.com.br",'');
			}
		}
		else {
			$cookie = "";
			$this->save_cookies("conexaomega.com.br","");
		}
	}
}

/*
* Home page: http://vinaget.us
* Blog:	http://blog.vinaget.us
* Script Name: Vinaget 
* Version: 2.6.3
* Created: raj
*/
?>