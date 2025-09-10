<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');

if (isset($_SESSION["username"]))
{
	$logintime = $_SESSION["shiftstart"];
	$username = $_SESSION["username"];
			 $query31 = "select* from shift_tracking where username = '$username'  order by auto_number desc";
			$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exe31);
			 $res31anum = $res31["auto_number"];
			 $shiftouttime = $res31["shiftouttime"];
	if($shiftouttime == '0000-00-00 00:00:00')
	{		
	 $query1 = "update shift_tracking set shiftouttime = '$updatedatetime' where username = '$username' and auto_number = '$res31anum' ";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	header ("location:shiftwisereport2.php?anum=254");
	exit;
}

//session_destroy();
//session_start();
//header ("location:index.php");


?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
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
		//window.location = "browserfailed.php?st=versionfailed";
	}
}
else
{
	//alert ("This is not MSIE.");
	//window.location = "browserfailed.php?st=browserfailed";
}


</script>
<script language="javascript">

function funccheck()
{
var varUserChoice; 
	varUserChoice = confirm('DO YOU LIKE TO END YOUR SHIFT? PLEASE CLICK YES TO SHIFT OUT OR CLICK CANCEL'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		
		return false;
	}
	}
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
	
}

function setFocus()
{
	document.getElementById("username").focus();
}

</script>
</head>

<body onLoad="return funccheck()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#003399"><?php //include ("includes/menu1.php"); ?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
		  	  	<form id="form1" name="form1" method="post" action="access.php" onKeyDown="return disableEnterKey()" onSubmit="return process1login1()">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
        <tr>
          <td><!--<table width="400" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
              <tbody>
			  <tr>
			  <td colspan="2" bgcolor="#FFFFFF"><div class="bodytext3"><b>User Logout </b></div> </td>
			  </tr>
                <tr>
                  <td width="21%" align="middle" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                  <td width="79%" align="middle" valign="top"  bgcolor="#FFFFFF">
				  <div align="left"><span class="bodytext3"><b>Logout Completed. </b></span></div></td>
                </tr>
                <tr>
                  <td align="middle" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                  <td align="middle" valign="top"  bgcolor="#FFFFFF">
				  <div align="left"><span class="bodytext3"><b>To Login Again <a href="index.php">Click Here.</a> </b></span></div></td>
                </tr>
              </tbody>
            </table>-->
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

