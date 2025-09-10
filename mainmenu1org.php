<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];


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
<script language="javascript">

function process1login1()
{
	if (document.form1.username.value == "")
	{
		alert ("Pleae Enter Your Login.");
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

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style><!--<style type="text/css">body {	margin-left: 0px;	margin-top: 0px;	background-color: #add8e6;}.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma}.submenubutton{height: 40px; width: 180px; color:#000000; font: Tahoma; background:#add8e6; border-radius: 20px;}.submenubutton:hover{border: 1px solid #black;color:#000000;}#menu{	margin: 0;	padding: 0;		z-index: 30}#menu li{	margin: 0;	padding: 0;	list-style: none;	float:left;	font: bold 11px arial;	border:0;}#menu li a{	display: inline;	margin: 0px 0px 0 0;	padding: 15px 2px;	width: 150px;	background: #add8e6;	color: #FFF;		text-align: center;	text-decoration: none}#menu li a:hover{	background: #add8e6}#menu div{	position: absolute;	visibility: hidden;	margin: 0;	padding: 0;	background: #add8e6;	}	#menu div a	{	position: relative;		display: inline;		margin: 0;		padding: 5px 10px;		width: auto;		white-space: nowrap;		text-align: left;		text-decoration: none;		background: #add8e6;		color: #2875DE;		font: 11px arial}	#menu div a:hover	{	background: #add8e6;		color: #FFF}</style>-->
</head>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99" colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
      </table>	  	<!--  	  	  <tr>    <td width="1%">&nbsp;</td>    <td width="2%" valign="top">&nbsp;      </td>    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">      <tr>        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">            <tr>              <td>&nbsp;</td>            </tr>            <tr>              <td>			  <div class="test">                  <ul id="menu" >				  <?php if (isset($_REQUEST["mainmenuid"])) { $mainmenid = $_REQUEST["mainmenuid"]; } else { $mainmenid = ""; }		$sessionusername = $_SESSION["username"];				  		$query10 = "select * from master_employeerights where username = '$sessionusername' and is_fav = '1'";		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));		$rowcount10 = mysqli_num_rows($exec10);				while ($res10sm = mysqli_fetch_array($exec10))		{			$submenuid = $res10sm["submenuid"];							$query2sm = "select * from master_menusub where submenuid = '$submenuid' and status <> 'deleted' order by submenutext";		$exec2sm = mysqli_query($GLOBALS["___mysqli_ston"], $query2sm) or die ("Error in Query2sm".mysqli_error($GLOBALS["___mysqli_ston"]));		$res2sm = mysqli_fetch_array($exec2sm);		$submenuorder = $res2sm["submenuorder"];		$submenutext = $res2sm["submenutext"];		$submenulink = $res2sm["submenulink"];				?>                            <li ><a href="<?php echo $submenulink; ?>">                              <input name="button" type="button" class="submenubutton" id="submenubutton" value="<?php echo $submenutext; ?>">                            </a></li>		<?php } 				  ?>				  				  				  </ul>			  </div>			  </td>			  </tr>			  			  </td>			  </tr>			  </td>			  </tr>
	-->