<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");

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
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; text-decoration:none
}
</style>

	  <table width="700" border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td colspan="15" align="left" valign="center" 
				class="bodytext31">&nbsp;</td>
			</tr>
			<?php 
			$query2 = "select * from master_company where auto_number = '$companyanum'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$companyname = $res2["companyname"];
			$address1 = $res2["address1"];
			$address2 = $res2["address2"];
			$area = $res2["area"];
			$city = $res2["city"];
			$pincode = $res2["pincode"];
			$phonenumber1 = $res2["phonenumber1"];
			$phonenumber2 = $res2["phonenumber2"];
			$tinnumber1 = $res2["tinnumber"];
			$cstnumber1 = $res2["cstnumber"];
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>	
            <tr>
              <td colspan="15" align="left" valign="center" 
                 class="bodytext31"><div align="center"><strong><?php echo $companyname; ?></strong></div></td>
            </tr>
            <tr>
              <td colspan="15" align="left" valign="center" 
                 class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td width="15" align="left" valign="center" 
                 class="bodytext31"><strong>No.</strong></td>
				<td width="160" align="left" valign="center"  
                 class="bodytext31"><strong>Patient Name </strong></td>
				<td width="52" align="left" valign="center"  
                 class="bodytext31"><strong>Reg. No. </strong></td>
                <td width="50" align="left" valign="center"  
                 class="bodytext31"><strong>Visit No </strong></td>
                <td width="20" align="left" valign="center"  
                 class="bodytext31"><strong>Age</strong></td>
                <td width="44" align="left" valign="center"  
                 class="bodytext31"><strong>Gender</strong></td>
                <td width="56" align="left" valign="center"  
                 class="bodytext31"><strong>DOA</strong></td>
                <td width="60"  align="left" valign="center" 
                 class="bodytext31"><strong>DOD</strong></td>
				<td width="30"  align="left" valign="center" 
                 class="bodytext31"><strong>HDS</strong></td>
                <td  width="80"  align="left" valign="center" 
                 class="bodytext31"><strong>Diagnosis</strong></td>
                <td  width="80"  align="left" valign="center" 
                 class="bodytext31"><strong>Procedure</strong></td>
                <td  width="60"  align="left" valign="center" 
                 class="bodytext31"><strong>DOP</strong></td>
                <td  width="42"  align="left" valign="center" 
                 class="bodytext31"><strong>Weight</strong></td>
                <td  width="112"  align="left" valign="center" 
                 class="bodytext31"><strong>Notification</strong></td>
                <td  width="112"  align="left" valign="center" 
                 class="bodytext31"><strong>Condition</strong></td>
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
            <tr>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $patientname; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $patientcode; ?></td>
				<td class="bodytext31" valign="center" align="left"><?php echo $visitcode; ?></td>
				<td class="bodytext31" valign="center" align="left"><?php echo $age; ?></td>
				<td class="bodytext31" valign="center" align="left"><?php echo $gender; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res3recorddate; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res2consultationdate; ?></td>
				<td class="bodytext31" valign="center"  align="left">
				  <?php if($res2consultationdate = '') { echo $todate; } else { if($totaldays == '0') { echo '1'; } else { echo $totaldays; }}?>			    </td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res4diagnosis; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res4procedure; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res4dop; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res4weightofbaby; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res4notification; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res4condition; ?></td>
        </tr>
			<?php
			}
			?>
			  <?php 
			  }
			 // }
			 ?>
</table>
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('maternityreport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>