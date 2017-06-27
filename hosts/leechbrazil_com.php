<?php
$account = trim($this->get_account('leechbrazil.com'));
if (stristr($account,':')) list($user, $pass) = explode(':',$account);
else $cookie = $account;
if(empty($cookie)==false || ($user && $pass)){
	for ($j=0; $j < 2; $j++){
		if(!$cookie) $cookie = $this->get_cookie("leechbrazil.com");
		if(!$cookie){
			$data = $this->curl("http://leechbrazil.com/login_1.php","","email=".$user."&senha=".$pass);
			$cookie = "eCP=".$user."; sCP=".md5($pass)."; cCP=LEECHBRAZIL-SOMOS_MAIS_INTELIGENTES_QUE_VOCE;";
		}
		$this->cookie = $cookie;
		
    $data = curl("http://leechbrazil.com/gerar.php",$cookie,"links=".$url);
	//	echo $data = $this->curl("http://leechbrazil.com/gerar.php",$cookie,"links=".$url);
	//	echo $data = file_get_contents('http://leechbrazil.com/gerar.php?links='.$url,$cookie);

		preg_match('/href=\'(.*?)\' style=/', $data, $linkpre);
		$link = trim($linkpre[1]);
		$size_name = Tools_get::size_name($link, $this->cookie);
		$filesize = $size_name[0];
		$filename = $size_name[1];
		break;

	}
}


function curl($url, $cookies, $post, $header=1){
	$ch = @curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, $header);
	if ($cookies) curl_setopt($ch, CURLOPT_COOKIE, $cookies);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:5.0) Gecko/20100101 Firefox/5.0');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_REFERER,$url); 
	if ($post){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
	}
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
	$page = curl_exec( $ch);
	curl_close($ch); 
	return $page;
}

?>