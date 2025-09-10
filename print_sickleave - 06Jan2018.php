<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$dateonly2 = date('Y-m-d');
$username = $_SESSION["username"];
$docno = $_SESSION["docno"];
$timeonly = date('H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$errmsg = "";
$res2sickoffnumber ='';

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if(isset($_REQUEST['patientcode'])) {$patientcode=$_REQUEST['patientcode']; } else{$patientcode="";}
if(isset($_REQUEST['visitcode'])) {$visitcode = $_REQUEST['visitcode']; } else{$visitcode="";}

ob_start();

$locationquery="select locationcode from login_locationdetails where username='$username'  and docno='$docno'";
$exeloc=mysqli_query($GLOBALS["___mysqli_ston"], $locationquery);
$resloc=mysqli_fetch_array($exeloc);
$loginlocation=$resloc['locationcode'];

$logindetail="select * from master_location where locationcode='$loginlocation'";
$exeloc1=mysqli_query($GLOBALS["___mysqli_ston"], $logindetail);
$resloc1=mysqli_fetch_array($exeloc1);
$locationname=$resloc1['locationname'];
 $address=$resloc1['address1'];
 $phonenumber1 = $resloc1["phone"];
$phoneno=$resloc1['phone'];
$email=$resloc1['email'];


$query2 = "select * from sickleave_entry where patientcode = '$patientcode' and visitcode='$visitcode' order by auto_number desc ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$num=mysqli_num_rows($exec2);

$res2patientcode = $res2['patientcode'];
$res2visitcode = $res2['visitcode'];
$res2patientname = $res2['patientname'];
$res2recorddate = $res2['recorddate'];
$res2fromdate = $res2['fromdate'];
$res2todate = $res2['todate'];
$res2nodays1= $res2['nodays1'];
$res2nodays2= $res2['nodays2'];
$res2work= $res2['work'];
$res2sicktype= $res2['sicktype'];
$res2sickoffnumber= $res2['sickoffnumber'];
$res2fromreview= $res2['fromreview'];
$res2toreview= $res2['toreview'];
$res2fromduty= $res2['fromduty'];
$res2toduty= $res2['toduty'];
$res2remarks= $res2['remarks'];
$res2recorddate= $res2['recorddate'];
$res2recordtime= $res2['recordtime'];
$res2preparedby=$res2['preparedby'];
$res2res2patientname = strtoupper($res2patientname);




$query33= "select consultationdate from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'" ;
$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
$res33 = mysqli_fetch_array($exec33);

$res33registrationdate=$res33['consultationdate'];

		$query1 = "select * from master_company where auto_number = '$companyanum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$res1companyname = $res1['companyname'];
		$res1address1 = $res1['address1'];
		$res1area = $res1['area'];
		$res1city = $res1['city'];
		$res1state = $res1['state'];
		$res1country = $res1['country'];
		$res1pincode = $res1['pincode'];
	    $res1emailid = $res1["emailid1"];
		$res1phonenumber1 = $res1['phonenumber1'];
		
$employeedetails="select employeename from master_employee where username='$res2preparedby'";
$exeemp=mysqli_query($GLOBALS["___mysqli_ston"], $employeedetails);
$resemp=mysqli_fetch_array($exeemp);
$employeefullname=$resemp['employeename'];
		?>


<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #3b3b3c; 
}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 16px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
body {
	border:2px;
	background-color: #ecf0f5;
}
</style>


<body>
<br /><br />
<table align="center" style="border-top:2px; border-bottom:2px; border-left:2px; border-right:2px;">
<tr><td colspan="5">&nbsp;</td></tr>
<tr>
<td width="644">
<?php include("print_header.php");
?>
</td>
</tr>
<tr>
<td>
<table width="642" cellpadding="10" cellspacing="2">
<tr>
<td colspan="5"class="bodytext365">&nbsp;
</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr>
  <td width="42"class="bodytext365">Date:</td><td width="400"class="bodytext365"><?= $res33registrationdate;?></td><td width="70"class="bodytext365"><strong>Serial No.</strong></td><td width="25" class="bodytext365"><strong><?=$res2sickoffnumber;?></strong></td></tr>
<tr><td>&nbsp;</td></tr><tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5" class="bodytext365"><strong>To Whom It May Concern</strong></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td width="42" class="bodytext365">Re:</td><td  colspan="3" class="bodytext365"><?=$res2patientname;?></td></tr>
<tr><td>&nbsp;</td></tr><tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5" class="bodytext365">The above named patient was seen at  
  <?=$locationname;?> on <?= $res33registrationdate; ?>.</td>
</tr>
<tr><td>&nbsp;</td></tr><tr><td colspan="5">&nbsp;</td></tr>
<?php if($res2fromdate <> '' && $res2fromdate <> '0000-00-00')
{?>
<tr><td colspan="5"class="bodytext365">He/She is allow sick leave regular duties from <?=$res2fromdate;?> to <?= $res2todate; ?>.</td></tr>
<tr><td>&nbsp;</td></tr><tr><td colspan="5">&nbsp;</td></tr>
<?php } ?>
<?php if($res2fromduty <> '' && $res2fromduty <> '0000-00-00')
{?>
<tr><td colspan="5"class="bodytext365"><strong>Light duty is recommended from</strong>
<?=$res2fromduty;?> <strong>to</strong>
<?= $res2toduty; ?>.</td></tr>
<tr><td>&nbsp;</td></tr><tr><td colspan="5">&nbsp;</td></tr>
<?php } ?>
<?php if($res2fromreview <> '' && $res2fromreview <> '0000-00-00')
{?>
<tr><td colspan="5"class="bodytext365">A follow up appoinment is recommended on <?=$res2fromreview;?>.</td></tr>
<?php } ?>
</table>
</td>
</tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5" align="left" class="bodytext365">Signed:</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5"align="left" class="bodytext365"><?=$employeefullname;?></td></tr>
<tr><td colspan="5">&nbsp;</td></tr>





</table>
</body>
<?php

    $content = ob_get_clean();
	ob_end_clean();
//ob_flush();
    // convert in PDF
//	ob_stop();
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Times');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printsickleave.pdf');
    }
    catch(HTML2PDF_exception $e) {
      echo $e;
        exit;
    }
?>
