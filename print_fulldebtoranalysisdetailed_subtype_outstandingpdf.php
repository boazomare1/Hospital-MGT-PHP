<?php

ob_start();

session_start();

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



$query1 = "select * from master_company where auto_number = '$companyanum'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1companyname = $res1['companyname'];

$res1address1 = $res1['address1'];

$resfaxnumber1 = $res1['faxnumber1'];

$res1area = $res1['area'];

$res1city = $res1['city'];

$res1state = $res1['state'];

$res1emailid1= $res1['emailid1'];

$res1country = $res1['country'];

$res1pincode = $res1['pincode'];

$phonenumber1 = $res1['phonenumber1'];

$locationname = $res1['locationname'];

$locationcode = $res1['locationcode'];




if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchaccountnameanum1"])) {  $searchaccountnameanum1 = $_REQUEST["searchaccountnameanum1"]; } else { $searchaccountnameanum1 = ""; }



if (isset($_REQUEST["searchsubtypeanum1"])) {  $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }

if (isset($_REQUEST["billno"])) {  $billno = $_REQUEST["billno"]; } else { $billno = ""; }



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

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE:14px; COLOR: #3B3B3C;

}

-->

</style>

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE:14px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE:14px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE:14px; COLOR: #3b3b3c; text-decoration:none

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

