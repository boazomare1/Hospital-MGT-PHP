<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
$transactiondatefrom = $_REQUEST['ADate1'];
$transactiondateto = $_REQUEST['ADate2'];
$locationcode = $_REQUEST['locationcode'];
$department=isset($_REQUEST['department'])?$_REQUEST['department']:'%%';
}
$query12 = "select locationname from master_location where locationcode='$locationcode' order by locationname";
$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
$res12 = mysqli_fetch_array($exec12);
$res1location = $res12["locationname"];
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<script src="js/datetimepicker_css.js"></script>
<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  
  
   <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top">
      <table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" align="left" border="0">
          <tbody>
            <td colspan="11" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Revenue &nbsp; From &nbsp;<?php echo $transactiondatefrom; ?> To <?php echo $transactiondateto; ?></strong></td>
			
			<tr>
              	  <td width="3%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>S.No</strong></td>
                  <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
                  <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Reg.No</strong></td>
                  <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Visit No</strong></td>
                  <td width="16%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
                  <td width="16%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Doctor</strong></td>
                  <td width="9%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bill Amt</strong></td>
                  <td width="4%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Dr.Share%</strong></td>
                  <td width="8%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Dr.Share</strong></td>
                  <td width="8%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Hosp.Share</strong></td>
                  <td width="12%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Location Name</strong></td>
             </tr>
			 
			 <?php
			    if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$colorloopcount = '';
					$tot_amount = 0.00;
					$snocount=0;
					$tot_doctor_amount = 0;
					$tot_hospital_amount = 0;
		        if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,consultation,billdate,locationname,patientvisitcode,doctorname,consultation_percentage,sharingamount from billing_consultation where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')

				UNION ALL

				select patientcode,patientname,fxamount as consultation,billdate,locationname,visitcode as patientvisitcode,doctorname,consultation_percentage,sharingamount from billing_paylaterconsultation where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL' and visitcode in (select visitcode from master_visitentry where department like '$department')
				order by billdate";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['consultation'];

				  $doctorname = $res1['doctorname'];

				  $doctor_share_percentage = $res1['consultation_percentage']; 

				  $doctor_amount = $res1['sharingamount'];

				  $hospital_amount = $amount - $doctor_amount;

				  $tot_doctor_amount = $tot_doctor_amount + $doctor_amount;

				  $tot_hospital_amount = $tot_hospital_amount + $hospital_amount;

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>

                   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $doctorname;  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $doctor_share_percentage; ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($doctor_amount,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($hospital_amount,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php
				}
				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,fxamount,billdate,locationname,visitcode,doctorname,consultation_percentage,sharingamount from billing_paylaterconsultation where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and visitcode in (select visitcode from master_visitentry where department like '$department')

				UNION ALL

				select patientcode,patientname,consultation as fxamount,billdate,locationname,patientvisitcode as visitcode,doctorname,consultation_percentage,sharingamount from billing_consultation where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')
				order by billdate";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['visitcode'];

				  $amount = $res1['fxamount'];

				  $doctorname = $res1['doctorname'];

				  $doctor_share_percentage = $res1['consultation_percentage']; 

				  $doctor_amount = $res1['sharingamount'];

				  $hospital_amount = $amount - $doctor_amount;

				  $tot_doctor_amount = $tot_doctor_amount + $doctor_amount;

				  $tot_hospital_amount = $tot_hospital_amount + $hospital_amount;

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $doctorname;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $doctor_share_percentage; ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($doctor_amount,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($hospital_amount,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php
				}
				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,consultation,billdate,locationname,patientvisitcode from refund_consultation where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['consultation'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				?>

				    	  

				<?php

				$query1 = "select patientcode,patientname,consultation,billdate,locationname,locationcode,patientvisitcode,fxamount from refund_paylaterconsultation where  locationname='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationcode'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['fxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}


				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,fxamount,billdate,locationname,patientvisitcode from billing_paynowpharmacy where  locationcode='$locationcode' and accountname = 'CASH - HOSPITAL' and  billdate between '$transactiondatefrom' and '$transactiondateto'  and patientvisitcode in (select visitcode from master_visitentry where department like '$department')

				UNION ALL

				select patientcode,patientname,fxamount,billdate,locationname,patientvisitcode from billing_paylaterpharmacy where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname = 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['fxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}
				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,fxamount,billdate,locationname,patientvisitcode from billing_paylaterpharmacy where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')

				UNION ALL

				select patientcode,patientname,fxamount,billdate,locationname,patientvisitcode from billing_paynowpharmacy where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['fxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,amount,billdate,locationname,patientvisitcode from billing_externalpharmacy where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['amount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,amount,billdate,locationname,patientvisitcode from refund_paylaterpharmacy where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['amount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				$query1 = "select patientcode,patientname,amount,billdate,locationname,patientvisitcode from refund_paynowpharmacy where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['amount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				

				 $query1 = "SELECT `amount` as amount, patientcode, patientname, patientvisitcode, locationname, billdate FROM `paylaterpharmareturns` WHERE locationcode='$locationcode' and billdate between  '$transactiondatefrom' and '$transactiondateto' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['amount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				    <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				    <td class="bodytext31" valign="center"  colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}
			
			$query1 = "select pharmacyfxamount as pharmacyfxamount, patientcode, patientname, entrydate, visitcode, locationname from billing_patientweivers where locationcode='$locationcode' and entrydate between '$transactiondatefrom' and '$transactiondateto'";
				
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['entrydate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['visitcode'];

				  $amount = $res1['pharmacyfxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}
				

				}
				
				if($locationcode!='All')
				{



			//this query for consultation

			$query1 = "select patientcode,patientname,fxamount,billdate,locationname,patientvisitcode from billing_paynowlab where locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['fxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,fxamount,billdate,locationname,patientvisitcode from billing_paylaterlab where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and  accountname != 'CASH - HOSPITAL' AND patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['fxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}
				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,labitemrate,billdate,locationname,patientvisitcode from billing_externallab where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['labitemrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,labitemrate,billdate,locationname,patientvisitcode from refund_paylaterlab where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['labitemrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				$query1 = "select patientcode,patientname,labitemrate,billdate,locationname,patientvisitcode from refund_paynowlab where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['labitemrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}	

				$query1 = "select labfxamount as labfxamount, patientcode, patientname, entrydate, visitcode, locationname from billing_patientweivers where locationcode='$locationcode' and entrydate between '$transactiondatefrom' and '$transactiondateto'";
				
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['entrydate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['visitcode'];

				  $amount = $res1['labfxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,fxamount,billdate,locationname,patientvisitcode from billing_paynowradiology where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['fxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}
				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,fxamount,billdate,locationname,patientvisitcode from billing_paylaterradiology where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' AND accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['fxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,radiologyitemrate,billdate,locationname,patientvisitcode from billing_externalradiology where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['radiologyitemrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}

                if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,radiologyitemrate,billdate,locationname,patientvisitcode from refund_paylaterradiology where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['radiologyitemrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				$query1 = "select patientcode,patientname,radiologyitemrate,billdate,locationname,patientvisitcode from refund_paynowradiology where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['radiologyitemrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				$query1 = "select radiologyfxamount as radiologyitemrate, patientcode, patientname, entrydate, visitcode, locationname from billing_patientweivers where locationcode='$locationcode' and entrydate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['entrydate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['visitcode'];

				  $amount = $res1['radiologyitemrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,fxamount,billdate,locationname,patientvisitcode,servicesitemname,billnumber from billing_paynowservices where  locationcode='$locationcode'  and  billdate between '$transactiondatefrom' and '$transactiondateto' and wellnessitem <> 1 and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];
				   $servicesitemname = $res1['servicesitemname'];

				  $billnumber = $res1['billnumber'];


				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['fxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
                    <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;  ?></div></td>
					
					<td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
					
                    <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"><?php echo $servicesitemname;  ?></div></td>

                  

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,servicesitemrate,billdate,locationname,patientvisitcode,fxamount,servicesitemname,billnumber from billing_paylaterservices where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];
				    $servicesitemname = $res1['servicesitemname'];

				  $billnumber = $res1['billnumber'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['fxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
                    <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;  ?></div></td>
					
					<td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
					
                    <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"><?php echo $servicesitemname;  ?></div></td>
                  

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}
				}
                
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,servicesitemrate,billdate,locationname,patientvisitcode,servicesitemname,billnumber from billing_externalservices where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];
				   $servicesitemname = $res1['servicesitemname'];

				  $billnumber = $res1['billnumber'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['servicesitemrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
                    <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"><?php echo $servicesitemname;  ?></div></td>
                  

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,servicesitemrate,billdate,locationname,patientvisitcode,servicesitemname,billnumber from refund_paylaterservices where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];
				   $servicesitemname = $res1['servicesitemname'];

				  $billnumber = $res1['billnumber'];


				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['servicesitemrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
                    <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"><?php echo $servicesitemname;  ?></div></td>
                  

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				$query1 = "select patientcode,patientname,servicesitemrate,billdate,locationname,patientvisitcode,servicesitemname,billnumber from refund_paynowservices where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $servicesitemname = $res1['servicesitemname'];

				  $billnumber = $res1['billnumber'];


				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['servicesitemrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}	

				
				$query1 = "select servicesfxamount as servicesfxamount, patientcode, patientname, entrydate, visitcode, locationname from billing_patientweivers where locationcode='$locationcode' and entrydate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['entrydate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['visitcode'];

				  $amount = $res1['servicesfxamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>
				  
				  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
                  <td class="bodytext31" valign="center"  colspan="3" align="right"><div class="bodytext31"><strong><?php  ?></strong></div></td>
                  

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}
				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,referalrate,billdate,locationname,patientvisitcode,cashamount from billing_paynowreferal where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['cashamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,referalrate,billdate,locationname,patientvisitcode from billing_paylaterreferal where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['referalrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				//noo external refferal
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,referalrate,billdate,locationname,patientvisitcode from refund_paylaterreferal where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto' and patientvisitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['referalrate'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				$query1 = "select patientcode,patientname,referalrate,billdate,locationname,patientvisitcode from refund_paynowreferal where  locationcode='$locationcode' and  billdate between '$transactiondatefrom' and '$transactiondateto'";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['cashamount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format('-'.$amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,amount,recorddate,locationname,visitcode from billing_opambulance where  locationcode='$locationcode' and  recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['recorddate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['visitcode'];

				  $amount = $res1['amount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,amount,recorddate,locationname,visitcode from billing_opambulancepaylater where  locationcode='$locationcode' and  recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['recorddate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['visitcode'];

				  $amount = $res1['amount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,amount,recorddate,locationname,visitcode from billing_homecare where  locationcode='$locationcode' and  recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['amount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center"  colspan="3" align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

               </tr>

			    <?php

				}

				}
				
				if($locationcode!='All')
				{

			//this query for consultation

			$query1 = "select patientcode,patientname,amount,recorddate,locationname,visitcode from billing_homecarepaylater where  locationcode='$locationcode' and  recorddate between '$transactiondatefrom' and '$transactiondateto' and visitcode in (select visitcode from master_visitentry where department like '$department')";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res1 = mysqli_fetch_array($exec1)){

				  $patientcode = $res1['patientcode'];

				  $patientname = $res1['patientname'];

				  $billdate = $res1['billdate'];

				  $locationname = $res1['locationname'];

				  $patientvisitcode = $res1['patientvisitcode'];

				  $amount = $res1['amount'];

				  $tot_amount=$tot_amount+$amount ;

			

			$snocount = $snocount + 1;

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

                <tr <?php echo $colorcode; ?>>

              	  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $snocount; ?></div></td>	

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billdate;  ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>

                  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;  ?></div></td>
				  
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  
				  <td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo $locationname; ?></div></td>

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
			 
			
			
			
			
			