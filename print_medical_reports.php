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

if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
if (isset($_REQUEST["search_type"])) { $search_type = $_REQUEST["search_type"]; } else { $search_type = ""; }

$table_name='';
if($search_type=='medical'){
$table_name='medical_report';
}
else if($search_type=='birth'){
$table_name='birth_notification';
}
else if($search_type=='death'){
$table_name='death_notification';
}
if($table_name==''){
exit;
}
	
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


$query2 = "select * from $table_name where docno='$docnumber' order by auto_number desc ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$num=mysqli_num_rows($exec2);

$res2patientcode = $res2['patientcode'];
$dnumber = $res2['docno'];
$res2patientname = $res2['patientname'];
$res2recorddate= $res2['record_date'];
$res2recordtime= $res2['record_time'];
$res2preparedby=$res2['doctor_code'];
$body_content=$res2['body_content'];
$address=$res2['address'];
$res2res2patientname = strtoupper($res2patientname);


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
		
$employeedetails="select doctorname from master_doctor where doctorcode='$res2preparedby'";
$exeemp=mysqli_query($GLOBALS["___mysqli_ston"], $employeedetails);
$resemp=mysqli_fetch_array($exeemp);
$employeefullname=$resemp['doctorname'];
		
		$res2fromdate='2016-01-01';
		$res2fromduty='a';
		$res2fromreview='b';
		?>


<style type="text/css">



.bodytext27 {FONT-WEIGHT: bold; FONT-SIZE: 22px; COLOR: #000000; 

}



.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; 

}





body {

	margin:0 auto; 

	width:100%;

	background-color: #FFFFFF;

	font-family:Arial, Helvetica, sans-serif;

}



.page{

    width: 612px; 

    height: 792px; 

    overflow: hidden; 

    position: relative; 

    page-break-after: always;

}

.last-page{

   width: 612px; 

   height: 792px; 

   overflow: hidden; 

   position: relative; 

  

 }

.txt {
  text-decoration: red underline;
}

</style>


<body>

<table align="center" >
<tr>
<td >
<?php include("print_header.php");
?>
</td>
</tr>
<tr><td colspan="5"><hr ></td></tr>
<tr><td colspan="5" align='center'><span class='bodytext27 txt'>Medical Report</span></td></tr>
<tr>
<td>
<table width="520" border="0" cellspacing="0" cellpadding="2" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;"  valign='top' >
<tr><td colspan="5">&nbsp;</td></tr>
<tr>
  <td width="39"class="bodytext365"><strong>Date:</strong></td>
  <td width="397"class="bodytext365"><strong><?= $res2recorddate;?></strong></td>
  <td width="40" class="bodytext365"><!--<strong>No.</strong>--></td>
  <td width="74" class="bodytext365"><!--<strong><?=$dnumber;?></strong>--></td>
</tr>

<tr><td colspan="5">&nbsp;</td></tr>
<tr><td width="39" class="bodytext365"><strong>Re:</strong></td>
<td  colspan="3" class="bodytext365"><strong><?=$res2patientname;?></strong></td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5"class="bodytext365"><?php
$body_content = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $body_content);
		$body_content = preg_replace("/<p[^>]*?>/", "", $body_content);
        $body_content = str_replace("</p>", "<br/>", $body_content);
        $newcontent = str_replace("</pre>", "<br/>", $newcontent);

echo $body_content;?></td></tr>
</table>
</td>
</tr>
<tr><td colspan="5">&nbsp;</td></tr>

<tr><td colspan="5">&nbsp;</td></tr>

<tr><td colspan="5">&nbsp;</td></tr>

<tr><td colspan="5" align="left" class="bodytext365"><strong>Signed:</strong></td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5"align="left" class="bodytext365"><strong><?=$employeefullname;?></strong></td></tr>

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
