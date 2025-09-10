<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');


header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Hospitalrevenuereportdetailed.xls"');

header('Cache-Control: max-age=80');


$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 

  $transactiondatefrom=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:'';

   $transactiondateto=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:'';

   if($transactiondatefrom=='')

   {

   $transactiondatefrom = date('Y-m-d', strtotime('-1 month')); }

    if($transactiondateto==''){

   $transactiondateto =  date('Y-m-d');}

 

?>

 
      

 
</head>



<script>



function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here



</script>

<script src="js/datetimepicker_css.js"></script>



<body>
 
	

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }



if ($cbfrmflag1 == 'cbfrmflag1')

{



	$fromdate=$_REQUEST['ADate1'];

	$todate=$_REQUEST['ADate2'];



	

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1479" 

            align="left" border="0">

          <tbody>
          		<!-- ////////////OP STARTS /////////////////// -->
          		     <!-- /////////////////////////// OP REVENUE DETAILED STARTS ///////////////////// -->
      <tr>
     <td>
        <!-- TABLE FOR OP REVENUE REPORT-->
       
       <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" align="left" border="0">
          <tbody>
          	<tr>
            	<td align="center" colspan="14" bgcolor="#ecf0f5" class="bodytext3"><strong>Hospital Detail : OP & IP Revenues </strong></td>
                </td>
               
            </tr>
		   <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				?>
            <tr>
            <td colspan="14" bgcolor="#ecf0f5" class="bodytext3"><strong>Hospital Detail : OP Revenue  &nbsp; From &nbsp;<?php echo date('d-M-Y',strtotime($_REQUEST['ADate1'])); ?> To <?php echo date('d-M-Y',strtotime($_REQUEST['ADate2'])); ?></strong></td>
              
                </td>
               
            </tr>
            
			
              <tr>
              	  <!-- <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td> -->
              	  <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Sl No.</strong></td>
              	  <td width="15%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bill Dt</strong></td>
              	  <td width="15%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bill No.</strong></td>
              	  <td width="30%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
              	  <td width="20%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Patient Code</strong></td>
              	  <td width="20%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Consultation</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Laboratory</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Radiology</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Service</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Referal</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Rescue</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Home Care</strong></td>
                  <td width="10%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
              </tr>

<?php
$total=0;
$snocount=0;
$colorloopcount=0;
$refexternal=0;

$consultation_1=0;
$pharmacy_1=0;
$lab_1=0;
$radio_1=0;
$services_1=0;
$ref_1=0;
$rescue_1=0;
$homecare_1=0;

$consultation_2=0;
$pharmacy_2=0;
$lab_2=0;
$radio_2=0;
$services_2=0;
$ref_2=0;
$rescue_2=0;
$homecare_2=0;
$subtotal_2=0;
$subtotal_1=0;
$serial=0;

		if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
		if ($cbfrmflag1 == 'cbfrmflag1')
			{
				$transactiondatefrom=$_REQUEST['ADate1'];
				$transactiondateto=$_REQUEST['ADate2'];
		        if(1)
				{
				$location = $locationcode1;
			//**CONSULTATION**//
			//CASH
			$query_op = "SELECT patientcode, patientvisitcode as  visitcode, patientname, billnumber as billno, billdate as billdate  from billing_consultation where  locationcode='$location' and billdate between '$transactiondatefrom' and '$transactiondateto' group by billno
			union all SELECT patientcode,visitcode, patientname, billno as billno, billdate as billdate   from billing_paynow where  locationcode='$location' and  billdate between '$transactiondatefrom' and '$transactiondateto' group by billno
			UNION ALL select patientcode,visitcode, patientname, billno as billno, billdate as billdate    from billing_paylater where locationcode='$location' and  billdate between '$transactiondatefrom' and '$transactiondateto'
			union all SELECT patientcode,visitcode, patientname, docno as billno, recorddate as billdate   from billing_opambulance where  locationcode='$location' and  recorddate between '$transactiondatefrom' and '$transactiondateto' group by billno
			union all SELECT patientcode,visitcode, patientname, docno as billno, recorddate as billdate  from billing_homecare where  locationcode='$location' and  recorddate between '$transactiondatefrom' and '$transactiondateto' group by billno
			";
			// UNION ALL select patientcode,visitcode, patientname  from billing_paynow where locationcode='$location' and  billdate between '$transactiondatefrom' and '$transactiondateto' 
			$exec_op = mysqli_query($GLOBALS["___mysqli_ston"], $query_op) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_op = mysqli_fetch_array($exec_op)){
				$patientcode_op = $res_op['patientcode'];
				$patientname_op = $res_op['patientname'];
				$visitcode_op = $res_op['visitcode'];
				$billno_op = $res_op['billno'];
				$billdate_op  = $res_op['billdate'];


			//**CONSULTATION**//
			//CASH
			 $query1 = "SELECT sum(consultation) as billamount1 from billing_consultation where billnumber='$billno_op'   ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			
			//CREDIT
			$query1 = "SELECT sum(fxamount) as billamount1 from billing_paylaterconsultation where billno='$billno_op' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res2consultationamount = $res1['billamount1'];
			// $res2consultationamount=0;
			
			//REFUND
			// $query12 = "select sum(consultation) as consultation1 from refund_consultation where locationcode='$location' and  patientcode='$patientcode_op' and patientvisitcode='$visitcode_op' ";
			// $exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			// $res12 = mysql_fetch_array($exec12);
			// $res12refundconsultation = $res12['consultation1'];
			$res12refundconsultation=0;
			
			//TOTAL CONSULTATION CALCULATION
			$tot_consult = $res1consultationamount + $res2consultationamount - $res12refundconsultation;

			//**ENDS**//
			?>
		   <?php
		  //**PHARMACY**//
		  //CASH
		  $query9 = "select sum(fxamount) as amount1 from billing_paynowpharmacy where locationcode='$location' and   billnumber='$billno_op'  "; 
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9pharmacyitemrate = $res9['amount1'];
		
			//CREDIT
			$query8 = "select sum(fxamount) as amount1 from billing_paylaterpharmacy where locationcode='$location' and   billnumber='$billno_op' ";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8pharmacyitemrate = $res8['amount1'];
			
			//EXTERNAL
			$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where locationcode='$location' and   billnumber='$billno_op' "; 
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$res17pharmacyitemrate = $res17['amount1'];
			
			 
			$totalrefundpharmacy =0;
			
			//TOTAL PHARMACY CALCULATION
			$tot_pharmacy = $res9pharmacyitemrate + $res8pharmacyitemrate + $res17pharmacyitemrate - $totalrefundpharmacy;
			//**ENDS**//
		?>
        <?php	
			//**LABARATORY**//
			
			//CASH
			$query3 = "select sum(fxamount) as labitemrate1 from billing_paynowlab where locationcode='$location' and billnumber='$billno_op' "; 
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];
			
			//CREDIT
			$query2 = "select sum(fxamount) as labitemrate1 from billing_paylaterlab where locationcode='$location' and billnumber='$billno_op' "; 
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$res2labitemrate = $res2['labitemrate1'];
			
			//EXTERNAL
			$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where locationcode='$location' and billnumber='$billno_op' "; 
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			$res14labitemrate = $res14['labitemrate1'];
			
			 
			$totalrefundlab = 0;
			
			//TOTAL LAB CALCULATION
			$tot_lab = $res3labitemrate + $res2labitemrate + $res14labitemrate - $totalrefundlab;
			
			//**ENDS**//
			?>
		   <?php
			//**RADIOLOGY**//
			
			//CASH
			$query5 = "select sum(fxamount) as radiologyitemrate1 from billing_paynowradiology where locationcode='$location' and billnumber='$billno_op' "; 
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			
			//CREDIT
			$query4 = "select sum(fxamount) as radiologyitemrate1 from billing_paylaterradiology where locationcode='$location'  and billnumber='$billno_op' "; 
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4radiologyitemrate = $res4['radiologyitemrate1'];
			
			//EXTERNAL
			$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where locationcode='$location'  and billnumber='$billno_op' "; 
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res15 = mysqli_fetch_array($exec15);
			$res15radiologyitemrate = $res15['radiologyitemrate1'];
			
			 
			$totalrefundradio = 0;
			
			//TOTAL RADIOLOGY CALCULATION
			$tot_radiol = $res5radiologyitemrate + $res4radiologyitemrate + $res15radiologyitemrate - $totalrefundradio;
			//**ENDS**//
			?>
		   
		   <?php
			//**SERVICES**//
			
			//CASH
			$query7 = "select sum(fxamount) as servicesitemrate1 from billing_paynowservices where billnumber='$billno_op' "; 
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7servicesitemrate = $res7['servicesitemrate1'];
			
			//CREDIT
			$query6 = "select sum(fxamount) as servicesitemrate1 from billing_paylaterservices where  billnumber='$billno_op' "; 
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6servicesitemrate = $res6['servicesitemrate1'];
			
			//EXTERNAL
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where  billnumber='$billno_op' "; 
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res16 = mysqli_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
			
			 
			$totalrefundservice = 0;
			
			//TOT SERVICE CALCULATION
			$tot_serv = $res7servicesitemrate + $res6servicesitemrate + $res16servicesitemrate - $totalrefundservice;
			
			//**ENDS**//
			?>
            <?php
			//**REFERALS**//
			
			//CASH
			$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where billnumber='$billno_op' "; 
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11referalitemrate = $res11['referalrate1'];
			
			//CREDIT
			$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billnumber='$billno_op' "; 
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$res10referalitemrate = $res10['referalrate1'];
		
			 
			$totalrefundreferal =0;
			
			//TOTAL REFERAL CALCULATIONS
			$tot_reffer = $res11referalitemrate + $res10referalitemrate + $total - $totalrefundreferal;
			//**ENDS**//
			?>
             <?php
			//**RESCUE**//
			//CASH
			$query30 = "select sum(amount) as amount1 from billing_opambulance where docno='$billno_op' ";
			$exec30= mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30) ;
			$res30rescue = $res30['amount1'];
			 // $res30rescue = 0;
			
			//CREDIT
			$query31 = "select sum(amount) as amount1 from billing_opambulancepaylater where billnumber='$billno_op' ";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31) ;
			$res31rescue = $res31['amount1'];
			
			//TOTAL RESCUE CALCULATION
			$totalrescue = $res30rescue + $res31rescue;
			
			//**ENDS**//
			?>
            <?php
			//**HOME CARE**//
		    
			//CASH
		    $query28 = "select sum(amount) as amount1 from billing_homecare where docno='$billno_op' ";
			$exec28= mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28) ;
			$res28homecare = $res28['amount1'];
			// $res28homecare = 0;
			
			//CREDIT
			$query29 = "select sum(amount) as amount1 from billing_homecarepaylater where billnumber='$billno_op' ";
			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res29 = mysqli_fetch_array($exec29) ;
			$res29homecare = $res29['amount1'];
			
			//TOTAL HOME CARE CALCULATION
			$totalhomecare = $res28homecare + $res29homecare;
			
			//**ENDS**//
			?>
           
			<?php
		
			
			$snocount = $snocount + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				//$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				//$colorcode = 'bgcolor="#ecf0f5"';
			}
			
			//TOTAL ON REVENUE TYPE
			//for cash total
		 $cashtotal = $res1consultationamount + $res9pharmacyitemrate + $res3labitemrate + $res5radiologyitemrate + $res7servicesitemrate + $res11referalitemrate + $res30rescue + $res28homecare;
			
			//for credit total
			 $credittotal = $res2consultationamount + $res8pharmacyitemrate + $res2labitemrate + $res4radiologyitemrate + $res6servicesitemrate + $res10referalitemrate + $res31rescue + $res29homecare;
			
			//for external total
			$externaltotal = $res17pharmacyitemrate + $res14labitemrate + $res15radiologyitemrate + $res16servicesitemrate + $refexternal;
			
			//for refund total
			 $refundtotal = $res12refundconsultation + $totalrefundpharmacy + $totalrefundlab + $totalrefundradio + $totalrefundservice + $totalrefundreferal;
			
			//grand total of totals
			$holetotal1 = $cashtotal + $credittotal + $externaltotal - $refundtotal;

			$consultation_1=$res1consultationamount+$res2consultationamount-$res12refundconsultation;
			$pharmacy_1=$res9pharmacyitemrate+$res8pharmacyitemrate+$res17pharmacyitemrate-$totalrefundpharmacy;
			$lab_1=$res3labitemrate+$res2labitemrate+$res14labitemrate-$totalrefundlab;
			$radio_1=$res5radiologyitemrate+$res4radiologyitemrate+$res15radiologyitemrate-$totalrefundradio;
			$services_1=$res7servicesitemrate+$res6servicesitemrate+$res16servicesitemrate-$totalrefundservice;
			$ref_1=$res11referalitemrate+$res10referalitemrate+$refexternal-$totalrefundreferal;

			$rescue_1=$res30rescue+$res31rescue;
			$homecare_1=$res28homecare+$res29homecare;

			$subtotal_1=$consultation_1+$pharmacy_1+$lab_1+$radio_1+$services_1+$ref_1+$rescue_1+$homecare_1;


			$consultation_2+=$consultation_1;
			$pharmacy_2+=$pharmacy_1;
			$lab_2+=$lab_1;
			$radio_2+=$radio_1;
			$services_2+=$services_1;
			$ref_2+=$ref_1;
			$rescue_2+=$rescue_1;
			$homecare_2+=$homecare_1;
			$subtotal_2+=$subtotal_1;

			$serial = $serial + 1;
			$showcolor1 = ($serial & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#ecf0f5"';
			}
			?>
          <tr >
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$serial;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$billdate_op;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$billno_op;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$patientname_op;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$patientcode_op;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$visitcode_op;?></strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($consultation_1,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo  number_format($pharmacy_1,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($lab_1,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($radio_1,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($services_1,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($ref_1,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($rescue_1,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($homecare_1,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($subtotal_1,2,'.',','); ?></strong></div></td>
       
               </tr>
               
              
              
            <?php }  // while
           //exit();  ?>

            <!-- ///////////////////////////////////////////////////// REFUNDS STARTS /////////////////////////////////////////			 -->
<?php
$query_refund="SELECT patientcode,visitcode, patientname, billnumber as billno, transactiondate as billdate from refund_paynow where  locationcode='$location' and  transactiondate between '$transactiondatefrom' and '$transactiondateto'  
			UNION ALL SELECT patientcode,visitcode, patientname, billno as billno, billdate as billdate from refund_paylater where  locationcode='$location' and  billdate between '$transactiondatefrom' and '$transactiondateto'  
			UNION ALL SELECT patientcode,visitcode, patientname, billno as billno, entrydate as billdate from billing_patientweivers where  locationcode='$location' and entrydate between '$transactiondatefrom' and '$transactiondateto'
			";
			// UNION ALL SELECT patientcode,patientvisitcode as visitcode, patientname, billnumber as billno from refund_consultation where  locationcode='$location' and  billdate between '$transactiondatefrom' and '$transactiondateto'  group by visitcode

			$exec_refund = mysqli_query($GLOBALS["___mysqli_ston"], $query_refund) or die ("Error in query1123".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_refund = mysqli_fetch_array($exec_refund)){
				$patientcode_refund = $res_refund['patientcode'];
				$patientname_refund = $res_refund['patientname'];
				$visitcode_refund = $res_refund['visitcode'];
				$billno_refund = $res_refund['billno'];
				$billdate_refund = $res_refund['billdate'];


			// 	$query121 = "select sum(consultationfxamount) as consultation1 from billing_patientweivers where billno='$billno_refund' ";
			// $exec121 = mysql_query($query121) or die ("Error in Query121".mysql_error());
			// $res121 = mysql_fetch_array($exec121);
			// $res12refundconsultation = $res121['consultation1'];

//REFUND
			$query12 = "select sum(consultation) as consultation1 from refund_consultation where billnumber='$billno_refund'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12refundconsultation1 = $res12['consultation1'];

			$query12 = "select sum(consultation) as consultation1 from refund_paylaterconsultation where billnumber='$billno_refund'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12refundconsultation2 = $res12['consultation1'];

			$query222 = "select sum(consultationfxamount) as amount1 from billing_patientweivers where billno='$billno_refund'";
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222) ;
			$res12refundconsultation3 = $res222['amount1'];

			$res12refundconsultation=$res12refundconsultation1+$res12refundconsultation2+$res12refundconsultation3;

//REFUND pharmacy
			$query21 = "select sum(amount)as amount1 from refund_paylaterpharmacy where billnumber='$billno_refund'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21) ;
			$res21refundlabitemrate = $res21['amount1'];

			$query22 = "select sum(amount)as amount1 from refund_paynowpharmacy where billnumber='$billno_refund'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundlabitemrate = $res22['amount1'];

			$query221 = "select sum(pharmacyfxamount) as amount1 from billing_patientweivers where `billno`='$billno_refund'";
			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res221 = mysqli_fetch_array($exec221) ;
			$res22refundlabitemrate1 = $res221['amount1'];
			

			$query21p = "SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE  `billnumber`='$billno_refund'";
			$exec21p = mysqli_query($GLOBALS["___mysqli_ston"], $query21p) or die ("Error in Query21p".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21p = mysqli_fetch_array($exec21p) ;
		    $res21prefundlabitemrate = $res21p['amount1'];

		    $totalrefundpharmacy = $res22refundlabitemrate + $res21refundlabitemrate+$res21prefundlabitemrate+$res22refundlabitemrate1;



			//REFUND LAB
			$query19 = "select sum(labitemrate)as labitemrate1 from refund_paylaterlab where billnumber='$billno_refund'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res19 = mysqli_fetch_array($exec19) ;
			$res19refundlabitemrate = $res19['labitemrate1'];
			$query20 = "select sum(labitemrate)as labitemrate1 from refund_paynowlab where billnumber='$billno_refund'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res20 = mysqli_fetch_array($exec20) ;
			$res20refundlabitemrate = $res20['labitemrate1'];

			$query222 = "select sum(labfxamount) as amount1 from billing_patientweivers where `billno`='$billno_refund'";
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222) ;
			$res20refundlabitemrate1 = $res222['amount1'];

			$totalrefundlab = $res20refundlabitemrate + $res19refundlabitemrate+$res20refundlabitemrate1;


			//REFUND radiology
			$query22 = "select sum(fxamount)as radiologyitemrate1 from refund_paylaterradiology where billnumber='$billno_refund'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundradioitemrate = $res22['radiologyitemrate1'];
			$query23 = "select sum(radiologyitemrate)as radiologyitemrate1 from refund_paynowradiology where billnumber='$billno_refund'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23) ;
			$res23refundradioitemrate = $res23['radiologyitemrate1'];

			$query223 = "select sum(radiologyfxamount) as amount1 from billing_patientweivers where `billno`='$billno_refund'";
			$exec223 = mysqli_query($GLOBALS["___mysqli_ston"], $query223) or die ("Error in Query223".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res223 = mysqli_fetch_array($exec223) ;
			$res23refundradioitemrate1 = $res223['amount1'];

			$totalrefundradio = $res23refundradioitemrate + $res22refundradioitemrate+$res23refundradioitemrate1;

			//REFUND services
			$query24 = "select sum(fxamount)as servicesitemrate1 from refund_paylaterservices where billnumber='$billno_refund'";
			$exec24= mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24) ;
			$res24refundserviceitemrate = $res24['servicesitemrate1'];
			$query25 = "select sum(servicetotal)as servicesitemrate1 from refund_paynowservices where billnumber='$billno_refund'";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25) ;
			$res25refundserviceitemrate = $res25['servicesitemrate1'];

			$query225 = "select sum(servicesfxamount) as amount1 from billing_patientweivers where `billno`='$billno_refund'";
			$exec225 = mysqli_query($GLOBALS["___mysqli_ston"], $query225) or die ("Error in Query225".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res225 = mysqli_fetch_array($exec225) ;
			$res25refundserviceitemrate1 = $res225['amount1'];

			$totalrefundservice = $res25refundserviceitemrate + $res24refundserviceitemrate+$res25refundserviceitemrate1;


			//REFUNDS
			$query26 = "select sum(referalrate)as referalrate1 from refund_paylaterreferal where billnumber='$billno_refund'";
			$exec26= mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res26 = mysqli_fetch_array($exec26) ;
			$res26refundreferalitemrate = $res26['referalrate1'];
			$query27 = "select sum(referalrate)as referalrate1 from refund_paynowreferal where billnumber='$billno_refund'";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res27 = mysqli_fetch_array($exec27) ;
			$res27refundreferalitemrate = $res27['referalrate1'];
			$totalrefundreferal = $res27refundreferalitemrate + $res26refundreferalitemrate;

			 $refundtotal = $res12refundconsultation + $totalrefundpharmacy + $totalrefundlab + $totalrefundradio + $totalrefundservice + $totalrefundreferal;

$consultation_ref=$res12refundconsultation;
$pharmacy_ref=$totalrefundpharmacy;
$lab_ref=$totalrefundlab;
$radio_ref=$totalrefundradio;
$services_ref=$totalrefundservice;
$ref_ref=$totalrefundreferal;
$rescue_ref=0;
$homecare_ref=0;


$subtotal_ref=$refundtotal;

$consultation_2-=$consultation_ref;
$pharmacy_2-=$pharmacy_ref;
$lab_2-=$lab_ref;
$radio_2-=$radio_ref;
$services_2-=$services_ref;
$ref_2-=$ref_ref;
$rescue_2-=$rescue_ref;
$homecare_2-=$homecare_ref;
$subtotal_2-=$subtotal_ref;


			$serial = $serial + 1;
			$showcolor1 = ($serial & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#ecf0f5"';
			}

			?>



			 <tr >
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$serial;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$billdate_refund;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$billno_refund;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$patientname_refund;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$patientcode_refund;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$visitcode_refund;?></strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format($consultation_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo  number_format($pharmacy_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format($lab_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format($radio_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format($services_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format($ref_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format($rescue_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format($homecare_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong>-<?php echo number_format($subtotal_ref,2,'.',','); ?></strong></div></td>
       
               </tr>

           <?php } // while close of refunds ?>

           <!-- /////////////// pharmacy refuns other loop //// -->
           <?php
           $subtotal_refp=0;
           $query1 = "SELECT billnumber, `amount` as amount, patientcode, patientname, patientvisitcode, locationname, billdate FROM `paylaterpharmareturns` WHERE locationcode='$location' and billdate between  '$transactiondatefrom' and '$transactiondateto' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1)){
				  $patientcode_refundp = $res1['patientcode'];
				  $patientname_refundp = $res1['patientname'];
				  $billdate = $res1['billdate'];
				  $locationname = $res1['locationname'];
				  $visitcode_refundp = $res1['patientvisitcode'];
				  $amount = $res1['amount'];
				  $pharmacy_refp = $res1['amount'];
				  $billno_refundp = $res1['billnumber'];
				  // $tot_amount=$tot_amount+$amount ;
				  $subtotal_refp=$subtotal_refp+$amount ;

				  $pharmacy_2-=$pharmacy_refp;
				  $subtotal_2-=$pharmacy_refp;

				  $serial = $serial + 1;
			$showcolor1 = ($serial & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#ecf0f5"';
			}
           ?>
            <tr <?php //  echo $colorcode1; ?>>
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$serial;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$billdate;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$billno_refundp;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$patientname_refundp;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$patientcode_refundp;?></strong></td>	
              	  <td class="bodytext31" valign="center"  align="left"><strong><?=$visitcode_refundp;?></strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format(0,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo  number_format($pharmacy_refp,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format(0,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format(0,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format(0,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format(0,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format(0,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31">-<?php echo number_format(0,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong>-<?php echo number_format($subtotal_refp,2,'.',','); ?></strong></div></td>
               </tr>

           <?php } // while close of pharmacy refunds ?>
           <!-- /////////////// pharmacy refuns other loop  closes//// -->

<!-- ///////////////////////////////////////////////////// REFUNDS CLOSE /////////////////////////////////////////			 -->
                
                 
                 <tr <?php echo $colorcode= 'bgcolor="#ecf0f5"'; ?>>
              	  <td colspan="6" class="bodytext31" valign="center"  align="right"><strong>Grand Total :</strong></td>	
              	  	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($consultation_2,2,'.',','); ?></div></strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo  number_format($pharmacy_2,2,'.',','); ?></div></strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($lab_2,2,'.',','); ?></div></strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($radio_2,2,'.',','); ?></div></strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($services_2,2,'.',','); ?></div></strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($ref_2,2,'.',','); ?></div></strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($rescue_2,2,'.',','); ?></div></strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($homecare_2,2,'.',','); ?></div></strong></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($subtotal_2,2,'.',','); ?></strong></div></td>
       
               </tr>         
		      <?php
				}
				}
			}
			?>
          </tbody>
        </table>
     </td>
  </tr>
  <?php //exit(); ?>
      <!-- /////////////////////////// OP REVENUE DETAILED ENDS ///////////////////// -->
	<tr ><td colspan="20">&nbsp;</td></tr>
          		<!-- ////////////OP ENDS /////////////////// -->
 <tr>
        <td>
	 
 
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1479" 
            align="left" border="0">
          <tbody>
              

             <tr>

			 <td colspan="22" bgcolor="#ecf0f5" class="bodytext31" align="left" valign="middle"><strong>Hospital Detail- IP Revenue</strong></td>

			 </tr>

			  <tr>

				    <td width="36" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>S.No. </strong></div></td>
				    <td width="100" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Bill Dt</strong></div></td>

  				    <td width="134" class="bodytext31" valign="center"  align="left" 

					bgcolor="#ffffff"><div align="center"><strong>Patient</strong></div></td>

  				    <td width="69" class="bodytext31" valign="center"  align="left" 

					bgcolor="#ffffff"><div align="center"><strong>Reg No. </strong></div></td>

  				    <td width="73"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="center">IP&nbsp;No</div></td>

  				    <td width="65"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Adm Fee </div></td>

                    <td width="76"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">IP&nbsp;Package</div></td>

  				    <td width="43"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Bed</div></td>

  				    <td width="53"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Nursing</div></td>

  				    <td width="45"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">RMO</div></td>

  				    <td width="45"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Lab</div></td>

  				    <td width="46"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Rad</div></td>

  				    <td width="64"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Pharma</div></td>

  				    <td width="69"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Services</div></td>

                    <!--VENU-- REMOVE OT-->

  				  <!--  <td width="23"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">OT</div></td>-->

                    <!--ENDS-->

  				    <td width="82"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Ambulance</strong></div></td>

                    <td width="72"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Homecare</strong></div></td>

				    <td width="80"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Pvt Dr.</div></td>

                    <!--VENU -- REMOVE DEPOSIT-->

				   <!-- <td width="77"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Deposit</div></td>

                    -->

                    <!--VENU -- REMOVE DISCOUNT-->

					<!--<td width="61"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Discount</div></td>-->

                    <!--VENU -- REMOVE IP REFUND-->

                    <!--<td width="86"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">IP&nbsp;Refund</div></td>-->

                    <!--VENU -- RMEOVE NHIF-->

                    <!--<td width="57"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">NHIF</div></td>-->

                    <!--ENDS-->

					<td width="94"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Misc&nbsp;Billing</div></td>

					<td width="64"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">Others</div></td>


					<td width="59"  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rebate</strong></div></td>

					<td width="59"  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discounts</strong></div></td>

					<td width="74"  align="left" valign="center" bgcolor="#ffffff" class="style2"><div align="right">Total</div></td>

              </tr>					

        <?php

		$admissionamount=0.00;

		$ipdiscountamount = 0.00;

		$totaladmissionamount = 0.00;

		$totallabamount = 0.00;

		$totalpharmacyamount = 0.00;

		$totalradiologyamount = 0.00;

		$totalservicesamount = 0.00;

		//$totalotamount = 0.00;

		$totalambulanceamount = 0.00;

		$totalprivatedoctoramount = 0.00;

		$totalipbedcharges = 0.00;

		$totalipnursingcharges = 0.00;

		$totaliprmocharges = 0.00;

		$totalipdiscountamount = 0.00;

		$totalipmiscamount = 0.00;
		$totaliprebateamount = 0.00;

		$totaltransactionamount = 0.00;

		$colorcode = '';

		$transactionamount = 0.00;

		$totalhospitalrevenue = '0.00';

		$totalpackagecharge=0.00;

		$totalhomecareamount=0.00;

		$totalotamount=0.00;

		$totaliprefundamount=0.00;

		$totalnhifamount =0.00;

		

		//VARIABLES FOR -- CREDITNOTE--

		

		

		$bedchgsdiscount=0;

		$labchgsdiscount=0;

		$nursechgsdiscount=0;

		$pharmachgsdiscount=0;

		$radchgsdiscount = 0;

		$rmochgsdiscount = 0;

		$servchgsdiscount = 0;

		

		$totbedchgdisc=0;

		$totlabchgdisc=0;

		$totnursechgdisc=0;

		$totpharmachgdisc=0;

		$totradchgdisc=0;

		$totrmochgdisc=0;

		$totservchgdisc=0;

		

		$brfbedchgsdiscount = 0;

		$brflabchgsdiscount = 0;

		$brfnursechgsdiscount = 0;

		$brfpharmachgsdiscount=0;

		$brfradchgsdiscount=0;

		$brfrmochgsdiscount = 0;

		$brfservchgsdiscount  = 0;

		

		$totbrfbeddisc=0;

		$totbrflabdisc=0;

		$totbrfnursedisc=0;

		$totbrfpharmadisc=0;

		$totbrfraddisc=0;

		$totbrfrmodisc=0;

		$totbrfservdisc=0;

		

		$totcreditnotebedchgs = 0;

		$totcreditnotelabchgs = 0; 

		$totcreditnotenursechgs = 0;

		$totcreditnotepharmachgs = 0; 

		$totcreditnoteradchgs = 0;

		$totcreditnotermochgs = 0;

		$totcreditnoteservchgs = 0;

		$totalbrfotherdisc = 0;

		

		$rowtotfinal = 0;

		

		

		

		//QUERY TO GET PATIENT DETAILS TO PASS

	   $query1 = "select  patientname,patientcode,visitcode, billdate from billing_ip where patientbilltype <> '' and locationcode='$locationcode1' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		$patientname=$res1['patientname'];

		$patientcode=$res1['patientcode'];

		$visitcode=$res1['visitcode'];
		$billdate_ip=$res1['billdate'];

		

	   	

		//VENU -- CHANGE QUERY

		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  

		 $query112 = "select sum(amountuhx) as bedamount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";

		  

		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num112=mysqli_num_rows($exec112);

		$res112 = mysqli_fetch_array($exec112);

		 $packagecharge=$res112['bedamount'];

		$totalpackagecharge=$totalpackagecharge + $packagecharge; 



		//TO GET TOTAL ADMIN FEE

	     $query2 = "select amountuhx from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		 

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num2=mysqli_num_rows($exec2);

		$res2 = mysqli_fetch_array($exec2);				

		$admissionamount=$res2['amountuhx'];

	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 

		

		//TO GET TOTAL LAB AMOUNT

		  $query3 = "select sum(rateuhx) as labitemrate from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num3=mysqli_num_rows($exec3);

	    $res3 = mysqli_fetch_array($exec3);

		$labamount=$res3['labitemrate'];

		 $totallabamount=$totallabamount + $labamount;

		

		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT

		  $query4 = "select sum(radiologyitemrateuhx) as radiologyitemrate from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num4=mysqli_num_rows($exec4);

		$res4 = mysqli_fetch_array($exec4);

		$radiologyamount=$res4['radiologyitemrate'];

	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;



		 //TO GET TOTAL PHARMACY CHARGES AMOUNT

		 $query5 = "select sum(amountuhx) as amount from billing_ippharmacy where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num5=mysqli_num_rows($exec5);

		$res5 = mysqli_fetch_array($exec5);

		$pharmacyamount=$res5['amount'];

		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;

	

		//TO GET TOTAL SERVICE CHARGES AMOUNT

	    $query6 = "select sum(servicesitemrateuhx) as servicesitemrate, sum(sharingamount) as sharingamount from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num6=mysqli_num_rows($exec6);

		$res6 = mysqli_fetch_array($exec6);

		$servicesamount=$res6['servicesitemrate']-$res6['sharingamount'];

           $totalservicesamount=$totalservicesamount + $servicesamount;

		

		//VENU -- REMOVE OT

		/* $query7 = "select sum(amount) from billing_ipotbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());

		$num7=mysql_num_rows($exec7);

		$res7 = mysql_fetch_array($exec7);

		$otamount=$res7['sum(amount)'];

		 $totalotamount=$totalotamount + $otamount;*/

	     

		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT

	     $query8 = "select sum(amountuhx) as amount from billing_ipambulance where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num8=mysqli_num_rows($exec8);

		$res8 = mysqli_fetch_array($exec8);

		$ambulanceamount=$res8['amount'];

		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;

		 

		 

		 //TO GET TOTAL HOME CARE CHARGES AMOUNT

		 $query81 = "select sum(amount) as amount from billing_iphomecare where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num81=mysqli_num_rows($exec81);

		$res81 = mysqli_fetch_array($exec81);

		$homecareamount=$res81['amount'];

		 $totalhomecareamount=$totalhomecareamount + $homecareamount;

		

		//VENU -- CHANGE THE QUERY

		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT

		// $query8 = "select sum(amountuhx) as amount from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		// $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

		// $num8=mysql_num_rows($exec8);

		// $res8 = mysql_fetch_array($exec8);

		// $privatedoctoramount=$res8['amount'];

		// $totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		$privatedoctoramount=0;
		$query8              = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor  where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query8" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num8                     = mysqli_num_rows($exec8);
                while($res8 = mysqli_fetch_array($exec8)){
                		if($res8['visittype'] =="IP")
							{
								if($res8['coa'] !="")
								 $privatedoctoramount += $res8['transactionamount'];
								else
								 $privatedoctoramount += $res8['original_amt'];
							}
							else
							{
								$privatedoctoramount += $res8['original_amt'];
							}
			                // $privatedoctoramount      = $res8['sum(transactionamount)'];
			               
            		}
            		 $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;

		

		 //TO GET TOTAL BED CHARGES AMOUNT

		 $query9 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $num9=mysqli_num_rows($exec9);

		$res9 = mysqli_fetch_array($exec9);

		$ipbedcharges=$res9['amount'];

		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;

		

    

		//VENU -- CHANGE THE QUERY

		

		//TO GET TOTAL IP NURSE CHARGES AMOUNT

	    $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Ward Dispensing Charges' and recorddate between '$fromdate' and '$todate' ";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num10=mysqli_num_rows($exec10);

		$res10 = mysqli_fetch_array($exec10);

		$ipnursingcharges=$res10['amount'];

		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;

		

		//VENU-CHANGING QUERY

		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";

		

		//TO GET TOTAL RMO CHARGES AMOUNT

		$query11 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";

		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num11=mysqli_num_rows($exec11);

		$res11 = mysqli_fetch_array($exec11);

		$iprmocharges=$res11['amount'];

		$totaliprmocharges=$totaliprmocharges + $iprmocharges;

		

		//VENU-- REMOVE DEPOSIT AMOUNT

		/*$query13 = "select sum(rate) from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());

		$num13=mysql_num_rows($exec13);

		$res13 = mysql_fetch_array($exec13);

		$ipdiscountamount=$res13['sum(rate)'];

		

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/

		//ENDS

		

		//VENU -- REMOVE IP REFUND

		/*$query133 = "select sum(amount) from deposit_refund where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());

		$num133=mysql_num_rows($exec133);

		$res133 = mysql_fetch_array($exec133);

		$iprefundamount=$res133['sum(amount)'];

		

		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/

		//ENDS

		

		//VENU -- REMOVE NHIF

		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());

		$num1333=mysql_num_rows($exec1333);

		$res1333 = mysql_fetch_array($exec1333);

		$nhifamount=$res1333['sum(nhifclaim)'];

		

		$totalnhifamount=$totalnhifamount + $nhifamount;*/

		//ENDS

		

		//TO GET TOTAL IP MISC BILL AMOUNT

		$query14 = "select sum(amountuhx) as amount from billing_ipmiscbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num14=mysqli_num_rows($exec14);

		$res14 = mysqli_fetch_array($exec14);

		$ipmiscamount=$res14['amount'];

		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;



		/////////// discount and rebate ///////////////
		$query13 = "select sum(-1*ip_discount.rate) as amount from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num13=mysqli_num_rows($exec13);
		$res13 = mysqli_fetch_array($exec13);
		$ipdiscountamount=$res13['amount'];

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;

		//TO GET TOTAL IP REBATE BILL AMOUNT
		$query15 = "select sum(amount) as amount from billing_ipnhif where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num15=mysqli_num_rows($exec15);
		$res15 = mysqli_fetch_array($exec15);
		$iprebateamount=$res15['amount'];

		$totaliprebateamount = $totaliprebateamount + $iprebateamount;
		/////////// discount and rebate ///////////////



		

		

		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE

		 $query15 = "select patientname,patientcode,visitcode from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		

		$res15 = mysqli_fetch_array($exec15);

		

		$res15patientname=$res1['patientname'];

		$res15patientcode=$res1['patientcode'];

		$res15visitcode=$res1['visitcode'];

		

		

		

		

		//TO GET TOTAL TRANSACTION AMOUNT

		$query12 = "select transactionamount,docno from master_transactionipdeposit where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";

		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num12=mysqli_num_rows($exec12);

		

		while($res12 = mysqli_fetch_array($exec12))

		{

			 $transactionamount=$res12['transactionamount'];

			 $referencenumber=$res12['docno'];

			 $totaltransactionamount=$totaltransactionamount + $transactionamount;

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

          <tr <?php // echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billdate_ip; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center">

			    <div align="center"><?php echo $res15patientname; ?></div>

			  </div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $res15patientcode; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $res15visitcode; ?></div></td>	

            

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($admissionamount,2,'.',','); ?></div></td>

                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packagecharge,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipbedcharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipnursingcharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($iprmocharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($labamount,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($radiologyamount,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($pharmacyamount,2,'.',','); ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($servicesamount,2,'.',','); ?></div></td>

                    <!--VENU -- REMOVE OT-->

				    <!--<td class="bodytext31" valign="center"  align="left">

			          <div align="right"><?php //echo number_format($otamount,2,'.',','); ?></div></td>-->

                    <!--ENDS-->  

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($homecareamount,2,'.',','); ?></div></td>

				   <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>

                     

                     <!--VENU -- REMOVE DISCOUNT-->

				   <!-- <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><?php //echo number_format($transactionamount,2,'.',','); ?></div></td>-->

				     <!--VENU -- REMOVE DISCOUNT-->

                     <!-- <td class="bodytext31" valign="center"  align="left">

                      <div align="right"><?php //echo number_format($ipdiscountamount,2,'.',','); ?></div></td>-->

                      <!--VENU REMOVE IPREFUND-->

                       <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($iprefundamount,2,'.',','); ?></div></td>-->

                       <!--VENU REMOVE NHIF-->

                        <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($nhifamount,2,'.',','); ?></div></td>-->

                      <!--ENDS-->  

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipmiscamount,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($iprebateamount,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipdiscountamount,2,'.',','); ?></div></td>

				  <?php

				  $rowtot1 = 0;

				  $rowtot1 = $admissionamount+$packagecharge+$ipbedcharges+$ipnursingcharges+$iprmocharges+$labamount+$radiologyamount+$pharmacyamount+$servicesamount+$ambulanceamount+

				  			 $homecareamount+$privatedoctoramount+$ipmiscamount+$iprebateamount+$ipdiscountamount;

				  $rowtotfinal = $rowtotfinal + $rowtot1;			 

				  ?>

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot1,2,'.',','); ?></strong></div></td>

                  </tr>

                  

                

				  

                  <!--ENDS-->

                  

                    <!--DISPLAY ROW DETAIL FOR DISCOUNT FROM ip_creditbrief -- BRIEF DATA-->

                  <?php

				  /*if($briefcreditpatientcount>0)

				  {

					*/ 

				?>

             

                 <?php   	

				 // }//ends if($briefcreditpatientcount>0)

				  ?>

                  <!--ENDS BRIEF DISCOUNT SHOW-->

		   <?php 

		    

		     }

			 

			$query186 = "select  patientname,patientcode,visitcode, billdate from billing_ipcreditapproved where locationcode='$locationcode1' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";

		$exec186 = mysqli_query($GLOBALS["___mysqli_ston"], $query186) or die ("Error in Query186".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num186=mysqli_num_rows($exec186);

		

		while($res186 = mysqli_fetch_array($exec186))

		{ 

			 

		$patientname=$res186['patientname'];

		$patientcode=$res186['patientcode'];

		$visitcode=$res186['visitcode'];
		$billdate_ipcredit=$res186['billdate'];

		

	   	

		//VENU -- CHANGE QUERY

		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  

		 $query112 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";

		  

		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num112=mysqli_num_rows($exec112);

		$res112 = mysqli_fetch_array($exec112);

		 $packagecharge=$res112['amount'];

		$totalpackagecharge=$totalpackagecharge + $packagecharge; 



		//TO GET TOTAL ADMIN FEE

	     $query2 = "select amountuhx from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		 

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num2=mysqli_num_rows($exec2);

		$res2 = mysqli_fetch_array($exec2);				

		$admissionamount=$res2['amountuhx'];

	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 

		

		//TO GET TOTAL LAB AMOUNT

		  $query3 = "select sum(rateuhx) as labitemrate from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num3=mysqli_num_rows($exec3);

	    $res3 = mysqli_fetch_array($exec3);

		$labamount=$res3['labitemrate'];

		 $totallabamount=$totallabamount + $labamount;

		

		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT

		  $query4 = "select sum(radiologyitemrateuhx) as radiologyitemrate from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num4=mysqli_num_rows($exec4);

		$res4 = mysqli_fetch_array($exec4);

		$radiologyamount=$res4['radiologyitemrate'];

	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;



		 //TO GET TOTAL PHARMACY CHARGES AMOUNT

		 $query5 = "select sum(amountuhx) as amount from billing_ippharmacy where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num5=mysqli_num_rows($exec5);

		$res5 = mysqli_fetch_array($exec5);

		$pharmacyamount=$res5['amount'];

		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;

	

		//TO GET TOTAL SERVICE CHARGES AMOUNT

	    $query6 = "select sum(servicesitemrateuhx) as servicesitemrate, sum(sharingamount) as sharingamount from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num6=mysqli_num_rows($exec6);

		$res6 = mysqli_fetch_array($exec6);

		$servicesamount=$res6['servicesitemrate']-$res6['sharingamount'];

           $totalservicesamount=$totalservicesamount + $servicesamount;

		

		//VENU -- REMOVE OT

		/* $query7 = "select sum(amount) from billing_ipotbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());

		$num7=mysql_num_rows($exec7);

		$res7 = mysql_fetch_array($exec7);

		$otamount=$res7['sum(amount)'];

		 $totalotamount=$totalotamount + $otamount;*/

	     

		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT

	     $query8 = "select sum(amountuhx) as amount from billing_ipambulance where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num8=mysqli_num_rows($exec8);

		$res8 = mysqli_fetch_array($exec8);

		$ambulanceamount=$res8['amount'];

		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;

		 

		 

		 //TO GET TOTAL HOME CARE CHARGES AMOUNT

		 $query81 = "select sum(amount) as amount from billing_iphomecare where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num81=mysqli_num_rows($exec81);

		$res81 = mysqli_fetch_array($exec81);

		$homecareamount=$res81['amount'];

		 $totalhomecareamount=$totalhomecareamount + $homecareamount;

		

		//VENU -- CHANGE THE QUERY

		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT

		// $query8 = "select sum(amountuhx) as amount from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		// $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

		// $num8=mysql_num_rows($exec8);

		// $res8 = mysql_fetch_array($exec8);

		// $privatedoctoramount=$res8['amount'];

		// $totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;

		 $privatedoctoramount=0;
		$query8              = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor  where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query8" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num8                     = mysqli_num_rows($exec8);
                while($res8 = mysqli_fetch_array($exec8)){
                		if($res8['visittype'] =="IP")
							{
								if($res8['coa'] !="")
								 $privatedoctoramount += $res8['transactionamount'];
								else
								 $privatedoctoramount += $res8['original_amt'];
							}
							else
							{
								$privatedoctoramount += $res8['original_amt'];
							}
			                // $privatedoctoramount      = $res8['sum(transactionamount)'];
			               
            		}
            		 $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;

		

		 //TO GET TOTAL BED CHARGES AMOUNT

		 $query9 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $num9=mysqli_num_rows($exec9);

		$res9 = mysqli_fetch_array($exec9);

		$ipbedcharges=$res9['amount'];

		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;

		

    

		//VENU -- CHANGE THE QUERY

		

		//TO GET TOTAL IP NURSE CHARGES AMOUNT

	    $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Ward Dispensing Charges' and recorddate between '$fromdate' and '$todate' ";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num10=mysqli_num_rows($exec10);

		$res10 = mysqli_fetch_array($exec10);

		$ipnursingcharges=$res10['amount'];

		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;

		

		//VENU-CHANGING QUERY

		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";

		

		//TO GET TOTAL RMO CHARGES AMOUNT

		$query11 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";

		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num11=mysqli_num_rows($exec11);

		$res11 = mysqli_fetch_array($exec11);

		$iprmocharges=$res11['amount'];

		$totaliprmocharges=$totaliprmocharges + $iprmocharges;

		

		//VENU-- REMOVE DEPOSIT AMOUNT

		/*$query13 = "select sum(rate) from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());

		$num13=mysql_num_rows($exec13);

		$res13 = mysql_fetch_array($exec13);

		$ipdiscountamount=$res13['sum(rate)'];

		

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/

		//ENDS

		

		//VENU -- REMOVE IP REFUND

		/*$query133 = "select sum(amount) from deposit_refund where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());

		$num133=mysql_num_rows($exec133);

		$res133 = mysql_fetch_array($exec133);

		$iprefundamount=$res133['sum(amount)'];

		

		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/

		//ENDS

		

		//VENU -- REMOVE NHIF

		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());

		$num1333=mysql_num_rows($exec1333);

		$res1333 = mysql_fetch_array($exec1333);

		$nhifamount=$res1333['sum(nhifclaim)'];

		

		$totalnhifamount=$totalnhifamount + $nhifamount;*/

		//ENDS

		

		//TO GET TOTAL IP MISC BILL AMOUNT

		$query14 = "select sum(amountuhx) as amount from billing_ipmiscbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num14=mysqli_num_rows($exec14);

		$res14 = mysqli_fetch_array($exec14);

		$ipmiscamount=$res14['amount'];

		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;

		/////////// DISCOUT AND REBATE//////////////////////
		$query13 = "select sum(-1*ip_discount.rate) as amount from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num13=mysqli_num_rows($exec13);
		$res13 = mysqli_fetch_array($exec13);
		$ipdiscountamount=$res13['amount'];

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;

		//TO GET TOTAL IP REBATE BILL AMOUNT
		$query15 = "select sum(1*amount) as amount from billing_ipnhif where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num15=mysqli_num_rows($exec15);
		$res15 = mysqli_fetch_array($exec15);
		$rebateamount=$res15['amount'];

		$totaliprebateamount = $totaliprebateamount + $rebateamount;
		/////////// DISCOUT AND REBATE//////////////////////

		

		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE

		 $query15 = "select patientname,patientcode,visitcode from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		

		$res15 = mysqli_fetch_array($exec15);

		

		$res15patientname=$res1['patientname'];

		$res15patientcode=$res1['patientcode'];

		$res15visitcode=$res1['visitcode'];

		

		

		

		

		//TO GET TOTAL TRANSACTION AMOUNT

		$query12 = "select transactionamount,docno from master_transactionipdeposit where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";

		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num12=mysqli_num_rows($exec12);

		

		while($res12 = mysqli_fetch_array($exec12))

		{

			 $transactionamount=$res12['transactionamount'];

			 $referencenumber=$res12['docno'];

			 $totaltransactionamount=$totaltransactionamount + $transactionamount;

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

          <tr <?php // echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billdate_ipcredit; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center">

			    <div align="center"><?php echo $patientname; ?></div>

			  </div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientcode; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $visitcode; ?></div></td>	

            

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($admissionamount,2,'.',','); ?></div></td>

                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packagecharge,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipbedcharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipnursingcharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($iprmocharges,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($labamount,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($radiologyamount,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			      <div align="right"><?php echo number_format($pharmacyamount,2,'.',','); ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($servicesamount,2,'.',','); ?></div></td>

                    <!--VENU -- REMOVE OT-->

				    <!--<td class="bodytext31" valign="center"  align="left">

			          <div align="right"><?php //echo number_format($otamount,2,'.',','); ?></div></td>-->

                    <!--ENDS-->  

				  <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></div></td>

                    <td class="bodytext31" valign="center"  align="left">

			        <div align="right"><?php echo number_format($homecareamount,2,'.',','); ?></div></td>

				   <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>

                     

                     <!--VENU -- REMOVE DISCOUNT-->

				   <!-- <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><?php //echo number_format($transactionamount,2,'.',','); ?></div></td>-->

				     <!--VENU -- REMOVE DISCOUNT-->

                     <!-- <td class="bodytext31" valign="center"  align="left">

                      <div align="right"><?php //echo number_format($ipdiscountamount,2,'.',','); ?></div></td>-->

                      <!--VENU REMOVE IPREFUND-->

                       <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($iprefundamount,2,'.',','); ?></div></td>-->

                       <!--VENU REMOVE NHIF-->

                        <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($nhifamount,2,'.',','); ?></div></td>-->

                      <!--ENDS-->  

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipmiscamount,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

                   <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($rebateamount,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipdiscountamount,2,'.',','); ?></div></td>

				  <?php

				  $rowtot2 = 0;

				  $rowtot2 = $admissionamount+$packagecharge+$ipbedcharges+$ipnursingcharges+$iprmocharges+$labamount+$radiologyamount+$pharmacyamount+$servicesamount+$ambulanceamount+

				  			 $homecareamount+$privatedoctoramount+$ipmiscamount+$rebateamount+$ipdiscountamount;

							 

				  $rowtotfinal = $rowtotfinal + $rowtot2;			 

				  ?>

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot2,2,'.',','); ?></strong></div></td>

                  </tr>

                  

                

				  

                  <!--ENDS-->

                  

                    <!--DISPLAY ROW DETAIL FOR DISCOUNT FROM ip_creditbrief -- BRIEF DATA-->

                  <?php

				  /*if($briefcreditpatientcount>0)

				  {

					*/ 

				?>

             

                 <?php   	

				 // }//ends if($briefcreditpatientcount>0)

				  ?>

                  <!--ENDS BRIEF DISCOUNT SHOW-->

		   <?php 

		    

		     }

		   ?>

          

          <tr>

             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td colspan="21" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><strong>IP Credit</strong></td>

          </tr>    

          <!--CODE FOR CREDIT NOTE FROM ip_creditnotebrief -->

         

          <?php

         $qrycreditbrf = "select patientcode, patientvisitcode,patientname, consultationdate from ip_creditnotebrief where locationcode = '$locationcode1' and consultationdate between '$fromdate' and '$todate' group by patientcode";

		  $execcredibrf = mysqli_query($GLOBALS["___mysqli_ston"], $qrycreditbrf) or die ("Error in qrycreditbrf".mysqli_error($GLOBALS["___mysqli_ston"]));

	

		while($rescreditbrf = mysqli_fetch_array($execcredibrf))

		{

   			$pcode = $rescreditbrf["patientcode"];

   			$vcode =$rescreditbrf["patientvisitcode"]; 

			$patienname = $rescreditbrf["patientname"];
			$billdate_ipcredit = $rescreditbrf["consultationdate"];

		  

		  //TO GET DISCOUT FOR BED CHGS -- ip_creditnotebrief

		  $qrybrfbedchgsdisc = "select sum(fxamount) as brfbedchgsdisc from ip_creditnotebrief where description='Bed Charges'  AND patientcode = '$pcode' AND patientvisitcode = '$vcode'  and locationcode = '$locationcode1' and consultationdate between '$fromdate' and '$todate'";

		   $execbrfbedchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfbedchgsdisc) or die ("Error in qrybrfbedchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

		   $rescbrfbedchgsdisc= mysqli_fetch_array($execbrfbedchgsdisc);

		   $brfbedchgsdiscount = $rescbrfbedchgsdisc['brfbedchgsdisc'];

		   

		   $totbrfbeddisc = $totbrfbeddisc + $brfbedchgsdiscount;

		   

		   	//TO GET DISCOUT FOR LAB CHGS -- ip_creditnotebrief

			$qrybrflabchgsdisc = "SELECT sum(fxamount) AS brflabchgsdisc FROM ip_creditnotebrief WHERE description='Lab'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrflabchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrflabchgsdisc) or die ("Error in qrybrflabchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrflabchgsdisc= mysqli_fetch_array($execbrflabchgsdisc);

			$brflabchgsdiscount = $rescbrflabchgsdisc['brflabchgsdisc'];

				

			$totbrflabdisc = $totbrflabdisc + $brflabchgsdiscount;

			

			//TO GET DISCOUT FOR NURSING CHGS -- ip_creditnotebrief

			$qrybrfnursechgsdisc = "SELECT sum(fxamount) AS brfnursechgsdisc FROM ip_creditnotebrief WHERE description='Nursing Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfnursechgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfnursechgsdisc) or die ("Error in qrybrfnursechgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfnursechgsdisc= mysqli_fetch_array($execbrfnursechgsdisc);

			$brfnursechgsdiscount = $rescbrfnursechgsdisc['brfnursechgsdisc'];

				

			$totbrfnursedisc = $totbrfnursedisc + $brfnursechgsdiscount;

			

			//TO GET DISCOUT FOR PHARMACY CHGS  -- ip_creditnotebrief

			$qrybrfpharmachgsdisc = "SELECT sum(fxamount) AS brfpharmachgsdisc FROM ip_creditnotebrief WHERE description='Pharmacy'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfpharmachgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfpharmachgsdisc) or die ("Error in qrybrfpharmachgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfpharmachgsdisc= mysqli_fetch_array($execbrfpharmachgsdisc);

			$brfpharmachgsdiscount = $rescbrfpharmachgsdisc['brfpharmachgsdisc'];

				

			$totbrfpharmadisc = $totbrfpharmadisc + $brfpharmachgsdiscount ;

			

			

			//TO GET DISCOUT FOR RADIOLOGY CHGS  -- ip_creditnotebrief

			$qrybrfradchgsdisc = "SELECT sum(fxamount) AS brfradchgsdisc FROM ip_creditnotebrief WHERE description='Radiology'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfradchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfradchgsdisc) or die ("Error in qrybrfradchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfradchgsdisc= mysqli_fetch_array($execbrfradchgsdisc);

			$brfradchgsdiscount = $rescbrfradchgsdisc['brfradchgsdisc'];

				

			$totbrfraddisc = $totbrfraddisc + $brfradchgsdiscount;

			

			//TO GET DISCOUT FOR RMO CHGS -- ip_creditnotebrief

			$qrybrfrmochgsdisc = "SELECT sum(fxamount) AS brfrmochgsdisc FROM ip_creditnotebrief WHERE description='RMO Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfrmochgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfrmochgsdisc) or die ("Error in qrybrfrmochgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfrmochgsdisc= mysqli_fetch_array($execbrfrmochgsdisc);

			$brfrmochgsdiscount = $rescbrfrmochgsdisc['brfrmochgsdisc'];

				

			$totbrfrmodisc = $totbrfrmodisc + $brfrmochgsdiscount;

			

			//TO GET DISCOUT FOR SERVICEE CHGS-- ip_creditnotebrief

			$qrybrfservchgsdisc = "SELECT sum(fxamount) AS brfservchgsdisc FROM ip_creditnotebrief WHERE description='Service'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfservchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfservchgsdisc) or die ("Error in qrybrfservchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfservchgsdisc= mysqli_fetch_array($execbrfservchgsdisc);

			$brfservchgsdiscount = $rescbrfservchgsdisc['brfservchgsdisc'];

				

			$totbrfservdisc = $totbrfservdisc + $brfservchgsdiscount;

			

			$qrybrfotherdisc = "SELECT sum(fxamount) AS brfotherdisc FROM ip_creditnotebrief WHERE description='Others'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";

			$execbrfotherdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfotherdisc) or die ("Error in qrybrfotherdisc".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rescbrfotherdisc= mysqli_fetch_array($execbrfotherdisc);

			$brfotherdisc = $rescbrfotherdisc['brfotherdisc'];

			

			$totalbrfotherdisc = $totalbrfotherdisc + $brfotherdisc;

			

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

         <!--DISPLAY CREDITNOTE DETAILS-->

            

          <tr <?php // echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billdate_ipcredit; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center">

			    <div align="center"><?php echo $patienname; ?></div>

			  </div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $pcode; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $vcode; ?></div></td>	

            

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($admissionamount,2,'.',','); ?>0.00</div></td>

                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($packagecharge,2,'.',','); ?>0.00</div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfbedchgsdiscount!=0){echo "-".number_format($brfbedchgsdiscount,2,'.',',');} else { echo number_format($brfbedchgsdiscount,2,'.',','); } ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfnursechgsdiscount!=0){echo "-".number_format($brfnursechgsdiscount,2,'.',',');}else{ echo number_format($brfnursechgsdiscount,2,'.',',');} ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfrmochgsdiscount!=0){echo "-".number_format($brfrmochgsdiscount,2,'.',',');}else{echo number_format($brfrmochgsdiscount,2,'.',',');} ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brflabchgsdiscount!=0){echo  "-".number_format($brflabchgsdiscount,2,'.',',');}else{echo  number_format($brflabchgsdiscount,2,'.',',');} ?></div></td>

				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfradchgsdiscount!=0){echo "-".number_format($brfradchgsdiscount,2,'.',',');}else{echo number_format($brfradchgsdiscount,2,'.',',');} ?></div></td>

				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfpharmachgsdiscount!=0){echo "-".number_format($brfpharmachgsdiscount,2,'.',',');} else { echo number_format($brfpharmachgsdiscount,2,'.',','); } ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfservchgsdiscount!=0){echo "-".number_format($brfservchgsdiscount,2,'.',',');}else{ echo number_format($brfservchgsdiscount,2,'.',',');} ?></div></td>

                    <!--VENU -- REMOVE OT-->

				    <!--<td class="bodytext31" valign="center"  align="left">

			          <div align="right"><?php //echo number_format($otamount,2,'.',','); ?></div></td>-->

                    <!--ENDS-->  

				  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($ambulanceamount,2,'.',','); ?>0.00</div></td>

                    <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($homecareamount,2,'.',','); ?>0.00</div></td>

				   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($privatedoctoramount,2,'.',','); ?>0.00</div></td>

                     

                     <!--VENU -- REMOVE DISCOUNT-->

				   <!-- <td class="bodytext31" valign="center"  align="left">

			         <div align="right"><?php //echo number_format($transactionamount,2,'.',','); ?></div></td>-->

				     <!--VENU -- REMOVE DISCOUNT-->

                     <!-- <td class="bodytext31" valign="center"  align="left">

                      <div align="right"><?php //echo number_format($ipdiscountamount,2,'.',','); ?></div></td>-->

                      <!--VENU REMOVE IPREFUND-->

                       <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($iprefundamount,2,'.',','); ?></div></td>-->

                       <!--VENU REMOVE NHIF-->

                        <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($nhifamount,2,'.',','); ?></div></td>-->

                      <!--ENDS-->  

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($ipmiscamount,2,'.',','); ?>0.00</div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo '-'.number_format($brfotherdisc,2,'.',','); ?></div></td>

                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($ipmiscamount,2,'.',','); ?>0.00</div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($ipmiscamount,2,'.',','); ?>0.00</div></td>

				  <?php

				  //$rowtot3 = 0;

				  $rowtot3 = $brfbedchgsdiscount+$brfnursechgsdiscount+$brfrmochgsdiscount+$brflabchgsdiscount+$brfradchgsdiscount+$brfpharmachgsdiscount+$brfservchgsdiscount+$brfotherdisc;

				  $rowtot3 = 0 - $rowtot3;

				  

				  $rowtotfinal = $rowtotfinal + $rowtot3;

				  ?>

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot3,2,'.',','); ?></strong></div></td>

                  </tr>

         <!--DISPLAY ENDS-->

        <?php   

		}

		?>



  <!--<tr>

<td>patient details from $query1</td>

</tr>-->



          <!--ENDS-->

           

            <tr>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right">

				

				<?php 

				

				

				//VENU--CHANGE GRAND TOTAL ACC TO REMOVED FIELDS

				/*$grandtotal = $totaladmissionamount + $totalipbedcharges + $totalipnursingcharges + $totaliprmocharges + $totallabamount + $totalradiologyamount

				+ $totalpharmacyamount + $totalservicesamount + $totalotamount + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount - $totaliprefundamount - $totalipdiscountamount - $totalnhifamount -$totaltransactionamount; */

				

				//VENU --CALCULATIONS FOR TOTALDISC-CREITNOTE

				$totbedchgs = $totalipbedcharges - $totbrfbeddisc;

				$totnursechgs = $totalipnursingcharges - $totbrfnursedisc;

				$totrmochgs =  $totaliprmocharges - $totbrfrmodisc;

				$totlabchgs = $totallabamount - $totbrflabdisc;

				$totradchgs = $totalradiologyamount - $totbrfraddisc;

				$totpharmchgs = $totalpharmacyamount - $totbrfpharmadisc;

				$totservchgs = $totalservicesamount - $totbrfservdisc;

				$totalbrfotherdisc = 0 - $totalbrfotherdisc;

				

				/*$grandtotal = $totaladmissionamount + $totalipbedcharges + $totalipnursingcharges + $totaliprmocharges + $totallabamount + $totalradiologyamount

				+ $totalpharmacyamount + $totalservicesamount + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount ; */

				

				//--VENU -- GRAND TOTAL ACC TO CREDIT NOTE CHANGES

				$grandtotal = $totaladmissionamount + $totbedchgs + $totnursechgs + $totrmochgs + $totlabchgs + $totradchgs

				+ $totpharmchgs + $totservchgs + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount + $totalbrfotherdisc+$totalipdiscountamount+$totaliprebateamount;

				

				?>

				

                  <strong>Grand Total:</strong> </div></td>

                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right">

                <strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totaladmissionamount,2,'.',','); ?></strong></td>

                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalpackagecharge,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totbedchgs,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totnursechgs,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totrmochgs,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totlabchgs,2,'.',','); ?></strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totradchgs,2,'.',','); ?></strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totpharmchgs,2,'.',','); ?></strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totservchgs,2,'.',','); ?></strong></td>

                <!--VENU -- REMOVE total ot amount -->

              <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php //echo number_format($totalotamount,2,'.',','); ?></strong></td>-->

                <!--ends-->

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalambulanceamount,2,'.',','); ?></strong></td>

                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalhomecareamount,2,'.',','); ?></strong></td> 

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></strong></td>

                

                <!--VENU --  REMOVE DISCOUNT-->

              <!--<td align="right" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ecf0f5" class="style2">-<?php //echo number_format($totaltransactionamount,2,'.',','); ?></td>-->

                

              <!--VENU -- REMOVE DEPOSIT-->  

              <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong>-<?php //echo number_format($totalipdiscountamount,2,'.',','); ?></strong></td>-->

                <!--VENU -- REMOVE IP REFUND-->

                <!-- <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong>-<?php //echo number_format($totaliprefundamount,2,'.',','); ?></strong></td>-->

                <!--VENU-- REMOVE NHIF-->

                  <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong>-<?php // echo number_format($totalnhifamount,2,'.',','); ?></strong></td>-->

                <!--ENDS-->

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalipmiscamount,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($totalbrfotherdisc,2,'.',','); ?></strong></td>

				 
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totaliprebateamount,2,'.',','); ?></strong></td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalipdiscountamount,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($rowtotfinal,2,'.',','); ?></strong></td>


               </tr>

           </tbody>
       </table>
   </td>
</tr>

               

            </tbody>

        </table>

<?php

}

?>	
 
 



