<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="doctorreport.xls"');
header('Cache-Control: max-age=80');

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$locationcode1=$locationcode;
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 
  $transactiondatefrom=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:'';
   $transactiondateto=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:'';
   if($transactiondatefrom=='')
   {
   $transactiondatefrom = date('Y-m-d', strtotime('-1 month')); }
    if($transactiondateto==''){
   $transactiondateto =  date('Y-m-d');}
 
?>

<body>
<table width="129%" border="0" cellspacing="0" cellpadding="2">
 
      
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{

	$fromdate=$_REQUEST['ADate1'];
	$todate=$_REQUEST['ADate2'];
  $consultingdoctorsearch=isset($_REQUEST['consultingdoctorsearch'])?$_REQUEST['consultingdoctorsearch']:'';

	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1479" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="19" bgcolor="#ecf0f5" class="bodytext31" align="left" valign="middle"><strong>Doctor Detail Revenue</strong></td>
			 </tr>
			  <tr>
				    <td width="36" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>S.No. </strong></div></td>
  				    <td width="134" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>Doctor name</strong></div></td>
  				   
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
					<td width="64"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Discount</div></td>
					<td width="74"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Total</div></td>
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
		$totaldocttotbrfdisc=0;
		$rowtotfinal = 0;
		if($consultingdoctorsearch!=''){
		   $query122 = "select  consultingdoctor as name  from master_ipvisitentry where locationcode='$locationcode1'  and consultationdate between '$fromdate' and '$todate' and consultingdoctor = '$consultingdoctorsearch' group by consultingdoctor UNION  select  doctorname as name   from ipconsultation_services where locationcode='$locationcode1'  and consultationdate between '$fromdate' and '$todate' and doctorname = '$consultingdoctorsearch' group by doctorname UNION select  doctorname as name from ipprivate_doctor where locationcode='$locationcode1'  and consultationdate between '$fromdate' and '$todate' and doctorname = '$consultingdoctorsearch' group by doctorname";
		$exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $query122) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
		  $query122 = "select  consultingdoctor as name  from master_ipvisitentry where locationcode='$locationcode1'  and consultationdate between '$fromdate' and '$todate'  group by consultingdoctor UNION  select  doctorname as name   from ipconsultation_services where locationcode='$locationcode1'  and consultationdate between '$fromdate' and '$todate'  group by doctorname UNION select  doctorname as name from ipprivate_doctor where locationcode='$locationcode1'  and consultationdate between '$fromdate' and '$todate'  group by doctorname";
		$exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $query122) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		$row122=mysqli_num_rows($exec122);
		
		while($res122 = mysqli_fetch_array($exec122))
		{ 
		 		 $consultingdoctor=$res122['name'];

		 		$doctadmissionamount=0.00;
		$doctipdiscountamount = 0.00;
		$docttotaladmissionamount = 0.00;
		$docttotallabamount = 0.00;
		$docttotalpharmacyamount = 0.00;
		$docttotalradiologyamount = 0.00;
		$docttotalservicesamount = 0.00;
		//$docttotalotamount = 0.00;
		$docttotalambulanceamount = 0.00;
		$docttotalprivatedoctoramount = 0.00;
		$docttotalipbedcharges = 0.00;
		$docttotalipnursingcharges = 0.00;
		$docttotaliprmocharges = 0.00;
		$docttotalipdiscountamount = 0.00;
		$docttotalipmiscamount = 0.00;
		$docttotaltransactionamount = 0.00;
		$doctcolorcode = '';
		$docttransactionamount = 0.00;
		$docttotalhospitalrevenue = '0.00';
		$docttotalpackagecharge=0.00;
		$docttotalhomecareamount=0.00;
		$docttotalotamount=0.00;
		$docttotaliprefundamount=0.00;
		$docttotalnhifamount =0.00;
		$docttotallabamount=0;
		$docttotbrfdisc=0;
		 $query112 = "select  patientcode,visitcode  from master_ipvisitentry where locationcode='$locationcode1' and consultingdoctor = '$consultingdoctor' ";
		//QUERY TO GET PATIENT DETAILS TO PASS
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$row112=mysqli_num_rows($exec112);
		
		while($res112 = mysqli_fetch_array($exec112))
		{ 
		$patientcode=$res112['patientcode'];
		$visitcode=$res112['visitcode'];
		 
		
	   $query1 = "select  patientname,patientcode,visitcode from billing_ip where patientbilltype <> '' and locationcode='$locationcode1'  and patientcode = '$patientcode' and visitcode='$visitcode' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		//$patientname=$res1['patientname'];
		
	   	
		//VENU -- CHANGE QUERY
		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  
		 $query112 = "select sum(amountuhx) as bedamount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";
		  
		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num112=mysqli_num_rows($exec112);
		$res112 = mysqli_fetch_array($exec112);
		 $packagecharge=$res112['bedamount'];
		$totalpackagecharge=$totalpackagecharge + $packagecharge; 
		$docttotalpackagecharge=$docttotalpackagecharge + $packagecharge; 

		//TO GET TOTAL ADMIN FEE
	     $query2 = "select amountuhx from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		 
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);				
		$admissionamount=$res2['amountuhx'];
	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 
			    $docttotaladmissionamount=$docttotaladmissionamount + $admissionamount; 

		//TO GET TOTAL LAB AMOUNT
		  $query3 = "select sum(rateuhx) as labitemrate from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_num_rows($exec3);
	    $res3 = mysqli_fetch_array($exec3);
		$labamount=$res3['labitemrate'];
		 $totallabamount=$totallabamount + $labamount;
				 $docttotallabamount=$docttotallabamount + $labamount;

		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT
		  $query4 = "select sum(radiologyitemrateuhx) as radiologyitemrate from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num4=mysqli_num_rows($exec4);
		$res4 = mysqli_fetch_array($exec4);
		$radiologyamount=$res4['radiologyitemrate'];
	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;
	   $docttotalradiologyamount=$docttotalradiologyamount + $radiologyamount;

		 //TO GET TOTAL PHARMACY CHARGES AMOUNT
		 $query5 = "select sum(amountuhx) as amount from billing_ippharmacy where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num5=mysqli_num_rows($exec5);
		$res5 = mysqli_fetch_array($exec5);
		$pharmacyamount=$res5['amount'];
		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;
			 $docttotalpharmacyamount=$docttotalpharmacyamount + $pharmacyamount;

		//TO GET TOTAL SERVICE CHARGES AMOUNT
	    $query6 = "select sum(servicesitemrateuhx) as servicesitemrate from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num6=mysqli_num_rows($exec6);
		$res6 = mysqli_fetch_array($exec6);
		$servicesamount=$res6['servicesitemrate'];
           $totalservicesamount=$totalservicesamount + $servicesamount;
		           $docttotalservicesamount=$docttotalservicesamount + $servicesamount;

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
		 		 $docttotalambulanceamount=$docttotalambulanceamount + $ambulanceamount;

		 
		 //TO GET TOTAL HOME CARE CHARGES AMOUNT
		 $query81 = "select sum(amount) as amount from billing_iphomecare where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num81=mysqli_num_rows($exec81);
		$res81 = mysqli_fetch_array($exec81);
		$homecareamount=$res81['amount'];
		 $totalhomecareamount=$totalhomecareamount + $homecareamount;
				 $docttotalhomecareamount=$docttotalhomecareamount + $homecareamount;

		//VENU -- CHANGE THE QUERY
		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT
		$query8 = "select sum(amountuhx) as amount from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num8=mysqli_num_rows($exec8);
		$res8 = mysqli_fetch_array($exec8);
		$privatedoctoramount=$res8['amount'];
		$totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
				$docttotalprivatedoctoramount=$docttotalprivatedoctoramount + $privatedoctoramount;

		 //TO GET TOTAL BED CHARGES AMOUNT
		 $query9 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num9=mysqli_num_rows($exec9);
		$res9 = mysqli_fetch_array($exec9);
		$ipbedcharges=$res9['amount'];
		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;
		
    		$docttotalipbedcharges=$docttotalipbedcharges + $ipbedcharges;

		//VENU -- CHANGE THE QUERY
		
		//TO GET TOTAL IP NURSE CHARGES AMOUNT
	    $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Ward Dispensing Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num10=mysqli_num_rows($exec10);
		$res10 = mysqli_fetch_array($exec10);
		$ipnursingcharges=$res10['amount'];
		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;
				$docttotalipnursingcharges=$docttotalipnursingcharges + $ipnursingcharges;

		//VENU-CHANGING QUERY
		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";
		
		//TO GET TOTAL RMO CHARGES AMOUNT
		$query11 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num11=mysqli_num_rows($exec11);
		$res11 = mysqli_fetch_array($exec11);
		$iprmocharges=$res11['amount'];
		$totaliprmocharges=$totaliprmocharges + $iprmocharges;
				$docttotaliprmocharges=$docttotaliprmocharges + $iprmocharges;

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
				$docttotalipmiscamount=$docttotalipmiscamount + $ipmiscamount;

		
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
			 			 $docttotaltransactionamount=$docttotaltransactionamount + $transactionamount;

		} 	
		
	/*	$colorloopcount = $colorloopcount + 1;
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
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
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
				  <?php
				  $rowtot1 = 0;
				  $rowtot1 = $admissionamount+$packagecharge+$ipbedcharges+$ipnursingcharges+$iprmocharges+$labamount+$radiologyamount+$pharmacyamount+$servicesamount+$ambulanceamount+
				  			 $homecareamount+$privatedoctoramount+$ipmiscamount;
				  $rowtotfinal = $rowtotfinal + $rowtot1;			 
				  ?>
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot1,2,'.',','); ?></strong></div></td>
                  </tr>
                  
                
				  
                  <!--ENDS-->
                  
                    <!--DISPLAY ROW DETAIL FOR DISCOUNT FROM ip_creditbrief -- BRIEF DATA-->
                  <?php
				  /*if($briefcreditpatientcount>0)
				  {
					
				?>
             
                 <?php   	
				 // }//ends if($briefcreditpatientcount>0)
				  ?>
                  <!--ENDS BRIEF DISCOUNT SHOW-->
		   <?php */
		    
		     }
			 
			$query186 = "select  patientname,patientcode,visitcode from billing_ipcreditapproved where locationcode='$locationcode1' and  patientcode = '$patientcode' and visitcode='$visitcode' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";
		$exec186 = mysqli_query($GLOBALS["___mysqli_ston"], $query186) or die ("Error in Query186".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num186=mysqli_num_rows($exec186);
		
		while($res186 = mysqli_fetch_array($exec186))
		{ 
			 
		$patientname=$res186['patientname'];
		$patientcode=$res186['patientcode'];
		$visitcode=$res186['visitcode'];
		
	   	
		//VENU -- CHANGE QUERY
		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  
		 $query112 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";
		  
		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num112=mysqli_num_rows($exec112);
		$res112 = mysqli_fetch_array($exec112);
		 $packagecharge=$res112['amount'];
		$totalpackagecharge=$totalpackagecharge + $packagecharge; 
		$docttotalpackagecharge=$docttotalpackagecharge + $packagecharge; 

		//TO GET TOTAL ADMIN FEE
	     $query2 = "select amountuhx from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		 
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);				
		$admissionamount=$res2['amountuhx'];
	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 
			    $docttotaladmissionamount=$docttotaladmissionamount + $admissionamount; 

		//TO GET TOTAL LAB AMOUNT
		  $query3 = "select sum(rateuhx) as labitemrate from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_num_rows($exec3);
	    $res3 = mysqli_fetch_array($exec3);
		$labamount=$res3['labitemrate'];
		 $totallabamount=$totallabamount + $labamount;
				 $docttotallabamount=$docttotallabamount + $labamount;

		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT
		  $query4 = "select sum(radiologyitemrateuhx) as radiologyitemrate from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num4=mysqli_num_rows($exec4);
		$res4 = mysqli_fetch_array($exec4);
		$radiologyamount=$res4['radiologyitemrate'];
	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;
	   $docttotalradiologyamount=$docttotalradiologyamount + $radiologyamount;

		 //TO GET TOTAL PHARMACY CHARGES AMOUNT
		 $query5 = "select sum(amountuhx) as amount from billing_ippharmacy where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num5=mysqli_num_rows($exec5);
		$res5 = mysqli_fetch_array($exec5);
		$pharmacyamount=$res5['amount'];
		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;
			 $docttotalpharmacyamount=$docttotalpharmacyamount + $pharmacyamount;

		//TO GET TOTAL SERVICE CHARGES AMOUNT
	    $query6 = "select sum(servicesitemrateuhx) as servicesitemrate from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num6=mysqli_num_rows($exec6);
		$res6 = mysqli_fetch_array($exec6);
		$servicesamount=$res6['servicesitemrate'];
           $totalservicesamount=$totalservicesamount + $servicesamount;
		           $docttotalservicesamount=$docttotalservicesamount + $servicesamount;

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
		 		 $docttotalambulanceamount=$docttotalambulanceamount + $ambulanceamount;

		 
		 //TO GET TOTAL HOME CARE CHARGES AMOUNT
		 $query81 = "select sum(amount) as amount from billing_iphomecare where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num81=mysqli_num_rows($exec81);
		$res81 = mysqli_fetch_array($exec81);
		$homecareamount=$res81['amount'];
		 $totalhomecareamount=$totalhomecareamount + $homecareamount;
				 $docttotalhomecareamount=$docttotalhomecareamount + $homecareamount;

		//VENU -- CHANGE THE QUERY
		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT
		$query8 = "select sum(amountuhx) as amount from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num8=mysqli_num_rows($exec8);
		$res8 = mysqli_fetch_array($exec8);
		$privatedoctoramount=$res8['amount'];
		$totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
				$docttotalprivatedoctoramount=$docttotalprivatedoctoramount + $privatedoctoramount;

		 //TO GET TOTAL BED CHARGES AMOUNT
		 $query9 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num9=mysqli_num_rows($exec9);
		$res9 = mysqli_fetch_array($exec9);
		$ipbedcharges=$res9['amount'];
		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;
				$docttotalipbedcharges=$docttotalipbedcharges + $ipbedcharges;

    
		//VENU -- CHANGE THE QUERY
		
		//TO GET TOTAL IP NURSE CHARGES AMOUNT
	    $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Ward Dispensing Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num10=mysqli_num_rows($exec10);
		$res10 = mysqli_fetch_array($exec10);
		$ipnursingcharges=$res10['amount'];
		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;
				$docttotalipnursingcharges=$docttotalipnursingcharges + $ipnursingcharges;

		//VENU-CHANGING QUERY
		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";
		
		//TO GET TOTAL RMO CHARGES AMOUNT
		$query11 = "select sum(amountuhx) as amount from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num11=mysqli_num_rows($exec11);
		$res11 = mysqli_fetch_array($exec11);
		$iprmocharges=$res11['amount'];
		$totaliprmocharges=$totaliprmocharges + $iprmocharges;
				$docttotaliprmocharges=$docttotaliprmocharges + $iprmocharges;

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
				$docttotalipmiscamount=$docttotalipmiscamount + $ipmiscamount;

		
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
			 			 $docttotaltransactionamount=$docttotaltransactionamount + $transactionamount;

		} 	
		
