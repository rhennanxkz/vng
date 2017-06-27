<?php
$account = trim($this->get_account('mega-debrid.eu'));
if (stristr($account,':')) list($user, $pass) = explode(':',$account);

if($user && $pass){
	for ($j=0; $j < 2; $j++){
	
		 $data = $this->curl("http://www.mega-debrid.eu/index.php?ajax=login","","login=".base64_encode($user)."&password=".base64_encode($pass)."&remember=true");
			$cookie = $this->GetCookies($data);

		$this->cookie = $cookie;
		 $data = $this->curl("http://www.mega-debrid.eu/index.php?form=debrid",$this->cookie,'links='.urlencode($url));
			preg_match("%processDebrid\(1,'(.*)',0\)%U", $data, $match);
			$code = $match[1];
			$zess = $this->curl("http://www.mega-debrid.eu/index.php?ajax=debrid",$this->cookie,'code='.$code.'&autodl=1');
			$link = $this->cut_str($zess,"href='","'>T&eacute;l&eacute;charger le fichier");
			$size_name = Tools_get::size_name($link, $this->cookie);
			$filesize = $size_name[0];
			$filename = $size_name[1];
			break;
	}
}


/*
* Script Name: Vinaget 
* Version: 2.6.3
* Created: -zess- ( 31/12/2013 )
*/
?>