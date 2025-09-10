<?php

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

$nettotal = '0.00';

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

$res3labitemratereturn = '';

$accountname = '';

$radiologyitemrate1  = '';



 



if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }



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



/*if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	//$cbsuppliername = $_REQUEST['cbsuppliername'];

	//$suppliername = $_REQUEST['cbsuppliername'];

	$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	$visitcode1 = 10;



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

	$ADate1 = $_REQUEST['ADate1'];

	$ADate2 = $_REQUEST['ADate2'];

}

else

{

	$ADate1 = date('Y-m-d', strtotime('-1 month'));

	$ADate2 = date('Y-m-d');

}

*/

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



function cbsuppliername1()

{

	document.cbform1.submit();

}



</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

-->

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table width="1900" border="0" cellspacing="0" cellpadding="2">

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

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
             <?php if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
             if($type=='opcash'){ ?>
             	<td colspan="2" bgcolor="#ecf0f5" class="bodytext31"> <strong>OP Cash</strong>
             <?php }else{  ?>
             		<td colspan="2" bgcolor="#ecf0f5" class="bodytext31"> <strong>OP Refunds</strong>
             <?php }  ?>
                         

			<?php

			

			

			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				?>

			<?php

			$netamount='';

			$totalconsultationamount='';

			$totalrefundamount='0.00';

			$totallabamount='';

			$totallabrefundamount='';

			$totalradiologyamount='';

			$totalradiologyrefundamount='';

			$totalservicesamount='';

			$totalservicesrefundamount='';

			$totalpharmacyamount='';

			$totalpharmacyrefundamount='';

			$totalreferalamount='';

			$totalreferalrefundamount='';

			$totalexternalpharmacy='';

			$totalexternallab='';

			$totalexternalradiology='';

			$totalexternalservices='';

			$res102refundamount = '0.00';

			

			//$query1 = "select sum(billamount) as billamount1 from master_billing where billingdatetime between '$ADate1' and '$ADate2'";

			$query1 = "SELECT SUM(`consultation`) as billamount1 FROM `billing_consultation` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' and accountname = 'CASH - HOSPITAL'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res1 = mysqli_fetch_array($exec1);

			

			$res1consultationamount = $res1['billamount1'];

			

			$totalconsultationamount=$res1consultationamount;

			$netamount=$netamount+$res1consultationamount;

			

