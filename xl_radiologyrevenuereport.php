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
header('Content-Disposition: attachment;filename="radiologyrevenuereport.xls"');
header('Cache-Control: max-age=80');
if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }	
if (isset($_REQUEST["radiology"])) { $radiology = $_REQUEST["radiology"]; } else { $radiology = ""; }			
if (isset($_REQUEST["radcategory"])) { $radcategory = $_REQUEST["radcategory"]; } else { $radcategory = ""; }
			
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
		 <tr> <td colspan="10" align="center"><strong><u><h3>RADIOLOGY REVENUE REPORT</h3></u></strong></td></tr>
         
        <tr ><td colspan="10" align="center"><strong>Type : <?php if($type=='') { echo 'All'; } echo $type; ?></strong></td></tr>
		 <tr ><td colspan="10" align="center"><strong>Date From:    <?php echo $ADate1 ?>   To:  <?php echo $ADate2 ?></strong></td></tr>
   		<tbody>
            
           <tr>
              <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="9%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date</strong></div></td>
              <td width="9%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg Code</strong></div></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Visit Code</td>
              <td width="16%" align="left" valign="left"  
                bgcolor="#ffffff" class="style1"><div align="left"><strong>Patitent Name</strong></div></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Code</strong></div></td>
                <td width="14%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Name</strong></div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Category</strong></div></td>
                <td width="8%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate</strong></div></td>
                <!-- <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Type</strong></div></td> -->
                   <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill No </strong></div></td>
                <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>  
            </tr>
            
			<?php
			if($radcategory=='')
			  $catsql=" and m.categoryname like '%%'";
			else
			  $catsql=" and m.categoryname = '$radcategory'";
			$num1=0;
			$num2=0;
			$num3=0;
			$num6=0;
			$grandtotal = 0;
			$res2itemname = '';
			
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
			if($type == "OP")
			{
			$querycr1in = "SELECT DISTINCT a.fxamount as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, a.accountname as accountname,a.billnumber as billno, a.billtype as billtype,m.categoryname as categoryname FROM `billing_paynowradiology` as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and  a.radiologyitemname LIKE '%$radiology%' AND a.billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location
						   UNION ALL SELECT DISTINCT a.radiologyitemrate as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, CONCAT(a.accountname,'CASH COLLECTIONS') as accountname,a.billnumber as billno, CONCAT(a.billtype,'PAY NOW') as billtype,m.categoryname as categoryname FROM `billing_externalradiology` as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and a.radiologyitemname LIKE '%$radiology%' AND a.billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location
						   UNION ALL SELECT DISTINCT a.fxamount as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, a.accountname as accountname,a.billnumber as billno, a.billtype as billtype,m.categoryname as categoryname FROM `billing_paylaterradiology`  as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and a.radiologyitemname LIKE '%$radiology%' AND a.billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location";
			}
			else if($type == "IP")
			{
			$querycr1in = "SELECT DISTINCT a.radiologyitemrateuhx as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, a.accountname as accountname, a.billnumber as billno,a.billtype as billtype,m.categoryname as categoryname FROM `billing_ipradiology` as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and a.radiologyitemname LIKE '%$radiology%' AND a.billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location";
			}
			else
			{
			$querycr1in = "SELECT DISTINCT a.fxamount as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, a.accountname as accountname,a.billnumber as billno, a.billtype as billtype,m.categoryname as categoryname FROM `billing_paynowradiology`  as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and radiologyitemname LIKE '%$radiology%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location
						   UNION ALL SELECT DISTINCT a.radiologyitemrate as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, CONCAT(a.accountname,'CASH COLLECTIONS') as accountname,a.billnumber as billno, CONCAT(a.billtype,'PAY NOW') as billtype,m.categoryname as categoryname FROM `billing_externalradiology`  as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and radiologyitemname LIKE '%$radiology%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location
						   UNION ALL SELECT DISTINCT a.fxamount as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, a.accountname as accountname,a.billnumber as billno, a.billtype as billtype,m.categoryname as categoryname FROM `billing_paylaterradiology`  as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and radiologyitemname LIKE '%$radiology%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location
						   UNION ALL SELECT DISTINCT a.radiologyitemrateuhx as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, a.accountname as accountname,a.billnumber as billno, a.billtype as billtype,m.categoryname as categoryname FROM `billing_ipradiology`  as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and radiologyitemname LIKE '%$radiology%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location";
			}			    
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$j = $j+1;
			$patientcode = $rescr1['pcode'];
			$patientname = $rescr1['pname'];
			$patientvisitcode = $rescr1['vcode'];
			$itemcode = $rescr1['lcode'];
			$itemname = $rescr1['lname'];
			$billdate = $rescr1['date'];
			$radiologyrate = $rescr1['income'];
			$categoryname = $rescr1['categoryname'];
			$total = $total + $radiologyrate;
			
			//$res4billtype = $rescr1['billtype'];
			$res4accountname = $rescr1['accountname'];
			$billno = $rescr1['billno'];
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
			    <div align="left"><?php echo $itemcode; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $categoryname; ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($radiologyrate,2,'.',','); ?></div></td>
                <!-- <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4billtype; ?></div></td> -->
			     <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $billno; ?></div></td>
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
              <td colspan="4" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><strong><?php echo number_format($amount,2); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
                 <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
                <!-- <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td> -->
           </tr>
		  
		   <tr>
			<td bgcolor="#FFFFFF" colspan="10" class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong><?php echo 'Refund'; ?></strong></div></td>
			</tr>	
		   <?php
		   $amount=0;
		   $j=0;
		   $total=0;
		    if($type == "OP")
			{
			$querydr1in = "SELECT DISTINCT (a.radiologyitemrate) as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, CONCAT(a.accountname,'CASH COLLECTIONS') as accountname,a.billnumber as billno, CONCAT(a.billtype,'PAY NOW') as billtype,m.categoryname as categoryname FROM `refund_paynowradiology` as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and radiologyitemname LIKE '%$radiology%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location
						   UNION ALL SELECT DISTINCT (a.fxamount) as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, a.accountname as accountname, a.billnumber as billno,a.billtype as billtype,m.categoryname as categoryname FROM `refund_paylaterradiology`  as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and radiologyitemname LIKE '%$radiology%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location
						   UNION ALL SELECT radiologyfxamount as income, patientcode as pcode, patientname as pname, visitcode as vcode,'' as lcode, '' as lname, entrydate as date, accountname as accountname,billno as billno, billtype as billtype,'' as categoryname FROM `billing_patientweivers` WHERE radiologyfxamount > '0' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
			}
			else if($type == "IP")
			{
			$querydr1in = "SELECT rate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,'' as lcode, '' as lname, consultationdate as date, accountname as accountname,docno as billno,  '' as billtype,'' as categoryname FROM `ip_discount` WHERE description = 'Radiology' AND consultationdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
			}
			else
			{
			$querydr1in = "SELECT DISTINCT (a.radiologyitemrate) as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, CONCAT(a.accountname,'CASH COLLECTIONS') as accountname, a.billnumber as billno,CONCAT(a.billtype,'PAY NOW') as billtype,m.categoryname as categoryname FROM `refund_paynowradiology`  as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and radiologyitemname LIKE '%$radiology%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location
						   UNION ALL SELECT DISTINCT (a.fxamount) as income, a.patientcode as pcode, a.patientname as pname, a.patientvisitcode as vcode,a.radiologyitemcode as lcode, a.radiologyitemname as lname, a.billdate as date, a.accountname as accountname,a.billnumber as billno, a.billtype as billtype,m.categoryname as categoryname FROM `refund_paylaterradiology`  as a,master_radiology as m  WHERE a.radiologyitemcode=m.itemcode $catsql and radiologyitemname LIKE '%$radiology%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND a.$pass_location
						   UNION ALL SELECT radiologyfxamount as income, patientcode as pcode, patientname as pname, visitcode as vcode,'' as lcode, '' as lname, entrydate as date, accountname as accountname, billno as billno,billtype as billtype,'' as categoryname FROM `billing_patientweivers` WHERE radiologyfxamount > '0' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT rate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,'' as lcode, '' as lname, consultationdate as date, accountname as accountname,docno as billno, '' as billtype,'' as categoryname FROM `ip_discount` WHERE description = 'Radiology' AND consultationdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
			}
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
			$radiologyrate = $resdr1['income'];
			$categoryname = $resdr1['categoryname'];
			$total = $total + $radiologyrate;
			
			//$res4billtype = $resdr1['billtype'];
			$res4accountname = $resdr1['accountname'];
				$billno          = $resdr1['billno'];
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
			    <div align="left"><?php echo $itemcode; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $categoryname; ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($radiologyrate,2,'.',','); ?></div></td>
                <!-- <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4billtype; ?></div></td> -->
			     <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $billno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4accountname; ?></div></td>
           </tr>
		   <?php
			}	
			$amount = $amount + $total;		
		   
		  $num4 = $num1 + $num2 + $num3 + $num6;
		  //$num4 = number_format($num4, '2', '.' ,''); 
		  
		  $grandtotal = $grandtotal - $amount;
		  
		  $total = number_format($total,'2','.','');
		  
			
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
              <td colspan="4" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><strong><?php echo number_format($amount,2); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
                <!-- <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td> -->
           </tr>
			
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
               <td colspan="4" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong><strong>Grand Total:</strong></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong><?php echo number_format($grandtotal,2);?></strong></td>
              <td colspan="1" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
            </tr>
			<?php
			  }
			  ?>
          </tbody>
        </table>
</body>
</html>