<?php

session_start();

ob_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d ');

$time = date(' H:i:a');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}

if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}



$subtype_ano='';

$exchange_rate=1;

$currency=0;

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

$faxnumber1='';

$docno=isset($_REQUEST['docno'])?$_REQUEST['docno']:'';

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }

		

$query1 = "select * from master_company where auto_number = '$companyanum'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1companyname = $res1['companyname'];

$res1address1 = $res1['address1'];

//$resfaxnumber1 = $res1['faxnumber1'];

$res1area = $res1['area'];

$res1city = $res1['city'];

$res1state = $res1['state'];

$res1emailid1= $res1['emailid1'];

$res1country = $res1['country'];

$res1pincode = $res1['pincode'];

$phonenumber1 = $res1['phonenumber1'];

$locationname = $res1['locationname'];

$locationcode = $res1['locationcode'];



$query12 = "select * from master_accountname where auto_number = '$searchsupplieranum'";

$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

$res12 = mysqli_fetch_array($exec12);

$subtype = $res12['subtype'];

$code = $res12['id'];

$locationn = $res12['locationname'];

$searchsuppliername = $res12['accountname'];



$query122 = "select * from master_subtype where auto_number = '$subtype'";

$exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $query122) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

$res122 = mysqli_fetch_array($exec122);

 $subtypename = $res122['subtype']; 









//This include updatation takes too long to load for hunge items database.

/*include ("autocompletebuild_account2.php");*/

// for Excel Export

/*if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }

if (isset($_REQUEST["companyanum"])) {echo  $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }

if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }*/





//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }

//echo $amount;



?>



<style>

body {

	font-family: 'Arial';

	font-size: 14px;

}



.border td{

	border: 1px solid black;

	border-collapse:collapse;}

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

<table width="725"  align="center"  cellpadding="0"   cellspacing="0"  style="margin-left: 100px;">



 <tr>

          <td  align="center" colspan="7" bgcolor="#ffffff" class="bodytext31"><strong>Account Outstanding</strong></td>

  </tr>

        <tr>

          <td align="center" colspan="7" bgcolor="#ffffff" class="bodytext31"><strong> Report From <?php echo $ADate1; ?> To <?php echo $ADate2; ?> </strong> </td>

        </tr>

 

 <tr>

 	<td width="365" align="left"   

                bgcolor="#ffffff" class="bodytext31"><?php echo $searchsuppliername; ?></td>

          <td width="358" align="right"   

                bgcolor="#ffffff" class="bodytext31"><strong><?php //echo $res1companyname; ?> </strong></td>

</tr>

  <tr>

 	<td width="365" align="left"   

                bgcolor="#ffffff" class="bodytext31"><?php echo $code ?></td>

          <td width="358" align="right"   

                bgcolor="#ffffff" class="bodytext31"><strong><?php //echo $res1address1; ?>  </strong></td>

</tr>

 <tr>

 	<td width="365" align="left"   

                bgcolor="#ffffff" class="bodytext31"><strong><?php echo $locationn ?></strong></td>

          <td width="358" align="right"   

                bgcolor="#ffffff" class="bodytext31"><strong><?php //echo $resfaxnumber1; ?>  </strong></td>

</tr>

<tr>

 	<td width="365" align="left"   

                bgcolor="#ffffff" class="bodytext31"><?php echo $subtypename; ?></td>

          <td width="358" align="right"   

                bgcolor="#ffffff" class="bodytext31"><strong> <?php //echo $phonenumber1; ?>  </strong></td>

</tr>

<tr><td>&nbsp;

</td>

</tr>

