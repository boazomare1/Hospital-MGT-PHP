<?php

session_start();

error_reporting(0);

include ("includes/loginverify.php");

include ("db/db_connect.php");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="FullCreditorAnalysisSummary.xls"');
header('Cache-Control: max-age=80');

$sno1=0;

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');


$totalamount1_final =0;
$totalamount301_final =0;
$totalamount601_final =0;
$totalamount901_final =0;
$totalamount1201_final =0;
$totalamount1801_final =0;
$totalamount2101_final =0;
$totalamount2401_final =0;


$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$searchsuppliername = "";

$searchsuppliername1 = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$totalamount = "0.00";

$totalamount30 = "0.00";

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

$totalamount2401 = "0.00";

//This include updatation takes too long to load for hunge items database.

//include("autocompletebuild_subtype.php");



//include ("autocompletebuild_account3.php");





if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

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

if (isset($_REQUEST["accountssub"])) { $accountssubanum = $_REQUEST["accountssub"]; } else { $accountssubanum = ""; }		// by Kenique 22 Nov 2018



?>


 
 


 


    	 <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="12" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">

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

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					//$transactiondatefrom = $_REQUEST['ADate1'];

					//$transactiondateto = $_REQUEST['ADate2'];

					

					//$paymenttype = $_REQUEST['paymenttype'];

					//$billstatus = $_REQUEST['billstatus'];

					

					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";

				}

				else

				{

					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";

				}

				?>

 				<?php

				//For excel file creation.

				

				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.

				$filename1 = "print_paymentgivenreport1.php?$urlpath";

				$fileurl = $applocation1."/".$filename1;

				$filecontent1 = @file_get_contents($fileurl);

				

				$indiatimecheck = date('d-M-Y-H-i-s');

				$foldername = "dbexcelfiles";

				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');

				fwrite($fp, $filecontent1);

				fclose($fp);



				?>

              <script language="javascript">

				function printbillreport1()

				{

					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

				}

				function printbillreport2()

				{

					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"

				}

				</script>

              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />

&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->

