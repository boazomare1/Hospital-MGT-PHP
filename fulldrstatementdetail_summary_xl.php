<?php 

session_start();
header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="doctorwisedetailedreport.xls"');

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

$totalat1 = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$arraysuppliername = '';

$arraysuppliercode = '';	

$totalatret = 0.00;





$totalamountgreater = 0;

		  

$docno = $_SESSION['docno'];



$query01="select locationcode from login_locationdetails where username='$username' and docno='$docno'";

$exe01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

$res01=mysqli_fetch_array($exe01);

 $locationcode=$res01['locationcode'];



include ("autocompletebuild_doctor.php");





if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) {  $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["location"])) {  $location = $_REQUEST["location"]; } else { $location = ""; }





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



?>
 
 

 

</style>

</head>

<body>

<table width="700" border="0" cellspacing="0" cellpadding="2">
          <tbody>
  
          	<tr bgcolor="#ffffff">

            <td colspan="18"  align="center" valign="center"  ><strong>Doctor Wise Detailed Statement</strong></td>

            </tr> 
          	<tr bgcolor="#ffffff">

            <td colspan="18"  align="center" valign="center" ><strong>Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?></strong></td>

            </tr> 
            <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
           

            <tr bgcolor="#ffffff">

              <td  valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff"  ><div align="left"><strong>Doctor</strong></div></td>
                 <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff"  ><div align="left"><strong>Patient</strong></div></td>

              <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" ><strong> Bill No.	 </strong></td>
                  <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" ><strong> Account	 </strong></td>

                   <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" ><strong> Bill Date	 </strong></td>
                <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" ><strong> Bill Type	 </strong></td>
                 <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" ><strong>Alloted </strong></td>
                 <td width="6%" align="right" valign="center"  

                bgcolor="#ffffff" ><strong> Org. Bill</strong></td>

				<td width="6%" align="right" valign="center"  

                bgcolor="#ffffff" ><strong>Parcentage</strong></td>

				<td width="6%" align="right" valign="center"  

                bgcolor="#ffffff" ><strong>Doc. Share</strong></td>

                 <td width="6%" align="right" valign="center"  

                bgcolor="#ffffff" ><strong> Bal. Amt</strong></td>
                <td width="6%" align="right" valign="center"  

                bgcolor="#ffffff" ><strong> 30 days</strong></td>

                 <td width="6%" align="right" valign="center"  

                bgcolor="#ffffff" ><strong> 60 days </strong></td>
                 <td width="6%" align="right" valign="center"  

                bgcolor="#ffffff" ><strong> 90 days</strong></td>

              <td width="6%" align="right" valign="center"  

                bgcolor="#ffffff" ><div align="right"><strong>120 days</strong></div></td>

              <td width="6%" align="left" valign="right"  

                bgcolor="#ffffff" ><div align="right"><strong>180 days</strong></div></td>

				<td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" ><div align="center"><strong>180+ days</strong></div></td>

				

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

				$snocount_invoice = 0;

				$total_debitamt = 0;
				$totalatorginal = 0;
				$fulltotalatorginal = 0;
				$doct_wise_amt = 0;
				$doct_wise_orgamt = 0;
				if (isset($_REQUEST["searchsuppliername"])) { $suppliername = $_REQUEST["searchsuppliername"]; } else { $suppliername = ""; }

				if (isset($_REQUEST["searchsuppliercode"])) {  $suppliercode = $_REQUEST["searchsuppliercode"]; } else { $suppliercode = ""; }

					$arraysupplier = explode("#", $suppliername);

					$suppliername = $arraysupplier[0];

					$suppliername = trim($suppliername);

					$res21accountname = $suppliername ;

					$snocount = 0;
					
					
					if($location=='All')
					{
					$pass_location = "and locationcode !=''";
					}
					else
					{
					$pass_location = "and locationcode ='$location'";
					}
					
					
					if($suppliername !="")
					{
					$query233 = "select docno,doccoa,description as doctorname from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' $pass_location group by doccoa order by recorddate,docno ";
					}
					else
					{
					$query233 = "select docno,doccoa,description as doctorname from billing_ipprivatedoctor where amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' $pass_location group by doccoa order by recorddate,docno ";
				    }
					
					$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));

			//$num233=mysql_num_rows($exec233);
			

			while($res233 = mysqli_fetch_array($exec233))	
			{

			$suppliercode = $res233['doccoa'];
			$suppliercode1 = $res233['docno'];
			$doctorname = $res233['doctorname'];

			$snocount_main = $snocount_main + 1;
			//////////// OPENING BALANCE //////////////////
			$openingbalance=0;
$orginalamount_total=0;
$totalamount30=0;
$total60=0;
$total90=0;
$total120=0;
$total180=0;
$total210=0;
$doctorperecentage=0;
$docperfinal=0;
$count_for_doc=0;

$totalamount30=0;
					$totalamount60=0;
					$totalamount90=0;
					$totalamount120=0;
					$totalamount180=0;
					$totalamountgreater=0;

$totalamount30_new=0;
$totalamount60_new=0;
$totalamount90_new=0;
$totalamount120_new=0;
$totalamount180_new=0;
$totalamountgreater_new=0;

			 $openingbalance =0;
         $totalat =0;

        

          $query234 = "SELECT mainset.* from (
		  (select recorddate as transdate,docno as documentno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor' as transtable  from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate < '$ADate1'  and docno <> '' $pass_location group by docno,doccoa order by recorddate,docno)
		  union (select transactiondate as transdate,billnumber as documentno,'' as billtype,visitcode,patientname,patientcode,accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$suppliercode' and transactiondate < '$ADate1' $pass_location order by transactiondate,auto_number)
		  union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_creditnote' as transtable from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate < '$ADate1' $pass_location order by consultationdate) 
		  union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_debitnote' as transtable from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate <'$ADate1' $pass_location order by consultationdate) 

          -- for ADP bills
           union (select transactiondate as transdate,docno as documentno,'' as billtype,'' as visitcode,'' as patientname,'' as patientcode, '' as accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, '0' as taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from advance_payment_entry where  ledger_code='$suppliercode' and recordstatus<>'deleted' and transactiondate <'$ADate1' $pass_location order by transactiondate,auto_number)

          union (SELECT recorddate as transdate,docno as documentno,billtype, visitcode visitcode,patientname,patientcode,accountname,'visittype' as visittype,sum(sharingamount) as sharingamount,percentage as percentage,sum(transactionamount) as transactionamount,pvtdr_percentage as pvtdr_percentage, sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor_refund' as transtable from billing_ipprivatedoctor_refund where doccoa = '$suppliercode' and recorddate < '$ADate1' $pass_location group by docno,doccoa order by recorddate,docno)
        ) mainset order by transdate";

      $exec234 = mysqli_query($GLOBALS["___mysqli_ston"], $query234) or die ("Error in Query234".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num234=mysqli_num_rows($exec234);
      while($res234 = mysqli_fetch_array($exec234))
      {
        $res45doctorperecentage = "";
        $res45transactiondate = $res234['transdate'];
        //$n_billdate = $res234
        $billnumber = $res234['documentno'];

        $billtype = $res234['billtype'];
        $res45visitcode = $res234['visitcode'];

        $query124 = "select * from master_visitentry where visitcode = '$res45visitcode'";
        $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($exec124) == 0)
        {
        $query124 = "select * from master_ipvisitentry where visitcode = '$res45visitcode'";
        $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
        }

        $res124 = mysqli_fetch_array($exec124);
        $billtype = $res124['billtype'];

        $res45patientname = $res234['patientname'];
        $res45patientcode = $res234['patientcode'];
        
        $res45accountname = $res234['accountname'];
        $res45vistype = $res234['visittype'];

        $transtable = $res234['transtable'];

        $description = "";
        $res45billamount = $res234['original_amt'];

        $orginalamount_total+=$res45billamount;

        $refno = $res234['refno'];

        $res45transactionamount = $res234['transactionamount'];
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'billing_ipprivatedoctor_refund')
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
        
         if($transtable == 'master_transactiondoctor')
        {
           $res45transactionamount = $res234['transactionamount'];

          $taxamount = $res234['taxamount'];

          $amtwithouttax = $res45transactionamount - $taxamount;
          $description =  "Payment ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res234['particulars']." )";


            $query124 = "select sum(original_amt) as original_amt,visittype,percentage,pvtdr_percentage from billing_ipprivatedoctor where doccoa='$suppliercode' and docno='$billnumber' and transactionamount >0";
            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res124 = mysqli_fetch_array($exec124);
            $res45billamount = $res124['original_amt'];
             $orginalamount_total+=$res45billamount;
            $res45vistype = $res124['visittype'];
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
         if($transtable == 'adhoc_creditnote')
        {
         $description =  "Credit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";

        
       }

        if($transtable == 'adhoc_debitnote')
        {
         $description =  "Debit Note ( ".$res45patientname." , ".$res45patientcode.",".$res45visitcode.",".$res45accountname."," .$refno." )";
        
       }
        $res45locationcode = $res234['locationcode'];
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

      

       $t1 = strtotime($ADate2);

       

      $t2 = strtotime($res45transactiondate);


     

      $days_between = ceil(abs($t1 - $t2) / 86400);

     
  
       $snocount = $snocount + 1;

     
      $res2transactionamount =  $res45transactionamount;

      

      $debit_total = 0;

     
      

      if($days_between <= 30)

      {

      if($snocount == 1)

      {



      if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

      else if(($days_between >30) && ($days_between <=60))

      {

      if($snocount == 1)

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

      
       if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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
      
      if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $totalat + $res45transactionamount ;
        }
        if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
        $totalat = $totalat - $res45transactionamount;
       }
        
      }

        

      }

        $grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;

						$fulltotalatorginal = $fulltotalatorginal + $grandtotal;		 
						$fulltotal = $fulltotal + $grandtotal;
						$fulltotalamount30 = $fulltotalamount30 + $totalamount30;
						$fulltotalamount60 = $fulltotalamount60 + $totalamount60;
						$fulltotalamount90 = $fulltotalamount90 + $totalamount90;
						$fulltotalamount120 = $fulltotalamount120 + $totalamount120;
						$fulltotalamount180 = $fulltotalamount180 + $totalamount180;
						$fulltotalamountgreater = $fulltotalamountgreater + $totalamountgreater;

						$doct_wise_amt+=$grandtotal;
						$doct_wise_orgamt+=$grandtotal;

						$totalamount30_new+=$totalamount30;
					$totalamount60_new+=$totalamount60;
					$totalamount90_new+=$totalamount90;
					$totalamount120_new+=$totalamount120;
					$totalamount180_new+=$totalamount180;
					$totalamountgreater_new+=$totalamountgreater;


			?>

			<tr  bgcolor="#ff944d" onClick="showsub(<?=$doc_anum?>)">
            		<td colspan="5" class="bodytext31" valign="center"  align="left"><strong><?php echo strtoupper($doctorname);?></strong></td>
            		 <td colspan="3" class="bodytext31" valign="center"  align="left"><div class="bodytext31">Opening Balance : </div></td>
            		 <!-- <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
            		 <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
            		 <td class="bodytext31" valign="center"  align="left">&nbsp;</td> -->
            		 <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php //echo number_format($orginalamount_total,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php // echo $docperfinal; ?></div></td>
            		 <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($grandtotal,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($grandtotal,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount60,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount90,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount120,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount180,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>

           </tr>
           <!-- /////////////////////////////////OPENING BALANCE //////////////////////////////// -->

		
		 

			<!-- <tr bgcolor="#ffffff">

            <td colspan="18"  align="left" valign="center" bgcolor="#ffffff"   ><strong><?php echo strtoupper($doctorname);?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>

            </tr> -->

			<?php
			// Get all invoices for the doctor
			// $doctor_invoice_qry = "select docno,billtype,patientname,visitcode,visittype from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' group by docno order by recorddate,docno";

			// $exec_invoice = mysql_query($doctor_invoice_qry) or die ("Error in Doctor Invoices Query".mysql_error());

			// while($resinvoice = mysql_fetch_array($exec_invoice))	
			// {
			if(1){


			// 	$snocount = 0;	
			// 	$invoiceno = $resinvoice['docno'];
			// 	$billtype = $resinvoice['billtype'];
			// 	$patientname = $resinvoice['patientname'];
			// 	$res45visitcode = $resinvoice['visitcode'];

			// 	$query11 = "SELECT billtype from master_visitentry where visitcode = '$res45visitcode'  ";
			// 	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			// 	$res11 = mysql_fetch_array($exec11);
			// 	$num11 =mysql_num_rows($exec11);
			// 				$num11 =mysql_num_rows($exec11);
			// 	if($num11 ==0)
			// 	{
			// 	$query11 = "SELECT billtype from master_ipvisitentry where  visitcode = '$res45visitcode' ";
			// 	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			// 	$res11 = mysql_fetch_array($exec11);
			// 	$num11 =mysql_num_rows($exec11);
			// 	if($num11 ==1)
			// 	    { $billtype = $res11['billtype']; }
			// 	}else{
			// 	$billtype = $res11['billtype'];}

			// 	 // get visit type
			// 	  $visittype = $resinvoice['visittype'];
			// 	// get sub type
			// 	  $subtypename = getsubtype($res45visitcode,$visittype);

			// 		$colorloopcount = $colorloopcount + 1;

			// $showcolor = ($colorloopcount & 1); 

			// if ($showcolor == 0)

			// {
			// 	$colorcode = 'bgcolor="#CBDBFA"';

			// }

			// else

			// {

			

			// 	$colorcode = 'bgcolor="#ecf0f5"';

			// }

				// OB
					// $querycr1op = "SELECT SUM(`transactionamount`) as openingbalance  FROM `billing_ipprivatedoctor` WHERE doccoa='$suppliercode1'  AND `recorddate` <  '$ADate1' and visittype='OP' and amount <> '0.00' and amount > 0  and docno <> ''";
					// 	$execcr1 = mysql_query($querycr1op) or die ("Error in querycr1op".mysql_error());
					// 	$rescr1 = mysql_fetch_array($execcr1);
					// 	$openingbalance = $rescr1['openingbalance']; 

					// $querycr1ip = "SELECT SUM(`sharingamount`) as openingbalance1  FROM `billing_ipprivatedoctor` WHERE doccoa='$suppliercode1'  AND `recorddate` <  '$ADate1' and visittype='IP' and amount <> '0.00' and amount > 0  and docno <> ''";
					// 	$execcr12 = mysql_query($querycr1ip) or die ("Error in querycr1ip".mysql_error());
					// 	$rescr12 = mysql_fetch_array($execcr12);
					// 	$openingbalance1 = $rescr12['openingbalance1']; 

					// 	$openingbalance =$openingbalance +$openingbalance1;


				  

				  // OB

					$snocount_invoice=0;
$openingbalance=0;
					$query234 = "SELECT mainset.* from (
					(select recorddate as transdate,docno as documentno,billtype,visitcode,patientname,patientcode,accountname,visittype,sum(sharingamount) as sharingamount,percentage,sum(transactionamount) as transactionamount,pvtdr_percentage,sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor' as transtable  from billing_ipprivatedoctor where doccoa='$suppliercode'  and amount <> '0.00' and amount > 0 and recorddate between '$ADate1' and '$ADate2'  and docno <> '' $pass_location group by docno,doccoa order by recorddate,docno)

           union (select transactiondate as transdate,billnumber as documentno,'' as billtype,visitcode,patientname,patientcode,accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from master_transactiondoctor where  debit_reference_no IS NULL and doctorcode='$suppliercode' and transactiondate between '$ADate1' and '$ADate2' $pass_location order by transactiondate,auto_number)
		   union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_creditnote' as transtable from adhoc_creditnote where billingaccountcode = '$suppliercode' and consultationdate between '$ADate1' and '$ADate2' $pass_location  order by consultationdate) 
		   union (SELECT consultationdate as transdate,docno as documentno,billtype,patientvisitcode visitcode,patientname,patientcode,accountname,'' as visittype,0 as sharingamount,'' as percentage,amount as transactionamount,'' as pvtdr_percentage, 0 as original_amt,locationcode,'' as taxamount,'' as particulars,ref_no as refno,'adhoc_debitnote' as transtable from adhoc_debitnote where billingaccountcode = '$suppliercode' and consultationdate between '$ADate1' and '$ADate2' $pass_location order by consultationdate) 

            -- for ADP bills
           union (select transactiondate as transdate,docno as documentno,'' as billtype,'' as visitcode,'' as patientname,'' as patientcode, '' as accountname,'' as visittype, 0 as sharingamount,'' as percentage, transactionamount,'' as pvtdr_percentage,0 as original_amt,'' as locationcode, '0' as taxamount,particulars,'' as refno,'master_transactiondoctor' as transtable  from advance_payment_entry where  ledger_code='$suppliercode' and recordstatus<>'deleted' and transactiondate between '$ADate1' and '$ADate2' $pass_location order by transactiondate,auto_number)

          union (SELECT recorddate as transdate,docno as documentno,billtype, visitcode visitcode,patientname,patientcode,accountname,visittype as visittype,sum(sharingamount) as sharingamount,percentage as percentage,sum(transactionamount) as transactionamount,pvtdr_percentage as pvtdr_percentage, sum(original_amt) as original_amt,locationcode,'' as taxamount,'' as particulars,'' as refno,'billing_ipprivatedoctor_refund' as transtable from billing_ipprivatedoctor_refund where doccoa = '$suppliercode' and recorddate between '$ADate1' and '$ADate2' $pass_location group by docno,doccoa order by recorddate,docno)
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
				  $subtypename = getsubtype($res45visitcode,$visittype);
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


            $query124 = "select sum(original_amt) as original_amt,visittype,percentage,pvtdr_percentage from billing_ipprivatedoctor where doccoa='$suppliercode' and docno='$billnumber' and transactionamount >0";
            $exec124 = mysqli_query($GLOBALS["___mysqli_ston"], $query124) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res124 = mysqli_fetch_array($exec124);
            $res45billamount = $res124['original_amt'];
            $res45vistype = $res124['visittype'];
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
        if($days_between <= 30)
      {
      if($snocount == 1)
      {
        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

      else if(($days_between >30) && ($days_between <=60))

      {

      if($snocount == 1)

      {

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

        if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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

      
       if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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
      
      if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
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
         if($transtable == 'billing_ipprivatedoctor' || $transtable == 'adhoc_debitnote')
        {
      $totalat = $totalat + $res45transactionamount ;
        }
        if($transtable == 'master_transactiondoctor' || $transtable == 'adhoc_creditnote' || $transtable == 'billing_ipprivatedoctor_refund')
        {
        $totalat = $totalat - $res45transactionamount;
       }
        
      }


$alloted_status = "No";
			  $bal_amt = $totalat - $total_debitamt;
			   if($billtype == 'PAY LATER')
			   {
			   		 $transc_amt = 0;
					$query27 = "select sum(receivableamount) as transactionamount from master_transactionpaylater where billnumber='$invoiceno' and (recordstatus='allocated' || recordstatus='')";


					$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));

					$num2 = mysqli_num_rows($exec27);

					$res27 = mysqli_fetch_array($exec27);

					$transc_amt = $res27['transactionamount'];

					if($totalat == $transc_amt)
					{
					$alloted_status = "Fully";
					}
					else if( ($transc_amt > 0 ) && ($transc_amt < $totalat ) )
					{
					$alloted_status = "Partly";
					}
					else if($transc_amt > $totalat )
					{
					$alloted_status = "Fully";
					}
					else
					{
					if($transc_amt == 0)
					{
					$alloted_status = "No";
					}
					}
					}


					if($billtype == 'PAY NOW' || strpos( $billnumber, "CF-" ) !== false)
					{
					$alloted_status = "Yes";
					}
		 	//$alloted_status = "yes";

					

					 if($totalat !=0){

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

            $totalatorginal=$totalat;
					 	$doct_wise_amt = $doct_wise_amt + $totalat;
					$doct_wise_orgamt = $doct_wise_orgamt + $totalatorginal;
			?>

			 <tr >

              <td  valign="center"  align="left"><?php  echo $snocount_invoice = $snocount_invoice+1; ?></td>

               <td  valign="center"  align="left" width="15%"><?php  echo $doctorname; ?></td>
                <td class="bodytext31" valign="center"  align="left" width="15%">
                  <?php 
                  if($patientname==''){
                         echo "PAYMENT (".$res234['particulars']." )";
                  }else{
                   echo $patientname; 
                  }
                   ?></td>
             

               <td  valign="center"  align="left">

                <div ><?php echo $invoiceno; ?></div></td>
                 <td  valign="center"  align="left">

                <div ><?php echo $subtypename; ?></div></td>

              <td  valign="center"  align="left">

                <div > <?php echo $res45transactiondate; ?></div></td>

                 <td  valign="center"  align="left">

                <div > <?php echo $billtype; ?></div></td>

                  <td  valign="center"  align="left">

                <div > <?php echo $alloted_status ?></div></td>
               <td  valign="center"  align="right">

                <div ><?php echo number_format($res45billamount,2,'.',','); ?></div></td>

				<td  valign="center"  align="right">

                <div ><?php echo $res45doctorperecentage ?></div></td>

				<td  valign="center"  align="right">

                <div ><?php echo number_format($totalatorginal,2,'.',','); ?></div></td>
                <td  valign="center"  align="right">

                <div ><?php echo number_format($totalat,2,'.',','); ?></div></td>
                 <td  valign="center"  align="right">

                <div ><?php echo number_format($totalamount30,2,'.',','); ?></div></td>
                 <td  valign="center"  align="right">

                <div ><?php echo number_format($totalamount60,2,'.',','); ?></div></td>

                 <td  valign="center"  align="right">

                <div ><?php echo number_format($totalamount90,2,'.',','); ?></div></td>
                 <td  valign="center"  align="right">

                <div ><?php echo number_format($totalamount120,2,'.',','); ?></div></td>
                 <td  valign="center"  align="right">

                <div ><?php echo number_format($totalamount180,2,'.',','); ?></div></td>

             

              <td  valign="center"  align="right">

			    <div align="right"><?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>

			

               

           </tr>
           <?php 

            $grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;

            $totalamount30_new+=$totalamount30;
					$totalamount60_new+=$totalamount60;
					$totalamount90_new+=$totalamount90;
					$totalamount120_new+=$totalamount120;
					$totalamount180_new+=$totalamount180;
					$totalamountgreater_new+=$totalamountgreater;
			

			$fulltotal = $fulltotal + $totalat;
			$fulltotalamount30 = $fulltotalamount30 + $totalamount30;
			$fulltotalamount60 = $fulltotalamount60 + $totalamount60;
			$fulltotalamount90 = $fulltotalamount90 + $totalamount90;
			$fulltotalamount120 = $fulltotalamount120 + $totalamount120;
			$fulltotalamount180 = $fulltotalamount180 + $totalamount180;
			$fulltotalamountgreater = $fulltotalamountgreater + $totalamountgreater;
			$fulltotalatorginal = $fulltotalatorginal + $totalatorginal;


            }?>
			
           <?php 

          /* $grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
			//$grandtotal = $totalat;

			//$fulltotal = $fulltotal + $grandtotal;

			$fulltotal = $fulltotal + $totalat;
			$fulltotalamount30 = $fulltotalamount30 + $totalamount30;
			$fulltotalamount60 = $fulltotalamount60 + $totalamount60;
			$fulltotalamount90 = $fulltotalamount90 + $totalamount90;
			$fulltotalamount120 = $fulltotalamount120 + $totalamount120;
			$fulltotalamount180 = $fulltotalamount180 + $totalamount180;
			$fulltotalamountgreater = $fulltotalamountgreater + $totalamountgreater;
			$fulltotalatorginal = $fulltotalatorginal + $totalatorginal;*/

           ?>
		   

         <?php 

             }
         	} // loop invoices


         	?>
			
			 <tr  onClick="showsub(<?=$doc_anum?>)">
            	<td bgcolor="#D3D3D3" colspan="6" class="bodytext31" valign="center"  align="right">&nbsp;</td>
             	<td bgcolor="#D3D3D3" colspan="4" class="bodytext31" valign="center"  align="right"><b>Sub Total : </b></td>
                <td bgcolor="#D3D3D3" class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><b><?php echo number_format($doct_wise_orgamt,2,'.',','); ?></b></div></td>
				<td bgcolor="#D3D3D3" class="bodytext31" valign="center"  align="right"> <div class="bodytext31"><b><?php echo number_format($doct_wise_amt,2,'.',','); ?></b></div></td>


                <td bgcolor="#D3D3D3" class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamount30_new,2,'.',','); ?></b></div></td>
                <td bgcolor="#D3D3D3" class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamount60_new,2,'.',','); ?></b></div></td>
                <td bgcolor="#D3D3D3" class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamount90_new,2,'.',','); ?></b></div></td>
                <td bgcolor="#D3D3D3" class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamount120_new,2,'.',','); ?></b></div></td>
                <td bgcolor="#D3D3D3" class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamount180_new,2,'.',','); ?></b></div></td>
                <td bgcolor="#D3D3D3" class="bodytext31" valign="center"  align="right"><div class="bodytext31"><b><?php echo number_format($totalamountgreater_new,2,'.',','); ?></b></div></td>
                <!-- <td colspan="7" class="bodytext31" valign="center"  align="right">&nbsp;</td> -->
           </tr>

            <?php 
            $doct_wise_amt =0;$doct_wise_orgamt =0;

            		$totalamount30_new=0;
					$totalamount60_new=0;
					$totalamount90_new=0;
					$totalamount120_new=0;
					$totalamount180_new=0;
					$totalamountgreater_new=0;

          		} // loop doctors

         
          ?>


         <tr bgcolor="#ffffff">

              
         	<td bgcolor="#ffffff"  valign="center"  align="left" colspan="6"></td>
               <td bgcolor="#ffffff"  valign="center" colspan="4" align="left"><strong>Total</strong></td>
             
               <td bgcolor="#ffffff"  valign="center"  align="right">

                <div ><strong><?php echo number_format($fulltotalatorginal,2,'.',','); ?></strong></div></td>
               <td bgcolor="#ffffff"  valign="center"  align="right">

                <div ><strong><?php echo number_format($fulltotal,2,'.',','); ?></strong></div></td>

              <td bgcolor="#ffffff"  valign="center"  align="right">

                <div > <strong><?php echo number_format($fulltotalamount30,2,'.',','); ?></strong></div></td>

                 <td bgcolor="#ffffff"  valign="center"  align="right">

                <div ><strong><?php echo number_format($fulltotalamount60,2,'.',','); ?></strong></div></td>
                 <td bgcolor="#ffffff"  valign="center"  align="right">

                <div ><strong><?php echo number_format($fulltotalamount90,2,'.',','); ?></strong></div></td>
                 <td bgcolor="#ffffff"  valign="center"  align="right">

                <div ><strong><?php echo number_format($fulltotalamount120,2,'.',','); ?></strong></div></td>

              <td bgcolor="#ffffff"  valign="center"  align="right">

			 <strong><?php echo number_format($fulltotalamount180,2,'.',','); ?></strong></td>

              <td bgcolor="#ffffff"  valign="center"  align="right">

			    <div align="right"><strong><?php echo number_format($fulltotalamountgreater,2,'.',','); ?></strong></div></td>

           </tr>
       </tbody>

 </table>


