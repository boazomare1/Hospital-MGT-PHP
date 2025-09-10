<?php
ob_start();
session_start();

//include ("includes/loginverify.php");

include ("db/db_connect.php");



//$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = '';

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

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$exchange_rate = 1;

$res1mrdno ='';

$query1 = "select * from master_company where auto_number = '$companyanum'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1companyname = $res1['companyname'];

$res1address1 = $res1['address1'];

$resfaxnumber1 = '';

$res1area = $res1['area'];

$res1city = $res1['city'];

$res1state = $res1['state'];

$res1emailid1= $res1['emailid1'];

$res1country = $res1['country'];

$res1pincode = $res1['pincode'];

$phonenumber1 = $res1['phonenumber1'];

$locationname = $res1['locationname'];

$locationcode = $res1['locationcode'];



// for print page

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = "cbfrmflag1"; }



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }



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

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none

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

.page_footer

{

	font-family: Times;

	text-align:center;

	font-weight:bold;

	margin-bottom:25px;

	

}


</style>

<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="2mm">

 <?php  include('print_header_pdf4.php'); ?>

    

 <page_footer>

  <div class="page_footer" style="width: 100%; text-align: center">

                     Page [[page_cu]] of [[page_nb]]

                </div>

    </page_footer>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="5" width="100%" 

            align="center" border="1">

         

            <tr>

              <td colspan="10" bgcolor="#ffffff" align="center" class="bodytext31"><strong>Account Statement</strong></td>  

            </tr>

			<tr>

              <td align="left" colspan="10" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $searchsuppliername; ?> </strong>( Report From <?php echo $ADate1; ?> To <?php echo $ADate2; ?> ) 

			  </td>  

            </tr>

			<tr>

              <td align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

              <td width="90" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>

              <td width="150" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>

                <td width="140" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Scheme</strong></td>

				<td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Mrd No</strong></td>

				<td width="90" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill number </strong></td>

              <td width="90" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>

              <td width="90" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Credit</strong></td>

				<td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Days</strong></td>

				<td width="90" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Current Balance</strong></td>

				

            </tr>

			<?php

			

			$openingbalance='0';

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

			$openingbalance='0';

			$id =$searchsuppliercode;

			$query_acc = "select * from master_accountname where id = '$id'";

				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res1 = mysqli_fetch_array($exec1);

				  $currency = $res1['currency'];

				  $cur_qry = "select * from master_currency where currency like '$currency'";

				  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $cur_qry) or die ("Error in cur_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res21 = mysqli_fetch_array($exec21);

				  $exchange_rate = $res21['rate'];

				  if($exchange_rate == 0.00)

				  {

					  $exchange_rate=1;

				  }

				$querycr1op = "SELECT SUM(`fxamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` <  '$ADate1' AND `transactiontype` = 'finalize' AND `billnumber` LIKE 'CB%'

								 UNION ALL SELECT SUM(`fxamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` <  '$ADate1' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%IPDr%'

								 UNION ALL SELECT SUM(`transactionamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` <  '$ADate1' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%AOP%'

								 UNION ALL SELECT SUM(a.`totalamountuhx`) as paylater FROM `master_transactionip` AS a JOIN master_ipvisitentry AS b ON (a.visitcode = b.visitcode) WHERE a.`accountnameid` = '$id' AND b.billtype = 'PAY LATER' AND a.`transactiondate` <  '$ADate1'

								 UNION ALL SELECT SUM(`fxamount`) as paylater FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = '$id' AND `billdate` <  '$ADate1'

								 UNION ALL SELECT SUM(`debitamount`) as paylater FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` <  '$ADate1'

								 UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%Cr.N%' AND `transactiondate` <  '$ADate1' AND `transactiontype` = 'paylatercredit'

								 UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%CRN%' AND `transactiondate` <  '$ADate1' AND `transactiontype` = 'paylatercredit'
                 					UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%DBN%' AND `transactiondate` <  '$ADate1' AND `transactiontype` = 'paylaterdebit'

								 UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `billnumber` LIKE '%IPCr%' AND `transactiondate` <  '$ADate1' AND `transactiontype` = 'paylatercredit'

								 UNION ALL SELECT SUM(-1*`amount`) as paylater FROM `paylaterpharmareturns` WHERE billdate <  '$ADate1' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$id' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)

								 UNION ALL SELECT SUM(-1*`openbalanceamount`) as paylater FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` <  '$ADate1'

								 UNION ALL SELECT SUM(-1*`transactionamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` <  '$ADate1' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'

								 union all select SUM(1*`amount`) as paylater from adhoc_debitnote where accountnameano='$searchsupplieranum'  and accountcode='$searchsuppliercode'  and consultationdate < '$ADate1' 

                 union all select SUM(-1*`amount`) as paylater from adhoc_creditnote where accountnameano='$searchsupplieranum'  and accountcode='$searchsuppliercode'  and consultationdate < '$ADate1' 

								 UNION ALL SELECT SUM(-1*`creditamount`) as paylater FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1'";

						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1op) or die ("Error in querycr1op".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($rescr1 = mysqli_fetch_array($execcr1))

						{

						$paylater = $rescr1['paylater'];

							$paylater = $paylater / $exchange_rate;

						$openingbalance += $paylater;

						}

				?>

                <tr>

			<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff"><strong>&nbsp;</strong></td>

				

              <td align="left" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>

              <td align="left" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong> Opening Balance </strong></td>

              <td align="right" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>

                <td align="right" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>

				<td align="right" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>

                <td align="right" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>

              <td align="left" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>

			 <td align="left" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>	

				<td align="right" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong><?php echo number_format($openingbalance,2,'.',','); ?></strong></td>

				</tr>

                <?php

			

			$totaldebit=0;

			$credit1=0;

			$credit2=0;

			$debit=0;

			

			

$credit4=0;

			}

			

		 

			

	$totaldebit=0;		

$debit=0;

$credit1=0;

$credit2=0;

$totalpayment=0;

$totalcredit='0';

$resamount=0;

$totalamount30 = 0;

					$totalamount60 = 0;

					$totalamount90 = 0;

					$totalamount120 = 0;

					$totalamount180 = 0;

					$totalamountgreater = 0;

			$totalamountgreater=0;

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			//$searchsuppliername1 = trim($searchsuppliername1);

		  

	  $queryunion="select groupdate,patientcode,patientname,visitcode,billnumber,particulars,subtype,subtypeano,accountname,fxamount,auto_number,transactiontype from(select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum' and accountnameid='$searchsuppliercode' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' and billnumber not like 'AOP%'

	  union all select transactiondate as groupdate, patientcode,'opening balance' as patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, transactionamount as fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'  and accountnameid='$searchsuppliercode' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%'

	   union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount, docno as auto_number,transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'   and accountnameid='$searchsuppliercode'  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'

     union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount, docno as auto_number,transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'   and accountnameid='$searchsuppliercode'  and transactiontype = 'paylaterdebit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'
	   

	    union all select b.transactiondate as groupdate,b.patientcode as patientcode,b.patientname as patientname,b.visitcode as visitcode,b.billnumber as billnumber,b.particulars as particulars,b.transactionmode as transactionmode,b.subtypeano as subtypeano,b.accountname as accountname,b.fxamount as fxamount,b.docno as docno,b.transactiontype as transactiontype FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$searchsuppliercode' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'

	   

	    union all select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, transactionmode, subtypeano, chequenumber, fxamount, docno, transactiontype from master_transactionpaylater where accountnameano = '$searchsupplieranum'  and accountnameid='$searchsuppliercode'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit')


	    

		union all select entrydate as groupdate,'' as patientcode,'' as patientname,'' as visitcode,docno as billnumber,narration as particulars,selecttype as transactionmode,selecttype as subtypeano,'' as chequenumber,transactionamount as fxamount, auto_number,vouchertype as transactiontype FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as t order by groupdate asc";

		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryunion) or die ("Error in queryunion".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res2 = mysqli_fetch_array($exec1))

		  {

		 		$resamount=0;

				$res2transactionamount=0;

				

				$transactiontype = $res2['transactiontype'];

	if($transactiontype=='finalize')

			{

				$res2transactiondate = $res2['groupdate'];

				$res2patientname = $res2['patientname'];

				$res2visitcode = $res2['visitcode'];

				$res2billnumber = $res2['billnumber'];

				$res2patientcode = $res2['patientcode'];

				$particulars = $res2['particulars'];

				if($res2patientname==''){

				$res2patientname = $particulars;

				}

				$anum = $res2['auto_number'];
				
				$querymrdno11 = "select accountfullname from master_visitentry where visitcode='$res2visitcode'
				Union all select accountfullname from master_ipvisitentry where visitcode='$res2visitcode'";
				$execmrdno11 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno11) or die ("Error in Querymrdno11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmrdno11 = mysqli_fetch_array($execmrdno11);
				$accountfullname = $resmrdno11['accountfullname'];



				$res2transactionamount = $res2['fxamount']/$exchange_rate;

				$snocount = $snocount + 1;

				$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";

				$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));

				$resmrdno1 = mysqli_fetch_array($execmrdno1);

				$res1mrdno = $resmrdno1['mrdno'];

				$res2mrdno='';

				

				$totalpayment = 0;

				

								

				$res2transactionamount = $res2transactionamount - $totalpayment;

				

				if($res2transactionamount != '0')

				{

					$t1 = strtotime($ADate2);

						$t2 = strtotime($res2transactiondate);

						$days_between = ceil(abs($t1 - $t2) / 86400);

						$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";

						$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$resmrdno1 = mysqli_fetch_array($execmrdno1);

						$res1mrdno = $resmrdno1['mrdno'];

						if($snocount == 1)

						{

							$total = $openingbalance + $res2transactionamount;

						}

						else

						{

							$total = $total + $res2transactionamount;

						}

						if($days_between <= 30)

						{

							if($snocount == 1)

							{

								$totalamount30 = $openingbalance + $res2transactionamount;

							}

							else

							{

								$totalamount30 = $totalamount30 + $res2transactionamount;

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

						

						

		 			

			//echo $cashamount;

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#FFF"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#FFF"';

			}

	

			?>

           <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res2transactiondate; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                            <?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>) <?php echo $particulars ?></td>

                <td class="bodytext31" valign="center"  align="left">

			  <?php echo $accountfullname; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res2mrdno; ?></td>

                <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res2billnumber; ?></td>

                            

              <td class="bodytext31" valign="center"  align="right">

			    <?php echo number_format($res2transactionamount,2,'.',','); ?></td>

				 <td class="bodytext31" valign="center"  align="right">

			    </td>

				<td class="bodytext31" valign="center"  align="center">

                            <?php echo $days_between; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total,2,'.',','); ?></td>

              

           </tr>

			<?php

				

			$res2transactionamount=0;

			$resamount=0;

			

			}

			$res2transactionamount=0;

			$resamount=0;

			

			if(substr($res2billnumber,0,4)=="IPDr"){

					continue;

				}

			

			}

			

			if($transactiontype=='JOURNAL')

			{

				$totalpayment = 0;

				$res2transactiondate = $res2['groupdate'];

				$res2patientname = $res2['patientname'];

				$res2visitcode = $res2['visitcode'];

				$res2billnumber = $res2['billnumber'];

				$res2patientcode = $res2['patientcode'];

				$particulars = $res2['particulars'];

				if($res2patientname==''){

				$res2patientname = $particulars;

				}

				$anum = $res2['auto_number'];

				$querymrdno11 = "select accountfullname from master_visitentry where visitcode='$res2visitcode'
				Union all select accountfullname from master_ipvisitentry where visitcode='$res2visitcode'";
				$execmrdno11 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno11) or die ("Error in Querymrdno11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmrdno11 = mysqli_fetch_array($execmrdno11);
				$accountfullname = $resmrdno11['accountfullname'];
				

				$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";

				$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));

				$resmrdno1 = mysqli_fetch_array($execmrdno1);

				$res1mrdno = $resmrdno1['mrdno'];

				$res2mrdno='';



				if($res2['subtypeano'] == 'Cr')

				{

			$query7="SELECT  -1*`creditamount` as fxamount FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Cr' and auto_number = '$anum'";

				}

				else

				{

				$query7="SELECT  `debitamount` as fxamount  FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Dr' and auto_number = '$anum'";

				}

				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res7 = mysqli_fetch_array($exec7);

				$res2transactionamount = $res7['fxamount']/$exchange_rate;				

				$res2transactionamount = $res2transactionamount - $totalpayment;

				

				if($res2transactionamount != '0')

				{

					$snocount = $snocount + 1;

					$t1 = strtotime($ADate2);

					$t2 = strtotime($res2transactiondate);

					$days_between = ceil(abs($t1 - $t2) / 86400);

					if($snocount == 1)

						{

							$total = $openingbalance + $res2transactionamount;

						}

						else

						{

							$total = $total + $res2transactionamount;

						}

						if($days_between <= 30)

						{

							if($snocount == 1)

							{

								$totalamount30 = $openingbalance + $res2transactionamount;

							}

							else

							{

								$totalamount30 = $totalamount30 + $res2transactionamount;

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

						

			//echo $cashamount;

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#FFF"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#FFF"';

			}

	

			?>

           <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res2transactiondate; ?></td> 

               <td class="bodytext31" valign="center"  align="left">

                <?php echo $res2patientname; ?></td>

                <td class="bodytext31" valign="center"  align="left">

			  <?php echo $accountfullname; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res2mrdno; ?></td>

                <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res2billnumber; ?></td>

                 

              <td class="bodytext31" valign="center"  align="right">

			    <?php echo number_format($res2transactionamount,2,'.',','); ?></td>

				 <td class="bodytext31" valign="center"  align="right">

			    </td>

			

               <td class="bodytext31" valign="center"  align="center">

                            <?php echo $days_between; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($total,2,'.',','); ?></td>

              

           </tr>

			<?php

						

			$res2transactionamount=0;

			$resamount=0;

			}

			$res2transactionamount=0;

			$resamount=0;

			if(substr($res2billnumber,0,4)=="IPDr"){

					continue;

				}

}

