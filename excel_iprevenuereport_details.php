<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="iprevenuereport_details.xls"');
header('Cache-Control: max-age=80');

$ipaddress = $_SERVER['REMOTE_ADDR'];


$total_beforesharing=0;
$total_sharingamount=0;

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');

$colorloopcount='';

$sno='';

 

?>

<style type="text/css">

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFFFFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

</style>



<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

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

</head>



<script src="js/datetimepicker_css.js"></script>

           <?php

            $colorloopcount ='';

			$netamount='';

			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

			if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }

			if (isset($_REQUEST["ward"])) { $ward = $_REQUEST["ward"]; } else { $ward = ""; }

			if (isset($_REQUEST["name"])) { $name = $_REQUEST["name"]; } else { $name = ""; }
			
			if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }

		//$ADate1='2015-02-01';

		//$ADate2='2015-02-28';

        $title ='';

		if($name=='admission') 

			$title = "Admission Charge";

			elseif($name=='bed')

				$title = "Bed Charge";

			elseif($name=='package')

			  $title = "Package Charge";

			elseif($name=='Nursing')

			  $title = "Nursing Charge";

			elseif($name=='mo')

			  $title = "MO Charge";

			elseif($name=='consultant')

			  $title = "Consultant Charge";

			elseif($name=='lab')

			  $title = "Lab Charge";

			elseif($name=='rad')

			  $title = "Radiology Charge";

			elseif($name=='pharma')

			  $title = "Pharma Charge";

			elseif($name=='services')

			  $title = "Services Charge";

			elseif($name=='ambulance')

			  $title = "Ambulance Charge";

			elseif($name=='homecare')

			  $title = "Homecare Charge";

			elseif($name=='pvtdr')

			  $title = "Private Doctor Charge";

			elseif($name=='misc')

			  $title = "Misc Billing";

			elseif($name=='discount')

			  $title = "Discount";

			elseif($name=='others')

			  $title = "Others";



		?>

