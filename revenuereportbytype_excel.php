<?php
session_start();
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
header('Content-Disposition: attachment;filename="revenuereportbytype.xls"');
header('Cache-Control: max-age=80');


//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) {  $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) {  $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;

//$frmflag2 = $_POST['frmflag2'];
$location=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
?>
<style>
.text{
  mso-number-format:"\@";/*force text*/
}
</style>

          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
            
            <tr>
            <td colspan="2"  class="bodytext3"><strong>Revenue Report By User</strong></td>
            </tr>
            <tr>
            <td bgcolor="#ffffff">&nbsp;</td>
            </tr>
			<tr>
            
			<td bgcolor="#ffffff">&nbsp;</td>
			<?php 
		  $paymenttypename = array();
		  $query21 = "select paymenttype from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res21 = mysqli_fetch_array($exec21))
		  {
		  $res21paymenttype = $res21['paymenttype'];
		  array_push($paymenttypename, $res21paymenttype);
		  
		  //print_r($paymenttypename); 
		  ?>
		 
		  <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong><?php echo $res21paymenttype; ?></strong></td>
		  <?php 
		  }
		  ?>
		  
		  <?php 
		  if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
?>	
		  <tr>
		  <td class="bodytext31" valign="center"  align="left" ><strong>Revenue</strong></td> 
		  
		  <?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$totalcashamount = '0.00';
			$revenueamountfinal = '0.00';
			$billnumberamountfinal = '0.00';
			$averagecostfinal = '0.00';
			$billnumbercount ='0.00';
			
          $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

		  $revenueamountfinal = array();
		  $billnumberamountfinal = array();
		  $averagecostfinal = array();
	 

		  $query2 = "select auto_number,paymenttype from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			  $res2auto_number = $res2['auto_number'];
			  $res2paymenttype = $res2['paymenttype'];
			  
			  $query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and transactionamount <>'0.00' and locationcode='$location' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3transactionamount= $res3['transactionamount1'];
			  $res3billnumber = $res3['billnumber1'];
			  
			  $query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype'and totalamount <> '0.00' and locationcode='$location' and billingdatetime between '$ADate1' and '$ADate2'"; 
			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res4 = mysqli_fetch_array($exec4);
			  $res4totalamount= $res4['totalamount1'];
			  $res4billnumber = $res4['billnumber1'];
			  
			  $query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and transactiontype = 'finalize' and transactionamount <>'0.00' and locationcode='$location' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res5 = mysqli_fetch_array($exec5);
			  $res5totalamount= $res5['transactionamount1'];
			  $res5billnumber = $res5['billnumber1'];
			  
			  $revenueamount = $res3transactionamount + $res4totalamount + $res5totalamount;
			  $billnumbercount = $res3billnumber + $res4billnumber + $res5billnumber;
			  
			  if($billnumbercount != 0)
			  {
			  $averagecost = $revenueamount/$billnumbercount;
			  }
			  else 
			  {
			  $averagecost = $revenueamount/1;
			  }
			  array_push($revenueamountfinal, $revenueamount);
			  array_push($billnumberamountfinal, $billnumbercount);
			  array_push($averagecostfinal,$averagecost);
	
			 
		 
		  //print_r($revenueamountfinal);
		  
		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
		  $showcolor = ($colorloopcount & 1); 
		  
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = '';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
			
		  <td class="bodytext31" valign="center"  align="left" ><strong><?php  echo number_format($revenueamount,2,'.',','); ?></strong></td>			
		<!-- <tr>
		 <td class="bodytext31" valign="center"  align="left">Revenue</td>
		 </tr>-->
			<?php
			}
			
			?>
			</tr>
		    <tr>
		   <td class="bodytext31" valign="center"  align="left" ><strong>Count</strong></td> 
		  <?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$totalcashamount = '0.00';
			$revenueamountfinal = '0.00';
			$billnumberamountfinal = '0.00';
			$averagecostfinal = '0.00';
			$billnumbercount ='0.00';
			
          $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

		  $revenueamountfinal = array();
		  $billnumberamountfinal = array();
		  $averagecostfinal = array();
	  

		  $query2 = "select auto_number,paymenttype from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			  $res2auto_number = $res2['auto_number'];
			  $res2paymenttype = $res2['paymenttype'];
			  
			  $query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and transactionamount <>'0.00' and locationcode='$location' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3transactionamount= $res3['transactionamount1'];
			  $res3billnumber = $res3['billnumber1'];
			  
			  $query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype'and totalamount <> '0.00' and locationcode='$location' and billingdatetime between '$ADate1' and '$ADate2'"; 
			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res4 = mysqli_fetch_array($exec4);
			  $res4totalamount= $res4['totalamount1'];
			  $res4billnumber = $res4['billnumber1'];
			  
			  $query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and transactiontype = 'finalize' and transactionamount <>'0.00' and locationcode='$location' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res5 = mysqli_fetch_array($exec5);
			  $res5totalamount= $res5['transactionamount1'];
			  $res5billnumber = $res5['billnumber1'];
			  
			  $revenueamount = $res3transactionamount + $res4totalamount + $res5totalamount;
			  $billnumbercount = $res3billnumber + $res4billnumber + $res5billnumber;
			  
			  if($billnumbercount != 0)
			  {
			  $averagecost = $revenueamount/$billnumbercount;
			  }
			  else 
			  {
			  $averagecost = $revenueamount/1;
			  }
			  array_push($revenueamountfinal, $revenueamount);
			  array_push($billnumberamountfinal, $billnumbercount);
			  array_push($averagecostfinal,$averagecost);
			  
		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
		  $showcolor = ($colorloopcount & 1); 
		  
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = '';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
			  <td class="bodytext31" valign="center"  align="left" ><strong><?php echo number_format($billnumbercount,2,'.',','); ?></strong></td>
			 
			<?php
			}
			?>
			  </tr>
			  <tr>
		   <td class="bodytext31" valign="center"  align="left" ><strong>Avg Cost</strong></td> 
		  <?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$totalcashamount = '0.00';
			$revenueamountfinal = '0.00';
			$billnumberamountfinal = '0.00';
			$averagecostfinal = '0.00';
			$billnumbercount ='0.00';
			
