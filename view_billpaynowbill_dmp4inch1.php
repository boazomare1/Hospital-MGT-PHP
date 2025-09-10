<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

date_default_timezone_set('Asia/Calcutta'); 

$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];



$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }



/*	$query2 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";

	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());

	$res2 = mysql_fetch_array($exec2);

	$companyname = $res2["companyname"];

	$address1 = $res2["address1"];

	$area = $res2["area"];

	$city = $res2["city"];

	$pincode = $res2["pincode"];

	$phonenumber1 = $res2["phonenumber1"];

	$phonenumber2 = $res2["phonenumber2"];

	$tinnumber1 = $res2["tinnumber"];

	$cstnumber1 = $res2["cstnumber"];*/

	

	include('convert_currency_to_words.php');

	

	$query11 = "select * from master_transactionpaynow where billnumber = '$billautonumber' ";

	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	mysqli_num_rows($exec11);

	$res11 = mysqli_fetch_array($exec11);

	$res11patientfirstname = $res11['patientname'];

	$res11patientcode = $res11['patientcode'];

	$res11visitcode = $res11['visitcode'];

	$res11billnumber = $res11['billnumber'];

	$res11billingdatetime = $res11['transactiondate'];

	$res11patientpaymentmode = $res11['transactionmode'];

	$res11username = $res11['username'];

	$res11cashamount = $res11['cashamount'];

	$res11transactionamount = $res11['transactionamount'];

	$convertedwords = covert_currency_to_words($res11transactionamount); 

    $res11chequeamount = $res11['chequeamount'];

	$res11cardamount = $res11['cardamount'];

	$res11onlineamount= $res11['onlineamount'];

	$res11adjustamount= $res11['adjustamount'];

	$res11creditamount= $res11['creditamount'];

	$res11updatetime= $res11['transactiontime'];

	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];

	$res11cashgiventocustomer = $res11['cashgiventocustomer'];

	$res11locationcode = $res11['locationcode'];

	$mpesanumber = $res11['mpesanumber'];

	
	

	$queryuser="select employeename from master_employee where username='$res11username'";

		$execuser = mysqli_query($GLOBALS["___mysqli_ston"], $queryuser) or die ("Error in queryuser".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resuser = mysqli_fetch_array($execuser);

		$res11username=$resuser['employeename'];

?>



<?php 

$query2 = "select * from master_location where locationcode = '$res11locationcode'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		//$companyname = $res2["companyname"];

		$address1 = $res2["address1"];

		$address2 = $res2["address2"];

//		$area = $res2["area"];

//		$city = $res2["city"];

//		$pincode = $res2["pincode"];

		$emailid1 = $res2["email"];

		$phonenumber1 = $res2["phone"];

		$locationcode = $res2["locationcode"];

//		$phonenumber2 = $res2["phonenumber2"];

//		$tinnumber1 = $res2["tinnumber"];

//		$cstnumber1 = $res2["cstnumber"];

		$locationname =  $res2["locationname"];

		$prefix = $res2["prefix"];

		$suffix = $res2["suffix"];

?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>





<script type="text/javascript" src="js/autocomplete_users.js"></script>

<script type="text/javascript" src="js/autosuggestusers.js"></script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table width="1901" border="0" cellspacing="0" cellpadding="2">

 

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="1134">

		

		

              <form name="cbform1" method="post" action="billenquiry.php">

		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

           <tr> 

           <td class="bodytext33" bgcolor="#FFFFFF" >Name : </td>

    <td  class="bodytext33" bgcolor="#FFFFFF" ><?php echo $res11patientfirstname; ?></td>
	
	<td  class="bodytext33"  bgcolor="#FFFFFF">Bill No: </td>

        <td valign="top"  colspan="2" class="bodytext33"  bgcolor="#FFFFFF"><?php echo $res11billnumber; ?></td>
	</tr>
	
	
	<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Reg No: </td>

        <td  align="left" class="bodytext33" bgcolor="#FFFFFF" ><?php echo $res11patientcode; ?></td>
		
		 <td class="bodytext33" bgcolor="#FFFFFF">Bill Date: </td>

		<td class="bodytext33" colspan="2" bgcolor="#FFFFFF"><?php echo date("d/m/y", strtotime($res11billingdatetime)); ?></td>
		
		</tr>

	
	<tr>
		<td align="left" class="bodytext33" bgcolor="#FFFFFF">OPVisit No: </td>
        <td colspan="4" align="left" class="bodytext33" bgcolor="#FFFFFF"><?php echo $res11visitcode; ?></td></tr>

	     
		 
		
    

  <tr>

	 <td align="left" class="bodytext32 border" width="" bgcolor="#FFFFFF">S.No</td>

	  <td align="left" class="bodytext32 border" width="45" bgcolor="#FFFFFF"><strong>Description</strong></td>

	  <td align="left" class="bodytext32 border" width="25" bgcolor="#FFFFFF"><strong>Qty</strong></td>

	  <td align="left" class="bodytext32 border" width="15%" bgcolor="#FFFFFF"><strong>Rate</strong></td>

    <td align="left" class="bodytext32 border" width="20" bgcolor="#FFFFFF"><strong>Amount</strong></td>

  </tr>
  

   <?php

   $query14 = "select planpercentage,planname from master_visitentry where locationcode='$locationcode' and visitcode = '$res11visitcode' and patientcode = '$res11patientcode'  ";

			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res14 = mysqli_fetch_array($exec14);

			 $planpercent=$res14['planpercentage'];

			 $plannumber = $res14['planname'];

			

			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//

			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resplanname = mysqli_fetch_array($execplanname);

		 	$planforall = $resplanname['forall'];

   

   

			$colorloopcount = '';

			$sno = '';

			$query_pw = "select consultationamount, pharmacyamount, labamount, radiologyamount, servicesamount from billing_patientweivers where visitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billno = '$res11billnumber' ";

			$exec_pw = mysqli_query($GLOBALS["___mysqli_ston"], $query_pw) or die ("Error in Query_pw".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res_pw = mysqli_fetch_array($exec_pw);

			$pw_consultation = $res_pw['consultationamount'];

			$pw_pharmacy = $res_pw['pharmacyamount'];

			$pw_lab = $res_pw['labamount'];

			$pw_radiology = $res_pw['radiologyamount'];

			$pw_services = $res_pw['servicesamount'];

			

			$query1 = "select * from billing_paynowlab where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber' ";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res1 = mysqli_fetch_array($exec1))

			{

		    $res1labitemname = $res1['labitemname'];

			$res1labitemrate = $res1['labitemrate'];

			$colorloopcount = $colorloopcount + 1;

			$sno =$sno + 1;

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

			  <tr <?php //echo $colorcode; ?>>

              	<td class="bodytext34 " valign="center"  align="left"  bgcolor="#FFFFFF">

			   <?php echo $sno; ?></td>

			   <td class="bodytext34 border" valign="center"  align="left"  width="245" bgcolor="#FFFFFF">

			   <?php echo nl2br($res1labitemname); ?></td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF" >

			   <?php echo 1; ?></td>

				<td class="bodytext34 border" valign="center"  align="left"  width="55" bgcolor="#FFFFFF">

			  <?php echo number_format($res1labitemrate,2,'.',','); ?></td>

				<td  align="right" valign="left" class="bodytext34 border"  bgcolor="#FFFFFF">

			   <?php echo number_format($res1labitemrate,2,'.',','); ?></td>

              </tr>

              <?php if($planforall=='yes'){?>

               <tr <?php //echo $colorcode; ?>>

              	<td class="bodytext34 " valign="center"  align="left" bgcolor="#FFFFFF">

			   <?php echo $sno=$sno+1; ?></td>

			   <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			   <?php echo "COPAY"; ?></td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">&nbsp;

			   </td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			  <?php  ?></td>

				<td  align="left" valign="center" class="bodytext34 border" bgcolor="#FFFFFF">

			   <?php $copay=($res1labitemrate/100)*$planpercent; echo '-',number_format($copay,2,'.',','); ?></td>

              </tr>

			  <?php

			  }

			}

			if($pw_lab > 0)

			{

			?>

			<tr <?php //echo $colorcode; ?>>

              	<td class="bodytext34 " valign="center"  align="left" bgcolor="#FFFFFF">

			   <?php echo $sno=$sno+1; ?></td>

			   <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF" >

			   <?php echo "Lab Discount"; ?></td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">1

			   </td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			  <?php  echo '-',number_format($pw_lab,2,'.',','); ?></td>

				<td  align="left" valign="center" class="bodytext34 border" bgcolor="#FFFFFF">

			   <?php echo '-',number_format($pw_lab,2,'.',','); ?></td>

              </tr>

			<?php

			}

			?>

			

			<?php

			$colorloopcount = '';

			

			

			$query2 = "select * from billing_paynowradiology where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber' ";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res2 = mysqli_fetch_array($exec2))

			{

		    $res2radiologyitemname = $res2['radiologyitemname'];

			$res2radiologyitemrate = $res2['radiologyitemrate'];

			$sno =$sno + 1;

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

			   

			 <?php if($res2radiologyitemrate != '0.00' ) { ?>

			  <tr <?php //echo $colorcode; ?>>

              <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			   <?php echo $sno; ?></td>

			   <td class="bodytext34 border" valign="center"  align="left" width="245" bgcolor="#FFFFFF">

			 <?php echo nl2br($res2radiologyitemname); ?></td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			<?php echo 1; ?></td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			   <?php echo number_format($res2radiologyitemrate,2,'.',','); ?></td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			   <?php echo number_format($res2radiologyitemrate,2,'.',','); ?></td>

              </tr>

			  <?php

			}  }

			

			if($pw_radiology > 0)

			{

			?>

			<tr <?php //echo $colorcode; ?>>

              	<td class="bodytext34 " valign="center"  align="left" bgcolor="#FFFFFF">

			   <?php echo $sno=$sno+1; ?></td>

			   <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			   <?php echo "Radiology Discount"; ?></td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">1

			   </td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			  <?php  echo '-',number_format($pw_radiology,2,'.',','); ?></td>

				<td  align="left" valign="center" class="bodytext34 border" bgcolor="#FFFFFF">

			   <?php echo '-',number_format($pw_radiology,2,'.',','); ?></td>

              </tr>

			<?php

			}

			?>

			<?php

			$colorloopcount = '';

			

			

			$query3 = "select * from billing_paynowservices where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber' group by servicesitemcode";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res3 = mysqli_fetch_array($exec3))

			{

		    $res3servicesitemname = $res3['servicesitemname'];

			$res3servicesitemrate = $res3['servicesitemrate'];

			$res3servicesitemcode = $res3['servicesitemcode'];

			

			$query2111 = "select * from billing_paynowservices where locationcode='$locationcode' and patientvisitcode='$res11visitcode' and patientcode='$res11patientcode' and servicesitemcode = '$res3servicesitemcode' and billnumber = '$res11billnumber'";

			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numrow2111 = mysqli_num_rows($exec2111);

			

			$res3serviceserviceqty = $res3['serviceqty'];

			if($res3serviceserviceqty==0){$res3serviceserviceqty=$numrow2111;}

			$res3servicesitemamount = $res3['amount'];

			if($res3servicesitemamount==0){

			$res3servicesitemamount = $res3servicesitemrate*$numrow2111;

			}

			$sno =$sno + 1;

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

			  <tr <?php //echo $colorcode; ?>>

              <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			   <?php echo $sno; ?></td>

			   <td class="bodytext34 border" valign="center"  align="left" width="245" bgcolor="#FFFFFF">

			  <?php echo nl2br($res3servicesitemname); ?></td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			  <?php echo $res3serviceserviceqty; ?></td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			 <?php echo number_format($res3servicesitemrate,2,'.',','); ?></td>

				<td class="bodytext34 border" valign="center"  align="left"  bgcolor="#FFFFFF">

			 <?php echo number_format($res3servicesitemamount,2,'.',','); ?></td>

              </tr>

			  <?php

			}

			if($pw_services > 0)

			{

			?>

			<tr <?php //echo $colorcode; ?>>

              	<td class="bodytext34 " valign="center"  align="left" bgcolor="#FFFFFF" >
			   <?php echo $sno=$sno+1; ?></td>

			   <td class="bodytext34 border" valign="center"  align="left"bgcolor="#FFFFFF" >

			   <?php echo "Services Discount"; ?></td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">1

			   </td>

				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			  <?php  echo '-',number_format($pw_services,2,'.',','); ?></td>

				<td  align="left" valign="center" class="bodytext34 border" bgcolor="#FFFFFF">

			   <?php echo '-',number_format($pw_services,2,'.',','); ?></td>

              </tr>

			<?php

			}

			?>

			<?php

			$colorloopcount = '';

			

			
			$query5 = "select * from billing_paynowreferal where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res5 = mysqli_fetch_array($exec5))
			{
		    $res3referalname = $res5['referalname'];
			$res3referalrate = $res5['referalrate'];
			$res3referalcode = $res5['referalcode'];
			$res3patientvisitcode = $res5['patientvisitcode'];
			$res3patientcode = $res5['patientcode'];
			
			$query51 = "SELECT referalremark FROM consultation_referal WHERE referalcode = '$res3referalcode' AND patientcode = '$res3patientcode' AND patientvisitcode = '$res3patientvisitcode'";
			$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res51 = mysqli_fetch_array($exec51);
			$res51referalremark = $res51['referalremark'];
			if($res51referalremark != ''){
				$res51referalremark = " - ".$res51referalremark;
			}
			$sno =$sno + 1;
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

			<tr <?php //echo $colorcode; ?>>
				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF"><?php echo $sno; ?></td>
				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF" width="245"><?php echo nl2br($res3referalname.$res51referalremark); ?></td>
				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF" ><?php echo 1; ?></td>
				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF" ><?php echo number_format($res3referalrate,2,'.',','); ?></td>
				<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF"><?php echo number_format($res3referalrate,2,'.',','); ?></td>
			</tr>

			  <?php

			}

			?>

			<?php

			$colorloopcount = '';

			

			

			$query4 = "select * from billing_paynowpharmacy where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber' ";

			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res4 = mysqli_fetch_array($exec4))

			{

		    $res4medicinename = $res4['medicinename'];


			$res4amount = $res4['amount'];

			$res4quantity = $res4['quantity'];

			$res4rate = $res4['rate'];

			$sno =$sno + 1;

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

			  <tr <?php //echo $colorcode; ?>>

              <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

			   <?php echo $sno; ?></td>

			    <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF" width="245"><?php echo nl2br($res4medicinename); ?></td>

			    <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF"><?php echo $res4quantity; ?></td>

			    <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF"><?php echo number_format($res4rate,2,'.',','); ?></td>

			    <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF"><?php echo number_format($res4amount,2,'.',','); ?></td>

              </tr>

			  <?php

			    }

				if($pw_pharmacy > 0)

				{

				?>

				<tr <?php //echo $colorcode; ?>>

					<td class="bodytext34 " valign="center"  align="left" bgcolor="#FFFFFF">

				   <?php echo $sno=$sno+1; ?></td>

				   <td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

				   <?php echo "Pharmacy Discount"; ?></td>

					<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">1

				   </td>

					<td class="bodytext34 border" valign="center"  align="left" bgcolor="#FFFFFF">

				  <?php  echo '-',number_format($pw_pharmacy,2,'.',','); ?></td>

					<td  align="left" valign="center" class="bodytext34 border" bgcolor="#FFFFFF">

				   <?php echo '-',number_format($pw_pharmacy,2,'.',','); ?></td>

				  </tr>

				<?php

				}

				?>
		 
		 
		 <tr>

		<td align="right " colspan="4" class="bodytext32" bgcolor="#FFFFFF">Bill Amount:</td>

		<td align="right " class="bodytext32" bgcolor="#FFFFFF"><?php echo number_format($res11transactionamount,2,'.',','); ?></td>

	</tr> 

   
 <?php if($res11cashgivenbycustomer != 0.00) { ?> 

 	<tr><td colspan="5" class="bodytext33" bgcolor="#FFFFFF">Payment Mode:</td></tr>

    <tr>

		<td class="bodytext32"  colspan="2" bgcolor="#FFFFFF"><strong>Cash Received:</strong></td>

        <td align="right"  class="bodytext34"  valign="middle" bgcolor="#FFFFFF"><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></td>

		<td align="right" width="" bgcolor="#FFFFFF">&nbsp;</td>

		<td align="right" width="" bgcolor="#FFFFFF">&nbsp;</td>

	

	</tr>

	<tr>

		<td class="bodytext32" colspan="2" bgcolor="#FFFFFF"><strong>CashReturned:</strong></td>

        <td   class="bodytext34" align="right" valign="middle" bgcolor="#FFFFFF"><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

		

	</tr>

	<?php } ?>
	
	
	<?php if($res11chequeamount != 0.00) { ?> 

	<tr>

		<td class="bodytext32" colspan="2" bgcolor="#FFFFFF"><strong>Cheque Amount</strong></td>

		<td align="right" class="bodytext34" valign="middle" bgcolor="#FFFFFF"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

       

	</tr>

	<?php } ?>
	
	<?php if($res11onlineamount != 0.00) { ?> 

	<tr>

		<td class="bodytext32" colspan="2" bgcolor="#FFFFFF"><strong>Online Amount</strong></td>

		<td align="right" class="bodytext34" valign="middle" bgcolor="#FFFFFF"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

       
	</tr>

	<?php } ?>


