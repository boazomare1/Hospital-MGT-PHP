<?php
session_start();
//error_reporting(0);
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
//if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1emailid1= $res1['emailid1'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];

ob_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="DeliveryReport.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }


?>
<style>
body {
	font-family: 'Arial';
	font-size: 11px;
}
#footer {
	position: fixed;
	left: 0px;
	bottom: -20px;
	right: 0px;
	height: 150px;
}
#footer .page:after {
	content: counter(page, upper-roman);
}
#delivery {
	min-height: 500px;
}
.page {
	page-break-after: always;
	clear:both;
	min-height:800px;
}
.fontsize{font-size:16px; font-weight:bold;}
</style>
<?php //include("a4pdfheader1.php"); ?>

<table width="100%" border="" align="center" class="page">
    <?php
	$query31 = "select * from completed_billingpaylater where printno = '$printno' ";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 = mysqli_fetch_array($exec31);
	
	$subtype = $res31['subtype'];
	$locationnameget = $res31['locationname'];
	?>
    <tr>
      <td colspan="10" align="left"><strong><?php echo $subtype; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Location : <?php echo $locationnameget?></b></td>
    </tr>
	<tr>
      <td colspan="6" align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
      <td colspan="2" align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Treatment Dates</strong></div></td>
      <td colspan="2" align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> &nbsp; </strong></td>
	</tr>
    <tr>
      <td  align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Member No </strong></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> D.O.B</strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>From Date </strong></div></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>To Date </strong></div></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor</strong></div></td>
  </tr>
   <tr>
      <td colspan="6" align="center" class="fontsize"><strong>Delivered Invoices</strong></td>
    </tr>
	<?php
	$queryloc = "select locationname,locationcode from master_location where status <> 'deleted'";
	$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resloc = mysqli_fetch_array($execloc);
	$locshow=0;
		$locationcodecheck = $resloc['locationcode'];
		$locationnamecheck = $resloc['locationname'];
   ?>
	<tr class="delivery">
      <td colspan="10" align="center"><strong><?php echo $locationnamecheck;?></strong></td>
    </tr>
    <?php
	$totalamount = '0.00';
	$query3 = "select * from completed_billingpaylater where printno = '$printno' group by accountname ORDER BY patientname ASC";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3 = mysqli_fetch_array($exec3))
	{
		$res3accountname = $res3['accountname'];
	?>
    <tr>
      <td colspan="10" align="left"><strong><?php echo $res3accountname; ?></strong></td>
    </tr>
    <?php
	$queryloc = "select locationname,locationcode from master_location where status <> 'deleted'";
	$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resloc = mysqli_fetch_array($execloc))
	{$locshow=0;
		$locationcodecheck = $resloc['locationcode'];

	$query2 = "select * from completed_billingpaylater where locationcode = '".$locationcodecheck."' and printno = '$printno' and accountname = '$res3accountname' and completed = 'completed' ORDER BY patientname ASC";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
		 $locationcodecheck = $resloc['locationcode'];
		 $locationnamecheck = $resloc['locationname'];
		 
		$patientcode = $res2['patientcode'];
		$patientname = $res2['patientname'];
		$billno = $res2['billno'];
		$billdate = $res2['billdate'];
		$amount = $res2['totalamount'];
		$accountname = $res2['accountname'];
		$subtype = $res2['subtype'];
		$visitcode = $res2['visitcode'];
		
		$query7 = "select a.consultationdate as consultationdate, a.consultingdoctor as consultingdoctor,a.memberno from `master_visitentry` AS a where a.visitcode = '$visitcode'";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res7 = mysqli_fetch_array($exec7);
		$consultationdate = $res7['consultationdate'];
		$consultingdoctor = $res7['consultingdoctor'];
		$memberno = $res7['memberno'];
		
		$query8 = "select dateofbirth,mrdno from `master_customer` where customercode = '$patientcode'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res8 = mysqli_fetch_array($exec8);
		$dateofbirth = $res8['dateofbirth'];
		//$mrdno = $res8['mrdno'];
		
	$totalamount = $totalamount + $amount;
	
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	else
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	   $locshow=$locshow+1;
	?>
    <?php if($locshow==1) {?>
    <!--<tr class="delivery">
      <td colspan="6" align="left"><strong><?php //echo $locationnamecheck;?></strong></td>
    </tr>-->
    <?php }?>
    <tr <?php echo $colorcode; ?> class="page">
      <td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
      <td align="left" class="bodytext3"><?php echo $patientcode; ?></td>
      <td align="left" class="bodytext3"><?php echo $patientname; ?></td>
      <td align="left" class="bodytext3"><?php echo $billno; ?></td>
	   <td align="left" class="bodytext3"><?php echo $memberno; ?></td>
	    <td align="left" class="bodytext3"><?php echo $dateofbirth; ?></td>
		 <td align="left" class="bodytext3"><?php echo $consultationdate; ?></td>
      <td align="left" class="bodytext3"><?php echo $billdate; ?></td>
      <td align="right" class="bodytext3"><?php echo $amount; ?></td>
	  <td align="left" class="bodytext3"><?php echo $consultingdoctor; ?></td>
    </tr>
    <?php
	 $locshow=$locshow+1;
	}
	}
	}
	?>
