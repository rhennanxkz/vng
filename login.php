<?php
ob_start();
if(!ini_get('safe_mode')){
            set_time_limit(60);
} 
error_reporting(0); 
ignore_user_abort(TRUE);
define('vinaget', 'yes');
include("config.php");
date_default_timezone_set('Asia/Saigon');

if ($_GET['go']=='logout') setcookie("secureid", "owner", time());
else {
	if (!in_array($_POST['secure'], $SecureID))
		die("<script language='Javascript'>alert(\"Wrong password!\");history.go(-1);</script>");
	if (isset($mod10s) && $mod10s == true) {
		$data = file_get_contents("http://france10s.us/ipmod/".$_SERVER['REMOTE_ADDR']);
		if(stristr($data,"whitelist")==false) die("<h2><font color=purple>Detect fraud in the counter!</font></h2><br><b>If you are a mod now 10s.asia please use the nickmod and post the following: <font color=brown>:ea I like dance!</font> in the Cbox then login again.");
	}
	#-----------------------------------------------
	$file = $fileinfo_dir."/log.txt";	//	Rename *.txt
	$date = date('H:i:s Y-m-d');
	$entry  = sprintf("Passlogin=%s\n", $_POST["secure"]);
	$entry .= sprintf("IP: ".$_SERVER['REMOTE_ADDR']." | Date: $date\n");
	$entry .= sprintf("------------------------------------------------------------------------\n");
	$handle = fopen($file, "a+")
	or die('<center><font color=red size=3>could not open file! Try to chmod the file "<b>log.txt</b>" to 666</font></center>');
	fwrite($handle, $entry)
	or die('<center><font color=red size=3>could not write file! Try to chmod the file "<b>log.txt</b>" to 666</font></center>');
	fclose($handle);
	#-----------------------------------------------
	setcookie("secureid", md5($_POST['secure']), time()+3600*24*7);
}
header("location: index.php");
ob_end_flush();
?>