<?php if($res11cardamount != 0.00) { ?> 
<tr><td colspan="5" class="bodytext33" bgcolor="#FFFFFF">Payment Mode:</td></tr>
	<tr>

		<td class="bodytext32" colspan="2" bgcolor="#FFFFFF"><strong>Card Amount</strong></td>

        <td align="right" class="bodytext34" valign="middle" bgcolor="#FFFFFF"><?php echo number_format($res11cardamount,2,'.',','); ?></td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

       

		

	</tr>

	<?php } ?>
	
	
	
    <?php if($res11creditamount != 0.00) { ?> 

	<tr>

		<td class="bodytext32" colspan="2" bgcolor="#FFFFFF"><strong>MPESA - <?php echo $mpesanumber;?></strong><span align="right"></span></td>

        <td align="right" class="bodytext34" valign="middle" bgcolor="#FFFFFF" ><?php echo number_format($res11creditamount,2,'.',','); ?></td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

       

		

	</tr>

	<?php } ?>	
	
	
	<?php if($res11adjustamount != 0.00) { ?> 

	<tr>

		<td class="bodytext32" colspan="2" bgcolor="#FFFFFF"><strong>Deposit Adjusted</strong></td>

		<td align="right" class="bodytext34" valign="middle" bgcolor="#FFFFFF"><?php echo number_format($res11adjustamount,2,'.',','); ?></td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

		<td align="right" bgcolor="#FFFFFF">&nbsp;</td>

       
	</tr>

	<?php } ?>
	
	<tr>

		<td colspan="5" class="bodytext32" bgcolor="#FFFFFF"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>

	</tr>
<tr>

		<td colspan="5" align="right" class="bodytext32" bgcolor="#FFFFFF">Served By: <?php echo strtoupper($res11username); ?> </td>

	</tr>

	<tr>

		<td colspan="5" align="right" class="bodytext31" bgcolor="#FFFFFF"><?php echo date("d/m/Y", strtotime($res11billingdatetime))."&nbsp;".date("g.i A",strtotime($res11updatetime)); ?> </td>

	</tr>
 
          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      

        </td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>



