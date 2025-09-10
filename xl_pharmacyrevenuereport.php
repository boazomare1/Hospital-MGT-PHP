<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0.00';
$accountname = '';
$amount = 0;

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="pharmacyrevenuereport.xls"');
header('Cache-Control: max-age=80');


if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }	
if (isset($_REQUEST["pharmacy"])) { $pharmacy = $_REQUEST["pharmacy"]; } else { $pharmacy = ""; }			
			
if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select suppliername from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;

}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
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

?>
<style type="text/css">
<!--

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>

</head>

<body>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666" cellspacing="0" cellpadding="4" width="100%" 
            align="left" border="1">
          <tbody>

		 <tr> <td colspan="10" align="center"><strong><u><h3>PHARMACY REVENUE REPORT</h3></u></strong></td></tr>
          <tr ><td colspan="10" align="center"><strong>Type : <?php if($type=='') { echo 'All'; } echo $type; ?></strong></td></tr>
        <tr ><td colspan="10" align="center"><strong>Date From:    <?php echo $ADate1 ?>   To:  <?php echo $ADate2 ?></strong></td></tr>
   		 <tbody>
            
          	<tr>
              <td width="26"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="64" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date</strong></div></td>
              <td width="72" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg Code</strong></div></td>
              <td width="73" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Visit Code</td>
              <td width="160" align="left" valign="left"  
                bgcolor="#ffffff" class="style1"><div align="left"><strong>Patitent Name</strong></div></td>

                <td width="160" align="left" valign="left"  
                bgcolor="#ffffff" class="style1"><div align="left"><strong>Subtype</strong></div></td>
                 <td width="160" align="left" valign="left"  
                bgcolor="#ffffff" class="style1"><div align="left"><strong>Account Name</strong></div></td>


              <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Code</strong></div></td>
                <td width="174" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Name</strong></div></td>
                <td width="89" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate</strong></div></td>
                <td width="73" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Type</strong></div></td>
                <td width="225" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>  
            </tr>
            
			<?php
			$num1=0;
			$num2=0;
			$num3=0;
			$num6=0;
			$grandtotal = 0;
			$res2itemname = '';
			$amount = 0;
			
			$ADate1 = $transactiondatefrom;
			$ADate2 = $transactiondateto;
			
			if($cbfrmflag1 == 'cbfrmflag1')
			{
			
			$j = 0;
			$crresult = array();
			
			if($slocation=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$slocation'";
			}
			
			$querycr1in = "SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paynowpharmacy` WHERE medicinename LIKE '%$pharmacy%' AND medicinename <> 'Dispensing Fee' AND medicinename <> 'DISPENSING' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT amount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_externalpharmacy` WHERE medicinename LIKE '%$pharmacy%' AND medicinename <> 'Dispensing Fee' AND medicinename <> 'DISPENSING' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paylaterpharmacy` WHERE medicinename LIKE '%$pharmacy%' AND medicinename <> 'Dispensing Fee' AND medicinename <> 'DISPENSING' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT amountuhx as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_ippharmacy` WHERE medicinename LIKE '%$pharmacy%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
			
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows = mysqli_num_rows($execcr1);
			
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$j = $j+1;
			$patientcode = $rescr1['pcode'];
			$patientname = $rescr1['pname'];
			$patientvisitcode = $rescr1['vcode'];
			$itemcode = $rescr1['lcode'];
			$itemname = $rescr1['lname'];
			$billdate = $rescr1['date'];
			$pharmacyrate = $rescr1['income'];
			$total = $total + $pharmacyrate;
			
			//$res4billtype = $rescr1['billtype'];
			$res4accountname = $rescr1['accountname'];
			if($res4accountname != 'CASH COLLECTIONS')
			{
				$res4billtype = 'PAY LATER';
			}
			else
			{
				$res4billtype = 'PAY NOW';
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
               <tr >
              <td class="bodytext31" valign="center"  align="left"><?php echo $j; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $billdate; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientcode; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientvisitcode; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientname; ?></td>


			  <td class="bodytext31" valign="center"  align="left">
			  <?php //echo $patientname; 
			  // $patientcode
			  $query11 = "SELECT * from master_visitentry where visitcode='$patientvisitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_subtype=$res11['subtype'];
						$fetch_subtype = "SELECT * from master_subtype where auto_number='$aut_subtype'";
					$fetch_subtype1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_subtype11 = mysqli_fetch_array($fetch_subtype1);
					echo $fetch_subtype11['subtype'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$patientvisitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_subtype2=$res12['subtype'];
									$fetch_subtype33 = "SELECT * from master_subtype where auto_number='$aut_subtype2'";
								$fetch_subtype133 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype33) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_subtype1133 = mysqli_fetch_array($fetch_subtype133);
								echo $fetch_subtype1133['subtype'];
								
						}else{
									echo  "----";
								}
					}

			  ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php  
			  $query11 = "SELECT * from master_visitentry where visitcode='$patientvisitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_accountname=$res11['accountname'];
						$fetch_accountnam = "SELECT * from master_accountname where auto_number='$aut_accountname'";
					$fetch_accountnam1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_accountnam) or die ("Error in fetch_accountnam".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_accountnam11 = mysqli_fetch_array($fetch_accountnam1);
					echo $fetch_accountnam11['accountname'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$patientvisitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_accountname2=$res12['accountname'];
									$fetch_aut_accountname2 = "SELECT * from master_accountname where auto_number='$aut_accountname2'";
								$fetch_aut_accountname22 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_aut_accountname2) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_aut_accountname221 = mysqli_fetch_array($fetch_aut_accountname22);
								echo $fetch_aut_accountname221['accountname'];
								
						}else{
									echo  "----";
								}
					}


			  ?></td>




              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemcode; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($pharmacyrate,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4billtype; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4accountname; ?></div></td>
           </tr>
		   <?php
			}
			
			 $amount = $amount + $total;	
			
		  $num4 = $num1 + $num2 + $num3 + $num6;
		 
		  $grandtotal = $grandtotal + $amount;
		  
		  $total = number_format($total,'2','.','');
		
			?>
          <tr>
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td colspan="5" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><strong><?php echo number_format($amount,2); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
           </tr>
		  
		   <tr>
			<td bgcolor="#FFFFFF" colspan="10" class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong><?php echo 'Refund'; ?></strong></div></td>
			</tr>	
		    <?php
		   $amount=0;
		   $total=0;
		   $j=0;
		   
		    if($type=="" || $type=="OP")
			{
			$querydr1in = "SELECT (amount) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `refund_paynowpharmacy`  WHERE medicinename LIKE '%$pharmacy%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT (amount) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, accountname as accountname, billtype as billtype FROM `refund_paylaterpharmacy` WHERE medicinename LIKE '%$pharmacy%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT pharmacyfxamount as income, patientcode as pcode, patientname as pname, visitcode as vcode,'' as lcode, '' as lname, entrydate as date, accountname as accountname, billtype as billtype FROM `billing_patientweivers` WHERE pharmacyfxamount > '0' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdr1 = mysqli_fetch_array($execdr1))
			{
			$j = $j+1;
			$patientcode = $resdr1['pcode'];
			$patientname = $resdr1['pname'];
			$patientvisitcode = $resdr1['vcode'];
			$itemcode = $resdr1['lcode'];
			$itemname = $resdr1['lname'];
			$billdate = $resdr1['date'];
			$servicesrate = $resdr1['income'];
			$total = $total + $servicesrate;
			
			//$res4billtype = $resdr1['billtype'];
			$res4accountname = $resdr1['accountname'];
			if($res4accountname != 'CASH COLLECTIONS')
			{
				$res4billtype = 'PAY LATER';
			}
			else
			{
				$res4billtype = 'PAY NOW';
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
               <tr >
              <td class="bodytext31" valign="center"  align="left"><?php echo $j; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $billdate; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientcode; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientvisitcode; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientname; ?></td>

			  <td class="bodytext31" valign="center"  align="left">
			  <?php //echo $patientname; 
			  // $patientcode
			  $query11 = "SELECT * from master_visitentry where visitcode='$patientvisitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_subtype=$res11['subtype'];
						$fetch_subtype = "SELECT * from master_subtype where auto_number='$aut_subtype'";
					$fetch_subtype1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_subtype11 = mysqli_fetch_array($fetch_subtype1);
					echo $fetch_subtype11['subtype'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$patientvisitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_subtype2=$res12['subtype'];
									$fetch_subtype33 = "SELECT * from master_subtype where auto_number='$aut_subtype2'";
								$fetch_subtype133 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype33) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_subtype1133 = mysqli_fetch_array($fetch_subtype133);
								echo $fetch_subtype1133['subtype'];
								
						}else{
									echo  "----";
								}
					}

			  ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php  
			  $query11 = "SELECT * from master_visitentry where visitcode='$patientvisitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_accountname=$res11['accountname'];
						$fetch_accountnam = "SELECT * from master_accountname where auto_number='$aut_accountname'";
					$fetch_accountnam1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_accountnam) or die ("Error in fetch_accountnam".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_accountnam11 = mysqli_fetch_array($fetch_accountnam1);
					echo $fetch_accountnam11['accountname'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$patientvisitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_accountname2=$res12['accountname'];
									$fetch_aut_accountname2 = "SELECT * from master_accountname where auto_number='$aut_accountname2'";
								$fetch_aut_accountname22 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_aut_accountname2) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_aut_accountname221 = mysqli_fetch_array($fetch_aut_accountname22);
								echo $fetch_aut_accountname221['accountname'];
								
						}else{
									echo  "----";
								}
					}


			  ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemcode; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($servicesrate,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4billtype; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4accountname; ?></div></td>
           </tr>
		   <?php
			}
			}	
			$amount = $amount + $total;
			
		  $num4 = $num1 + $num2 + $num3 + $num6;
		  //$num4 = number_format($num4, '2', '.' ,''); 
		  
		  $grandtotal = $grandtotal - $amount;
		  
		  $total = number_format($total,'2','.','');
		  
			if(true)
			{
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
          <tr>
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td colspan="5" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong><?php echo number_format($amount,2); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
           </tr>
			<?php
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
               <td colspan="5" class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><strong><strong>Grand Total:</strong></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><strong><?php echo number_format($grandtotal,2);?></strong></td>
              <td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
			  </tr>
			  <?php
			  }
			  ?>
          </tbody>
        </table>
</body>
</html>

