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

$ADate1 = "2014-01-01";

$ADate2 =  date('Y-m-d');



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




$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$totalamount = "0.00";

$totalamount30 = "0.00";

$searchsuppliername = "";

$searchsuppliername1 = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$total30="0.00";

$total60 = "0.00";

$total90 = "0.00";

$total120 = "0.00";

$total180 = "0.00";

$total240 = "0.00";

$totalamount1 = "0.00";

$totalamount301 = "0.00";

$totalamount601 = "0.00";

$totalamount901 = "0.00";

$totalamount1201 = "0.00";

$totalamount1801 = "0.00";

$totalamount2101 = "0.00";

$grandtotalamount1 = "0.00";

$grandtotalamount301 = "0.00";

$grandtotalamount601 = "0.00";

$grandtotalamount901 = "0.00";

$grandtotalamount1201 = "0.00";

$grandtotalamount1801 = "0.00";

$grandtotalamount2101 = "0.00";

$grandtotalamount2401 = "0.00";

$totalamount1 = "0.00";

$totalamount301 = "0.00";

$totalamount60 = "0.00";

$totalamount601 = "0.00";

$totalamount90 = "0.00";

$totalamount901 = "0.00";

$totalamount120 = "0.00";

$totalamount1201 = "0.00";

$totalamount180 = "0.00";

$totalamount1801 = "0.00";

$totalamount210 = "0.00";

$totalamount2101 = "0.00";

$totalamount240 = "0.00";

$totalamount2401 = "0.00";

$res21accountnameano='';

$closetotalamount1 = '0';

$closetotalamount301 = '0';

$closetotalamount601 = '0';

$closetotalamount901 = '0';

$closetotalamount1201 = '0';

$closetotalamount1801 = '0';

$closetotalamount2101 = '0';

$closetotalamount2401 = '0';



$total301='0';

$total601='0';

$total901='0';

$total1201='0';

$total1801='0';

$total2401='0';



$total3012='0';

$total6012='0';

$total9012='0';

$total12012='0';

$total18012='0';

$total24012='0';



$total3013='0';

$total6013='0';

$total9013='0';

$total12013='0';

$total18013='0';

$total24013='0';


//This include updatation takes too long to load for hunge items database.

include ("autocompletebuild_account2.php");




if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }



if (isset($_REQUEST["searchsubtypeanum1"])) {  $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }





if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom= $_REQUEST["ADate1"];} else { $ADate1 = "2000-01-01"; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto= $_REQUEST["ADate2"];} else { $ADate2 = date("Y-m-d
  "); }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//$frmflag2 = $_POST['frmflag2'];



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

<script>

function funcAccount()

{

if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))

{

alert('Please Select Account Name');

return false;

}

}

</script>

<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>

<script type="text/javascript" src="js/autosuggest4accounts.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.bal

{

border-style:none;

background:none;

text-align:right;

}

.bali

{

text-align:right;

}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



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

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		<form name="cbform1" method="post" action="nettpositions.php">

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400" 

            align="left" border="0">

          <tbody>

		   <tr>

   <td colspan="2"  align="left" valign="center" class="bodytext31"><strong>Nett Positions</strong></td>

</tr>

		  <?php

		  $finalcashinhand =0;
$finalbankamount=0;

//Bank Accounts
$group_id = 2;
$from_date = '2000-01-01';
$to_date = date('Y-m-d');
$accounts_subid = 7;

$all_ledgers = getAllLedgers($group_id,$accounts_subid);


		$finalbankamount = getLedgerAmt($all_ledgers,$from_date,$to_date);

// Cash In Hand
$accounts_subid = 8;
$all_ledgers = getAllLedgers($group_id,$accounts_subid);

$finalcashinhand = getLedgerAmt($all_ledgers,$from_date,$to_date);

