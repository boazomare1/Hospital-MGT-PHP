
<?php
session_start();
set_time_limit(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

if (isset($_REQUEST["upload"])) { $upload = $_REQUEST["upload"]; } else { $upload = ""; }
if (isset($_REQUEST["errmsg"])) { $errmsg = $_REQUEST["errmsg"]; } else { $errmsg = ""; }
if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
//$upload = $_REQUEST['upload'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. File Uploaded Successfully.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. File Upload Failed.";
		}
}
if ($st == 'failed')
{
		$errmsg = "Failed. Supplier Already Exists.";
}

if ($upload == 'success')
{

	$importstarted = date("d-M-Y H:i:s");

	$skipcountservice = 0;
	$skipcounttax = 0;
	$skipcountcategory = 0;
	$skipcountunit = 0;
	$successcount = 0;
	$forloopcount = 0;
	$foldername = "tab_file_dump//";
	$filename = $username."_tabdump.txt";
	$filepath = $foldername.$filename;
	$fd = fopen ($filepath, "r");
	$fullcontents = fread ($fd,filesize ($filepath));
	fclose ($fd); 
	
	$linebreak = "\n"; //for line breaks
	$linecounter = 0;
	$splitcontents = explode($linebreak, $fullcontents);
	//print_r($splitcontents);
	$totallinecount = count($splitcontents);
	//echo "<br>";
	
	foreach ( $splitcontents as $linecontent )
	{
		$forloopcount = $forloopcount + 1;
		//echo "<br>";
		if ($forloopcount > 1 && $forloopcount < $totallinecount) // to skip header row. to skip last empty row to avoid empty array error.
		{
			//echo "<br><br>";
			$linecounter = $linecounter + 1;
			$linecontent; //contains the text of each line.
			
			$delimiter = "\t"; // for tab delimit breaks
			$delimitercount = 0;
			$splitdelimiter = explode($delimiter, $linecontent);
			$accountname = $splitdelimiter[0];
			$accountname = strtoupper($accountname);
			$id = $splitdelimiter[1];
			$paymenttype = $splitdelimiter[2];
			$subtype = $splitdelimiter[3];
			$accountsmain = $splitdelimiter[4];
			$accountssub = $splitdelimiter[5];
			$openingbalancecredit = $splitdelimiter[6];
			$openingbalancedebit= $splitdelimiter[7];
			$recordstatus = $splitdelimiter[8];
			$recordstatus = strtoupper($recordstatus);
			$expirydate = $splitdelimiter[9];
			
			preg_match ('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $accountsmain);
			
			if ($accountsmain != '')
			{
			$query2 = "insert into master_accountname(accountname,id,paymenttype,subtype,accountsmain,accountssub,openingbalancecredit,openingbalancedebit,recordstatus,expirydate,ipaddress,recorddate,username) values ('$accountsmain','$id', '$paymenttype', '$subtype', '$accountsmain', '$accountssub', '$openingbalancecredit', '$openingbalancedebit', '$recordstatus', '$expirydate', '$ipaddress','$updatedatetime','$username')";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $successcount = $successcount + 1;
		    }
			else
			{
			$skipcountunit = $skipcountunit + 1;
			}
		}
	}
	header("location:chartaccountnamedataimport1.php?st=success");
}
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">


</script>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>
                  <table width="83%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Item / Services Data Import From TAB Delimited File </strong></td>
                      </tr>
                      <tr>
                        <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				 
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