</table>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="7" width="725" 

            align="center" border="1">

          <tbody>

            

          

           <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="80" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>

              <td width="120" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>

                <td width="50" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Mrd No</strong></td>
                
                <td width="13%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill number </strong></td>
                
                <td width="13%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Scheme Name </strong></td>

              <td width="75" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>

              <td width="75" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Credit</strong></td>

				<td width="30" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Days</strong></td>

				<td width="100" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Current Bal</strong></td>

            </tr>

			<?php

			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

			

			$openingbalance='0';

			$totaldebit=0;

			$credit1=0;

			$credit2=0;

			$debit=0;

			

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

								 UNION ALL SELECT SUM(-1*fxamount) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `billnumber` LIKE '%IPCr%' AND `transactiondate` <  '$ADate1' AND `transactiontype` = 'paylatercredit'

								 

								 UNION ALL SELECT SUM(-1*`openbalanceamount`) as paylater FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` <  '$ADate1'

								 UNION ALL SELECT SUM(-1*`transactionamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` <  '$ADate1' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'

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

				

              <td width="9%" align="left" valign="center"  

                bgcolor="#fff" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>

              <td width="20%" align="left" valign="center"  bgcolor="#fff" class="bodytext31"><strong> Opening Balance </strong></td>

             <td width="20%" align="right" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>
                  <td width="20%" align="right" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>
                  <td width="20%" align="right" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>

                <td width="20%" align="right" valign="center"  

                bgcolor="#fff" class="bodytext31"><strong>&nbsp;</strong></td>

              <td width="16%" align="left" valign="center"  

                bgcolor="#fff" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>

			 <td width="16%" align="left" valign="center"  

                bgcolor="#fff" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	

				<td width="16%" align="left" valign="center"  

                bgcolor="#fff" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',','); ?></strong></div></td>

				</tr>

                <?php

			

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

	   union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount,docno,transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'   and accountnameid='$searchsuppliercode'  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'

	   

	    union all select b.transactiondate as groupdate,b.patientcode as patientcode,b.patientname as patientname,b.visitcode as visitcode,b.billnumber as billnumber,b.particulars as particulars,b.transactionmode as transactionmode,b.subtypeano as subtypeano,b.accountname as accountname,b.fxamount as fxamount,b.docno as docno,b.transactiontype as transactiontype FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$searchsuppliercode' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'

	   

	    union all select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, transactionmode, subtypeano, chequenumber, fxamount, docno, transactiontype from master_transactionpaylater where accountnameano = '$searchsupplieranum'  and accountnameid='$searchsuppliercode'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit')

		

		union all select entrydate as groupdate,'' as patientcode,'' as patientname,'' as visitcode,docno as billnumber,narration as particulars,selecttype as transactionmode,selecttype as subtypeano,'' as chequenumber,transactionamount as fxamount, auto_number,vouchertype as transactiontype FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as t order by groupdate asc";

		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryunion) or die ("Error in queryunion".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res2 = mysqli_fetch_array($exec1))

		  {

		 		$resamount=0;

				$res2transactionamount=0;

				

				$transactiontype = $res2['transactiontype'];
				
			$res2visitcode = $res2['visitcode'];
			
			$querry18="select scheme_id from master_visitentry where visitcode='$res2visitcode'
			UNION ALL
			select scheme_id from master_ipvisitentry where visitcode='$res2visitcode'";
			$exe18=mysqli_query($GLOBALS["___mysqli_ston"], $querry18);
			$result18=mysqli_fetch_array($exe18);
			$scheme_id=$result18['scheme_id'];
			
			$querry28="select scheme_name from master_planname where scheme_id='$scheme_id'";
			$exe28=mysqli_query($GLOBALS["___mysqli_ston"], $querry28);
			$result28=mysqli_fetch_array($exe28);
			$scheme_name=$result28['scheme_name'];


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



				$res2transactionamount = $res2['fxamount']/$exchange_rate;

				

				$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";

				$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));

				$resmrdno1 = mysqli_fetch_array($execmrdno1);

				$res1mrdno = $resmrdno1['mrdno'];

				$res2mrdno='';

				

				$totalpayment = 0;

				

				$query98 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";

				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$num98 = mysqli_num_rows($exec98);

				while($res98 = mysqli_fetch_array($exec98))

				{

				$payment = $res98['transactionamount1']/$exchange_rate;

				$totalpayment = $totalpayment + $payment;

				}

									

				$res2transactionamount = $res2transactionamount - $totalpayment;

				

				if($res2transactionamount != '0')

				{

				$snocount = $snocount + 1;

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

              <td class="bodytext31"   align="left"><?php echo $snocount; ?></td>

			  <td class="bodytext31"   align="left">

			  <?php echo $res2transactiondate; ?></td>

               <td class="bodytext31"   align="left"> <?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>) <?php echo $particulars ?></td>

                <td class="bodytext31"   align="left">

			  <?php echo $res2mrdno; ?></td>

                <td class="bodytext31"   align="left">

			  <?php echo $res2billnumber; ?></td>
            <td class="bodytext31" valign="center"  align="left">
            
            <div class="bodytext31"><?php echo $scheme_name; ?></div></td>
                            

              <td class="bodytext31"   align="right">

			    <?php echo number_format($res2transactionamount,2,'.',','); ?></td>

				 <td class="bodytext31"   align="right">

			    </td>

				<td class="bodytext31"   align="center">

                            <?php echo $days_between; ?></td>

			  <td class="bodytext31"   align="right">

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

				$res2transactionamount = $res2transactionamount;

				

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

              <td class="bodytext31"   align="left"><?php echo $snocount; ?></td>

			  <td class="bodytext31"   align="left">

			  <?php echo $res2transactiondate; ?></td> 

               <td class="bodytext31"   align="left">

                <?php echo $res2patientname; ?></td>

                <td class="bodytext31"   align="left">

			  <?php echo $res2mrdno; ?></td>

                <td class="bodytext31"   align="left">

			  <?php echo $res2billnumber; ?></td>
              
              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $scheme_name; ?></div></td>

              <?php if($res2transactionamount > 0)

			  {

			  ?>     

              <td class="bodytext31"   align="right">

			    <?php echo number_format($res2transactionamount,2,'.',','); ?></td>

				 <td class="bodytext31"   align="right">

			    </td>

			<?php

			}

			else

			{

				?>

				 <td class="bodytext31"   align="right">

			    </td>

				 <td class="bodytext31"   align="right">

			    <?php echo number_format(-1*$res2transactionamount,2,'.',','); ?></td>

				<?php

				}

				?>

               <td class="bodytext31"   align="center">

                            <?php echo $days_between; ?></td>

			  <td class="bodytext31"   align="right">

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

						

				$t1 = strtotime($ADate2);

				$t2 = strtotime($res6transactiondate);

				$days_between = ceil(abs($t1 - $t2) / 86400);

				

				$totalpaylatercreditpayment = 0;

				$query47 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 

				$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res47 = mysqli_fetch_array($exec47))

				{

					$paylatercreditpayment = $res47['transactionamount1']/$exchange_rate;

					

					$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;

				}

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

				

				if($respaylatercreditpayment != 0)

				{

					

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

							

							$snocount = $snocount + 1;

							

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

				  <td class="bodytext31"   align="left"><?php echo $snocount; ?></td>

				  <td class="bodytext31"   align="left">

				  <?php echo $res6transactiondate; ?></td>

				   <td class="bodytext31"   align="left">

                                <?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $res6docno; ?>)- Cr.Note : <?php echo $lab; ?>&nbsp;<?php echo $rad; ?>&nbsp;<?php echo $ser; ?> <?php echo $particulars ?></td>		

                    <td class="bodytext31"   align="left">

                            <?php echo $res1mrdno; ?></td>	

                    <td class="bodytext31"   align="left">

				  <?php echo $res6docno; ?></td>
                  
                  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $scheme_name; ?></div></td>

				  <td class="bodytext31"   align="left">

				  </td>

				  <td class="bodytext31"   align="right">

					<?php echo number_format($res6transactionamount,2,'.',','); ?></td>

				   <td class="bodytext31"   align="center">

                            <?php echo $days_between; ?></td>

				  <td class="bodytext31"   align="left">

				  <?php echo number_format($total,2,'.',','); ?></td>

			   </tr>

				<?php

				

				$res6transactionamount=0;

				$respaylatercreditpayment=0;

				

				}

		}

	if($transactiontype=='pharmacycredit')

			{

		
				/*
				$respaylatercreditpayment=0;

				$res6transactiondate = $res2['groupdate'];

				$res6patientname = $res2['patientname'];

				$res6patientcode = $res2['patientcode'];

				$res6visitcode = $res2['visitcode'];

				$res6billnumber = $res2['billnumber'];

				$res6transactionmode = $res2['subtype'];

				$res6docno = $res2['auto_number'];

				$particulars = $res2['particulars'];

				//$docno  = $res2['docno'];

				

				$res6transactionamount = $res2['fxamount']/$exchange_rate;

								

				$t1 = strtotime($ADate2);

				$t2 = strtotime($res6transactiondate);

				$days_between = ceil(abs($t1 - $t2) / 86400);

				

				$totalpaylatercreditpayment = 0;

				$query47 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'pharmacycredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 

				$exec47 = mysql_query($query47) or die(mysql_error());

				while($res47 = mysql_fetch_array($exec47))

				{

					$paylatercreditpayment = $res47['transactionamount1']/$exchange_rate;

					

					$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;

				}

				

				$res6transactionamount = $res6transactionamount - $totalpaylatercreditpayment;

				

				if($respaylatercreditpayment != 0)

				{

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

							

							$snocount = $snocount + 1;

							

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

		*/

				?>

			 <!--  <tr <?php echo $colorcode; ?>>

				  <td class="bodytext31"   align="left"><?php echo $snocount; ?></td>

				   <td width="6%"class="bodytext31"   align="left">

							<?php echo $res6transactiondate; ?></td>

							<td class="bodytext31"   align="left">

							<?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $res6billnumber; ?>)- Cr.Note : Pharma <?php echo $particulars ?></td> 

                    <td class="bodytext31"   align="left">

			  <?php echo $res1mrdno; ?></td>-->

                   <!-- <td class="bodytext31"   align="left">

				  <?php echo $res6docno; ?></td>-->

				 <!-- <td class="bodytext31"   align="left">

				  </td>



				  <td class="bodytext31"   align="right">

					<?php echo number_format($res6transactionamount,2,'.',','); ?></td>

				   

				  <td class="bodytext31"   align="center">

                            <?php echo $days_between; ?></td>

				  <td class="bodytext31"   align="left">

				  <?php echo number_format($total,2,'.',','); ?></td>

			   </tr>-->
					
				<?php

				$res6transactionamount=0;

				$respaylatercreditpayment=0;

				//}

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

				if($res2patientname=='')

						{

							$res2patientname='On Account';

						}

				

			 	$res3transactionamount = $res2['fxamount']/$exchange_rate;

				

				$t1 = strtotime($ADate2);

				$t2 = strtotime($res3transactiondate);

				$days_between = ceil(abs($t1 - $t2) / 86400);



				$totalonaccountpayment = 0;

			 	$query67 = "select sum(fxamount) as transactionamount1 from master_transactionpaylater where  docno='$res3docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";

				$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res67 = mysqli_fetch_array($exec67))

				{

					$onaccountpayment = $res67['transactionamount1']/$exchange_rate;

					$totalonaccountpayment = $totalonaccountpayment + $onaccountpayment;

				}

				 

			 	 $res3transactionamount = $res3transactionamount - $totalonaccountpayment;

				if($snocount == 0)

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

				$snocount = $snocount + 1;

			

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

				  <td class="bodytext31"   align="left"><?php echo $snocount; ?></td>

				  <td class="bodytext31"   align="left">

				  <?php echo $res3transactiondate; ?></td>

				  <td class="bodytext31"   align="left">

                            <?php echo $res3patientname; ?> (<?php echo $res3patientcode; ?>, <?php echo $res3visitcode; ?>, <?php echo $res3billnumber; ?>) <?php echo $particulars ?></td>

                    <td class="bodytext31"   align="left">

			  <?php echo ''; ?></td>

                    <td class="bodytext31"   align="left">

				  <?php echo $res3docno; ?></td>
                  
                  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $scheme_name; ?></div></td>

				  

				  <td class="bodytext31"   align="right">

					<?php //echo number_format($res3transactionamount,2,'.',','); ?></td>

				   <td class="bodytext31"   align="right">

					<?php echo number_format(abs($res3transactionamount),2,'.',','); ?></td>

					<td class="bodytext31"   align="center">

			  <?php echo $days_between; ?></td>

				  <td class="bodytext31"   align="right">

				  <?php echo number_format($total,2,'.',','); ?></td>

			   </tr>

				<?php

			}

			}

			}

			}

			

			

				

				?>

				 

				 </tbody>

        </table>

		

			<table align="center" width="725" cellspacing="0" border="1" style="margin-top:15px;">

			<tr>

              <td width="103"  align="left"  

                bgcolor="#FFF">&nbsp;</td>

              <td width="88"  align="left"   

                bgcolor="#FFF">&nbsp;</td>

              <td width="107"  align="left"  

                bgcolor="#FFF">&nbsp;</td>

              <td width="88"  align="left"  

                bgcolor="#FFF">&nbsp;</td>

				<td width="107"  align="left"   

                bgcolor="#FFF">&nbsp;</td>

					<td width="103"  align="left"   

                bgcolor="#FFF">&nbsp;</td>
                <td width="103"  align="left"   

                bgcolor="#FFF">&nbsp;</td>
                <td width="103"  align="left"   

                bgcolor="#FFF">&nbsp;</td>

            

				<td width="99"  align="left"   

                bgcolor="#FFF">&nbsp;</td>

            

           	  </tr>

						<tr>

               <td   align="right" 

                bgcolor="#ffffff"><strong>30 days</strong></td>

              <td   align="right" 

                bgcolor="#ffffff"><strong>60 days</strong></td>

              <td   align="right" 

                bgcolor="#ffffff"><strong>90 days</strong></td>

				<td   align="right" 

                bgcolor="#ffffff"><strong>120 days</strong></td>

				<td   align="right" 

                bgcolor="#ffffff"><strong>180 days</strong></td>

           <td   align="right" 

                bgcolor="#ffffff"><strong>180+ days</strong></td>

           

             	 <td   align="right" 

                bgcolor="#ffffff"><strong>Total Due</strong></td>

            </tr>

			<?php 

			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater;

			?>

			<tr>

               <td   align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamount30,2,'.',','); ?></td>

              <td   align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamount60,2,'.',','); ?></td>

              <td   align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamount90,2,'.',','); ?></td>

				<td   align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamount120,2,'.',','); ?></td>

				<td   align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamount180,2,'.',','); ?></td>

            <td   align="right" 

                bgcolor="#FFF"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>

            

             	 <td   align="right" 

                bgcolor="#FFF"><?php echo number_format($grandtotal,2,'.',','); ?></td>

				

            </tr>

			

		    <tr>

              <td   align="left" 

                bgcolor="#FFF">&nbsp;</td>

              <td   align="left" 

                bgcolor="#FFF">&nbsp;</td>

              <td   align="left" 

                bgcolor="#FFF">&nbsp;</td>

              <td   align="left" 

                bgcolor="#FFF">&nbsp;</td>

				<td   align="left" 

                bgcolor="#FFF">&nbsp;</td>

					<td   align="left" 

                bgcolor="#FFF">&nbsp;</td>

        <td   align="left" 

                bgcolor="#FFF">&nbsp;</td>

					

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

        $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        // $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));

//      $html2pdf->setModeDebug();

        // $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_corporateoutstanding.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>

