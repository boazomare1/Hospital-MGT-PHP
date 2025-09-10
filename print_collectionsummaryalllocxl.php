<?php
session_start();
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
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

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Collectionalllocation.xls"');
header('Cache-Control: max-age=80');


 $cashamount2='0.00';
 $cardamount2='0.00';
 $chequeamount2='0.00';
 $onlineamount2='0.00'; 
 $creditamount2='0.00'; 

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

<style>
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; }
.bodytextbold{font-weight:bold; font-size:15px; text-align:center;}
.bodytext{font-weight:normal; font-size:15px; text-align:center; vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td, th{{height: 50px;padding: 5px; }
td{width:75px; vertical-align:central;}
table{table-layout:fixed;
width:100%;
display:table;
border-collapse:collapse;}
</style>
<table width="700" border="1" align="left">
<thead>
	<tr>
    	<th colspan="7" class="logo">Collection Summary -All Locations Wise Report</th>
        
    </tr>
    <tr><th colspan="7" class="logo">Collection Report From: <?php echo $transactiondatefrom;?> To: <?php echo $transactiondateto;?></th></tr>
</thead>	
<thead>
    	<tr>
        	<th width="110" class="border bodytextbold">Location</th>
            <th width="80" class="border bodytextbold">Cash</th>
            <th width="80" class="border bodytextbold">Card</th>
            <th width="80" class="border bodytextbold">Cheque</th>
			<th width="80" class="border bodytextbold">Online</th>
            <th width="80" class="border bodytextbold">Mpesa</th>
            <th width="80" class="border bodytextbold">Amount</th>
        </tr>
        </thead>
    <?php
 		   $query1 = "select * from master_location where status='' order by locationname";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$loccode=array();
			while ($res1 = mysqli_fetch_array($exec1))
			{
			
			 $locationname = $res1["locationname"];
			 $locationcode = $res1["locationcode"];
		  $query2 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where locationcode='$locationcode' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2 = mysqli_fetch_array($exec2);
		  
     	  $res2cashamount1 = $res2['cashamount1'];
		  $res2onlineamount1 = $res2['onlineamount1'];
		  $res2creditamount1 = $res2['creditamount1'];
		  $res2chequeamount1 = $res2['chequeamount1'];
		  $res2cardamount1 = $res2['cardamount1'];
		  
		   
	      $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where locationcode='$locationcode' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  
     	  $res3cashamount1 = $res3['cashamount1'];
		  $res3onlineamount1 = $res3['onlineamount1'];
		  $res3creditamount1 = $res3['creditamount1'];
		  $res3chequeamount1 = $res3['chequeamount1'];
		  $res3cardamount1 = $res3['cardamount1'];
		  
		  
		  $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where locationcode='$locationcode' and  billingdatetime between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  
     	  $res4cashamount1 = $res4['cashamount1'];
		  $res4onlineamount1 = $res4['onlineamount1'];
		  $res4creditamount1 = $res4['creditamount1'];
		  $res4chequeamount1 = $res4['chequeamount1'];
		  $res4cardamount1 = $res4['cardamount1'];
		  
		  $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where locationcode='$locationcode' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  
     	  $res5cashamount1 = $res5['cashamount1'];
		  $res5onlineamount1 = $res5['onlineamount1'];
		  $res5creditamount1 = $res5['creditamount1'];
		  $res5chequeamount1 = $res5['chequeamount1'];
		  $res5cardamount1 = $res5['cardamount1'];
		  
		  $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where locationcode='$locationcode' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  
     	  $res6cashamount1 = $res6['cashamount1'];
		  $res6onlineamount1 = $res6['onlineamount1'];
		  $res6creditamount1 = $res6['creditamount1'];
		  $res6chequeamount1 = $res6['chequeamount1'];
		  $res6cardamount1 = $res6['cardamount1'];

		  $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where locationcode='$locationcode' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  
     	  $res7cashamount1 = $res7['cashamount1'];
		  $res7onlineamount1 = $res7['onlineamount1'];
		  $res7creditamount1 = $res7['creditamount1'];
		  $res7chequeamount1 = $res7['chequeamount1'];
		  $res7cardamount1 = $res7['cardamount1'];
		  
		  $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where locationcode='$locationcode' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  
     	  $res8cashamount1 = $res8['cashamount1'];
		  $res8onlineamount1 = $res8['onlineamount1'];
		  $res8creditamount1 = $res8['creditamount1'];
		  $res8chequeamount1 = $res8['chequeamount1'];
		  $res8cardamount1 = $res8['cardamount1'];
		  
    	  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where locationcode='$locationcode' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  
     	  $res9cashamount1 = $res9['cashamount1'];
		  $res9onlineamount1 = $res9['onlineamount1'];
		  $res9creditamount1 = $res9['creditamount1'];
		  $res9chequeamount1 = $res9['chequeamount1'];
		  $res9cardamount1 = $res9['cardamount1'];

		  $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where locationcode='$locationcode' and  transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res10 = mysqli_fetch_array($exec10);
		  
     	  $res10cashamount1 = $res10['cashamount1'];
		  $res10onlineamount1 = $res10['onlineamount1'];
		  $res10creditamount1 = $res10['creditamount1'];
		  $res10chequeamount1 = $res10['chequeamount1'];
		  $res10cardamount1 = $res10['cardamount1'];

		  
		  $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1;
		  $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1;
		  $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1;
		  $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1;
		  $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1;
		  
		  $cashamount1 = $cashamount - $res5cashamount1;
		  $cardamount1 = $cardamount - $res5cardamount1;
		  $chequeamount1 = $chequeamount - $res5chequeamount1;
		  $onlineamount1 = $onlineamount - $res5onlineamount1;
		  $creditamount1 = $creditamount - $res5creditamount1;		  
	
		  
		  $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;
		  
		  	  
		 	
		 $cashamount2=$cashamount2+$cashamount1;
		 $cardamount2=$cardamount2+$cardamount1;
		 $chequeamount2=$chequeamount2+$chequeamount1;
		 $onlineamount2=$onlineamount2+$onlineamount1; 
		 $creditamount2=$creditamount2+$creditamount1; 
		 
		 $total2 = $cashamount2 + $onlineamount2 + $chequeamount2 + $cardamount2 + $creditamount2;
		 
		  
		  $snocount = $snocount + 1;
		 
		  
			
			?>
    <tr>
    	<td align="left" class="bodytext"><?php echo $locationname;?></td>
        <td align="right" class="bodytext"><?php echo number_format($cashamount1,2,'.',','); ?></td>
        <td align="right" class="bodytext"><?php echo number_format($cardamount1,2,'.',','); ?></td>
        <td align="right" class="bodytext"> <?php echo number_format($chequeamount1,2,'.',','); ?></td>
        <td align="right" class="bodytext"><?php echo number_format($onlineamount1,2,'.',','); ?></td>
		 <td align="right" class="bodytext"><?php echo number_format($creditamount1,2,'.',','); ?></td>
        <td align="right" class="bodytext"><?php echo number_format($total,2,'.',','); ?></td>
    </tr>
    <tr>
    	<td class="bodytextbold" align="right">Sub Totals:</td>
        <td align="right" class="bodytext"><?php echo number_format($cashamount1,2,'.',','); ?></td>
        <td align="right" class="bodytext"><?php echo number_format($cardamount1,2,'.',','); ?></td>
        <td align="right" class="bodytext"><?php echo number_format($chequeamount1,2,'.',','); ?></td>
        <td align="right" class="bodytext"><?php echo number_format($onlineamount1,2,'.',','); ?></td>
		<td align="right" class="bodytext"><?php echo number_format($creditamount1,2,'.',','); ?></td>
        <td align="right" class="bodytext"><?php echo number_format($total,2,'.',','); ?></td>
    </tr>
    <?php 
			}
			
	?>
<tr>
    <td class="bodytextbold" align="right">Grand Total :</td>
    <td align="right" class="bodytext"><?php echo number_format($cashamount2,2,'.',','); ?></td>
    <td align="right" class="bodytext"><?php echo number_format($cardamount2,2,'.',','); ?></td>
    <td align="right" class="bodytext"><?php echo number_format($chequeamount2,2,'.',','); ?></td>
    <td align="right" class="bodytext"><?php echo number_format($onlineamount2,2,'.',','); ?></td>
	<td align="right" class="bodytext"><?php echo number_format($creditamount2,2,'.',','); ?></td>
    <td align="right" class="bodytext"><?php echo number_format($total2,2,'.',','); ?></td>
</tr>
</table>