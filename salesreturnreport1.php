<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

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
$billnumber1 = '';

$totalsumtotalamount1  = '';
$totalsumcashamount1  = '';
$totalsumchequeamount1  = '';
$totalsumonlineamount1  = '';
$totalsumcardamount1 = '';
$totalsumcreditamount1 = '';
$totalsumbalancebillamount1 = '';
$totalsumsubtotal1 = '';
$totalsumtotaltax1 = '';
$totalpackaging1 = '';
$totaldelivery1 = '';
$caseamount1 = '0.00';
$chequeamount1 = '0.00';
$onlineamount1 = '0.00';
$cardamount1 = '0.00';
$creditamount1 = '0.00';
$balanceamount1 = '0.00';

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$cbcustomername = $_REQUEST['cbcustomername'];
	$customername = $_REQUEST['cbcustomername'];
	
	if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
	//$cbbillnumber = $_REQUEST['cbbillnumber'];
	$billnumber1 = $cbbillnumber;
	if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
	//$cbbillstatus = $_REQUEST['cbbillstatus'];
	
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
	
	$paymenttype = $_REQUEST['paymenttype'];
	$billstatus = $_REQUEST['billstatus'];

}
/*			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
*/


?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function loadprintpage1(banum)
{
	var varbanum = banum;
	//alert (varqanum);
	window.open("print_bill1_salesreturn1.php?copy1=SALES RETURN&&billautonumber="+varbanum+"","Window"+varbanum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function loadprintpage2(banum)
{
	var varbanum = banum;
	var varbanum1 = "O";
	var varbanum2 = "D";
	
	//alert (varqanum);
			
	window.open("print_bill1_salesreturn1.php.php?copy1=INVOICE && title1=ORIGINAL && banum="+varbanum+"","Window1"+varbanum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("print_bill1_salesreturn1.php.php?banum="+varbanum+"","Window2"Original"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	
	window.open("print_bill1_salesreturn1.php.php?copy1=INVOICE && title1=DUPLICATE && banum="+varbanum+"","Window2"+varbanum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_bill1_salesreturn1.php.php?copy1=INVOICE && title1=TRIPLICATE && banum="+varbanum+"","Window3"+varbanum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function loadpdfpage1(banum)
{
	//alert ("Please Wait Few Seconds. The PDF File is being created. Do Not Close Popup Window.");
	var varbanum = banum;
	//alert (varqanum);
	window.open("mailbill1.php?banum="+varbanum+"","Window1","menubar=no,width=450,height=450,toolbar=no,scrollbars=yes,status=yes,left=100,top=100");
	//window.open("print_bill1_salesreturn1.php.php?banum="+varbanum+"","Window"+varbanum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function funcRedirectWindow1()
{
	window.location = "salesreturnreport1.php";
}

function funcDeleteRecord1(varBillNumberNumber)
{
	var varBillNumberNumber = varBillNumberNumber;
	var fRet;
	fRet = confirm('Are You Sure Want To Delete This Sales Return Bill Number '+varBillNumberNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		var fRet2;
		fRet2 = confirm('All Payment Details Saved Will Also Be Deleted. Are Sure Your Want To Delete This Sales Return Bill Number '+varBillNumberNumber+'?');
		//alert(fRet);
		if (fRet2 == true)
		{
			alert ("Success. Sales Return Entry Delete Completed.");
			//return false;
		}
		if (fRet2 == false)
		{
			alert ("Failed. Sales Return Entry Delete Not Completed.");
			return false;
		}
	}
	if (fRet == false)
	{
		alert ("Failed. Sales Return Entry Delete Not Completed.");
		return false;
	}
	//return false;
}


</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1450" border="0" cellspacing="0" cellpadding="2">
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
    <td colspan="9"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="99%" valign="top"><table width="1425" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1019">
		
              <form name="cbform1" method="get" action="salesreturnreport1.php">
		<table width="929" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong>Sales Return Report     - Select Customer </strong></td>
              <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
              </tr>
            <tr>
                <td width="10%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Customer  * </td>
                <td width="19%" align="left" valign="top"  bgcolor="#FFFFFF">
				<input value="<?php echo $cbcustomername; ?>" name="cbcustomername" type="text" id="cbcustomername" size="20" style="border: 1px solid #001E6A"></td>
                <td width="9%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bill Number</td>
                <td width="18%" align="left" valign="top"  bgcolor="#FFFFFF"><input value="<?php echo $cbbillnumber; ?>" name="cbbillnumber" type="text" id="cbbillnumber" size="10" style="border: 1px solid #001E6A"></td>
                <td width="8%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date From </td>
                <td width="15%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                  <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>
				</span>				</td>
                <td width="7%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                <td width="14%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                  <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
				</span></td>
                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> </td>
              <td align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type ="hidden" name="paymenttype" id="paymenttype">
				<?php
				if ($paymenttype != '')
				{
				?>
				<option value="<?php echo $paymenttype; ?>" selected="selected"><?php echo $paymenttype; ?></option>
				<?php
				}
				else
				{
				?>
                <option value="">ALL</option>
				<?php
				}
				?>
                <option value="CASH">CASH</option>
                <option value="CHEQUE">CHEQUE</option>
                <option value="CREDIT">CREDIT</option>
                <option value="CARD">CREDIT CARD</option>
                <option value="ONLINE">ONLINE</option>
                <option value="SPLIT">SPLIT</option>
              </select></td>
              <td align="left" valign="middle"  bgcolor="#FFFFFF"><span class="bodytext3"> </span></td>
              <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="billstatus" id="billstatus">
                <?php
				if ($billstatus == 'CONFIRMED')
				{
				?>
                <option value="CONFIRMED" selected="selected">SHOW CONFIRMED</option>
                <?php
				}
				else if ($billstatus == 'DELETED')
				{
				?>
                <option value="DELETED" selected="selected">SHOW DELETED</option>
                <?php
				}
				?>
                <option value="CONFIRMED">SHOW CONFIRMED</option>
                <option value="DELETED">SHOW DELETED</option>
              </select></td>
              <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag12" value="cbfrmflag1">
                <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                <input onClick="return funcRedirectWindow1()" name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
              <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
          </tbody>
        </table>
          </form>		</td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1400" 
            align="left" border="0">
          <tbody>
		  <?php
		  	$errmsg1 = '';
		  	if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
			if ($task == 'deleted')
			{
			$errmsg1 =  'Success. Selected Bill Number Delete Completed.';
		  ?>
            <tr>
              <td colspan="20" bgcolor="#FFFF00" class="bodytext31">&nbsp;<?php echo $errmsg1; ?></td>
              </tr>
			<?php
			}
			?>	
            <tr>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
             
              
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td colspan="3" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">
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
					
					$paymenttype = $_REQUEST['paymenttype'];
					$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&paymenttype=$paymenttype&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				<?php
				//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_salesreturnreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/SalesReturnReport.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
                <script language="javascript">
				function printbillreport1()
				{
					window.open("print_salesreturnreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/SalesReturnReport.xls"
				}
				</script>
                <input value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />
				
				</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
             
              
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>Print</strong></td>
              <!--<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>PDF</strong></td>-->
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong> Customer </strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Nett</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Cash</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Cheque</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Online</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Card</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Credit</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Pending</strong></div></td>
              
             
              <!--<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>Delivery</strong></td>-->
              
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Edit </strong></div></td>
              
              <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Delete</strong></div></td>
            </tr>
            <?php
			
			if (isset($_REQUEST["approvalstatus"])) { $approvalstatus = $_REQUEST["approvalstatus"]; } else { $approvalstatus = ""; }
			//$approvalstatus = $_REQUEST['approvalstatus'];
			if (isset($_REQUEST["financialyear"])) { $financialyear = $_REQUEST["financialyear"]; } else { $financialyear = ""; }
			//$financialyear = $_REQUEST['financialyear'];
			
			if ($billstatus == 'CONFIRMED')
			{
				$billstatusquery1 = " recordstatus <> 'deleted' ";
			}
			else if ($billstatus == '')
			{
				$billstatusquery1 = " recordstatus <> 'deleted' ";
			}
			else
			{
				$billstatusquery1 = " recordstatus = 'deleted' ";
			}

			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$billnumarray = explode('-', $cbbillnumber);
			//print_r($billnumarray);
			if (count($billnumarray) == 0)
			{
				$billnumberprefix = $billnumarray[0];
				$cbbillnumber = $billnumarray[1];
			}
			else
			{
				$billnumberprefix = '';
				$cbbillnumber = '';
			}
			if ($cbbillnumber == '') $cbbillnumber = $billnumberprefix;
			//echo $billnumber;
			//$cbbillnumber = $cbbillnumber;

			$query2 = "select * from pharmacysalesreturn_details where  
			billnumber like '%$billnumber1%' and 
			entrydate between '$transactiondatefrom' and '$transactiondateto' and $billstatusquery1  and 
			companyanum = '$companyanum' ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['auto_number'];
			$billautonumber = $res2['auto_number'];
			$totalamount = $res2['totalamount'];
			$billnumber = $res2['billnumber'];
			$entrydate = $res2['entrydate'];
			$patientcode = $res2['patientcode'];
			$visitcode = $res2['visitcode'];
			$res2anum = $res2['auto_number'];
			
			$query3 = "select * from master_customer where customercode = '$patientcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$customername = $res3['customername'];
			
			$query4 = "select * from refund_paynow where patientcode = '$patientcode' and visitcode = '$visitcode'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$cashamount = $res4['cashamount'];
			$chequeamount = $res4['chequeamount'];
			$onlineamount = $res4['onlineamount'];
			$creditamount = $res4['creditamount'];
			$cardamount = $res4['cardamount'];
			$tdsamount = $res4['tdsamount']; 
			$writeoffamount = $res4['writeoffamount'];
			$balanceamount = $res4['balanceamount'];
			
			if ($cashamount != '0.00')
			{
			$cashamount1 = $totalamount;
			}
			
			else if ($chequeamount != '0.00')
			{
			$chequeamount1 = $totalamount;
			}
			
			else if ($onlineamount != '0.00')
			{
			$onlineamount1 = $totalamount;
			}
			
			else if ($cardamount != '0.00')
			{
			$cardamount1 = $totalamount;
			}
			
			else if ($creditamount != '0.00')
			{
			$creditamount1 = $totalamount;
			}
			
			else if ($balanceamount != '0.00')
			{
			$balanceamount1 = $totalamount;
			}
			
			if ($billstatus == 'CLOSED') $closebill = '';
			if ($billstatus == 'OPEN') $closebill = 'Close Bill';
			
			$res2loopcount = $res2loopcount + 1;
			
			$subtotal = $res2['subtotal'];
			
			
			  if ($billstatus == 'OPEN')
			  {
			  	//$colorcode = 'bgcolor="#66CC66"';
			  	$colorcode = 'bgcolor="#CBDBFA"';
			  }
			  if ($billstatus == 'CLOSED')
			  {
			  	//$colorcode = 'bgcolor="#cbdbfa"';
			  	$colorcode = 'bgcolor="#ecf0f5"';
			  }
			  if ($billstatus == 'DELETED')
			  {
			  	//$colorcode = 'bgcolor="#cbdbfa"';
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2loopcount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <a href="javascript:loadprintpage1(<?php echo $res2anum; ?>)" class="bodytext3"><span class="bodytext3">Print</span></a></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left"> 
			  <?php echo $billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $entrydate ?>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
			  <?php echo $customername; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <?php echo $totalamount; ?>&nbsp;</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"> 
			  <?php echo $cashamount1; ?>&nbsp;</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"> 
			  <?php echo $chequeamount1; ?>&nbsp;</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"> 
			  <?php echo $onlineamount1; ?>&nbsp;</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"> 
			  <?php echo $cardamount1; ?>&nbsp;</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"> 
			  <?php echo $creditamount1; ?>&nbsp;</div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right"> 
			  <?php echo $balanceamount1; ?>&nbsp;</div></td>
             
              
              <td class="bodytext31" valign="center"  align="left"><div align="center">
              <?php
			  //if ($billstatus == 'OPEN' || $billstatus == 'CLOSED')
			  //{
			  if ($billstatus != 'DELETED')
			  {
			  ?>
                  <a href="pharmacyrefund.php?delbillst=billedit&&delbillautonumber=<?php echo $billautonumber; ?>&&delbillnumber=<?php echo $billnumber; ?>" class="bodytext3" target="_blank"><span class="bodytext3">Edit</span></a>
                  <?php
			  }
			  ?>
              </div></td>
              
              <td  align="left" valign="center" class="bodytext31">
             <?php
			  if ($billstatus != 'DELETED')
			  {
			  ?>
			  <div align="center"> 
			  <a href="salesreturndelete1.php?task=delete&&anum=<?php echo $billautonumber; ?>" 
			  class="bodytext3" onClick="return funcDeleteRecord1(<?php echo $billnumber;?>)"> 
			  <img src="images/b_drop.png" width="16" height="16" border="0"> </a> </div>
				<?php
				}
				?>
			  </td>
            </tr>
				<?php
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
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              
              
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

