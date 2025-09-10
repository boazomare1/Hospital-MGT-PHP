<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$total_beforesharing=0;
$total_sharingamount=0;
$ipaddress = $_SERVER['REMOTE_ADDR'];
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
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #add8e6;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
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
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
$qry2 = "select patientfullname,patientcode from master_ipvisitentry where visitcode='$visitcode'";
$query39=mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res39=mysqli_fetch_array($query39);
$patientname=$res39['patientfullname'];			
		
		?>
<table width="1360" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#add8e6"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#add8e6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#add8e6"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
  
	<table width="400" border="0"  align="center" cellspacing="0" cellpadding="2">
	<tr>
				<td  class="bodytext31" valign="center" bgcolor="#cccccc" align="left"><strong>Patient Name</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#cccccc" align="left"><strong>Patient code</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#cccccc" align="right"><strong>Visitcode</strong></td>
	</tr>
	
	<tr>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong><?php echo $patientname;?> </strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong><?php echo $patientcode;?> </strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong><?php echo $visitcode;?></strong></td>
	</tr>
	</table>
  
  <tr><td>&nbsp;</td></tr>
  
	<table width="1360" border="0" cellspacing="0" cellpadding="2">
	<td width="1%">&nbsp;</td>
    <td width="" valign="top">
        <table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="0">
		<tbody>
			<tr>
				<td   colspan="5" bgcolor="#cccccc" class="bodytext31" colspan='4'><strong>Package Processed  </strong></td>
			</tr>   
			<tr <?php //echo $colorcode; ?>>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Consultation</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Pharmacy</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Lab</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Radiology</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Service</strong></td>
			</tr>
			<?php 
			$tot_amount=0;
			$colorloopcount=0;
			$radpkgamt=0;
			$labpkgamt=0;
			$phpkgamt=0;
			$serpkgamt=0;
			$conpkgamt=0;
			$sno=1;
			$q1="SELECT CASE WHEN package_item_type = 'MI' THEN 'phpkgamt' WHEN package_item_type = 'LI' THEN 'labpkgamt' WHEN package_item_type = 'RI' THEN 'radpkgamt' WHEN package_item_type = 'SI' THEN 'serpkgamt' WHEN package_item_type = 'DC' THEN 'conpkgamt' ELSE 'Other' END AS package_item_type,sum(amount) AS total_amount FROM package_processing WHERE package_item_type IN ('SI', 'MI', 'LI', 'RI', 'CT', 'DC') and visitcode='$visitcode'  and recordstatus='completed' GROUP BY package_item_type";
			$ex1 = mysqli_query($GLOBALS["___mysqli_ston"], $q1) or die ("Error in Q1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res10 = mysqli_fetch_array($ex1)){
			$package_item_type=$res10['package_item_type'];
			if($package_item_type=='serpkgamt'){
			$serpkgamt=$res10['total_amount'];
			}
			else if($package_item_type=='labpkgamt'){
			$labpkgamt=$res10['total_amount'];
			}
			else if($package_item_type=='radpkgamt'){
			$radpkgamt=$res10['total_amount'];
			}
			else if($package_item_type=='conpkgamt'){
			$conpkgamt=$res10['total_amount'];
			}
			}
			
			$query_v1 = "select sum(totalcp) as totalamount from  pharmacysales_details where  patientcode='$patientcode'  and visitcode = '$visitcode' and freestatus='Yes' and package_process_id<>'0'  ";
			$exec_V1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_v1) or die ("Error in query_v1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_v1 = mysqli_fetch_array($exec_V1);
			$phpkgamt=$res_v1['totalamount'];
			?>
			<tr>
				<td class="bodytext31" valign="center"  align="left"><strong><?php echo number_format($conpkgamt,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="left"><strong><?php echo number_format($phpkgamt,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="left"><strong><?php echo number_format($labpkgamt,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="left"><strong><?php echo number_format($radpkgamt,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="left"><strong><?php echo number_format($serpkgamt,2,'.',','); ?></strong></td>
			</tr>
			
		
		</tbody>
		</table>
	</td>
	

	<td width="" valign="top">
        <table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="0">
		<tbody>
			<tr>
				<td width="10%" bgcolor="#cccccc" class="bodytext31" colspan='5'><strong>Consultation Package Processed Details </strong></td>
			</tr>   
			<tr <?php //echo $colorcode; ?>>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Item</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Quantity</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Amount</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Posted By</strong></td>
			</tr>
			<?php 
			$tot_amount=0;
			$colorloopcount=0;
			$sno=1;
			$query_v = "select * from  package_processing where  patientcode='$patientcode'  and visitcode = '$visitcode' and package_item_type='DC' and recordstatus='completed'";
			$exec_V = mysqli_query($GLOBALS["___mysqli_ston"], $query_v) or die ("Error in query_v".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_v = mysqli_fetch_array($exec_V))
			{
			$itemname=$res_v['itemname'];
			$quantity=$res_v['quantity'];
			$totalcp=$res_v['amount'];
			$usernamecp=$res_v['username'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$colorcode = '';
			if ($showcolor == 0)
			{
			//echo "if";
			$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
			//echo "else";
			$colorcode = 'bgcolor="#5fe5de"';
			}  ?>
			<tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno++; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $itemname; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format(1,2); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo $totalcp; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo $usernamecp; ?></td>
			</tr>
			<?php	
			$tot_amount=$tot_amount+$totalcp;
			}
			?>
			<tr >
				<td colspan="3" class="bodytext31" valign="center"  align="right"><b>Total :</b></td>
				<td  class="bodytext31" valign="center"  align="right"><b><?php echo number_format($tot_amount,2); ?></b></td>
				
			</tr>
		</tbody>
		</table>
	</td>
	
	</table>
	
	
	<table width="1360" border="0" cellspacing="0" cellpadding="2">
	<td width="1%">&nbsp;</td>
    <td width="" valign="top">
        <table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="0">
		<tbody>
			<tr>
				<td    width="10%" bgcolor="#cccccc" class="bodytext31" colspan='4'><strong>Pharmacy Package Processed Details </strong></td>
			</tr>   
			<tr <?php //echo $colorcode; ?>>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Item</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Quantity</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Amount</strong></td>
			</tr>
			<?php 
			$tot_amount=0;
			$colorloopcount=0;
			$sno=1;
			$query_v = "select sum(totalcp) as totalamount,sum(quantity) as quantity,itemname from  pharmacysales_details where  patientcode='$patientcode'  and visitcode = '$visitcode' and freestatus='Yes' and package_process_id<>'0' group by itemcode ";
			$exec_V = mysqli_query($GLOBALS["___mysqli_ston"], $query_v) or die ("Error in query_v".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_v = mysqli_fetch_array($exec_V))
			{
			$itemname=$res_v['itemname'];
			$quantity=$res_v['quantity'];
			$totalcp=$res_v['totalamount'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$colorcode = '';
			if ($showcolor == 0)
			{
			//echo "if";
			$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
			//echo "else";
			$colorcode = 'bgcolor="#5fe5de"';
			}  ?>
			<tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno++; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $itemname; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($quantity,2); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo $totalcp; ?></td>
			</tr>
			<?php	
			$tot_amount=$tot_amount+$totalcp;
			}
			?>
			<tr >
				<td colspan="3" class="bodytext31" valign="center"  align="right"><b>Total :</b></td>
				<td  class="bodytext31" valign="center"  align="right"><b><?php echo number_format($tot_amount,2); ?></b></td>
			</tr>
		</tbody>
		</table>
	</td>
	
	<td width="" valign="top">
	 <table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="0">
		<tbody>
		<tr>
				<td    width="10%" bgcolor="#cccccc" class="bodytext31" colspan='4'><strong>Lab Package Processed Details </strong></td>
			</tr>   
			<tr <?php //echo $colorcode; ?>>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Item</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Quantity</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Amount</strong></td>
			</tr>
			<?php 
			$tot_amount=0;
			$colorloopcount=0;
			$sno=1;
			$query_v = "select * from  package_processing where  patientcode='$patientcode'  and visitcode = '$visitcode' and package_item_type='LI' and recordstatus='completed' ";
			$exec_V = mysqli_query($GLOBALS["___mysqli_ston"], $query_v) or die ("Error in query_v".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_v = mysqli_fetch_array($exec_V))
			{
			$itemname=$res_v['itemname'];
			$quantity=$res_v['quantity'];
			$totalcp=$res_v['amount'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$colorcode = '';
			if ($showcolor == 0)
			{
			//echo "if";
			$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
			//echo "else";
			$colorcode = 'bgcolor="#5fe5de"';
			}  ?>
			<tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno++; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $itemname; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format(1,2); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo $totalcp; ?></td>
			</tr>
			<?php	
			$tot_amount=$tot_amount+$totalcp;
			}
			?>
			<tr >
				<td colspan="3" class="bodytext31" valign="center"  align="right"><b>Total :</b></td>
				<td  class="bodytext31" valign="center"  align="right"><b><?php echo number_format($tot_amount,2); ?></b></td>
			</tr>
		</tbody>
	</table>
	</td>
	</table>
	
	<table width="1360" border="0" cellspacing="0" cellpadding="2">
	<td width="1%">&nbsp;</td>
    <td width="" valign="top">
        <table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="0">
		<tbody>
			<tr>
				<td    width="10%" bgcolor="#cccccc" class="bodytext31" colspan='4'><strong>Radiology Package Processed Details </strong></td>
			</tr>   
			<tr <?php //echo $colorcode; ?>>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Item</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Quantity</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Amount</strong></td>
			</tr>
			<?php 
			$tot_amount=0;
			$colorloopcount=0;
			$sno=1;
			$query_v = "select * from  package_processing where  patientcode='$patientcode'  and visitcode = '$visitcode' and package_item_type='RI' and recordstatus='completed' ";
			$exec_V = mysqli_query($GLOBALS["___mysqli_ston"], $query_v) or die ("Error in query_v".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_v = mysqli_fetch_array($exec_V))
			{
			$itemname=$res_v['itemname'];
			$quantity=$res_v['quantity'];
			$totalcp=$res_v['totalamount'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$colorcode = '';
			if ($showcolor == 0)
			{
			//echo "if";
			$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
			//echo "else";
			$colorcode = 'bgcolor="#5fe5de"';
			}  ?>
			<tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno++; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $itemname; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($quantity,2); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo $totalcp; ?></td>
			</tr>
			<?php	
			$tot_amount=$tot_amount+$totalcp;
			}
			?>
			<tr >
				<td colspan="3" class="bodytext31" valign="center"  align="right"><b>Total :</b></td>
				<td  class="bodytext31" valign="center"  align="right"><b><?php echo number_format($tot_amount,2); ?></b></td>
			</tr>
		</tbody>
		</table>
	</td>
	
	<td width="" valign="top">
	 <table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="0">
		<tbody>
		<tr>
				<td    width="10%" bgcolor="#cccccc" class="bodytext31" colspan='4'><strong>Service Package Processed Details </strong></td>
			</tr>   
			<tr <?php //echo $colorcode; ?>>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Item</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Quantity</strong></td>
				<td  class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><strong>Amount</strong></td>
			</tr>
			<?php 
			$tot_amount=0;
			$colorloopcount=0;
			$sno=1;
			$query_v = "select * from  package_processing where  patientcode='$patientcode'  and visitcode = '$visitcode' and package_item_type='SI' and recordstatus='completed' ";
			$exec_V = mysqli_query($GLOBALS["___mysqli_ston"], $query_v) or die ("Error in query_v".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_v = mysqli_fetch_array($exec_V))
			{
			$itemname=$res_v['itemname'];
			$quantity=$res_v['quantity'];
			$totalcp=$res_v['amount'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$colorcode = '';
			if ($showcolor == 0)
			{
			//echo "if";
			$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
			//echo "else";
			$colorcode = 'bgcolor="#5fe5de"';
			}  ?>
			<tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno++; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $itemname; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format(1,2); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo $totalcp; ?></td>
			</tr>
			<?php	
			$tot_amount=$tot_amount+$totalcp;
			}
			?>
			<tr >
				<td colspan="3" class="bodytext31" valign="center"  align="right"><b>Total :</b></td>
				<td  class="bodytext31" valign="center"  align="right"><b><?php echo number_format($tot_amount,2); ?></b></td>
			</tr>
		</tbody>
	</table>
	</td>
	</table>
	
</tr>
</table>
        
			