////////////////// CREDIT AND DEBIT ////////////////////

if($transactiontype=='paylaterdebit')
      {
    
        $respaylatercreditpayment=0;
        $res6transactiondate = $res2['groupdate'];
        $res6patientname = $res2['patientname'];
        $res6patientcode = $res2['patientcode'];
        $res6visitcode = $res2['visitcode'];
        $res6billnumber = $res2['billnumber'];
        $res6transactionmode = $res2['subtype'];
        $res6docno = $res2['auto_number'];
        $particulars = $res2['particulars'];
        $ref_no = $res2['accountname'];
		
		$querymrdno11 = "select accountfullname from master_visitentry where visitcode='$res6visitcode'
		Union all select accountfullname from master_ipvisitentry where visitcode='$res6visitcode'";
		$execmrdno11 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno11) or die ("Error in Querymrdno11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resmrdno11 = mysqli_fetch_array($execmrdno11);
		$accountfullname = $resmrdno11['accountfullname'];


        $querymrdno1 = "select mrdno from master_customer where customercode='$res6patientcode'";
        $execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resmrdno1 = mysqli_fetch_array($execmrdno1);
        $res1mrdno = $resmrdno1['mrdno'];
        $res2mrdno='';
        
        $res6transactionamount = $res2['fxamount']/$exchange_rate;
            
        $t1 = strtotime($ADate2);
        $t2 = strtotime($res6transactiondate);
        $days_between = ceil(abs($t1 - $t2) / 86400);
        
        $totalpaylatercreditpayment = 0;
        $query57 = "select patientvisitcode from consultation_lab where patientvisitcode='$res6visitcode' and labrefund='refund'";
              $exec57 = mysqli_query($GLOBALS["___mysqli_ston"], $query57) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $num57 = mysqli_num_rows($exec57);             
              if($num57 != 0)
              {
                $lab = "Lab";
              }
              else
              {
                $lab = "";
              }
              
        $query58 = "select patientvisitcode from consultation_radiology where patientvisitcode='$res6visitcode' and radiologyrefund='refund'";
              $exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $num58 = mysqli_num_rows($exec58);             
              if($num58 != 0)
              {
                $rad = "Rad";
              }
              else
              {
                $rad = "";
              }
              
        $query59 = "select patientvisitcode from consultation_services where patientvisitcode='$res6visitcode' and servicerefund='refund'";
              $exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $num59 = mysqli_num_rows($exec59);             
              if($num59 != 0)
              {
                $ser = "Services";
              }
              else
              {
                $ser = "";
              }
        $res6transactionamount = $res6transactionamount + $totalpaylatercreditpayment;
        
        if($res6transactionamount != 0)
        {
                    $snocount = $snocount + 1;

          
          if($snocount == 1)
            {
              $total = $openingbalance + $res6transactionamount;
            }
            else
            {
              $total = $total + $res6transactionamount;
            }
          
          if($days_between <= 30)
              {
                $totalamount30 = $totalamount30 + $res6transactionamount;             
              }
              else if(($days_between >30) && ($days_between <=60))
              {           
                $totalamount60 = $totalamount60 + $res6transactionamount;
              }
              else if(($days_between >60) && ($days_between <=90))
              {             
                $totalamount90 = $totalamount90 + $res6transactionamount;             
              }
              else if(($days_between >90) && ($days_between <=120))
              {             
                $totalamount120 = $totalamount120 + $res6transactionamount;             
              }
              else if(($days_between >120) && ($days_between <=180))
              {             
                $totalamount180 = $totalamount180 + $res6transactionamount;             
              }
              else
              {             
                $totalamountgreater = $totalamountgreater + $res6transactionamount;             
              }
              
              //$snocount = $snocount + 1;
              
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
         <tr <?php //echo $colorcode; ?>>
          <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
          <td class="bodytext31" valign="center"  align="left"><?php echo $res6transactiondate; ?></td>
           <td class="bodytext31" valign="center"  align="left"><?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $res6docno; ?>)- Debit Note <?php //echo $ref_no; ?></td>    
                    <td class="bodytext31" valign="center"  align="left"><?php echo $accountfullname; ?></td>  
                    <td class="bodytext31" valign="center"  align="left"><?php echo $res1mrdno; ?></td>  
                    <td class="bodytext31" valign="center"  align="left"><?php echo $res6docno; ?></td>

          <td class="bodytext31" valign="center"  align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></td>
           <td class="bodytext31" valign="center"  align="center">&nbsp;</td>
           <td class="bodytext31" valign="center"  align="center"><?php echo $days_between; ?></td>
          <td class="bodytext31" valign="center"  align="right"><?php echo number_format($total,2,'.',','); ?></td>
         </tr>
        <?php
        
        $res6transactionamount=0;
        $respaylatercreditpayment=0;
        
        }
    }