//Cash Float
$accounts_subid = 9;
$all_ledgers = getAllLedgers($group_id,$accounts_subid);
$finalcashfloatamt = getLedgerAmt($all_ledgers,$from_date,$to_date);
?>

		  

   <tr>

   <td width=""  align="left" valign="center" class="bodytext31">Cash In Hand</td>

     <td width=""  align="right" valign="center" class="bodytext31"><?php echo number_format($finalcashinhand,2,'.',','); ?></td>

     <td width=""  align="left" valign="center" class="bodytext31">&nbsp;</td>

   </tr>

   <tr>

   <td width=""  align="left" valign="center" class="bodytext31">Bank</td>

     <td width=""  align="right" valign="center" class="bodytext31"><?php echo number_format($finalbankamount,2,'.',','); ?></td>

     <td width=""  align="left" valign="center" class="bodytext31">&nbsp;</td>

   </tr>

 		<tr>

   <td width=""  align="left" valign="center" class="bodytext31">Cash Float</td>

     <td width=""  align="right" valign="center" class="bodytext31"><?php echo number_format($finalcashfloatamt,2,'.',','); ?></td>

     <td width=""  align="left" valign="center" class="bodytext31">&nbsp;</td>

   </tr>

				 </tbody>

        </table>

		</form>

		</td>

      </tr>

	  

   

			<tr>

        <td>&nbsp;</td>

      </tr>

		

			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

			<tr>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>Debt Status</strong></td>

              <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

					<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

				<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

            	 </tr>

						<tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>30 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>60 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>90 days</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>120 days</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180 days</strong></td>

           <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180+ days</strong></td>

           

             	 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>Total Receivables</strong></td>

            </tr>

		<!-- 	
			<tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount90,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount120,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount180,2,'.',','); ?></td>

            <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamountgreater,2,'.',','); ?></td>

            

             	 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotal,2,'.',','); ?></td>

            </tr> -->

			

		 

			
			<?php 
			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = trim($searchsuppliername1);

			$searchsuppliername = trim($searchsuppliername);



			$selectedType=$type;

			 $query51 = "select auto_number from master_paymenttype where recordstatus <> 'deleted' and paymenttype!='CASH'";

			  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			  $j=0;

			  while($res51 = mysqli_fetch_array($exec51))

			  {

				$paymentTypes[$j]=$res51['auto_number'];

				$j=$j+1;

				

			  }


			  


            foreach ($paymentTypes as $k=>$v) {



			$type = $v;

		 

		 

			$query513 = "select auto_number, paymenttype from master_paymenttype where auto_number = '$type' and recordstatus <> 'deleted'";

			$exec513 = mysqli_query($GLOBALS["___mysqli_ston"], $query513) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res513 = mysqli_fetch_array($exec513);

			$type = $res513['paymenttype'];

			$typeanum = $res513['auto_number'];

			

			if($searchsubtypeanum1=='')

			{

				 $query2212 = "select accountname,auto_number,id,subtype from master_accountname where subtype <> '' and paymenttype = '$typeanum' and recordstatus <>'DELETED' group by subtype";

			}

			else if($searchsubtypeanum1!='')

			{

				 $query2212 = "select accountname,auto_number,id,subtype from master_accountname where paymenttype = '$typeanum' and subtype='$searchsubtypeanum1' and recordstatus <>'DELETED' group by subtype";

			}

			//echo $query2212;

			$exec2212 = mysqli_query($GLOBALS["___mysqli_ston"], $query2212) or die ("Error in Query2212".mysqli_error($GLOBALS["___mysqli_ston"]));

 			$resnum=mysqli_num_rows($exec2212); 

			while($res2212 = mysqli_fetch_array($exec2212))

			{

			$subtypeanum = $res2212['subtype'];

			$sno=1;

			$query9 = mysqli_query($GLOBALS["___mysqli_ston"], "select subtype from master_subtype where auto_number = '$subtypeanum'");

			$res9 = mysqli_fetch_array($query9);

			$subtype = $res9['subtype'];

			?>

			
			

			<?php

			if( $subtypeanum!='')

			{

				 $query221 = "select accountname,auto_number,id from master_accountname where subtype='$subtypeanum'";

			}

			//echo $query221;

			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

 			$resnum=mysqli_num_rows($exec221); 

			while($res221 = mysqli_fetch_array($exec221))

			{

			

			$res22accountname = $res221['accountname'];

			$res21accountnameano=$res221['auto_number'];

			$res21accountname = $res221['accountname'];

			$res21accountid = $res221['id'];

			

		 	$querydebit1 = "select * from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid'";

		

			$execdebit1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydebit1) or die ("Error in Querydebit1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numdebit1 = mysqli_num_rows($execdebit1);

					

			//echo $cashamount;

			

		

			if( $res22accountname != '' && $numdebit1>0)

			{

			

			$openingbalance='0';

			

			

	$totaldebit=0;		

$debit=0;

$credit1=0;

$credit2=0;

$totalpayment=0;

$totalcredit='0';

$resamount=0;



			

				

			$totalamountgreater=0;

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = trim($searchsuppliername1);

		  

		  $query1 = "select subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,fxamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano' and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' and billnumber not like 'AOP%' order by auto_number desc";

		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res2 = mysqli_fetch_array($exec1))

		  {

		 		$resamount=0;

				$res2transactionamount=0;

				

				$res2transactiondate = $res2['transactiondate'];

				$res2visitcode = $res2['visitcode'];

				$res2billnumber = $res2['billnumber'];

				$anum = $res2['auto_number'];



				$exchange_rate=1;

				

				$res2transactionamount = $res2['fxamount']/$exchange_rate;

			

				$totalpayment = 0;

				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				  $payment = $res98['transactionamount1'];
				  $totalpayment = $totalpayment + $payment;
				}
				

				$res7sumtransactionamount =0;

				$res8sumtransactionamount=0;

				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;

				

				$resamount = $res2transactionamount - $totalpayment;

				

				if($resamount != '0')

				{

					$snocount = $snocount + 1;

					$t1 = strtotime($ADate2);

					$t2 = strtotime($res2transactiondate);

					$days_between = ceil(abs($t1 - $t2) / 86400);

					

					if($days_between <= 30)

					{

						

							$totalamount30 = $totalamount30 + $resamount;

						

					}

					else if(($days_between >30) && ($days_between <=60))

					{

						

							$totalamount60 = $totalamount60 + $resamount;

						

					}

					else if(($days_between >60) && ($days_between <=90))

					{

						

							$totalamount90 = $totalamount90 + $resamount;

						

					}

					else if(($days_between >90) && ($days_between <=120))

					{

						

							$totalamount120 = $totalamount120 + $resamount;

						

					}

					else if(($days_between >120) && ($days_between <=180))

					{

						

							$totalamount180 = $totalamount180 + $resamount;

						

					}

					else

					{

						

							$totalamountgreater = $totalamountgreater + $resamount;

						

					}

		 			

			$totalamount1 = $totalamount1 + $res2transactionamount;

			$totalamount301 = $totalamount301 + $resamount;

			$totalamount601 = $totalamount601 + $totalamount30;

			$totalamount901 = $totalamount901 + $totalamount60;

			$totalamount1201 = $totalamount1201 + $totalamount90;

			$totalamount1801 = $totalamount1801 + $totalamount120;

			$totalamount2101 = $totalamount2101 + $totalamount180;

			$totalamount2401 = $totalamount2401 + $totalamountgreater;

			

			$closetotalamount1 = $closetotalamount1 + $res2transactionamount;

			$closetotalamount301 = $closetotalamount301 + $resamount;

			$closetotalamount601 = $closetotalamount601 + $totalamount30;

			$closetotalamount901 = $closetotalamount901 + $totalamount60;

			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;

			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;

			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;

			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;

			

			$res2transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$totalamount60=0;

			$totalamount90=0;

			$totalamount120=0;

			$totalamount180=0;

			$totalamountgreater=0;

			}

			$res2transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$total60=0;

			$totalamount60=0;

			$total90=0;

			$totalamount90=0;

			$total120=0;

			$totalamount120=0;

			$total180=0;

			$totalamount180=0;

			$total210=0;

			$totalamountgreater=0;

			

			if(substr($res2billnumber,0,4)=="IPDr"){

					continue;

				}

				$res5transactionamount=0;

				$respharmacreditpayment=0;

				$totalamount30=0;

				$total60=0;

				$totalamount60=0;

				$total90=0;

				$totalamount90=0;

				$total120=0;

				$totalamount120=0;

				$total180=0;

				$totalamount180=0;

				$total210=0;

				$totalamountgreater=0;

}



 $query1 = "select subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,transactionamount as fxamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano'  and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%' order by auto_number desc";

		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res2 = mysqli_fetch_array($exec1))

		  {

		 		$resamount=0;

				$res2transactionamount=0;

				

				$res2transactiondate = $res2['transactiondate'];

				$res2visitcode = $res2['visitcode'];

				$res2billnumber = $res2['billnumber'];

				$anum = $res2['auto_number'];



				$exchange_rate=1;

				

				$res2transactionamount = $res2['fxamount']/$exchange_rate;

			

				$totalpayment = 0;

				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				  $payment = $res98['transactionamount1'];
				  $totalpayment = $totalpayment + $payment;
				}
				

				$res7sumtransactionamount =0;

				$res8sumtransactionamount=0;

				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;

				

				$resamount = $res2transactionamount - $totalpayment;

				

				if($resamount != '0')

				{

					$snocount = $snocount + 1;

					$t1 = strtotime($ADate2);

					$t2 = strtotime($res2transactiondate);

					$days_between = ceil(abs($t1 - $t2) / 86400);

					

					if($days_between <= 30)

					{

						

							$totalamount30 = $totalamount30 + $resamount;

						

					}

					else if(($days_between >30) && ($days_between <=60))

					{

						

							$totalamount60 = $totalamount60 + $resamount;

						

					}

					else if(($days_between >60) && ($days_between <=90))

					{

						

							$totalamount90 = $totalamount90 + $resamount;

						

					}

					else if(($days_between >90) && ($days_between <=120))

					{

						

							$totalamount120 = $totalamount120 + $resamount;

						

					}

					else if(($days_between >120) && ($days_between <=180))

					{

						

							$totalamount180 = $totalamount180 + $resamount;

						

					}

					else

					{

						

							$totalamountgreater = $totalamountgreater + $resamount;

						

					}

		 			

			$totalamount1 = $totalamount1 + $res2transactionamount;

			$totalamount301 = $totalamount301 + $resamount;

			$totalamount601 = $totalamount601 + $totalamount30;

			$totalamount901 = $totalamount901 + $totalamount60;

			$totalamount1201 = $totalamount1201 + $totalamount90;

			$totalamount1801 = $totalamount1801 + $totalamount120;

			$totalamount2101 = $totalamount2101 + $totalamount180;

			$totalamount2401 = $totalamount2401 + $totalamountgreater;

			

			$closetotalamount1 = $closetotalamount1 + $res2transactionamount;

			$closetotalamount301 = $closetotalamount301 + $resamount;

			$closetotalamount601 = $closetotalamount601 + $totalamount30;

			$closetotalamount901 = $closetotalamount901 + $totalamount60;

			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;

			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;

			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;

			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;

			

			$res2transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$totalamount60=0;

			$totalamount90=0;

			$totalamount120=0;

			$totalamount180=0;

			$totalamountgreater=0;

			}

			$res2transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$total60=0;

			$totalamount60=0;

			$total90=0;

			$totalamount90=0;

			$total120=0;

			$totalamount120=0;

			$total180=0;

			$totalamount180=0;

			$total210=0;

			$totalamountgreater=0;

			

			if(substr($res2billnumber,0,4)=="IPDr"){

					continue;

				}

				$res5transactionamount=0;

				$respharmacreditpayment=0;

				$totalamount30=0;

				$total60=0;

				$totalamount60=0;

				$total90=0;

				$totalamount90=0;

				$total120=0;

				$totalamount120=0;

				$total180=0;

				$totalamount180=0;

				$total210=0;

				$totalamountgreater=0;

}





