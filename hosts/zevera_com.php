<?php
	$account = trim($this->get_account('zevera.com'));
	if (stristr($account,':')) list($user, $pass) = explode(':',$account);
	else $cookie = $account;
	if(empty($cookie)==false || ($user && $pass)){
		for ($j=0; $j < 2; $j++){
			if(!$cookie) $cookie = $this->get_cookie("zevera.com");
			if(!$cookie){
				$data = $this->curl("http://zevera.com/OfferLogin.aspx?login={$user}&pass={$pass}", "otmData=languagePref=US", "");
				$cookie = "otmData=languagePref=US;".$this->GetCookies($data);
				$this->save_cookies("zevera.com", $cookie);
			}
			$this->cookie = $cookie;
			$data = $this->curl("http://zevera.com/Member/download.ashx?ourl=".urlencode($url), $this->cookie, "");
			$link = preg_replace("/\s+/", "", $this->cut_str($data, 'Location: ', 'Server: Microsoft'));
			if(stristr($link, '/member/systemmessage.aspx?hoster'))   die("<font color=red>Service Unavailable.</font>");
			if($link) {
				$size_name = Tools_get::size_name($link, $cookie);
				if($size_name[0] > 200 ){
					$filesize = $size_name[0];
					$filename = $size_name[1];
					break;
				}
				elseif($size_name[0] <= 0 ){
					$data = $this->curl($link, $this->cookie, "");
					$link = preg_replace("/\s+/", "", $this->cut_str($data, 'Location: ', 'Server: Microsoft'));
					$size_name = Tools_get::size_name($link, $cookie);
					if($size_name[0] > 200 ){
						$filesize = $size_name[0];
						$filename = $size_name[1];
						break;
					}
					elseif($size_name[0] <= 0 ){
						$data = $this->curl($link, $this->cookie, "");
						$link = preg_replace("/\s+/", "", $this->cut_str($data, 'Location: ', 'Server: Microsoft'));
						$size_name = Tools_get::size_name($link, $cookie);
						if($size_name[0] > 200 ){
							$filesize = $size_name[0];
							$filename = $size_name[1];
							break;
						}
						elseif($size_name[0] <= 0 ){
							$data = $this->curl($link, $this->cookie, "");
							$link = preg_replace("/\s+/", "", $this->cut_str($data, 'Location: ', 'Server: Microsoft'));
							$size_name = Tools_get::size_name($link, $cookie);
							if($size_name[0] > 200 ){
								$filesize = $size_name[0];
								$filename = $size_name[1];
								break;
							}
							elseif($size_name[0] <= 0 ){
								$data = $this->curl($link, $this->cookie, "");
								$link = preg_replace("/\s+/", "", $this->cut_str($data, 'Location: ', 'Server: Microsoft'));
								$size_name = Tools_get::size_name($link, $cookie);
								if($size_name[0] > 200 ){
									$filesize = $size_name[0];
									$filename = $size_name[1];
									break;
								}
								elseif($size_name[0] <= 0 ){
									$data = $this->curl($link, $this->cookie, "");
									$link = preg_replace("/\s+/", "", $this->cut_str($data, 'Location: ', 'Server: Microsoft'));
									$size_name = Tools_get::size_name($link, $cookie);
									if($size_name[0] > 200 ){
										$filesize = $size_name[0];
										$filename = $size_name[1];
										break;
									}
									else die("<font color=red>Error: Download link not found.</font>");
								}
								else die("<font color=red>Error: Download link not found.</font>");
							}
							else die("<font color=red>Error: Download link not found.</font>");
						}
						else die("<font color=red>Error: Download link not found.</font>");
					}
					else die("<font color=red>Error: Download link not found.</font>");
					
				}
				else die("<font color=red>Error: Download link not found.</font>");
			}
			else {
				$cookie = "";
				$this->save_cookies("zevera.com","");
			}
		}
	}

/*
* zevera Download Plugin by giaythuytinh176 [7.9.2013][18.1.2013][fixed]
*/
?>