<?php

session_start();

//include ("includes/loginverify.php");

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$fromdate = date('Y-m-d', strtotime('-1 month'));

$todate = date('Y-m-d');

$username = '';

$companyanum = '';

$companyname = '';

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$sno = "";

$colorloopcount="";



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="ipfinalizeddetailed.xls"');

header('Cache-Control: max-age=80');



if ($companyanum == '') //For print view.

{

	if (isset($_SESSION["username"])) { $username = $_SESSION["username"]; } else { $username = ""; }

	//$username = $_SESSION['username'];

	if (isset($_SESSION["companyanum"])) { $companyanum = $_SESSION["companyanum"]; } else { $companyanum = ""; }

	//$companyanum = $_SESSION['companyanum'];

	if (isset($_SESSION["companyname"])) { $companyname = $_SESSION["companyname"]; } else { $companyname = ""; }

	//$companyname = $_SESSION['companyname'];

	if (isset($_SESSION["financialyear"])) { $financialyear = $_SESSION["financialyear"]; } else { $financialyear = ""; }

	//$financialyear = $_SESSION['financialyear'];

}



if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if (isset($_REQUEST["user"])) { $searchsuppliercode = $_REQUEST["user"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["loc"])) { $locationcode1 = $_REQUEST["loc"]; } else { $locationcode1 = ""; }



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



}



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype'];

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//$billstatus = $_REQUEST['billstatus'];

//echo $ADate2;



if ($ADate1 != '' && $ADate2 != '')

{

	$fromdate = $_REQUEST['ADate1'];

	$todate = $_REQUEST['ADate2'];

}

else

{

	$fromdate = date('Y-m-d', strtotime('-1 month'));

	$todate = date('Y-m-d');

}

?>

