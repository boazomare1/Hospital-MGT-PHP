  <?php
include ("db/db_connect.php");
ob_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="drOutstanding-list.xls"');
header('Cache-Control: max-age=80');

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$ADate2 = date('Y-m-d');



$billnumbers=array();

$billnumbers1=array();


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

$snocount1 = 0;

//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_account2.php");




if (isset($_REQUEST["searchsuppliercode"])) {  $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $ADate1 = date('Y-m-d'); }

$paymentreceiveddatefrom=$ADate1;

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $ADate1 = date('Y-m-d'); }

$paymentreceiveddateto=$ADate2;

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




		<table  border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" >

          <tbody>

            <tr bgcolor="#011E6A">

              <td  bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Outstanding List</strong></td>

              </tr>


       <tr>

        <td><table id="AutoNumber3"  

             cellspacing="0" cellpadding="4" 

            align="left" border="1">

          <tbody>

            <tr>

              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }


					


				}

				

				?>

 				<?php

				//For excel file creation.

				




				?>


</span></td>  

            </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

              <td width="25%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
                 <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill Number </strong></td>
                 <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill Type </strong></td>

				<td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Company </strong></td>

				<td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Allotted</strong></td>

              <td width="10%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Invoice Share Amt</strong></td>

              <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Balance Amt</strong></div></td>

				

            </tr>

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

				$openingcreditamount = 0;

				$openingdebittamount = 0;
                $openingbalance=0;

			
		  ?>

			
			<?php

			}

			

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

			if ($cbfrmflag1 == 'cbfrmflag1')

			{


				if(isset($searchsuppliercode) && $searchsuppliercode!=''){
				$query21 = "select doctorname,doctorcode from master_doctor where doctorcode = '$searchsuppliercode'";
				}else{
                  $query21 = "select doctorname,doctorcode from master_doctor ";
				}

				$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

				//$res21 = mysql_fetch_array($exec21);
				

				while ($res21 = mysqli_fetch_array($exec21))
				{

					$res21accountname = $res21['doctorname'];
					$searchsuppliercode2 = $res21['doctorcode'];

					//$res21accountname = $res21['doctorname'];

					

				// UNION ALL SELECT '' AS doctorname,patientname,patientcode,patientvisitcode as visitcode, accountname,docno as billnumber, consultationdate as recorddate, 0 as original_amt,amount,
				// 	sum(amount) as transactionamount, billtype, locationcode, 0 as transactionamount1, billingaccountcode as doccoa, '' as visittype from adhoc_creditnote where billingaccountcode = '$searchsuppliercode2' and consultationdate between '$ADate1' and '$ADate2'  group by visitcode

				// 	UNION ALL SELECT '' AS doctorname,patientname,patientcode,patientvisitcode as visitcode, accountname,docno as billnumber, consultationdate as recorddate, 0 as original_amt,amount,
				// 	sum(amount) as transactionamount, billtype, locationcode, 0 as transactionamount1, billingaccountcode as doccoa, '' as visittype from adhoc_debitnote where billingaccountcode = '$searchsuppliercode2' and consultationdate between '$ADate1' and '$ADate2'  group by visitcode	

					//if( $res21accountname != '')

					//{

					$totalbal=0;
					$totalout=0;

					$query2 = "SELECT description as doctorname,patientname,patientcode,visitcode,accountname,docno as billnumber,recorddate as recorddate,original_amt,amount,sum(transactionamount) as transactionamount,billtype,locationcode,sum(sharingamount) as transactionamount1,doccoa,visittype,'' as particulars12 from billing_ipprivatedoctor where doccoa = '$searchsuppliercode2' and recorddate between '$ADate1' and '$ADate2' and docno <> '' group by visitcode


					union all SELECT '' AS doctorname,patientname,patientcode,visitcode as visitcode, accountname,billnumber as billnumber, transactiondate as recorddate, 0 as original_amt, transactionamount as amount,
					sum(transactionamount) as transactionamount,'' as billtype, locationcode, 0 as transactionamount1, doctorcode as doccoa, '' as visittype,'' as particulars12  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$searchsuppliercode2' and transactiondate between '$ADate1' and '$ADate2' group by visitcode 

					 -- for ADP bills
					union all SELECT '' AS doctorname,'' as patientname,'' as patientcode,'' as visitcode, '' as accountname,docno as billnumber, transactiondate as recorddate, 0 as original_amt, transactionamount as amount,
					(transactionamount) as transactionamount,'' as billtype, locationcode, (transactionamount)  as transactionamount1, ledger_code as doccoa, '' as visittype, particulars as particulars12 from advance_payment_entry where  ledger_code='$searchsuppliercode2' and transactiondate between '$ADate1' and '$ADate2' and recordstatus<>'deleted'

					order by recorddate";

 $a=array();
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

					$rowcount2 = mysqli_num_rows($exec2);

					if($rowcount2>0){

			?>

				<tr bgcolor="#ffffff">

					<td colspan="7"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res21accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2; ?>)</strong></td>

				</tr>

				

			<?php
		
			$total = 0;

			$totalamount30 = 0;

			$totalamount60 = 0;

			$totalamount90 = 0;

			$totalamount120 = 0;

			$totalamount180 = 0;

			$totalamountgreater = 0;

			$balanceamount = 0;

			$snocount = 0;

			

			//$cashamount21 = '0.00';
				$cashamount21 = 0;

				//$cardamount21 = '0.00';
				$cardamount21 = 0;

				//$onlineamount21 = '0.00';
				$onlineamount21 = 0;

				//$chequeamount21 = '0.00';
				$chequeamount21 = 0;

				//$tdsamount21 = '0.00';
				$tdsamount21 = 0;

				//$writeoffamount21 = '0.00';
				$writeoffamount21 = 0;

				//$taxamount21 = '0.00';
				$taxamount21 = 0;



				//$totalpayment = '0.00';
				$totalpayment = 0;

				//$netpayment = '0.00';
				$netpayment = 0;

				//$balanceamount = '0.00';
				$balanceamount = 0;

				

				//$billtotalamount = '0.00';
				$billtotalamount = 0;

				//$netpayment = '0.00';
				$netpayment = 0;

				//$balanceamount = '0.00';
				$balanceamount = 0;

				$transaction_amount21 = 0;
				
			

			//$query2 = "select patientname,patientcode,visitcode,accountname,billanum,billnumber,transactiondate from doctorsharing where doctorcode = '$searchsuppliercode2' ";

			

			while ($res2 = mysqli_fetch_array($exec2))

			{

				$snocount1 = $snocount1 + 1;
				$suppliername1 = $res2['patientname'];

				$patientcode = $res2['patientcode'];

				$visitcode = $res2['visitcode'];

    

				//$billautonumber=$res2['billanum'];

				$billnumber = $res2['billnumber'];
				//$billtype = $res2['billtype'];

				$query11 = "SELECT billtype,subtype from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode'  ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$num11 =mysqli_num_rows($exec11);
				$billtype = $res11['billtype'];
				$subtype = $res11['subtype'];
				
				if($num11 ==0)
				{
				$query11 = "SELECT billtype,subtype from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$billtype = $res11['billtype'];
				$subtype = $res11['subtype'];
				}

				$subtypesql="select subtype from master_subtype where auto_number='$subtype'";
				$sexec11 = mysqli_query($GLOBALS["___mysqli_ston"], $subtypesql) or die ("Error in subtypesql".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sres11 = mysqli_fetch_array($sexec11);
				$subtype = $sres11['subtype'];


				//echo 'hi'.$billnumber.'<br>';

				$billdate = $res2['recorddate'];

				$suppliername = $res2['accountname'];

				$doctorname=$res2['doctorname'];

				if($res2['visittype']=='OP')
				  $amount_topay_doc = $res2['transactionamount'];
				else
				  $amount_topay_doc = $res2['transactionamount1'];

				$res45locationcode = $res2['locationcode'];

				$name = $res2['patientname'];


				$billtotalamount = $amount_topay_doc;

				

			
				$debit_amount=0;

				  ///////////// CASH REFUNDS/////////////
				$res45transactionamount=0;
				$query234 = "SELECT sum(sharingamount) as sharingamount, sum(transactionamount) as transactionamount, docno, percentage, pvtdr_percentage, visittype FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$searchsuppliercode2'  AND `visitcode` =  '$visitcode' group by docno, visitcode 
					union all SELECT 0 as sharingamount, sum(amount) as transactionamount, docno, '' as percentage, '' as pvtdr_percentage,'adhoc_creditnote_min' as visittype FROM `adhoc_creditnote` WHERE billingaccountcode='$searchsuppliercode2'  AND `patientvisitcode` =  '$visitcode' group by docno, patientvisitcode 
					union ALL select 0 as sharingamount, sum(transactionamount) as transactionamount,docno,'' as percentage,'' as pvtdr_percentage, 'master_transactiondoctor' as visittype  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$searchsuppliercode2' and `visitcode` =  '$visitcode'
					";
            $exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num234=mysqli_num_rows($exec234);
			while($res234 = mysqli_fetch_array($exec234)){
			 // $res234 = mysql_fetch_array($exec234);
			 $res45transactionamount_old=0;
				              $ref_doc = $res234['docno'];
				              $res45vistype = $res234['visittype'];
				              $res45transactionamount_old = $res234['sharingamount'];
				              if($res45vistype == "OP")
				              {
				              	$res45doctorperecentage = $res234['percentage'];
				              	 $res45transactionamount_old = $res234['transactionamount'];
				              }
				              if($res45vistype == "IP")
				              {
				              	$res45doctorperecentage = $res234['pvtdr_percentage'];
				              }

				              /// for CRN Bills
				              if($res45vistype == 'adhoc_creditnote_min'){
				              	 $res45transactionamount_old = $res234['transactionamount'];
				              }
				              /// for CRN Bills


				     if($res45vistype == 'master_transactiondoctor')
				        {
				           $res45transactionamount_old = $res234['transactionamount'];
				          // $taxamount = $res234['taxamount'];
				          // $amtwithouttax = $res45transactionamount_old - $taxamount;

				            $query124 = "select sum(original_amt) as original_amt,transactionamount, visittype,percentage,pvtdr_percentage,billtype as billtype2 from billing_ipprivatedoctor where doccoa='$searchsuppliercode2' and docno='$ref_doc' and transactionamount >0";
				            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				            $res124 = mysqli_fetch_array($exec124);
				            $res45billamount = $res124['original_amt'];
				            $res45vistype = $res124['visittype'];
							$billtype2 = $res124['billtype2'];
				             if($res45vistype == "OP")
				              {

				              $res45doctorperecentage = $res234['percentage'];

				              $res45transactionamount_old = $res234['transactionamount'];
				              }
				              else
				              {

				              $res45doctorperecentage = $res234['pvtdr_percentage'];

				              }
				              
				            
				        }
				        $res45transactionamount=$res45transactionamount+$res45transactionamount_old;
				    }

				      ///////////// for crn billls
						    $query_crnno = "SELECT  docno FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$searchsuppliercode2'  AND `visitcode` =  '$visitcode' group by docno, visitcode ";
		            $exec_crnno = mysqli_query($GLOBALS["___mysqli_ston"], $query_crnno) or die ("Error in Query_crnno".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_crnno=mysqli_num_rows($exec_crnno);
					 $res_crnno = mysqli_fetch_array($exec_crnno);
					 $crnnumber=$res_crnno['docno'];

					  $query_crn2 = "SELECT  docno FROM `adhoc_creditnote` WHERE billingaccountcode='$searchsuppliercode'  AND `patientvisitcode` =  '$visitcode'  ";
		            $exec_crn2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_crn2) or die ("Error in Query_crn2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_crn2=mysqli_num_rows($exec_crn2);
					 $res_crn2 = mysqli_fetch_array($exec_crn2);
					 $crnnumber2=$res_crn2['docno'];
				    ///////////// for crn billls


					  $query_adpallocaion = "SELECT  sum(transactionamount) as transactionamount,docno  from advance_payment_allocation where  doctorcode='$searchsuppliercode' and `visitcode` =  '$visitcode' and transactiondate <='$ADate2' and billnumber='$billnumber' and recordstatus='allocated'";
					$exec_adpallocaion = mysqli_query($GLOBALS["___mysqli_ston"], $query_adpallocaion) or die ("Error in Query_adpallocaion".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_adpallocaion=mysqli_num_rows($exec_adpallocaion);
					$res_adpallocaion = mysqli_fetch_array($exec_adpallocaion);
					$res45transactionamount +=$res_adpallocaion['transactionamount'];
					$adpallocaionnumber=$res_adpallocaion['docno'];


					$query_adhocdebit = "SELECT  amount as transactionamount  from adhoc_debitnote where billingaccountcode = '$searchsuppliercode2' and patientvisitcode ='$visitcode'  group by docno, patientvisitcode  ";
					$exec_adhocdebit = mysqli_query($GLOBALS["___mysqli_ston"], $query_adhocdebit) or die ("Error in Query_adhocdebit".mysqli_error($GLOBALS["___mysqli_ston"]));
					// $num_adhocdebit=mysql_num_rows($exec_adhocdebit);
					$res_adhocdebit = mysqli_fetch_array($exec_adhocdebit);
					 $amount_adhocdebit = $res_adhocdebit['transactionamount'];
         ///////////// CASH REFUNDS/////////////

				

				//$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
					 $transaction_amount21=0;
				$totalpayment = $transaction_amount21;

				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				
				//$balanceamount = $billtotalamount - $netpayment;

				//$balanceamount = $billtotalamount - $transactionamount1;
				// $balanceamount = $amount_topay_doc - $netpayment - $res45transactionamount + $amount_adhocdebit;
				 $debit_amount =  $res45transactionamount;
				$balanceamount1 =  $amount_topay_doc+$amount_adhocdebit;
				$balanceamount = $amount_topay_doc - $res45transactionamount + $amount_adhocdebit;


				// ------ for total amountallocated for the doc-----------
					$haystack21 = $billnumber;
						$needle21   = "ADP";
						if( strpos( $haystack21, $needle21 ) !== false) {
							$query_adp = "SELECT sum(transactionamount) as transactionamount FROM `advance_payment_allocation` WHERE   docno='$billnumber'  and recordstatus='allocated'  ";
							$exec_adp = mysqli_query($GLOBALS["___mysqli_ston"], $query_adp) or die ("Error in Query_adp".mysqli_error($GLOBALS["___mysqli_ston"]));
							$num_adp=mysqli_num_rows($exec_adp);
							// while($res_adp = mysql_fetch_array($exec_adp)){
							$res_adp = mysqli_fetch_array($exec_adp);
							$total_adp_transactioamount = $res_adp['transactionamount'];

							 	$num234=1;
							
							$balanceamount=$amount_topay_doc-$total_adp_transactioamount;				
							$res45transactionamount =  '-1'*$balanceamount;
							$balanceamount1 =  '-1'*$amount_topay_doc;
							// $debit_amount =  $res45transactionamount;
							$debit_amount =  0;
						}
				// ------ for total amountallocated for the doc-----------	


				if(in_array($billnumber,$a))
				    continue;
				else if($balanceamount>=0)
					$a[]=$billnumber;

				if($balanceamount1==0){
						continue;
				}

				if($snocount1 == 1)	
				{
					$total = $openingbalance + $balanceamount1 - $debit_amount;
					
				}
				else
				{
					$total = $total + $balanceamount1 - $debit_amount;
				}
				
				

				//$billtotalamount = number_format($billtotalamount, 2, '.', '');

				//$netpayment = number_format($netpayment, 2, '.', '');

				//$balanceamount = number_format($balanceamount, 2, '.', '');

				

				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;



				

			$billdate = substr($billdate, 0, 10);

			$date1 = $billdate;



			$dotarray = explode("-", $billdate);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));



			/*$billtotalamount = number_format($billtotalamount, 2, '.', '');

			$netpayment = number_format($netpayment, 2, '.', '');

			$balanceamount = number_format($balanceamount, 2, '.', '');
*/
			

			$date1 = $date1;

			$date2 = date("Y-m-d");  

			$diff = abs(strtotime($date2) - strtotime($date1));  

			$days = floor($diff / (60*60*24));  

			$daysafterbilldate = $days;

			

			//$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber' and acc_status <> 'deallocated' order by auto_number desc";

			$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber'  and recordstatus = ''  and acc_status <> 'deallocated' and doctorcode = '$searchsuppliercode2' order by auto_number desc";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exec31);

			 $numb1=mysqli_num_rows($exec31);

			 //$totalnumb=$totalnumb+$numb1;

			 

			// $lastpaymentdate = $res31['transactiondate'];
			$lastpaymentdate = $res2['recorddate'];

			$lastpaymentdate = substr($lastpaymentdate, 0, 10);


			if ($lastpaymentdate != '')

			{

				$date1 = $lastpaymentdate;

				$date2 = date("Y-m-d");  

				$diff = abs(strtotime($date2) - strtotime($date1));  

				$days = floor($diff / (60*60*24));  

				$daysafterpaymentdate = $days;

				

				$dotarray = explode("-", $lastpaymentdate);

				$dotyear = $dotarray[0];

				$dotmonth = $dotarray[1];

				$dotday = $dotarray[2];

				$lastpaymentdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

				

			}

			else

			{

				$daysafterpaymentdate = '';

				$lastpaymentdate = '';

			}			

			//echo $billtotalamount;

		if ($balanceamount == 0)

			{

				$res2transactionamount = 0;

			}

			else

			{

				$res2transactionamount = $balanceamount;

			} 

			

 			if($balanceamount!=0){

			
			 $query33 = "select transactionamount as debit,transactiondate  from master_transactiondoctor where billnumber = '$billnumber' and doctorcode='$searchsuppliercode' order by transactiondate,auto_number";

			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num33=mysqli_num_rows($exec33);

			$inner_sno = 0;
			$debit_total =0;
			$totalat=$total;
			$alloted_status ='';

			//$debit_amt = 0;

			while($res33 = mysqli_fetch_array($exec33))

			{
				$debit_amt = $res33['debit'];
				$totalat = $totalat - $debit_amt;
			}
            if(isset($billtype2) && $billtype2!='')
				$billtype2=$billtype2;
			else
				$billtype2=$billtype;


      
			if($billtype2 == 'PAY LATER')
			   {
			   		 $transc_amt = 0;
					$query27 = "select sum(billbalanceamount) as billbalanceamount from master_transactionpaylater where billnumber='$billnumber' and (recordstatus='allocated' || recordstatus='') and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype='PAYMENT'";


					$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));

					$num2 = mysqli_num_rows($exec27);

					if($num2==0){
						$alloted_status = "No";
					}else{

						$res27 = mysqli_fetch_array($exec27);
						$transc_amt_bal = $res27['billbalanceamount'];
						if($transc_amt_bal==null || $transc_amt_bal=="")
						{
						 $alloted_status = "No";
						}
						elseif($transc_amt_bal>0 )
						{
						 $alloted_status = "Partly";
						}
						else
						{
						 $alloted_status = "Fully";
						}
					
					}
				}


					if($billtype2 == 'PAY NOW' || strpos( $billnumber, "CF-" ) !== false)
					{
					   $alloted_status = "Yes";
					}

			//  $totalat=0;
			$t1 = strtotime($ADate2);
			$t2 = strtotime($billdate);
			$days_between = ceil(abs($t1 - $t2) / 86400);
			$snocount = $snocount + 1;

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



			//if($balanceamount !='0.00'){

			//echo $balanceamount;

			//$total =$total + $balanceamount;

			

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
			if($balanceamount != 0) {
			// if($res45transactionamount > 0) {
			// if(1) {
				?>

				<tr >

				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

				   <td class="bodytext31" valign="center"  align="left">

					<div class="bodytext31"><?php echo $billdate; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

					<div class="bodytext31">
						<?php
						$haystack = $billnumber;
						$needle   = "ADP";
						if( strpos( $haystack21, $needle21 ) !== false) {
							echo "Payment (".$res2['particulars12']." )";
						}else{
					?>
						<?php echo $name; ?> (<?php echo $patientcode; ?>, <?php echo $visitcode; ?>)
						<?php } ?>

					</div></td>
					 <td class="bodytext31" valign="center"  align="left">
					 	    	<?php
                 	$haystack = $billnumber;
		$needle   = "IPFCA";
		$url = "";
		if( strpos( $haystack, $needle ) !== false) {
		   
		    $url = "print_creditapproval.php?locationcode=$res45locationcode&&patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$billnumber";
		}
		else
		{
			$needle   = "IPF";
			if( strpos( $haystack, $needle ) !== false) {
		   
		    $url = "print_ipfinalinvoice1.php?locationcode=$res45locationcode&&patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$billnumber";
			}
			else
			{
				$needle   = "CB";
				if( strpos( $haystack, $needle ) !== false) {
		  
		    	$url = "print_paylater_detailed.php?locationcode=$res45locationcode&&billautonumber=$billnumber";
				}
				else
				{
					$needle   = "CF";
					if( strpos( $haystack, $needle ) !== false) {
			  
			    	$url = "print_consultationbill_dmp4inch1.php?locationcode=$res45locationcode&&billautonumber=$billnumber";
					}
					else
						{
							// $needle   = "OPR";
							// if( strpos( $haystack, $needle ) !== false) {
					  
					  //   	$url = "print_consultationrefund_dmp4inch1.php?locationcode=$res45locationcode&&billautonumber=$billnumber";
							// }
							// else
							// {
								//$needle   = "CB";
							// }
						}
				}
			}
		}

						$needle   = "OPR";
						$url1='';

							if( strpos( $ref_doc, $needle ) !== false) {
					  
					    	$url1 = "print_consultationrefund_dmp4inch1.php?locationcode=$res45locationcode&&billautonumber=$ref_doc";
							}
                 	 ?>
					<div class="bodytext31">
						 <?php
						$haystack = $billnumber;
						$needle   = "ADP";
						if( strpos( $haystack21, $needle21 ) !== false) {
							  echo $billnumber;  
						}else{ ?>
						 <?php echo $billnumber; ?> 
						<?php  } ?>

						<?php if($num234>0){ ?>
							&nbsp;&nbsp;<?php echo $ref_doc; ?> 
						<?php }if($num_crnno>0){ ?>
							&nbsp;&nbsp;<?php echo $crnnumber; ?> 	
						<?php } if($num_crn2>0){ ?>
							&nbsp;&nbsp;<?php echo $crnnumber2; ?>	 
					<?php } if($num_adpallocaion>0){ ?>
							&nbsp;&nbsp;<?php echo $adpallocaionnumber; ?>	
						<?php }  ?>
						
					</div></td>
					 <td class="bodytext31" valign="center"  align="left">

					<div class="bodytext31"><?php echo $billtype; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">

					<div class="bodytext31"><?php echo $subtype; ?></div></td>

					<td class="bodytext31" valign="center"  align="left">

					<div class="bodytext31"><?php echo $alloted_status; ?></div></td>
            
				  <td class="bodytext31" valign="center"  align="right">  
				  <?php
				  $totalbal=$totalbal+$balanceamount1;
				  echo number_format($balanceamount1,2,'.',','); ?>
				  	 
				  	<?php // echo number_format($res45transactionamount,2,'.',',');
						?>
					</td>

				  <td class="bodytext31" valign="center"  align="right">
					<div align="right"> <?php 
						$haystack = $billnumber;
						$needle   = "ADP";
						if( strpos( $haystack, $needle ) !== false) {
								$totalout=$totalout+($res45transactionamount);
				           echo number_format($res45transactionamount,2,'.',',');  

						}else{
					if($num234>0 and $res45transactionamount>0){ ?>
							<?php 
							$totalout=$totalout+($balanceamount1-$res45transactionamount);
				           echo number_format($balanceamount1-$res45transactionamount,2,'.',','); ?>
						<?php }else{
						     $totalout=$totalout+$balanceamount1;
							echo number_format($balanceamount1,2,'.',',');
						}

						} ?>  
					</div></td>

					

			   </tr>

			<?php
					}
				

					}

					//$cashamount21 = '0.00';
				$cashamount21 = 0;

				//$cardamount21 = '0.00';
				$cardamount21 = 0;

				//$onlineamount21 = '0.00';
				$onlineamount21 = 0;

				//$chequeamount21 = '0.00';
				$chequeamount21 = 0;

				//$tdsamount21 = '0.00';
				$tdsamount21 = 0;

				//$writeoffamount21 = '0.00';
				$writeoffamount21 = 0;

				//$taxamount21 = '0.00';
				$taxamount21 = 0;



				//$totalpayment = '0.00';
				$totalpayment = 0;

				//$netpayment = '0.00';
				$netpayment = 0;

				//$balanceamount = '0.00';
				$balanceamount = 0;

				

				//$billtotalamount = '0.00';
				$billtotalamount = 0;

				//$netpayment = '0.00';
				$netpayment = 0;

				//$balanceamount = '0.00';
				$balanceamount = 0;

				

				//$billstatus = '0.00';

				$billstatus = 0;

				$transaction_amount21 = 0;

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

                bgcolor="#ecf0f5"></td>

				 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalbal,2,'.',',');?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalout,2,'.',',');?></td>

              
            </tr>

			<?php } 
			}
?>

				 </tbody>

        </table>
			  

			<?php


			//}

			}

			?>

   </tr>       
</table>