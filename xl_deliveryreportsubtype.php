<?php 

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Dispatch Report Subtype.xls"');
header('Cache-Control: max-age=80');

session_start();
include ("db/db_connect.php");
error_reporting(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
if (isset($_REQUEST["searchaccoutname"])) { $searchaccoutname = $_REQUEST["searchaccoutname"]; } else { $searchaccoutname = ""; }
if (isset($_REQUEST["searchaccoutnameanum"])) { $searchaccoutnameanum = $_REQUEST["searchaccoutnameanum"]; } else { $searchaccoutnameanum = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }


?>
<style type="text/css">
<!--
.bodytext3 {
}
.bodytext31 {
}
.bodytext311 {
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

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1032" align="left" border="1">
  <tbody>
	<?php
	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
	if (isset($_REQUEST["subtype"])) { $searchsuppliername = $_REQUEST["subtype"]; } else { $searchsuppliername = ""; }
    if ($cbfrmflag1 == 'cbfrmflag1')
	{
	
	?>
	<tr>
      <td colspan="8" bgcolor="#ecf0f5" align="center" class="bodytext31"><strong><?php echo $searchsuppliername; ?></strong></td>
    </tr>
    <tr>
      <td colspan="8" bgcolor="#00CCFF" align="center" class="bodytext31"><strong><?php echo 'Completed Invoice'; ?></strong></td>
    </tr>
    <tr>
		<td width="4%"  align="left" valign="center" 
        bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
        <td width="16%" align="left" valign="center"  
        bgcolor="#ffffff" class="bodytext31"><strong>Account Name</strong></td>
      <td width="7%" align="left" valign="center"  
        bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
      <td width="11%" align="left" valign="center"  
        bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
		<td width="11%" align="left" valign="center"  
        bgcolor="#ffffff" class="bodytext31"><strong> Location </strong></td>
      <td width="15%" align="left" valign="center"  
        bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
      <td width="10%" align="left" valign="center"  
        bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date </strong></div></td>
      <td width="10%" align="left" valign="center"  
        bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
      </tr>
	<?php
	$total = '0.00';
	$snocount = '';
	 $searchsuppliername;
	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
	if (isset($_REQUEST["subtype"])) { $searchsuppliername = $_REQUEST["subtype"]; } else { $searchsuppliername = ""; }
	if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
	if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }


    if ($cbfrmflag1 == 'cbfrmflag1')
	{ 
	
	  if($searchsuppliername!=''){
	      $query25 = "select auto_number,subtype from master_subtype where  subtype = '$searchsuppliername'";
	  }
		else{
			$query25 = "select auto_number,subtype from master_subtype ";
		}

	$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res25 = mysqli_fetch_array($exec25)) {

	$searchsubtypeanum1 = $res25['auto_number'];
	$searchsuppliername = $res25['subtype'];
	//echo $searchsuppliername;
	$searchsuppliername=trim($searchsuppliername);
	$query21 = "select accountname,id from master_accountname where  subtype = '$searchsubtypeanum1'  order by subtype desc";	
	// and recordstatus <> 'DELETED' 
	
	if($searchaccoutname!=''){

		 $query21 = "select accountname,id from master_accountname where  auto_number = '$searchaccoutnameanum'";		
		   // and recordstatus <> 'DELETED'	
	}

	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while ($res21 = mysqli_fetch_array($exec21))
	{

	 $res21accountname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res21['accountname']));
	  $accountnameid=$res21['id'];
	

	// $query24 = "select accountname from print_deliverysubtype where  trim(accountname) = '$res21accountname' and subtype = '$searchsuppliername' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted' group by accountname";
	 // $query24 = "select accountname from print_deliverysubtype where  accountnameid = '$accountnameid' and subtype = '$searchsuppliername' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted' group by accountnameid";
	 // $query24 = "select a.accountname from print_deliverysubtype as a JOIN master_accountname as b on a.accountnameid=b.id where b.subtype='$searchsubtypeanum1' and a.accountnameid = '$accountnameid' and date(a.updatedatetime) between '$ADate1' and '$ADate2' and a.status <> 'deleted' group by a.accountnameid";
	 
	 
	 if($location!=''){
	$loct="and locationcode='$location'";
	}else{
	$loct="and locationcode like '%%'";
	}
	 $query24 = "select accountname from print_deliverysubtype where  accountnameid = '$accountnameid' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted' $loct group by accountnameid";

	 if($searchsuppliername==''){
				 // $query6 = "select accountname from print_deliverysubtype where  trim(accountname) = '$res21accountname' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted' group by accountname";
	 $query24 = "select accountname from print_deliverysubtype where  accountnameid = '$accountnameid' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted' $loct group by accountnameid";
			}

	$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res24 = mysqli_fetch_array($exec24);
	$res24accountname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res24['accountname']));

	if($res24accountname != '')
	{
	?>
	<?php
	
	// $query6 = "select billno,locationname,locationcode,isnhif from print_deliverysubtype where  trim(accountname) = '$res21accountname' and subtype = '$searchsuppliername' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted'";

	// if($searchsuppliername==''){
	// 	$query6 = "select billno,locationname,locationcode,isnhif from print_deliverysubtype where  trim(accountname) = '$res21accountname' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted'";
	// }
	// $query6 = "select a.billno,a.locationname,a.locationcode,a.isnhif,a.accountnameid from print_deliverysubtype  as a JOIN master_accountname as b on a.accountnameid=b.id where b.subtype='$searchsubtypeanum1' and a.accountnameid = '$accountnameid' and date(a.updatedatetime) between '$ADate1' and '$ADate2' and a.status <> 'deleted' group by a.accountnameid";
	$query6 = "select billno,locationname,locationcode,isnhif,accountnameid from print_deliverysubtype where accountnameid = '$accountnameid' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted' $loct";

	if($searchsuppliername==''){

			$query6 = "select billno,locationname,locationcode,isnhif,accountnameid from print_deliverysubtype where accountnameid = '$accountnameid' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted' $loct";
	}
		
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	
 while ($res6 = mysqli_fetch_array($exec6))
 {
	
  $billno = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res6['billno']));
  $accountnameid=$res6['accountnameid'];
  $isnhif=$res6['isnhif'];
  $dis_locationcode=$res6['locationcode'];
	
  $query2 = "select * from billing_paylater where  billno = '$billno' and accountnameid = '$accountnameid' and completed <> 'completed' and (missing ='' OR missing ='missing' OR incomplete='incomplete' ) and locationcode='$dis_locationcode'  order by accountname, billdate desc";  
  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
  while ($res2 = mysqli_fetch_array($exec2))
  {
	  $res2accountname = $res2['accountname'];
  $res2patientcode = $res2['patientcode'];
  $res2visitcode = $res2['visitcode'];
  $res2billno = $res2['billno'];
  $res2totalamount = $res2['totalamount'];
  //$res2billdate = $res2['billdate'];
  $res2billdate = date("d/m/Y", strtotime($res2['billdate']));
  $res2subtype = $res2['subtype'];
  $res2patientname = $res2['patientname'] ;
  $res2accountname = $res2['accountname'];
  
 
	
   $res6billnumber = $res6['billno'];
   $locationnameget = $res6['locationname'];
   $locationcodeget = $res6['locationcode'];

   $total = $total + $res2totalamount;
  
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
         <td class="bodytext31" valign="center"  align="left"><?php echo $res21accountname; ?></td>
       <td class="bodytext31" valign="center"  align="left">
        <div class="bodytext31"><?php echo $res2patientcode; ?></div>
		</td>
      <td class="bodytext31" valign="center"  align="left">
        <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
        <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $locationnameget; ?></div></td>
      <td class="bodytext31" valign="center"  align="left"><?php echo $res2billno; ?></td>
      <td class="bodytext31" valign="center"  align="left">
	    <div align="left"><?php echo $res2billdate; ?></div></td>
      <td class="bodytext31" valign="center"  align="left">
      	<div align="right"><?php echo number_format($res2totalamount,2,'.',','); ?></div></td>
      </tr>
	<?php
	}

	if($isnhif==1)
		  {
		  	// and accountcode = '$accountnameid'
			 $query3 = "select * from billing_ipnhif where  docno = '$billno' and completed <> 'completed' and (missing ='' OR missing ='missing' OR incomplete='incomplete' ) and locationcode='$dis_locationcode' order by recorddate desc"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res3 = mysqli_fetch_array($exec3))
			  {
			  $res3accountname = 'NHIF NATIONAL SCHEAME';
			  $res3patientcode = $res3['patientcode'];
			  $res3visitcode = $res3['visitcode'];
			  $res3billno = $res3['docno'];
			  $res3subtype = 'NATIONAL HOSPITAL INSURANCE FUND-NHIF';
			  $res3totalamount = $res3['finamount'];
			  $res3billdate = date("d/m/Y", strtotime($res3['recorddate']));
			  $res3patientname = $res3['patientname'];
			  $res6billnumber = $res6['billno'];
			  
			  
			   $locationnameget1 = $res6['locationname'];
			   $locationcodeget1 = $res6['locationcode'];
			  $total = $total + $res3totalamount;
			  
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
   <tr <?php echo $colorcode; ?>>
	  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
         <td class="bodytext31" valign="center"  align="left"><?php echo $res3accountname; ?></td>
       <td class="bodytext31" valign="center"  align="left">
        <div class="bodytext31"><?php echo $res3patientcode; ?></div></td>
      <td class="bodytext31" valign="center"  align="left">
        <div class="bodytext31"><?php echo $res3patientname; ?></div></td>
       <td class="bodytext31" valign="center"  align="left">  <div class="bodytext31"><?php echo $locationnameget1; ?></div></td>
      <td class="bodytext31" valign="center"  align="left"><?php echo $res3billno; ?></td>
      <td class="bodytext31" valign="center"  align="left">
	    <div align="left"><?php echo $res3billdate; ?></div></td>
      <td class="bodytext31" valign="center"  align="left">
      	<div align="right"><?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
      </tr>
	<?php
	}
	}
	else{
  $query3 = "select * from billing_ip where  billno = '$billno' and completed <> 'completed' and accountnameid = '$accountnameid' and (missing ='' OR missing ='missing' OR incomplete='incomplete' ) and locationcode='$dis_locationcode' order by accountname, billdate desc"; 
  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
  while ($res3 = mysqli_fetch_array($exec3))
  {
	  $res3accountname = $res3['accountname'];
  $res3patientcode = $res3['patientcode'];
  $res3visitcode = $res3['visitcode'];
  $res3billno = $res3['billno'];
  $res3subtype = $res3['subtype'];
  $res3totalamount = $res3['totalamount'];
  $res3billdate =date("d/m/Y", strtotime($res3['billdate']));
  $res3patientname = $res3['patientname'];
  $res6billnumber = $res6['billno'];
  
  
   $locationnameget1 = $res6['locationname'];
   $locationcodeget1 = $res6['locationcode'];
  $total = $total + $res3totalamount;
  
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
         <td class="bodytext31" valign="center"  align="left"><?php echo $res3accountname; ?></td>
       <td class="bodytext31" valign="center"  align="left">
        <div class="bodytext31"><?php echo $res3patientcode; ?></div></td>
      <td class="bodytext31" valign="center"  align="left">
        <div class="bodytext31"><?php echo $res3patientname; ?></div></td>
         <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $locationnameget1; ?></div></td>
      <td class="bodytext31" valign="center"  align="left"><?php echo $res3billno; ?></td>
      <td class="bodytext31" valign="center"  align="left">
	    <div align="left"><?php echo $res3billdate; ?></div></td>
      <td class="bodytext31" valign="center"  align="left">
      	<div align="right"><?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
      </tr>
	<?php
	}
	}
	 $query3 = "select * from billing_ipcreditapprovedtransaction where  billno = '$billno' and accountnameid = '$accountnameid' and completed <> 'completed' and ( missing ='' OR missing ='missing' OR incomplete='incomplete') and locationcode='$dis_locationcode' order by accountname, billdate desc"; 
  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
  while ($res3 = mysqli_fetch_array($exec3))
  {
	  $res3accountname = $res3['accountname'];
  $res3patientcode = $res3['patientcode'];
  $res3visitcode = $res3['visitcode'];
  $res3billno = $res3['billno'];
   $res3subtype = $res3['subtype'];
  $res3totalamount = $res3['totalamount'];
  $res3billdate = date("d/m/Y", strtotime($res3['billdate']));
  $res3patientname = $res3['patientname'];

 
	
  $res6billnumber = $res6['billno'];
  
  
   $locationnameget2 = $res6['locationname'];
   $locationcodeget2 = $res6['locationcode'];
  $total = $total + $res3totalamount;
  
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
         <td class="bodytext31" valign="center"  align="left"><?php echo $res3accountname; ?></td>
       <td class="bodytext31" valign="center"  align="left">
        <div class="bodytext31"><?php echo $res3patientcode; ?></div></td>
      <td class="bodytext31" valign="center"  align="left">
        <div class="bodytext31"><?php echo $res3patientname; ?></div></td>
        <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $locationnameget2; ?></div></td>
      <td class="bodytext31" valign="center"  align="left"><?php echo $res3billno; ?></td>
      <td class="bodytext31" valign="center"  align="left">
	    <div align="left"><?php echo $res3billdate; ?></div></td>
      <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
      </tr>
	<?php
	}
	}
	}
	}
	}
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
        bgcolor="#ecf0f5"><strong>Total:</strong></td>
      <td class="bodytext31" valign="center"  align="left" 
        bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total,2,'.',','); ?></strong></div></td>
	  <?php if($total != 0.00) { ?>	
      <?php } ?>
	</tr>
	<?php
	}
	}
	?>
  </tbody>
</table>