/*		$colorloopcount = $colorloopcount + 1;
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
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
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
				  <?php
				  $rowtot2 = 0;
				  $rowtot2 = $admissionamount+$packagecharge+$ipbedcharges+$ipnursingcharges+$iprmocharges+$labamount+$radiologyamount+$pharmacyamount+$servicesamount+$ambulanceamount+
				  			 $homecareamount+$privatedoctoramount+$ipmiscamount;
							 
				  $rowtotfinal = $rowtotfinal + $rowtot2;			 
				  ?>
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot2,2,'.',','); ?></strong></div></td>
                  </tr>
                  
                
				  
                  <!--ENDS-->
                  
                    <!--DISPLAY ROW DETAIL FOR DISCOUNT FROM ip_creditbrief -- BRIEF DATA-->
                  <?php
				  /*if($briefcreditpatientcount>0)
				  {
					
				?>
             
                 <?php   	
				 // }//ends if($briefcreditpatientcount>0)
				  ?>
                  <!--ENDS BRIEF DISCOUNT SHOW-->
		   <?php */
		    
		     }
		   ?>
          
         
          <!--CODE FOR CREDIT NOTE FROM ip_creditnotebrief -->
         
          <?php
         $qrycreditbrf = "select patientcode, patientvisitcode,patientname from ip_creditnotebrief where locationcode = '$locationcode1'  and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' group by patientcode";
		  $execcredibrf = mysqli_query($GLOBALS["___mysqli_ston"], $qrycreditbrf) or die ("Error in qrycreditbrf".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		while($rescreditbrf = mysqli_fetch_array($execcredibrf))
		{
   			$pcode = $rescreditbrf["patientcode"];
   			$vcode =$rescreditbrf["patientvisitcode"]; 
			$patienname = $rescreditbrf["patientname"];
		  
		  //TO GET DISCOUT FOR BED CHGS -- ip_creditnotebrief
		  $qrybrfbedchgsdisc = "select sum(fxamount) as brfdisc from ip_creditnotebrief where    patientcode = '$pcode' AND patientvisitcode = '$vcode'  and locationcode = '$locationcode1' and consultationdate between '$fromdate' and '$todate'";
		   $execbrfbedchgsdisc = mysqli_query($GLOBALS["___mysqli_ston"], $qrybrfbedchgsdisc) or die ("Error in qrybrfbedchgsdisc".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $rescbrfbedchgsdisc= mysqli_fetch_array($execbrfbedchgsdisc);
		   $brfdiscount = $rescbrfbedchgsdisc['brfdisc'];
		   
		   		   $docttotbrfdisc = $docttotbrfdisc + $brfdiscount;
		   		   $totaldocttotbrfdisc = $totaldocttotbrfdisc + $brfdiscount;

		/*   	//TO GET DISCOUT FOR LAB CHGS -- ip_creditnotebrief
			$qrybrflabchgsdisc = "SELECT sum(fxamount) AS brflabchgsdisc FROM ip_creditnotebrief WHERE description='Lab'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrflabchgsdisc = mysql_query($qrybrflabchgsdisc) or die ("Error in qrybrflabchgsdisc".mysql_error());
			$rescbrflabchgsdisc= mysql_fetch_array($execbrflabchgsdisc);
			$brflabchgsdiscount = $rescbrflabchgsdisc['brflabchgsdisc'];
				
			$totbrflabdisc = $totbrflabdisc + $brflabchgsdiscount;
						$docttotbrflabdisc = $docttotbrflabdisc + $brflabchgsdiscount;

			//TO GET DISCOUT FOR NURSING CHGS -- ip_creditnotebrief
			$qrybrfnursechgsdisc = "SELECT sum(fxamount) AS brfnursechgsdisc FROM ip_creditnotebrief WHERE description='Nursing Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfnursechgsdisc = mysql_query($qrybrfnursechgsdisc) or die ("Error in qrybrfnursechgsdisc".mysql_error());
			$rescbrfnursechgsdisc= mysql_fetch_array($execbrfnursechgsdisc);
			$brfnursechgsdiscount = $rescbrfnursechgsdisc['brfnursechgsdisc'];
				
			$totbrfnursedisc = $totbrfnursedisc + $brfnursechgsdiscount;
						$docttotbrfnursedisc = $docttotbrfnursedisc + $brfnursechgsdiscount;

			//TO GET DISCOUT FOR PHARMACY CHGS  -- ip_creditnotebrief
			$qrybrfpharmachgsdisc = "SELECT sum(fxamount) AS brfpharmachgsdisc FROM ip_creditnotebrief WHERE description='Pharmacy'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfpharmachgsdisc = mysql_query($qrybrfpharmachgsdisc) or die ("Error in qrybrfpharmachgsdisc".mysql_error());
			$rescbrfpharmachgsdisc= mysql_fetch_array($execbrfpharmachgsdisc);
			$brfpharmachgsdiscount = $rescbrfpharmachgsdisc['brfpharmachgsdisc'];
				
			$totbrfpharmadisc = $totbrfpharmadisc + $brfpharmachgsdiscount ;
						$docttotbrfpharmadisc = $docttotbrfpharmadisc + $brfpharmachgsdiscount ;

			
			//TO GET DISCOUT FOR RADIOLOGY CHGS  -- ip_creditnotebrief
			$qrybrfradchgsdisc = "SELECT sum(fxamount) AS brfradchgsdisc FROM ip_creditnotebrief WHERE description='Radiology'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfradchgsdisc = mysql_query($qrybrfradchgsdisc) or die ("Error in qrybrfradchgsdisc".mysql_error());
			$rescbrfradchgsdisc= mysql_fetch_array($execbrfradchgsdisc);
			$brfradchgsdiscount = $rescbrfradchgsdisc['brfradchgsdisc'];
				
			$totbrfraddisc = $totbrfraddisc + $brfradchgsdiscount;
						$docttotbrfraddisc = $docttotbrfraddisc + $brfradchgsdiscount;

			//TO GET DISCOUT FOR RMO CHGS -- ip_creditnotebrief
			$qrybrfrmochgsdisc = "SELECT sum(fxamount) AS brfrmochgsdisc FROM ip_creditnotebrief WHERE description='RMO Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfrmochgsdisc = mysql_query($qrybrfrmochgsdisc) or die ("Error in qrybrfrmochgsdisc".mysql_error());
			$rescbrfrmochgsdisc= mysql_fetch_array($execbrfrmochgsdisc);
			$brfrmochgsdiscount = $rescbrfrmochgsdisc['brfrmochgsdisc'];
				
			$totbrfrmodisc = $totbrfrmodisc + $brfrmochgsdiscount;
						$docttotbrfrmodisc = $docttotbrfrmodisc + $brfrmochgsdiscount;

			
			//TO GET DISCOUT FOR SERVICEE CHGS-- ip_creditnotebrief
			$qrybrfservchgsdisc = "SELECT sum(fxamount) AS brfservchgsdisc FROM ip_creditnotebrief WHERE description='Service'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfservchgsdisc = mysql_query($qrybrfservchgsdisc) or die ("Error in qrybrfservchgsdisc".mysql_error());
			$rescbrfservchgsdisc= mysql_fetch_array($execbrfservchgsdisc);
			$brfservchgsdiscount = $rescbrfservchgsdisc['brfservchgsdisc'];
				
			$totbrfservdisc = $totbrfservdisc + $brfservchgsdiscount;
						$docttotbrfservdisc = $docttotbrfservdisc + $brfservchgsdiscount;

			
			$qrybrfotherdisc = "SELECT sum(fxamount) AS brfotherdisc FROM ip_creditnotebrief WHERE description='Others'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfotherdisc = mysql_query($qrybrfotherdisc) or die ("Error in qrybrfotherdisc".mysql_error());
			$rescbrfotherdisc= mysql_fetch_array($execbrfotherdisc);
			$brfotherdisc = $rescbrfotherdisc['brfotherdisc'];
			
			$totalbrfotherdisc = $totalbrfotherdisc + $brfotherdisc;
						$docttotalbrfotherdisc = $docttotalbrfotherdisc + $brfotherdisc;
*/
			/*$colorloopcount = $colorloopcount + 1;
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
            
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
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
				  <?php
				  //$rowtot3 = 0;
				  $rowtot3 = $brfbedchgsdiscount+$brfnursechgsdiscount+$brfrmochgsdiscount+$brflabchgsdiscount+$brfradchgsdiscount+$brfpharmachgsdiscount+$brfservchgsdiscount+$brfotherdisc;
				  $rowtot3 = 0 - $rowtot3;
				  
				  $rowtotfinal = $rowtotfinal + $rowtot3;
				  ?>
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot3,2,'.',','); ?></strong></div></td>
                  </tr>
         <!--DISPLAY ENDS-->
        <?php   */
		}
		
		
		
		
		
		
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
			
			
				$docttotbedchgs = $docttotalipbedcharges ;
				$docttotnursechgs = $docttotalipnursingcharges ;
				$docttotrmochgs =  $docttotaliprmocharges ;
				$docttotlabchgs = $docttotallabamount ;
				$docttotradchgs = $docttotalradiologyamount ;
				$docttotpharmchgs = $docttotalpharmacyamount ;
				$docttotservchgs = $docttotalservicesamount ;
				$docttotalbrfotherdisc = 0 ;
				
				/*$doctgrandtotal = $docttotaladmissionamount + $docttotalipbedcharges + $docttotalipnursingcharges + $docttotaliprmocharges + $docttotallabamount + $docttotalradiologyamount
				+ $docttotalpharmacyamount + $docttotalservicesamount + $docttotalambulanceamount+ $docttotalprivatedoctoramount + $docttotalipmiscamount + $docttotalpackagecharge + $docttotalhomecareamount ; */
				
				//--VENU -- GRAND TOTAL ACC TO CREDIT NOTE CHANGES
				$doctgrandtotal = $docttotaladmissionamount + $docttotbedchgs + $docttotnursechgs + $docttotrmochgs + $docttotlabchgs + $docttotradchgs
				+ $docttotpharmchgs + $docttotservchgs + $docttotalambulanceamount+ $docttotalprivatedoctoramount + $docttotalipmiscamount + $docttotalpackagecharge + $docttotalhomecareamount + $docttotalbrfotherdisc-$docttotbrfdisc;
				if($doctgrandtotal!=0)
				{
			?>
		
         <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			
				
			
                
                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                ><?php echo $consultingdoctor; ?> </td>
            
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotaladmissionamount,2,'.',','); ?></strong></td>
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotalpackagecharge,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotbedchgs,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotnursechgs,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotrmochgs,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                ><div align="right"><strong><?php echo number_format($docttotlabchgs,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                ><div align="right"><strong><?php echo number_format($docttotradchgs,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                ><div align="right"><strong><?php echo number_format($docttotpharmchgs,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotservchgs,2,'.',','); ?></strong></td>
                <!--VENU -- REMOVE total ot amount -->
              <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php //echo number_format($docttotalotamount,2,'.',','); ?></strong></td>-->
                <!--ends-->
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotalbrfotherdisc,2,'.',','); ?></strong></td>
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotalhomecareamount,2,'.',','); ?></strong></td> 
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotalprivatedoctoramount,2,'.',','); ?></strong></td>
                
                <!--VENU --  REMOVE DISCOUNT-->
              <!--<td align="right" valign="center" bordercolor="#f3f3f3" 
                 class="style2">-<?php //echo number_format($docttotaltransactionamount,2,'.',','); ?></td>-->
                
              <!--VENU -- REMOVE DEPOSIT-->  
              <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong>-<?php //echo number_format($docttotalipdiscountamount,2,'.',','); ?></strong></td>-->
                <!--VENU -- REMOVE IP REFUND-->
                <!-- <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong>-<?php //echo number_format($docttotaliprefundamount,2,'.',','); ?></strong></td>-->
                <!--VENU-- REMOVE NHIF-->
                  <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong>-<?php // echo number_format($docttotalnhifamount,2,'.',','); ?></strong></td>-->
                <!--ENDS-->
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotalipmiscamount,2,'.',','); ?></strong></td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotbrfdisc,2,'.',','); ?></strong></td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($docttotbrfdisc,2,'.',','); ?></strong></td>
		  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                ><div align="right">
                <strong><?php echo number_format($doctgrandtotal,2,'.',','); ?></strong></div></td>
             
               </tr>
                  
                
				  
                  <!--ENDS-->
                  
                    <!--DISPLAY ROW DETAIL FOR DISCOUNT FROM ip_creditbrief -- BRIEF DATA-->
                  <?php
				  
				  }
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

  <!--<tr>
