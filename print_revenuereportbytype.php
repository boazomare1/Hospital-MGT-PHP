<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '';
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';




if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
//$locationcode1=$_REQUEST['locationcode'];
$location=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
?>

<table width="673" height="352" border="0" align="center" cellpadding="4" cellspacing="0" >
           <tr>
             <td colspan="2">&nbsp;</td>
           </tr>
           <tr>
             <td colspan="2">&nbsp;</td>
           </tr>
           <tr>
<?php 
  $query2 = "select * from master_company where locationcode='$location' and auto_number = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
 $companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>
			<td colspan="2">
			  <div align="center">
			    <?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>			
	        </div></td>
  </tr>
		<tr>
			<td colspan="2"><div align="center"><?php echo $companyname; ?>
		      <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>			
		    </div></td>
		</tr>
		<tr>
			<td colspan="2"><div align="center"><?php echo $address1; ?>
		      <?php
			$address2 = $area.''.$city.' '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>			
		    </div></td>
		</tr>
		<tr>
			<td colspan="2">
			
			  <div align="center"><?php echo $address2; ?>
		        <?php
			$address3 = "PHONE: ".$phonenumber1.' '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>			
	        </div></td>
		 
         </tr>
         <tr>
         <td bgcolor="#ffffff">&nbsp;</td>
         <td bgcolor="#ffffff">&nbsp;</td>
         </tr>
         <tr>
         <td bgcolor="#ffffff">&nbsp;</td>
         <td bgcolor="#ffffff">&nbsp;</td>
         </tr>
         </table>
        <table width="800" height="500" border="0" align="center" cellpadding="4" cellspacing="9" >
			
            <tr>
			<td colspan="" bgcolor="#ffffff">&nbsp;</td>
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
		  </tr>
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
			
		  <td class="bodytext31" valign="center"  align="left" ><?php  echo number_format($revenueamount,2,'.',','); ?></td>			
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
			  <td class="bodytext31" valign="center"  align="left" ><?php echo number_format($billnumbercount,2,'.',','); ?></td>

			 
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
			
           
			  <td class="bodytext31" valign="center"  align="left" ><?php echo number_format($averagecost, 2, '.',','); ?></td>
			<?php
			}
			?>
			</tr>
			<?php
			}
			?>
			
</table>
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('paymentmodecollection.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
