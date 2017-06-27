<?php
error_reporting (E_ALL);
define('vinaget', 'yes');
include("class.php");
function check_account($host,$account){
	global $obj;
	foreach ($obj->acc[$host]['accounts'] as $value)
		if ($account == $value) return true; 
	return false;
}
if (empty($_POST["accounts"])==false) {
	$obj = new stream_get();
	$type = $_POST['type'];

	$_POST["accounts"] = str_replace(" ","",$_POST["accounts"]);
	$account = trim($_POST['accounts']);
	$donate = false;
################################## DONATE ACC real-debrid.com #################################################################
	if($type == "real-debrid"){
		if(check_account("real-debrid.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$data = $obj->curl("https://www.real-debrid.com/ajax/login.php?user=".urlencode($user)."&pass=".urlencode($pass)."","","");
			//You are blocked for one hour because of too many attempts !
			if(strpos($data,"You are blocked")) die("You are blocked for one hour because of too many attempts !");
			elseif(strpos($data,"Your login informations are incorrect") || strpos($data,"Your account is not active or has been suspended") || strpos($data,"You are blocked"))
				die("false");
			else {
				preg_match('%(auth=.+);%U', $data, $cook);
				$cookie = $cook[1];
			}
		}
		else $cookie = $account;
		if(check_account("real-debrid.com",$cookie)==true) die("false");
		$cookie = preg_replace("/(auth=|AUTH=|Auth=)/","",$cookie);
		$data = $obj->curl("https://www.real-debrid.com","auth=".$cookie,"");
		if(preg_match('%<li>Premium :<span class="fidelity">(.*)</span></li>%U', $data, $matches)) {
			$obj->acc["real-debrid.com"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC real-debrid.com #################################################################

################################## DONATE ACC alldebrid.com ###################################################################
	elseif($type == "alldebrid"){
		if(check_account("alldebrid.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$data = $obj->curl("http://www.alldebrid.com/register/?action=login&returnpage=&login_login=".urlencode($user)."&login_password=".urlencode($pass),"","login_login=".urlencode($user)."&login_password=".urlencode($pass));
			//you are banned 23min for non respect of AllDebrid flood policy (reason : Too mutch login fail.)
			if(strpos($data,"The password is not valid") || strpos($data,"You are banned"))
				die("false");
			else {
				preg_match("%uid=(.*);%U", $data, $matches);
				$cookie = $matches[1];
			}
		}
		else $cookie = $account;
		if(check_account("alldebrid.com",$cookie)==true) die("false");
		$cookie = preg_replace("/(uid=|UID=|Uid=)/","",$cookie);
		$data = $obj->curl("http://www.alldebrid.com/account/","uid=".$cookie,"");
		if(strpos($data,'</strong>Premium</li>')) {
			$obj->acc["alldebrid.com"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC alldebrid.com ###################################################################

################################## DONATE ACC rapidshare.com ##################################################################
	elseif($type == "rapidshare"){
		if(check_account("rapidshare.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$data = $obj->curl("http://api.rapidshare.com/cgi-bin/rsapi.cgi","","sub=getaccountdetails&withcookie=1&withpublicid=1&login=".$user."&cbf=RSAPIDispatcher&cbid=2&password=".$pass."");
			if(strpos($data,'Login failed'))
				die("false");
			else {
				$cookie  = $obj->cut_str($data, "ncookie=","\\n");
			}
		}
		else $cookie = $account;
		if(check_account("rapidshare.com",$cookie)==true) die("false");
		$cookie = preg_replace("/(enc=|Enc=|ENC=)/","",$cookie);
		$data = $obj->curl("http://api.rapidshare.com/cgi-bin/rsapi.cgi","","sub=getaccountdetails&withcookie=1&withpublicid=1&withsession=1&cookie=".$cookie."&cbf=RSAPIDispatcher&cbid=1");
		if(preg_match('/billeduntil=([0-9]+)/', $data, $matches)) {
			if (time() < $matches[1]) { 
				$obj->acc["rapidshare.com"]['accounts'][] = $account;
				$donate = true;
			}
		}
	}
################################## DONATE ACC rapidshare.com ##################################################################

################################## DONATE ACC hotfile.com #####################################################################
	elseif($type == "hotfile"){
		if(check_account("hotfile.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$data = $obj->curl("http://www.hotfile.com/login.php","","returnto=/&user=".$user."&pass=".$pass."&=Login");
			if(strpos($data,"Bad username/password combination"))
				die("false");
			else {
				preg_match('/^Set-Cookie: auth=(.*?);/m', $data, $matches);
				$cookie = $matches[1];
			}
		}
		else $cookie = $account;
		if(check_account("hotfile.com",$cookie)==true) die("false");
		$cookie = preg_replace("/(auth=|AUTH=|Auth=)/","",$cookie);
		$ch = @curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://hotfile.com/myaccount.html");
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_COOKIE, "auth=".$cookie);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
		$data = curl_exec( $ch);
		curl_close($ch); 
		if(preg_match('%<p>Premium until: <span class="rightSide">(.+) <b>%U', $data, $matches)) {
			$obj->acc["hotfile.com"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC hotfile.com #####################################################################

################################## DONATE ACC uploading.com ###################################################################
	elseif($type == "uploading"){
		if(check_account("uploading.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$tid = str_replace(".","12",microtime(true));
			$data = $obj->curl("http://uploading.com/general/login_form/?JsHttpRequest=".$tid."-xml","","email=".$user."&password=".$pass."");
			if(strpos($data,"Incorrect e-mail\/password combination") || strpos($data,"captcha"))
				die("false");
			else $cookie = $obj->GetCookies($data);
		}
		else $cookie = "remembered_user=".$account;
		if(check_account("uploading.com",$cookie)==true) die("false");
		$data = $obj->curl("http://uploading.com/account/subscription",$cookie,"");
		if(strpos($data,"Valid Until")) {
			$obj->acc["uploading.com"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC uploading.com ###################################################################

################################## DONATE ACC uploaded.net ####################################################################
	elseif($type == "uploaded") {
		if(check_account("uploaded.net",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$data = $obj->curl("http://uploaded.net/io/login","","id=".$user."&pw=".$pass."");
			if(strpos($data,"password combination"))
				die("false");
			else {
				preg_match('/^Set-Cookie: login=(.*?);/m', $data, $matches);
				$cookie = $matches[1];
			}
		}
		else $cookie = $account;
		if(check_account("uploaded.net",$cookie)==true) die("false");
		$cookie = preg_replace("/(login=|LOGIN=|Login=)/","",$cookie);
		$data = $obj->curl("http://uploaded.net","login=".$cookie,"");  
		if(strpos($data,'<em>Premium</em>')) {
			$obj->acc["uploaded.net"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC uploaded.net ####################################################################

################################## DONATE ACC filefactory.com #################################################################
	elseif($type == "filefactory"){
		//==== Fix link ====
		$url = "http://filefactory.com/";
		$data = $obj->curl("".$url."","","");
		if (preg_match('/ocation: (.*)/', $data, $fftlink)) $url = trim($fftlink[1]);
		$linkFFT= explode('/', $url);
		$urllogin = "http://".$linkFFT[2]."/member/login.php";
		//==== Fix link ====
		if(check_account("filefactory.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$post["email"] = $user;
			$post["password"] = $pass;
			$page = $obj->curl("".$urllogin."","",$post);
			if(strpos($page,"Location: /member/login.php"))
				die("false");
			else {
				preg_match('/^Set-Cookie: ff_membership=(.*?);/m', $page, $matches);
				$cookie = $matches[1];
			}
		}
		else $cookie = $account;
		if(check_account("filefactory.com",$cookie)==true) die("false");
		$cookie = preg_replace("/(ff_membership=|Ff_membership=|FF_MEMBERSHIP=)/","",$cookie);
		$data = $obj->curl("".$url."member/","ff_membership=".$cookie,"");
		if(strpos($data,"Premium member until")) {
			$obj->acc["filefactory.com"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC filefactory.com #################################################################

################################## DONATE ACC bayfiles.com ####################################################################
	elseif($type == "bayfiles"){
		if(check_account("bayfiles.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$page = $obj->curl("http://bayfiles.com/ajax_login","","action=login&username=".$user."&password=".$pass."&next=%252F&=");
			if(strpos($page,"Login failed. Please try again"))
				die("false");
			else {
				preg_match('/SESSID=(.*);/',$page,$temp);
				$cookie = $temp[1];
			}
		}
		else $cookie = $account;
		if(check_account("bayfiles.com",$cookie)==true) die("false");
		$cookie = preg_replace("/(SESSID=|sessid=|Sessid=)/","",$cookie);
		$data = $obj->curl("http://bayfiles.com/account","SESSID=".$cookie,"");
		if(strpos($data,'<p>Premium</p>')) {
			$obj->acc["bayfiles.com"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC bayfiles.com ####################################################################

################################## DONATE ACC rapidgator.net ##################################################################
	elseif($type == "rapidgator"){
		if(check_account("rapidgator.net",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$data = $obj->curl("https://rapidgator.net/auth/login","","LoginForm[email]=".$user."&LoginForm[password]=".$pass."&LoginForm[rememberMe]=1");
			if(strpos($data,"Please fix the following input errors:"))
				die("false");
			else {
				preg_match('/user__=(.*)/', $data, $matches);
				$cookie = $matches[1];
			}
		}
		else $cookie = $account;
		if(check_account("rapidgator.net",$cookie)==true) die("false");
		$cookie = preg_replace("/(user__=|USER__=|User__=)/","",$cookie);
		$data = $obj->curl("https://rapidgator.net/article/premium","user__=".$cookie,"");
		if(strpos($data,"You already have premium")) {
			$obj->acc["rapidgator.net"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC rapidgator.net ##################################################################

################################## DONATE ACC filepost.com ####################################################################
	elseif($type == "filepost"){
		if(check_account("filepost.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$tid = str_replace(".","12",microtime(true));
			$data = $obj->curl("http://filepost.com/general/login_form/?JsHttpRequest=".$tid."-xml","","email=".$user."&password=".$pass."");
			if(strpos($data,"Incorrect e-mail\/password combination"))
				die("false");
			else $cookie = $obj->GetCookies($data);
		}
		else $cookie = "SID=".$account;
		if(check_account("filepost.com",$cookie)==true) die("false");
		$data = $obj->curl("http://filepost.com/profile/",$cookie,"");
		if(strpos($data,"Account type: <span>Premium<")) {
			$obj->acc["filepost.com"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC filepost.com ####################################################################

################################## DONATE ACC depositfiles.com ################################################################
	elseif($type == "depositfiles"){
		if(check_account("depositfiles.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$data=$obj->curl("http://depositfiles.com/api/user/login","lang_current=en","login=$user&password=$pass");
			if(strpos($data,"Your password or login is incorrect"))
				die("false");
			else {
				$cookie = $obj->GetCookies($data);
			}
		}
		else $cookie = $account;
		if(check_account("depositfiles.com",$cookie)==true) die("false");
		$data = $obj->curl("http://depositfiles.com/gold/payment_history.php",$cookie.'; lang_current=en;',"");
		if(strpos($data,"You have Gold access until")) {
			$obj->acc["depositfiles.com"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC depositfiles.com ################################################################

################################## DONATE ACC bitshare.com ####################################################################
	elseif($type == "bitshare"){
		if(check_account("bitshare.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$data=$obj->curl("http://bitshare.com/login.html","","user=$user&password=$pass&rememberlogin=&submit=Login");
			if(strpos($data,"Click here to login"))
				die("false");
			else {
				$cookie = $obj->GetCookies($data);
			}
		}
		else $cookie = $account;
		if(check_account("bitshare.com",$cookie)==true) die("false");
		$data = $obj->curl("http://bitshare.com/myaccount.html", $cookie."; language_selection=EN;", "");
		if(strpos($data,'Premium  <a href="http://bitshare.com/myupgrade.html">Extend</a>')) {
			$obj->acc["bitshare.com"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC bitshare.com ####################################################################

################################## DONATE ACC ryushare.com ####################################################################
	elseif($type == "ryushare"){
		if(check_account("ryushare.com",$account)==true) die("false");
		if (stristr($account,':')) {
			list($user, $pass) = explode(':', $account);
			$data=$obj->curl("http://ryushare.com/","lang=english","op=login&redirect=http%3A%2F%2Fryushare.com%2F&login=$user&password=$pass&loginFormSubmit=Login");
			if(strpos($data,"Incorrect Login or Password"))
				die("false");
			else {
				$cookie = $obj->GetCookies($data);
			}
		}
		else $cookie = $account;
		if(check_account("ryushare.com",$cookie)==true) die("false");
		$data = $obj->curl("http://ryushare.com/my-account.python", $cookie, "");
		if(strpos($data,'Renew premium')) {
			$obj->acc["ryushare.com"]['accounts'][] = $account;
			$donate = true;
		}
	}
################################## DONATE ACC ryushare.com ####################################################################

################################## Save Account ###############################################################################
	if($donate == true && is_array($obj->acc) && count($obj->acc) > 0) {
		$str = "<?php";
		$str .= "\n";
		$str .= "\n\$this->acc = array(";
		$str .= "\n";
		$str .= "# Example: 'accounts'	=> array('user:pass','cookie'),\n";
		$str .= "# Example with letitbit.net: 'accounts'	 => array('user:pass,cookie,prekey=xxxx'),\n";
		$str .= "\n";
		foreach ($obj->acc as $host => $accounts) {
			$str .= "\n	'".$host."'		=> array(";
			$str .= "\n								'max_size'	=> ".($accounts['max_size']?$accounts['max_size']:1024).",";
			$str .= "\n								'accounts'	=> array(";
			foreach ($accounts['accounts'] as $acc) {
				$str .= "\"".$acc."\",";
			}
			$str .= "),";
			$str .= "\n							),";
			$str .= "\n";
		}
		$str .= "\n);";
		$str .= $obj->max_size_other_host ? "\n\$this->max_size_other_host = ".$obj->max_size_other_host.";" : "\n\$this->max_size_other_host = 1024;";
		$str .= "\n";
		$str .= "\n?>";
		$accountPath = "account.php";
		$CF = fopen ($accountPath, "w")
		or die('<CENTER><font color=red size=3>could not open file! Try to chmod the file "<B>account.php</B>" to 666</font></CENTER>');
		fwrite ($CF, $str)
		or die('<CENTER><font color=red size=3>could not write file! Try to chmod the file "<B>account.php</B>" to 666</font></CENTER>');
		fclose ($CF); 
		@chmod($accountPath, 0666);

		echo "true";
	}
	else echo "false";
################################## Save Account ###############################################################################

}
/*
* Home page: http://vinaget.us
* Blog:	http://blog.vinaget.us
* Script Name: Vinaget 
* Version: 2.6.3 Design Final
* Description: 
	- Vinaget is script generator premium link that allows you to download files instantly and at the best of your Internet speed.
	- Vinaget is your personal proxy host protecting your real IP to download files hosted on hosters like RapidShare, megaupload, hotfile...
	- You can now download files with full resume support from filehosts using download managers like IDM etc
	- Vinaget is a Free Open Source, supported by a growing community.
* Code LeechViet by VinhNhaTrang
* Developed by ..:: [H] ::..
*/
?>