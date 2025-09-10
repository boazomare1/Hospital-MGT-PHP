<?php
session_start();
error_reporting(0);
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetitme = date ("d-m-Y H:i:s");
$dateonly=date("Y-m-d");
$suppdateonly = date("Y-m-d");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$pagename = 'PURCHASE BILL ENTRY';

$titlestr = 'PURCHASE BILL';
$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
$reslocationname = $res["locationname"];
$res12locationanum = $res["auto_number"];

$query3 = "select * from master_location where locationname='$reslocationname'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$reslocationcode = $res3['locationcode'];

include ("login1purchasedataredirect1.php");

//to redirect if there is no entry in masters category or item or customer or settings
$query91 = "select count(auto_number) as masterscount from settings_purchase where companyanum = '$companyanum'";
$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
$res91 = mysqli_fetch_array($exec91);
$res91count = $res91["masterscount"];
if ($res91count == 0)
{
	header ("location:settingspurchase1.php?svccount=firstentry");
	exit;
}


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77['allowed'];


$query88 = "select count(auto_number) as cntanum from master_purchase where lastupdate like '$thismonth%'";
$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
$res88 = mysqli_fetch_array($exec88);
$res88cntanum = $res88['cntanum'];


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
?>
<?php include ("includes/pagetitle1.php"); ?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.style8 {COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-size: 11px;}
-->
</style>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<script src="js/datetimepicker_css.js"></script>

<body>
<form name="budget" id="budget" method="post" action="budgetentrylist.php">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<tr>
    <td colspan="9" bgcolor="#ecf0f5">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="1214" border="0" cellspacing="0" cellpadding="0">
      <tr>
       <td width="6%">&nbsp;</td><td width="94%"><table width="70%" border="0" align="left" cellpadding="4" cellspacing="4" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <tr bgcolor="#011E6A">
		  <td bgcolor="#ecf0f5" class="bodytext3" colspan="5" align="left"><strong>Budget Entry - Initiated</strong></td>
		  <td bgcolor="#ecf0f5" class="bodytext3" colspan="5" align="right"><strong><?php echo $reslocationname; ?></strong></td>
		  </tr>
		  <tr bgcolor="#FFFFFF">
		  <td width="5%" align="left" class="bodytext3"><strong>S.No</strong> </td>
		  <td width="9%" align="left" class="bodytext3"><strong>Doc No</strong></td>
		  <td width="30%" align="left" class="bodytext3"><strong>Budget Name</strong></td>
		  <td width="14%" align="left" class="bodytext3"><strong>Budget Year</strong></td>
		  <td width="14%" align="left" class="bodytext3"><strong>Budget Type</strong></td>
		  <td width="14%" align="left" class="bodytext3"><strong>Initiated Date</strong></td>
		  <td width="14%" align="left" class="bodytext3"><strong>Initiated By</strong></td>
		  <td width="14%" align="left" class="bodytext3"><strong>View</strong></td>
		  </tr>
		  <?php
		  $sno = 0;
		  $colorloopcount = 0;
		  $query6 = "select * from budgetentry where locationcode = '$reslocationcode' group by budgetno order by budgetyear";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res6 = mysqli_fetch_array($exec6))
		  {
		  $budgetno = $res6['budgetno'];
		  $budgetdate = $res6['budgetdate'];
		  $budgetname = $res6['budgetname'];
		  $budgetyear = $res6['budgetyear'];
		  $budgetby = $res6['username'];
		  $sno = $sno + 1;
		  
		  $query7 = "select * from budgetentry where budgetno = '$budgetno' and locationcode = '$reslocationcode' group by budgettype order by budgetyear";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $row7 = mysqli_num_rows($exec7);
		  $res7 = mysqli_fetch_array($exec7);
		  $budgettype = $res7['budgettype'];
		  if($row7 == '2')
		  {
		  	$budgettype = 'All';
		  }
		  else
		  {
		  	$budgettype = $budgettype;
		  }
		  
		  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
		  ?>
		  <tr <?php echo $colorcode; ?>>
		  <td align="left" class="bodytext3"><?php echo $sno; ?></td>
		  <td align="left" class="bodytext3"><?php echo $budgetno; ?></td>
		  <td align="left" class="bodytext3"><?php echo $budgetname; ?></td>
		  <td align="left" class="bodytext3"><?php echo $budgetyear; ?></td>
		  <td align="left" class="bodytext3"><?php echo $budgettype; ?></td>
		  <td align="left" class="bodytext3"><?php echo $budgetdate; ?></td>
		  <td align="left" class="bodytext3"><?php echo strtoupper($budgetby); ?></td>
		  <td align="left" class="bodytext3"><a href="budgetentryview.php?st=view&&docno=<?php echo $budgetno; ?>"><strong><?php echo 'View'; ?></strong></a></td>
		  </tr>
		  <?php
		  }
		  ?>
		   <tr>
		  <td bgcolor="#ecf0f5" class="bodytext3" colspan="10"><strong>&nbsp;</strong></td>
		  </tr>
          </tbody>
        </table></td>
		</tr>
		</table>
		</form>

<?php include ("includes/footer1.php"); ?>
</body>
</html>