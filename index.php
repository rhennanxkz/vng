<?php
date_default_timezone_set('Etc/GMT+5');
/*
* Home page: http://vinaget.us
* Blog:	http://blog.vinaget.us
* Script Name: Vinaget 
* Version: 2.6.3
* Description: 
	- Vinaget is script generator premium link that allows you to download files instantly and at the best of your Internet speed.
	- Vinaget is your personal proxy host protecting your real IP to download files hosted on hosters like RapidShare, megaupload, hotfile...
	- You can now download files with full resume support from filehosts using download managers like IDM etc
	- Vinaget is a Free Open Source, supported by a growing community.
* Code LeechViet by VinhNhaTrang
* Developed by ..:: [H] ::..
*/

ob_start();
error_reporting (0);
ob_implicit_flush (TRUE);
ignore_user_abort (0);
if(!ini_get('safe_mode')){
	set_time_limit(30);
}
define('vinaget', 'yes');

include("class.php");
$obj = new stream_get(); 

if ($obj->Deny == false && isset($_POST['urllist'])) $obj->main();
elseif(isset($_GET['infosv'])) $obj->notice();
############################################### Begin Secure ###############################################
elseif($obj->Deny == false) {
	if (!isset($_POST['urllist'])) {
		include ("hosts/hosts.php");
		ksort($host);
?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml"><head profile="http://gmpg.org/xfn/11">
		<head>
			<link rel="SHORTCUT ICON" href="images/vngicon.png" type="image/x-icon" />
			<title><?php printf($obj->lang['title'], $obj->lang['version']); ?></title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<meta name="keywords" content="<?php printf($obj->lang['version']); ?>, download, get, vinaget, file, generator, premium, link, sharing, real-debrid.com, multi-debrid.com, alldebrid.com, megaupload.com, hotfile.com, fileserve.com, filesonic.com, rapidshare.com, filefactory.com, depositfiles.com, netload.in, easy-share.com, uploading.com, duckload.com, uploaded.net, megashares.com, bitshare.com, gigasize.com, megavideo.com" />
			<link title="Rapidleech Style" href="images/style.css" rel="stylesheet" type="text/css" />
		</head>
		<body>
			<script type="text/javascript" language="javascript" src="images/jquery-1.8.3.min.js"></script>
			<script type="text/javascript" src="images/ZeroClipboard.js"></script>
			<script type="text/javascript" language="javascript">
				var title = '<?php echo $obj->title; ?>';
				var colorname = '<?php echo $obj->colorfn; ?>';
				var colorfile = '<?php echo $obj->colorfs; ?>';
				var more_acc = '<?php printf($obj->lang["moreacc"]); ?>';
				var less_acc = '<?php printf($obj->lang["lessacc"]); ?>';
				var d_error = '<?php printf($obj->lang["invalid"]); ?>';
				var d_succ1 = '<?php printf($obj->lang["dsuccess"]); ?>';
				var d_succ2 = '<?php printf($obj->lang["success"]); ?>';
				var get_loading = '<?php printf($obj->lang["getloading"]); ?>';
			</script> 
			<!--
			<center><img src="images/logo.png" alt="France Team" border="0" /></center><br>
			-->
			<div id="showlistlink" class="showlistlink" align="center">
				<div style="border:0px #ffffff solid; width:960px; padding:5px; margin-top:50px;">
					<div id="listlinks"><textarea style='width:950px;height:400px' id="textarea"></textarea></div>
					<table style='width:950px;'><tr>
					<td width="50%" vAlign="left" align="left">	
						<input type='button' value="BB code" onclick="return bbcode('list');" />
						<input type='button' id ='SelectAll' value="Select All"/>
						<input type='button' id="copytext" value="Copy To Clipboard"/>
					</td>
					<td id="report" width="50%" align="center"></td>
					</tr></table>
				</div>
				<div style="width:120px; padding:5px; margin:2px;border:1px #ffffff solid;">
					<a onclick="return makelist(document.getElementById('showresults').innerHTML);" href="javascript:void(0)" style='TEXT-DECORATION: none'><font color=#FF6600>Click to close</font></a>
				</div>
			</div>
			<table align="center"><tbody>
				<tr>
				<!-- ########################## Begin Plugins ########################## -->
				<td valign="top">
					<table width="100%"  border="0">
						<tr><td valign="top">
							<table border="0" cellpadding="0" cellspacing="0">
								<tr><td width="140" height="100%"><div class="cell-plugin"><?php printf($obj->lang['plugins']); ?></div></td></tr>
								<tr><td><div align="center" class="plugincolhd"><b><small><?php echo count($host);?></small></b> <?php printf($obj->lang['plugins']); ?></div></td></tr>
								<tr><td height="100%" style="padding:3px;">
									<div dir="rtl" align="left" style="overflow-y:scroll; height:150px; padding-left:20px;">
									<?php
										foreach ($host as $file => $site){
											$site = substr($site,0,-4);
											$site = str_replace("_",".",$site) ;
											echo "<span class='plugincollst'>" .$site."</span><br>";
										}
									?>
									</div><br>
									<div class="cell-plugin"><?php printf($obj->lang['premium']); ?></div>
									<table border="0">
										<tr><td height="100%" style="padding:3px;">
											<div dir="rtl" align="left" style="padding-left:5px;">
												<?php $obj->showplugin(); ?>
											</div>
										</td></tr>
									</table><br>
								</td></tr>
							</table>
						</td></tr>
					</table>
				</td>
				<!-- ########################## End Plugins ########################## -->
				<!-- ########################## Begin Main ########################### -->
				<td align="center" valign="top">
					<table border="0" cellpadding="0" cellspacing="1"><tbody>
						<tr>
							<td class="cell-nav"><a class="ServerFiles" href="./"><?php printf($obj->lang['main']); ?></a></td>
							<td class="cell-nav"><a class="ServerFiles" href="./index.php">Main 4 MORE</a></td>
							<td class="cell-nav"><a class="ServerFiles" href="./?id=admin">Admin Panel</a></td>
							<td class="cell-nav"><a class="ServerFiles" href="./?id=donate"><?php printf($obj->lang['donate']); ?></a></td>
							<td class="cell-nav"><a class="ServerFiles" href="./?id=listfile"><?php printf($obj->lang['listfile']); ?></a></td>
							<td class="cell-nav"><a class="ServerFiles" href="./?id=check"><?php printf($obj->lang['check']); ?></a></td>
							<?php if ($obj->Secure == true) 
							echo '<td class="cell-nav"><a class="ServerFiles" href="./login.php?go=logout">'.$obj->lang['logout'].'</a></td>'; ?>
						</tr>
				<table class='table1' border='0' cellPadding='0' cellSpacing='0'>					<tr><td class="td11">Get Link v3.0.0</td></tr>
					<tr><td>
						<table width="500" align="center">
							<tbody><tr><td align="center">
						<tr><td height="5px"></td></tr>
						<tr><td width="25px"></td></tr>
						<tr><td align="center">
<?php 
						#---------------------------- begin list file ----------------------------#
						if ((isset($_GET['id']) && $_GET['id']=='listfile') || isset($_POST['listfile']) || isset($_POST['option']) || isset($_POST['renn']) || isset($_POST['remove']))  {
							if($obj->listfile==true) $obj->fulllist();
							else echo "<br><br><font color=red size=2>".$obj->lang['notaccess']."</b></font>";
						}
						#---------------------------- end list file ------------------------------#

						#---------------------------- begin donate  ------------------------------#
						else if (isset($_GET['id']) && $_GET['id']=='donate') { 
?>
							<div align="center">
								<div id="wait"><?php printf($obj->lang['donations']); ?></div><br>
								<form action="javascript:donate(document.getElementById('donateform'));" name="donateform" id="donateform">
									<table>
										<tr>
											<td>
												<?php printf($obj->lang['acctype']); ?>
												<select name='type' id='type'>
													<option value="real-debrid">real-debrid.com</option>
													<option value="alldebrid">alldebrid.com</option>
													<option value="rapidshare">rapidshare.com</option>
													<option value="hotfile">hotfile.com</option>
													<option value="uploading">uploading.com</option>
													<option value="uploaded">uploaded.net</option>
													<option value="filefactory">filefactory.com</option>
													<option value="bayfiles">bayfiles.com</option>
													<option value="rapidgator">rapidgator.net</option>
													<option value="filepost">filepost.com</option>
													<option value="depositfiles">depositfiles.com</option>
													<option value="bitshare">bitshare.com</option>
													<option value="ryushare">ryushare.com</option>
												</select>
											</td>
											<td>
												&nbsp; &nbsp; &nbsp; <input type="text" name="accounts" id="accounts" value="" size="50" maxlength="400"><br>
											</td>
											<td>&nbsp; &nbsp; &nbsp; <input type=submit value="<?php printf($obj->lang['sbdonate']); ?>">
											</td>
										</tr>
									</table>
								</form>
								<div id="check"><font color=#FF6600>user:pass</font> or <font color=#FF6600>cookie</font></div>
							</div>
<?php					
						}
						#---------------------------- end donate  --------------------------------#

						#---------------------------- begin check  -------------------------------#
						else if (isset($_GET['id']) && $_GET['id']=='check'){
							if($obj->checkacc==true) include("checkaccount.php");
							else echo "<br><br><font color=red size=2>".$obj->lang['notaccess']."</b></font>";
						}
						#---------------------------- end check  ---------------------------------#
						
						#---------------------------- begin admin  -------------------------------#
						else if (isset($_GET['id']) && $_GET['id']=='admin'){
							echo "<br><br><font color=red>Seriously.. man / WOman.. FUCK OFF HERE <BR> cant actually believe u just fell for this <BR> <img src='images/he1.gif'> </font>";
							}
						#---------------------------- end admin  ---------------------------------#

						#---------------------------- begin get  ---------------------------------#
						else {
?>
							<form action="javascript:get(document.getElementById('linkform'));" name="linkform" id="linkform">
								<?php printf($obj->lang['welcome'], $obj->lang['homepage']); ?><br>
								<font face=Arial size=1><?php printf($obj->lang['maxline']); ?></font><br>
								<textarea id='links' style='width:550px;height:100px;' name='links'></textarea><br>
								<?php printf($obj->lang['example']); ?><br>
								<input type="submit" id ="submit" value="<?php printf($obj->lang['sbdown']); ?>"/>&nbsp;&nbsp;&nbsp;
								<input type="button" onclick="reseturl();return false;" value="Reset">&nbsp;&nbsp;&nbsp;
								<input type="checkbox" name="autoreset" id="autoreset" checked>&nbsp;Auto reset&nbsp;&nbsp;&nbsp;
								<input type="checkbox" name="autopcbox" id="autopcbox">&nbsp;Auto Post CBox
							</form><BR><BR>
							 <div id="formauto" style="display: none;">
					           Nick: <input type="text" id="nick" name="nick" size="25" /><br><br>
					           Pass: <input type="password" id="pass" name="pass" size="25" />
				            </div>
							<div id="dlhere" align="left" style="display: none;">
								<br><hr /><small style="color:#55bbff"><?php printf($obj->lang['dlhere']); ?></small>
								<div align="right"><a onclick="return bbcode('bbcode');" href="javascript:void(0)" style='TEXT-DECORATION: none'><font color=#FF6600>BB code</font></a>&nbsp;&nbsp;&nbsp;
								<a onclick="return makelist(document.getElementById('showresults').innerHTML);" href="javascript:void(0)" style='TEXT-DECORATION: none'><font color=#FF6600>Make List</font></a></div>
							</div>
							<div id="bbcode" align="center" style="display: none;"></div><br>
							<div id="showresults" align="center"></div>
<?php						
						}
						#---------------------------- end get  -----------------------------------#
?>
						</td></tr>
					</tbody></table>
				</td></tr>
				<!-- ########################## End Main ########################### -->
			</tbody></table>

			<table width="60%" align="center" cellpadding="0" cellspacing="0">
				<tr><td>
					<div align="center" style="color:#ccc">
						<!-- Start Server Info -->
							<hr />
						<div id="server_stats">
							<?php echo $obj->notice();?>
						</div>
						<!-- End Server Info -->
						<hr />
						<BR>
						<BR>
						<BR>
						<BR>
						
						<script type="text/javascript" language="javascript" src="ajax.js"></script> 
						<!-- Copyright please don't remove-->
						<!-- ##########################	<span style="FONT-FAMILY: Arial; FONT-SIZE: 10px; color:#FF8700"><strong>Code LeechViet. Developed by ..:: [H] ::..<br>
							<a href="http://<?php printf($obj->lang['homepage']); ?>">Powered by <?php printf($obj->lang['version']); ?></a></strong></span><br>
							<span style="FONT-FAMILY: Arial; FONT-SIZE: 11px"><?php printf($obj->lang['copyright'], date('Y'), $obj->lang['homepage']); ?>. All rights reserved.</span><br>
						<!-- Copyright please don't remove-->
					</div>
				</td></tr>
			</table>
		</body>
	</html>

<?php
	} #(!$_POST['urllist'])
} 
############################################### End Secure ###############################################
else {
?>
	<html>
	<head>
	<meta http-equiv="Content-Language" content="en-us">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<META NAME="ROBOTS" CONTENT="NOINDEX,FOLLOW" />
	<META NAME="GOOGLEBOT" CONTENT="NOINDEX,FOLLOW" />
	<META NAME="SLURP" CONTENT="NOINDEX,FOLLOW" />
	<link rel="shortcut icon" type="image/x-icon" href="images/login.ico"/>
	<link title="Rapidleech Style" href="images/login.css" rel="stylesheet" type="text/css" />
	<title>Login - <?php printf($obj->lang['title'],$obj->lang['version']); ?></title>
	</head>

	<body>
		<!-- main -->
		<div align="center">
			<div><a><img src="images/logo.png" alt="vinaget.us" align="center"></a></div>
			<div align="center" id="loginform">
				<form method="POST" action="login.php">
				<font face="Arial" color='#FFFFFF'><b><?php printf($obj->lang['login']); ?></b></font>
				<table border="0" width="500" height="32" align="center" >
					<tr>
						<td height="28" width="108">
							<font face="Bookman Old Style" color="#CCCCCC"><b><?php printf($obj->lang['password']); ?></b></font>
						</td>
						<td height="28" width="316"><input type="password" name="secure" size="44"></td>
						<td height="28" width="56"><input type="submit" value="Submit" name="submit" class="submit"></td>
					</tr>
				</table>
				</form>
			</div>
		<!-- /main -->

		<!-- Copyright please don't remove-->
			<STRONG><SPAN class='powered'>Code LeechViet. Developed by ..:: [H] ::..<br/><a href='http://vinaget.us/'>Powered by <?php printf($obj->lang['version']); ?></a></SPAN><br/>
			<SPAN class='copyright'>Copyright 2009-<?php echo date('Y');?> by <a href='http://vinaget.us/'>http://vinaget.us</a>. All rights reserved. </SPAN><br />
		<!-- Copyright please don't remove-->	
		</div>
	</body>
	</html>
<?php
}
ob_end_flush();
?>