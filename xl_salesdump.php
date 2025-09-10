<?php
header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename="Sales_dump_.xls"');
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
$refund_total = '0.00';
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$grandtotal = 0;
$refund_gtotal = 0;
$after_refund = 0;

$total_neg="0.00";
		  $total_final="0.00";
		  $total_postive="0.00";
		  $total_final="0.00";



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
//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;

header('Content-Disposition: attachment;filename="Sales_dump_"'.$ADate1.'"_To_"'.$ADate2.'".xls"');

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

?>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1546" 
            align="left" border="1">
          <tbody>
          	<tr> <td colspan="19" align="center"><strong><u><h3>Sales Dump REPORT</h3></u></strong></td></tr>
          	<!-- <tr ><td colspan="19" align="center"><strong>Department : <?php //if($search_department=='') { //echo 'All'; }else{ echo $search_department; } ?></strong></td></tr> -->
          
        <tr ><td colspan="19" align="center"><strong>Date From:    <?php echo $ADate1 ?>   To:  <?php echo $ADate2 ?></strong></td></tr>
        <tbody>
 			<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No. </strong></div></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill Date </strong></td>
                <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill Discription </strong></td>
				 <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member No. </strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
				<td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Accountname</strong></div></td>
				<td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Subtype</strong></div></td>
				<td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department</strong></div></td>
				<td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Payment Type</strong></div></td>
              <!-- <td width="12%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Plan Name </strong></div></td> -->

                <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Item Code</strong></div></td>

              <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Item Name</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Category</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Qty</strong></div></td>
              
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
            </tr>
			<?php
			$totallab = $totalser = $totalpharm = $totalrad = $totalref = $totalcons = 0;
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				
				
			
			?>
			
			
			<?php
			
			
		   $query2 = "SELECT accountname,patientcode,visitcode,billno,billdate,patientname from billing_paylater where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname from billing_paynow where locationcode='$locationcode1'  and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode, patientvisitcode as visitcode, billnumber as billno,billdate,patientname from billing_consultation where locationcode='$locationcode1'  and billdate between '$ADate1' and '$ADate2'  union all SELECT accountname,patientcode,visitcode,billno,billdate,patientname from refund_paylater where locationcode='$locationcode1'  and billdate between '$ADate1' and '$ADate2' union all SELECT accountname,patientcode,visitcode, billnumber as billno, transactiondate as billdate, patientname from refund_paynow where locationcode='$locationcode1' and transactiondate between '$ADate1' and '$ADate2' union all SELECT accountname, patientcode, visitcode, billno, billdate, patientname from billing_ip where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2' union all SELECT accountname, patientcode, visitcode, billno, billdate, patientname from billing_ipcreditapproved where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'  order by billdate"; 

		    // $query2 = "SELECT accountname, patientcode, visitcode, billno, billdate, patientname from billing_ip where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'   order by billdate";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
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
						$subtype_num=$res11['subtype'];
		  // $subtype = $res2['subtype'];
				$query112 = "SELECT * from master_subtype where auto_number='$subtype_num'";
				$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res112 = mysqli_fetch_array($exec112);
				$subtype = $res112['subtype'];




		  //echo $res2paymenttype = $res2['paymenttype'];
		  $res5labitemrate1 = '0.00';
		  $res6servicesitemrate1 = '0.00';
		  $res7pharmacyitemrate1 = '0.00';
		  $res8radiologyitemrate1 = '0.00';
		  $res9referalitemrate1 = '0.00';
		  $res10consultationitemrate1 = '0.00';
		  $resr1consultationrate1 = '0.00';
		  $resr2rate1 = '0.00';
		  $resr3rate1 = '0.00';
		  $resr4rate1 = '0.00';
		  $resr5rate1 = '0.00';
		  $resr6rate1 = '0.00';
		  $resr7rate1 = '0.00';

		  $resr7ratec = '0.00';
		  $resr7ratep = '0.00';
		  $resr7ratel = '0.00';
		  $resr7rater = '0.00';
		  $resr7rates = '0.00';

		  
		  $query12 = "select * from master_transactionpaylater where locationcode='$locationcode1' and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billnumber='$res2billno' and transactiontype='finalize'  ";
          $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res12 = mysqli_fetch_array($exec12);
		  $res12username = $res12['username'];
		  
		 $query3 = "select * from master_visitentry where locationcode='$locationcode1' and visitcode = '$res2visitcode'";
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
		  
		  // $query5 = "select * from billing_paylaterlab where locationcode='$locationcode1' and billnumber = '$res2billno'";
		 $query10 = "SELECT totalamount as totalamount from billing_paylaterconsultation where locationcode='$locationcode1' and billno = '$res2billno' union all SELECT  consultation as totalamount from billing_consultation where locationcode='$locationcode1' and billnumber = '$res2billno'  ";
		  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res10 = mysqli_fetch_array($exec10))
		  {

		  	$res10c='consultation';
		  // $res10 = $res5['labitemrate'];
		  // $res10 = $res5['labitemname'];
		  // $res10 = $res5['labitemcode'];
		  $res10consultationitemrate = $res10['totalamount'];
		  $res10consultationitemrate1 = $res10consultationitemrate1 + $res10consultationitemrate; 

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
			}?>

		  <tr <?php echo $colorcode; ?>>
		  	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res10c; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>


				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res10c; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res10consultationitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res10consultationitemrate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php }
		  // Item Code Item Nam Category Rate Qty Amount
		  $query5 = "SELECT labitemrate,labitemcode,labitemname, username from billing_paylaterlab where locationcode='$locationcode1' and billnumber = '$res2billno' union all SELECT labitemrate,labitemcode,labitemname,username from billing_paynowlab where locationcode='$locationcode1' and billnumber = '$res2billno'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res5 = mysqli_fetch_array($exec5))
		  {
		   
		  	$res5labbilldescription='Laboratory';
		  $res5labitemrate = $res5['labitemrate'];
		  $res5labitemname = $res5['labitemname'];
		  $res5labitemcode = $res5['labitemcode'];
		  // $res5labitemamount = $res5['fxamount'];
		  $res5labitemrate1 = $res5labitemrate1 + $res5labitemrate; 
		  $res5labitemrate1 = number_format($res5labitemrate1,'2','.','');

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
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res5labbilldescription; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>


				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res5labitemcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res5labitemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res5labbilldescription; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5labitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5labitemrate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php }
		  

		$query6 = "SELECT servicesitemcode,servicesitemname,servicesitemrate,serviceqty,amount from billing_paylaterservices where locationcode='$locationcode1' and wellnessitem <> 1 and billnumber = '$res2billno' union all SELECT servicesitemcode,servicesitemname,servicesitemrate,serviceqty,amount from billing_paynowservices where locationcode='$locationcode1' and wellnessitem <> 1 and billnumber = '$res2billno'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res6 = mysqli_fetch_array($exec6))
		  {
		  $res6servicesitemcode = $res6['servicesitemcode'];
		  $res6servicesitemname = $res6['servicesitemname'];
		  $res6servicesitemcat = 'Services';
		  $res6servicesitemratefixed = $res6['servicesitemrate'];
		  $res6servicesitemqty = $res6['serviceqty'];
		  $res6servicesitemrate = $res6['amount'];
		  $res6servicesitemrate1 = $res6servicesitemrate1 + $res6servicesitemrate;
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
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res6servicesitemcat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res6servicesitemcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res6servicesitemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res6servicesitemcat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6servicesitemratefixed,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res6servicesitemqty; ?></div></td>

              

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6servicesitemrate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php }

		  $res6servicesitemrate1 = number_format($res6servicesitemrate1,'2','.','');
		  
		  $query7 = "SELECT medicinecode,medicinename,quantity,rate, amount from billing_paylaterpharmacy where locationcode='$locationcode1' and billnumber = '$res2billno' union all SELECT medicinecode,medicinename,quantity,rate, amount from billing_paynowpharmacy where locationcode='$locationcode1' and billnumber = '$res2billno'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res7 = mysqli_fetch_array($exec7))
		  {
		  	
		  $res7pharmacycode = $res7['medicinecode'];
		  $res7pharmacyname = $res7['medicinename'];
		  $res7pharmacycat = 'Pharmacy';
		  $res7pharmacyqty = $res7['quantity'];
		  $res7pharmacyrate = $res7['rate'];
		  $res7pharmacyitemrate = $res7['amount'];
		  $res7pharmacyitemrate1 = $res7pharmacyitemrate1 + $res7pharmacyitemrate;
		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res7pharmacycat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res7pharmacycode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res7pharmacyname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res7pharmacycat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res7pharmacyrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res7pharmacyqty; ?></div></td>

              

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res7pharmacyitemrate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  $res7pharmacyitemrate1 = number_format($res7pharmacyitemrate1,'2','.','');
		  
		  $query8 = "SELECT radiologyitemcode,radiologyitemname,radiologyitemrate from billing_paylaterradiology where locationcode='$locationcode1' and billnumber = '$res2billno' union all SELECT radiologyitemcode,radiologyitemname,radiologyitemrate from billing_paynowradiology where locationcode='$locationcode1' and billnumber = '$res2billno' ";
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res8 = mysqli_fetch_array($exec8))
		  {
		  	// Item Code Item Nam Category Rate Qty Amount
		  $res8radiologycode = $res8['radiologyitemcode'];
		  $res8radiologyname = $res8['radiologyitemname'];
		  $res8radiologycat = 'Radiology';
		  $res8radiologyitemrate = $res8['radiologyitemrate'];
		  $res8radiologyitemrate1 = $res8radiologyitemrate1 + $res8radiologyitemrate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res8radiologycat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res8radiologycode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res8radiologyname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res8radiologycat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res8radiologyitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res8radiologyitemrate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  $res8radiologyitemrate1 = number_format($res8radiologyitemrate1,'2','.','');
		  
		  $query9 = "SELECT referalcode,referalname,referalrate from billing_paylaterreferal where locationcode='$locationcode1' and billnumber = '$res2billno' union all SELECT  referalcode,referalname,referalrate from billing_paynowreferal where locationcode='$locationcode1' and billnumber = '$res2billno'";

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res9 = mysqli_fetch_array($exec9))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $res9referalcode = $res9['referalcode'];
		  $res9referalname = $res9['referalname'];
		  $res9referalcat='Referal';
		  $res9referalitemrate = $res9['referalrate'];
		  $res9referalitemrate1 = $res9referalitemrate1 + $res9referalitemrate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res9referalcat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];


			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res9referalcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res9referalname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $res9referalcat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res9referalitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res9referalitemrate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $res9referalitemrate1 = number_format($res9referalitemrate1,'2','.','');
		  
		  // $query10 = "SELECT totalamount as totalamount from billing_paylaterconsultation where locationcode='$locationcode1' and billno = '$res2billno' union all SELECT  consultation as totalamount from billing_consultation where locationcode='$locationcode1' and billnumber = '$res2billno'  ";
		  // $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		  // while ($res10 = mysql_fetch_array($exec10))
		  // {

		  // // $res10username = $res10['username'];
		  // $res10consultationitemrate = $res10['totalamount'];
		  // $res10consultationitemrate1 = $res10consultationitemrate1 + $res10consultationitemrate;
		  // }
		  $res10consultationitemrate1 = number_format($res10consultationitemrate1,'2','.','');

		  $queryr1 = "SELECT consultation from refund_consultation where locationcode='$locationcode1' and billnumber = '$res2billno' union all SELECT consultation from refund_paylaterconsultation where locationname='$locationcode1' and billnumber = '$res2billno'";

		  $execr1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr1) or die ("Error in Queryr1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr1 = mysqli_fetch_array($execr1))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resr1consultationrate = $resr1['consultation'];
		  $resr1cat='Refund Consultation';
		  
		  $resr1consultationrate1 = $resr1consultationrate1 + $resr1consultationrate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: red;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr1cat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ''; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ''; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr1cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr1consultationrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr1consultationrate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resr1consultationrate1 = number_format($resr1consultationrate1,'2','.','');
		  
		  $queryr2 = "SELECT labitemcode,labitemname,labitemrate from refund_paylaterlab where locationcode='$locationcode1' and billnumber = '$res2billno' union all SELECT labitemcode,labitemname,labitemrate from refund_paynowlab where locationcode='$locationcode1' and billnumber = '$res2billno' ";

		  $execr2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr2) or die ("Error in Queryr2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr2 = mysqli_fetch_array($execr2))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resr2code = $resr2['labitemcode'];
		  $resr2name = $resr2['labitemname'];
		  $resr2rate = $resr2['labitemrate'];
		  $resr2cat='Refund Laboratory';
		  
		  $resr2rate1 = $resr2rate1 + $resr2rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: red;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr2cat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo 'resr2code'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo 'resr2name'; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr2cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr2rate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo '1.00'; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr2rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resr2rate1 = number_format($resr2rate1,'2','.','');

		  $queryr3 = "SELECT servicesitemcode, servicesitemname, servicesitemrate, servicesitemqty, amount from refund_paylaterservices where locationcode='$locationcode1' and billnumber = '$res2billno' union all SELECT servicesitemcode, servicesitemname, servicesitemrate, servicequantity as servicesitemqty, serviceamount as amount from refund_paynowservices where locationcode='$locationcode1' and billnumber = '$res2billno' ";

		  $execr3 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr3) or die ("Error in Queryr3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr3 = mysqli_fetch_array($execr3))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resr3code = $resr3['servicesitemcode'];
		  $resr3name = $resr3['servicesitemname'];
		  $resr3singlerate = $resr3['servicesitemrate'];
		  $resr3qty = $resr3['servicesitemqty'];
		  $resr3rate = $resr3['amount'];
		  $resr3cat='Refund Services';
		  
		  $resr3rate1 = $resr3rate1 + $resr3rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: red;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr3cat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr3code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr3name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr3cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr3singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr3qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr3rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resr3rate1 = number_format($resr3rate1,'2','.','');

		  $queryr4 = "SELECT medicinecode, medicinename, rate, quantity, amount from refund_paylaterpharmacy where locationcode='$locationcode1' and billnumber = '$res2billno' union all SELECT medicinecode, medicinename, rate, quantity, amount from refund_paynowpharmacy where locationcode='$locationcode1' and billnumber = '$res2billno' ";

		  $execr4 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr4) or die ("Error in Queryr4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr4 = mysqli_fetch_array($execr4))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resr4code = $resr4['medicinecode'];
		  $resr4name = $resr4['medicinename'];
		  $resr4singlerate = $resr4['rate'];
		  $resr4qty = $resr4['quantity'];
		  $resr4rate = $resr4['amount'];
		  $resr4cat='Refund Pharmacy';
		  
		  $resr4rate1 = $resr4rate1 + $resr4rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: red;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr4cat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr4code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr4name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr4cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr4singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr4qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr4rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resr4rate1 = number_format($resr4rate1,'2','.','');

		  $queryr5 = "SELECT radiologyitemcode, radiologyitemname, radiologyitemrate from refund_paylaterradiology where locationcode='$locationcode1' and billnumber = '$res2billno' union all SELECT radiologyitemcode, radiologyitemname, radiologyitemrate from refund_paynowradiology where locationcode='$locationcode1' and billnumber = '$res2billno' ";

		  $execr5 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr5) or die ("Error in Queryr5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr5 = mysqli_fetch_array($execr5))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resr5code = $resr5['radiologyitemcode'];
		  $resr5name = $resr5['radiologyitemname'];
		  // $resr5singlerate = $resr5['rate'];
		  $resr5qty = '1.00';
		  $resr5rate = $resr5['radiologyitemrate'];
		  $resr5cat='Refund Radiology';
		  
		  $resr5rate1 = $resr5rate1 + $resr5rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: red;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr5cat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr5code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr5name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr5cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr5rate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr5qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr5rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resr5rate1 = number_format($resr5rate1,'2','.','');

		   $queryr6 = "SELECT referalcode, referalname, referalrate from refund_paylaterreferal where locationcode='$locationcode1' and billnumber = '$res2billno' union all SELECT referalcode, referalname, referalrate from refund_paynowreferal where locationcode='$locationcode1' and billnumber = '$res2billno' ";

		  $execr6 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr6) or die ("Error in Queryr6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr6 = mysqli_fetch_array($execr6))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resr6code = $resr6['referalcode'];
		  $resr6name = $resr6['referalname'];
		  // $resr5singlerate = $resr5['rate'];
		  $resr6qty = '1.00';
		  $resr6rate = $resr6['referalrate'];
		  $resr6cat='Refund Referal';
		  
		  $resr6rate1 = $resr6rate1 + $resr6rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: red;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resr6cat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr6code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr6name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr6cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr6rate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resr6qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr6rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resr6rate1 = number_format($resr6rate1,'2','.','');
		  /////////////////////// WEIVERS //////////////////////////////////
		  $queryr7 = "SELECT consultationfxamount, pharmacyfxamount, labfxamount, radiologyfxamount, servicesfxamount from billing_patientweivers where locationcode='$locationcode1' and billno = '$res2billno' ";

		  $execr7 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr7) or die ("Error in Queryr7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resr7 = mysqli_fetch_array($execr7))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		   
		  $resr7ratec = $resr7['consultationfxamount'];
		  $resr7ratep = $resr7['pharmacyfxamount'];
		  $resr7ratel = $resr7['labfxamount'];
		  $resr7rater = $resr7['radiologyfxamount'];
		  $resr7rates = $resr7['servicesfxamount'];
		  // $resr7cat='Patient Weivers';
		  
		  $resr7rate1 = $resr7rate1 + $resr7ratec+$resr7ratep+$resr7ratel+$resr7rater+$resr7rates;

		  $snocount = $snocount + 1;
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
		

		if($resr7ratec!='0.00'){ ?>
			<tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo "Consultation Waivers"; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "Consultation Waivers"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratec,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "1.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratec,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php }
		  if($resr7ratep!='0.00'){ ?>
			<tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo "Pharmacy Waivers"; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "Pharmacy Waivers"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratep,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "1.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratep,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php }
		  if($resr7ratel!='0.00'){ ?>
			<tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo "Laboratory Waivers"; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "Laboratory Waivers"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratel,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "1.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7ratel,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php }
		  if($resr7rater!='0.00'){ ?>
			<tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo "Radiology Waivers"; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "Radiology Waivers"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7rater,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "1.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7rater,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php }
		  if($resr7rates!='0.00'){ ?>
			<tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo "Service Waivers"; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo ""; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "Service Waivers"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7rates,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "1.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resr7rates,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php }
		}// end while of resr7
		  $resr7rate1 = number_format($resr7rate1,'2','.','');
		  /////////////////////// WEIVERS //////////////////////////////////

		  //////////////////////////////////OP WAS DONE HERE AND IP STARTS HERE//////////////
		  $resip1rate1 = '0.00';
		  $resip2rate1 = '0.00';
		  $resip3rate1 = '0.00';
		  $resip4rate1 = '0.00';
		  $resip5rate1 = '0.00';
		  $resip6rate1 = '0.00';
		  $resip7rate1 = '0.00';
		  $resip8rate1 = '0.00';
		  $resip9rate1 = '0.00';

		  $queryip1 = "SELECT  labitemcode, labitemrate,labitemname  from billing_iplab where locationcode='$locationcode1' and billnumber = '$res2billno'  ";
		  $execip1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip1) or die ("Error in Queryip1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip1 = mysqli_fetch_array($execip1))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip1code = $resip1['labitemcode'];
		  $resip1name = $resip1['labitemname'];
		  $resip1singlerate = $resip1['labitemrate'];
		  $resip1qty = '1.00';
		  $resip1rate = $resip1['labitemrate'];
		  $resip1cat='IP Laboratory';
		  
		  $resip1rate1 = $resip1rate1 + $resip1rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip1cat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip1code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip1name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip1cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip1rate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip1qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip1rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resip1rate1 = number_format($resip1rate1,'2','.','');

		   $queryip2 = "SELECT  servicesitemcode, servicesitemrate,servicesitemname  from billing_ipservices where locationcode='$locationcode1' and billnumber = '$res2billno'  ";

		  $execip2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip2) or die ("Error in Queryip2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip2 = mysqli_fetch_array($execip2))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip2code = $resip2['servicesitemcode'];
		  $resip2name = $resip2['servicesitemname'];
		  // $resip2singlerate = $resip2['servicesitemrate'];
		  $resip2qty = '1.00';
		  $resip2rate = $resip2['servicesitemrate'];
		  $resip2cat='IP Services';
		  
		  $resip2rate1 = $resip2rate1 + $resip2rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip2cat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip2code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip2name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip2cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip2rate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip2qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip2rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resip2rate1 = number_format($resip2rate1,'2','.','');

		  $queryip3 = "SELECT  medicinecode, medicinename, quantity, rate, amount  from billing_ippharmacy where locationcode='$locationcode1' and billnumber = '$res2billno'  ";

		  $execip3 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip3) or die ("Error in Queryip3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip3 = mysqli_fetch_array($execip3))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip3code = $resip3['medicinecode'];
		  $resip3name = $resip3['medicinename'];
		  $resip3singlerate = $resip3['rate'];
		  $resip3qty = $resip3['quantity'];
		  $resip3rate = $resip3['amount'];
		  $resip3cat='IP Pharmacy';
		  
		  $resip3rate1 = $resip3rate1 + $resip3rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip3cat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip3code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip3name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip3cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip3singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip3qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip3rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resip3rate1 = number_format($resip3rate1,'2','.','');

		   $queryip4 = "SELECT  radiologyitemcode, radiologyitemname, radiologyitemrate  from billing_ipradiology where locationcode='$locationcode1' and billnumber = '$res2billno'  ";

		  $execip4 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip4) or die ("Error in Queryip4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip4 = mysqli_fetch_array($execip4))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip4code = $resip4['radiologyitemcode'];
		  $resip4name = $resip4['radiologyitemname'];
		  $resip4singlerate = $resip4['radiologyitemrate'];
		  $resip4qty = '1.00';
		  $resip4rate = $resip4['radiologyitemrate'];
		  $resip4cat='IP Radiology';
		  
		  $resip4rate1 = $resip4rate1 + $resip4rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip4cat; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip4code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip4name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip4cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip4singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip4qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip4rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resip4rate1 = number_format($resip4rate1,'2','.','');

		  $queryip5 = "SELECT  description, bed, quantity, rate, amount  from billing_ipbedcharges where locationcode='$locationcode1' and docno = '$res2billno'  ";

		  $execip5 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip5) or die ("Error in Queryip5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip5 = mysqli_fetch_array($execip5))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip5code = $resip5['bed'];
		  $resip5dis = $resip5['description'];
		  $resip5name = 'Bed';
		  $resip5singlerate = $resip5['rate'];
		  $resip5qty = $resip5['quantity'];
		  $resip5rate = $resip5['amount'];
		  $resip5cat='IP Bed Charges';
		  
		  $resip5rate1 = $resip5rate1 + $resip5rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?>>
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip5dis; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip5code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip5name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip5cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip5singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip5qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip5rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resip5rate1 = number_format($resip5rate1,'2','.','');

		  $queryip6 = "SELECT quantity, rate, amount  from billing_ipadmissioncharge where locationcode='$locationcode1' and docno='$res2billno'  ";

		  $execip6 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip6) or die ("Error in Queryip6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip6 = mysqli_fetch_array($execip6))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip6code = "";
		  $resip6dis = "IP Admission Charges";
		  $resip6name = '';
		  $resip6singlerate = $resip6['rate'];
		  $resip6qty = $resip6['quantity'];
		  $resip6rate = $resip6['amount'];
		  $resip6cat='IP Admission Charges';
		  
		  $resip6rate1 = $resip6rate1 + $resip6rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: ;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip6dis; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip6code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip6name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip6cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip6singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip6qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip6rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resip6rate1 = number_format($resip6rate1,'2','.','');

		   $queryip7 = "SELECT description, rate, amount  from billing_ipmiscbilling where locationcode='$locationcode1' and docno='$res2billno'  ";
		   // $queryip7 = "SELECT totalamount  from billing_ipcreditapprovedtransaction where locationcode='$locationcode1' and docno='$res2billno'  ";

		  $execip7 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip7) or die ("Error in Queryip7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip7 = mysqli_fetch_array($execip7))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  // $resip7code = "";
		  // $resip7dis = "IP Credit Approved Charges";
		  // $resip7name = '';
		  // $resip7singlerate = $resip7['totalamount'];
		  // $resip7qty = '1';
		  // $resip7rate = $resip7['totalamount'];
		  // $resip7cat='IP Credit Approved Charges';

		  $resip7code = "";
		  $resip7dis = $resip7['description'];
		  $resip7name = '';
		  $resip7singlerate = $resip7['rate'];
		  $resip7qty = '1';
		  $resip7rate = $resip7['amount'];
		  $resip7cat='IP Miscellaneous Charges';
		  
		  $resip7rate1 = $resip7rate1 + $resip7rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: ;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip7dis; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip7code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip7name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip7cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip7singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip7qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip7rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resip7rate1 = number_format($resip7rate1,'2','.','');

		  $queryip8 = "SELECT description, rate, quantity, amount  from billing_ipambulance where locationcode='$locationcode1' and docno='$res2billno'  ";

		  $execip8 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip8) or die ("Error in Queryip8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip8 = mysqli_fetch_array($execip8))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip8code = "";
		  $resip8dis = $resip8['description'];
		  $resip8name = '';
		  $resip8singlerate = $resip8['rate'];
		  $resip8qty = $resip8['quantity'];
		  $resip8rate = $resip8['amount'];
		  $resip8cat='IP Abulance';
		  
		  $resip8rate1 = $resip8rate1 + $resip8rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: ;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip8dis; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip8code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip8name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip8cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip8singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip8qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip8rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resip8rate1 = number_format($resip8rate1,'2','.','');

		  $queryip9 = "SELECT description, rate, quantity, amount  from billing_ipprivatedoctor where locationcode='$locationcode1' and docno='$res2billno'  ";

		  $execip9 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip9) or die ("Error in Queryip9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip9 = mysqli_fetch_array($execip9))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip9code = "";
		  $resip9dis = $resip9['description'];
		  $resip9name = '';
		  $resip9singlerate = $resip9['rate'];
		  $resip9qty = $resip9['quantity'];
		  $resip9rate = $resip9['amount'];
		  $resip9cat='IP Private Doctor';
		  
		  $resip9rate1 = $resip9rate1 + $resip9rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: ;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip9dis; ?></td>
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
			    $query11 = "SELECT * from master_visitentry where visitcode='$res2visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip9code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip9name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip9cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip9singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip9qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip9rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		  $resip9rate1 = number_format($resip9rate1,'2','.','');

		  $total = $res5labitemrate1 + $res6servicesitemrate1 + $res7pharmacyitemrate1 + $res8radiologyitemrate1 + $res9referalitemrate1 + $res10consultationitemrate1+$resip1rate1+$resip2rate1+$resip3rate1+$resip4rate1+$resip5rate1+$resip6rate1+$resip7rate1+$resip8rate1+$resip9rate1;


		  $refund_total=$resr1consultationrate1+$resr2rate1+$resr3rate1+$resr4rate1+$resr5rate1+$resr6rate1+$resr7rate1;

		  $totallab += $res5labitemrate1;
		  $totalser += $res6servicesitemrate1;
		  $totalpharm += $res7pharmacyitemrate1;
		  $totalrad += $res8radiologyitemrate1;
		  $totalref += $res9referalitemrate1;
		  $totalcons += $res10consultationitemrate1;

		  $total = number_format($total,'2','.','');
		  $grandtotal = $grandtotal + $total;
		  $refund_gtotal=$refund_gtotal+$refund_total;
		  $after_refund=$grandtotal-$refund_gtotal;
			?>
          
			<?php //} //DEPARTMENT FILTER CONDITIONS
			$res21accountname ='';
			
			// }
			
			} // while big  query2 end loop
			$res22accountname ='';

			/////////////////////// OTHER SINGLE SAPERATE LOOP TABLE /////////////
			$resip10rate1="0.00";
			$queryip10 = "SELECT * from ip_discount where locationcode='$locationcode1' and consultationdate between '$ADate1' and '$ADate2'  order by consultationdate";

		  $execip10 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip10) or die ("Error in Queryip10".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip10 = mysqli_fetch_array($execip10))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip10code = $resip10['docno'];
		  $resip10dis = $resip10['description'];
		  $resip10name = '';
		  $resip10singlerate = $resip10['rate'];
		  $resip10qty = '1';
		  $resip10rate = $resip10['rate'];
		  $resip10cat='IP Discount';

		   $res10accountname = $resip10['accountname'];
		   $res10patientcode = $resip10['patientcode'];
		  $res10visitcode = $resip10['patientvisitcode'];
		  $res10billno = '';
		  $res10billdate = $resip10['consultationdate'];
		  $res10patientname = $resip10['patientname'];
		  
		  $resip10rate1 = $resip10rate1 + $resip10rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: red;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res10patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res10visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res10billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res10billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip10dis; ?></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo ''; //memberno ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res10patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res10accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo " "; //$subtype; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res10visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo '';//$res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip10code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip10name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip10cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resip10singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip10qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resip10rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		   $resip10rate1 = number_format($resip10rate1,'2','.','');

		   $resip11rate1="0.00";
			$queryip11 = "SELECT * from ip_creditnote where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'  order by billno";

		  $execip11 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip11) or die ("Error in Queryip11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip11 = mysqli_fetch_array($execip11))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip11code = '';
		  $resip11dis = 'IP Credit';
		  $resip11name = '';
		  $resip11singlerate = $resip11['totalamount'];
		  $resip11qty = '1';
		  $resip11rate = $resip11['totalamount'];
		  $resip11cat='IP Credit';

		   $res11accountname = $resip11['accountname'];
		   $res11patientcode = $resip11['patientcode'];
		  $res11visitcode = $resip11['visitcode'];
		  $res11billno = $resip11['billno'];
		  $res11billdate = $resip11['billdate'];
		  $res11patientname = $resip11['patientname'];
		  $res11subtype = $resip11['subtype'];
		  // $res11patienttype = $resip11['patienttype'];
		  
		  $resip11rate1 = $resip11rate1 + $resip11rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: red;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res11visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res11billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res11billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip11dis; ?></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo ''; //memberno ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11subtype; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res11visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo '';//$res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip11code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip11name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip11cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resip11singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip11qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right">-<?php echo number_format($resip11rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		   $resip11rate1 = number_format($resip11rate1,'2','.','');

		   $resip12rate1="0.00";
			$queryip12 = "SELECT * from ip_debitnote where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'  order by billno";

		  $execip12 = mysqli_query($GLOBALS["___mysqli_ston"], $queryip12) or die ("Error in Queryip12".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($resip11 = mysqli_fetch_array($execip12))
		  {
		  	 // Item Code Item Nam Category Rate Qty Amount
		  $resip12code = '';
		  $resip12dis = 'IP Debit';
		  $resip12name = '';
		  $resip12singlerate = $resip12['totalamount'];
		  $resip12qty = '1';
		  $resip12rate = $resip12['totalamount'];
		  $resip12cat='IP Debit';

		   $res12accountname = $resip12['accountname'];
		   $res12patientcode = $resip12['patientcode'];
		  $res12visitcode = $resip12['visitcode'];
		  $res12billno = $resip12['billno'];
		  $res12billdate = $resip12['billdate'];
		  $res12patientname = $resip12['patientname'];
		  $res12subtype = $resip12['subtype'];
		  // $res11patienttype = $resip11['patienttype'];
		  
		  $resip12rate1 = $resip12rate1 + $resip12rate;

		  $snocount = $snocount + 1;
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


		   <tr <?php echo $colorcode; ?> style="color: ;">
		   	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res12patientcode; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res12visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res12billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res12billdate; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $resip12dis; ?></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo ''; //memberno ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res12patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res12accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res12subtype; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php 
			    $query11 = "SELECT * from master_visitentry where visitcode='$res12visitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						$aut_department=$res11['department'];
						$fetch_department = "SELECT * from master_department where auto_number='$aut_department'";
					$ex_department = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_department) or die ("Error in fetch_department".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ex_department1 = mysqli_fetch_array($ex_department);
					echo $ex_department1['department'];

			     ?></div></td>

				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo '';//$res11paymenttype; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip12code; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip12name; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip12cat; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip12singlerate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo $resip12qty; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($resip12rate,2,'.',','); ?></div></td>
             
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php 
		  }
		  
		   $resip12rate1 = number_format($resip12rate1,'2','.','');
		

		  $total_neg="0.00";
		  $total_final="0.00";
		  $total_postive="0.00";
		  $total_final="0.00";

		  // $total_neg="";
		  // $total_final="";
		  // $total_postive="";
		  // $total_final="";

		  	$total_postive = $grandtotal+$resip12rate1;

		   $total_neg = $refund_gtotal+$resip10rate1+$resip11rate1;
		   
		   $total_final = $total_postive-$total_neg;


		  // $total = number_format($total,'2','.','');
		  // $grandtotal = $grandtotal + $total;
		  // $refund_gtotal=$refund_gtotal+$refund_total;
		  // $after_refund=$grandtotal-$refund_gtotal;

	        }
// }
			
			// }



			?>
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
                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><!--Total--></strong></div></td>

                  <!-- <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalcons,2); ?></strong></div></td>


              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totallab,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalser,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalpharm,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalrad,2); ?></strong></div></td> -->
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                <!--  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td> -->

            
  
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_postive,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5" style="color: red;"><div align="right"><strong>-<?php echo number_format($total_neg,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5" style="color: green"><strong><?php echo number_format($total_final,2,'.',','); ?></strong></td>
			  <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			 
			</tr>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>

