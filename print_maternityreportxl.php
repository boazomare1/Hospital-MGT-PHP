<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="maternityreport.xls"');
header('Cache-Control: max-age=80');

$grandtotal = '0.00';
$searchcustomername = '';
$patientfirstname = '';
$visitcode = '';
$customername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$customername = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$visitcode1='';
$res2username ='';
$custname = '';
$colorloopcount = '';
$sno = '';
$customercode = '';

//$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
//$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
if (isset($_REQUEST["ADate1"])) { $transactiondatefrom = $_REQUEST["ADate1"]; } else { $transactiondatefrom = ""; }
if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; } else { $transactiondateto = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')
{
	$query4 = "select * from master_customer where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbcustomername = $res4['customername'];
	$customername = $res4['customername'];
}
?>
<style>
.xlText {
    mso-number-format: "\@";
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
<table border="0" width="1278">

<tr>
<td colspan="5"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Maternity Report: </strong><?php echo $transactiondatefrom; ?> To <?php echo $transactiondateto; ?></td>
 </tr>
<tr>
<td colspan="6">&nbsp;</td>
  </tr>
 <tr>
 <td>&nbsp;</td>
 <td>
  <table width="1278" border="1" cellspacing="0" cellpadding="2">
            
            
            <tr>
              <td width="36"  align="left" valign="center" 
                 class="bodytext31"><div align="left"><strong>No.</strong></div></td>
				<td width="154" align="right" valign="center"  
                 class="bodytext31"><div align="left"><strong>Patient Name </strong></div></td>
				<td width="146" align="right" valign="center"  
                 class="bodytext31"><div align="left"><strong>Reg. No. </strong></div></td>
                <td width="127" align="right" valign="center"  
                 class="bodytext31"><div align="left"><strong>IP Visit No </strong></div></td>
                <td width="127" align="right" valign="center"  
                 class="style1"><div align="left">Age</div></td>
                <td width="127" align="right" valign="center"  
                 class="style1"><div align="left">Gender</div></td>
                <td width="114" align="right" valign="center"  
                 class="bodytext31"><div align="left"><strong> DOA </strong></div></td>
                <td width="134"  align="right" valign="center" 
                 class="bodytext31"><div align="left"><strong> DOD </strong></div></td>
				<td  width="147"  align="right" valign="center" 
                 class="bodytext31"><div align="left"><strong>HDS</strong></div></td>
                <td  width="147"  align="right" valign="center" 
                 class="bodytext31"><div align="left"><strong>Diagnosis</strong></div></td>
                <td  width="147"  align="right" valign="center" 
                 class="bodytext31"><div align="left"><strong>Procedure</strong></div></td>
                <td  width="147"  align="right" valign="center" 
                 class="bodytext31"><div align="left"><strong>DOP</strong></div></td>
                <td  width="147"  align="right" valign="center" 
                 class="bodytext31"><div align="left"><strong>Weight</strong></div></td>
                <td  width="147"  align="right" valign="center" 
                 class="bodytext31"><div align="left"><strong>Notification</strong></div></td>
                <td  width="147"  align="right" valign="center" 
                 class="bodytext31"><div align="left"><strong>Condition</strong></div></td>
           </tr>		
				<?php
				$colorloopcount=0;
				$sno=0;
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_POST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
				$fromdate=$_REQUEST['ADate1'];
				$todate=$_REQUEST['ADate2'];
		
		$query1 = "select * from ip_discharge where recorddate between '$fromdate' and '$todate' order by auto_number desc";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		$res2consultationdate=$res1['recorddate'];
	    $docnumber=$res1['docno'];
		
        $query2 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'  ";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);
		$res2registrationdate=$res2['registrationdate'];
		$age=$res2['age'];
		$gender=$res2['gender'];
		
		$query3 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' ";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_num_rows($exec3);
		$res3 = mysqli_fetch_array($exec3);
		$res3recorddate=$res3['recorddate'];
		
		$query4 = "select * from ip_progressnotes where patientcode='$patientcode' and visitcode='$visitcode' ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num4=mysqli_num_rows($exec4);
		$res4 = mysqli_fetch_array($exec4);
		$res4diagnosis=$res4['diagnosis'];
		$res4procedure=$res4['procedure1'];
		$res4dop=$res4['dop'];
		$res4weightofbaby=$res4['weightofbaby'];
		$res4notification=$res4['notification'];
		$res4condition=$res4['condition1'];
		$res4recorddate=$res4['recorddate'];
        
		$consultationdate = strtotime($res2consultationdate);
        $registrationdate   = strtotime($res3recorddate);
        $totaldays = ceil(($consultationdate - $registrationdate) / 86400);
			?>
            <tr >
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $patientcode; ?></div></td>
              <td class="bodytext31" valign="center" style="mso-number-format:"0\.000" " align="right"><div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center" style="mso-number-format:"0\.000" " align="right"><div align="left"><?php echo $age; ?></div></td>
              <td class="bodytext31" valign="center" style="mso-number-format:"0\.000" " align="right"><div align="left"><?php echo $gender; ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $res3recorddate; ?></div></td>
              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $res2consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="right"><div align="left">
				  <?php if($res2consultationdate = '') { echo $todate; } else { if($totaldays == '0') { echo '1'; } else { echo $totaldays; }}?>
			    </div></td>
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $res4diagnosis; ?></div></td>
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $res4procedure; ?></div></td>
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $res4dop; ?></div></td>
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $res4weightofbaby; ?></div></td>
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $res4notification; ?></div></td>
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $res4condition; ?></div></td>
        </tr>
			<?php
			}
			?>
			  
		
			  <tr>
			    <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"></td>
			
              <td colspan="2" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff">&nbsp;</td>
				<td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	            <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	            <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	            <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	            <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	            <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	    </tr>
			  <?php 
			  }
			 // }
			 ?>
</table> </td>
</table>