<table width="" border="0" cellspacing="0" cellpadding="2">


  <tr>

    <td width="" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="">

        	<?php if($name=='pvtdr'){ $width="1000";$head_title_colspan="10";} else{$width="800";$head_title_colspan="8";} ?>

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="<?= $width?>" 

            align="left" border="1">

          <tbody>

            <tr>

              <td width="" bgcolor="#ecf0f5" class="bodytext31" colspan="<?= $head_title_colspan?>"><strong>IP <?php echo $title;?> Details From  <?php echo $ADate1;?> To <?php echo $ADate2;?></strong></td>

              </tr>            

			
             <?php
			if($name=='pvtdr'){
			?>
			  <tr <?php //echo $colorcode; ?>>


             <td width="3%" class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
			 
			 <td width="8%" class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Bill Number</strong></td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Patient Code</td>

			  <td width="20%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Patient Name</td>

              <td width="10%" align="" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>

              <td width="10%" align="" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Date</td>

			  <td  width="20%" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doctor</td>

			  <td  width="7%" valign="center" bgcolor="#FFFFFF" class="bodytext31">Bill Amt</td>
			  <td width="3%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Dr.Share(%)</td>
			  <td width="7%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Dr.Share</td>
			  <td width="7%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Hosp.Share</td>


            </tr>
            
           <?php } 
		   else if($name=='services'){  ?>

		   <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
			  
			  <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Bill Number</strong></td>

              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doc. No</td>

			  <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Patient Name</td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Date</td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>

			  <!-- <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Bill Number</td> -->


			  <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Service</td>

			   <td width="15%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Services Amount</td>
              <td width="15%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Dr Sharing Amount</td>
              <td width="21%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Hospital Amount</td>
              <!-- <td width="" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td> -->

            </tr>

          <?php
		   }
		   else {?>
            <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
			  
			  <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Bill Number</td>

              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Patient Code</td>

			  <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Patient Name</td>
			  
			  <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Remarks</td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Date</td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>

              <td width="" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td>

            </tr>

        <?php
		   }



	   if($_GET['type'] =='cash') {

		   $chk = "accountnameano = '47'";

               if($ward=='')

				{

				  $query1 = "select visitcode,'billing' as type from billing_ip where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1' and accountnameano = '47'  UNION ALL SELECT visitcode,'creditapproved' as type from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1' and accountnameano = '47'";

				}

				else {



                   $query1 = "select visitcode,'billing' as type from ip_bedallocation where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1')



				   UNION  select visitcode,'creditapproved' as type from ip_bedallocation where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1')



				   UNION  select visitcode,'billing' as type from ip_bedtransfer where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1')	

				   

				   UNION  select visitcode,'creditapproved' as type from ip_bedtransfer where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1')	

				   ";

				}



	   }elseif($_GET['type']=='credit') {

          $chk = "accountnameano != '47'";

		if($ward=='')

		{

				 $query1 = "select visitcode,'billing' as type from billing_ip where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1' and accountnameano != '47'  UNION ALL SELECT visitcode,'creditapproved' as type from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1' and accountnameano != '47'";

		}

		else {



				   $query1 = "select visitcode,'billing' as type from ip_bedallocation where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano != '47'  and  locationcode='$locationcode1')



				   UNION  select visitcode,'creditapproved' as type from ip_bedallocation where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano != '47'  and  locationcode='$locationcode1')



				   UNION  select visitcode,'billing' as type from ip_bedtransfer where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano != '47'  and  locationcode='$locationcode1')	

				   

				   UNION  select visitcode,'creditapproved' as type from ip_bedtransfer where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano != '47'  and  locationcode='$locationcode1')	

				   ";

		}

	   }elseif($_GET['type']=='note'){

           $query1 = "select patientcode, patientvisitcode as visitcode,patientname from ip_creditnotebrief where locationcode = '$locationcode1' and consultationdate between '$ADate1' and '$ADate2' and patientvisitcode like '%IPV%' group by patientcode ";

	   }

	    $total_bill_amt = 0;
	   $tot_doctor_share_amount = 0;
	   $tot_hospital_share_amount =0;

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num1=mysqli_num_rows($exec1);

	$totaladmncharges = 0;

	if($num1>0){

		while($res1 = mysqli_fetch_array($exec1))

		{

			

		    $visitcode=$res1['visitcode'];

			if($name=='admission') {
			
			 $query66 = "select  patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber  from billing_ipadmissioncharge where locationcode='$locationcode1' and visitcode='$visitcode' and recorddate between '$ADate1' and '$ADate2'  ";

			}elseif($name=='bed'){

				if($_GET['type']=='note') {

                    $query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate AS amountuhx,docno as billnumber FROM ip_creditnotebrief WHERE description='Bed Charges' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'

					";

				}else{

					$query66 = "SELECT patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber FROM `billing_ipbedcharges` WHERE description = 'Bed Charges' AND recorddate BETWEEN '$ADate1' AND '$ADate2'   and visitcode='$visitcode'  

					UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Bed Charges' and patientvisitcode='$visitcode'

					";

				}

			}elseif($name=='package')

			{

				// if($res1['type']=='billing') {

				  $query66 = "select patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2' 

				  UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'

				";

				// }else{


					 // $query66 = "select patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN ('Bed Charges','Nursing Charges','Resident Doctor Charges') and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2'
		
						//    UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','Resident Doctor Charges') and patientvisitcode='$visitcode'
		
						//    ";


			       //             $query66 = "select patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN  ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges') and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2'

							   // UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges') and patientvisitcode='$visitcode'

							   // ";

				// }

			}elseif($name=='nursing')

			{

				if($_GET['type']=='note') {

                    $query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate AS amountuhx,docno as billnumber FROM ip_creditnotebrief WHERE description='Nursing Charges' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'

					";

				}else{

					if($res1['type']=='billing') {

					  $query66 = "select patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber from billing_ipbedcharges where locationcode='$locationcode1' and  description='Nursing Charges' and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2' 

					  UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description='Nursing Charges' and patientvisitcode='$visitcode'

					";

					}else{


						$query66 = "select patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber from billing_ipbedcharges where locationcode='$locationcode1' and  description='Nursing Charges' and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2' 
		
							   UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description='Nursing Charges' and patientvisitcode='$visitcode'  ";

					   // $query66 = "select patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber from billing_ipbedcharges where locationcode='$locationcode1' and  description='Ward Dispensing Charges' and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2' 

					   // UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description='Ward Dispensing Charges' and patientvisitcode='$visitcode'

					   // ";

					}

				}

			}

			elseif($name=='mo')

			{

				if($_GET['type']=='note') {

                    $query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate AS amountuhx,docno as billnumber FROM ip_creditnotebrief WHERE description='RMO Charges' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'

					";

				}else{

					// if($res1['type']=='billing') {

					  $query66 = "SELECT patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber FROM `billing_ipbedcharges` WHERE (description = 'RMO Charges' or description ='Daily Review charge') AND recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode='$visitcode'

					  UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'RMO Charges' and patientvisitcode='$visitcode'

					";

					// }else{

					//    $query66 = "SELECT  patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber FROM `billing_ipbedcharges` WHERE (description = 'Resident Doctor Charges') AND recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode='$visitcode'

					//    ";

					// }

				}

			}elseif($name=='consultant')

			{

				if($_GET['type']=='note') {

                    $query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate AS amountuhx,docno as billnumber FROM ip_creditnotebrief WHERE description='Consultant Fee' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'

					";

				}else{

					$query66 = "SELECT patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber FROM `billing_ipbedcharges` WHERE description = 'Consultant Fee' AND recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";

				}

			}elseif($name=='lab')

			{

				if($_GET['type']=='note') {

                    $query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate AS amountuhx,docno as billnumber FROM ip_creditnotebrief WHERE description='Lab' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'

					";

				}else{

					$query66 = "SELECT billdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rateuhx as amountuhx,billnumber as billnumber FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode ='$visitcode'

					UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Lab' and patientvisitcode='$visitcode'

					";

				}

			}elseif($name=='rad')

			{

				if($_GET['type']=='note') {

                    $query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate AS amountuhx,docno as billnumber FROM ip_creditnotebrief WHERE description='Radiology' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'

					";

				}else{

					$query66 = "SELECT billdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,radiologyitemrateuhx as amountuhx,billnumber as billnumber FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode ='$visitcode'

					UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Radiology' and patientvisitcode='$visitcode'";

				}

			}elseif($name=='pharma')

			{

				if($_GET['type']=='note') {

                    $query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate AS amountuhx,docno as billnumber FROM ip_creditnotebrief WHERE description='Pharmacy' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'

					";

				}else{

					$query66 = "SELECT patientcode,patientname,patientvisitcode as visitcode,billdate as recorddate,amountuhx as amountuhx,billnumber as billnumber FROM `billing_ippharmacy`  WHERE   billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode ='$visitcode'";

				}

			}elseif($name=='services')

			{

				if($_GET['type']=='note') {

                    $query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate AS amountuhx,'' as servicesitemname,docno as billnumber FROM ip_creditnotebrief WHERE description='Service' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'

					";

				}else{

					$query66 = "SELECT billdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,servicesitemrateuhx as amountuhx,servicesitemname,billnumber as billnumber,sharingamount FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode ='$visitcode'

					UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,'' as servicesitemname,docno as billnumber,'' as sharingamount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Service' and patientvisitcode='$visitcode'";

				}

			}elseif($name=='ambulance')

			{

				$query66 = "SELECT recorddate,patientcode,patientname,visitcode as visitcode, amountuhx,docno as billnumber FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";

			}elseif($name=='homecare')

			{

				$query66 = "SELECT recorddate,patientcode,patientname,visitcode as visitcode,amount as amountuhx,docno as billnumber FROM billing_iphomecare WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";

			}elseif($name=='pvtdr')

			{

				$query66 = "SELECT *,docno as billnumber FROM billing_ipprivatedoctor WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";

			}elseif($name=='misc')

			{

				 $query66 = "SELECT recorddate,patientcode,patientname,visitcode as visitcode,amountuhx,docno as billnumber FROM billing_ipmiscbilling WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";

			}elseif($name=='discount')

			{

				if($_GET['type']=='cash') {

						$query66 = "select consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,sum(rate) as amountuhx,docno as billnumber from ip_discount where   patientvisitcode='$visitcode'  and consultationdate between '$ADate1' and '$ADate2' ";
					}else{
		
						 	$query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate as amountuhx,docno as billnumber FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE $chk and transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber) and patientvisitcode ='$visitcode'
		
						 	UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate as amountuhx,docno as billnumber FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE $chk and billdate BETWEEN '$ADate1' AND '$ADate2' group by billno) and patientvisitcode ='$visitcode'";
						}

			}elseif($name=='others')

			{   

				if($_GET['type']=='note') {

                    $query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate AS amountuhx,docno as billnumber FROM ip_creditnotebrief WHERE description='Others' AND patientvisitcode='$visitcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$ADate1' and '$ADate2'

					";

				}else{

				 $query66 = "SELECT recorddate,patientcode,patientname,visitcode as visitcode,amountuhx,docno as billnumber FROM billing_ipmiscbilling WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";

				}

			}
			elseif($name=='rebate')
			{
				
				if($_GET['type']=='cash'){

					$query66 = "SELECT recorddate,patientcode,patientname,visitcode,amount as amountuhx,docno as billnumber FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2'  and visitcode ='$visitcode' and accountname = 'CASH - HOSPITAL'";

				}	
				else{
					$query66 = "SELECT recorddate,patientcode,patientname,visitcode,amount as amountuhx,docno as billnumber FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2'  and visitcode ='$visitcode' and accountname != 'CASH - HOSPITAL'";

				}	
			}


			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res66 = mysqli_fetch_array($exec66))

			{

				$patientcode = $res66['patientcode'];

				$consultationdate = $res66['recorddate'];

				$visitcode = $res66['visitcode'];

				$consultationfee = $res66['amountuhx'];

				$patientname=$res66['patientname'];
				
				$billnumber=$res66['billnumber'];
				
				
			$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
			$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_ipdiscount05 = mysqli_num_rows($exec6405);
			$res6405 = mysqli_fetch_array($exec6405);
			$discount= $res6405['description'];
			$authorizedby = $res6405['authorizedby'];

			if($name=='discount' && $_GET['type']=='cash')
								{
									if($consultationfee==0 or $consultationfee=='0.00'){
										continue;
									}
								}
				

				 $sno=$sno+1;

				if($name=='services')
				{ 
				$sharingamount = $res66['sharingamount'];
				$beforesharing = $res66['amountuhx'];
			    $consultationfee = $consultationfee-$sharingamount;

			    		$total_beforesharing+=$beforesharing;
						$total_sharingamount+=$sharingamount;
				}

			    $totaladmncharges=$totaladmncharges+$consultationfee;

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

				if($name=='pvtdr'){ 
if($res66['visittype'] =="IP")
                	{
						if($res66['coa'] !="")
                		  $billamt = $res66['transactionamount'];
						else
						  $billamt = $res66['original_amt'];
                	}
                	else
                	{
                		$billamt = $res66['original_amt'];
                	}
					
                	$total_bill_amt = $total_bill_amt + $billamt;
                	$hospital_share = $billamt - $res66['sharingamount'];
                	$tot_hospital_share_amount = $tot_hospital_share_amount + $hospital_share;
                	$doctor_share_amt = $res66['sharingamount'];
                	$tot_doctor_share_amount = $tot_doctor_share_amount + $doctor_share_amt;

					?>

                <tr >


				  <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber ?></td>


				   <td class="bodytext31" valign="center"  align="left">


					<div class="bodytext31"><?php echo $patientcode;?></div> </td>


					<td class="bodytext31" valign="center"  align="left">


					<div class="bodytext31"><?php echo $patientname;?></div> </td>

                    <td class="bodytext31" valign="center" align=""><?php echo $visitcode;?></td>

					<td class="bodytext31" valign="center" align=""><?php echo $consultationdate;?></td>


					<td class="bodytext31" valign="center" align=""><?php echo $res66['description'];?></td>
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($billamt,2,'.',','); ?></div></td>

					<td class="bodytext31" valign="center" align="right"><?php echo $res66['pvtdr_percentage'];?></td>
					<td class="bodytext31" valign="center" align="right"><?php echo number_format($res66['sharingamount'],2,'.',',');?></td>
					 <td class="bodytext31" valign="center" align="right"><?php echo number_format($hospital_share,2,'.',',');?></td> 
				<!-- <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></div></td> -->


			   </tr>
				<?php
				}
			   elseif($name=='services'){

				   $servicesitemname = $res66['servicesitemname'];

				  	$billnumber = $res66['billnumber'];



				?>

			   <tr>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber ?></td>

				   <td class="bodytext31" valign="center"  align="left">

					<div class="bodytext31"><?php echo $patientcode;?></div> </td>

					<td class="bodytext31" valign="center"  align="left">

					<div class="bodytext31"><?php echo $patientname;?></div> </td>

					

				   <td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>

				   <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
				   <!-- <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;  ?></div></td> -->
                    <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $servicesitemname;  ?></div></td>

				<!-- <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></div></td> -->
				<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($beforesharing,2,'.',','); ?></div></td>
						<td align="right" valign="center"  class="bodytext31"><div class="bodytext31">-<?php echo number_format($sharingamount,2,'.',','); ?></div></td>
						<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>

			   </tr>

		<?php
			   }
			   else{

				?>

			   <tr>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber ?></td>

				   <td class="bodytext31" valign="center"  align="left">

					<div class="bodytext31"><?php echo $patientcode;?></div> </td>

					<td class="bodytext31" valign="center"  align="left">

					<div class="bodytext31"><?php echo $patientname;?></div> </td>

					<td class="bodytext31" valign="center"  align="left">


					<div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>

				   <td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>

				   <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>

				<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>

			   </tr>

		<?php
			   }

			}

		}

	}

