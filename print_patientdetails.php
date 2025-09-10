<?php
session_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ippatientdetails.xls"');
header('Cache-Control: max-age=80');

//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = '';
$companyanum = '';
$companyname = '';
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if(isset($_REQUEST['patient'])){$searchpatient = $_REQUEST['patient'];}else{$searchpatient="";}
if(isset($_REQUEST['patientcode'])){$searchpatientcode=$_REQUEST['patientcode'];}else{$searchpatientcode="";}
if(isset($_REQUEST['visitcode'])){ $searchvisitcode = $_REQUEST['visitcode'];}else{$searchvisitcode="";}
if(isset($_REQUEST['ADate1'])){ $fromdate = $_REQUEST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_REQUEST['ADate2'])){$todate = $_REQUEST['ADate2'];}else{$todate=$transactiondateto;}
 $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

?>
<style type="text/css">

.num {
  mso-number-format:General;
}
.text{
  mso-number-format:"\@";/*force text*/
  
}
<!--
body {
	
	background-color: #FFFFFF;
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

<body>
       <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1310" 
            align="left" border="0">
           
          <tbody>
           <tr>

           <td width="154" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Patient Name</strong></td>
           <td width="102" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Patientcode</strong></td>
           <td width="106" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Visitcode</strong></td>
           <td width="91" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Bill No.</strong></td>
           <td width="118" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Date of admission</strong></td>
           <td width="120" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Date of discharge</strong></td>
           <td width="125" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Ward</strong></td>
           <td width="165" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Account Name</strong></td>
           <td width="129" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Total Amount</strong></td>
           <td width="120" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Amount Allocated</strong></td>
           </tr>
           
           <?php
		   $scount=0;
		   $colorloopcount=0;
            $patientdetails="select patientcode,visitcode,patientname,billno,totalamount,accountname from billing_ipcreditapproved where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and billdate between '$fromdate' and '$todate' and locationcode='$locationcode' group by visitcode order by auto_number desc";
		   $exepatient=mysqli_query($GLOBALS["___mysqli_ston"], $patientdetails) or die("Error in patientdetails".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $numrow=mysqli_num_rows($exepatient);
		   while($respatient=mysqli_fetch_array($exepatient))
		   {
			   $patientcode=$respatient['patientcode'];
			   $visitcode=$respatient['visitcode'];
			  
			   $patientname=$respatient['patientname'];
			   $billnum=$respatient['billno'];
			    $totalamount=$respatient['totalamount'];
			    $accountname=$respatient['accountname'];
			   
			   $admission=mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode='$visitcode' order by auto_number asc")or die("Error in admission".mysqli_error($GLOBALS["___mysqli_ston"]));
			   $resdata=mysqli_fetch_array($admission);
			   $dateofaddmission=$resdata['recorddate'];
			   
			   $discharge=mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_discharge where visitcode='$visitcode' group by visitcode")or die("Error in discharge".mysqli_error($GLOBALS["___mysqli_ston"]))or die("Error in discharge".mysqli_error($GLOBALS["___mysqli_ston"]));
			   $resdis=mysqli_fetch_array($discharge);
			   $dischargedate=$resdis['recorddate'];
			   
			   $warddetails=mysqli_query($GLOBALS["___mysqli_ston"], "select ward from master_ward where auto_number in(select ward from ip_bedallocation where visitcode='$visitcode' and recordstatus not in('transfered')) order by auto_number desc")or die("Error in warddetails".mysqli_error($GLOBALS["___mysqli_ston"]));
			   $resward=mysqli_fetch_array($warddetails);
			   $wardname=$resward['ward'];
			   if($wardname=='')
			   {
				 $warddetails=mysqli_query($GLOBALS["___mysqli_ston"], "select ward from master_ward where auto_number in(select ward from ip_bedtransfer where visitcode='$visitcode' and recordstatus not in('transfered')) order by auto_number desc")or die("Error in warddetails".mysqli_error($GLOBALS["___mysqli_ston"]));
			   $resward=mysqli_fetch_array($warddetails);
			   $wardname=$resward['ward'];   
			   }
			   
			   $payment="select receivableamount,transactionamount,accountname from master_transactionpaylater where visitcode='$visitcode' and transactionamount<>'0' and acc_flag='0' and recordstatus='allocated' and billnumber='$billnum' order by auto_number desc";
			   $exepay=mysqli_query($GLOBALS["___mysqli_ston"], $payment)or die("Error in payment".mysqli_error($GLOBALS["___mysqli_ston"]));
			    $paidamount='0';
			   while($respay=mysqli_fetch_array($exepay))
			   {
				  
				   $paidamount +=$respay['transactionamount'];
				  
			   }
				   $scount=$scount+1;
				
		?>
        <tr >
          
           <td align="left" valign="middle"   class="bodytext3"><?=$patientname;?></td>
           <td align="left" valign="middle"  class="bodytext3"><?=$patientcode;?></td>
           <td align="left" valign="middle"  class="bodytext3"><?=$visitcode;?></td>
            <td align="left" valign="middle"  class="bodytext3"><?=$billnum;?></td>
           <td align="left" valign="middle"   class="bodytext3"><?=$dateofaddmission;?></td>
           <td align="left" valign="middle"   class="bodytext3"><?=$dischargedate;?></td>
           <td align="left" valign="middle"   class="bodytext3"><?=$wardname;?></td>
            <td align="left" valign="middle"   class="bodytext3"><?=$accountname;?></td>
           <td align="left" valign="middle"  class="bodytext3"><?=number_format($totalamount,2,'.',',');?></td>
           <td align="left" valign="middle"   class="bodytext3"><?=number_format($paidamount,2,'.',',');?></td>
           </tr>  
			   <?php
             
			   
		   }
		   
		   
		   ?>
           
            
          </tbody>
         
        </table>
</body>
</html>