$query2 = "SELECT b.`docno` as docno, b.`transactionamount` as fxamount, b.`transactiondate` as transactiondate,a.visitcode,a.billnumber  FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res3 = mysqli_fetch_array($exec2))

		  {

		 		$resamount=0;

				$res3transactionamount=0;

				

				$res3transactiondate = $res3['transactiondate'];

				$res3docno = $res3['docno'];

				$exchange_rate=1;

				$res2visitcode = $res3['visitcode'];
				$res2billnumber = $res3['billnumber'];

				

				 $res3transactionamount = $res3['fxamount']/$exchange_rate;

			

				$totalpayment = 0;

				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				  $payment = $res98['transactionamount1'];
				  $totalpayment = $totalpayment + $payment;
				}
				

				$res7sumtransactionamount =0;

				$res8sumtransactionamount=0;

				$res3transactionamount = $res3transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;

				

				$resamount = $res3transactionamount - $totalpayment;

				

				if($resamount != '0')

				{

					$snocount = $snocount + 1;

					$t1 = strtotime($ADate2);

					$t2 = strtotime($res3transactiondate);

					$days_between = ceil(abs($t1 - $t2) / 86400);

					

					if($days_between <= 30)

					{

						

							$totalamount30 = $totalamount30 - $resamount;

						

					}

					else if(($days_between >30) && ($days_between <=60))

					{

						

							$totalamount60 = $totalamount60 - $resamount;

						

					}

					else if(($days_between >60) && ($days_between <=90))

					{

						

							$totalamount90 = $totalamount90 - $resamount;

						

					}

					else if(($days_between >90) && ($days_between <=120))

					{

						

							$totalamount120 = $totalamount120 - $resamount;

						

					}

					else if(($days_between >120) && ($days_between <=180))

					{

						

							$totalamount180 = $totalamount180 - $resamount;

						

					}

					else

					{

						

							$totalamountgreater = $totalamountgreater - $resamount;

						

					}

		 			

			$totalamount1 = $totalamount1 - $res3transactionamount;

			$totalamount301 = $totalamount301 - $resamount;

			$totalamount601 = $totalamount601 + $totalamount30;

			$totalamount901 = $totalamount901 + $totalamount60;

			$totalamount1201 = $totalamount1201 + $totalamount90;

			$totalamount1801 = $totalamount1801 + $totalamount120;

			$totalamount2101 = $totalamount2101 + $totalamount180;

			$totalamount2401 = $totalamount2401 + $totalamountgreater;

			

			$closetotalamount1 = $closetotalamount1 - $res3transactionamount;

			$closetotalamount301 = $closetotalamount301 - $resamount;

			$closetotalamount601 = $closetotalamount601 + $totalamount30;

			$closetotalamount901 = $closetotalamount901 + $totalamount60;

			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;

			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;

			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;

			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;

			

			$res3transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$totalamount60=0;

			$totalamount90=0;

			$totalamount120=0;

			$totalamount180=0;

			$totalamountgreater=0;

			}

			$res3transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$total60=0;

			$totalamount60=0;

			$total90=0;

			$totalamount90=0;

			$total120=0;

			$totalamount120=0;



			$total180=0;

			$totalamount180=0;

			$total210=0;

			$totalamountgreater=0;

			

			if(substr($res2billnumber,0,4)=="IPDr"){

					continue;

				}

				$res5transactionamount=0;

				$respharmacreditpayment=0;

				$totalamount30=0;

				$total60=0;

				$totalamount60=0;

				$total90=0;

				$totalamount90=0;

				$total120=0;

				$totalamount120=0;

				$total180=0;

				$totalamount180=0;

				$total210=0;

				$totalamountgreater=0;

}

 $query3 = "SELECT `docno` as docno, `fxamount` as fxamount, `transactiondate` as transactiondate,visitcode,billnumber  from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'";

 

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec3))

		  {

		 		$resamount=0;

				$res4transactionamount=0;

				

				$res4transactiondate = $res4['transactiondate'];

				$res4docno = $res4['docno'];

				$exchange_rate=1;

				$res2visitcode = $res3['visitcode'];
				$res2billnumber = $res3['billnumber'];
				

				 $res4transactionamount = $res4['fxamount']/$exchange_rate;

			

				$totalpayment = 0;
				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				  $payment = $res98['transactionamount1'];
				  $totalpayment = $totalpayment + $payment;
				}
				

				$res7sumtransactionamount =0;

				$res8sumtransactionamount=0;

				$res4transactionamount = $res4transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;

				

				$resamount = $res4transactionamount - $totalpayment;

				

				if($resamount != '0')

				{

					$snocount = $snocount + 1;

					$t1 = strtotime($ADate2);

					$t2 = strtotime($res4transactiondate);

					$days_between = ceil(abs($t1 - $t2) / 86400);

					

					if($days_between <= 30)

					{

						

							$totalamount30 = $totalamount30 - $resamount;

						

					}

					else if(($days_between >30) && ($days_between <=60))

					{

						

							$totalamount60 = $totalamount60 - $resamount;

						

					}

					else if(($days_between >60) && ($days_between <=90))

					{

						

							$totalamount90 = $totalamount90 - $resamount;

						

					}

					else if(($days_between >90) && ($days_between <=120))

					{

						

							$totalamount120 = $totalamount120 - $resamount;

						

					}

					else if(($days_between >120) && ($days_between <=180))

					{

						

							$totalamount180 = $totalamount180 - $resamount;

						

					}

					else

					{

						

							$totalamountgreater = $totalamountgreater - $resamount;

						

					}

		 			

			$totalamount1 = $totalamount1 - $res4transactionamount;

			$totalamount301 = $totalamount301 - $resamount;

			$totalamount601 = $totalamount601 + $totalamount30;

			$totalamount901 = $totalamount901 + $totalamount60;

			$totalamount1201 = $totalamount1201 + $totalamount90;

			$totalamount1801 = $totalamount1801 + $totalamount120;

			$totalamount2101 = $totalamount2101 + $totalamount180;

			$totalamount2401 = $totalamount2401 + $totalamountgreater;

			

			$closetotalamount1 = $closetotalamount1 - $res4transactionamount;

			$closetotalamount301 = $closetotalamount301 - $resamount;

			$closetotalamount601 = $closetotalamount601 + $totalamount30;

			$closetotalamount901 = $closetotalamount901 + $totalamount60;

			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;

			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;

			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;

			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;

			

			$res4transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$totalamount60=0;

			$totalamount90=0;

			$totalamount120=0;

			$totalamount180=0;

			$totalamountgreater=0;

			}

			$res4transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$total60=0;

			$totalamount60=0;

			$total90=0;

			$totalamount90=0;

			$total120=0;

			$totalamount120=0;



			$total180=0;

			$totalamount180=0;

			$total210=0;

			$totalamountgreater=0;

			

			if(substr($res2billnumber,0,4)=="IPDr"){

					continue;

				}

				$res5transactionamount=0;

				$respharmacreditpayment=0;

				$totalamount30=0;

				$total60=0;

				$totalamount60=0;

				$total90=0;

				$totalamount90=0;

				$total120=0;

				$totalamount120=0;

				$total180=0;

				$totalamount180=0;

				$total210=0;

				$totalamountgreater=0;

}