</table>
    <table width="100%" border="" align="center" class="page">
    <tr>
      <td colspan="10" align="left" class="fontsize"><strong>Missing Invoices</strong></td>
    </tr>
    <tr>
      <td  align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Member No </strong></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> D.O.B</strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>From Date </strong></div></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>To Date </strong></div></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor</strong></div></td>
  </tr>
    <?php	
	
	$queryloc = "select locationname,locationcode from master_location where status <> 'deleted'";
	$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resloc = mysqli_fetch_array($execloc))
	{
		$locshow=0;
		 $locationcodecheck = $resloc['locationcode'];
	$query2 = "select * from completed_billingpaylater where  locationcode = '".$locationcodecheck."' and printno = '$printno' and accountname = '$res3accountname' and missing ='missing' ORDER BY patientname ASC";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
		 $locationcodecheck = $resloc['locationcode'];
		 $locationnamecheck = $resloc['locationname'];
		
		$patientcode = $res2['patientcode'];
		$patientname = $res2['patientname'];
		$billno = $res2['billno'];
		$billdate = $res2['billdate'];
		$amount = $res2['totalamount'];
		$accountname = $res2['accountname'];
		$subtype = $res2['subtype'];
		$visitcode = $res2['visitcode'];
		
		$query7 = "select a.consultationdate as consultationdate, a.consultingdoctor as consultingdoctor from `master_visitentry` AS a where a.visitcode = '$visitcode'";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res7 = mysqli_fetch_array($exec7);
		$consultationdate = $res7['consultationdate'];
		$consultingdoctor = $res7['consultingdoctor'];
		
		$query8 = "select dateofbirth,mrdno from `master_customer` where customercode = '$patientcode'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res8 = mysqli_fetch_array($exec8);
		$dateofbirth = $res8['dateofbirth'];
		$mrdno = $res8['mrdno'];
	
	$totalamount = $totalamount + $amount;
	
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	
	
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	else
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	  $locshow=$locshow+1;
	?>
    <?php if($locshow==1) {?>
    <tr>
      <td colspan="6" align="left"><strong><?php echo $locationnamecheck;?></strong></td>
    </tr>
    <?php }?>
    <tr <?php echo $colorcode; ?> class="page">
      <td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
      <td align="left" class="bodytext3"><?php echo $patientcode; ?></td>
      <td align="left" class="bodytext3"><?php echo $patientname; ?></td>
      <td align="left" class="bodytext3"><?php echo $billno; ?></td>
	   <td align="left" class="bodytext3"><?php echo $mrdno; ?></td>
	    <td align="left" class="bodytext3"><?php echo $dateofbirth; ?></td>
		 <td align="left" class="bodytext3"><?php echo $consultationdate; ?></td>
      <td align="left" class="bodytext3"><?php echo $billdate; ?></td>
      <td align="right" class="bodytext3"><?php echo $amount; ?></td>
	  <td align="left" class="bodytext3"><?php echo $consultingdoctor; ?></td>
    </tr>
    <?php
	$locshow=$locshow+1;
	}
	}
	?>
    </table>
    <table width="100%" border="" align="center" class="page">
    <tr>
      <td colspan="10" align="left"  class="fontsize"<strong>Incomplete Invoices</strong></td>
    </tr>
	<tr>
      <td  align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> Member No </strong></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><strong> D.O.B</strong></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>From Date </strong></div></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>To Date </strong></div></td>
      <td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
	<td align="left" valign="center"  
	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor</strong></div></td>
  </tr>
    <?php	
	$queryloc = "select locationname,locationcode from master_location where status <> 'deleted'";
	$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resloc = mysqli_fetch_array($execloc))
	{
		$locshow=0;
		 $locationcodecheck = $resloc['locationcode'];
		 
	$query2 = "select * from completed_billingpaylater where locationcode = '".$locationcodecheck."' and printno = '$printno' and accountname = '$res3accountname' and incomplete = 'incomplete' ORDER BY patientname ASC";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
		$locationcodecheck = $resloc['locationcode'];
		$locationnamecheck = $resloc['locationname'];
		 
		$patientcode = $res2['patientcode'];
		$patientname = $res2['patientname'];
		$billno = $res2['billno'];
		$billdate = $res2['billdate'];
		$amount = $res2['totalamount'];
		$accountname = $res2['accountname'];
		$subtype = $res2['subtype'];
		$visitcode = $res2['visitcode'];
		
		$query7 = "select a.consultationdate as consultationdate, a.consultingdoctor as consultingdoctor from `master_visitentry` AS a where a.visitcode = '$visitcode'";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res7 = mysqli_fetch_array($exec7);
		$consultationdate = $res7['consultationdate'];
		$consultingdoctor = $res7['consultingdoctor'];
		
		$query8 = "select dateofbirth,mrdno from `master_customer` where customercode = '$patientcode'";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res8 = mysqli_fetch_array($exec8);
		$dateofbirth = $res8['dateofbirth'];
		$mrdno = $res8['mrdno'];
	
	$totalamount = $totalamount + $amount;
	
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	else
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	  $locshow=$locshow+1;
	?>
    <?php if($locshow==1) {?>
    <tr>
      <td colspan="6" align="left"><strong><?php echo $locationnamecheck;?></strong></td>
    </tr>
    <?php }?>
    <tr <?php echo $colorcode; ?> class="page">
      <td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
      <td align="left" class="bodytext3"><?php echo $patientcode; ?></td>
      <td align="left" class="bodytext3"><?php echo $patientname; ?></td>
      <td align="left" class="bodytext3"><?php echo $billno; ?></td>
	   <td align="left" class="bodytext3"><?php echo $mrdno; ?></td>
	    <td align="left" class="bodytext3"><?php echo $dateofbirth; ?></td>
		 <td align="left" class="bodytext3"><?php echo $consultationdate; ?></td>
      <td align="left" class="bodytext3"><?php echo $billdate; ?></td>
      <td align="right" class="bodytext3"><?php echo $amount; ?></td>
	  <td align="left" class="bodytext3"><?php echo $consultingdoctor; ?></td>
    </tr>
    <?php
	 $locshow=$locshow+1;
	}}
	
	?>
    <tr>
      <td colspan="9" align="right" class="bodytext3"><strong>Total :</strong></td>
      <td align="right" class="bodytext3"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
    </tr>
</table>

<table width="100%" border="0" align="center" id="footer" cellpadding="4" cellspacing="0">
  
    <tr>
      <td align="left"><strong>Despatching Officer</strong></td>
      <td align="right"><strong>Receiving Officer</strong></td>
    </tr>
</table>