<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="DepartmentSalesREPORT.xls"');
header('Cache-Control: max-age=80');


session_start();
include ("includes/loginverify.php");
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

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$total = '0.00';
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$grandtotal = 0;

$res10username="";
$res5labusername="";

//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
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

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["department"])) { $search_department = $_REQUEST["department"]; } else { $search_department = ""; }

if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }

if (isset($_REQUEST["reporttype"])) { $reporttype = $_REQUEST["reporttype"]; } else { $reporttype = ""; }

if($locationcode1=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$locationcode1'";
}


//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;

if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}
$table_width ="1546";
$colspan="19";
if($reporttype=="summary"){
	$table_width="900";
	$colspan="9";
}
?>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="<?php echo $table_width; ?>" 
            align="left" border="1">
          <tbody>
          	<tr> <td colspan="<?php echo $colspan; ?>" align="center"><strong><u><h3>Department Sales Report</h3></u></strong></td></tr>
          	<!-- <tr ><td colspan="19" align="center"><strong>Department : <?php //if($search_department=='') { //echo 'All'; }else{ echo $search_department; } ?></strong></td></tr> -->
          
        <tr ><td colspan="<?php echo $colspan; ?>" align="center"><strong>Date From:    <?php echo $ADate1 ?>   To:  <?php echo $ADate2 ?></strong></td></tr>
        <tbody>
        	  <?php if($reporttype=="detailed"){ ?>
 			<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>No.</strong></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong> Bill No </strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong> Bill Date </strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Reg No. </strong></div></td>
				 <td width="8%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Member No. </strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Accountname</strong></div></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Subtype</strong></div></td>
               <!--  <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department</strong></div></td> -->

              <td width="7%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Department</strong></div></td> 
				<td width="15%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Payment Type</strong></div></td>

              <!-- <td width="12%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Plan Name </strong></div></td> -->

                 <td width="6%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Consultation</strong></div></td>

              <td width="3%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Service</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Radiology</strong></div></td>
             
              <td width="5%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Referral</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>Total</strong></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong>Username</strong></td>
            </tr>
             <?php } ?>

                   <?php if($reporttype=="summary"){ ?>
            <tr>

              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
             
				<td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department</strong></div></td>
				
                <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Consultation</strong></div></td>

              <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Service</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Radiology</strong></div></td>
              
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Referral</strong></div></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
              
            </tr>
        <?php } ?>
			<?php
			$totallab = $totalser = $totalpharm = $totalrad = $totalref = $totalcons = 0;
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				
				
			// $query21 = "select * from billing_paylater where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname order by accountname desc  ";
			// $query21 = "SELECT accountname, billdate,billno from billing_paylater where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' UNION ALL SELECT accountname, billdate,billno from billing_paynow where locationcode='$locationcode1' and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2'  order by billdate ";
			// $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			// while ($res21 = mysql_fetch_array($exec21))
			// {
			// $res21accountname = $res21['accountname'];
			//  $res21billno = $res21['billno'];
			
			// $query22 = "select * from master_accountname where locationcode='$locationcode1' and accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			// $exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			// $res22 = mysql_fetch_array($exec22);
			// $res22accountname = $res22['accountname'];

			// if( $res21accountname != '')
			// {
			?>
			<!-- <tr bgcolor="#ecf0f5">
            <td colspan="17"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res21accountname;?></strong></td> -->
            <!-- </tr> -->
			
			<?php
			
			// $dotarray = explode("-", $paymentreceiveddateto);
			// $dotyear = $dotarray[0];
			// $dotmonth = $dotarray[1];
			// $dotday = $dotarray[2];
			// $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
		  // $query1 = "select * from master_accountname where locationcode='$locationcode1' and accountname = '$searchsuppliername'";
		  // $exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
		  // $res1 = mysql_fetch_array($exec1);
		  // $res1auto_number = $res1['auto_number'];
		  // $res1accountname = $res1['accountname'];
			
		  // $query2 = "select * from billing_paylater where locationcode='$locationcode1' and accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' order by accountname desc ";
			 if($reporttype=="detailed")
			 {
		  $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname from billing_paylater where $pass_location and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname from billing_paynow where $pass_location  and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode, patientvisitcode as visitcode, billnumber as billno,billdate,patientname from billing_consultation where $pass_location  and billdate between '$ADate1' and '$ADate2' order by billdate"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
     	  // $res2accountcode = $res2['accountnameid'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  // $subtype = $res2['subtype'];
		  //echo $res2paymenttype = $res2['paymenttype'];
		  $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res11 = mysqli_fetch_array($exec11);
					$aut_department=$res11['department'];
						if(($aut_department==$search_department && $search_department!="") || ($search_department=="" && $aut_department!=""))
						// if($aut_department==$search_department || $search_department=='')
							{

			

		  $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
					$subtype_num=$res11['subtype'];
		  // $subtype = $res2['subtype'];
				$query112 = "SELECT * from master_subtype where auto_number='$subtype_num'";
				$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res112 = mysqli_fetch_array($exec112);
				$subtype = $res112['subtype'];
		  $res5labitemrate1 = '0.00';
		  $res6servicesitemrate1 = '0.00';
		  $res7pharmacyitemrate1 = '0.00';
		  $res8radiologyitemrate1 = '0.00';
		  $res9referalitemrate1 = '0.00';
		  $res10consultationitemrate1 = '0.00';

		  
		  $query12 = "SELECT username from master_transactionpaylater where $pass_location and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billnumber='$res2billno' and transactiontype='finalize' union all SELECT username from billing_paynow where $pass_location and billno = '$res2billno' union all SELECT  username from billing_consultation where $pass_location and billnumber = '$res2billno'";
        
		   $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res12 = mysqli_fetch_array($exec12);
		  $res12username = $res12['username'];
		 
		  
		 $query3 = "select * from master_visitentry where $pass_location and visitcode = '$res2visitcode'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3planname = $res3['planname'];
		  $res10paymenttype = $res3['paymenttype'];
		  $memberno = $res3['memberno'];
		  
		  $query11 = "select * from master_paymenttype where auto_number = '$res10paymenttype'";
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  $res11paymenttype = $res11['paymenttype'];
		  
		  $query4 = "select * from master_planname where auto_number = '$res3planname'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4planname = $res4['planname'];

		  // $query50 = "select accountname, misreport from master_accountname where id = '$res2accountcode'";
		  // $exec50 = mysql_query($query50) or die ("Error in Query50".mysql_error());
		  // $res50 = mysql_fetch_array($exec50);
		  // $res50accountname = $res50['accountname'];
		  // $misid = $res50['misreport'];

		  // $query51 = "select type from mis_types where auto_number = '$misid'";
		  // $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
		  // $res51 = mysql_fetch_array($exec51);
		  // $mistype = $res51['type'];
		  
		  // $query5 = "select * from billing_paylaterlab where $pass_location and billnumber = '$res2billno'";
		  $query5 = "SELECT labitemrate, username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT labitemrate, username from billing_paynowlab where $pass_location and billnumber = '$res2billno'";

		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res5 = mysqli_fetch_array($exec5))
		  {
		  	$res5labusername = $res5['username'];
		  $res5labitemrate = $res5['labitemrate'];
		  $res5labitemrate1 = $res5labitemrate1 + $res5labitemrate;
		  }
		  $res5labitemrate1 = number_format($res5labitemrate1,'2','.','');


		  // $res51labusername="";
		  // $query51 = "SELECT username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_paynowlab where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_consultation where $pass_location and billnumber = '$res2billno'  ";
		  // $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
		  // while ($res51 = mysql_fetch_array($exec51))
		  // {
		  // 	$res51labusername = $res51['username'];
		  // }
		  
		  // $query6 = "select * from billing_paylaterservices where $pass_location and wellnessitem <> 1 and billnumber = '$res2billno'";
		  $query6 = "SELECT amount from billing_paylaterservices where $pass_location  and billnumber = '$res2billno' union all SELECT amount from billing_paynowservices where $pass_location  and billnumber = '$res2billno'";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res6 = mysqli_fetch_array($exec6))
		  {
		  $res6servicesitemrate = $res6['amount'];
		  $res6servicesitemrate1 = $res6servicesitemrate1 + $res6servicesitemrate;
		  }
		  $res6servicesitemrate1 = number_format($res6servicesitemrate1,'2','.','');
		  
		  // $query7 = "select * from billing_paylaterpharmacy where $pass_location and billnumber = '$res2billno'";
		  $query7 = "SELECT amount from billing_paylaterpharmacy where $pass_location and billnumber = '$res2billno' union all SELECT amount from billing_paynowpharmacy where $pass_location and billnumber = '$res2billno'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res7 = mysqli_fetch_array($exec7))
		  {
		  $res7pharmacyitemrate = $res7['amount'];
		  $res7pharmacyitemrate1 = $res7pharmacyitemrate1 + $res7pharmacyitemrate;
		  }
		  $res7pharmacyitemrate1 = number_format($res7pharmacyitemrate1,'2','.','');
		  
		  // $query8 = "select * from billing_paylaterradiology where $pass_location and billnumber = '$res2billno'";
		  $query8 = "SELECT radiologyitemrate from billing_paylaterradiology where $pass_location and billnumber = '$res2billno' union all SELECT radiologyitemrate from billing_paynowradiology where $pass_location and billnumber = '$res2billno' ";
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res8 = mysqli_fetch_array($exec8))
		  {
		  $res8radiologyitemrate = $res8['radiologyitemrate'];
		  $res8radiologyitemrate1 = $res8radiologyitemrate1 + $res8radiologyitemrate;
		  }
		  $res8radiologyitemrate1 = number_format($res8radiologyitemrate1,'2','.','');
		  
		  // $query9 = "select * from billing_paylaterreferal where $pass_location and billnumber = '$res2billno'";
		   $query9 = "SELECT referalrate from billing_paylaterreferal where $pass_location and billnumber = '$res2billno' union all SELECT referalrate from billing_paynowreferal where $pass_location and billnumber = '$res2billno'";
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res9 = mysqli_fetch_array($exec9))
		  {
		  $res9referalitemrate = $res9['referalrate'];
		  $res9referalitemrate1 = $res9referalitemrate1 + $res9referalitemrate;
		  }
		  $res9referalitemrate1 = number_format($res9referalitemrate1,'2','.','');
		  
		  // $query10 = "select * from billing_paylaterconsultation where $pass_location and billno = '$res2billno'";
		   $query10 = "SELECT totalamount as totalamount from billing_paylaterconsultation where $pass_location and billno = '$res2billno' union all SELECT  consultation as totalamount from billing_consultation where $pass_location and billnumber = '$res2billno'  ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res10 = mysqli_fetch_array($exec10))
		  {
		  	// $res10username = $res10['username'];
		  $res10consultationitemrate = $res10['totalamount'];
		  $res10consultationitemrate1 = $res10consultationitemrate1 + $res10consultationitemrate;
		  }
		  $res10consultationitemrate1 = number_format($res10consultationitemrate1,'2','.','');
		 
		  $total = $res5labitemrate1 + $res6servicesitemrate1 + $res7pharmacyitemrate1 + $res8radiologyitemrate1 + $res9referalitemrate1 + $res10consultationitemrate1;

		  $totallab += $res5labitemrate1;
		  $totalser += $res6servicesitemrate1;
		  $totalpharm += $res7pharmacyitemrate1;
		  $totalrad += $res8radiologyitemrate1;
		  $totalref += $res9referalitemrate1;
		  $totalcons += $res10consultationitemrate1;


		  $total = number_format($total,'2','.','');
		  $grandtotal = $grandtotal + $total;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#ffffff"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ffffff"';
			}
	
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $memberno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $subtype; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    // echo $mistype;

			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				// if (mysql_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>

				<!-- <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php //echo $mistype; ?></div></td>-->
			    				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
            <!--   <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php //echo $res4planname; ?></div></td> -->

			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res10consultationitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5labitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6servicesitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res7pharmacyitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res8radiologyitemrate1,2,'.',','); ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res9referalitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo number_format($total,2,'.',','); ?></td>
               <!-- <td class="bodytext31" valign="center"  align="left"><?php //if($res5labusername!=""){//echo strtoupper($res5labusername); }else{ echo strtoupper($res10username);} ?></td> -->
              <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res12username); ?></td>
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
			<?php }
			$res21accountname ='';
			
			// }
			
			}
			$res22accountname ='';
		}
	        
			
			// }
			
			?>
			 <?php if($reporttype=="detailed"){ ?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <!-- <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td> -->
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><!--Total--></strong></div></td>

                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalcons,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totallab,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalser,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalpharm,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalrad,2); ?></strong></div></td>
              
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalref,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></td>
			  <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			  <?php if($grandtotal != 0.00) 
			      {
			   ?>
            <?php } ?>


			</tr>
			 <?php } ?>

			   <?php


              if($reporttype=="summary")
              {
              

			  // $query21 = "SELECT accountname, billdate,billno from billing_paylater where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' UNION ALL SELECT accountname, billdate,billno from billing_paynow where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2'  order by billdate ";
			  // union all SELECT accountname,billdate,  billnumber as billno from billing_consultation where $pass_location  and billdate between '$ADate1' and '$ADate2'
			// $query21 = "select accountname,billno,billdate from billing_paylater where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname order by accountname desc  ";
			// $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			// while ($res21 = mysql_fetch_array($exec21))
			// {
			//  $res21accountname = $res21['accountname'];
			//  $res21billno = $res21['billno'];
			
			// $query22 = "select * from master_accountname where $pass_location and accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			// // $query22 = "select * from master_accountname where $pass_location and accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			// $exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			// $res22 = mysql_fetch_array($exec22);
			// $res22accountname = $res22['accountname'];

			// if( $res21accountname != '')
			// {
			// ?>
			 <!-- <tr bgcolor="#ecf0f5">
   //          <td colspan="20"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res21accountname;?></strong></td>
   //          </tr> -->
			
			 <?php


			$consgrand =0;
			// $dotarray = explode("-", $paymentreceiveddateto);
			// $dotyear = $dotarray[0];
			// $dotmonth = $dotarray[1];
			// $dotday = $dotarray[2];
			// $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
		 //  $query1 = "select * from master_accountname where $pass_location and accountname = '$searchsuppliername'";
		 //  $exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
		 //  $res1 = mysql_fetch_array($exec1);
		 //  $res1auto_number = $res1['auto_number'];
		 //  $res1accountname = $res1['accountname'];
			///FOR GROUPING USE THIS QUERYY2
		   // $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paylater where $pass_location and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paynow where $pass_location  and billdate between '$ADate1' and '$ADate2'   union all SELECT accountname,patientcode, patientvisitcode as visitcode,billnumber as billno,billdate,patientname, from billing_consultation where $pass_location  and billdate between '$ADate1' and '$ADate2'
		    // order by billdate";
		     $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname from billing_paylater where $pass_location and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname from billing_paynow where $pass_location  and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode, patientvisitcode as visitcode, billnumber as billno,billdate,patientname from billing_consultation where $pass_location  and billdate between '$ADate1' and '$ADate2' order by billdate";
		     
		  // echo $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paylater where $pass_location and accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname,subtype from billing_paynow where $pass_location and accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' order by billdate"; 
		  ////////////////
		  // $query2 = "select * from billing_paylater where $pass_location  and billdate between '$ADate1' and '$ADate2' order by accountname desc "; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  // $accountid = $res2['accountnameid'];

		$query11 = "SELECT department from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						
						// echo $search_department.'c';
						// if($aut_department==$search_department )
				if(($aut_department==$search_department && $search_department!="") || ($search_department=="" && $aut_department!=""))
						{
						// 	echo $aut_department."a=";
						// echo $search_department."b-----";
		 
		  // $subtype = $res2['subtype'];
				
		  //echo $res2paymenttype = $res2['paymenttype'];
		  $res5labitemrate1 = '0.00';
		  $res6servicesitemrate1 = '0.00';
		  $res7pharmacyitemrate1 = '0.00';
		  $res8radiologyitemrate1 = '0.00';
		  $res9referalitemrate1 = '0.00';
		  $res10consultationitemrate1 = '0.00';
		  
		  
		  
		
		  
		

		  // $query50 = "select accountname, misreport from master_accountname where id = '$accountid'";
		  // $exec50 = mysql_query($query50) or die ("Error in Query50".mysql_error());
		  // $res50 = mysql_fetch_array($exec50);
		  // $res50accountname = $res50['accountname'];
		  // $misid = $res50['misreport'];

		  // $query51 = "select type from mis_types where auto_number = '$misid'";
		  // $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
		  // $res51 = mysql_fetch_array($exec51);
		  // $mistype = $res51['type'];
		  
		  $query5 = "SELECT labitemrate, username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT labitemrate, username from billing_paynowlab where $pass_location and billnumber = '$res2billno'";
		  // $query5 = "SELECT sum(labitemrate) as labitemrate, username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT sum(labitemrate) as labitemrate, username from billing_paynowlab where $pass_location and billnumber = '$res2billno'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res5 = mysqli_fetch_array($exec5))
		  {

		  // $res5labusername = $res5['username'];
		  $res5labitemrate = $res5['labitemrate'];
		  $res5labitemrate1 = $res5labitemrate1 + $res5labitemrate;
		  }
		  $res5labitemrate1 = number_format($res5labitemrate1,'2','.','');


		  // $res51labusername="";

		  // $query51 = "SELECT username from billing_paylaterlab where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_paylaterpharmacy where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_paylaterradiology where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_paylaterservices where $pass_location and billnumber = '$res2billno'
		  //  union all SELECT  username from billing_paynowlab where $pass_location and billnumber = '$res2billno' union all SELECT  username from billing_consultation where $pass_location and billnumber = '$res2billno'  ";
		  // $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
		  // while ($res51 = mysql_fetch_array($exec51))
		  // {
		  // 	$res51labusername = $res51['username'];
		  // }

		  
		  $query6 = "SELECT  amount from billing_paylaterservices where $pass_location and billnumber = '$res2billno' union all SELECT  amount from billing_paynowservices where $pass_location  and billnumber = '$res2billno'";
		  // $query6 = "SELECT sum(amount) as amount from billing_paylaterservices where $pass_location and wellnessitem <> 1 and billnumber = '$res2billno' union all SELECT sum(amount) as amount from billing_paynowservices where $pass_location and wellnessitem <> 1 and billnumber = '$res2billno'";

		  
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res6 = mysqli_fetch_array($exec6))
		  {
		  $res6servicesitemrate = $res6['amount'];
		  $res6servicesitemrate1 = $res6servicesitemrate1 + $res6servicesitemrate;
		  }
		  $res6servicesitemrate1 = number_format($res6servicesitemrate1,'2','.','');
		  
		  $query7 = "SELECT amount from billing_paylaterpharmacy where $pass_location and billnumber = '$res2billno' union all SELECT amount from billing_paynowpharmacy where $pass_location and billnumber = '$res2billno'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res7 = mysqli_fetch_array($exec7))
		  {
		  $res7pharmacyitemrate = $res7['amount'];
		  $res7pharmacyitemrate1 = $res7pharmacyitemrate1 + $res7pharmacyitemrate;
		  }
		  $res7pharmacyitemrate1 = number_format($res7pharmacyitemrate1,'2','.','');
		  
		  $query8 = "SELECT radiologyitemrate  from billing_paylaterradiology where $pass_location and billnumber = '$res2billno' union all SELECT radiologyitemrate from billing_paynowradiology where $pass_location and billnumber = '$res2billno' ";
		  

		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res8 = mysqli_fetch_array($exec8))
		  {
		  $res8radiologyitemrate = $res8['radiologyitemrate'];
		  $res8radiologyitemrate1 = $res8radiologyitemrate1 + $res8radiologyitemrate;
		  }
		  $res8radiologyitemrate1 = number_format($res8radiologyitemrate1,'2','.','');
		  
		  $query9 = "SELECT referalrate from billing_paylaterreferal where $pass_location and billnumber = '$res2billno' union all SELECT referalrate from billing_paynowreferal where $pass_location and billnumber = '$res2billno'";

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res9 = mysqli_fetch_array($exec9))
		  {
		  $res9referalitemrate = $res9['referalrate'];
		  $res9referalitemrate1 = $res9referalitemrate1 + $res9referalitemrate;
		  }
		  $res9referalitemrate1 = number_format($res9referalitemrate1,'2','.','');
		  
		  $query10 = "SELECT totalamount as totalamount from billing_paylaterconsultation where $pass_location and billno = '$res2billno' union all SELECT  consultation as totalamount from billing_consultation where $pass_location and billnumber = '$res2billno'  ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res10 = mysqli_fetch_array($exec10))
		  {

		  // $res10username = $res10['username'];
		  $res10consultationitemrate = $res10['totalamount'];
		  $res10consultationitemrate1 = $res10consultationitemrate1 + $res10consultationitemrate;
		  }
		  $res10consultationitemrate1 = number_format($res10consultationitemrate1,'2','.','');
		 
		  $total = $res5labitemrate1 + $res6servicesitemrate1 + $res7pharmacyitemrate1 + $res8radiologyitemrate1 + $res9referalitemrate1 + $res10consultationitemrate1;

		  $totallab += $res5labitemrate1;
		  $totalser += $res6servicesitemrate1;
		  $totalpharm += $res7pharmacyitemrate1;
		  $totalrad += $res8radiologyitemrate1;
		  $totalref += $res9referalitemrate1;
		  $totalcons += $res10consultationitemrate1;

		  


		  $total = number_format($total,'2','.','');
		  $grandtotal = $grandtotal + $total;
		  
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
        
			<?php 

		

				$cons[$aut_department][] = $res10consultationitemrate1;
				$lab[$aut_department][] = $res5labitemrate1;

				$ser[$aut_department][] = $res6servicesitemrate1;
				$pharm[$aut_department][] = $res7pharmacyitemrate1;
				$rad[$aut_department][] = $res8radiologyitemrate1;
				$ref[$aut_department][] = $res9referalitemrate1;



			}
			$res21accountname ='';
			
			// }
			
			}

			$conamtt = 0;
			
			foreach ($cons as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$conamtt = $conamtt + $v;
				}
				
				$consultation[$key] = $conamtt;
				$conamtt = 0;
			}
			$labamtt = 0;
			foreach ($lab as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$labamtt = $labamtt + $v;
				}
				
				$labarotory[$key] = $labamtt;
				$labamtt = 0;
			}
			$seramtt = 0;
			foreach ($ser as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$seramtt = $seramtt + $v;
				}
			
				$service[$key] = $seramtt;
				$seramtt = 0;
			}
			$pharmamtt = 0;
			foreach ($pharm as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$pharmamtt = $pharmamtt + $v;
				}
				
				$pharmacy[$key] = $pharmamtt;
				$pharmamtt = 0;
			}
			$radamtt = 0;
			foreach ($rad as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$radamtt = $radamtt + $v;
				}
				
				$radiology[$key] = $radamtt;
				$radamtt = 0;
			}

			$refamtt = 0;
			foreach ($ref as $key => $value) {
				
				foreach ($value as $k => $v) {
					
					$refamtt = $refamtt + $v;
				}
				
				$referral[$key] = $refamtt;
				$refamtt = 0;
			}
			
		
			$res22accountname ='';
			
			$snocount = 0;

			foreach ($consultation as $key => $consultamt) 

			{ 

				$snocount = $snocount +1;


				$deptid = $key;

				//echo $deptid.'--'.$consamt_arr[$deptid].'<br>';

				  $query5 = "select department from master_department where auto_number = '$deptid'";

		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res5 = mysqli_fetch_array($exec5);

		  $res5deparmentname = $res5['department'];

		

		  $finallinetot = $consultamt + $labarotory[$deptid] + $service[$deptid] + $pharmacy[$deptid] +$radiology[$deptid]+$referral[$deptid];
		  $consgrand = $consgrand + $consultamt ; 

		 

				?>
 
				 <tr >

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res5deparmentname; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($consultamt,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($labarotory[$deptid],2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($service[$deptid],2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($pharmacy[$deptid],2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($radiology[$deptid],2,'.',','); ?></div></td>

                 <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($referral[$deptid],2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($finallinetot,2,'.',','); ?></div></td>

             	

           </tr> 
			<?php }
			?>


			

            <tr>
             
				
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><!--Total--></strong></div></td>

                  <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><!--Total--></strong></div></td>

                  <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totalcons,2); ?></strong></div></td>


              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totallab,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totalser,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totalpharm,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totalrad,2); ?></strong></div></td>

            

              <td class="bodytext31" valign="center"  align="left" 
                ><div align="right"><strong><?php echo number_format($totalref,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="right" 
                ><strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></td>
			  
			 

       
            
			</tr>

			  <?php }

			}
                ?>
          </tbody>
        </table>