<?php }

function getsubtype($visitcode,$visittype='')
{
	
	$subtypeid = 0;
	$subtypename = "";

	if(trim($visittype) =="")
	{
		
		$haystack = $visitcode;
		$needle   = "IPV";

		if( strpos( $haystack, $needle ) !== false) {
		    $visittype = "IP";
		}
		else
		{
			$visittype = "OP";
		}

	}
	if($visittype == 'OP')
	{
		$queryacc = "select subtype from master_visitentry where visitcode='$visitcode'";
		$execacc = mysqli_query($GLOBALS["___mysqli_ston"], $queryacc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$resacc = mysqli_fetch_array($execacc);
		$subtypeid = $resacc['subtype'];
		
	}
	else
	{
		$queryacc = "select subtype from master_ipvisitentry where visitcode='$visitcode'";
		$execacc = mysqli_query($GLOBALS["___mysqli_ston"], $queryacc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$resacc = mysqli_fetch_array($execacc);
		$subtypeid = $resacc['subtype'];
	}

	if($subtypeid > 0)
		{
			$queryaccsub = "select subtype from master_subtype where auto_number='$subtypeid'";
			$execaccsub = mysqli_query($GLOBALS["___mysqli_ston"], $queryaccsub) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resaccsub = mysqli_fetch_array($execaccsub);
			$subtypename = $resaccsub['subtype'];
		}
	return $subtypename;
}
?>