/*			$query2 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billdate between '$ADate1' and '$ADate2'";

			$exec2 = mysql_query($query2) or die ("Error in query2".mysql_error());

			$res2 = mysql_fetch_array($exec2);

			$res2labitemrate = $res2['labitemrate1'];

*/	

			// $query102 = "select sum(consultation) as refundamount from refund_consultation where billdate between '$ADate1' and '$ADate2'";
			// $exec102 = mysql_query($query102) or die ("Error in query102".mysql_error());
			// $res102 = mysql_fetch_array($exec102);
			// $res102refundamount = $res102['refundamount'];

			//////// TOTAL REFUND T  CONSULTATION/////////
			//REFUND

			$query12 = "select sum(consultation) as consultation1 from refund_consultation where billdate between '$ADate1' and '$ADate2'";

			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res12 = mysqli_fetch_array($exec12);

			$res12refundconsultation = $res12['consultation1'];



			$query12c = "select sum(fxamount) as consultation1 from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2'  ";

			$exec12c = mysqli_query($GLOBALS["___mysqli_ston"], $query12c) or die ("Error in Query12c".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res12c = mysqli_fetch_array($exec12c);

			$res12crefundconsultation = $res12c['consultation1'];



			$query121 = "select sum(consultationfxamount) as consultation1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2' ";

			$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res121 = mysqli_fetch_array($exec121);

			$res12refundconsultation1 = $res121['consultation1'];



            $res12refundconsultation = $res12refundconsultation + $res12crefundconsultation+$res12refundconsultation1;

            if($res12refundconsultation == '' || $res12refundconsultation == 0)
			{
				$res12refundconsultation = '0.00';
			}
			//////// TOTAL REFUND ENDS /////////
			$totalrefundamount=$res12refundconsultation;
			// $totalrefundamount=$res102refundamount;
			$netamount=$netamount-$res12refundconsultation;

			
		

			$query3 = "select sum(fxamount) as labitemrate1 from billing_paynowlab where  billdate between '$ADate1' and '$ADate2'";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3 = mysqli_fetch_array($exec3);

			$res3labitemrate = $res3['labitemrate1'];

			

			 $totallabamount=$totallabamount+$res3labitemrate;

			$netamount=$netamount+$res3labitemrate;

			


			//////// refunds lab ///////////////
			// $query301 = "select sum(labitemrate) as labitemrate2 from refund_paynowlab where billdate between '$ADate1' and '$ADate2'";

			// $exec301 = mysql_query($query301) or die ("Error in Query3".mysql_error());

			// $res301 = mysql_fetch_array($exec301);

			// $res301labitemratereturn = $res301['labitemrate2'];

			//REFUND

			$query19 = "select sum(labitemrate)as labitemrate1 from refund_paylaterlab where billdate between '$ADate1' and '$ADate2'";

			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res19 = mysqli_fetch_array($exec19) ;

			$res19refundlabitemrate = $res19['labitemrate1'];

			$query20 = "select sum(labitemrate)as labitemrate1 from refund_paynowlab where billdate between '$ADate1' and '$ADate2'";

			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res20 = mysqli_fetch_array($exec20) ;

			$res20refundlabitemrate = $res20['labitemrate1'];



			$query222 = "select sum(labfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'";

			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res222 = mysqli_fetch_array($exec222) ;

			$res20refundlabitemrate1 = $res222['amount1'];



			$res301labitemratereturn = $res20refundlabitemrate + $res19refundlabitemrate+$res20refundlabitemrate1;

			//////////// REFUNDS LAB CLOSE ////////////

			$totallabrefundamount=$res301labitemratereturn;

			$netamount=$netamount-$res301labitemratereturn;

			

			

//			$totallabitemrate = $res3labitemratereturn ;

			

			$snocount = $snocount + 1;

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

			

/*			$query4 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billdate between '$ADate1' and '$ADate2'";

			$exec4 = mysql_query($query4) or die ("Error in query4".mysql_error());

			$res4 = mysql_fetch_array($exec4);

			$res4radiologyitemrate = $res4['radiologyitemrate1'];

*/			

			$query5 = "select sum(fxamount) as radiologyitemrate1 from billing_paynowradiology where billdate between '$ADate1' and '$ADate2'";

			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res5 = mysqli_fetch_array($exec5);

			$res5radiologyitemrate = $res5['radiologyitemrate1'];

			

			

			$totalradiologyamount=$res5radiologyitemrate;

			$netamount=$netamount+$res5radiologyitemrate;


			/////////// REFUND RADIOLOGY ///////////////////////////////////////
			// $query501 = "select sum(radiologyitemrate) as radiologyitemrate2 from refund_paynowradiology where billdate between '$ADate1' and '$ADate2'";
			// $exec501 = mysql_query($query501) or die ("Error in Query501".mysql_error());
			// $res501 = mysql_fetch_array($exec501);
			//  $res501radiologyitemratereturn = $res501['radiologyitemrate2'];

			 //REFUND
			$query22 = "select sum(fxamount)as radiologyitemrate1 from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundradioitemrate = $res22['radiologyitemrate1'];

			$query23 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where billdate between '$ADate1' and '$ADate2'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23) ;
			$res23refundradioitemrate = $res23['radiologyitemrate1'];

			$query223 = "select sum(radiologyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'";
			$exec223 = mysqli_query($GLOBALS["___mysqli_ston"], $query223) or die ("Error in Query223".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res223 = mysqli_fetch_array($exec223) ;
			$res23refundradioitemrate1 = $res223['amount1'];

			$res501radiologyitemratereturn = $res23refundradioitemrate + $res22refundradioitemrate+$res23refundradioitemrate1;
			$netamount=$netamount-$res501radiologyitemratereturn;
			/////////// REFUND RADIOLOGY ///////////////////////////////////////
			$totalradiologyrefundamount=$totalradiologyrefundamount+$res501radiologyitemratereturn;

			$totalradiologyitemrate = $res5radiologyitemrate;

			

			$snocount = $snocount + 1;

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

			

/*			$query6 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billdate between '$ADate1' and '$ADate2'";

			$exec6 = mysql_query($query6) or die ("Error in query6".mysql_error());

			$res6 = mysql_fetch_array($exec6);

			$res6servicesitemrate = $res6['servicesitemrate1'];

*/			

			$query7 = "select sum(fxamount) as servicesitemrate1 from billing_paynowservices where  billdate between '$ADate1' and '$ADate2'";

			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res7 = mysqli_fetch_array($exec7);

			$res7servicesitemrate = $res7['servicesitemrate1'];

			

			$totalservicesamount=$totalservicesamount+$res7servicesitemrate;

			$netamount=$netamount+$res7servicesitemrate;

			
		/////////////////////// SERVICES RETURNS //////////////////////////////////////
			// $query701 = "select sum(serviceamount) as servicesitemrate2 from refund_paynowservices where  billdate between '$ADate1' and '$ADate2'";

			// $exec701 = mysql_query($query701) or die ("Error in Query701".mysql_error());

			// $res701 = mysql_fetch_array($exec701);

			// $res701servicesitemratereturn = $res701['servicesitemrate2'];

			//REFUND

			$query24 = "select sum(fxamount)as servicesitemrate1 from refund_paylaterservices where billdate between '$ADate1' and '$ADate2'";
			$exec24= mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24) ;
			$res24refundserviceitemrate = $res24['servicesitemrate1'];

			$query25 = "select sum(servicetotal)as servicesitemrate1 from refund_paynowservices where billdate between '$ADate1' and '$ADate2'";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25) ;
			$res25refundserviceitemrate = $res25['servicesitemrate1'];

			$query225 = "select sum(servicesfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'";
			$exec225 = mysqli_query($GLOBALS["___mysqli_ston"], $query225) or die ("Error in Query225".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res225 = mysqli_fetch_array($exec225) ;
			$res25refundserviceitemrate1 = $res225['amount1'];

			$res701servicesitemratereturn = $res25refundserviceitemrate + $res24refundserviceitemrate + $res25refundserviceitemrate1;

			$netamount=$netamount-$res701servicesitemratereturn;
			////////////////////// SERVICES RETURNS ENDS //////////////////////////////////////
			

			$totalservicesrefundamount=$totalservicesrefundamount+$res701servicesitemratereturn;

			$totalservicesitemrate = $res7servicesitemrate ;

			

			$snocount = $snocount + 1;

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

			

			//$query9 = "select sum(totalamount) as amount1 from pharmacysales_details where `visitcode` NOT LIKE 'IP%' and `visitcode` IN (SELECT `visitcode` FROM `master_visitentry` WHERE `billtype` = 'PAY NOW') and entrydate between '$ADate1' and '$ADate2'";

			$query9 = "SELECT SUM(`fxamount`) as amount1 FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and accountname = 'CASH - HOSPITAL'";

			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res9 = mysqli_fetch_array($exec9);

			$res9pharmacyitemrate = $res9['amount1'];

			

			// $query93 = "SELECT SUM(`amount`) as amount3 FROM `billing_externalpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";

			// $exec93 = mysql_query($query93) or die ("Error in Query93".mysql_error());

			// $res93 = mysql_fetch_array($exec93);

			// $res93pharmacyitemrate3 = $res93['amount3'];

			$res93pharmacyitemrate3=0;

			

			$totalpharmacyamount=$totalpharmacyamount+$res9pharmacyitemrate+$res93pharmacyitemrate3;

			

			//$query19 = "select sum(totalamount) as amount2 from pharmacysalesreturn_details where `visitcode` NOT LIKE 'IP%' and `visitcode` IN (SELECT `visitcode` FROM `master_visitentry` WHERE `billtype` = 'PAY NOW') and entrydate between '$ADate1' and '$ADate2'";

			///////// REFUNDS PHARMACY //////////////////////////////////
			// $query19 = "SELECT SUM(`amount`) as amount2 FROM `refund_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
			// $exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());
			// $res19 = mysql_fetch_array($exec19);
			// $res19pharmacyitemratereturn = $res19['amount2'];

			//REFUND

			$query21 = "select sum(amount)as amount1 from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21) ;
			$res21refundlabitemrate = $res21['amount1'];

			$query22 = "select sum(amount)as amount1 from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundlabitemrate = $res22['amount1'];


			$query221 = "select sum(pharmacyfxamount) as amount1 from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'";
			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res221 = mysqli_fetch_array($exec221) ;
			$res22refundlabitemrate1 = $res221['amount1'];

			$query21p = "SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)";
			$exec21p = mysqli_query($GLOBALS["___mysqli_ston"], $query21p) or die ("Error in Query21p".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21p = mysqli_fetch_array($exec21p) ;
		    $res21prefundlabitemrate = $res21p['amount1'];


			$res19pharmacyitemratereturn = $res22refundlabitemrate + $res21refundlabitemrate + $res22refundlabitemrate1 + $res21prefundlabitemrate;


			$totalpharmacyrefundamount=$res19pharmacyitemratereturn;

			$totalpharmacyitemrate=$res9pharmacyitemrate-$res19pharmacyitemratereturn;

			///////// REFUNDS PHARMACY //////////////////////////////////

			$netamount=$netamount+$totalpharmacyitemrate;
			$netamount=$netamount-$res19pharmacyitemratereturn;


			$snocount = $snocount + 1;

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

			

/*			$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billdate between '$ADate1' and '$ADate2'";

			$exec10 = mysql_query($query10) or die ("Error in query10".mysql_error());

			$res10 = mysql_fetch_array($exec10);

			$res10referalitemrate = $res10['referalrate1'];

*/	

		

			$query11 = "select sum(fxamount) as referalrate1 from billing_paynowreferal where  billdate between '$ADate1' and '$ADate2'";

			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res11 = mysqli_fetch_array($exec11);

			$res11referalitemrate = $res11['referalrate1'];

			$totalreferalitemrate = $res11referalitemrate;
			

			$totalreferalamount=$totalreferalamount+$res11referalitemrate;

			$netamount=$netamount+$res11referalitemrate;

	
			//////////////////////////////// REFUNDS REFERAL /////////////////////////////
			// $query110 = "select sum(referalrate) as referalrate1 from refund_paynowreferal where billdate between '$ADate1' and '$ADate2'";

			// $exec110 = mysql_query($query110) or die ("Error in Query110".mysql_error());

			// $res110 = mysql_fetch_array($exec110);

			// $res110referalitemratereturn = $res110['referalrate1'];

			//REFUNDS

			$query26 = "select sum(referalrate)as referalrate1 from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2'";
			$exec26= mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res26 = mysqli_fetch_array($exec26) ;
			$res26refundreferalitemrate = $res26['referalrate1'];

			$query27 = "select sum(referalrate)as referalrate1 from refund_paynowreferal where billdate between '$ADate1' and '$ADate2'";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res27 = mysqli_fetch_array($exec27) ;
			$res27refundreferalitemrate = $res27['referalrate1'];
			$res110referalitemratereturn = $res27refundreferalitemrate + $res26refundreferalitemrate;

			////////////////////// REFUNDS REFERAL CLOSE ///////////////////////////////////////////
			

			$totalreferalrefundamount=$res110referalitemratereturn;

			$netamount=$netamount-$res110referalitemratereturn;

			

			$snocount = $snocount + 1;

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



			//////////////////// HOME CARE //////////////////////////
			
			 $query28 = "select sum(amount) as amount1 from billing_homecare where recorddate between '$ADate1' and '$ADate2'";
			$exec28= mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28) ;
			$totalreferalhomecare = $res28['amount1'];
			$$netamount=$netamount+$totalreferalhomecare;
			//////////////////// HOME CARE ENDS //////////////////////////

			?>

		   <?php

			//$nettotal = $res1consultationamount + $totallabitemrate + $totalradiologyitemrate + $totalservicesitemrate + $totalpharmacyitemrate + $totalreferalitemrate;

			?>

		   <?php 

			

		   			$netamount=$netamount;

					

			// $query52 = "select sum(subtotal) as referal from billing_referal where accountname = 'CASH' and billdate between '$ADate1' and '$ADate2'";

			// $exec52 = mysql_query($query52) or die ("Error in Query52".mysql_error());

			// $res52 = mysql_fetch_array($exec52);

			// $res52referal = $res52['referal'];
			$res52referal =0;				

				

			// $netamount = $netamount + $res52referal;

					

			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where  billdate between '$ADate1' and '$ADate2'";

			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res16 = mysqli_fetch_array($exec16);

			$res16servicesitemrate = $res16['servicesitemrate1'];

			

		   			$netamount=$netamount+$res16servicesitemrate;

					

			$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where billdate between '$ADate1' and '$ADate2'";

			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res15 = mysqli_fetch_array($exec15);

			$res15radiologyitemrate = $res15['radiologyitemrate1'];

			

		   			$netamount=$netamount+$res15radiologyitemrate;

					

			$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where billdate between '$ADate1' and '$ADate2'";

			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res14 = mysqli_fetch_array($exec14);

			$res14labitemrate = $res14['labitemrate1'];

			$netamount=$netamount+$res14labitemrate;

			//EXTERNAL PHARMACY
			$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where billdate between '$ADate1' and '$ADate2'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17pharmacyitemrate = $res17['amount1'];
			$netamount=$netamount+$res17pharmacyitemrate;
					 

			 $opcash=$res1consultationamount  + $res3labitemrate  +$res5radiologyitemrate 

+ $res7servicesitemrate  + $res9pharmacyitemrate  + $res11referalitemrate 	+ $totalreferalhomecare			

+ $res16servicesitemrate + $res15radiologyitemrate + $res14labitemrate + $res52referal+$res17pharmacyitemrate;	

$oprefunds=$res12refundconsultation+$res301labitemratereturn+$res501radiologyitemratereturn+$res701servicesitemratereturn+$res19pharmacyitemratereturn+$res110referalitemratereturn;	

					 

					 
	if($type=='opcash'){ 
		   ?>

             <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>No.</strong></td>

              <td align="left" valign="center" bgcolor="#FFFFFF" class="style3">Head</td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="style3">Value</td>

              <td width="21%" align="right" valign="center" bgcolor="#ecf0f5" class="style3">&nbsp;</td>

            </tr>

            

            <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '1'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsconsultation.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Consultation</a></div>              </td>

               <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalconsultationamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

           </tr>

           

           <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '2'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailslab.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Lab</a></div>              </td>

               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totallabamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

           </tr>

           

           <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '3'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">

                <div class="bodytext31"><div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsradiology.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Radiology</a></div></div>              </td>

               <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalradiologyamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

           </tr>

           

           <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '4'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsservice.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Service</a></div>              </td>

               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalservicesamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

           </tr>

           

           <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '5'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailspharmacy.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Pharmacy</a></div>              </td>

               <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalpharmacyamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

           </tr>

           

           <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '6'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsreferral.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Referral</a></div>              </td>

               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalreferalamount,2,'.',','); ?></div></td>

			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

           </tr>

           
           <tr>	
           	<tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '7'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">
                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailshomecare.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Home Care</a></div> 
            	</td>
               <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalreferalhomecare,2,'.',','); ?></div></td>
			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
           </tr>
           <tr>

              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '8'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsexternallab.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">External Lab</a></div>              </td>

               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($res14labitemrate,2,'.',','); ?></div></td>

			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

           </tr>

           <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '9'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsexternalradio.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">External Radiology</a></div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($res15radiologyitemrate,2,'.',','); ?></div></td>
			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

           </tr>
           <tr>

              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '10'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsexternalservice.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">External Services</a></div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($res16servicesitemrate,2,'.',','); ?></div></td>
			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
           </tr>
