<?php

$Secure = true;				# true : private host - false : public host
$SecureID = array(
"mtn",				# pass...
);

$homepage = "bywarrior.com";
$fileinfo_dir = "data";
$fileinfo_ext = "dat";
$filecookie = "cookie.php";

$download_prefix = "";
$limitMBIP = 1024*1000;		# limit load file for 1 IP (MB)
$ttl = 60*6;				# time to live (in minutes)
$limitPERIP = 100;			# limit file per mins, chmod 777 to folder tmp (files)
$ttl_ip = 1;				# limit load file per time (in minutes)
$max_jobs_per_ip = 5000;	# total jobs for 1 IP  per time live
$max_jobs = 100000;			# max total jobs in this host   
$max_load = 50;				# max server load (%)

$title = "[color=#666633]..::..DownLoAd..::..[/color]"; # Example: [color=red]http://france10s.us[/color]
$colorfilename = "DARKORANGE";
$colorfilesize = "BROWN";

$ziplink = false;			#true : enable Zip URL to http://adf.ly - false : disable Zip URL to http://adf.ly
# if you want support me, please register from my Referrals ==> http://adf.ly/?id=678589
$apiadf = "http://api.adf.ly/api.php?key=08b16705567cfa6c9b749407e080faae&uid=678589&advert_type=int&domain=adf.ly&url=";
$listfile = true;			# enable/disable all user can see list files.
$privatefile = false;		# enable/disable other people can see your file in the list files
$privateip = false;			# enable/disable other people can download your file.
$checkacc = true;			# enable/disable all user can use check account.
$checklinksex = false;		# enable/disable check link 3x,porn...

$action = array(			# action with file in server files, set to true to enable, set to false to disable
'rename' => true,
'delete' => true,
);

$mod10s = false;				# enable/disable login host for mod 10s
$debrid = true;				# enable/disable get link with debrid plugin
$plugin = "multi-debrid_com.php";	# file plugin

# List of Bad Words, you can add more
$badword = array("porn","jav ","Uncensored","xxx japan","tora.tora","tora-tora","SkyAngle","Sky_Angel","Sky.Angel","Incest","fuck","Virgin","PLAYBOY","Adult","tokyo hot","Gangbang","BDSM","Hentai","lauxanh","homosexual","bitch" ,"Torture","Nurse","phim 18+"," Hentai","Sex Videos","Adult","Adult XXX","XXX movies","Free Sex","hardcore","rape","jav4u","javbox","jav4you","akiba-online.com","JAVbest.ORG","X-JAV","cnnwe.com","J4v.Us","J4v.Us","teendaythi.com","entnt.com","khikhicuoi.us","sex-scandal.us","hotavxxx.com");

require_once('languages.php');
?>