<?php
$account = trim($this->get_account('unrestrict.li'));
if (stristr($account,':')) list($user, $pass) = explode(':',$account);
else $cookie = $account;
if(empty($cookie)==false || ($user && $pass)){
	for ($j=0; $j < 2; $j++){
		if(!$cookie) $cookie = $this->get_cookie("unrestrict.li");
		if(!$cookie){
			$data = $this->curl("http://unrestrict.li/sign_in", "lang=EN;ssl=0;".$cookie, "return=sign_in&username={$user}&password={$pass}&remember_me=remember&signin=Sign%20in");
			$this->save_cookies("unrestrict.li","lang=EN;ssl=0;".$this->GetCookies($data));
		}
 		if(strpos($url,"|")) {
			$linkpass = explode('|', $url); 
			$url = $linkpass[0]; $pass = $linkpass[1];
		}
		$data = $this->curl("http://unrestrict.li/unrestrict.php", "lang=EN;ssl=0;{$cookie}", "domain=long&download_password={$pass}&link=".urlencode($url), 0);
		$page = json_decode($data);
		if(isset($page->$url->invalid))  die('<font color=red>'.$page->$url->invalid.'</font>');
		elseif(preg_match('%"(https?:.+(unrestrict|unr)\.li.+dl.+)":%U', $data, $link))   $link = trim(str_replace("\\", "", $link[1]));
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
			$this->save_cookies("unrestrict.li","");
		}
	}
}


/*
* Unrestrict.li Download Plugin by giaythuytinh176 [10.9.2013]
*/
?>