</span></td>  

            </tr>

             <tr><td colspan="13" align="center"><b> Full Creditor Analysis Summary</b></td></tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="22%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name</strong></div></td>

				<td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> </strong></div></td>

              

              <td width="10%" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Invoice Amt</strong></div></td>

				<td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bal. Amt</strong></div></td>

				<td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>30 days</strong></div></td>

              <td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>60 days </strong></div></td>

				<td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>90 days </strong></div></td>

			<td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days </strong></div></td>

				<td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days </strong></div></td>

				<td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>

			  </tr>

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

			

			$arraysupplier = $searchsuppliername;

			$arraysuppliername = $arraysupplier;

			$searchsuppliername = trim($arraysuppliername);

			$arraysuppliercode = trim($_REQUEST['searchsuppliercode']);

			$searchsuppliername = trim($searchsuppliername);

			

			if($arraysuppliercode == '') {

			$query212 = "select suppliercode,suppliername from master_transactionpharmacy where transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by suppliername order by suppliername desc ";

			} else {

			$query212 = "select suppliercode,suppliername from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by suppliername order by suppliername desc ";

			}

			$exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $num_main=mysqli_num_rows($exec212);
			while ($res212 = mysqli_fetch_array($exec212))

			{

				// echo 1;

			$res21suppliername = $res212['suppliername'];

			$res21suppliercode = $res212['suppliercode'];

			// if($num_main==0){
			// 	$res21suppliername = $searchsuppliername;
			// 	$res21suppliercode = $arraysuppliercode;
			// }

			

			$query222 = "select * from master_accountname where id = '$res21suppliercode' and recordstatus <>'DELETED' ";

			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res222 = mysqli_fetch_array($exec222);

			$res22accountname = $res222['accountname'];
			$res22accountautonum = $res222['auto_number'];
			$id = $res222['id'];



			if( $res21suppliername != '')

			{

				//////////////// for opening Balance //////////
				$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
			$invoicevalue1=0;
			$invoicevalue2=0;
				// $querycr1op = "SELECT sum(-1*`transactionamount`) as payables, suppliercode as code, CONCAT('Payment - ',remarks) as name, docno as docno, transactiondate as date_entry,chequenumber as chequenum FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND (`docno` LIKE 'SP%' or `docno` LIKE 'SPE%') AND `transactiondate` < '$ADate1'  and billnumber NOT LIKE 'PV%'

						 

				// 		 UNION ALL SELECT sum(-1*`totalamount`) as payables,suppliercode as code, CONCAT('Return - ',suppliername) as name, billnumber as docno, entrydate as date_entry,typeofreturn as chequenum FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND billnumber NOT LIKE 'SPCA%' AND `entrydate` < '$ADate1'

						 

				// 		 UNION ALL SELECT sum(-1*`debitamount`) as payables, locationcode as code, CONCAT('Journal - ',ledgername) as name, docno as docno, entrydate as date_entry,vouchertype as chequenum FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` < '$ADate1'

						 

				// 		 UNION ALL SELECT sum(-1*`transactionamount`) as payables,expensecoa as code, remarks as name, docnumber as docno, transactiondate as date_entry, chequenumber as chequenum FROM `expensesub_details` WHERE `expensecoa` = '$id' AND transactionmode <> 'ADJUSTMENT' AND transactiondate < '$ADate1'

						

				// 		 UNION ALL SELECT sum(-1*`openbalanceamount`) as payables, docno as code, CONCAT('Opening Balance as of may 1st - ',accountname) as name, docno as docno, entrydate as date_entry, 'Opening Balance' as chequenum FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` < '$ADate1'

						

				// 		UNION ALL SELECT sum(`openbalanceamount`) as payables, docno as code, CONCAT('Opening Balance as of may 1st - ',accountname) as name, docno as docno, entrydate as date_entry, 'Opening Balance' as chequenum FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` < '$ADate1' and payablestatus ='1'

						

				// 		 UNION ALL SELECT sum(`transactionamount`) as payables, suppliercode as code, CONCAT('Purchase - ',suppliername) as name, billnumber as docno, transactiondate as date_entry,chequenumber as chequenum FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `billnumber` NOT LIKE 'SUPO%' AND `transactiontype` = 'PURCHASE' AND `transactiondate` < '$ADate1'  and billnumber NOT LIKE 'PV%'

				// 		 UNION ALL SELECT sum(`creditamount`) as payables, locationcode as code, CONCAT('Journal - ',ledgername) as name, docno as docno, entrydate as date_entry,vouchertype as chequenum FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` < '$ADate1'

				// 		 UNION ALL SELECT sum(`totalamount`) as payables,suppliercode as code, CONCAT('Payable Credit - ',suppliername) as name, billnumber as docno, entrydate as date_entry,typeofreturn as chequenum FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND billnumber LIKE 'SPCA%' AND `entrydate` < '$ADate1'

				// 		 UNION ALL SELECT sum(-total_amount) as payables, '' as code, '' as name, approve_id as docno, date(created_at) as date_entry, '' as chequenum  from supplier_debit_transactions where supplier_id = '$id' and date(created_at) < '$ADate1'
 
				// 		 ";

				// 		$execcr1 = mysql_query($querycr1op) or die ("Error in querycr1op".mysql_error());

				// 		while($rescr1 = mysql_fetch_array($execcr1))

				// 		{

				// 			$payables = $rescr1['payables'];
				// 			$entrydate = $rescr1['date_entry'];
				// 			 $rescr1docno = $rescr1['docno'];
				// 			// $payables = $payables / $exchange_rate;
				// 		    $openingbalance += $payables;


						    

							// $total_allocated_amount=0;
			    //         	$query3 = "SELECT * from master_transactionpharmacy where  docno = '$rescr1docno' and recordstatus = 'allocated' order by auto_number desc"; 
							// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
							// $num=mysql_num_rows($exec3);
							// while ($res3 = mysql_fetch_array($exec3)) {  $total_allocated_amount +=$res3['transactionamount']; }
							// if($total_allocated_amount!=0){
							// 	// echo $total_allocated_amount;
							//    $pending_amountfromdb=$payables+$total_allocated_amount;
							// }


						// 	$query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$id' and billnumber = '$rescr1docno'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate < '$ADate1'";
						// 	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
						// 	$res3 = mysql_fetch_array($exec3);
						// 	$res3transactionamount = $res3['transactionamount1'];

						// 	$res4return = 0;
						// 	$query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$id' and grnbillnumber = '$rescr1docno' and entrydate < '$ADate1'
						// 		UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$id' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$rescr1docno' and transactiontype = 'PURCHASE' and transactiondate < '$ADate1' )";
						// 	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
						// 	while($res4 = mysql_fetch_array($exec4))
						// 	{
						// 		$res4return += $res4['totalreturn'];
						// 	}
						// 	  $invoicevalue1 +=  $payables - ($res3transactionamount + $res4return);
						// 	 // echo $invoicevalue1 +=  $payables - ($res3transactionamount + $res4return)-$total_allocated_amount+$pending_amountfromdb;
						// }
						

					$query1 = "SELECT billdate as date_entry,totalamount as payables, billnumber as billnumber from master_purchase where suppliercode = '$id' and recordstatus <> 'deleted' and billdate < '$ADate1'   group by billnumber
					 UNION ALL SELECT date(created_at) as date_entry, (-1*total_amount) as payables,  approve_id as billnumber from supplier_debit_transactions where supplier_id = '$id' and date(created_at) < '$ADate2'
					  ";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num1 = mysqli_num_rows($exec1);
					while($res1 = mysqli_fetch_array($exec1))
					{
					$entrydate  = $res1['date_entry'];
					$rescr1docno = $res1['billnumber'];
					$payables = $res1['payables'];
					$openingbalance += $payables;


					$query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$id' and billnumber = '$rescr1docno'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate <= '$ADate2'";
							$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res3 = mysqli_fetch_array($exec3);
							$res3transactionamount = $res3['transactionamount1'];
							
							$res4return = 0;
							$query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$id' and grnbillnumber = '$rescr1docno' and entrydate <= '$ADate2'
								UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$id' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$rescr1docno' and transactiontype = 'PURCHASE' and transactiondate <= '$ADate2' )";
							$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($res4 = mysqli_fetch_array($exec4))
							{
								$res4return += $res4['totalreturn'];
							}

								/////// for grns///////////////////////////////////
									$total_allocated_amount=0;
									// $query3 = "SELECT * from master_transactionpharmacy where  billnumber = '$rescr1docno' and recordstatus = 'allocated' and transactiondate < '$ADate1' order by auto_number desc";
									// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
									// while ($res3 = mysql_fetch_array($exec3))
									// {
									// $total_allocated_amount +=$res3['transactionamount'];
									// }
									/////////// for sdbts /////////////////
									$total_allocated_amount2=0;
					            	 $query3 = "SELECT * from master_transactionpharmacy where  docno = '$rescr1docno' and recordstatus = 'allocated' and transactiondate <= '$ADate2' order by auto_number desc"; 
									$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
									$num123=mysqli_num_rows($exec3);
									while ($res3 = mysqli_fetch_array($exec3)) { $total_allocated_amount2 +=$res3['transactionamount']; }
									// echo number_format($debitamount_sbdt-$total_allocated_amount,2,'.',',');
									if($num123>0){
											 $pending_amountfromdb=$payables+$total_allocated_amount2;
										}
									///////////////////////////////////
										if($num123>0){
											 $invoicevalue1 =  ($res3transactionamount + $res4return)-$total_allocated_amount+$pending_amountfromdb;
							  				$invoicevalue2 +=  ($res3transactionamount + $res4return)-$total_allocated_amount+$pending_amountfromdb;

										}else{
							  				$invoicevalue1 =  $payables - ($res3transactionamount + $res4return)-$total_allocated_amount;
							  				$invoicevalue2 +=  $payables - ($res3transactionamount + $res4return)-$total_allocated_amount;
											}


							  $t1 = strtotime($entrydate);
					    	  $t2 = strtotime($ADate2);
							  $days_between = ceil(abs($t2 - $t1) / 86400);
							    if($days_between<30) { $totalamount30=$totalamount30+$invoicevalue1; }
								if($days_between>30 && $days_between<=60) { $total60=$total60+$invoicevalue1; }
								if($days_between>60 && $days_between<=90){ $total90=$total90+$invoicevalue1; }
								if($days_between>90 && $days_between<=120) { $total120=$total120+$invoicevalue1; }
								if($days_between>120 && $days_between<=180) { $total180=$total180+$invoicevalue1; }
								if($days_between>180){ $total210=$total210+$invoicevalue1; }

									
								}


									// $totalamount1=$totalamount1+$payables;
									// $totalamount301=$totalamount301+$invoicevalue1;

									$totalamount1=$totalamount1+$openingbalance;
									$totalamount301=$totalamount301+$invoicevalue2;
									$totalamount601=$totalamount601+$totalamount30;
									$totalamount901=$totalamount901+$total60;
									$totalamount1201=$totalamount1201+$total90;
									$totalamount1801=$totalamount1801+$total120;
									$totalamount2101=$totalamount2101+$total180;
									$totalamount2401=$totalamount2401+$total210;
							 
 


					// $snocount = $snocount + 1;
				//////////////// for opening Balance //////////

			?>


			 

            <tr  >
            		<td colspan="1" bgcolor="#ffffff" valign="center"  align="left"><strong><?php echo $sno1+=1;?></strong></td>
            		<td colspan="1" bgcolor="#ffffff" valign="center"  align="left"><strong><?php echo strtoupper($res22accountname);?></strong></td>
            		 <td colspan="1" bgcolor="#ffffff" valign="center"  align="left">Opening Balance :  </td>
            		 <!-- <td bgcolor="#ffffff" valign="center"  align="left">&nbsp;</td>
            		 <td bgcolor="#ffffff" valign="center"  align="left">&nbsp;</td>
            		 <td bgcolor="#ffffff" valign="center"  align="left">&nbsp;</td> -->
            		 <td bgcolor="#ffffff" valign="center"  align="right"> <?php echo number_format($openingbalance,2,'.',','); ?></td>
            		 <td bgcolor="#ffffff" valign="center"  align="right"> <?php echo number_format($invoicevalue2,2,'.',','); ?></td>
            		 <td bgcolor="#ffffff" valign="center"  align="right"><?php echo number_format($totalamount30,2,'.',','); ?></td>
            		 <td bgcolor="#ffffff" valign="center"  align="right"><?php echo number_format($total60,2,'.',','); ?></td>
            		 <td bgcolor="#ffffff" valign="center"  align="right"><?php echo number_format($total90,2,'.',','); ?></td>
            		 <td bgcolor="#ffffff" valign="center"  align="right"><?php echo number_format($total120,2,'.',','); ?></td>
            		 <td bgcolor="#ffffff" valign="center"  align="right"><?php echo number_format($total180,2,'.',','); ?></td>
            		 <td bgcolor="#ffffff" valign="center"  align="right"><?php echo number_format($total210,2,'.',','); ?></td>

           </tr>

              

            </tr> 
            <tbody >


			<?php

			
			$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
			

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = trim($searchsuppliername1);

			$res21suppliername = trim($res21suppliername);

		  

		  //$query1 = "select * from master_transactionpharmacy where suppliercode = '$res21suppliercode' and transactiondate between '$ADate1' and '$ADate2' group by billnumber order by suppliername";

		   $query1 = "select * from master_purchase where suppliercode = '$res21suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2'  and companyanum = '$companyanum' group by billnumber order by billdate asc";

		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		   $num1 = mysqli_num_rows($exec1);

		  while($res1 = mysqli_fetch_array($exec1))

		  {

		  $res1suppliername = $res1['suppliername'];

		  $res1suppliercode = $res1['suppliercode'];

		  $res1transactiondate  = $res1['billdate'];

		  $res1billnumber = $res1['billnumber'];

		  $res2transactionamount = $res1['totalamount'];

		  $supplierbillnumber = $res1['supplierbillnumber'];

		  /*$res1patientname = $res1['patientname'];

		  $res1visitcode = $res1['visitcode'];*/

		  

		  $query2 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2'";

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res2 = mysqli_fetch_array($exec2);

		  //$res2transactionamount = $res2['transactionamount1'];

		  

		  $query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate between '$ADate1' and '$ADate2'";

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3 = mysqli_fetch_array($exec3);

		   $res3transactionamount = $res3['transactionamount1'];

		  

		  $res4return = 0;

		  $query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$ADate1' and '$ADate2'

		  UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2')";

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

		  {

		  	$res4return += $res4['totalreturn'];

		  }

		  

		  /*$query4 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'paylatercredit'";

		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

		  $res4 = mysql_fetch_array($exec4);

		  $res4transactionamount = $res4['transactionamount'];

		  

		  $query5 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit'";

		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

		  $res5 = mysql_fetch_array($exec5);

		  $res5transactionamount = $res5['transactionamount'];*/

		  ///////////////// sdbt allocated for grn numbers//////////
		  $total_allocated_amount=0;
		  // $query3 = "SELECT * from master_transactionpharmacy where  billnumber = '$res1billnumber' and recordstatus = 'allocated' order by auto_number desc";
				// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
				// // $num=mysql_num_rows($exec3);
				// // 	if($num>0){
				// while ($res3 = mysql_fetch_array($exec3))
				// {
				// 		$total_allocated_amount +=$res3['transactionamount'];
				// }

		  ///////////////// sdbt allocated for grn numbers//////////
		  ///////////////// SPE  for grn numbers//////////
				$res5transactionamount_spe=0;
			// 	$query5 = "select * from master_transactionpharmacy where billnumber = '$res1billnumber' and transactionmodule = 'PAYMENT'  and recordstatus <> 'deallocated'  order by transactiondate desc";
			// 	// $query5 = "select * from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT'  and recordstatus <> 'deallocated'  order by transactiondate desc";
		 //  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		 //  $num5 = mysql_num_rows($exec5);
		 //  if($num5 > 0)
		 //  {
			//   while($res5 = mysql_fetch_array($exec5))
			//   {
			// 	  $res5billnumber = $res5['billnumber'];
			// 	  $res5openingbalance = $res5['openingbalance'];
			// 	  $res5docnumber = $res5['docno'];
			// 	  $res5transactionamount = $res5['transactionamount'];
			// 	  $res5transactionamount_spe += $res5['transactionamount'];
			// 	}
			// }
		  ///////////////// SPE  for grn numbers//////////

		  $invoicevalue =  $res2transactionamount - ($res3transactionamount + $res4return)-$total_allocated_amount-$res5transactionamount_spe;
		  $creditamount =  $res2transactionamount - ($res3transactionamount + $res4return);

		  $t1 = strtotime($res1transactiondate);
    	  $t2 = strtotime($ADate2);
		  $days_between = ceil(abs($t2 - $t1) / 86400);

		  if($days_between<30) { $totalamount30=$totalamount30+$invoicevalue; }
			if($days_between>30 && $days_between<=60) { $total60=$total60+$invoicevalue; }
			if($days_between>60 && $days_between<=90){ $total90=$total90+$invoicevalue; }
			if($days_between>90 && $days_between<=120) { $total120=$total120+$invoicevalue; }
			if($days_between>120 && $days_between<=180) { $total180=$total180+$invoicevalue; }
			if($days_between>180) { $total210=$total210+$invoicevalue; }

		   

		  if($res2transactionamount !=''){

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

			

			?>


          <!--  <tr   >

              <td class="bodytext31" valign="center"  align="left"><?php // echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php // echo $res21suppliername; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php // echo $res1billnumber; ?></div></td>

              
                <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php // echo $supplierbillnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php // echo $res1transactiondate; ?></div></td>
              

              <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php // echo number_format($res2transactionamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php // echo number_format($invoicevalue,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php // echo number_format($totalamount30,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total60,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total90,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total120,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total180,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total210,2,'.',','); ?></div></td>

           </tr> -->

			<?php

			}

				$totalamount1 = $totalamount1 + $res2transactionamount;

				$totalamount301 = $totalamount301 + $invoicevalue;

				$totalamount601 = $totalamount601 + $totalamount30;

				$totalamount901 = $totalamount901 + $total60;

				$totalamount1201 = $totalamount1201 + $total90;

				$totalamount1801 = $totalamount1801 + $total120;

				$totalamount2101 = $totalamount2101 + $total180;

				$totalamount2401 = $totalamount2401 + $total210;

				

				$res2transactionamount=0;

				$invoicevalue=0;

				$totalamount30=0;

				$total60=0;

				$$totalamount60=0;

				$total90=0;

				$totalamount90=0;

				$total120=0;

				$totalamount120=0;

				$total180=0;

				$totalamount180=0;

				$total210=0;

				$totalamount210=0;   

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

		  $snocount = $snocount + 1;

			

			

			$totalamount1=$totalamount1+$creditamount;

			$totalamount301=$totalamount301+$creditamount;

			$totalamount601=$totalamount601+$totalamount30;

			$totalamount901=$totalamount901+$total60;

			$totalamount1201=$totalamount1201+$total90;

			$totalamount1801=$totalamount1801+$total120;

			$totalamount2101=$totalamount2101+$total180;

			$totalamount2401=$totalamount2401+$total210;

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

           <!-- <tr  >

              <td class="bodytext31" valign="center"  align="left"><?php // echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php // echo $res21suppliername; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php // echo $docno; ?></div></td>

               
                <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php //// echo $entrydate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php // echo $entrydate; ?></div></td>

              

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php // echo number_format($creditamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php // echo number_format($creditamount,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php // echo number_format($totalamount30,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total60,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total90,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total120,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total180,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total210,2,'.',','); ?></div></td>

           </tr> -->
           <?php
           $totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
		}
	}
