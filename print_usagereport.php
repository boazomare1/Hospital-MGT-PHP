<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="daybookreport.xls"');
header('Cache-Control: max-age=80');

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
//$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
//$transactiondateto = date('Y-m-d');

include ("autocompletebuild_account2.php");

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
<style>
.xlText {
    mso-number-format: "\@";
}
</style>
<table border="0" width="1278">

<tr>
<td width="6" >&nbsp;</td>
<td colspan="8"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Usagereport: </strong><?php echo $transactiondatefrom; ?> To <?php echo $transactiondateto; ?></td>
 </tr>
<tr>
<td colspan="8">&nbsp;</td>
  </tr>
 <tr>
 <td>&nbsp;</td>
 <td>
  <table width="1278" border="1" cellspacing="0" cellpadding="2">
            
            
            <tr>
              <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill No</strong></div></td>
              <td width="17%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date </strong></td>
              <td width="13%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Reg. No </strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>OP No </strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
				<td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bill Amount </strong></div></td>
            </tr>
				<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
            //$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
            if ($cbfrmflag1 == 'cbfrmflag1')
            {
			$query21 = "select * from billing_paylater where accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname order by accountname desc  ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			
			$query22 = "select * from master_accountname where accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['accountname'];

			if( $res21accountname != '')
			{
			?>
			<tr bgcolor="#ecf0f5">
            <td colspan="15"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res22accountname;?></strong></td>
            </tr>
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query2 = "select * from billing_paylater where accountname like '%$res21accountname%' and billdate between '$ADate1' and '$ADate2' order by billdate desc";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2billnumber = $res2['billno'];
		  $res2billdate = $res2['billdate'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2patientname = $res2['patientname'];
		  $res2totalamount = $res2['totalamount'];
		  $res2accountname = $res2['accountname'];
	      
		  $total = $res2totalamount + $total;
		  
		  $query3 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and transactiontype = 'finalize'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3doctorname = $res3['doctorname'];
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
			/*$colorloopcount = $colorloopcount + 1;
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
			}*/
	
			?>
           <tr >
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="xlText"><?php echo $res2billnumber; ?></div></td>
              <td class="xlText" valign="center"  align="left">
                <div class="xlText"><?php echo $res2billdate; ?></div></td>
              <td class="xlText" valign="center"  align="left">
			  <?php echo $res2patientcode; ?></td>
              <td class="xlText" valign="center"  align="left">
			    <div align="left"><?php echo $res2visitcode; ?></div></td>
               <td class="xlText" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
				<td class="xlText" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
              <td class="xlText" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res2totalamount,2,'.',','); ?></div></td>

           </tr>
			<?php
			}
			}
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
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>Total:</strong></div></td>
				<td class="xlText" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total,2,'.',','); ?> </strong></div></td>
				
            </tr>
		
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>