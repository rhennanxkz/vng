<?php
$account = trim($this->get_account('debriditalia.com'));
if (stristr($account,':')) list($user, $pass) = explode(':',$account);
else $cookie = $account;
if(empty($cookie)==false || ($user && $pass)){
	for ($j=0; $j < 2; $j++){
		if(!$cookie) $cookie = $this->get_cookie("debriditalia.com");
		if(!$cookie){
			$data = $this->curl("http://debriditalia.com/login.php?u={$user}&p={$pass}&sid=".time(), "fplang=en", "");
			$cookie = "fplang=en;".$this->GetCookies($data);
			$this->save_cookies("debriditalia.com",$cookie);
		}
		$data = $this->curl("http://debriditalia.com/linkgen2.php", "fplang=en;".$cookie, "xjxfun=convertiLink&xjxargs[]=".urlencode($url), 0);
		if(stristr($data,'File not available')) 	die(Tools_get::report($Original,"dead"));
		elseif(stristr($data,'Unsupported host or bad typed link')) 	die("Unsupported host or bad typed link");
		elseif(preg_match('%<a href="(https?:\/\/.+debriditalia\.com\/dl\/.+)">%U', $data, $giay)) {
			$link = trim($giay[1]); 
			$size_name = Tools_get::size_name($link, $this->cookie);
			if($size_name[0] > 200 ){
				$filesize =  $size_name[0];
				$filename = $size_name[1];
				break;
			}
			else {
				$data = $this->curl($link, $this->cookie, ""); 
				$link =  $this->cut_str($data, "Location:", "\\s X-Powered");
				$link = explode("\n", $link);
				$link = trim($link[0]);
				if($link){
					$size_name = Tools_get::size_name($link, $this->cookie);
					if($size_name[0] > 200 ){
						$filesize =  $size_name[0];
						$filename = $size_name[1];
						break;
					}
					else die("<font color=red>Error: Download link not found.</font>");
				}
			}
		}
		else {
			$cookie = "";
			$this->save_cookies("debriditalia.com","");
		}
	}
}

/*
* Debriditalia.com Download Plugin by giaythuytinh176 [29.8.2013]
*/
?>