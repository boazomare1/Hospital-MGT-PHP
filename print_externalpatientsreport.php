<?php
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$username = '';
$companyanum = '';
$companyname = '';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="externalpatients.xls"');
header('Cache-Control: max-age=80');
 $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if ($companyanum == '') //For print view.
{
	if (isset($_SESSION["username"])) { $username = $_SESSION["username"]; } else { $username = ""; }
	//$username = $_SESSION['username'];
	if (isset($_SESSION["companyanum"])) { $companyanum = $_SESSION["companyanum"]; } else { $companyanum = ""; }
	//$companyanum = $_SESSION['companyanum'];
	if (isset($_SESSION["companyname"])) { $companyname = $_SESSION["companyname"]; } else { $companyname = ""; }
	//$companyname = $_SESSION['companyname'];
	if (isset($_SESSION["financialyear"])) { $financialyear = $_SESSION["financialyear"]; } else { $financialyear = ""; }
	//$financialyear = $_SESSION['financialyear'];
}
if ($companyanum == '')  // For excel export.
{
	if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
	//$username = $_REQUEST['username'];
	if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }
	//$companyanum = $_REQUEST['companyanum'];
	if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }
	//$companyname = $_REQUEST['companyname'];
	if (isset($_REQUEST["financialyear"])) { $financialyear = $_REQUEST["financialyear"]; } else { $financialyear = ""; }
	//$financialyear = $_REQUEST['financialyear'];
}

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>

<table width="50%" height="90" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td colspan="8" bgcolor="#ffffff" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
				}
				?>
 			</td>  
            </tr>
            <tr>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"><strong>No.</strong></td>
              <td width="22%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="14%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><strong> Visit Date </strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><strong> Bill No </strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>
			  <td width="11%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>
			  <td width="11%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><div align="right"><strong>Radiology</strong></div></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><div align="right"><strong>Services</strong></div></td>
			  <td width="11%" align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext31"><div align="right"><strong>Total</strong></div></td>
			</tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query2 = "select * from billing_external where locationcode='$locationcode' and billdate between '$ADate1' and '$ADate2' order by billdate desc";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2patientname = $res2['patientname'];
		  $res2billno = $res2['billno'];
		  $res2billdate = $res2['billdate'];
		
		  $query3 = "select sum(labitemrate) as labitemrate1 from billing_externallab where locationcode='$locationcode' and patientname = '$res2patientname' and billnumber = '$res2billno'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3". mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3= mysqli_fetch_array($exec3);
		  $res3labitemrate = $res3['labitemrate1'];
		  if($res3labitemrate == '')
		  {
		  $res3labitemrate = '0.00';
		  }
		  else
		  {
		  $res3labitemrate = $res3['labitemrate1'];
		  }
		  
		  $query4 = "select sum(amount) as amount1 from billing_externalpharmacy where locationcode='$locationcode' and patientname = '$res2patientname' and billnumber = '$res2billno'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4". mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4= mysqli_fetch_array($exec4);
		  $res4pharmacyitemrate = $res4['amount1'];
		  if($res4pharmacyitemrate == '')
		  {
		  $res4pharmacyitemrate = '0.00';
		  }
		  else
		  {
		  $res4pharmacyitemrate = $res4['amount1'];
		  }
		  
		  $query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where locationcode='$locationcode' and patientname = '$res2patientname' and billnumber = '$res2billno'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5". mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5= mysqli_fetch_array($exec5);
		  $res5radiologyitemrate = $res5['radiologyitemrate1'];
		  if($res5radiologyitemrate == '')
		  {
		  $res5radiologyitemrate = '0.00';
		  } 
		  else
		  {
		  $res5radiologyitemrate = $res5['radiologyitemrate1'];
		  }
		  
		  $query6 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where locationcode='$locationcode' and patientname = '$res2patientname' and billnumber = '$res2billno'";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6". mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  $res6servicesitemrate = $res6['servicesitemrate1'];
		  if($res6servicesitemrate == '')
		  {
		  $res6servicesitemrate = '0.00';
		  }
		  else
		  {
		  $res6servicesitemrate = $res6['servicesitemrate1'];
		  }
		  
		  $total = $res3labitemrate + $res4pharmacyitemrate + $res5radiologyitemrate + $res6servicesitemrate;
		  $total1 = $total1 + $res3labitemrate;
		  $total2 = $total2 + $res4pharmacyitemrate;
		  $total3 = $total3 + $res5radiologyitemrate;
		  $total4 = $total4 + $res6servicesitemrate;
		  $total6 = $total6 + $total;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res4pharmacyitemrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6servicesitemrate,2,'.',','); ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><strong>Total:</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><strong><?php echo number_format($total1,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><strong><?php echo number_format($total2,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><strong><?php echo number_format($total3,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><strong><?php echo number_format($total4,2,'.',','); ?></strong></td>
				<td  align="right" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"><strong><?php echo number_format($total6,2,'.',','); ?></strong></td>
		    </tr>
          </tbody>
</table>