<td>patient details from $query1</td>
</tr>-->

          <!--ENDS-->
           
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right">
				
				<?php 
				
				
				//VENU--CHANGE GRAND TOTAL ACC TO REMOVED FIELDS
				/*$grandtotal = $totaladmissionamount + $totalipbedcharges + $totalipnursingcharges + $totaliprmocharges + $totallabamount + $totalradiologyamount
				+ $totalpharmacyamount + $totalservicesamount + $totalotamount + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount - $totaliprefundamount - $totalipdiscountamount - $totalnhifamount -$totaltransactionamount; */
				
				//VENU --CALCULATIONS FOR TOTALDISC-CREITNOTE
				$totbedchgs = $totalipbedcharges ;
				$totnursechgs = $totalipnursingcharges ;
				$totrmochgs =  $totaliprmocharges ;
				$totlabchgs = $totallabamount ;
				$totradchgs = $totalradiologyamount ;
				$totpharmchgs = $totalpharmacyamount ;
				$totservchgs = $totalservicesamount ;
				$totalbrfotherdisc = 0 ;
			
				/*$grandtotal = $totaladmissionamount + $totalipbedcharges + $totalipnursingcharges + $totaliprmocharges + $totallabamount + $totalradiologyamount
				+ $totalpharmacyamount + $totalservicesamount + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount ; */
				
				//--VENU -- GRAND TOTAL ACC TO CREDIT NOTE CHANGES
				$grandtotal = $totaladmissionamount + $totbedchgs + $totnursechgs + $totrmochgs + $totlabchgs + $totradchgs
				+ $totpharmchgs + $totservchgs + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount + $totalbrfotherdisc;
				
				?>
				
                  <strong>Grand Total:</strong> </div></td>
                 
            
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
				<td class="bodytext311" valign="center" bgcolor="#ecf0f5" bordercolor="#f3f3f3" align="right" 
                ><strong><?php echo number_format($totaldocttotbrfdisc,2,'.',','); ?></strong></td>
				  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right">
                <strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></div></td>
                
               </tr>
               
            </tbody>
        </table>
<?php



}
?>	
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
</body>
</html>