<?php  include("print_header1.php"); ?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1101" 

            align="center" border="1">

          <tbody>

            <tr>

              <td align="center" colspan="13" bgcolor="#ffffff" class="bodytext31"><strong>Full Debtor Analysis Detailed</strong></td>  

            </tr>

			<tr>

              <td align="center" colspan="13" bgcolor="#ffffff" class="bodytext31"><strong>Report From <?php echo $ADate1; ?> To <?php echo $ADate2; ?></strong></td>  

            </tr>

             <tr>

              <td width="20" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="210" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>

				 <td width="45" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

              <td width="80" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Total Amount </strong></td>

              <td width="80" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> 30 days </strong></td>

              <td width="80" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>60 days </strong></div></td>

				<td width="80" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>90 days</strong></div></td>

				<td width="80" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days</strong></div></td>

              <td width="80" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days </strong></div></td>

				<td width="80" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>

            </tr>

			

			<?php

			

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{
				$grandtotalopbal = 0;
				$grandtotoptotalamount30 = 0;
				$grandtotoptotalamount60  = 0;
				$grandtotoptotalamount90  = 0;
				$grandtotoptotalamount120  = 0;
				$grandtotoptotalamount180   = 0;
				

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

			$grandopbal = 0;
			$grandopbal30 = 0;
			$grandopbal60 = 0;
			$grandopbal90 = 0;
			$grandopbal120 = 0;
			$grandopbal180 = 0;
			$grandopbal180g = 0;			

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
 $totoptotalamount30 = 0;
		  $totoptotalamount60 = 0;
		  $totoptotalamount90 = 0;
		  $totoptotalamount120 = 0;
		  $totoptotalamount180 = 0;
		  $totoptotalamountgreater = 0;
		   $subtypeopbal = 0;
		if( $subtypeanum!='')
			{	
			
				$query2211 = "select accountname,auto_number,id from master_accountname where subtype='$subtypeanum'";
			}
						//echo $query221;
			$exec2211 = mysqli_query($GLOBALS["___mysqli_ston"], $query2211) or die ("Error in query2211".mysqli_error($GLOBALS["___mysqli_ston"]));
 			 $resnum=mysqli_num_rows($exec2211); 
			while($res2211 = mysqli_fetch_array($exec2211))
			{		   
			 $res22accountname = $res2211['accountname'];
			$res21accountnameano=$res2211['auto_number'];
			$res21accountname = $res2211['accountname'];
			$res21accountid = $res2211['id'];
			
		 	$querydebit12 = "select * from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid'";
		
			$execdebit12 = mysqli_query($GLOBALS["___mysqli_ston"], $querydebit12) or die ("Error in querydebit12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numdebit12 = mysqli_num_rows($execdebit12);
					
			//echo $cashamount;
		  $optotalamount30 = 0;
		  $optotalamount60 = 0;
		  $optotalamount90 = 0;
		  $optotalamount120 = 0;
		  $optotalamount180 = 0;
		  $optotalamountgreater = 0;
			if( $res22accountname != '' && $numdebit12>0)
			{

			$openingbalance='0';



		  $opquery = "select billnumber,visitcode,fxamount AS fxamount,transactiondate AS transactiondate from master_transactionpaylater where accountnameano='$res21accountnameano' and paymenttype like '%%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate < '$ADate1' and fxamount <>'0' and billnumber not like 'AOP%'

		  UNION ALL select billnumber,visitcode,transactionamount as fxamount,transactiondate AS transactiondate  from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate < '$ADate1'  and billnumber like 'AOP%'
	
		  UNION ALL SELECT b.`docno` as billnumber,b.visitcode AS visitcode, (-1*b.`transactionamount`) as fxamount, b.`transactiondate` as transactiondate FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` < '$ADate1' and b.billnumber!=''


	
		 UNION ALL SELECT  docno AS billnumber,'' AS visitcode,(-1*`fxamount`) as fxamount,transactiondate AS transactiondate from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate < '$ADate1'  		  
		  
		    
 UNION ALL SELECT  billnumber,'' AS visitcode,(-1*`fxamount`) as fxamount,transactiondate AS transactiondate   FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` < '$ADate1'  AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
		  
		  UNION ALL SELECT docno AS billnumber,patientvisitcode AS visitcode,(1*`amount`) as fxamount,consultationdate AS transactiondate  FROM `adhoc_debitnote` WHERE `accountcode` = '$res21accountid' AND `consultationdate` < '$ADate1'  group by docno
		  
		  UNION ALL SELECT  docno AS billnumber,'' AS visitcode,(debitamount-creditamount) as fxamount,entrydate AS transactiondate   FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` < '$ADate1'  group by docno";
		  
		$opexec = mysqli_query($GLOBALS["___mysqli_ston"], $opquery) or die ("Error in OPQuery".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($opres= mysqli_fetch_array($opexec)){
		 $resamount = $opres['fxamount'];
		
		$resbillnumber = $opres['billnumber'];
		$resvisitcode = $opres['visitcode'];
		$totalpayment = 0;
	//$query98 = "select sum(fxamount) as transactionamount1,docno from master_transactionpaylater where visitcode='$resvisitcode' and transactiontype = 'PAYMENT' and billnumber='$resbillnumber' and recordstatus = 'allocated'  AND transactiondate <= '$ADate2'";
	
	/* $query98 = "select sum(fxamount) as transactionamount1,docno from master_transactionpaylater where visitcode='$resvisitcode' and transactiontype = 'PAYMENT' and billnumber='$resbillnumber' and recordstatus = 'allocated' AND `transactiondate` <= '$ADate2' and accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND accountnameid='$res21accountid' 
	UNION ALL 
	select sum(-1*fxamount) as transactionamount1,docno from master_transactionpaylater where visitcode='$resvisitcode' and transactiontype = 'PAYMENT' and docno='$resbillnumber' and recordstatus = 'allocated' AND `transactiondate` <= '$ADate2'  and accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND accountnameid='$res21accountid' ";	 */	
	//AND `transactiondate` <= '$ADate2'  
	 $query98 = "select sum(a.fxamount +a.discount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where a.transactiontype = 'PAYMENT' AND a.transactionstatus!= 'onaccount' AND b.transactionstatus= 'onaccount' and a.billnumber='$resbillnumber' and a.recordstatus = 'allocated' and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND a.accountnameid='$res21accountid' AND  b.transactiondate <= '$ADate2'
				UNION ALL 
				select sum(a.fxamount +a.discount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where a.transactionmode = 'CREDIT NOTE' AND a.transactiontype= 'PAYMENT' AND b.transactiontype= 'paylatercredit'and a.billnumber='$resbillnumber' and a.recordstatus = 'allocated' and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND a.accountnameid='$res21accountid' AND  b.transactiondate <= '$ADate2'
				UNION ALL 
				select sum(-1*a.fxamount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where  a.transactiontype = 'PAYMENT' AND b.transactiontype != 'PAYMENT' and a.docno='$resbillnumber' and a.recordstatus = 'allocated'  and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND a.accountnameid='$res21accountid' AND a.docno NOT LIKE '%AR%' AND b.transactiondate  <= '$ADate2'
								UNION ALL 
				select sum(-1*a.fxamount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno)  where  b.transactionstatus = 'onaccount' AND a.transactionstatus != 'onaccount' and a.docno='$resbillnumber' and a.recordstatus = 'allocated' AND  a.docno  LIKE '%AR%'  and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum')  AND  b.transactiondate  <= '$ADate2' ";				
/*			
				UNION ALL 
				select sum(-1*a.fxamount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where  a.transactiontype = 'PAYMENT' AND b.transactiontype != 'PAYMENT' and a.docno='$resbillnumber' and a.recordstatus = 'allocated' AND a.docno  LIKE '%AR%'  and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND b.transactiondate  <= '$ADate2'  ";
	*/
	
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die('ERROR IN  98'.mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				  $payment = $res98['transactionamount1'];

				  $totalpayment = $totalpayment + $payment;
				}
									
				$opbalance = $resamount - $totalpayment;		
				$opbalance = number_format($resamount,2,'.','')-number_format($totalpayment,2,'.','');
			
		
					////////////// FOR AR DOCS PENDING AMOUNT //////////////

					/* $dotarray = explode("-", $resbillnumber);
					$dot_ar_doc = $dotarray[0];
					if($dot_ar_doc=='AR'){
							 $query21 = "SELECT * from master_transactionpaylater where  docno='$res2billnumber' AND `transactiondate` <=  '$ADate2' AND transactionmodule = 'PAYMENT' AND transactionstatus = 'onaccount'  order by auto_number desc LIMIT 1";
							  $exec21 = mysql_query($query21) or die ("Error in Query2".mysql_error());
							  // $num2 = mysql_num_rows($exec2);
							  while ($res21 = mysql_fetch_array($exec21))
							  {
								  $totalamount_AR = -1 * $res21['receivableamount'];
								}

					 $query_allocated_amount = "SELECT sum(transactionamount) as amount, sum(discount) as discount from master_transactionpaylater where  recordstatus='allocated' and docno='$res2billnumber' AND `transactiondate`  <= '$ADate2'";
					$exec_allocated_amount = mysql_query($query_allocated_amount) or die ("Error in Query_allocated_amount".mysql_error());
					$num_allocated = mysql_num_rows($exec_allocated_amount);
					while($res_allocated_amount = mysql_fetch_array($exec_allocated_amount)){
								$allocated_amount=$res_allocated_amount['amount'];
									}
									if($num_allocated>0){
										 $pendig_final_value1 = $totalamount_AR+$allocated_amount;
										 //$pendig_final_value1 = $totalamount_AR;
										 $opbalance=$pendig_final_value1;
									}
								}	 */	
								
		 $openingbalance = $openingbalance + $opbalance;
		$openingtransactiondate = $opres['transactiondate'];
		
					if($opbalance != '0')
					{
					$snocount = $snocount + 1;
					$t1 = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $ADate1) ) ));
					$t1 = strtotime($t1);
					$t2 = strtotime($openingtransactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);

					if($days_between <= 30)
					{

							$optotalamount30 = $optotalamount30 + $opbalance;						
							
						
					}
					else if(($days_between >30) && ($days_between <=60))
					{
				
							$optotalamount60 = $optotalamount60 + $opbalance;

						
					}
					else if(($days_between >60) && ($days_between <=90))
					{
			
							$optotalamount90 = $optotalamount90 + $opbalance;
						
					}
					else if(($days_between >90) && ($days_between <=120))
					{
			
							$optotalamount120 = $optotalamount120 + $opbalance;
						
					}
					else if(($days_between >120) && ($days_between <=180))
					{
				
							$optotalamount180 = $optotalamount180 + $opbalance;
							
						
					}
					else
					{

							$optotalamountgreater = $optotalamountgreater + $opbalance;
						
					}

					
		}
	


		}

			 $subtypeopbal = $subtypeopbal+ $openingbalance;			
			$totoptotalamount30 = $totoptotalamount30 + $optotalamount30;
			$totoptotalamount60 = $totoptotalamount60 + $optotalamount60;
			$totoptotalamount90 = $totoptotalamount90 + $optotalamount90;	
			$totoptotalamount120 = $totoptotalamount120 + $optotalamount120;
			$totoptotalamount180 = $totoptotalamount180 + $optotalamount180;
			$totoptotalamountgreater = $totoptotalamountgreater + $optotalamountgreater;


			}

				
			}
			?>

				<tr bgcolor="#cbdbfa" onClick="showsub(<?=$subtypeanum?>)">
            <td colspan="2"  align="left" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo $subtype; ?> </strong></td>
               <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong>Opening Balance </strong></td>
                <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($subtypeopbal,2,'.',','); ?></strong></td>
                 <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamount30,2,'.',','); ?></strong></td>
               <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamount60,2,'.',','); ?></strong></td>
                <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamount90,2,'.',','); ?></strong></td>
                <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamount120,2,'.',','); ?></strong></td>
                <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamount180,2,'.',','); ?></strong></td>
                <td colspan=""  align="right" valign="center" bgcolor="#FFF" class="bodytext31" ><strong><?php echo number_format($totoptotalamountgreater,2,'.',','); ?></strong></td>        
            </tr> 		 

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

		  $snoln=1;

		  $query42 = "select docno,fxamount,transactiondate,patientcode,patientname,visitcode,particulars from (select billnumber AS docno,fxamount,transactiondate,patientcode,patientname,visitcode,'Invoice NO' as particulars from master_transactionpaylater where accountnameano='$res21accountnameano' and paymenttype like '%%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' and billnumber not like 'AOP%' and (billnumber like '%$billno%' or docno like '%$billno%')
		 
		 UNION ALL select billnumber AS docno,transactionamount as fxamount,transactiondate,patientcode,patientname,visitcode,'Opening Balance'particulars from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%' and (billnumber like '%$billno%' or docno like '%$billno%')

		  UNION ALL SELECT b.`docno` as docno,  (-1*b.`transactionamount`) as fxamount, b.`transactiondate` as transactiondate,b.patientcode,b.patientname,b.visitcode,b.particulars  FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2' and b.billnumber!='' and (b.billnumber like '%$billno%' or b.docno like '%$billno%')

			
		  		  UNION ALL SELECT docno as docno, (-1*`fxamount`) as fxamount, `transactiondate` as transactiondate,patientcode,patientname,visitcode,particulars from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2' and (billnumber like '%$billno%' or docno like '%$billno%')
				  
		  		  UNION ALL SELECT `docno` as docno, (-1*`fxamount`) as fxamount, `transactiondate` as transactiondate,accountnameid as patientcode, accountname as patientname,'' as visitcode,particulars  FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT' and (billnumber like '%$billno%' or docno like '%$billno%')				  



		  UNION ALL SELECT `docno` as docno, sum(1*`amount`) as fxamount, `consultationdate` as transactiondate, patientcode as patientcode, patientname as patientname, patientvisitcode as visitcode, '' as particulars  FROM `adhoc_debitnote` WHERE `accountcode` = '$res21accountid' AND `consultationdate` BETWEEN '$ADate1' AND '$ADate2' and docno like '%$billno%' group by docno
		  
		  UNION ALL SELECT `docno` as docno, sum(debitamount-creditamount) as fxamount, `entrydate` as transactiondate ,ledgerid as patientcode, ledgername as patientname,'' as visitcode,narration as particulars   FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno like '%$billno%' group by docno) as t order by t.transactiondate ASC";

		  

		   $exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
/*
		   if(mysql_num_rows($exec42)==0)

		   {

		   continue;

		   }
*/
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
	//ACCOUNT WISE OPENING BALANCE 
		$accountopeningbalance = 0;
		$accoptotal30 = 0;
		$accoptotal60 = 0;
		$accoptotal90 = 0;
		$accoptotal120 = 0;
		$accoptotal180 = 0;
		$accoptotal180g = 0;
		$accountopeningbalance = 0;
//echo $res22accountname;

		  $opquery2 = "select billnumber,visitcode,fxamount AS fxamount,transactiondate AS transactiondate from master_transactionpaylater where accountnameano='$res21accountnameano' and paymenttype like '%%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate < '$ADate1' and fxamount <>'0' and billnumber not like 'AOP%' 

		  UNION ALL select billnumber,visitcode,transactionamount as fxamount,transactiondate AS transactiondate  from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate < '$ADate1'  and billnumber like 'AOP%' 
		  
		  UNION ALL SELECT b.`docno` as billnumber,b.visitcode AS visitcode, (-1*b.`transactionamount`) as fxamount, b.`transactiondate` as transactiondate FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` < '$ADate1' and b.billnumber!=''

		  		  UNION ALL SELECT docno AS billnumber,visitcode, (-1*`fxamount`) as fxamount,transactiondate AS transactiondate from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate < '$ADate1' 
				  
		  		  UNION ALL SELECT billnumber,visitcode, (-1*`fxamount`) as fxamount,transactiondate AS transactiondate FROM `master_transactionpaylater` WHERE `accountnameid` = '$res21accountid' AND `transactiondate` < '$ADate1'  AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT' 


		  UNION ALL SELECT docno AS billnumber, patientvisitcode AS visitcode,(1*`amount`) as fxamount,consultationdate AS transactiondate  FROM `adhoc_debitnote` WHERE `accountcode` = '$res21accountid' AND `consultationdate` < '$ADate1'  group by docno
		  
		  UNION ALL SELECT  docno AS billnumber,'' AS visitcode, (debitamount-creditamount) as fxamount,entrydate AS transactiondate   FROM `master_journalentries` WHERE `ledgerid` = '$res21accountid' AND `entrydate` < '$ADate1'   group by docno";
		$opexec2 = mysqli_query($GLOBALS["___mysqli_ston"], $opquery2) or die ("Error in OPQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($opres2= mysqli_fetch_array($opexec2)){

		 $resamount2 = $opres2['fxamount'];
		$resbillnumber = $opres2['billnumber'];

		$resvisitcode = $opres2['visitcode'];
		$totalpayment = 0;
		

	/* $query98 = "select sum(fxamount) as transactionamount1,docno from master_transactionpaylater where visitcode='$resvisitcode' and transactiontype = 'PAYMENT' and billnumber='$resbillnumber' and recordstatus = 'allocated' AND `transactiondate` <= '$ADate2' and accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND accountnameid='$res21accountid' 
	UNION ALL 
	select sum(-1*fxamount) as transactionamount1,docno from master_transactionpaylater where visitcode='$resvisitcode' and transactiontype = 'PAYMENT' and docno='$resbillnumber' and recordstatus = 'allocated' AND `transactiondate` <= '$ADate2'  and accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND accountnameid='$res21accountid' ";		 */	
	
	
	
	
	//AND `transactiondate` <= '$ADate2'
	$query98 = "select sum(a.fxamount +a.discount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where a.transactiontype = 'PAYMENT' AND a.transactionstatus!= 'onaccount' AND b.transactionstatus= 'onaccount' and a.billnumber='$resbillnumber' and a.recordstatus = 'allocated' and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND a.accountnameid='$res21accountid' AND  b.transactiondate <= '$ADate2'
			 
				UNION ALL
				select sum(a.fxamount +a.discount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where a.transactionmode = 'CREDIT NOTE' AND a.transactiontype= 'PAYMENT' AND b.transactiontype= 'paylatercredit' and a.billnumber='$resbillnumber' and a.recordstatus = 'allocated' and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND a.accountnameid='$res21accountid' AND  b.transactiondate <= '$ADate2'
			 
				UNION ALL 
				
				select sum(-1*a.fxamount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where  a.transactiontype = 'PAYMENT' AND b.transactiontype != 'PAYMENT' and a.docno='$resbillnumber' and a.recordstatus = 'allocated' and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND a.accountnameid='$res21accountid' AND a.docno NOT LIKE '%AR%'  AND b.transactiondate  <= '$ADate2'
UNION ALL
				select sum(-1*a.fxamount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno)  where  b.transactionstatus = 'onaccount' AND a.transactionstatus != 'onaccount' and a.docno='$resbillnumber' and a.recordstatus = 'allocated' AND  a.docno  LIKE '%AR%'  and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum')  AND  b.transactiondate  <= '$ADate2' ";	

/*				
				UNION ALL 
				
				select sum(-1*a.fxamount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where  a.transactiontype = 'PAYMENT' AND b.transactiontype != 'PAYMENT' and a.docno='$resbillnumber' and a.recordstatus = 'allocated' AND a.docno  LIKE '%AR%'  and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND b.transactiondate  <= '$ADate2' ";		
*/				
					$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num98 = mysqli_num_rows($exec98);
					while($res98 = mysqli_fetch_array($exec98))
					{
					  $payment = $res98['transactionamount1'];

					   $totalpayment = $totalpayment + $payment;
					}
					
					$opbalance2 = $resamount2 - $totalpayment;		
				$opbalance2 = number_format($resamount2,2,'.','')-number_format($totalpayment,2,'.','');
					
					
					////////////// FOR AR DOCS PENDING AMOUNT //////////////

					/* $dotarray = explode("-", $resbillnumber);
					 $dot_ar_doc = $dotarray[0];
					if($dot_ar_doc=='AR'){
							 $query21 = "SELECT * from master_transactionpaylater where  docno='$res2billnumber' AND `transactiondate` <= '$ADate2' AND transactionmodule = 'PAYMENT' AND transactionstatus = 'onaccount' order by auto_number desc LIMIT 1";
							  $exec21 = mysql_query($query21) or die ("Error in Query2".mysql_error());
							  // $num2 = mysql_num_rows($exec2);
							  while ($res21 = mysql_fetch_array($exec21))
							  {
								   $totalamount_AR = -1 * $res21['receivableamount'];
								}

					 $query_allocated_amount = "SELECT sum(transactionamount) as amount, sum(discount) as discount from master_transactionpaylater where  recordstatus='allocated' and docno='$res2billnumber' AND `transactiondate` <= '$ADate2'";
					$exec_allocated_amount = mysql_query($query_allocated_amount) or die ("Error in Query_allocated_amount".mysql_error());
					$num_allocated = mysql_num_rows($exec_allocated_amount);
					while($res_allocated_amount = mysql_fetch_array($exec_allocated_amount)){
								 $allocated_amount=$res_allocated_amount['amount'];
								
									}
									if($num_allocated>0){
										 $pendig_final_value1 = $totalamount_AR+$allocated_amount;
										 //$pendig_final_value1 = $totalamount_AR;
										$opbalance2=$pendig_final_value1;
									}
								}		 */			
					
		
					
					
					
					$accountopeningbalance = $accountopeningbalance + $opbalance2;
					$openingtransactiondate2 = $opres2['transactiondate'];

					if($opbalance2 != '0')
					{
					$snocount = $snocount + 1;
					$t1 = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $ADate1) ) ));
					
					$t1 = strtotime($t1);
					$t2 = strtotime($openingtransactiondate2);
					$days_between = ceil(abs($t1 - $t2) / 86400);

					if($days_between <= 30)
					{

							$accoptotal30 = $accoptotal30 +	$opbalance2;				
							
						
					}
					else if(($days_between >30) && ($days_between <=60))
					{
				
							$accoptotal60 = $accoptotal60 +	$opbalance2;	

						
					}
					else if(($days_between >60) && ($days_between <=90))
					{
			
						$accoptotal90 = $accoptotal90 +	$opbalance2;	
						
					}
					else if(($days_between >90) && ($days_between <=120))
					{
			
							$accoptotal120 = $accoptotal120 +	$opbalance2;	
						
					}
					else if(($days_between >120) && ($days_between <=180))
					{
						$accoptotal180 = $accoptotal180 +	$opbalance2;	

					}
					else
					{
		
							$accoptotal180g = $accoptotal180g +	$opbalance2;	
						
					}

					
		}

	
		}
//ACCOUNT WISE OPENING BALANCE END					
		   ?>

		    <tr >
		   <td class="bodytext31" valign="center"  align="left"><?=$sno++;?></td>
                <td class="bodytext31" valign="center" colspan="1" align="left"><?php echo $res22accountname; ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right">Opening Balance</td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accountopeningbalance,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal30,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal60,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal90,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal120,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal180,2); ?></td>
                <td class="bodytext31" valign="center" colspan="" align="right"><?php echo number_format($accoptotal180g,2); ?></td>
                       
            </tr>

		

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

				

				$query981 = "select docno from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT'  and recordstatus = 'allocated'
				UNION ALL select docno from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'paylatercredit'  and recordstatus = ''";
				$exec981 = mysqli_query($GLOBALS["___mysqli_ston"], $query981) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num981 = mysqli_num_rows($exec981);
				while($res981 = mysqli_fetch_array($exec981))
				{  
				  $res2billnumber1 = $res981['docno'];
				}

				

				$totalpayment = 0;
				//AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
				 $query98 = "select sum(a.fxamount +a.discount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where a.transactiontype = 'PAYMENT' AND a.transactionstatus!= 'onaccount' AND b.transactionstatus= 'onaccount' and a.billnumber='$res2billnumber' and a.recordstatus = 'allocated' and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND a.accountnameid='$res21accountid' AND  b.transactiondate BETWEEN '$ADate1' and '$ADate2'
 
				UNION ALL
				select sum(a.fxamount +a.discount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where a.transactionmode = 'CREDIT NOTE' AND a.transactiontype= 'PAYMENT' AND b.transactiontype= 'paylatercredit' and a.billnumber='$res2billnumber' and a.recordstatus = 'allocated' and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND a.accountnameid='$res21accountid' AND  b.transactiondate BETWEEN '$ADate1' and '$ADate2'
 
				UNION ALL 
				
select sum(-1*a.fxamount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno) where  a.transactiontype = 'PAYMENT' AND b.transactiontype != 'PAYMENT' and a.docno='$res2billnumber' and a.recordstatus = 'allocated' and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum') AND a.accountnameid='$res21accountid' AND a.docno NOT LIKE '%AR%'	AND b.transactiondate BETWEEN '$ADate1' and '$ADate2'			


UNION ALL
				select sum(-1*a.fxamount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno)  where  b.transactionstatus = 'onaccount' AND a.transactionstatus != 'onaccount' and a.docno='$res2billnumber' and a.recordstatus = 'allocated' AND  a.docno  LIKE '%AR%'  and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum')  AND  b.transactiondate   BETWEEN '$ADate1' and '$ADate2' ";					

/*				UNION ALL 
				
select sum(-1*a.fxamount ) as transactionamount1,a.docno from master_transactionpaylater as a left join master_transactionpaylater as b on(b.docno=a.docno)  where  a.transactiontype = 'PAYMENT' AND b.transactiontype != 'PAYMENT' and a.docno='$res2billnumber' and a.recordstatus = 'allocated' AND  a.docno  LIKE '%AR%'  and a.accountnameid in (select id from master_accountname where subtype='$subtypeanum')  AND b.transactiondate BETWEEN '$ADate1' and '$ADate2'

				";*/
				$exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num98 = mysqli_num_rows($exec98);
				while($res98 = mysqli_fetch_array($exec98))
				{
				  $payment = $res98['transactionamount1'];

				  $totalpayment = $totalpayment + $payment;
				}
									
				$resamount = $res2transactionamount - $totalpayment;		
				$resamount = number_format($res2transactionamount,2,'.','')-number_format($totalpayment,2,'.','');
				
				
					$query90 = "select customerfullname, memberno from master_customer where customercode = '$res2patientcode'";
				$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res90 = mysqli_fetch_array($exec90);
				$customerfullname = $res90['customerfullname'];
				$mrdno = $res90['memberno'];
				if($customerfullname==''){
				$customerfullname = $res42['patientname'];
				}
				

////////////// FOR AR DOCS PENDING AMOUNT //////////////

					/* $dotarray = explode("-", $res2billnumber);
					$dot_ar_doc = $dotarray[0];
					if($dot_ar_doc=='AR'){
							 $query2 = "SELECT * from master_transactionpaylater where  docno='$res2billnumber' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND transactionmodule = 'PAYMENT' AND transactionstatus = 'onaccount' order by auto_number desc LIMIT 1";
							  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
							  // $num2 = mysql_num_rows($exec2);
							  while ($res2 = mysql_fetch_array($exec2))
							  {
								  $totalamount_AR = -1 * $res2['receivableamount'];
								  
								}
				  
					 $query_allocated_amount = "SELECT sum(transactionamount) as amount, sum(discount) as discount from master_transactionpaylater where  recordstatus='allocated' and docno='$res2billnumber' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
					$exec_allocated_amount = mysql_query($query_allocated_amount) or die ("Error in Query_allocated_amount".mysql_error());
					$num_allocated = mysql_num_rows($exec_allocated_amount);
					while($res_allocated_amount = mysql_fetch_array($exec_allocated_amount)){
								$allocated_amount=$res_allocated_amount['amount'];
									}
									if($num_allocated>0){
										 $pendig_final_value = $totalamount_AR+$allocated_amount;
										 //$pendig_final_value = $totalamount_AR;
										 $resamount=$pendig_final_value;
									}
								} */
					/////////////////////////////////////////////////////////////////

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

                ><?php echo $particulars.' - '.$res2billnumber; ?></td>

                  <!--  <td align="left" class="bodytext31"><?php echo $customerfullname; ?></td>

                    <td align="left" class="bodytext31"><?php echo $res2visitcode; ?></td>

                    <td align="left" class="bodytext31"><?php echo $mrdno; ?></td>-->

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
		$closetotalamount301=$closetotalamount301 + $accountopeningbalance;
		
		$totalamount1 =$totalamount1+$openingbalance;						

	

			?>

           

           <tr  onClick="showaccount(<?=$res21accountnameano?>)">

		   <td class="bodytext31" valign="center"  align="left"></td>

                <td class="bodytext31" valign="center" colspan="2"  align="right" 

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
$totalamount301=$totalamount301 + $subtypeopbal;	
			?>

			</tbody>

            <tr onClick="showsub(<?=$subtypeanum?>)">

             <!-- <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>-->

				<td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong>Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount601+$totoptotalamount30,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount901+$totoptotalamount60,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount1201+$totoptotalamount90,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount1801+$totoptotalamount120,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount2101+$totoptotalamount180,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($totalamount2401+$totoptotalamountgreater,2,'.',','); ?></strong></td>        

            </tr>

			<?php

				$grandopbal = $grandopbal + $subtypeopbal;
			   $grandopbal30 = $grandopbal30 + $totoptotalamount30;
			   $grandopbal60 = $grandopbal60 + $totoptotalamount60;
			    $grandopbal90 = $grandopbal90 + $totoptotalamount90;
			   $grandopbal120 = $grandopbal120 + $totoptotalamount120;
			   $grandopbal180 = $grandopbal180 + $totoptotalamount180;
			   $grandopbal180g = $grandopbal180g + $totoptotalamountgreater;
			   
			   
			   
$grandtotalamount1 += $totalamount1;
$grandtotalamount301 = $grandtotalamount301 + $totalamount301;
 $grandtotalamount601 =$grandtotalamount601+$totalamount601+$totoptotalamount30;
$grandtotalamount901 = $grandtotalamount901+$totalamount901+$totoptotalamount60;
$grandtotalamount1201 =$grandtotalamount1201+ $totalamount1201+$totoptotalamount90;
$grandtotalamount1801 = $grandtotalamount1801+$totalamount1801+$totoptotalamount120;
$grandtotalamount2101 =$grandtotalamount2101+ $totalamount2101+$totoptotalamount180;
$grandtotalamount2401 = $grandtotalamount2401+$totalamount2401+$totoptotalamountgreater;

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

             <!-- <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>-->

				<td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong>Grand Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($grandtotalamount301,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($grandtotalamount601,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($grandtotalamount901,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($grandtotalamount1201,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($grandtotalamount1801,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($grandtotalamount2101,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><strong><?php echo number_format($grandtotalamount2401,2,'.',','); ?></strong></td>        

            </tr>

			<?php

			   }

			   ?>

          </tbody>

</table>

<?php

require_once('html2pdf/html2pdf.class.php');



    $content = ob_get_clean();



    // convert in PDF

    try

    {

        $html2pdf = new HTML2PDF('L', 'A4', 'en');

//      $html2pdf->setModeDebug();

        //$html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_fulldebtorStatement.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    } 

?>