?>

            <!-- /////////////////////////////////////// DEBIT NOTES //////////////// -->
            <?php
             $query2 = "SELECT * from supplier_debit_transactions where supplier_id = '$id' and date(created_at) between '$ADate1' and '$ADate2'  order by created_at ASC";

			$exe2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);

			while($res2=mysqli_fetch_array($exe2))

			{

		 	// $creditamount=$res2['creditamount'];

		 

			 $docno = $res2['approve_id'];
		  $created_at = $res2['created_at'];

		  $timestamp = strtotime($created_at);
			$entrydate = date('Y-m-d', $timestamp); // d.m.YYYY
			$child2 = date('H:i', $timestamp); // HH:ss


		  $supplier_id_debitnotes = $res2['supplier_id'];

		   $debitamount_sbdt = $res2['total_amount'];

		   // FOR PENDING AMOUNT //////////////////////////////////////////////////////////////////
		   $total_allocated_amount=0;
            	 $query3 = "SELECT * from master_transactionpharmacy where  docno = '$docno' and recordstatus = 'allocated' order by auto_number desc"; 
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num=mysqli_num_rows($exec3);
				while ($res3 = mysqli_fetch_array($exec3)) { $total_allocated_amount +=$res3['transactionamount']; }
				// echo number_format($debitamount_sbdt-$total_allocated_amount,2,'.',',');
				$pending_amountfromdb=$debitamount_sbdt-$total_allocated_amount;

			   // FOR PENDING AMOUNT //////////////////////////////////////////////////////////////////

			$t1 = strtotime($entrydate);

    	  $t2 = strtotime($ADate2);

		  $days_between = ceil(abs($t2 - $t1) / 86400);

		    if($days_between<30)

			{

			$totalamount30=$totalamount30-$pending_amountfromdb;

			}

			

			if($days_between>30 && $days_between<=60)

			{

			$total60=$total60-$pending_amountfromdb;

			}

			if($days_between>60 && $days_between<=90)

			{

			$total90=$total90-$pending_amountfromdb;

			}

			if($days_between>90 && $days_between<=120)

			{

			$total120=$total120-$pending_amountfromdb;

			}

			if($days_between>120 && $days_between<=180)

			{

			$total180=$total180-$pending_amountfromdb;

			}

			if($days_between>180)

			{

			$total210=$total210-$pending_amountfromdb;

			}

		  

			

			  if($debitamount_sbdt !=''){

		  $snocount = $snocount + 1;

			

			

			$totalamount1=$totalamount1-$debitamount_sbdt;

			$totalamount301=$totalamount301-$pending_amountfromdb;

			$totalamount601=$totalamount601+$totalamount30;

			$totalamount901=$totalamount901+$total60;

			$totalamount1201=$totalamount1201+$total90;

			$totalamount1801=$totalamount1801+$total120;

			$totalamount2101=$totalamount2101+$total180;

			$totalamount2401=$totalamount2401+$total210;

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

           <!-- <tr  >

              <td class="bodytext31" valign="center"  align="left"><?php // echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php // echo $res21suppliername; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php // echo $docno; ?></div></td>

               
                <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php //// echo $entrydate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php // echo $entrydate; ?></div></td>

              

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php // echo '-'.number_format($debitamount_sbdt,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php // echo '-'.number_format($pending_amountfromdb,2,'.',',');
               
                ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php // echo number_format($totalamount30,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total60,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total90,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total120,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total180,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total210,2,'.',','); ?></div></td>

           </tr> -->
            <!-- /////////////////////////////////////// DEBIT NOTES //////////////// -->


			<?php
			$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
		

}

			

			}
			//////////////////////////// debit notes end ///////////////////////////
			//////////////////////////// SPE BILLS STARTS HERE ///////////////////////////
		// $query51 = "select auto_number from paymentmodecredit ";
		// $exec51 = mysql_query($query51) or die ("Error in Query5".mysql_error());
		// $num = mysql_num_rows($exec51);
		// if($num>0)
		//   {
		  // $paymentdocno = $res45['billnumber'];
		  // $res5transactionamount = $res45['totalfxamount'];
		  // $res5transactiondate = $res45['groupdate'];

			$query5 = "select * from master_transactionpharmacy where suppliercode = '$id' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT'  and recordstatus <> 'deallocated'  order by transactiondate desc";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num5 = mysqli_num_rows($exec5);
		  if($num5 > 0)
		  {
		  while($res5 = mysqli_fetch_array($exec5))
		  {

	      $res5suppliername = $res5['suppliername'];
		  $res5patientcode = $res5['suppliercode'];
		  $res5billnumber = $res5['billnumber'];
		  $res5openingbalance = $res5['openingbalance'];
		  $res5docnumber = $res5['docno'];
		  $res5particulars = $res5['particulars'];
		  $res5transactionamount = $res5['transactionamount'];
		  //$res5particulars = substr($res5particulars,2,6);
		  $res5transactionmode= $res5['transactionmode'];
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];
		  $entrydate = $res5['transactiondate'];

		  $res5transactionamount_balance=0;


		   $query852 = "select supplierbillnumber from master_purchase where billnumber = '$res5billnumber' ";
		  $exec852 = mysqli_query($GLOBALS["___mysqli_ston"], $query852) or die ("Error in Query852".mysqli_error($GLOBALS["___mysqli_ston"]));
		  //echo $num = mysql_num_rows($exec3);
		  $res852 = mysqli_fetch_array($exec852);
		  $res85supplierbillnumber = $res852['supplierbillnumber'];

		  $t1 = strtotime($entrydate);
    	  $t2 = strtotime($ADate2);
		  $days_between = ceil(abs($t2 - $t1) / 86400);

		  if($days_between<30) { $totalamount30=$totalamount30-$res5transactionamount_balance; }
			if($days_between>30 && $days_between<=60) { $total60=$total60-$res5transactionamount_balance; }
			if($days_between>60 && $days_between<=90){ $total90=$total90-$res5transactionamount_balance; }
			if($days_between>90 && $days_between<=120) { $total120=$total120-$res5transactionamount_balance; }
			if($days_between>120 && $days_between<=180) { $total180=$total180-$res5transactionamount_balance; }
			if($days_between>180) { $total210=$total210-$res5transactionamount_balance; }

			

			  if($res5transactionamount !=''){
		  		$snocount = $snocount + 1;

		  		$totalamount1=$totalamount1-$res5transactionamount;
				$totalamount301=$totalamount301-$res5transactionamount_balance;
				$totalamount601=$totalamount601+$totalamount30;
				$totalamount901=$totalamount901+$total60;
				$totalamount1201=$totalamount1201+$total90;
				$totalamount1801=$totalamount1801+$total120;
				$totalamount2101=$totalamount2101+$total180;
				$totalamount2401=$totalamount2401+$total210;

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

          <!--  <tr  >

              <td class="bodytext31" valign="center"  align="left"><?php // echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php // echo $res21suppliername; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php // echo $res5docnumber; ?></div></td>

               
                <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php // echo $res85supplierbillnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php // echo $entrydate; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php // echo '-'.number_format($res5transactionamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php // echo  number_format($res5transactionamount_balance,2,'.',',');
               
                ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php // echo number_format($totalamount30,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total60,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total90,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total120,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total180,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php // echo number_format($total210,2,'.',','); ?></div></td>

           </tr> -->
            <!-- /////////////////////////////////////// spe bills //////////////// -->


			<?php
			$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
		}
	}
}

 
			//////////////////////////// SPE BILLS ENDS HERE ///////////////////////////


			

			}

			?>
			</tbody>
			<tr >

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              

				<!-- <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5">&nbsp;</td> -->

                 <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1,2,'.',','); ?></strong></td>

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

			$totalamount1_final +=$totalamount1;
			$totalamount301_final +=$totalamount301;
			$totalamount601_final +=$totalamount601;
			$totalamount901_final +=$totalamount901;
			$totalamount1201_final +=$totalamount1201;
			$totalamount1801_final +=$totalamount1801;
			$totalamount2101_final +=$totalamount2101;
			$totalamount2401_final +=$totalamount2401;

			$snocount=0;
			$totalamount1=0;
		$totalamount301=0;
		$totalamount601=0;
		$totalamount901=0;
		$totalamount1201=0;
		$totalamount1801=0;
		$totalamount2101=0;
		$totalamount2401=0;

			} 

			}

			?>

			<tr >

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              

				<!-- <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5">&nbsp;</td> -->

                 <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1_final,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount301_final,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount601_final,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount901_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1201_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1801_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2101_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2401_final,2,'.',','); ?></strong></td>        

            </tr>
		
            
			<tr>

			<?php

			

				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliercode=$arraysuppliercode&&searchsuppliername=$searchsuppliername";
				$urlpath_summary = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliercode=$arraysuppliercode";

			

			?>

			 <td colspan="11"></td>

		   

			</tr>    
			 

          </tbody>

        </table> 