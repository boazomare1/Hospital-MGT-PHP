<?php
session_start();
ini_set('max_execution_time', 3000);
ini_set('memory_limit','-1');
error_reporting(1);
include ("db/db_connect.php");

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if(isset($_REQUEST['locationcode'])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }


$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$docno=$_SESSION["docno"];
ob_start();


$query2 = "select * from master_location where locationcode = '$locationcode'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$address1 = $res2["address1"];

$address2 = $res2["address2"];

$emailid1 = $res2["email"];

$phonenumber1 = $res2["phone"];

$locationcode = $res2["locationcode"];
$locationname = $res2["locationname"];

?>
<style type="text/css">
body {
    font-family: Verdana, sans-serif; 
	font-size:13px;
	font-weight:100; 
	 text-align: justify;
}
.bodytext31{ font-size:13px; }
.bodytext312{ font-size:9px; }
.bodytext27{ font-size:12px; }
#footer { position: fixed; left: 0px; bottom: 110px; right: 0px; height: 30px; }
#footer .page:after { content: counter(page, upper-roman); }
.style1 {
		font-weight: 800;
}
.test  td{
border:1px solid #CCC;
}
.page_footer
{
	font-family: Arial;
	text-align:center;
	font-weight:bold;
	margin-bottom:50px;
	
}
</style>
<head>
<title>BLOOD TRANFUSION OBSERVATION CHART</title>
</head>
<div pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">
<?php
$query1 = "select patientfullname,age,gender from master_ipvisitentry where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num1=mysqli_num_rows($exec1);
while($res1 = mysqli_fetch_array($exec1))
{	
	$patientname=$res1['patientfullname'];
	$age=$res1['age'];
	$gender=$res1['gender'];

	$ward ='';
			$bed ='';
			 $query592 = "select ward,bed from ip_bedtransfer where patientcode = '$patientcode' and visitcode = '$visitcode'  order by auto_number desc limit 0, 1";
			$exec592 = mysqli_query($GLOBALS["___mysqli_ston"], $query592) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res592 = mysqli_fetch_array($exec592);
			$num592 = mysqli_num_rows($exec592);
			if($num592 > 0)
			{
				$ward = $res592['ward'];
				$bed = $res592['bed'];
			}
			else{
                $query592 = "select ward,bed from ip_bedallocation where patientcode = '$patientcode' and visitcode = '$visitcode' order by auto_number desc limit 0, 1";
				$exec592 = mysqli_query($GLOBALS["___mysqli_ston"], $query592) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res592 = mysqli_fetch_array($exec592);
				$ward = $res592['ward'];
				$bed = $res592['bed'];
			}

			$query3_0121 = "select * from master_ward where auto_number = '$ward'";
						$exec3_0121 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0121) or die ("Error in Query3_0121".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res3_0121 = mysqli_fetch_array($exec3_0121)){
                          
							$ward_name = $res3_0121['ward'];
							
						}

?>
<table width="520" border="0" cellspacing="0" cellpadding="3" >
	     <tr>
			<td  align="center" style="font-size:16px" colspan="2" ><span class="style1"><u>BLOOD TRANFUSION OBSERVATION CHART</span></td>
		</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>		
     <tr>
	<td  align="left" valign="middle" bgcolor="#ffffff" colspan="2"
	><p>Name of patient <strong> <?php echo $patientname;?></strong> &nbsp; IP NO <strong><?php echo $visitcode;?></strong> &nbsp; ward <strong><?php echo $ward_name;?></strong>
<br><br>
Age <strong> <?php echo $age;?></strong> &nbsp; Sex <strong><?php echo $gender;?></strong>
<br><br>
Diagnosis _______________________________________________
<br><br>
Type of blood transfused:Whole blood  packed Red Cells  FFP  Platelets  Other
<br><br>
Blood unit donor number __________________________
<br><br>
Tranfusion started by: ___________________________&nbsp; counter checked by __________________________
<br><br> 
Time transfusion started:_________________________
<br><br>
Rate of transfusion: _____________________________ml/min
</p></td>
</tr>	  
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2"> <strong>OBSERVATIONS </strong></td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>

<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">
	   
	   <table width="520" border="1" cellspacing="0" cellpadding="3">
	     <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">HOURS OF OBSERVATION</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">BEFORE TRANFUSION</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">00 MINS</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">15 MINS</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">45 MINS</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">1HR 15MINS</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">1HR 45MINS</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">2HR 15MINS</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">2HR 45MINS</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">3HR 15MINS</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">3HR 45MINS</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">4HR 15MINS</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>

		 <tr>
				<td align="left" valign="middle" bgcolor="#ffffff" width="30%">4 HRS AFTER BLOOD TRANFUSION</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
				<td align="left" valign="middle" bgcolor="#ffffff" width="10%">&nbsp;</td>
		 </tr>
	   </table>
	
	</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>

<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">Time transfusion ended :__________________________________
</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">Amount  transfused: ______________________________________ml
</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle" bgcolor="#ffffff" colspan="2">
	<strong>SYMPTOMS OR SIGNS OF TRANSFUSION REACTION OBSERVED</strong>
	<p>
     <ul>
	  <li><strong>General:</strong> Fever,chills/Rigors,flushing,Nausea/vomiting</li>
	  <li><strong>Dermatological:</strong> Urticaria,other skin rash</li>
	  <li><strong>Cardiac/Respiratory:</strong> Chest pain,Dyspnoea,Hypotension,Tachycardia</li>
	  <li><strong>Renal:</strong> Haemoglobinuria,Oligulia,Anuria</li>
	  <li><strong>Haematological:</strong> Unexplained bleeding</li>
	  <li><strong>Others:</strong>__________________________________</li>
	  <li><strong>Intervention/drugs given :</strong>____________________________________________________</li>
	</ul>
	</p>
	
	</td>
</tr>


</table>




	</div>

<?php	
}
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();	
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
//$canvas->page_text(272, 814, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("AMA Form.pdf", array("Attachment" => 0)); 

?>