$query4 = "SELECT `docno` as docno, `fxamount` as fxamount, `transactiondate` as transactiondate,visitcode,billnumber  FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'";

 $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res5 = mysqli_fetch_array($exec4))

		  {

		 		$resamount=0;

				$res5transactionamount=0;

				

				$res5transactiondate = $res5['transactiondate'];

				$res5docno = $res5['docno'];

				$exchange_rate=1;

				$res2visitcode = $res3['visitcode'];
				$res2billnumber = $res3['billnumber'];
				

				 $res5transactionamount = $res5['fxamount']/$exchange_rate;

			

				$totalpayment = 0;

				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				  $payment = $res98['transactionamount1'];
				  $totalpayment = $totalpayment + $payment;
				}
				

				$res7sumtransactionamount =0;

				$res8sumtransactionamount=0;

				$res5transactionamount = $res5transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;

				

				$resamount = $res5transactionamount - $totalpayment;

				

				if($resamount != '0')

				{

					$snocount = $snocount + 1;

					$t1 = strtotime($ADate2);

					$t2 = strtotime($res5transactiondate);

					$days_between = ceil(abs($t1 - $t2) / 86400);

					

					if($days_between <= 30)

					{

						

							$totalamount30 = $totalamount30 - $resamount;

						

					}

					else if(($days_between >30) && ($days_between <=60))

					{

						

							$totalamount60 = $totalamount60 - $resamount;

						

					}

					else if(($days_between >60) && ($days_between <=90))

					{

						

							$totalamount90 = $totalamount90 - $resamount;

						

					}

					else if(($days_between >90) && ($days_between <=120))

					{

						

							$totalamount120 = $totalamount120 - $resamount;

						

					}

					else if(($days_between >120) && ($days_between <=180))

					{

						

							$totalamount180 = $totalamount180 - $resamount;

						

					}

					else

					{

						

							$totalamountgreater = $totalamountgreater - $resamount;

						

					}

		 			

			$totalamount1 = $totalamount1 - $res5transactionamount;

			$totalamount301 = $totalamount301 - $resamount;

			$totalamount601 = $totalamount601 + $totalamount30;

			$totalamount901 = $totalamount901 + $totalamount60;

			$totalamount1201 = $totalamount1201 + $totalamount90;

			$totalamount1801 = $totalamount1801 + $totalamount120;

			$totalamount2101 = $totalamount2101 + $totalamount180;

			$totalamount2401 = $totalamount2401 + $totalamountgreater;

			

			$closetotalamount1 = $closetotalamount1 - $res5transactionamount;

			$closetotalamount301 = $closetotalamount301 - $resamount;

			$closetotalamount601 = $closetotalamount601 + $totalamount30;

			$closetotalamount901 = $closetotalamount901 + $totalamount60;

			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;

			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;

			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;

			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;

			

			$res5transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$totalamount60=0;

			$totalamount90=0;

			$totalamount120=0;

			$totalamount180=0;

			$totalamountgreater=0;

			}

			$res5transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$total60=0;

			$totalamount60=0;

			$total90=0;

			$totalamount90=0;

			$total120=0;

			$totalamount120=0;



			$total180=0;

			$totalamount180=0;

			$total210=0;

			$totalamountgreater=0;

			

			if(substr($res2billnumber,0,4)=="IPDr"){

					continue;

				}

				$res5transactionamount=0;

				$respharmacreditpayment=0;

				$totalamount30=0;

				$total60=0;

				$totalamount60=0;

				$total90=0;

				$totalamount90=0;

				$total120=0;

				$totalamount120=0;

				$total180=0;

				$totalamount180=0;

				$total210=0;

				$totalamountgreater=0;

}

