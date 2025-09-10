<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

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


if (isset($_REQUEST["consultingdoctor"])) { $consultingdoctor = $_REQUEST["consultingdoctor"]; } else { $consultingdoctor = ""; }

$query111 = "select * from master_doctor where auto_number = '$consultingdoctor'";
$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in query111".mysqli_error($GLOBALS["___mysqli_ston"]));
$res111 = mysqli_fetch_array($exec111);
 $res111doctorname = $res111['doctorname'];

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype']; 
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
}

?>

<table align="center" border="0">
 <thead>
    <tr>
    	<td bgcolor="#ffffff">&nbsp;</td>
<?php

	$paymenttypename = array();
	
	$query21 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res21 = mysqli_fetch_array($exec21))
	{
	$res21paymenttype = $res21['paymenttype'];
	array_push($paymenttypename, $res21paymenttype);
?>

		<th class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong><?php echo $res21paymenttype."ein"; ?></strong></th>
    
<?php 
	}
?>	
	</tr>
    </thead>
<?php 
	$query15 = "select * from master_consultationlist group by username";
	$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res15 = mysqli_fetch_array($exec15))
	{
	$doctorname = $res15['username'];
?>

    <tr>
        <td width="5%" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $doctorname; ?></strong></td>
        <td colspan="30" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
    </tr>
   
    <tr>
    	<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Revenue</strong></td> 

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
	
	
	$query2 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res2 = mysqli_fetch_array($exec2))
	{
	$res2auto_number = $res2['auto_number'];
	$res2paymenttype = $res2['paymenttype'];
	$res3transactionamount = '0';
	$res4totalamount = '0';
	$res5totalamount = '0';
	$query16 = "select * from master_consultationlist where username = '$doctorname'";
	$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res16 = mysqli_fetch_array($exec16))
	{
	$visitcode = $res16['visitcode'];
	$query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$res3transactionamount += $res3['transactionamount1'];
	$res3billnumber = $res3['billnumber1'];
	
	$query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and totalamount <> '0.00' and billingdatetime between '$ADate1' and '$ADate2'"; 
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$res4totalamount += $res4['totalamount1'];
	$res4billnumber = $res4['billnumber1'];
	
	$query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactiontype = 'finalize' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res5 = mysqli_fetch_array($exec5);
	$res5totalamount += $res5['transactionamount1'];
	$res5billnumber = $res5['billnumber1'];
	}
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
?>

		<td class="bodytext31" ><?php  echo number_format($revenueamount,2,'.',','); ?></td>			
<!-- <tr>
<td class="bodytext31" valign="center"  align="left">Revenue</td>
</tr>-->
<?php

	}

?>
	</tr>
	<tr>
		<td class="bodytext31">Count</td> 
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
	
	
	$query2 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res2 = mysqli_fetch_array($exec2))
	{
	$res2auto_number = $res2['auto_number'];
	$res2paymenttype = $res2['paymenttype'];
	$res3transactionamount = '0';
	$res4totalamount = '0';
	$res5totalamount = '0';
	$res3billnumber = '0';
	$res4billnumber = '0';
	$res5billnumber = '0';
	$query16 = "select * from master_consultationlist where username = '$doctorname'";
	$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res16 = mysqli_fetch_array($exec16))
	{
	$visitcode = $res16['visitcode'];
	$query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$res3transactionamount += $res3['transactionamount1'];
	$res3billnumber += $res3['billnumber1'];
	
	$query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and totalamount <> '0.00' and billingdatetime between '$ADate1' and '$ADate2'"; 
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$res4totalamount += $res4['totalamount1'];
	$res4billnumber += $res4['billnumber1'];
	
	$query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactiontype = 'finalize' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res5 = mysqli_fetch_array($exec5);
	$res5totalamount += $res5['transactionamount1'];
	$res5billnumber += $res5['billnumber1'];
	}
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
?>
		<td class="bodytext31" valign="center"  align="left" bgcolor="#CBDBFA"><strong><?php echo number_format($billnumbercount,2,'.',','); ?></strong></td>

<?php
}
?>
	</tr>
	<tr>
		<td class="bodytext31">Avg Cost</td> 
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
	
	
	$query2 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res2 = mysqli_fetch_array($exec2))
	{
	$res2auto_number = $res2['auto_number'];
	$res2paymenttype = $res2['paymenttype'];
	$res3transactionamount = '0';
	$res4totalamount = '0';
	$res5totalamount = '0';
	$query16 = "select * from master_consultationlist where username = '$doctorname'";
	$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res16 = mysqli_fetch_array($exec16))
	{
	$visitcode = $res16['visitcode'];
	$query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$res3transactionamount += $res3['transactionamount1'];
	$res3billnumber = $res3['billnumber1'];
	
	$query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and totalamount <> '0.00' and billingdatetime between '$ADate1' and '$ADate2'"; 
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$res4totalamount += $res4['totalamount1'];
	$res4billnumber = $res4['billnumber1'];
	
	$query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and visitcode = '$visitcode' and transactiontype = 'finalize' and transactionamount <>'0.00' and transactiondate between '$ADate1' and '$ADate2'"; 
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res5 = mysqli_fetch_array($exec5);
	$res5totalamount += $res5['transactionamount1'];
	$res5billnumber = $res5['billnumber1'];
	}
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
?>

	<td class="bodytext31"><?php echo number_format($averagecost, 2, '.',','); ?></td>
<?php
	}
?>
	</tr>
<?php
	}

?>

<tr>
<td class="bodytext31">&nbsp;</td>
</tr>
</table>