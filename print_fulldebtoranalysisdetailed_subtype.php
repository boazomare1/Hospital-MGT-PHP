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

$colorloopcount2="";

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

$grandtotalamount1 = '0';

$grandtotalamount301  = '0';

$grandtotalamount601  = '0';

$grandtotalamount901 = '0';

$grandtotalamount1201  = '0';

$grandtotalamount1801  = '0';

$grandtotalamount2101  = '0';

$grandtotalamount2401  = '0';

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



$sno=1;



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="FullDebtorAnalysisDetailed.xls"');

header('Cache-Control: max-age=80');



// for Excel Export

if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }

if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }

if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }

//$sno = $sno + 2;

if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchaccountnameanum1"])) {  $searchaccountnameanum1 = $_REQUEST["searchaccountnameanum1"]; } else { $searchaccountnameanum1 = ""; }



if (isset($_REQUEST["searchsubtypeanum1"])) {  $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }



if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }

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

<style type="text/css">

<!--

body {

	

	background-color: #FFFFFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

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

<body>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1101" 

            align="left" border="1">

          <tbody>

            <tr>

              <td align="center" colspan="16" bgcolor="#ffffff" class="bodytext31"><strong>Full Debtor Analysis Detailed</strong></td>  

            </tr>

			<tr>

              <td align="center" colspan="16" bgcolor="#ffffff" class="bodytext31"><strong>Report From <?php echo $ADate1; ?> To <?php echo $ADate2; ?></strong></td>  

            </tr>

             <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="20%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>

				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Disp. Date</strong></div></td>
				<td width="16%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>

				<td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Subtype</strong></div></td>
                <td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
                <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>

                <td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member No</strong></div></td>

				 <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

              <td width="16%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Total Amount </strong></td>

              <td width="11%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> 30 days </strong></td>

              <td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>60 days </strong></div></td>

				<td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>90 days</strong></div></td>

				<td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days</strong></div></td>

              <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days </strong></div></td>

				<td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>

            </tr>

			

			<?php

			

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

			 		  $snoln=1;
	

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = trim($searchsuppliername1);

			$searchsuppliername = trim($searchsuppliername);



			if($type!='') {

				$paymentTypes = array($type);

			}

			else{

			  $query51 = "select auto_number from master_paymenttype where recordstatus <> 'deleted' and paymenttype!='CASH'";

			  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			  $j=0;

			  while($res51 = mysqli_fetch_array($exec51))

			  {

				$paymentTypes[$j]=$res51['auto_number'];

				$j=$j+1;

				

			  }



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

			 

			<tbody id="<?=$subtypeanum?>" >

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

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

			

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

		  $query42 = "select docno,fxamount,transactiondate,patientcode,patientname,visitcode,particulars from (select billnumber AS docno,fxamount,transactiondate,patientcode,patientname,visitcode,'Invoice' as particulars from master_transactionpaylater where accountnameano='$res21accountnameano' and paymenttype like '%%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' and billnumber not like 'AOP%'

		  UNION ALL select billnumber AS docno,transactionamount as fxamount,transactiondate,patientcode,patientname,visitcode,'Opening Balance'particulars from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%'

		  UNION ALL SELECT b.`docno` as docno,  (-1*b.`transactionamount`) as fxamount, b.`transactiondate` as transactiondate,b.patientcode,b.patientname,b.visitcode,b.particulars  FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2' and b.billnumber!=''

		  UNION ALL SELECT billnumber as docno, (-1*`fxamount`) as fxamount, `transactiondate` as transactiondate,patientcode,patientname,visitcode,particulars from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'

		  UNION ALL SELECT `docno` as docno, (-1*`fxamount`) as fxamount, `transactiondate` as transactiondate,accountnameid as patientcode, accountname as patientname,'' as visitcode,particulars  FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'

		  UNION ALL SELECT `docno` as docno, (1*`fxamount`) as fxamount, `transactiondate` as transactiondate,patientcode,patientname,visitcode,particulars from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'paylaterdebit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'

		  UNION ALL SELECT `docno` as docno, sum(debitamount-creditamount) as fxamount, `entrydate` as transactiondate ,ledgerid as patientcode, ledgername as patientname,'' as visitcode,narration as particulars   FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' group by docno) as t order by t.transactiondate DESC";

		  

		   $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));

		   if(mysqli_num_rows($exec42)==0)

		   {

		   continue;

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

		   
		

		   <?php

		  while($res42 = mysqli_fetch_array($exec42))

		  {

		 		$resamount=0;

				$res2transactionamount=0;

				

				$res2transactiondate = $res42['transactiondate'];

				$res2visitcode = $res42['visitcode'];

				$res2billnumber = $res42['docno'];

				$particulars = $res42['particulars'];

				$res2patientcode = $res42['patientcode'];

				

				$res2transactionamount = $res42['fxamount'];

				

				$query90 = "select customerfullname, memberno from master_customer where customercode = '$res2patientcode'";

				$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$res90 = mysqli_fetch_array($exec90);

				$customerfullname = $res90['customerfullname'];

				$mrdno = $res90['memberno'];
				if($customerfullname==''){
				$customerfullname = $res42['patientname'];
				}

				

				$totalpayment = 0;
				
				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated' and accountnameid in (select id from master_accountname where subtype='$subtypeanum')";
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				  $payment = $res98['transactionamount1'];
				  $totalpayment = $totalpayment + $payment;
				}
									
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

			

			 $colorloopcount2 = $colorloopcount2 + 1;

			$showcolor2 = ($colorloopcount2 & 1); 

			if ($showcolor2 == 0)

			{

				//echo "if";

				$colorcode2 = 'bgcolor="#FFFFFF"';

			}

			else

			{

				//echo "else";

				$colorcode2 = 'bgcolor="#cbdbfa"';

			}

			#cbdbfa

			?>

			<tr  class="acc<?=$res21accountnameano?>" >

		   <td class="bodytext31" valign="center"  align="left"><?=$snoln++;?></td>

                <td class="bodytext31" valign="center"  align="left" 

                ><?php echo $res2billnumber; ?></td>

				<?php 
			        $bill_fetch="SELECT updatedate from completed_billingpaylater where billno='$res2billnumber' ";
			        $exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $bill_fetch) or die ("Error in queryunion".mysqli_error($GLOBALS["___mysqli_ston"]));
			        $res2 = mysqli_fetch_array($exec_bill);
    			?>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
				<?php 
					if(isset($res2['updatedate'])){
					echo date("Y-m-d", strtotime($res2['updatedate']));
					}else{ echo "<p style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----</p>";
					}
				?>
				</div></td>
                    <td align="left" class="bodytext31"><?php echo $customerfullname; ?></td>

					<td align="left" class="bodytext31"><?php echo $subtype; ?></td>
					<td align="left" class="bodytext31"><?php echo $res22accountname; ?></td>

                    <td align="left" class="bodytext31"><?php echo $res2visitcode; ?></td>

                    <td align="left" class="bodytext31"><?php echo $mrdno; ?></td>

				

				<td class="bodytext31" valign="center"  align="left" 

                ><?php echo $res2transactiondate; ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($resamount,2,'.',','); ?></td>

                 <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount30,2,'.',','); ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount60,2,'.',','); ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount90,2,'.',','); ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount120,2,'.',','); ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount180,2,'.',','); ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamountgreater,2,'.',','); ?></td>        

            </tr>

			<?php

			

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

						

		$closetotalamount1 =$closetotalamount1 +$openingbalance;

		$closetotalamount301=$closetotalamount301 + $openingbalance;

		

		$totalamount1 =$totalamount1+$openingbalance;

		$totalamount301=$totalamount301 + $openingbalance;

		

	

			?>

           

           <tr  onClick="showaccount(<?=$res21accountnameano?>)">

		   <td class="bodytext31" valign="center"  align="left"></td>

                <td class="bodytext31" valign="center" colspan="8"  align="right" 

                >Total:</td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($closetotalamount301,2,'.',','); ?></td>

                 <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($closetotalamount601,2,'.',','); ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($closetotalamount901,2,'.',','); ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($closetotalamount1201,2,'.',','); ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($closetotalamount1801,2,'.',','); ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($closetotalamount2101,2,'.',','); ?></td>

                <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($closetotalamount2401,2,'.',','); ?></td>        

            </tr>

            <?php

			$closetotalamount1 = '0';

			$closetotalamount301 = '0';

			$closetotalamount601 = '0';

			$closetotalamount901 = '0';

			$closetotalamount1201 = '0';

			$closetotalamount1801 = '0';

			$closetotalamount2101 = '0';

			$closetotalamount2401 = '0';

			

			

			

			}

			 







			$totalamount30=0;

			$totalamount60=0;

			$totalamount90=0;

			$totalamount120=0;

			$totalamount180=0;

			$totalamount210=0;

			}

			}

			?>

			</tbody>

            <tr onClick="showsub(<?=$subtypeanum?>)">

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

              <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount601,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount901,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1201,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1801,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2101,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2401,2,'.',','); ?></strong></td>        

            </tr>

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

			   }

			}

			   ?>

			   <tr >

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

              <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5"><strong>Grand Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount301,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount601,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount901,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount1201,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount1801,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount2101,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount2401,2,'.',','); ?></strong></td>        

            </tr>

			<?php

			   }

			   ?>

          </tbody>

</table>

</body>

</html>