<table  border="0" cellspacing="0" cellpadding="0">

          <tbody>

            <tr>

			 <td colspan="27" bgcolor="#FFF" class="bodytext31" align="center"><strong>IP Final Bills</strong></td>

			 </tr>
			  <tr>
				    <td  class="bodytext31" valign="center" align="left" bgcolor="#ffffff"><div align="center"><strong>S.No.</strong></div></td>

  				    <td  class="bodytext31" valign="center" align="left"  bgcolor="#ffffff"><div align="center"><strong>Patient</strong></div></td>

  				    <td  class="bodytext31" valign="center" align="left" bgcolor="#ffffff"><div align="center"><strong>Reg No. </strong></div></td>

					<td width="87" class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><div align="center"><strong>Insurance</strong></div></td>

  				    <td width="224"  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Scheme Name</strong></td>


					<td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Memberno</strong></div></td>

  				    <td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP&nbsp;No</strong></div></td>

					<td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No</strong></div></td>

					<td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Date</strong></div></td>

  				    <td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Adm Fee </strong></div></td>

                    <td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IP&nbsp;Package</strong></div></td>

  				    <td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bed</strong></div></td>

  				    <td  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Nursing</strong></div></td>

  				    <td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>RMO</strong></div></td>

  				    <td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>

  				    <td  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rad</strong></div></td>

  				    <td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharma</strong></div></td>

  				    <td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Services</strong></div></td>

                    <!--VENU-- REMOVE OT-->

  				  <!--  <td width="23"  align="left" valign="center" 

					bgcolor="#ffffff" class="style2"><div align="right">OT</div></td>-->

                    <!--ENDS-->

  				    <td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Ambulance</strong></div></td>

                    <td  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Homecare</strong></div></td>

				    <td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pvt Dr.</strong></div></td>

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

					<td  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Misc&nbsp;Billing</strong></div></td>

					<td  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Others</strong></div></td>

					<td  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rebate</strong></div></td>

					<td  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discount</strong></div></td>

					<td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>

					

					<td   align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Username</strong></div></td>

					

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

		$iprebateamount = 0.00;

		$rebateamount = 0.00;

		$totaliprebateamount = 0.00;

		

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

		

		if($searchsuppliercode == '')

		{

		$searchsuppliercode = '%%';

		}
		
		if($locationcode1=='All')
		{
		$pass_location = "locationcode !=''";
		}
		else
		{
		$pass_location = "locationcode ='$locationcode1'";
		}	

		//QUERY TO GET PATIENT DETAILS TO PASS

	   $query1 = "select  patientname,patientcode,visitcode,billno,billdate from billing_ip where patientbilltype <> '' and $pass_location and billdate between '$fromdate' and '$todate' and accountcode like '$searchsuppliercode' group by visitcode  order by auto_number DESC ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		$patientname=$res1['patientname'];

		$patientcode=$res1['patientcode'];

		$visitcode=$res1['visitcode'];

		$billno =$res1['billno'];

			$billdate =$res1['billdate'];

	   	

		//VENU -- CHANGE QUERY

		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  

		 // $query112 = "select sum(amountuhx) as bedamount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Nursing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";

		  $query112 = "select sum(amountuhx) as bedamount from billing_ipbedcharges where $pass_location and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

				  UNION ALL SELECT sum(fxamount) as bedamount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'";

		  

		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num112=mysqli_num_rows($exec112);

		$res112 = mysqli_fetch_array($exec112);

		 $packagecharge=$res112['bedamount'];

		$totalpackagecharge=$totalpackagecharge + $packagecharge; 



		//TO GET TOTAL ADMIN FEE

	     $query2 = "select amountuhx,fxrate from billing_ipadmissioncharge where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		 

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num2=mysqli_num_rows($exec2);

		$res2 = mysqli_fetch_array($exec2);				

		$amount=$res2['amountuhx'];

		$fxrate=$res2['fxrate'];

		$admissionamount=$amount*$fxrate;

	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 

		

		//TO GET TOTAL LAB AMOUNT

		  $query3 = "select sum(labitemrate) as labitemrate from billing_iplab where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num3=mysqli_num_rows($exec3);

	    $res3 = mysqli_fetch_array($exec3);

		$labamount=$res3['labitemrate'];

		 $totallabamount=$totallabamount + $labamount;

		

		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT

		  $query4 = "select sum(radiologyitemrateuhx) as radiologyitemrate from billing_ipradiology where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num4=mysqli_num_rows($exec4);

		$res4 = mysqli_fetch_array($exec4);

		$radiologyamount=$res4['radiologyitemrate'];

	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;



		 //TO GET TOTAL PHARMACY CHARGES AMOUNT

		 $query5 = "select sum(amountuhx) as amount from billing_ippharmacy where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num5=mysqli_num_rows($exec5);

		$res5 = mysqli_fetch_array($exec5);

		$pharmacyamount=$res5['amount'];

		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;

	

		//TO GET TOTAL SERVICE CHARGES AMOUNT

	    $query6 = "select sum(servicesitemrateuhx) as servicesitemrate, sum(sharingamount) from billing_ipservices where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num6=mysqli_num_rows($exec6);

		$res6 = mysqli_fetch_array($exec6);

		$servicesamount=$res6['servicesitemrate']-$res6['sum(sharingamount)'];

           $totalservicesamount=$totalservicesamount + $servicesamount;

		

		//VENU -- REMOVE OT

		/* $query7 = "select sum(amount) from billing_ipotbilling where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());

		$num7=mysql_num_rows($exec7);

		$res7 = mysql_fetch_array($exec7);

		$otamount=$res7['sum(amount)'];

		 $totalotamount=$totalotamount + $otamount;*/

	     

		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT

	     $query8 = "select sum(amountuhx) as amount from billing_ipambulance where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num8=mysqli_num_rows($exec8);

		$res8 = mysqli_fetch_array($exec8);

		$ambulanceamount=$res8['amount'];

		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;

		 

		 

		 //TO GET TOTAL HOME CARE CHARGES AMOUNT

		 $query81 = "select sum(amount) as amount from billing_iphomecare where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num81=mysqli_num_rows($exec81);

		$res81 = mysqli_fetch_array($exec81);

		$homecareamount=$res81['amount'];

		 $totalhomecareamount=$totalhomecareamount + $homecareamount;

		

		//VENU -- CHANGE THE QUERY

		// $query8 = "select sum(amount) from billing_ipprivatedoctor where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT

		// $query8 = "select sum(amountuhx) as amount from billing_ipprivatedoctor where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		// $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

		// $num8=mysql_num_rows($exec8);

		// $res8 = mysql_fetch_array($exec8);

		// $privatedoctoramount=$res8['amount'];

		// $totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;

		$privatedoctoramount=0;
		$query8              = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor  where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
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

		 $query9 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $num9=mysqli_num_rows($exec9);

		$res9 = mysqli_fetch_array($exec9);

		$ipbedcharges=$res9['amount'];

		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;

		

    

		//VENU -- CHANGE THE QUERY

		

		//TO GET TOTAL IP NURSE CHARGES AMOUNT

	    $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Nursing Charges' and recorddate between '$fromdate' and '$todate' ";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num10=mysqli_num_rows($exec10);

		$res10 = mysqli_fetch_array($exec10);

		$ipnursingcharges=$res10['amount'];

		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;

		

		//VENU-CHANGING QUERY

		//$query11 = "select sum(amount) from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";

		

		//TO GET TOTAL RMO CHARGES AMOUNT

		// $query11 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";
		$query11 = "select sum(amount) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and (description = 'Daily Review charge' or description = 'RMO Charges' or description ='Consultant Fee') and recorddate between '$fromdate' and '$todate' ";

		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num11=mysqli_num_rows($exec11);

		$res11 = mysqli_fetch_array($exec11);

		$iprmocharges=$res11['amount'];

		$totaliprmocharges=$totaliprmocharges + $iprmocharges;

		

		//VENU-- REMOVE DEPOSIT AMOUNT

		/*$query13 = "select sum(rate) from ip_discount where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());

		$num13=mysql_num_rows($exec13);

		$res13 = mysql_fetch_array($exec13);

		$ipdiscountamount=$res13['sum(rate)'];

		

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/

		//ENDS

		

		//VENU -- REMOVE IP REFUND

		/*$query133 = "select sum(amount) from deposit_refund where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());

		$num133=mysql_num_rows($exec133);

		$res133 = mysql_fetch_array($exec133);

		$iprefundamount=$res133['sum(amount)'];

		

		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/

		//ENDS

		

		//VENU -- REMOVE NHIF

		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());

		$num1333=mysql_num_rows($exec1333);

		$res1333 = mysql_fetch_array($exec1333);

		$nhifamount=$res1333['sum(nhifclaim)'];

		

		$totalnhifamount=$totalnhifamount + $nhifamount;*/

		//ENDS

		

		//TO GET TOTAL IP MISC BILL AMOUNT

		$query14 = "select sum(amountuhx) as amount from billing_ipmiscbilling where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num14=mysqli_num_rows($exec14);

		$res14 = mysqli_fetch_array($exec14);

		$ipmiscamount=$res14['amount'];

		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;



		$query13 = "select sum(-1*ip_discount.rate) as amount from ip_discount where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num13=mysqli_num_rows($exec13);

		$res13 = mysqli_fetch_array($exec13);

		$ipdiscountamount=$res13['amount'];

		

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;



		//TO GET TOTAL IP REBATE BILL AMOUNT

		$query15 = "select sum(1*amount) as amount from billing_ipnhif where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		$res15 = mysqli_fetch_array($exec15);

		$iprebateamount=$res15['amount'];

		$totaliprebateamount = $totaliprebateamount + $iprebateamount;

		

		

		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE

		 //TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE

		 $query15 = "select memberno,accountfullname,subtype from master_ipvisitentry where  patientcode = '$patientcode' and visitcode='$visitcode' ";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		

		$res15 = mysqli_fetch_array($exec15);

			$memberno=$res15['memberno'];

			$accountname=$res15['accountfullname'];
			$subtype=$res15['subtype'];

			$query_subname = "select subtype from master_subtype where  auto_number = '$subtype' ";
			$exec_subname = mysqli_query($GLOBALS["___mysqli_ston"], $query_subname) or die ("Error in Query_subname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_subname=mysqli_num_rows($exec_subname);
			$res_subname = mysqli_fetch_array($exec_subname);
			$subtype_name=$res_subname['subtype'];

		

		

		//TO GET THE USERNAME OF THE FINILAZING AUTHORIY

		$query25 = "select username from master_transactionip where  patientcode = '$patientcode' and visitcode='$visitcode'";

		$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num25=mysqli_num_rows($exec25);

		

		$res25 = mysqli_fetch_array($exec25);

		$billuser=$res25['username'];

		

		

		//TO GET TOTAL TRANSACTION AMOUNT

		$query12 = "select transactionamount,docno from master_transactionipdeposit where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";

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

				$colorcode = 'bgcolor="#FFF"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#FFF"';

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

			    <td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $subtype_name; ?></div></td>

			  <td  align="left" valign="center" class="bodytext31"><?php echo $accountname; ?></td>

				 <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo $memberno; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $visitcode; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $billno; ?></div></td>	

				<td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $billdate; ?></div></td>	

            

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

				 

				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo $billuser; ?></strong></div></td>

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

			 

			$query186 = "select  patientname,patientcode,visitcode,billno,billdate from billing_ipcreditapproved where $pass_location and billdate between '$fromdate' and '$todate' and accountnameid like '$searchsuppliercode' group by visitcode order by auto_number DESC ";

		$exec186 = mysqli_query($GLOBALS["___mysqli_ston"], $query186) or die ("Error in Query186".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num186=mysqli_num_rows($exec186);

		

		while($res186 = mysqli_fetch_array($exec186))

		{ 

			 

		$patientname=$res186['patientname'];

		$patientcode=$res186['patientcode'];

		$visitcode=$res186['visitcode'];

		$billno=$res186['billno'];

		$billdate=$res186['billdate'];
	   	

		//VENU -- CHANGE QUERY

		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  

		 // $query112 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Nursing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";

		  $query112 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

				  UNION ALL SELECT sum(fxamount) as amount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'";

		  

		$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num112=mysqli_num_rows($exec112);

		$res112 = mysqli_fetch_array($exec112);

		 $packagecharge=$res112['amount'];

		$totalpackagecharge=$totalpackagecharge + $packagecharge; 



		//TO GET TOTAL ADMIN FEE

	     $query2 = "select amountuhx from billing_ipadmissioncharge where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		 
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num2=mysqli_num_rows($exec2);

		$res2 = mysqli_fetch_array($exec2);				

		$admissionamount=$res2['amountuhx'];

	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 

		

		//TO GET TOTAL LAB AMOUNT

		  $query3 = "select sum(labitemrate) as labitemrate from billing_iplab where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num3=mysqli_num_rows($exec3);

	    $res3 = mysqli_fetch_array($exec3);

		$labamount=$res3['labitemrate'];

		 $totallabamount=$totallabamount + $labamount;

		

		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT

		  $query4 = "select sum(radiologyitemrateuhx) as radiologyitemrate from billing_ipradiology where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num4=mysqli_num_rows($exec4);

		$res4 = mysqli_fetch_array($exec4);

		$radiologyamount=$res4['radiologyitemrate'];

	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;



		 //TO GET TOTAL PHARMACY CHARGES AMOUNT

		 $query5 = "select sum(amountuhx) as amount from billing_ippharmacy where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num5=mysqli_num_rows($exec5);

		$res5 = mysqli_fetch_array($exec5);

		$pharmacyamount=$res5['amount'];

		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;

	

		//TO GET TOTAL SERVICE CHARGES AMOUNT

	    $query6 = "select sum(servicesitemrateuhx) as servicesitemrate, sum(sharingamount) from billing_ipservices where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";

		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num6=mysqli_num_rows($exec6);

		$res6 = mysqli_fetch_array($exec6);

		$servicesamount=$res6['servicesitemrate']-$res6['sum(sharingamount)'];

           $totalservicesamount=$totalservicesamount + $servicesamount;

		

		//VENU -- REMOVE OT

		/* $query7 = "select sum(amount) from billing_ipotbilling where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());

		$num7=mysql_num_rows($exec7);

		$res7 = mysql_fetch_array($exec7);

		$otamount=$res7['sum(amount)'];

		 $totalotamount=$totalotamount + $otamount;*/

	     

		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT

	     $query8 = "select sum(amountuhx) as amount from billing_ipambulance where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num8=mysqli_num_rows($exec8);

		$res8 = mysqli_fetch_array($exec8);

		$ambulanceamount=$res8['amount'];

		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;

		 

		 

		 //TO GET TOTAL HOME CARE CHARGES AMOUNT

		 $query81 = "select sum(amount) as amount from billing_iphomecare where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num81=mysqli_num_rows($exec81);

		$res81 = mysqli_fetch_array($exec81);

		$homecareamount=$res81['amount'];

		 $totalhomecareamount=$totalhomecareamount + $homecareamount;

		

		//VENU -- CHANGE THE QUERY

		// $query8 = "select sum(amount) from billing_ipprivatedoctor where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		

		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT

		// $query8 = "select sum(amountuhx) as amount from billing_ipprivatedoctor where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";

		// $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

		// $num8=mysql_num_rows($exec8);

		// $res8 = mysql_fetch_array($exec8);

		// $privatedoctoramount=$res8['amount'];

		// $totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;

		 $privatedoctoramount=0;
		$query8              = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor  where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
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

		 $query9 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $num9=mysqli_num_rows($exec9);

		$res9 = mysqli_fetch_array($exec9);

		$ipbedcharges=$res9['amount'];

		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;

		

    

		//VENU -- CHANGE THE QUERY

		

		//TO GET TOTAL IP NURSE CHARGES AMOUNT

	    $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Nursing Charges' and recorddate between '$fromdate' and '$todate' ";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num10=mysqli_num_rows($exec10);

		$res10 = mysqli_fetch_array($exec10);

		$ipnursingcharges=$res10['amount'];

		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;

		

		//VENU-CHANGING QUERY

		//$query11 = "select sum(amount) from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";

		

		//TO GET TOTAL RMO CHARGES AMOUNT

		$query11 = "select sum(amount) as amount from billing_ipbedcharges where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and (description = 'Daily Review charge' or description = 'RMO Charges' or description ='Consultant Fee') and recorddate between '$fromdate' and '$todate' ";


		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num11=mysqli_num_rows($exec11);

		$res11 = mysqli_fetch_array($exec11);

		$iprmocharges=$res11['amount'];

		$totaliprmocharges=$totaliprmocharges + $iprmocharges;



		$query13 = "select sum(-1*ip_discount.rate) as amount from ip_discount where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num13=mysqli_num_rows($exec13);

		$res13 = mysqli_fetch_array($exec13);

		$ipdiscountamount=$res13['amount'];

		

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;



		//TO GET TOTAL IP REBATE BILL AMOUNT

		$query15 = "select sum(1*amount) as amount from billing_ipnhif where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		$res15 = mysqli_fetch_array($exec15);

		$rebateamount=$res15['amount'];

		$totaliprebateamount = $totaliprebateamount + $rebateamount;

		

		//VENU-- REMOVE DEPOSIT AMOUNT

		/*$query13 = "select sum(rate) from ip_discount where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());

		$num13=mysql_num_rows($exec13);

		$res13 = mysql_fetch_array($exec13);

		$ipdiscountamount=$res13['sum(rate)'];

		

		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/

		//ENDS

		

		//VENU -- REMOVE IP REFUND

		/*$query133 = "select sum(amount) from deposit_refund where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());

		$num133=mysql_num_rows($exec133);

		$res133 = mysql_fetch_array($exec133);

		$iprefundamount=$res133['sum(amount)'];

		

		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/

		//ENDS

		

		//VENU -- REMOVE NHIF

		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where $pass_location and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";

		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());

		$num1333=mysql_num_rows($exec1333);

		$res1333 = mysql_fetch_array($exec1333);

		$nhifamount=$res1333['sum(nhifclaim)'];

		

		$totalnhifamount=$totalnhifamount + $nhifamount;*/

		//ENDS

		

		//TO GET TOTAL IP MISC BILL AMOUNT

		$query14 = "select sum(amountuhx) as amount from billing_ipmiscbilling where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";

		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num14=mysqli_num_rows($exec14);

		$res14 = mysqli_fetch_array($exec14);

		$ipmiscamount=$res14['amount'];

		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;

		

		

		//TO GET PATIEN MEMBER NUMBER

		 //TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE

		 $query15 = "select memberno,accountfullname,subtype from master_ipvisitentry where  patientcode = '$patientcode' and visitcode='$visitcode' ";

		$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num15=mysqli_num_rows($exec15);

		

		$res15 = mysqli_fetch_array($exec15);

			$memberno=$res15['memberno'];

			$accountname=$res15['accountfullname'];
			$subtype=$res15['subtype'];

			$query_subname = "select subtype from master_subtype where  auto_number = '$subtype' ";
			$exec_subname = mysqli_query($GLOBALS["___mysqli_ston"], $query_subname) or die ("Error in Query_subname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_subname=mysqli_num_rows($exec_subname);
			$res_subname = mysqli_fetch_array($exec_subname);
			$subtype_name=$res_subname['subtype'];

		

		//TO GET THE USERNAME OF THE FINILAZING AUTHORIY

		 $query25 = "select username from ip_creditapproval where  patientcode = '$patientcode' and visitcode='$visitcode'";

		$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num25=mysqli_num_rows($exec25);

		

		$res25 = mysqli_fetch_array($exec25);

		$billuser=$res25['username'];

				

		//TO GET TOTAL TRANSACTION AMOUNT

		$query12 = "select transactionamount,docno from master_transactionipdeposit where $pass_location and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";

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

				$colorcode = 'bgcolor="#FFF"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#FFF"';

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

			    <td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $subtype_name; ?></div></td>

			  <td  align="left" valign="center" class="bodytext31"><?php echo $accountname; ?></td>

				<td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo $memberno; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $visitcode; ?></div></td>	

            <td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $billno; ?></div></td>



<td class="bodytext31" valign="center"  align="left">

			      <div align="center"><?php echo $billdate; ?></div></td>


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

                 

				 <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo $billuser; ?></strong></div></td>

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

  <!--<tr>

<td>patient details from $query1</td>

</tr>-->



          <!--ENDS-->

           

            <tr>

              <td colspan="3" class="bodytext311" valign="center" bordercolor="#FFF" align="left" 

                bgcolor="#FFF">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#FFF" align="left" 

                bgcolor="#FFF">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#FFF" align="left" 

                bgcolor="#FFF">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#FFF" align="left" 

                bgcolor="#FFF"><div align="right">

				

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

				+ $totpharmchgs + $totservchgs + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount + $totalbrfotherdisc;

				

				?>

				

                  <strong>Grand Total:</strong> </div></td>

                   <td class="bodytext311" valign="center" bordercolor="#FFF" align="left" 

                bgcolor="#FFF">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="left" 

                bgcolor="#FFF"><div align="right">

                <strong>&nbsp;</strong></div></td>

<td class="bodytext311" valign="center" bordercolor="#FFF" align="left" 

                bgcolor="#FFF"><div align="right">

                <strong>&nbsp;</strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totaladmissionamount,2,'.',','); ?></strong></td>

                <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totalpackagecharge,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totbedchgs,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totnursechgs,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totrmochgs,2,'.',','); ?></strong></td>

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="left" 

                bgcolor="#FFF"><div align="right"><strong><?php echo number_format($totlabchgs,2,'.',','); ?></strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="left" 

                bgcolor="#FFF"><div align="right"><strong><?php echo number_format($totradchgs,2,'.',','); ?></strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="left" 

                bgcolor="#FFF"><div align="right"><strong><?php echo number_format($totpharmchgs,2,'.',','); ?></strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totservchgs,2,'.',','); ?></strong></td>

                <!--VENU -- REMOVE total ot amount -->

              <!--<td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php //echo number_format($totalotamount,2,'.',','); ?></strong></td>-->

                <!--ends-->

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totalambulanceamount,2,'.',','); ?></strong></td>

                <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totalhomecareamount,2,'.',','); ?></strong></td> 

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></strong></td>

                

                <!--VENU --  REMOVE DISCOUNT-->

              <!--<td align="right" valign="center" bordercolor="#FFF" 

                bgcolor="#FFF" class="style2">-<?php //echo number_format($totaltransactionamount,2,'.',','); ?></td>-->

                

              <!--VENU -- REMOVE DEPOSIT-->  

              <!--<td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong>-<?php //echo number_format($totalipdiscountamount,2,'.',','); ?></strong></td>-->

                <!--VENU -- REMOVE IP REFUND-->

                <!-- <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong>-<?php //echo number_format($totaliprefundamount,2,'.',','); ?></strong></td>-->

                <!--VENU-- REMOVE NHIF-->

                  <!--<td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong>-<?php // echo number_format($totalnhifamount,2,'.',','); ?></strong></td>-->

                <!--ENDS-->

              <td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totalipmiscamount,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totalbrfotherdisc,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totaliprebateamount,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($totalipdiscountamount,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong><?php echo number_format($rowtotfinal,2,'.',','); ?></strong></td>

				<td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong></strong></td>

         		<td class="bodytext311" valign="center" bordercolor="#FFF" align="right" 

                bgcolor="#FFF"><strong></strong></td>

               </tr>

          </tbody>

        </table>