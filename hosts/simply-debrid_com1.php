<?php
$account = trim($this->get_account('simply-debrid.com'));
if (stristr($account,':')) list($user, $pass) = explode(':',$account);
else $cookie = $account;
if(empty($cookie)==false || ($user && $pass)){
	for ($j=0; $j < 2; $j++){
		if(!$cookie) $cookie = $this->get_cookie("simply-debrid.com");
		$this->cookie = $cookie;
		$data = $this->curl("http://simply-debrid.com/inc/name.php?i=".base64_encode($url), $this->cookie, "", 0);
		if(!stristr($data,'sd.php'))  die("<font color=red>".$data."</font>");
		elseif(preg_match('%href="(https?:.+sd\.php.+)">%U', $data, $giay))  $link = trim($giay[1]);
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
			$this->save_cookies("simply-debrid.com","");
		}
	}
}


/*
* Simply-Debrid Download Plugin by giaytinh176 [30.11.2013]
*/
?>