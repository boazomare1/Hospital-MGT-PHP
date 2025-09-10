<?php
session_start();
session_destroy();
session_start();
session_regenerate_id();
$sessionid = session_id();
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$todaydate = date('Y-m-d');
$licenseduser = '175';
//Variable Declaration
$errmsg = '';
$totalclosingcash = '';

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = isset($_POST["frmflag1"]);
if ($frmflag1 == 'frmflag1')
{
	$username = $_POST["username"];
	$password = $_POST["password"];
	$password1 = base64_encode($password);
	
	//$query1 = "select * from master_usercreation where username = '$username' and password = '$password'";
	$query1 = "select * from master_employee where username = '$username' and password = '$password1' and status = 'ACTIVE'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount1 = mysqli_num_rows($exec1);
	if ($rowcount1 == 0)
	{
		header ("location:access.php?st=1");
	}
	else
	{
	
	
		$res1 = mysqli_fetch_array($exec1);
		$validitydate = $res1['validitydate'];
		$validitydatestr = strtotime($validitydate);
		$todaydatestr = strtotime($todaydate);
		
		if($validitydatestr >= $todaydatestr)
		{
		$_SESSION["username"] = $username;
		$_SESSION["logintime"] = $updatedatetime;	 
		$_SESSION["timestamp"] = time();
		
		$query2 = "insert into details_login (username, logintime, openingcash, 
		lastupdate, lastupdateipaddress, lastupdateusername, sessionid) 
		value ('$username', '$updatedatetime', '$totalclosingcash', 
		'$updatedatetime', '$ipaddress', '$username', '$sessionid')";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query4 = "delete from login_restriction where username = '$username'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query3 = "insert into login_restriction (username, logintime, 
		lastupdate, lastupdateipaddress, lastupdateusername, sessionid) 
		value ('$username', '$updatedatetime', 
		'$updatedatetime', '$ipaddress', '$username', '$sessionid')";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query1 = "select count(auto_number) as countanum from login_restriction";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$logincount = $res1["countanum"];
		
		$query2 = "select * from master_edition where status = 'ACTIVE'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$res2usercount = $res2["users"];
		
		if ($logincount > $res2usercount)
		{
			//echo 'inside if';
			header ("location:login1restricted1.php");
			exit;
		}
		
		$query53 = "select * from master_employee where username = '$username' and status = 'Active'";
		$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die("Error in Query53".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res53 = mysqli_fetch_array($exec53);
		$shiftaccess = $res53["shift"];
		if($shiftaccess =="YES")
		{
		$query52 = "select * from shift_tracking where username = '$username' order by auto_number desc";
		$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res52 = mysqli_fetch_array($exec52);
	
		$shiftouttime = $res52["shiftouttime"];
		
		if($shiftouttime != '0000-00-00 00:00:00')
		{
		$query51 = "insert into shift_tracking(username,shiftstarttime,lastupdate,lastupdateipaddress,lastupdateusername)values('$username','$updatedatetime','$updatedatetime','$ipaddress','$username')";
		$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		
		
		//header ("location:mainmenu1.php?st=1");
		header ("location:setactivecompany1.php");
		}
		else
		{
		header ("location:access.php?st=2");
		}
	}

}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = isset($_REQUEST["st"]);
if ($st == 1)
{
	$errmsg = "Login Failed. Please Try Again With Proper User Id and Password.";
}
if ($st == 2)
{
	$errmsg = "Login Failed. Validity date is Expired.";
}
$queryactiveusers = "select * from details_login where logouttime = '0000-00-00 00:00:00' order by auto_number desc";
$execactiveusers = mysqli_query($GLOBALS["___mysqli_ston"], $queryactiveusers) or die ("Error in queryactiveusers".mysqli_error($GLOBALS["___mysqli_ston"]));
$numsactiveusers = mysqli_num_rows($execactiveusers);
$remainusers = $licenseduser - $numsactiveusers;
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-image:url(loginlogo/1.jpg); background-repeat:no-repeat; background-position:center; 
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; 
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">

// to check browser compatibility.

var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var browserName  = navigator.appName;
var fullVersion  = ''+parseFloat(navigator.appVersion); 
var majorVersion = parseInt(navigator.appVersion,10);
var nameOffset,verOffset,ix;

// In MSIE, the true version is after "MSIE" in userAgent
if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
 browserName = "Microsoft Internet Explorer";
 fullVersion = nAgt.substring(verOffset+5);
}
// In Opera, the true version is after "Opera" 
else if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
 browserName = "Opera";
 fullVersion = nAgt.substring(verOffset+6);
}
// In Chrome, the true version is after "Chrome" 
else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
 browserName = "Chrome";
 fullVersion = nAgt.substring(verOffset+7);
}
// In Safari, the true version is after "Safari" 
else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
 browserName = "Safari";
 fullVersion = nAgt.substring(verOffset+7);
}
// In Firefox, the true version is after "Firefox" 
else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
 browserName = "Firefox";
 fullVersion = nAgt.substring(verOffset+8);
}
// In most other browsers, "name/version" is at the end of userAgent 
else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < (verOffset=nAgt.lastIndexOf('/')) ) 
{
 browserName = nAgt.substring(nameOffset,verOffset);
 fullVersion = nAgt.substring(verOffset+1);
 if (browserName.toLowerCase()==browserName.toUpperCase()) {
  browserName = navigator.appName;
 }
}
// trim the fullVersion string at semicolon/space if present
if ((ix=fullVersion.indexOf(";"))!=-1) fullVersion=fullVersion.substring(0,ix);
if ((ix=fullVersion.indexOf(" "))!=-1) fullVersion=fullVersion.substring(0,ix);