<!-- -->
	           <tr>
	              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '11'; ?></td>
	               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
	                <div class="bodytext31"><a href="viewoprevenuereportdetailsexternalpharmacy.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>"  target="_blank" >External Pharmacy</a></div> </td>
	               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($res17pharmacyitemrate,2,'.',','); ?></div></td>
				   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
	           </tr>

           

		   <!-- </tr>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php // echo '15'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31">Referal</div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php // echo number_format($res52referal,2,'.',','); ?></div></td>
			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
           </tr> -->

         <tr>
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Net Revenue:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($opcash,2,'.',','); ?></strong></td>
            </tr>
        <?php } ?>

<!--				<?php if($nettotal != 0.00) { ?>

				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

                

			    <?php 

				}?>

-->		

<!-- // op refunds ///////////// -->
<?php if($type=='oprefunds'){ ?>
 <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '1'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsrefamt.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Consultation Refund</a></div>              </td>

               <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totalrefundamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

           </tr>
 
<tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '2'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailslabreturn.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Lab Return</a></div>              </td>

               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totallabrefundamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

           </tr>
<tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '3'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsradiologyreturn.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Radiology Return</a></div>              </td>

               <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totalradiologyrefundamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

           </tr>
<tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '4'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsservicereturn.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Service Return</a></div>              </td>

               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totalservicesrefundamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

           </tr>
<tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '5'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailspharmacyreturn.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Pharmacy Return</a></div>              </td>

               <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totalpharmacyrefundamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

           </tr>
<tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '6'; ?></td>

               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">

                <div class="bodytext31"><a target="_blank" href="viewoprevenuereportdetailsreferralreturn.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Referral Refunds</a></div>              </td>

               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31">-<?php echo number_format($totalreferalrefundamount,2,'.',','); ?></div></td>

			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

           </tr>
      	 <tr>
        
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Net Revenue:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong>-<?php echo number_format($oprefunds,2,'.',','); ?></strong></td>
       </tr>
<?php } ?>
           <!-- op refunds -->

          </tbody>

        </table></table>

	   </tr>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



