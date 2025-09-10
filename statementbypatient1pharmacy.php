<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$searchcustomername = '';
$customername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$customername = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$custname = '';
$colorloopcount = '';
$sno = '';
$customercode = '';
$totalsalesamount = '0.00';
$totalsalesreturnamount = '0.00';
$netcollectionamount = '0.00';
$netpaymentamount = '0.00';
$res2total = '0.00';

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
include("autocompletebuild_customer1.php");
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];

if ($getcanum != '')
{
	$query4 = "select * from master_customer where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbcustomername = $res4['customername'];
	$customername = $res4['customername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchcustomername = $_POST['searchcustomername'];
	if ($searchcustomername != '')
	{
		$arraycustomer = explode("#", $searchcustomername);
		$arraycustomername = $arraycustomer[0];
		$arraycustomername = trim($arraycustomername);
		$arraycustomercode = $arraycustomer[1];

		$cbcustomername = $arraycustomername;
		$customername = $arraycustomername;
		$customercode = $arraycustomercode;
	}
	else
	{
		$cbcustomername = $_REQUEST['cbcustomername'];
		$customername = $_REQUEST['cbcustomername'];
		$customercode = $_REQUEST['customercode'];
	}
	
	if ($_REQUEST['ADate1'] != '' && $_REQUEST['ADate2'] != '')
	{
		$transactiondatefrom = $_REQUEST['ADate1'];
		$transactiondateto = $_REQUEST['ADate2'];
	}
	else
	{
		$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
		$transactiondateto = date('Y-m-d');
	}

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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1901" border="0" cellspacing="0" cellpadding="2">
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
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1134">
		
		
              <form name="cbform1" method="post" action="statementbypatient1pharmacy.php">
		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Statement - By Patient </strong></td>
              <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
              <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchcustomername" type="text" id="searchcustomername" style="border: 1px solid #001E6A;" value="<?php echo $searchcustomername; ?>" size="50" autocomplete="off">
              </span><span class="bodytext3">
                <input type="hidden" name="searchcustomercode" onBlur="return customercodesearch1()" onKeyDown="return customercodesearch2()" id="searchcustomercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchcustomercode; ?>" size="20" />
              </span></td>
              </tr>
            <tr>
              <td width="17%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Select Patient </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input value="<?php echo $cbcustomername; ?>" name="cbcustomername" type="text" id="cbcustomername" readonly="readonly" onKeyDown="return disableEnterKey()" size="50" style="border: 1px solid #001E6A"></td>
              </tr>
           <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
              <td align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
			  </span></td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="941" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="6" bgcolor="#ecf0f5" class="bodytext31">
                <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$cbcustomername = $_REQUEST['cbcustomername'];
					$customername = $_REQUEST['cbcustomername'];
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					
					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				<?php
				//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_salescustomerreport1pharmacy.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/StatementByPatientPharmacy.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
                <script language="javascript">
				function printbillreport1()
				{
					window.open("print_salescustomerreport1pharmacy.php?<?php echo $urlpath; ?>","Window1",'width=1000,height=600,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/StatementByPatientPharmacy.xls"
				}
				</script>
                <input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />
&nbsp;				<input value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />
</td>
              
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Particulars </strong></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Doc No </strong></td>
              <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>By Sales </strong></div></td>
              
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>By Sales Return </strong></div></td>
              
              </tr>
			<?php
			
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
            $query1 = "select * from master_customer where customercode = '$customercode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1billtype = $res1['billtype'];
			$patientname = $res1['customername'];
			
			if($res1billtype =='PAY NOW')
			{
			$query2 = "select * from master_transactionpaynow where patientname like '%$patientname%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['visitcode'];
			$res2transactiondate = $res2['transactiondate'];
			$res2patientname = $res2['patientname'];
			$res2particulars = $res2['particulars'];
            $res2cashamount = $res2['cashamount'];
			$res2transactionamount = $res2['transactionamount'];
			$totalsalesamount = $totalsalesamount + $res2cashamount;
			$totalsalesreturnamount = $totalsalesreturnamount +	$res2transactionamount;
			
			$query3 = "select * from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3docnumber = $res3['docnumber'];
			
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo substr($res2transactiondate, 0, 10); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2particulars; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res3docnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2cashamount; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactionamount; ?></div></td>
              </tr>
			<?php
			}
			}
			?>
			
			<?php
			
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
            $query1 = "select * from master_customer where customercode = '$customercode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1billtype = $res1['billtype'];
			$patientname = $res1['customername'];
			
			if($res1billtype =='PAY LATER')
			{
			$query2 = "select * from master_transactionpaylater where patientname like '%$patientname%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['visitcode'];
			$res2transactiondate = $res2['transactiondate'];
			$res2patientname = $res2['patientname'];
			$res2particulars = $res2['particulars'];
            $res2cashamount = $res2['cashamount'];
			$res2transactionamount = $res2['transactionamount'];
			$totalsalesamount = $totalsalesamount + $res2transactionamount;
			$totalsalesreturnamount = $totalsalesreturnamount +	$res2cashamount;
			 
			$query3 = "select * from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3docnumber = $res3['docnumber'];
			
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo substr($res2transactiondate, 0, 10); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2particulars; ?></div>              </td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res3docnumber; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactionamount; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2cashamount;?></div>              </td>
              
              </tr>
			<?php
			}
			}
			?>
			
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>Total : </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="left"><strong><?php echo number_format($totalsalesamount, 2, '.', ''); ?></strong></div></td>
              
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="left"><strong><?php echo number_format($totalsalesreturnamount, 2, '.', ''); ?></strong></div></td>
              
              </tr>
           
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