majorVersion = parseInt(''+fullVersion,10);
if (isNaN(majorVersion)) {
 fullVersion  = ''+parseFloat(navigator.appVersion); 
 majorVersion = parseInt(navigator.appVersion,10);
}

//document.write('Browser name  = '+browserName+'<br>');
//document.write('Full version  = '+fullVersion+'<br>');
//document.write('Major version = '+majorVersion+'<br>');
//document.write('navigator.appName = '+navigator.appName+'<br>');
//document.write('navigator.userAgent = '+navigator.userAgent+'<br>');

if (browserName == "Microsoft Internet Explorer")
{
	//alert ("You Are Using MSIE.");
	//alert (fullVersion);
	if (fullVersion >= 6)
	{
		//alert ("You Are Using Version Greater Than / Equal To 6.");
		//window.location = "access.php";
	}
	else
	{
		//alert ("Version Is Less Than 6.");
		//alert ("This is not MSIE.");
		//window.location = "browserfailed.php?st=versionfailed";
	}
}
else
{
	//alert ("Version Is Less Than 6.");
	//alert ("This is not MSIE.");
	//window.location = "browserfailed.php?st=browserfailed";
}


</script>
<script language="javascript">

function process1login1()
{
	if (document.form1.username.value == "")
	{
		alert ("Pleae Enter Your User Id.");
		document.form1.username.focus();
		return false;
	}
	else if (document.form1.password.value == "")
	{	
		alert ("Pleae Enter Your Password.");
		document.form1.password.focus();
		return false;
	}
	if (document.form1.remainusers.value == "0")
	{
		alert (" LICENSE USERS ARE COMPLETE.");
		return false;
	}
}

function setFocus()
{
	document.getElementById("username").focus();
}

</script>
</head>

<body onLoad="return setFocus()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php /*?><?php include ("includes/alertmessages1.php"); ?><?php */?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/logintitle.php"); ?></td>
  </tr>
 
  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
		  	  	<form id="form1" name="form1" method="post" action="access.php" onSubmit="return process1login1()">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
        <tr>
          <td><table width="445" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; ">
              <tbody>
			                  
                <tr>
                  <td colspan="2" align="left" valign="top"  
				  bgcolor="<?php if ($errmsg != '') { echo '#FF9900'; } ?>" class="bodytext3">
				  <div align="right">&nbsp;
				  <?php
					  echo $errmsg;
				  ?>
                  </div></td>
                </tr>
                <tr>
                  <td width="50%" align="left" valign="middle"  class="bodytext3"><strong>User</strong> </td>
                  <td width="63%" align="left" valign="top"  ><input name="username" type="text" id="username" style="border: 1px solid #001E6A" size="20" />
				  <input name="licenseduser" type="hidden" id="licenseduser" value="<?php echo $licenseduser; ?>" />
				  <input name="remainusers" type="hidden" id="remainusers" value="<?php echo $remainusers; ?>" />				  
				  </td>
                
                  <td width="37%" align="left" valign="middle"  class="bodytext3"><strong>Password</strong></td>
                  <td width="63%" align="left" valign="top"  ><input name="password" type="password" id="password" style="border: 1px solid #001E6A" size="20" /></td>
                 <td align="middle" valign="top"  ><div align="right">
                   <input type="submit" name="Submit" value="Login" />
                   <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" />
                      <!--<input type="reset" name="Submit2" value="Reset" style="border: 1px solid #001E6A" />-->
                  </div></td>
                </tr>
              </tbody>
            </table>
            </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
	</form>
    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