?>		

         <tr>

              <?php if($name=='pvtdr'){ ?>

             <td colspan="7">&nbsp;</td>
              	 <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($total_bill_amt,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_doctor_share_amount,2,'.',',');  ?></strong></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($tot_hospital_share_amount,2,'.',',');  ?></strong></div></td>


             <?php } elseif($name=='services')
             { ?>
             	<td colspan="7"  class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong>Total Charges:</strong></td>
                <td align="right" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($total_beforesharing,2,'.',','); ?></strong></td>
                <td align="right" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>-<?php echo number_format($total_sharingamount,2,'.',','); ?></strong></td>
                <td align="right" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totaladmncharges,2,'.',','); ?></strong></td>
            <?php  }

              else { ?>
              	

			 <td colspan="7"  class="bodytext31" valign="center"  align="right" 


                bgcolor="#ecf0f5"><strong>Total Charges:</strong></td>
                 <td align="right" valign="center" 

                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totaladmncharges,2,'.',','); ?></strong></td>

			 <?php } ?>

             <!--  <td align="right" valign="center" 

                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totaladmncharges,2,'.',','); ?></strong></td> -->

<!--				<?php if($nettotal != 0.00) { ?>

				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

                

			    <?php 

				}?>

-->		



          </tbody>

        </table>

        

			