<?php 
session_start();
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="doctorwisesummaryreport.xls"');
header('Cache-Control: max-age=80');
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno']; 
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
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
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) {  $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["locationcode"])) {  $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
$searchsuppliername1=explode('#',$searchsuppliername);
$searchsuppliername=trim($searchsuppliername1[0]);
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d'); }
$paymentreceiveddatefrom=$ADate1;
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
$paymentreceiveddateto=$ADate2;
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if($locationcode=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$locationcode'";
}		
?>
 
 
</head>
<body>
<table width="101%" border="1" cellspacing="0" cellpadding="2">
          <tbody>
          	<tr bgcolor="#ffffff">
            <td colspan="9"  align="center" valign="center"  class="bodytext31"><strong>Doctor Wise Summary Statement</strong></td>
            </tr> 
          	<tr bgcolor="#ffffff">
            <td colspan="9"  align="center" valign="center" class="bodytext31"><strong>Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?></strong></td>
            </tr> 
            
              	<?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				
				
				?>
				 
            <tr bgcolor="#ffffff">
              <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor</strong></div></td>
              <td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Total Amount	 </strong></td>
                <td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> 30 days</strong></td>
                 <td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> 60 days </strong></td>
                 <td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> 90 days</strong></td>
              <td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days</strong></div></td>
              <td width="10%" align="right" valign="right"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days</strong></div></td>
				<td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days</strong></div></td>
				
            </tr>
            <?php 
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
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
					//$query233 = "select doccoa,description as doctorname from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by doccoa order by recorddate,docno ";
					$query233 = "select id as doccoa,accountname as doctorname from master_accountname where id='$suppliercode' and accountsmain='3' and accountssub='13' order by id";
					}
					else
					{
					//$query233 = "select doccoa,description as doctorname from billing_ipprivatedoctor where amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by doccoa order by recorddate,docno ";
					$query233 = "select id as doccoa,accountname as doctorname from master_accountname where  accountsmain='3' and accountssub='13' order by id";
				    }
					
					$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
			//$num233=mysql_num_rows($exec233);
			
			while($res233 = mysqli_fetch_array($exec233))	
			{
			$suppliercode = $res233['doccoa'];
			$doctorname = $res233['doctorname'];
			
				// $openingbalance1 = 0;	// OB
										
				// 	$querycr1op = "SELECT SUM(`transactionamount`) as openingbalance  FROM `billing_ipprivatedoctor` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1' and visittype='OP' and amount <> '0.00' and amount > 0  and docno <> ''";
				// 		$execcr1 = mysql_query($querycr1op) or die ("Error in querycr1op".mysql_error());
				// 		$rescr1 = mysql_fetch_array($execcr1);
				// 		$openingbalance = $rescr1['openingbalance']; 
				// 	$querycr1ip = "SELECT IFNULL(SUM(`sharingamount`),0) as openingbalance1  FROM `billing_ipprivatedoctor` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1' and visittype='IP' and amount <> '0.00' and amount > 0  and docno <> ''";
				// $execcr12 = mysql_query($querycr1ip) or die ("Error in querycr1ip".mysql_error());
				// // echo $querycr1ip.'<br>';
				// $rescr12 = mysql_fetch_array($execcr12);
				// $openingbalance1 = $rescr12['openingbalance1']; 
				// 		$openingbalance =$openingbalance +$openingbalance1;
				// 		$query_refunds = "SELECT IFNULL(SUM(`transactionamount`),0) as openingbalance_r  FROM `billing_ipprivatedoctor_refund` WHERE doccoa='$suppliercode'  AND `recorddate` <  '$ADate1'  and amount <> '0.00' and amount > 0  and docno <> ''";
				// 		//  and visittype='OP'
				// 		$exec_refunds = mysql_query($query_refunds) or die ("Error in querycr1ip".mysql_error());
				// 		$res_refunds = mysql_fetch_array($exec_refunds);
				// 		 $openingbalance_ref = $res_refunds['openingbalance_r']; 
				// 	     $openingbalance =$openingbalance - $openingbalance_ref;
				// 	     ////////// debits and credits ////////
				// 	      $query = "SELECT IFNULL(sum(transactionamount), 0) as opbaldebit  from master_transactiondoctor where doctorcode='$suppliercode' and transactiondate <'$ADate1' and debit_reference_no IS NULL" ;
				// 	            $exec_dr = mysql_query($query) or die ("Error in querycr1ip".mysql_error());
				// 	            $res_dr = mysql_fetch_array($exec_dr);
				// 	            $openingbalance_deb = $res_dr['opbaldebit']; 
				// 	            // doctor debit note
				// 	            $query_note = "SELECT IFNULL(sum(amount), 0) as docamt  from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate < '$ADate1'";
				// 	             $exec_note = mysql_query($query_note) or die ("Error in querycr1ip".mysql_error());
				// 	            $res_note = mysql_fetch_array($exec_note);
				// 	            $openingbalance_p = $res_note['docamt']; 
				// 	             $query_note = "SELECT IFNULL(sum(amount), 0) as docamt  from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate < '$ADate1'";
				// 	             //echo $query_note;
				// 	             $exec_note = mysql_query($query_note) or die ("Error in querycr1ip".mysql_error());
				// 	            $res_note = mysql_fetch_array($exec_note);
				// 	            $openingbalance_m = $res_note['docamt']; 
					           
				// 	            $openingbalance_doct_debcre = $openingbalance_p - $openingbalance_m;
				// 	     ////////// debits and credits ////////
				// 	            $openingbalance =$openingbalance - $openingbalance_deb + $openingbalance_doct_debcre;
					            	$fulltotal1=0;
$fulltotalamount301=0;
$fulltotalamount601=0;
$fulltotalamount901=0;
$fulltotalamount1201=0;
$fulltotalamount1801=0;
$fulltotalamountgreater1=0;
				    ?>
		
					<?php // OB
					$openingbalance=0;
					$query234 = "SELECT mainset.* from ((select recorddate as transdate,docno as documentno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor' as transtable  from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate <= '$ADate2'  and docno <> '' and $pass_location group by docno,doccoa order by recorddate,docno)
           union (select transactiondate as transdate,billnumber as documentno,'' as billtype,visitcode,patientname,patientcode,accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$suppliercode' and transactiondate <= '$ADate2' and $pass_location order by transactiondate,auto_number) union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,sum(amount) as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_creditnote' as transtable from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate <= '$ADate2' and $pass_location  order by consultationdate) union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_debitnote' as transtable from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate <= '$ADate2' and $pass_location  order by consultationdate) 
           -- for ADP bills
           union (select transactiondate as transdate,docno as documentno,'' as billtype,'' as visitcode,'' as patientname,'' as patientcode, '' as accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, '0' as taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from advance_payment_entry where  ledger_code='$suppliercode' and recordstatus<>'deleted' and transactiondate <= '$ADate2' and $pass_location order by transactiondate,auto_number)
		   union (select entrydate as transdate,docno as documentno,'' as billtype,'' as visitcode,'' as patientname,'' as patientcode, '' as accountname,'' as visittype, 0 as sharingamount,'' as percentage, IF(selecttype='Dr',-1*transactionamount,transactionamount) as transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, '0' as taxamount,narration as particulars,'' as refno,'master_journalentries' as transtable  from master_journalentries where  ledgerid='$suppliercode' and entrydate <= '$ADate2' and $pass_location order by entrydate,auto_number)
          union (SELECT recorddate as transdate,docno as documentno,billtype, visitcode visitcode,patientname,patientcode,accountname,visittype as visittype,sum(sharingamount) as sharingamount,percentage as percentage,sum(transactionamount) as transactionamount,pvtdr_percentage as pvtdr_percentage, sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor_refund' as transtable from billing_ipprivatedoctor_refund where doccoa = '$suppliercode' and recorddate <= '$ADate2' and $pass_location group by docno,doccoa order by recorddate,docno)
        ) mainset order by transdate";
			$exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num234=mysqli_num_rows($exec234);
			
$res45billamount=0;	
			while($res234 = mysqli_fetch_array($exec234))
			{
			$res45patientname = $res234['patientname'];
			$res45patientcode = $res234['patientcode'];
			$res45accountname = $res234['accountname'];
			$res45vistype = $res234['visittype'];
			$transtable = $res234['transtable'];
			$refno = $res234['refno'];
 			 
				$invoiceno = $res234['documentno'];
				// $doccoa = $res234['doccoa'];
				$billtype = $res234['billtype'];
				$patientname = $res234['patientname'];
				$res45visitcode = $res234['visitcode'];
				////////////
					$query11 = "SELECT billtype from master_visitentry where visitcode = '$res45visitcode'  ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$num11 =mysqli_num_rows($exec11);
				if($num11 ==0)
				{
				$query11 = "SELECT billtype from master_ipvisitentry where  visitcode = '$res45visitcode' ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
				$num11 =mysqli_num_rows($exec11);
				if($num11 ==1)
				    { $billtype = $res11['billtype']; }
				}else{
				$billtype = $res11['billtype'];}
				 // get visit type
				  $visittype = $res234['visittype'];
				// get sub type
				  // $subtypename = getsubtype($res45visitcode,$visittype);
				////////////
                
				$total = '0.00';
				$totalat = '0.00';
				$totalat1 = '0.00';
				$totalamount30 = 0;
			$totalamount60 = 0;
			$totalamount90 = 0;
			$totalamount120 = 0;
			$totalamount180 = 0;
      $totalamountgreater = 0;
				
				$res45transactiondate = $res234['transdate'];
				$billnumber = $res234['documentno'];
				$transtable = $res234['transtable'];
				$res45billamount = $res234['original_amt'];
				$res45vistype = $res234['visittype'];
				$res45vistype = $res234['visittype'];
				$res45transactionamount = $res234['transactionamount'];
        if($transtable == 'billing_ipprivatedoctor')
        {
              $res45transactionamount = $res234['sharingamount'];
              if($res45vistype == "OP")
              {
              $res45doctorperecentage = $res234['percentage'];
              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {
              $res45doctorperecentage = $res234['pvtdr_percentage'];
              }
              
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
             
      
         }
         ///////////// CASH REFUNDS/////////////
         if($transtable == 'billing_ipprivatedoctor_refund')
        {
              $res45transactionamount = $res234['sharingamount'];
              if($res45vistype == "OP")
              {
              $res45doctorperecentage = $res234['percentage'];
              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {
              $res45doctorperecentage = $res234['pvtdr_percentage'];
              }
              $description = "Towards Bill ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname." )";
         }
         ///////////// CASH REFUNDS/////////////
        
         if($transtable == 'master_transactiondoctor')
        {
           $res45transactionamount = $res234['transactionamount'];
          $taxamount = $res234['taxamount'];
          $amtwithouttax = $res45transactionamount - $taxamount;
          $description =  "Payment ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res234['particulars']." )";
            $query124 = "select sum(original_amt) as original_amt,visittype,percentage,pvtdr_percentage,recorddate from billing_ipprivatedoctor where doccoa='$suppliercode' and docno='$billnumber' and transactionamount >0";
            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res124 = mysqli_fetch_array($exec124);
            $res45billamount = $res124['original_amt'];
            $res45vistype = $res124['visittype'];
			$res45transactiondate = $res124['recorddate'];
             if($res45vistype == "OP")
              {
              $res45doctorperecentage = $res234['percentage'];
              $res45transactionamount = $res234['transactionamount'];
              }
              else
              {
              $res45doctorperecentage = $res234['pvtdr_percentage'];
              }
              
            
        }
        ///////////date filter works likes this////
        if($res45transactiondate==''){
           $res45transactiondate = $res234['transdate'];
        }
         if($transtable == 'adhoc_creditnote')
        {
         $description =  "Credit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
        
       } 
        if($transtable == 'adhoc_debitnote')
        {
         $description =  "Debit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
        
       }
        $res45locationcode = $res234['locationcode'];
        /////////////////
			 $t1 = strtotime($ADate2);
		  $t2 = strtotime($res45transactiondate);
		  $days_between = ceil(abs($t1 - $t2) / 86400);
	
		    $t1 = strtotime($ADate2);
       $t2 = strtotime($res45transactiondate);
       $days_between = ceil(abs($t1 - $t2) / 86400);
       $snocount = $snocount + 1;
       $res2transactionamount =  $res45transactionamount;
        $debit_total = 0;
        if($days_between < 30)
      {
      if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
      $totalamount30 = $openingbalance + $res2transactionamount;
     
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount30 = $openingbalance - $res2transactionamount;
           
        }
      //$totalamount30 = $openingbalance + $res2transactionamount;
     
      }
      else
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
      $totalamount30 = $totalamount30 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount30 = $totalamount30 - $res2transactionamount;
        }
     //$totalamount30 = $totalamount30 + $res2transactionamount;
     
      }
      }
      else if(($days_between >=30) && ($days_between <=60))
      {
      if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
            $totalamount60 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount60 = $openingbalance - $res2transactionamount;
        }
      //$totalamount60 = $openingbalance + $res2transactionamount;
      }
      else
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
            $totalamount60 = $totalamount60 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount60 = $totalamount60 - $res2transactionamount;
        }
     // $totalamount60 = $totalamount60 + $res2transactionamount;
      }
      }
      else if(($days_between >60) && ($days_between <=90))
      {
      if($snocount == 1)
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
            $totalamount90 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount90 = $openingbalance - $res2transactionamount;
        }
      //$totalamount90 = $openingbalance + $res2transactionamount;
      }
      else
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
            $totalamount90 = $totalamount90 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount90 = $totalamount90 - $res2transactionamount;
        }
     // $totalamount90 = $totalamount90 + $res2transactionamount;
      }
      }
      else if(($days_between >90) && ($days_between <=120))
      {
      if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
            $totalamount120 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount120 = $openingbalance - $res2transactionamount;
        }
      //$totalamount120 = $openingbalance + $res2transactionamount;
      }
      else
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
            $totalamount120 = $totalamount120 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount120 = $totalamount120 - $res2transactionamount;
        }
     // $totalamount120 = $totalamount120 + $res2transactionamount;
      }
      }
      else if(($days_between >120) && ($days_between <=180))
      {
        if($snocount == 1)
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
            $totalamount180 = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount180 = $openingbalance - $res2transactionamount;
        }
      //$totalamount180 = $openingbalance + $res2transactionamount;
      }
      else
      {
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
            $totalamount180 = $totalamount180 + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamount180 = $totalamount180 - $res2transactionamount;
        }
      //$totalamount180 = $totalamount180 + $res2transactionamount;
      }
      }
      else
      {
          if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
            $totalamountgreater = $openingbalance + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamountgreater = $openingbalance - $res2transactionamount;
        }
      //$totalamountgreater = $openingbalance + $res2transactionamount;
      }
      else
      {
      
       if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
            $totalamountgreater = $totalamountgreater + $res2transactionamount;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
           $totalamountgreater = $totalamountgreater - $res2transactionamount;
        }
        //$totalamountgreater = $totalamountgreater + $res2transactionamount;
      }
      }
      
           if($snocount == 1)
      {
     // $totalat = $openingbalance + $res45amount;
      
      if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
      $totalat = $openingbalance + $res45transactionamount ;
        }
        else if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
          $totalat = $openingbalance - $res45transactionamount;
        }
      
      
      }
      else
      {
     // $totalat = $totalat + $res45amount;
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote' || $transtable == 'master_journalentries')
        {
      $totalat = $totalat + $res45transactionamount ;
        }
        if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
        $totalat = $totalat - $res45transactionamount;
       }
        
      }
					 
		 
			?>
           
		
			<?php 
			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
			//$grandtotal = $totalat;
			$fulltotal1 = $fulltotal1 + $grandtotal;
			$fulltotalamount301 = $fulltotalamount301 + $totalamount30;
			$fulltotalamount601 = $fulltotalamount601 + $totalamount60;
			$fulltotalamount901 = $fulltotalamount901 + $totalamount90;
			$fulltotalamount1201 = $fulltotalamount1201 + $totalamount120;
			$fulltotalamount1801 = $fulltotalamount1801 + $totalamount180;
			$fulltotalamountgreater1 = $fulltotalamountgreater1 + $totalamountgreater;
			$fulltotal = $fulltotal + $grandtotal;
			$fulltotalamount30 = $fulltotalamount30 + $totalamount30;
			$fulltotalamount60 = $fulltotalamount60 + $totalamount60;
			$fulltotalamount90 = $fulltotalamount90 + $totalamount90;
			$fulltotalamount120 = $fulltotalamount120 + $totalamount120;
			$fulltotalamount180 = $fulltotalamount180 + $totalamount180;
			$fulltotalamountgreater = $fulltotalamountgreater + $totalamountgreater;
}
if($fulltotal1>0){
	
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
			?>
			 <tr>
              <td class="bodytext31" valign="center"  align="left"><?php  echo $snocount_main; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php  echo $doctorname; ?></td>
             
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($fulltotal1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"> <?php echo number_format($fulltotalamount301,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($fulltotalamount601,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($fulltotalamount901,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($fulltotalamount1201,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			 <?php echo number_format($fulltotalamount1801,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($fulltotalamountgreater1,2,'.',','); ?></div></td>
			
               
           </tr>
			<?php 
}
$fulltotal1=0;
$fulltotalamount301=0;
$fulltotalamount601=0;
$fulltotalamount901=0;
$fulltotalamount1201=0;
$fulltotalamount1801=0;
$fulltotalamountgreater1=0;
			 $totalat=0;
			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamountgreater=0;
			} ?>
         <tr <?php  echo $colorcode; ?>>
              
         	<td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>
             
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($fulltotal,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"> <strong><?php echo number_format($fulltotalamount30,2,'.',','); ?></strong></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($fulltotalamount60,2,'.',','); ?></strong></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($fulltotalamount90,2,'.',','); ?></strong></div></td>
                 <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($fulltotalamount120,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right">
			 <strong><?php echo number_format($fulltotalamount180,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><strong><?php echo number_format($fulltotalamountgreater,2,'.',','); ?></strong></div></td>
           </tr>
          
       </tbody>
	</table>
<?php }
?>