////////////////// CREDIT AND DEBIT ////////////////////

	if($transactiontype=='paylatercredit')

			{

		

				$respaylatercreditpayment=0;

				$res6transactiondate = $res2['groupdate'];

				$res6patientname = $res2['patientname'];

				$res6patientcode = $res2['patientcode'];

				$res6visitcode = $res2['visitcode'];

				$res6billnumber = $res2['billnumber'];

				$res6transactionmode = $res2['subtype'];

				$res6docno = $res2['auto_number'];

				$particulars = $res2['particulars'];

				$res6transactionamount = $res2['fxamount']/$exchange_rate;

				 $res6docno1 = explode("-", $res6docno);
      $res6docno2 = $res6docno1[0];
      if($res6docno2=='CRN'){
          $display_head='Credit Notes';
      }else{
          $display_head='Cr.Note :';
      }

						

				$t1 = strtotime($ADate2);

				$t2 = strtotime($res6transactiondate);

				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				
				$querymrdno11 = "select accountfullname from master_visitentry where visitcode='$res6visitcode'
				Union all select accountfullname from master_ipvisitentry where visitcode='$res6visitcode'";
				$execmrdno11 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno11) or die ("Error in Querymrdno11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmrdno11 = mysqli_fetch_array($execmrdno11);
				$accountfullname = $resmrdno11['accountfullname'];

				

				$totalpaylatercreditpayment = 0;


				
        $querymrdno1 = "select mrdno from master_customer where customercode='$res6patientcode'";
        $execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resmrdno1 = mysqli_fetch_array($execmrdno1);
        $res1mrdno = $resmrdno1['mrdno'];
        $res2mrdno='';

				

				$query57 = "select patientvisitcode from consultation_lab where patientvisitcode='$res6visitcode' and labrefund='refund'";

							$exec57 = mysqli_query($GLOBALS["___mysqli_ston"], $query57) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

							$num57 = mysqli_num_rows($exec57);							

							if($num57 != 0)

							{

								$lab = "Lab";

							}

							else

							{

								$lab = "";

							}

							

							$query58 = "select patientvisitcode from consultation_radiology where patientvisitcode='$res6visitcode' and radiologyrefund='refund'";

							$exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

							$num58 = mysqli_num_rows($exec58);							

							if($num58 != 0)

							{

								$rad = "Rad";

							}

							else

							{

								$rad = "";

							}

							

							$query59 = "select patientvisitcode from consultation_services where patientvisitcode='$res6visitcode' and servicerefund='refund'";

							$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

							$num59 = mysqli_num_rows($exec59);							

							if($num59 != 0)

							{

								$ser = "Services";

							}

							else

							{

								$ser = "";

							}

				$res6transactionamount = $res6transactionamount - $totalpaylatercreditpayment;

				

				if($res6transactionamount != 0)

				{

						$snocount = $snocount + 1;

					if($snocount == 1)

						{

							$total = $openingbalance - $res6transactionamount;

						}

						else

						{

							$total = $total - $res6transactionamount;

						}

					

					if($days_between <= 30)

							{

								$totalamount30 = $totalamount30 - $res6transactionamount;							

							}

							else if(($days_between >30) && ($days_between <=60))

							{						

								$totalamount60 = $totalamount60 - $res6transactionamount;

							}

							else if(($days_between >60) && ($days_between <=90))

							{							

								$totalamount90 = $totalamount90 - $res6transactionamount;							

							}

							else if(($days_between >90) && ($days_between <=120))

							{							

								$totalamount120 = $totalamount120 - $res6transactionamount;							

							}

							else if(($days_between >120) && ($days_between <=180))

							{							

								$totalamount180 = $totalamount180 - $res6transactionamount;							

							}

							else

							{							

								$totalamountgreater = $totalamountgreater - $res6transactionamount;							

							}

							

						//	$snocount = $snocount + 1;

							

				//echo $cashamount;

				$colorloopcount = $colorloopcount + 1;

				$showcolor = ($colorloopcount & 1); 

				if ($showcolor == 0)

				{

					//echo "if";

					$colorcode = 'bgcolor="#FFF"';

				}

				else

				{

					//echo "else";

					$colorcode = 'bgcolor="#FFF"';

				}

		

				?>

			   <tr <?php echo $colorcode; ?>>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

				  <td class="bodytext31" valign="center"  align="left">

				  <?php echo $res6transactiondate; ?></td>

				   <td class="bodytext31" valign="center"  align="left">

                                <?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $res6docno; ?>)- <?=$display_head;?>  <?php echo $lab; ?>&nbsp;<?php echo $rad; ?>&nbsp;<?php echo $ser; ?> <?php echo $particulars ?></td>		

                    <td class="bodytext31" valign="center"  align="left">

                            <?php echo $res1mrdno; ?></td>	

							<td class="bodytext31" valign="center"  align="left">

                            <?php echo $accountfullname; ?></td>	

                    <td class="bodytext31" valign="center"  align="left">

				  <?php echo $res6docno; ?></td>

				  <td class="bodytext31" valign="center"  align="left">

				  </td>

				  <td class="bodytext31" valign="center"  align="right">

					<?php echo number_format($res6transactionamount,2,'.',','); ?></td>

				   <td class="bodytext31" valign="center"  align="center">

                            <?php echo $days_between; ?></td>

				  <td class="bodytext31" valign="center"  align="right">

				  <?php echo number_format($total,2,'.',','); ?></td>

			   </tr>

				<?php

				

				$res6transactionamount=0;

				$respaylatercreditpayment=0;

				

				}

		}

	if($transactiontype=='pharmacycredit')

			{

		

				$respaylatercreditpayment=0;

				$res6transactiondate = $res2['groupdate'];

				$res6patientname = $res2['patientname'];

				$res6patientcode = $res2['patientcode'];

				$res6visitcode = $res2['visitcode'];

				$res6billnumber = $res2['billnumber'];

				$res6transactionmode = $res2['subtype'];

				$res6docno = $res2['auto_number'];

				$particulars = $res2['particulars'];
				
				$querymrdno11 = "select accountfullname from master_visitentry where visitcode='$res6visitcode'
Union all select accountfullname from master_ipvisitentry where visitcode='$res6visitcode'";
$execmrdno11 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno11) or die ("Error in Querymrdno11".mysqli_error($GLOBALS["___mysqli_ston"]));
$resmrdno11 = mysqli_fetch_array($execmrdno11);
$accountfullname = $resmrdno11['accountfullname'];

				//$docno  = $res2['docno'];


        $querymrdno1 = "select mrdno from master_customer where customercode='$res6patientcode'";
        $execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resmrdno1 = mysqli_fetch_array($execmrdno1);
        $res1mrdno = $resmrdno1['mrdno'];
        $res2mrdno='';

				$res6transactionamount = $res2['fxamount']/$exchange_rate;

								

				$t1 = strtotime($ADate2);

				$t2 = strtotime($res6transactiondate);

				$days_between = ceil(abs($t1 - $t2) / 86400);

				

				$totalpaylatercreditpayment = 0;

				

				

				$res6transactionamount = $res6transactionamount - $totalpaylatercreditpayment;

				

				if($res6transactionamount != 0)

				{	$snocount = $snocount + 1;

					if($snocount == 1)

						{

							$total = $openingbalance - $res6transactionamount;

						}

						else

						{

							$total = $total - $res6transactionamount;

						}

					

					

					if($days_between <= 30)

							{

								$totalamount30 = $totalamount30 - $res6transactionamount;							

							}

							else if(($days_between >30) && ($days_between <=60))

							{						

								$totalamount60 = $totalamount60 - $res6transactionamount;

							}

							else if(($days_between >60) && ($days_between <=90))

							{							

								$totalamount90 = $totalamount90 - $res6transactionamount;							

							}

							else if(($days_between >90) && ($days_between <=120))

							{							

								$totalamount120 = $totalamount120 - $res6transactionamount;							

							}

							else if(($days_between >120) && ($days_between <=180))

							{							

								$totalamount180 = $totalamount180 - $res6transactionamount;							

							}

							else

							{							

								$totalamountgreater = $totalamountgreater - $res6transactionamount;							

							}

							

					//		$snocount = $snocount + 1;

							

				//echo $cashamount;

				$colorloopcount = $colorloopcount + 1;

				$showcolor = ($colorloopcount & 1); 

				if ($showcolor == 0)

				{

					//echo "if";

					$colorcode = 'bgcolor="#FFF"';

				}

				else

				{

					//echo "else";

					$colorcode = 'bgcolor="#FFF"';

				}

		

				?>

			   <tr <?php echo $colorcode; ?>>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

				   <td class="bodytext31" valign="center"  align="left">

							<?php echo $res6transactiondate; ?></td>

							<td class="bodytext31" valign="center"  align="left">

							<?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $res6billnumber; ?>)- Cr.Note : Pharma <?php echo $particulars ?></td> 

                    <td class="bodytext31" valign="center"  align="left">

			  <?php echo $accountfullname; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res1mrdno; ?></td>

                    <td class="bodytext31" valign="center"  align="left">

				  <?php echo $res6docno; ?></td>

				  <td class="bodytext31" valign="center"  align="left">

				  </td>

				  <td class="bodytext31" valign="center"  align="right">

					<?php echo number_format($res6transactionamount,2,'.',','); ?></td>

				   

				  <td class="bodytext31" valign="center"  align="center">

                            <?php echo $days_between; ?></td>

				  <td class="bodytext31" valign="center"  align="right">

				  <?php echo number_format($total,2,'.',','); ?></td>

			   </tr>

				<?php

				$res6transactionamount=0;

				$respaylatercreditpayment=0;

				}

				}

	if($transactiontype=='PAYMENT')

		{

		$billnum=$res2['billnumber'];

$squery="select billnumber from master_transactionpaylater where accountnameano = '$searchsupplieranum'  and accountnameid='$searchsuppliercode'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit') and billnumber='$billnum'";

$exequery=mysqli_query($GLOBALS["___mysqli_ston"], $squery);

$numquery=mysqli_num_rows($exequery);

			if($numquery>0)

			

			{

				$resonaccountpayment=0;

				$res3transactiondate = $res2['groupdate'];

				$res3patientname = $res2['patientname'];

				$res3patientcode = $res2['patientcode'];

				$res3visitcode = $res2['visitcode'];

				$res3billnumber = $res2['billnumber'];

				$res3docno = $res2['auto_number'];

				$res3transactionmode = $res2['subtype'];

				$res3transactionnumber = $res2['accountname'];

				$particulars = $res2['particulars'];

				if($res3patientname=='')

						{

							$res3patientname='On Account';

						}

				

			 	$res3transactionamount = $res2['fxamount']/$exchange_rate;

				

				$t1 = strtotime($ADate2);

				$t2 = strtotime($res3transactiondate);

				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				
				$querymrdno11 = "select accountfullname from master_visitentry where visitcode='$res3visitcode'
Union all select accountfullname from master_ipvisitentry where visitcode='$res3visitcode'";
$execmrdno11 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno11) or die ("Error in Querymrdno11".mysqli_error($GLOBALS["___mysqli_ston"]));
$resmrdno11 = mysqli_fetch_array($execmrdno11);
$accountfullname = $resmrdno11['accountfullname'];



				$totalonaccountpayment = 0;

			 		$snocount = $snocount + 1;

				 

			 	 $res3transactionamount = $res3transactionamount - $totalonaccountpayment;

				if($snocount == 1)

						{

							$total = $openingbalance - $res3transactionamount;

						}

						else

						{

							$total = $total - $res3transactionamount;

						}

				if($res3transactionamount != 0)

				{

								

				if($days_between <= 30)

				{

				

				$totalamount30 = $totalamount30 - $res3transactionamount;

				

				}

				else if(($days_between >30) && ($days_between <=60))

				{

				

				$totalamount60 = $totalamount60 - $res3transactionamount;

				

				}

				else if(($days_between >60) && ($days_between <=90))

				{

				

				$totalamount90 = $totalamount90 - $res3transactionamount;

				

				}

				else if(($days_between >90) && ($days_between <=120))

				{

				

				$totalamount120 = $totalamount120 - $res3transactionamount;

				

				}

				else if(($days_between >120) && ($days_between <=180))

				{

				

				$totalamount180 = $totalamount180 - $res3transactionamount;

				

				}

				else

				{

				

				$totalamountgreater = $totalamountgreater - $res3transactionamount;

				

				}

				//$snocount = $snocount + 1;

			

				//echo $cashamount;

				$colorloopcount = $colorloopcount + 1;

				$showcolor = ($colorloopcount & 1); 

				if ($showcolor == 0)

				{

					//echo "if";

					$colorcode = 'bgcolor="#FFF"';

				}

				else

				{

					//echo "else";

					$colorcode = 'bgcolor="#FFF"';

				}

		

				?>

			   <tr <?php echo $colorcode; ?>>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

				  <td class="bodytext31" valign="center"  align="left">

				  <?php echo $res3transactiondate; ?></td>

				  <td class="bodytext31" valign="center"  align="left">

                            <?php echo $res3patientname; ?> (<?php echo $res3patientcode; ?>, <?php echo $res3visitcode; ?>, <?php echo $res3billnumber; ?>) <?php echo $particulars ?></td>

                    <td class="bodytext31" valign="center"  align="left">

			  <?php echo $accountfullname; ?></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <?php echo ''; ?></td>

                    <td class="bodytext31" valign="center"  align="left">

				  <?php echo $res3docno; ?></td>

				  

				  <td class="bodytext31" valign="center"  align="right">

					<?php //echo number_format($res3transactionamount,2,'.',','); ?></td>

				   <td class="bodytext31" valign="center"  align="right">

					<?php echo number_format(abs($res3transactionamount),2,'.',','); ?></td>

					<td class="bodytext31" valign="center"  align="center">

			  <?php echo $days_between; ?></td>

				  <td class="bodytext31" valign="center"  align="right">

				  <?php echo number_format($total,2,'.',','); ?></td>

			   </tr>

				<?php

			}

			}

			}

			}

			

			

				

				?>

               

	 

	  </table>

      <br>

            <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="66%" 

            align="center" border="1">

			<tr>

              <td width="109" class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

              <td  width="128" class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

              <td width="138" class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

				<td width="138" class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

              <td width="133" class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

				<td  width="112" class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

					<td  width="101" class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

            

				<td  width="96" class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

            

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

                bgcolor="#ffffff"><strong>Total Due</strong></td>

            </tr>

			<?php 

			

			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;

			?>

			<tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamount60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamount90,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamount120,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamount180,2,'.',','); ?></td>

            <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>

            

             	 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#FFF"><?php echo number_format($grandtotal,2,'.',','); ?></td>

            </tr>

			

		    <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

				</tr>

			  </table>
</page>
			  

			<?php

			

			?>

<?php	

 $content = ob_get_clean();



    // convert in PDF

    require_once('html2pdf/html2pdf.class.php');

    try

    {

        $html2pdf = new HTML2PDF('L', 'A3', 'en', true, 'UTF-8', array(0, 0, 0, 0));

//      $html2pdf->setModeDebug();

       // $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_accountstatement.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    } 
 
?>