$query5 = "SELECT `docno` as docno, `transactionamount` as fxamount, `entrydate` as transactiondate , `selecttype` as type  FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";

 $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res6 = mysqli_fetch_array($exec5))

		  {

		 		$resamount=0;

				$res6transactionamount=0;

				

				$res6transactiondate = $res6['transactiondate'];

				$res6docno = $res6['docno'];

				$exchange_rate=1;

				

				

			

				$totalpayment = 0;

				if($res6['type'] == 'Cr')

				{

			$query="SELECT `docno` as docno, -1*`creditamount` as fxamount, `entrydate` as transactiondate , `selecttype` as type  FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res6docno' and selecttype = 'Cr'";

				}

				else

				{

				$query="SELECT `docno` as docno, -1*`debitamount` as fxamount, `entrydate` as transactiondate , `selecttype` as type  FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res6docno' and selecttype = 'Dr'";

				}

				$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res = mysqli_fetch_array($exec);

		   $res6transactionamount = $res['fxamount']/$exchange_rate;

				$resamount = $res6transactionamount - $totalpayment;

				

				if($resamount != '0')

				{

					$snocount = $snocount + 1;

					$t1 = strtotime($ADate2);

					$t2 = strtotime($res6transactiondate);

					$days_between = ceil(abs($t1 - $t2) / 86400);

					

					if($days_between <= 30)

					{

						

							$totalamount30 = $totalamount30 + $resamount;

						

					}

					else if(($days_between >30) && ($days_between <=60))

					{

						

							$totalamount60 = $totalamount60 + $resamount;

						

					}

					else if(($days_between >60) && ($days_between <=90))

					{

						

							$totalamount90 = $totalamount90 + $resamount;

						

					}

					else if(($days_between >90) && ($days_between <=120))

					{

						

							$totalamount120 = $totalamount120 + $resamount;

						

					}

					else if(($days_between >120) && ($days_between <=180))

					{

						

							$totalamount180 = $totalamount180 + $resamount;

						

					}

					else

					{

						

							$totalamountgreater = $totalamountgreater + $resamount;

						

					}

		 			

			$totalamount1 = $totalamount1 + $res6transactionamount;

			$totalamount301 = $totalamount301 + $resamount;

			$totalamount601 = $totalamount601 + $totalamount30;

			$totalamount901 = $totalamount901 + $totalamount60;

			$totalamount1201 = $totalamount1201 + $totalamount90;

			$totalamount1801 = $totalamount1801 + $totalamount120;

			$totalamount2101 = $totalamount2101 + $totalamount180;

			$totalamount2401 = $totalamount2401 + $totalamountgreater;

			

			$closetotalamount1 = $closetotalamount1 + $res6transactionamount;

			$closetotalamount301 = $closetotalamount301 + $resamount;

			$closetotalamount601 = $closetotalamount601 + $totalamount30;

			$closetotalamount901 = $closetotalamount901 + $totalamount60;

			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;

			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;

			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;

			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;

			

			$res6transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$totalamount60=0;

			$totalamount90=0;

			$totalamount120=0;

			$totalamount180=0;

			$totalamountgreater=0;

			}

			$res6transactionamount=0;

			$resamount=0;

			$totalamount30=0;

			$total60=0;

			$totalamount60=0;

			$total90=0;

			$totalamount90=0;

			$total120=0;

			$totalamount120=0;



			$total180=0;

			$totalamount180=0;

			$total210=0;

			$totalamountgreater=0;

			

			if(substr($res2billnumber,0,4)=="IPDr"){

					continue;

				}

				$res6transactionamount=0;

				$respharmacreditpayment=0;

				$totalamount30=0;

				$total60=0;

				$totalamount60=0;

				$total90=0;

				$totalamount90=0;

				$total120=0;

				$totalamount120=0;

				$total180=0;

				$totalamount180=0;

				$total210=0;

				$totalamountgreater=0;

}

						

		$closetotalamount1 =$closetotalamount1 +$openingbalance;

		$closetotalamount301=$closetotalamount301 + $openingbalance;

		

		$totalamount1 =$totalamount1+$openingbalance;

		$totalamount301=$totalamount301 + $openingbalance;

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

           


            <?php

			$closetotalamount1 = '0';

			$closetotalamount301 = '0';

			$closetotalamount601 = '0';

			$closetotalamount901 = '0';

			$closetotalamount1201 = '0';

			$closetotalamount1801 = '0';

			$closetotalamount2101 = '0';

			$closetotalamount2401 = '0';

			

			

			

			

			 







			$totalamount30=0;

			$totalamount60=0;

			$totalamount90=0;

			$totalamount120=0;

			$totalamount180=0;

			$totalamount210=0;

			}

			}

			?>

			

         

			

			<?php

			$grandtotalamount1 += $totalamount1;

$grandtotalamount301 += $totalamount301;

$grandtotalamount601 += $totalamount601;

$grandtotalamount901 += $totalamount901;

$grandtotalamount1201 += $totalamount1201;

$grandtotalamount1801 += $totalamount1801;

$grandtotalamount2101 += $totalamount2101;

$grandtotalamount2401 += $totalamount2401;

			$totalamount1 = "0.00";

			$totalamount301 = "0.00";

			$totalamount601 = "0.00";

			$totalamount901 = "0.00";

			$totalamount1201 = "0.00";

			$totalamount1801 = "0.00";

			$totalamount2101 = "0.00";

			$totalamount2401 = "0.00";

				

				

			?>

			     

			   <?php

			   }}

			?>

 
			<tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount601,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount901,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount1201,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount1801,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount2101,2,'.',','); ?></td>

            <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount2401,2,'.',','); ?></td>

            

             	 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($grandtotalamount301,2,'.',','); ?></td>

            </tr> 

			

		

			  </table>

			  
<?php 
$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$totalamount = "0.00";

$totalamount30 = "0.00";

$searchsuppliername = "";

$searchsuppliername1 = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$total60 = "0.00";

$total90 = "0.00";



$total120 = "0.00";

$total180 = "0.00";

$total210 = "0.00";

$totalamount1 = "0.00";

$totalamount301 = "0.00";

$totalamount601 = "0.00";

$totalamount901 = "0.00";

$totalamount1201 = "0.00";

$totalamount1801 = "0.00";

$totalamount2101 = "0.00";

$totalamount90 = '0.00';

$totalamount2401 = 0;

$totalamount60 = 0;



$ftotalamount1 = 0;

$ftotalamount301 = 0;

$ftotalamount601 = 0;

$ftotalamount901 = 0;

$ftotalamount1201 = 0;

$ftotalamount1801 = 0;

$ftotalamount2101 = 0;

$ftotalamount2401 = 0;



$totalamount302=0;

        $totalamount602=0;

        $totalamount902=0;

        $totalamount1202=0;

        $totalamount1802=0;

        $totalamount2102=0;

        $totalamountgreater2=0;