$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

		  $revenueamountfinal = array();
		  $billnumberamountfinal = array();
		  $averagecostfinal = array();
	  

		  $query2 = "select auto_number,paymenttype from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
			  $res2auto_number = $res2['auto_number'];
			  $res2paymenttype = $res2['paymenttype'];
			  
			  $query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and transactionamount <>'0.00' and  locationcode='$location' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $res3transactionamount= $res3['transactionamount1'];
			  $res3billnumber = $res3['billnumber1'];
			  
			  $query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype'and totalamount <> '0.00' and locationcode='$location' and billingdatetime between '$ADate1' and '$ADate2'"; 
			  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res4 = mysqli_fetch_array($exec4);
			  $res4totalamount= $res4['totalamount1'];
			  $res4billnumber = $res4['billnumber1'];
			  
			  $query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and transactiontype = 'finalize' and locationcode='$location' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res5 = mysqli_fetch_array($exec5);
			  $res5totalamount= $res5['transactionamount1'];
			  $res5billnumber = $res5['billnumber1'];
			  
			  $revenueamount = $res3transactionamount + $res4totalamount + $res5totalamount;
			  $billnumbercount = $res3billnumber + $res4billnumber + $res5billnumber;
			  
			  if($billnumbercount != 0)
			  {
			  $averagecost = $revenueamount/$billnumbercount;
			  }
			  else 
			  {
			  $averagecost = $revenueamount/1;
			  }
			  array_push($revenueamountfinal, $revenueamount);
			  array_push($billnumberamountfinal, $billnumbercount);
			  array_push($averagecostfinal,$averagecost);
			  
		  $snocount = $snocount + 1;
		  $colorloopcount = $colorloopcount + 1;
		  $showcolor = ($colorloopcount & 1); 
		  
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = '';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
			
           
			  <td class="bodytext31" valign="center"  align="left" ><strong><?php echo number_format($averagecost, 2, '.',','); ?></strong></td>
			<?php
			}
			?>
			</tr>
			<?php
			}
			?>
			</tr>
           
          </tbody>
        </table>