?>
       
      

      <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

      <tr>

      <td>&nbsp;</td>

      </tr>

      <tr>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>Credit Status</strong></td>

              <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

        <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

          <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

        <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

               </tr>

            <tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>30 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>60 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>90 days</strong></td>

        <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>120 days</strong></td>

        <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180 days</strong></td>

           <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180+ days</strong></td>

           

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>Total Payables</strong></td>

            </tr>


       <?php  


       
        

      $dotarray = explode("-", $paymentreceiveddateto);

      $dotyear = $dotarray[0];

      $dotmonth = $dotarray[1];

      $dotday = $dotarray[2];

      $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

      //$searchsuppliername1 = $_REQUEST['searchsuppliername'];

      $searchsuppliername1 = "";

      $arraysuppliercode='';

      

      

      $res1suppliername = '';

      $res1suppliercode = '';

      $res1transactiondate ='';

      //print_r($_POST);

     

      if($searchsuppliername1 != '')

      {

      $arraysuppliername = $_REQUEST['searchsuppliername'];

      $searchsuppliername1 = trim($arraysuppliername);

      $arraysuppliercode = $_REQUEST['searchsuppliercode'];

      $query212 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' group by suppliercode";

      }

      else if($searchsuppliername1 == '')

      {

      $query212 = "select * from master_transactionpharmacy where transactiondate between '$ADate1' and '$ADate2'  group by suppliercode";

      }

      //echo $query212;

      $exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

      while($res212 = mysqli_fetch_array($exec212))

      {

      

      $res21suppliername = $res212['suppliername'];

      $res21suppliercode = $res212['suppliercode'];

      

      $query222 = "select * from master_accountname where id = '$res21suppliercode' and recordstatus <>'DELETED' ";

      $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

      $res222 = mysqli_fetch_array($exec222);

      $res22accountname = $res222['accountname'];



      if( $res21suppliername != '')

      {

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

      

      $dotarray = explode("-", $paymentreceiveddateto);

      $dotyear = $dotarray[0];

      $dotmonth = $dotarray[1];

      $dotday = $dotarray[2];

      $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

      $searchsuppliername1 = trim($searchsuppliername1);

      $res21suppliername = trim($res21suppliername);

      



      //$query1 = "select * from master_transactionpharmacy where suppliercode = '$res21suppliercode' and transactiondate between '$ADate1' and '$ADate2' group by billnumber order by suppliername";

      $query1 = "select * from master_purchase where suppliercode = '$res21suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2' and companyanum = '$companyanum'  group by suppliercode";

      $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

      $num1 = mysqli_num_rows($exec1);

      while($res1 = mysqli_fetch_array($exec1))

      {

      $res1suppliername = $res1['suppliername'];

      $res1suppliercode = $res1['suppliercode'];

      $res1transactiondate  = $res1['billdate'];

      $res1billnumber = $res1['billnumber'];

      $res2transactionamount = $res1['totalamount'];

      /*$res1patientname = $res1['patientname'];

      $res1visitcode = $res1['visitcode'];*/

      

      $query2 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode'  and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2'";

      $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

      $res2 = mysqli_fetch_array($exec2);

      $res2transactionamount = $res2['transactionamount1'];

      

      $query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode'   and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate between '$ADate1' and '$ADate2'";

      $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

      $res3 = mysqli_fetch_array($exec3);

       $res3transactionamount = $res3['transactionamount1'];

      

      $res4return = 0;

      $query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where  transactiontype = 'PURCHASE' and suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2')

      UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select billnumber from master_transactionpharmacy where transactiontype = 'PURCHASE' and suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2')";

      $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

      while($res4 = mysqli_fetch_array($exec4))

      {

      $res4return += $res4['totalreturn'];

      }

      

    

      

      $invoicevalue =  $res2transactionamount - ($res3transactionamount + $res4return) ;

      

$query45122 = "select billnumber from master_purchase where suppliercode = '$res1suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2' and companyanum = '$companyanum'  group by billnumber";     $exe45122=mysqli_query($GLOBALS["___mysqli_ston"], $query45122);

      while($res45122=mysqli_fetch_array($exe45122))

      {

     $resbill=$res45122['billnumber']; 

       $query451= "select transactiondate,sum(transactionamount) as transactionamount,billnumber,mrnno from master_transactionpharmacy where billnumber='$resbill' and  suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by billnumber";

      

      $exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));

     $num451 = mysqli_num_rows($exec451);

   if($num451>0)

      {

      while($res451=mysqli_fetch_array($exec451))

    {  

     

    $res451transactiondate = $res451['transactiondate'];

    $res451transactionamount = $res451['transactionamount'];

      $res451billnumber=$res451['billnumber'];

      $res451mrnno =$res451['mrnno'];

      $query452= "select sum(transactionamount) as transactionamount from master_transactionpharmacy where  billnumber='$res451billnumber' and  suppliercode = '$res1suppliercode'  and transactiontype = 'PAYMENT' and recordstatus='allocated'  and transactiondate between '$ADate1' and '$ADate2' group by billnumber";

      $exe452=mysqli_query($GLOBALS["___mysqli_ston"], $query452);

      $res452=mysqli_fetch_array($exe452);

      

     $totalpayment=$res452['transactionamount'];

      

      $returnamount451 = 0;

      $query652 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res451billnumber' and  transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2')

      UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res451billnumber' and entrydate between '$ADate1' and '$ADate2'";

      $exe652=mysqli_query($GLOBALS["___mysqli_ston"], $query652) or die("Error in query652".mysqli_error($GLOBALS["___mysqli_ston"]));

      while($res652=mysqli_fetch_array($exe652))

      {

      $returnamount451 += $res652['totalreturn'];

      }

      

    if($snocount==0)

    {

     $totalamount420 =$res451transactionamount-($totalpayment + $returnamount451)+$openingbalance;

}

else

{

$totalamount420 =$res451transactionamount-($totalpayment + $returnamount451);

}

      $totalamount451 =$totalamount420;    

      $t1 = strtotime("$ADate2");

      $t2 = strtotime("$res451transactiondate");

      $days_between = ceil(abs($t1 - $t2) / 86400);

    

      

      if($days_between <= 30)

      {

    

      $totalamount302 = $totalamount302 + $totalamount451;

    

      }

      else if(($days_between >30) && ($days_between <=60))

      {

    

      $totalamount602 = $totalamount602 + $totalamount451;

    

      }

      else if(($days_between >60) && ($days_between <=90))

      {

    

      $totalamount902 = $totalamount902 + $totalamount451;

    

      }

      else if(($days_between >90) && ($days_between <=120))

      {

    

      $totalamount1202 = $totalamount1202 + $totalamount451;

    

      }

      else if(($days_between >120) && ($days_between <=180))

      {

    

      $totalamount1802 = $totalamount1802 + $totalamount451;

    

      }

      else

      {

    

      $totalamountgreater2 = $totalamountgreater2 + $totalamount451;

      }

  $totalamount451=0;

       }

    

    }

    }

     

    

      

        $totalamount1 = $totalamount1 + $res2transactionamount;

        

        $totalamount301 = $totalamount301 + $invoicevalue;

        $totalamount601 = $totalamount601 + $totalamount302;

        $totalamount901 = $totalamount901 + $totalamount602;

        $totalamount1201 = $totalamount1201 + $totalamount902;

        $totalamount1801 = $totalamount1801 + $totalamount1202;

        $totalamount2101 = $totalamount2101 + $totalamount1802;

        $totalamount2401 = $totalamount2401 + $totalamountgreater2;

        

        $ftotalamount1 = $ftotalamount1 + $res2transactionamount;

        

        $ftotalamount301 = $ftotalamount301 + $invoicevalue;

        $ftotalamount601 = $ftotalamount601 + $totalamount302;

        $ftotalamount901 = $ftotalamount901 + $totalamount602;

        $ftotalamount1201 = $ftotalamount1201 + $totalamount902;

        $ftotalamount1801 = $ftotalamount1801 + $totalamount1202;

        $ftotalamount2101 = $ftotalamount2101 + $totalamount1802;

        $ftotalamount2401 = $ftotalamount2401 + $totalamountgreater2;

        

        $res2transactionamount=0;

        $invoicevalue=0;

        $totalamount30=0;

        $totalamount60=0;

        $totalamount90=0;

        $totalamount120=0;

        $totalamount180=0;

        $totalamount210=0;

        $totalamount302=0;

        $totalamount602=0;

        $totalamount902=0;

        $totalamount1202=0;

        $totalamount1802=0;

        $totalamount2102=0;

        $totalamountgreater2=0;

        

        $total60=0;

        $total90=0;

        $total120=0;

        $total180=0;

        $total210=0;

           

      }

      

            $query2="select sum(creditamount-debitamount) as creditamount,ledgername,entrydate,docno from master_journalentries where ledgerid='$res21suppliercode' and entrydate between '$ADate1' and '$ADate2' group by docno";

      $exe2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);

      while($res2=mysqli_fetch_array($exe2))

      {

        $creditamount=$res2['creditamount'];

      $ledgername=$res2['ledgername'];

      $entrydate=$res2['entrydate'];

      $docno=$res2['docno'];

      

      $t1 = strtotime($entrydate);

        $t2 = strtotime($ADate2);

      $days_between = ceil(abs($t2 - $t1) / 86400);

        if($days_between<30)

      {

      $totalamount30=$totalamount30+$creditamount;

      }

      

      if($days_between>30 && $days_between<=60)

      {

      $total60=$total60+$creditamount;

      }

      if($days_between>60 && $days_between<=90)

      {

      $total90=$total90+$creditamount;

      }

      if($days_between>90 && $days_between<=120)

      {

      $total120=$total120+$creditamount;

      }

      if($days_between>120 && $days_between<=180)

      {

      $total180=$total180+$creditamount;

      }

      if($days_between>180)

      {

      $total210=$total210+$creditamount;

      }

      

      

        if($creditamount !=''){ 

      

        $totalamount1 = $totalamount1 + $creditamount;

        $totalamount301 = $totalamount301 + $creditamount;

        $totalamount601 = $totalamount601 + $totalamount30;

        $totalamount901 = $totalamount901 + $total60;

        $totalamount1201 = $totalamount1201 + $total90;

        $totalamount1801 = $totalamount1801 + $total120;

        $totalamount2101 = $totalamount2101 + $total180;

        $totalamount2401 = $totalamount2401 + $total210;

        

        $ftotalamount1 = $ftotalamount1 + $creditamount;

        $ftotalamount301 = $ftotalamount301 + $creditamount;

        $ftotalamount601 = $ftotalamount601 + $totalamount30;

        $ftotalamount901 = $ftotalamount901 + $total60;

        $ftotalamount1201 = $ftotalamount1201 + $total90;

        $ftotalamount1801 = $ftotalamount1801 + $total120;

        $ftotalamount2101 = $ftotalamount2101 + $total180;

        $ftotalamount2401 = $ftotalamount2401 + $total210;

      //echo $cashamount;

      

    



      

}

        $res2transactionamount=0;

        $invoicevalue=0;

        $totalamount30=0;

        $totalamount60=0;

        $totalamount90=0;

        $totalamount120=0;

        $totalamount180=0;

        $totalamount210=0;

        

        $totalamount302=0;

        $totalamount602=0;

        $totalamount902=0;

        $totalamount1202=0;

        $totalamount1802=0;

        $totalamount2102=0;

        $total60=0;

        $total90=0;

        $total120=0;

        $total180=0;

        $total210=0;

      

      }

      

      

        

      ?>

      

      <?php

      

      }

        $totalamount1 = 0;

        $totalamount301 = 0;

        $totalamount601 = 0;

        $totalamount901 = 0;

        $totalamount1201 = 0;

        $totalamount1801 = 0;

        $totalamount2101 = 0;

        $totalamount2401 = 0;

      

      }

      ?>

           

              <tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($ftotalamount601,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($ftotalamount901,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($ftotalamount1201,2,'.',','); ?></td>

        <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($ftotalamount1801,2,'.',','); ?></td>

        <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($ftotalamount2101,2,'.',','); ?></td>

            <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($ftotalamount2401,2,'.',','); ?></td>

            

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($ftotalamount301,2,'.',','); ?></td>

            </tr>

        <tr>

      <td>&nbsp;</td>

      </tr>

      <tr>

        <?php 


        $billnumbers=array();

$billnumbers1=array();

$billnumbers11=array();

$billnumbers2=array();

$billnumbers3=array();

$billnumbers4=array();

$billnumbers5=array();



$totalvisitcodes='';

$totalbillnumbers='';

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$totalat = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$arraysuppliername = '';

$arraysuppliercode = '';  

$totalatret = 0.00;



$totalamount30 = 0;

$totalamount60 = 0;

$totalamount90 = 0;

$totalamount120 = 0;

$totalamount180 = 0;

$totalamountgreater = 0;

      

$docno = $_SESSION['docno'];



$query01="select locationcode from login_locationdetails where username='$username' and docno='$docno'";

$exe01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

$res01=mysqli_fetch_array($exe01);

 $locationcode=$res01['locationcode'];


     

        $colorcode = "";
        $openingcreditamount = 0;

        $openingdebittamount = 0;

        $openingbalance=0;
        $fulltotal = 0;
        $fulltotalamount30 = 0;
        $fulltotalamount60 =0;
        $fulltotalamount90 = 0;
        $fulltotalamount120 = 0;
        $fulltotalamount180 = 0;
        $fulltotalamountgreater = 0;

        $snocount_main = 0;
        if (isset($_REQUEST["searchsuppliername"])) { $suppliername = $_REQUEST["searchsuppliername"]; } else { $suppliername = ""; }

        if (isset($_REQUEST["searchsuppliercode"])) {  $suppliercode = $_REQUEST["searchsuppliercode"]; } else { $suppliercode = ""; }

          $arraysupplier = explode("#", $suppliername);

          $suppliername = $arraysupplier[0];

          $suppliername = trim($suppliername);

          $res21accountname = $suppliername ;

          $snocount = 0;
          if($suppliername !="")
          {
          $query233 = "select doccoa,description as doctorname from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by doccoa order by recorddate,docno ";
          }
          else
          {
          $query233 = "select doccoa,description as doctorname from billing_ipprivatedoctor where amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by doccoa order by recorddate,docno ";
            }
          
          $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));

      //$num233=mysql_num_rows($exec233);
      

      while($res233 = mysqli_fetch_array($exec233))  
      {

      $suppliercode = $res233['doccoa'];
      $doctorname = $res233['doctorname'];

      $snocount_main = $snocount_main + 1;

      $colorloopcount = $colorloopcount + 1;

      $showcolor = ($colorloopcount & 1); 

      if ($showcolor == 0)

      {
        $colorcode = 'bgcolor="#CBDBFA"';

      }

      else

      {

      

        $colorcode = 'bgcolor="#ecf0f5"';

      }

        $snocount = 0;  // OB
                    
          $querycr1op = "SELECT SUM(`transactionamount`) as openingbalance  FROM `billing_ipprivatedoctor` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1' and visittype='OP' and amount <> '0.00' and amount > 0  and docno <> ''";
            $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1op) or die ("Error in querycr1op".mysqli_error($GLOBALS["___mysqli_ston"]));
            $rescr1 = mysqli_fetch_array($execcr1);
            $openingbalance = $rescr1['openingbalance']; 

          $querycr1ip = "SELECT SUM(`sharingamount`) as openingbalance1  FROM `billing_ipprivatedoctor` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1' and visittype='IP' and amount <> '0.00' and amount > 0  and docno <> ''";
            $execcr12 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1ip) or die ("Error in querycr1ip".mysqli_error($GLOBALS["___mysqli_ston"]));
            $rescr12 = mysqli_fetch_array($execcr12);
            $openingbalance1 = $rescr12['openingbalance1']; 

            $openingbalance =$openingbalance +$openingbalance1;

            ?>


    
          <?php // OB

          $query234 = "select recorddate,docno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode from billing_ipprivatedoctor where doccoa='$suppliercode' and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by docno,doccoa order by recorddate,docno ";

      $exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));

      $num234=mysqli_num_rows($exec234);
      

      while($res234 = mysqli_fetch_array($exec234))

      {
        
        $res45transactiondate = $res234['recorddate'];
        $billnumber = $res234['docno'];

        //$res45patientname = $res234['patientname'];
        //$res45patientcode = $res234['patientcode'];
        //$res45visitcode = $res234['visitcode'];
        //$res45accountname = $res234['accountname'];
        //$res45amount = $res234['amount'];
        //$res45transactionamount = $res234['transactionamount'];
        //$res45billamount = $res234['original_amt'];
        //$res45doctorperecentage = $res234['percentage'];

        $res45transactionamount = $res234['sharingamount'];
        $res45vistype = $res234['visittype'];

        if($res45vistype == "OP")
        {
          //$res45billamount = $res234['original_amt'];
          $res45doctorperecentage = $res234['percentage'];
          //if($res45transactionamount<1 && $res45doctorperecentage>0)
            $res45transactionamount = $res234['transactionamount'];
        }
        else
        {
          //$res45billamount = $res234['transactionamount'];
          $res45doctorperecentage = $res234['pvtdr_percentage'];
          
        }
        

      

       $t1 = strtotime($ADate2);

      $t2 = strtotime($res45transactiondate);

      $days_between = ceil(abs($t1 - $t2) / 86400);
  
       $snocount = $snocount + 1;

      //$res2transactionamount =  $res45amount;
      $res2transactionamount =  $res45transactionamount;

      $debit_total = 0;


      if($days_between <= 30)

      {

      if($snocount == 1)

      {

      $totalamount30 = $openingbalance + $res2transactionamount;
      // $totalamount30 = ($openingbalance + $res2transactionamount) - $debit_total;

      }

      else

      {

     $totalamount30 = $totalamount30 + $res2transactionamount;

      //$totalamount30 = $totalamount30 + $res2transactionamount - $debit_total;

      }

      }

      else if(($days_between >30) && ($days_between <=60))

      {

      if($snocount == 1)

      {

      $totalamount60 = $openingbalance + $res2transactionamount;

      }

      else

      {

      $totalamount60 = $totalamount60 + $res2transactionamount;

      }

      }

      else if(($days_between >60) && ($days_between <=90))

      {

      if($snocount == 1)

      {

      $totalamount90 = $openingbalance + $res2transactionamount;

      }

      else

      {

      $totalamount90 = $totalamount90 + $res2transactionamount;

      }

      }

      else if(($days_between >90) && ($days_between <=120))

      {

      if($snocount == 1)

      {

      $totalamount120 = $openingbalance + $res2transactionamount;

      }

      else

      {

      $totalamount120 = $totalamount120 + $res2transactionamount;

      }

      }

      else if(($days_between >120) && ($days_between <=180))

      {

        if($snocount == 1)

      {

      $totalamount180 = $openingbalance + $res2transactionamount;

      }

      else

      {

      $totalamount180 = $totalamount180 + $res2transactionamount;

      }

      }

      else

      {

          if($snocount == 1)

      {

      $totalamountgreater = $openingbalance + $res2transactionamount;

      }

      else

      {

      $totalamountgreater = $totalamountgreater + $res2transactionamount;

      }

      }

         if($snocount == 1)

      {

     // $totalat = $openingbalance + $res45amount;
      
     
      $totalat = $openingbalance + $res45transactionamount;
      


      }

      else

      {

     // $totalat = $totalat + $res45amount;
      $totalat = $totalat + $res45transactionamount ;
        
        
      }
      //echo "grand total".$totalat.'<br>';

       
      //$res45doctorperecentage = preg_replace('~\.0+$~','',$res45doctorperecentage);
      ?>
         
      <?php 

        $query = "select transactionamount as debit,transactiondate  from master_transactiondoctor where billnumber = '$billnumber' and doctorcode='$suppliercode' order by transactiondate,auto_number";

      $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));

      $num=mysqli_num_rows($exec);

      $inner_sno = 0;
      $debit_total =0;

      //$debit_amt = 0;

      while($res = mysqli_fetch_array($exec))

      {
        $debit_amt = $res['debit'];
        //$debit_total = $debit_total + $debit_amt;
        

        //$totalat = $totalat - $debit_amt;
        $inner_sno = $inner_sno + 1; 

        $snocount = $snocount + 1;

        $totalat = $totalat - $debit_amt;

        $restransactiondate = $res['transactiondate'];
        $t1 = strtotime($ADate2);

      $t2 = strtotime($restransactiondate);

      $days_between_1 = ceil(abs($t1 - $t2) / 86400);
      if($days_between_1 <= 30)

      {

      
      
     $totalamount30 = $totalamount30 - $debit_amt;

      //$totalamount30 = $totalamount30 + $res2transactionamount - $debit_total;

     

      }

      else if(($days_between_1 >30) && ($days_between_1 <=60))

      {

      

        $totalamount60 = $totalamount60 - $debit_amt;

      

      }

      else if(($days_between_1 >60) && ($days_between_1 <=90))

      {

     

    

      $totalamount90 = $totalamount90 - $debit_amt;

      

      }

      else if(($days_between_1 >90) && ($days_between_1 <=120))

      {

     

    

      $totalamount120 = $totalamount120 - $debit_amt;

    

      }

      else if(($days_between_1 >120) && ($days_between_1 <=180))

      {

      $totalamount180 = $totalamount180 - $debit_amt;

      }
      else

      {

         

     

      $totalamountgreater = $totalamountgreater - $debit_amt;

     

      }
  
     // $totalat = $totalat + $res45amount;

       }

      }

      ?>
           
    

      

      

          

      <?php 
      $grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
      //$grandtotal = $totalat;

      $fulltotal = $fulltotal + $grandtotal;
      $fulltotalamount30 = $fulltotalamount30 + $totalamount30;
      $fulltotalamount60 = $fulltotalamount60 + $totalamount60;
      $fulltotalamount90 = $fulltotalamount90 + $totalamount90;
      $fulltotalamount120 = $fulltotalamount120 + $totalamount120;
      $fulltotalamount180 = $fulltotalamount180 + $totalamount180;
      $fulltotalamountgreater = $fulltotalamountgreater + $totalamountgreater;

      ?>

     

      

       

         <?php  } ?>

       
           <tr>

     



         

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>Doctor Status</strong></td>

              <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

        <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

          <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

        <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

               </tr>

            <tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>30 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>60 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>90 days</strong></td>

        <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>120 days</strong></td>

        <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180 days</strong></td>

           <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180+ days</strong></td>

           

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>Total </strong></td>

            </tr>

              <tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($fulltotalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($fulltotalamount60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($fulltotalamount90,2,'.',','); ?></td>

        <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($fulltotalamount120,2,'.',','); ?></td>

        <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($fulltotalamount180,2,'.',','); ?></td>

            <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($fulltotalamountgreater,2,'.',','); ?></td>

            

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($fulltotal,2,'.',','); ?></td>

            </tr> 


</table>



</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>

<?php 

function getAllLedgers($group_id,$accounts_subid){

	$array_data = [];

$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='$group_id' and auto_number='$accounts_subid' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";
	while($res = mysqli_fetch_array($exec))
	{
		$ledger_query1 = "select id as code from master_accountname where accountssub='".$res['code']."' order by auto_number";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die ("Error in ledger_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$data = "";

			while($res1 = mysqli_fetch_array($exec1))
			{
				array_push($array_data, $res1['code']);
			}

			//getAllLedgers($res['code']);
	}	

	$ledger_query1 = "select id as code from master_accountname where accountssub='$accounts_subid' and accountsmain='$group_id' order by auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die ("Error in ledger_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";

	while($res1 = mysqli_fetch_array($exec1))
	{
		array_push($array_data, $res1['code']);
	}


	return $array_data;

}

function getLedgerAmt($all_ledgers,$from_date,$to_date)
{
	$transaction_dr = 0;
	$transaction_cr =0;
$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and  ledger_id in ('".implode("','",$all_ledgers)."') and transaction_date <= '".$to_date."' group by transaction_type ";
		$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_transaction = mysqli_fetch_array($exec_transaction)){
			if($res_transaction['transaction_type']=="D"){
				$transaction_dr += $res_transaction['transaction_amount'];
			}else{
				$transaction_cr += $res_transaction['transaction_amount'];
			}
		}
		return $transaction_dr;
}
?>